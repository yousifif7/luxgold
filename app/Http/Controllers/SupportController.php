<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SupportController extends Controller
{
    public function index()
    {
        $tickets = [];
        if (Auth::check()) {
            $tickets = SupportTicket::where('user_id', Auth::id())->latest()->get();
        }

        return view('support.index', compact('tickets'));
    }

    public function show($id)
    {
        $ticket = SupportTicket::findOrFail($id);

        // Ensure only owner or admin can view (assume admin middleware for admin routes)
        if ($ticket->user_id && Auth::check() && Auth::id() !== $ticket->user_id) {
            // not owner
            abort(403);
        }

        return view('support.show', compact('ticket'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        $ticket = SupportTicket::create([
            'user_id' => Auth::id(),
            'name' => $data['name'] ?? (Auth::user()->first_name ?? null .' '. Auth::user()->last_name ?? null),
            'email' => $data['email'] ?? (Auth::user()->email ?? null),
            'subject' => $data['subject'] ?? 'General Support',
            'message' => $data['message'],
            'status' => 'open',
        ]);

        // Optionally send admin notification email (skipped heavy mail logic)

        return back()->with('success', 'Your support request has been submitted. We will get back to you shortly.');
    }
}

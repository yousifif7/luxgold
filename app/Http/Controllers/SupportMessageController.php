<?php

namespace App\Http\Controllers;

use App\Models\SupportMessage;
use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportMessageController extends Controller
{
    // Return JSON messages for a ticket (used by JS)
    public function index($ticketId)
    {
        $ticket = SupportTicket::findOrFail($ticketId);

        // Only allow owner or admins (keep simple: owner or authenticated admin middleware at route level)
        $messages = SupportMessage::where('support_ticket_id', $ticket->id)
            ->with('user')
            ->orderBy('created_at')
            ->get();

        return response()->json($messages);
    }

    // Store a new message from a user
    public function store(Request $request)
    {
        $data = $request->validate([
            'support_ticket_id' => 'required|exists:support_tickets,id',
            'message' => 'required|string'
        ]);

        $ticket = SupportTicket::findOrFail($data['support_ticket_id']);

        $msg = SupportMessage::create([
            'support_ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'sender_name' => Auth::check() ? (Auth::user()->first_name ?? null .' '. Auth::user()->last_name ?? null) : $request->input('name'),
            'message' => $data['message']
        ]);

        return response()->json(['success' => true, 'message' => $msg]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function index(Request $request)
    {
        $query = SupportTicket::query();
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $tickets = $query->latest()->paginate(25)->withQueryString();

        return view('admin.support.index', compact('tickets'));
    }

    public function show($id)
    {
        $ticket = SupportTicket::findOrFail($id);
        return view('admin.support.show', compact('ticket'));
    }

    public function updateStatus(Request $request, $id)
    {
        $ticket = SupportTicket::findOrFail($id);
        $data = $request->validate([ 'status' => 'required|string' ]);
        $ticket->update(['status' => $data['status']]);
        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $ticket = SupportTicket::findOrFail($id);
        $ticket->delete();
        return response()->json(['success' => true]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportMessageController extends Controller
{
    public function index($ticketId)
    {
        $ticket = SupportTicket::findOrFail($ticketId);
        $messages = SupportMessage::where('support_ticket_id', $ticket->id)->with('user')->orderBy('created_at')->get();
        return response()->json($messages);
    }

    public function store(Request $request, $ticketId)
    {
        $ticket = SupportTicket::findOrFail($ticketId);
        $data = $request->validate(['message' => 'required|string']);

        $msg = SupportMessage::create([
            'support_ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'sender_name' => Auth::user()->name ?? 'Admin',
            'message' => $data['message']
        ]);

        return response()->json(['success' => true, 'message' => $msg]);
    }
}

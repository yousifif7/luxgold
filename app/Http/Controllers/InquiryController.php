<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Message;
use App\Mail\InquirySent;
use Illuminate\Http\Request;
use App\Mail\InquiryReceived;
use App\Models\Cleaner as Provider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
class InquiryController extends Controller
{
public function store(Request $request)
{
    // Check if user is logged in
    if (!auth()->check()) {
        return response()->json([
            'success' => false,
            'message' => 'Please login first to send an inquiry.'
        ], 401); // 401 Unauthorized
    }

    $request->validate([
        'cleaner_id' => 'required|exists:cleaners,id',
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:20',
        'message' => 'required|string|min:10',
        'newsletter' => 'nullable'
    ]);

    try {
        $provider = Provider::findOrFail($request->cleaner_id);
        
        $inquiry = Inquiry::create([
            'cleaner_id' => $request->cleaner_id,
            'user_id' => auth()->id(),
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
            'newsletter_opt_in' => $request->boolean('newsletter'),
            'status' => 'pending',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        Message::create([
            'inquiry_id' => $inquiry->id,
            'sender_type' => 'customer',
            'message' => $request->message
        ]);

        // Send email notifications
        $this->sendEmailNotifications($inquiry, $provider);

        return response()->json([
            'success' => true,
            'message' => 'Inquiry sent successfully!',
            'inquiry_id' => $inquiry->id
        ]);

    } catch (\Exception $e) {
        \Log::error('Inquiry creation failed: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'Failed to send inquiry. Please try again.'
        ], 500);
    }
}

    private function sendEmailNotifications(Inquiry $inquiry, Provider $provider)
    {
       /* try {
            // Send to provider
            if ($provider->email) {
                Mail::to($provider->email)->send(new InquiryReceived($inquiry, $provider));
            }

            // Send confirmation to user
            Mail::to($inquiry->email)->send(new InquirySent($inquiry, $provider));

        } catch (\Exception $e) {
            \Log::error('Email sending failed: ' . $e->getMessage());
            // Don't fail the inquiry if email fails
        }*/
        return 1;
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $cleaner = $user->cleaner ?? null;

        if (! $cleaner) {
            return redirect()->route('cleaner-profile')
                ->with('error', 'Please complete your cleaner profile to view inquiries.');
        }

        $inquiries = Inquiry::with('cleaner')
            ->where('cleaner_id', $cleaner->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $providers = Provider::where('status', 'active')->get();

        return view('panels.provider.messages', compact('inquiries','providers'));
    }

    public function getMessages($inquiryId)
    {
        $inquiry = Inquiry::findOrFail($inquiryId);
        
        $messages = $inquiry->messages()->get()->map(function($message) {
            return [
                'sender_type' => $message->sender_type,
                'message' => $message->message,
                'created_at' => $message->created_at->format('M d, Y H:i')
            ];
        });

        return response()->json(['messages' => $messages]);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'inquiry_id' => 'required|exists:inquiries,id',
            'message' => 'required|string'
        ]);

        $inquiry = Inquiry::findOrFail($request->inquiry_id);

        $user = Auth::user();
        // Determine sender type by whether the authenticated user owns the cleaner profile for this inquiry
        if ($user && $user->cleaner && $user->cleaner->id == $inquiry->cleaner_id) {
            $inquiry->status = 'contacted';
            $inquiry->save();
            $type = 'cleaner';
        } else {
            $type = 'customer';
        }

        Message::create([
            'inquiry_id' => $inquiry->id,
            'sender_type' =>$type,
            'message' => $request->message
        ]);

        // Update inquiry status

        return response()->json(['success' => true]);
    }

    public function show(Inquiry $inquiry)
    {
        $this->authorize('view', $inquiry);
        return view('inquiries.show', compact('inquiry'));
    }

    public function update(Request $request, Inquiry $inquiry)
    {
        
        $request->validate([
            'status' => 'required|in:pending,contacted,approved,closed'
        ]);

        $inquiry->update([
            'status' => $request->status,
            'responded_at' => now()
        ]);

        return response()->json(['success' => true]);
    }
}
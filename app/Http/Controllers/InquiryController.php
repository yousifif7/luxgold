<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\InquirySent;
use App\Mail\InquiryReceived;
use App\Models\Message;
use Auth;
class InquiryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'provider_id' => 'required|exists:providers,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string|min:10',
            'newsletter' => 'boolean'
        ]);

        try {
            $provider = Provider::findOrFail($request->provider_id);
            
            $inquiry = Inquiry::create([
                'provider_id' => $request->provider_id,
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
            'sender_type' => 'parent',
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
        $inquiries = Inquiry::with('provider')
            ->where('provider_id', auth()->user()->provider->id)
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

        if (Auth::user()->hasRole('provider')) {
            $inquiry->status='contacted';
            $inquiry->save();
            $type= 'provider';
        } else{
            $type= 'parent';
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
<?php
// app/Http/Controllers/EventRegistrationController.php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\SavedEvent;

class EventRegistrationController extends Controller
{

    public function save(Event $event)
{
    $userId = auth()->id();

    if (!$userId) {
        return response()->json([
            'saved' => false,
            'message' => 'Please login to save events'
        ], 401);
    }

    // Check if already saved
    $existing = SavedEvent::where('user_id', $userId)
        ->where('event_id', $event->id)
        ->first();

    // If exists → unsave
    if ($existing) {
        $existing->delete();

        return response()->json([
            'saved' => false,
            'message' => 'Event removed from saved list'
        ]);
    }

    // Otherwise → save
    $newSave = SavedEvent::create([
        'user_id' => $userId,
        'event_id' => $event->id,
        'notes' => null,
        'reminder_set' => false,
        'reminder_at' => null,
    ]);

    return response()->json([
        'saved' => true,
        'message' => 'Event saved successfully',
        'data' => $newSave
    ]);
}

public function destroy(SavedEvent $savedEvent)
{

    $savedEvent->delete();

    return back()->with('success', 'Saved event removed');
}


    public function store(Request $request)
    {

        if (!auth()->user()) {
             return response()->json([
                'success' => false,
                'message' => 'Kindly login first to complete event registration']);
        }
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'guests' => 'required|integer|min:0|max:10',
            'notes' => 'nullable|string|max:1000',
        ]);

        try {
            DB::beginTransaction();

            $event = Event::findOrFail($request->event_id);

            // Check if event is still available
            if ($event->hasEnded()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This event has already ended.'
                ], 422);
            }

            if ($event->isFull()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This event is already full.'
                ], 422);
            }

            // Check if user already registered
            $existingRegistration = EventRegistration::where('event_id', $event->id)
                ->where('email', $request->email)
                ->first();

            if ($existingRegistration) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have already registered for this event.'
                ], 422);
            }

            // Create registration
            $registration = EventRegistration::create([
                'event_id' => $event->id,
                'user_id' => auth()->id(),
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'guests' => $request->guests,
                'notes' => $request->notes,
                'status' => 'confirmed',
            ]);

            // Update event capacity
            $totalAttendees = $registration->total_attendees;
            $event->incrementCapacity($totalAttendees);

            DB::commit();

            // Send confirmation email
            
            return response()->json([
                'success' => true,
                'message' => 'Registration completed successfully!',
                'registration_code' => $registration->registration_code,
                'updated_capacity' => $event->current_capacity
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('Event registration failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Registration failed. Please try again.'
            ], 500);
        }
    }

    public function show($code)
    {
        $registration = EventRegistration::with(['event', 'user'])
            ->where('registration_code', $code)
            ->firstOrFail();

        return view('event-registration-detail', compact('registration'));
    }

    public function cancel(Request $request, $code)
    {
        $registration = EventRegistration::where('registration_code', $code)
            ->where('email', $request->email)
            ->firstOrFail();

        if ($registration->status === 'cancelled') {
            return response()->json([
                'success' => false,
                'message' => 'Registration is already cancelled.'
            ], 422);
        }

        try {
            DB::beginTransaction();

            $registration->update(['status' => 'cancelled']);
            
            // Update event capacity
            $event = $registration->event;
            $event->decrementCapacity($registration->total_attendees);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Registration cancelled successfully.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Cancellation failed. Please try again.'
            ], 500);
        }
    }

    public function userRegistrations()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $registrations = EventRegistration::with('event')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.event-registrations', compact('registrations'));
    }
}
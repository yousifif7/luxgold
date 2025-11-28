<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HireRequest;
use App\Models\Cleaner;
use App\Models\Category;
use App\Services\NotificationService;

class HireRequestController extends Controller
{
    protected $notifications;

    public function __construct(NotificationService $notifications)
    {
        $this->notifications = $notifications;
    }

    public function index()
    {
        $requests = HireRequest::orderBy('created_at', 'desc')->paginate(20);

        return view('admin.hire_requests.index', compact('requests'));
    }

    public function show($id)
    {
        $request = HireRequest::find($id);
        // Use HireRequest helper to get recommended cleaners
        $recommended = $request->recommendedCleaners(50);

        return view('admin.hire_requests.show', compact('request', 'recommended'));
    }

    /**
     * Send hire request to selected cleaners (create notifications)
     */
    public function send(Request $request, HireRequest $hireRequest)
    {
        $data = $request->validate([
            'cleaner_ids' => 'nullable|array',
            'cleaner_ids.*' => 'integer|exists:cleaners,id',
            'cleaners' => 'nullable|array',
            'cleaners.*' => 'integer|exists:cleaners,id'
        ]);

        // Accept either `cleaner_ids[]` or `cleaners[]` from the form
        $ids = $data['cleaner_ids'] ?? $data['cleaners'] ?? [];

        if (empty($ids)) {
            return redirect()->back()->withErrors(['cleaners' => 'Please select at least one cleaner to notify.']);
        }

        $cleaners = Cleaner::whereIn('id', $ids)->get();

        foreach ($cleaners as $cleaner) {
            $this->notifications->sendToProvider($cleaner, [
                'type' => 'info',
                'title' => 'New Hire Request',
                'message' => "A new hire request matches your services. View details.",
                'action_url' => route('admin.hire-requests.show', $hireRequest->id),
                'action_text' => 'View Request',
            ]);
        }

        // Persist the notified cleaner ids (store as array/json)
        $hireRequest->update([
            'cleaner_ids' => array_values($ids),
            'status' => 'sent',
            'responded_at' => now()
        ]);

        return redirect()->route('admin.hire-requests.show', $hireRequest->id)
            ->with('success', 'Hire request sent to selected cleaners.');
    }
}

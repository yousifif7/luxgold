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

    public function show(Request $request, $id)
    {
        $hireRequest = HireRequest::findOrFail($id);

        // Allow admin to choose how cleaners are listed via ?filter=city|all
        $filter = $request->query('filter');

        if ($filter === 'all') {
            // return all active cleaners
            $recommended = Cleaner::all();
        } elseif ($filter === 'city') {
            // match cleaners by the hire request city (case-insensitive)
            if ($hireRequest->city) {
                $city = trim($hireRequest->city);
                $recommended = Cleaner::whereRaw('lower(city) = ?', [mb_strtolower($city)])
                    ->where('status', 'active')
                    ->get();
            } else {
                $recommended = collect();
            }
        } else {
            // default behaviour: use the HireRequest helper (category + city preference)
            $recommended = $hireRequest->recommendedCleaners(50);
        }

        return view('admin.hire_requests.show', compact('hireRequest', 'recommended', 'filter'));
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
            'cleaners.*' => 'integer|exists:cleaners,id',
            'admin_message' => 'nullable|string'
        ]);

        // Accept either `cleaner_ids[]` or `cleaners[]` from the form
        $ids = $data['cleaner_ids'] ?? $data['cleaners'] ?? [];

        if (empty($ids)) {
            return redirect()->back()->withErrors(['cleaners' => 'Please select at least one cleaner to notify.']);
        }

        $cleaners = Cleaner::whereIn('id', $ids)->get();

        // Send notifications to the selected cleaners
        foreach ($cleaners as $cleaner) {
            $this->notifications->sendToProvider($cleaner, [
                'type' => 'info',
                'title' => 'New Hire Request',
                'message' => "A new hire request matches your services. View details.",
                'action_url' => route('admin.hire-requests.show', $hireRequest->id),
                'action_text' => 'View Request',
            ]);
        }

        // If admin selected at least one cleaner, set the primary assigned cleaner to the first selected id
        $primaryCleanerId = is_array($ids) && count($ids) ? intval($ids[0]) : null;

        // Determine new status: if a single cleaner is selected treat as assigned, otherwise mark as sent
        $newStatus = (count($ids) === 1) ? 'assigned' : 'sent';

        // Persist the notified cleaner ids and admin message and optionally the assigned cleaner
        $hireRequest->update([
            'cleaner_ids' => array_values($ids),
            'cleaner_id' => $primaryCleanerId,
            'status' => $newStatus,
            'admin_message' => $data['admin_message'] ?? null,
            'responded_at' => now()
        ]);

        return redirect()->route('admin.hire-requests.show', $hireRequest->id)
            ->with('success', 'Hire request processed and notifications sent to selected cleaners.');
    }
}

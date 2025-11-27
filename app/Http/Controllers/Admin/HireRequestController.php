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

    public function show(HireRequest $hireRequest)
    {
        // Try to find matching cleaners by category/cleaning_type
        $cleaningType = $hireRequest->cleaning_type;

        $recommended = Cleaner::query();

        if (is_numeric($cleaningType)) {
            $recommended->where('categories_id', (int)$cleaningType);
        } else {
            // Match by category name
            $cat = Category::where('name', $cleaningType)->first();
            if ($cat) {
                $recommended->where('categories_id', $cat->id);
            }
        }

        // Also match by zip_code when available
        if ($hireRequest->zip_code) {
            $recommended->where('zip_code', $hireRequest->zip_code);
        }

        $recommended = $recommended->where('status', 'active')->limit(50)->get();

        return view('admin.hire_requests.show', compact('hireRequest', 'recommended'));
    }

    /**
     * Send hire request to selected cleaners (create notifications)
     */
    public function send(Request $request, HireRequest $hireRequest)
    {
        $data = $request->validate([
            'cleaner_ids' => 'required|array',
            'cleaner_ids.*' => 'integer|exists:cleaners,id'
        ]);

        $cleaners = Cleaner::whereIn('id', $data['cleaner_ids'])->get();

        foreach ($cleaners as $cleaner) {
            $this->notifications->sendToProvider($cleaner, [
                'type' => 'info',
                'title' => 'New Hire Request',
                'message' => "A new hire request matches your services. View details.",
                'action_url' => route('admin.hire-requests.show', $hireRequest->id),
                'action_text' => 'View Request',
            ]);
        }

        $hireRequest->update(['status' => 'sent', 'responded_at' => now()]);

        return redirect()->route('admin.hire-requests.show', $hireRequest->id)
            ->with('success', 'Hire request sent to selected cleaners.');
    }
}

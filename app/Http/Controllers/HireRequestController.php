<?php

namespace App\Http\Controllers;

use App\Models\HireRequest;
use App\Models\Cleaner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HireRequestController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'cleaner_id' => 'nullable',
            'cleaner_ids' => 'nullable|array',
            'cleaner_ids.*' => 'integer|exists:cleaners,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:40',
            'cleaning_type' => 'nullable|string|max:100',
            'selected_items' => 'required',
            'frequency' => 'nullable|string|max:100',
            'scheduled_at' => 'nullable|date',
            'notes' => 'nullable|string',
            'zip_code' => 'nullable|string|max:20',
        ]);

        try {
            // Normalize cleaner_id values coming from the frontend (sometimes 'null' or 'undefined' strings)
            $cleaner = null;
            $rawCleanerId = $request->input('cleaner_id');
            if (is_string($rawCleanerId)) {
                $lower = strtolower(trim($rawCleanerId));
                if (in_array($lower, ['null', 'undefined', ''])) {
                    $rawCleanerId = null;
                }
            }

            if ($rawCleanerId) {
                // if numeric id supplied, attempt to resolve; otherwise ignore
                if (is_numeric($rawCleanerId)) {
                    $cleaner = Cleaner::find($rawCleanerId);
                    if (! $cleaner) {
                        // don't crash — log and continue with null cleaner
                        Log::warning('HireRequestController: cleaner_id provided but not found: ' . $rawCleanerId);
                    }
                } else {
                    Log::warning('HireRequestController: invalid cleaner_id provided: ' . json_encode($rawCleanerId));
                }
            }

            // ensure we pass a proper integer or null for cleaner_id
            $cleanerId = null;
            if (isset($rawCleanerId) && is_numeric($rawCleanerId)) {
                $cleanerId = (int) $rawCleanerId;
            }

            // prepare cleaner ids array (prefer explicit cleaner_ids if provided)
            $cleanerIds = $request->input('cleaner_ids') ?? [];
            if ($cleanerId && empty($cleanerIds)) {
                $cleanerIds = [$cleanerId];
            }

            $hire = HireRequest::create([
                'cleaner_id' => $cleanerId,
                'cleaner_ids' => $cleanerIds,
                'user_id' => Auth::id(),
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'cleaning_type' => $request->cleaning_type,
                'selected_items' => is_string($request->selected_items) ? json_decode($request->selected_items, true) : $request->selected_items,
                'frequency' => $request->frequency,
                'scheduled_at' => $request->scheduled_at ? date('Y-m-d H:i:s', strtotime($request->scheduled_at)) : null,
                'notes' => $request->notes,
                'status' => 'pending',
                'zip_code' => $request->zip_code,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Optional: notify provider via email or internal notification
            // dispatch a notification job here if desired

            return response()->json([
                'success' => true,
                'message' => 'Hire request created',
                'hire_request_id' => $hire->id,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to create hire request: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create hire request. Please try again.'
            ], 500);
        }
    }

    /**
     * List hire requests for the authenticated user (parent/customer)
     */
    public function index(Request $request)
    {
        $user = $request->user();
        if (! $user) {
            return redirect()->route('login');
        }

        $hireRequests = HireRequest::with('cleaner')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('customer.hire_requests.index', compact('hireRequests'));
    }

    /**
     * Show a single hire request
     */
    public function show(Request $request, HireRequest $hireRequest)
    {
        $user = $request->user();
        if (! $user || $hireRequest->user_id !== $user->id) {
            abort(403);
        }

        $hireRequest->load('cleaner');
        return view('customer.hire_requests.show', compact('hireRequest'));
    }
}

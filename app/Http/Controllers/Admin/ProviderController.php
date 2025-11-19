<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use App\Models\User;
use App\Models\Subscription;
use App\Models\Plan;
use App\Models\RecentlyViewed;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ProviderController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index(Request $request)
    {
        $query = Provider::with(['user', 'subscription.plan']);

        // Search filter
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('business_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // City filter
        if ($request->has('city') && $request->city != '') {
            $query->where('city', 'like', "%{$request->city}%");
        }

        // Sort
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'revenue':
                $query->orderBy('revenue', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $providers = $query->paginate(15);

        return view('admin.providers.index', compact('providers'));
    }

    public function create()
    {
        $plans = Plan::where('is_active', true)->get();
        return view('admin.providers.create', compact('plans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'required|string|max:20',
            'business_name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'physical_address' => 'required|string',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:20',
            'service_description' => 'required|string',
            'plan_id' => 'required|exists:plans,id',
            'password' => 'required|string|min:8|confirmed',
            'is_featured'=>'nullable|boolean',
        ]);

        DB::transaction(function () use ($validated) {
            // Create user
            $user = User::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'password' => bcrypt($validated['password']),
            ]);

            // Assign provider role
            $user->assignRole('provider');

            // Create provider
            $provider = Provider::create([
                'user_id' => $user->id,
                'name' => $validated['business_name'],
                'business_name' => $validated['business_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'category' => $validated['category'],
                'physical_address' => $validated['physical_address'],
                'city' => $validated['city'],
                'state' => $validated['state'],
                'is_featured' => $validated['is_featured'],
                'zip_code' => $validated['zip_code'],
                'service_description' => $validated['service_description'],
                'status' => 'approved',
            ]);

            // Create subscription
            $plan = Plan::find($validated['plan_id']);
            Subscription::create([
                'provider_id' => $provider->id,
                'plan_id' => $plan->id,
                'status' => 'active',
                'amount' => $plan->monthly_fee,
                'started_at' => now(),
                'renews_at' => now()->addMonth(),
                'is_active' => true,
            ]);

            // Send welcome notification
            $this->notificationService->sendToProvider($provider, [
                'type' => 'success',
                'title' => 'Welcome to Our Platform',
                'message' => 'Your provider account has been created and is now active.',
                'action_url' => route('provider-home'),
                'action_text' => 'Go to Dashboard'
            ]);
        });

        return handleResponse($request, 'Provider created successfully!', 'admin.providers.index');

    }

    public function show(Provider $provider)
    {
        $provider->load(['user', 'subscription.plan', 'inquiries', 'reviews']);
        
        return view('admin.provider-show', compact('provider'));
    }

    public function edit(Provider $provider)
    {
        $provider->load(['user', 'subscription']);
        $plans = Plan::where('is_active', true)->get();
        
        return view('admin.providers.edit', compact('provider', 'plans'));
    }

    public function update(Request $request, Provider $provider)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($provider->user_id)
            ],
            'phone' => 'required|string|max:20',
            'business_name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'physical_address' => 'required|string',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:20',
            'service_description' => 'required|string',
            'status' => 'required|in:pending,approved,rejected',
            'plan_id' => 'required|exists:plans,id',
            'is_featured'=>'nullable|boolean',
        ]);

        DB::transaction(function () use ($validated, $provider) {
            // Update user
            $provider->user->update([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
            ]);

            // Update provider
            $provider->update([
                'name' => $validated['business_name'],
                'business_name' => $validated['business_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'is_featured' => $validated['is_featured'],
                'category' => $validated['category'],
                'physical_address' => $validated['physical_address'],
                'city' => $validated['city'],
                'state' => $validated['state'],
                'zip_code' => $validated['zip_code'],
                'service_description' => $validated['service_description'],
                'status' => $validated['status'],
            ]);

            // Update subscription if plan changed
            $currentSubscription = $provider->subscription;
            if ($currentSubscription && $currentSubscription->plan_id != $validated['plan_id']) {
                $plan = Plan::find($validated['plan_id']);
                $currentSubscription->update([
                    'plan_id' => $plan->id,
                    'amount' => $plan->monthly_fee,
                ]);
            }

            // Send status update notification
            if ($validated['status'] === 'approved' && $provider->getOriginal('status') !== 'approved') {
                $this->notificationService->sendProfileApproved($provider);
            } elseif ($validated['status'] === 'rejected' && $provider->getOriginal('status') !== 'rejected') {
                $this->notificationService->sendProfileRejected($provider, 'Profile rejected by administrator.');
            }
        });

          return handleResponse($request, 'Provider created successfully!', 'admin.providers.index');

       
    }

    public function destroy(Provider $provider)
    {
        DB::transaction(function () use ($provider) {
            // Delete related records first
            $provider->inquiries()->delete();
            $provider->reviews()->delete();
            $provider->subscription()->delete();
            
            // Delete provider and user
            $user = $provider->user;
            $provider->delete();
            $user->delete();
        });

        return redirect()->route('admin.providers.index')
            ->with('success', 'Provider deleted successfully.');
    }

    public function updateStatus(Request $request, Provider $provider)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $oldStatus = $provider->status;
        $provider->update(['status' => $request->status]);

        // Send notification based on status change
        if ($request->status === 'approved' && $oldStatus !== 'approved') {
            $this->notificationService->sendProfileApproved($provider);
        } elseif ($request->status === 'rejected' && $oldStatus !== 'rejected') {
            $this->notificationService->sendProfileRejected($provider, $request->reason);
        }

        return response()->json([
            'success' => true,
            'message' => 'Provider status updated successfully.'
        ]);
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,approve,reject',
            'ids' => 'required|array',
            'ids.*' => 'exists:providers,id'
        ]);

        $providers = Provider::whereIn('id', $request->ids)->get();

        switch ($request->action) {
            case 'delete':
                foreach ($providers as $provider) {
                    $this->destroy($provider);
                }
                $message = 'Selected providers deleted successfully.';
                break;

            case 'approve':
                foreach ($providers as $provider) {
                    $provider->update(['status' => 'approved']);
                    $this->notificationService->sendProfileApproved($provider);
                }
                $message = 'Selected providers approved successfully.';
                break;

            case 'reject':
                foreach ($providers as $provider) {
                    $provider->update(['status' => 'rejected']);
                    $this->notificationService->sendProfileRejected($provider, 'Bulk rejection by administrator.');
                }
                $message = 'Selected providers rejected successfully.';
                break;
        }

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    public function getStats()
    {
        $stats = [
            'total' => Provider::count(),
            'pending' => Provider::where('status', 'pending')->count(),
            'approved' => Provider::where('status', 'approved')->count(),
            'rejected' => Provider::where('status', 'rejected')->count(),
            'cities' => Provider::distinct('city')->pluck('city')->toArray(),
        ];

        return response()->json($stats);
    }
}
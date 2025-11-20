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
use App\Models\Category;
use App\Models\CareType;
use App\Models\AgesServed;
use App\Models\DiversityBadge;
use App\Models\ProgramsOffered;
use App\Models\SpecialFeatures;
use App\Models\ServicesOfferd;
use Illuminate\Support\Facades\Storage;
use App\Models\City;
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
        $categories=Category::whereNull('parent_id')->get();
        $sub_categories=Category::whereNotNull('parent_id')->get();
        $ages_served=AgesServed::get();
        $programs_offerd=ProgramsOffered::get();
        $services_offerd=ServicesOfferd::get();
        $div_bages=DiversityBadge::get();
        $special_pages=SpecialFeatures::get();
        $cities=City::get();
        return view('admin.providers.create', compact('plans','categories','sub_categories','ages_served','programs_offerd','div_bages','plans','special_pages','services_offerd','cities'));
    }

 public function store(Request $request)
{
    $validated = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email',
        'phone' => 'required|string|max:20',
        'business_name' => 'required|string|max:255',
        'categories_id' => 'required|exists:categories,id',
        'sub_categories' => 'nullable|array',
        'sub_categories.*' => 'exists:categories,id',
        'services_offerd' => 'nullable|array',
        'services_offerd.*' => 'exists:services_offerd,id',
        'service_description' => 'nullable|string',
        'ages_served_id' => 'nullable|exists:ages_served,id',
        'programs_offered_id' => 'nullable|exists:programs_offered,id',
        'price_amount' => 'nullable|numeric',
        'pricing_description' => 'nullable|string',
        'available_days' => 'nullable|array',
        'available_days.*' => 'string',
        'start_time' => 'nullable|date_format:H:i',
        'end_time' => 'nullable|date_format:H:i',
        'availability_notes' => 'nullable|string',
        'license_number' => 'nullable|string',
        'years_operation' => 'nullable|integer',
        'insurance_coverage' => 'nullable|string',
        'diversity_badges' => 'nullable|array',
        'diversity_badges.*' => 'exists:diversity_badges,id',
        'special_features' => 'nullable|array',
        'special_features.*' => 'exists:special_features,id',
        'website' => 'nullable|url',
        'facebook' => 'nullable|url',
        'instagram' => 'nullable|url',
        'avatar' => 'nullable|image|max:2048',
        'facility_photos_paths.*' => 'nullable|image|max:2048',
        'license_docs_paths.*' => 'nullable|file|max:4096',
        'city' => 'required|string|max:255',
        'state' => 'required|string|max:255',
        'zip_code' => 'required|string|max:20',
        'plan_id' => 'required|exists:plans,id',
        'status' => 'nullable|string|in:pending,approved,rejected',
        'is_featured' => 'nullable|boolean',
        'password' => 'required|string|min:8|confirmed',
    ]);

    DB::transaction(function () use ($validated, $request) {
        // Create User
        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => bcrypt($validated['password']),
        ]);

        $user->assignRole('provider');

        // Handle file uploads
        $avatarPath = $request->file('avatar') ? $request->file('avatar')->store('avatars', 'public') : null;

        $facilityPhotos = [];
        if ($request->hasFile('facility_photos_paths')) {
            foreach ($request->file('facility_photos_paths') as $photo) {
                $facilityPhotos[] = $photo->store('facility_photos', 'public');
            }
        }

        $licenseDocs = [];
        if ($request->hasFile('license_docs_paths')) {
            foreach ($request->file('license_docs_paths') as $doc) {
                $licenseDocs[] = $doc->store('license_docs', 'public');
            }
        }

        // Create Provider
        $provider = Provider::create([
            'user_id' => $user->id,
            'name' => $validated['business_name'],
            'business_name' => $validated['business_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'categories_id' => $validated['categories_id'],
            'sub_categories' => $validated['sub_categories'] ?? [],
            'services_offerd' => $validated['services_offerd'] ?? [],
            'service_description' => $validated['service_description'] ?? null,
            'ages_served_id' => $validated['ages_served_id'] ?? null,
            'programs_offered_id' => $validated['programs_offered_id'] ?? null,
            'price_amount' => $validated['price_amount'] ?? null,
            'pricing_description' => $validated['pricing_description'] ?? null,
            'available_days' => $validated['available_days'] ?? [],
            'start_time' => $validated['start_time'] ?? null,
            'end_time' => $validated['end_time'] ?? null,
            'availability_notes' => $validated['availability_notes'] ?? null,
            'license_number' => $validated['license_number'] ?? null,
            'years_operation' => $validated['years_operation'] ?? null,
            'insurance_coverage' => $validated['insurance_coverage'] ?? null,
            'diversity_badges' => $validated['diversity_badges'] ?? [],
            'special_features' => $validated['special_features'] ?? [],
            'website' => $validated['website'] ?? null,
            'facebook' => $validated['facebook'] ?? null,
            'instagram' => $validated['instagram'] ?? null,
            'avatar' => $avatarPath,
            'facility_photos_paths' => $facilityPhotos,
            'license_docs_paths' => $licenseDocs,
            'physical_address' => $validated['physical_address']??'',
            'city' => $validated['city'],
            'state' => $validated['state'],
            'zip_code' => $validated['zip_code'],
            'status' => $validated['status'] ?? 'pending',
            'is_featured' => $validated['is_featured'] ?? 0,
        ]);

        // Create Subscription
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

        // Send notification
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
        
        return view('admin.providers.show', compact('provider'));
    }

    public function edit(Provider $provider)
    {
        $provider->load(['user', 'subscription']);
        $plans = Plan::where('is_active', true)->get();
        $plans = Plan::where('is_active', true)->get();
        $categories=Category::whereNull('parent_id')->get();
        $sub_categories=Category::whereNotNull('parent_id')->get();
        $ages_served=AgesServed::get();
        $programs_offerd=ProgramsOffered::get();
        $services_offerd=ServicesOfferd::get();
        $div_bages=DiversityBadge::get();
        $special_pages=SpecialFeatures::get();
        $cities=City::get();
        
        return view('admin.providers.edit', compact('provider', 'plans','categories','sub_categories','ages_served','programs_offerd','div_bages','plans','special_pages','services_offerd','cities'));
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
        'categories_id' => 'required|exists:categories,id',
        'sub_categories' => 'nullable|array',
        'sub_categories.*' => 'exists:categories,id',
        'services_offerd' => 'nullable|array',
        'services_offerd.*' => 'exists:services_offerds,id',
        'service_description' => 'nullable|string',
        'ages_served_id' => 'nullable|exists:ages_served,id',
        'programs_offered_id' => 'nullable|exists:programs_offered,id',
        'price_amount' => 'nullable|numeric',
        'pricing_description' => 'nullable|string',
        'available_days' => 'nullable|array',
        'available_days.*' => 'string',
        'start_time' => 'nullable|date_format:H:i',
        'end_time' => 'nullable|date_format:H:i',
        'availability_notes' => 'nullable|string',
        'license_number' => 'nullable|string',
        'years_operation' => 'nullable|integer',
        'insurance_coverage' => 'nullable|string',
        'diversity_badges' => 'nullable|array',
        'diversity_badges.*' => 'exists:diversity_badges,id',
        'special_features' => 'nullable|array',
        'special_features.*' => 'exists:special_features,id',
        'website' => 'nullable|url',
        'facebook' => 'nullable|url',
        'instagram' => 'nullable|url',
        'avatar' => 'nullable|image|max:2048',
        'facility_photos_paths.*' => 'nullable|image|max:2048',
        'license_docs_paths.*' => 'nullable|file|max:4096',
        'city' => 'required|string|max:255',
        'state' => 'required|string|max:255',
        'zip_code' => 'required|string|max:20',
        'plan_id' => 'required|exists:plans,id',
        'status' => 'required|in:pending,approved,rejected',
        'is_featured' => 'nullable|boolean',
    ]);

    DB::transaction(function () use ($validated, $provider, $request) {
        // Update User
        $provider->user->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
        ]);

        // Handle file uploads
        if ($request->hasFile('avatar')) {
            if ($provider->avatar) {
                Storage::disk('public')->delete($provider->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        if ($request->hasFile('facility_photos_paths')) {
            $existingPhotos = $provider->facility_photos_paths ?? [];
            foreach ($request->file('facility_photos_paths') as $photo) {
                $existingPhotos[] = $photo->store('facility_photos', 'public');
            }
            $validated['facility_photos_paths'] = $existingPhotos;
        }

        if ($request->hasFile('license_docs_paths')) {
            $existingDocs = $provider->license_docs_paths ?? [];
            foreach ($request->file('license_docs_paths') as $doc) {
                $existingDocs[] = $doc->store('license_docs', 'public');
            }
            $validated['license_docs_paths'] = $existingDocs;
        }

        // Update Provider
        $provider->update([
            'name' => $validated['business_name'],
            'business_name' => $validated['business_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'categories_id' => $validated['categories_id'],
            'sub_categories' => $validated['sub_categories'] ?? [],
            'services_offerd' => $validated['services_offerd'] ?? [],
            'service_description' => $validated['service_description'] ?? null,
            'ages_served_id' => $validated['ages_served_id'] ?? null,
            'programs_offered_id' => $validated['programs_offered_id'] ?? null,
            'price_amount' => $validated['price_amount'] ?? null,
            'pricing_description' => $validated['pricing_description'] ?? null,
            'available_days' => $validated['available_days'] ?? [],
            'start_time' => $validated['start_time'] ?? null,
            'end_time' => $validated['end_time'] ?? null,
            'availability_notes' => $validated['availability_notes'] ?? null,
            'license_number' => $validated['license_number'] ?? null,
            'years_operation' => $validated['years_operation'] ?? null,
            'insurance_coverage' => $validated['insurance_coverage'] ?? null,
            'diversity_badges' => $validated['diversity_badges'] ?? [],
            'special_features' => $validated['special_features'] ?? [],
            'website' => $validated['website'] ?? null,
            'facebook' => $validated['facebook'] ?? null,
            'instagram' => $validated['instagram'] ?? null,
            'avatar' => $validated['avatar'] ?? $provider->avatar,
            'facility_photos_paths' => $validated['facility_photos_paths'] ?? $provider->facility_photos_paths,
            'license_docs_paths' => $validated['license_docs_paths'] ?? $provider->license_docs_paths,
            'physical_address' => $validated['physical_address'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'zip_code' => $validated['zip_code'],
            'status' => $validated['status'],
            'is_featured' => $validated['is_featured'] ?? 0,
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

        // Send notifications for status change
        if ($validated['status'] === 'approved' && $provider->getOriginal('status') !== 'approved') {
            $this->notificationService->sendProfileApproved($provider);
        } elseif ($validated['status'] === 'rejected' && $provider->getOriginal('status') !== 'rejected') {
            $this->notificationService->sendProfileRejected($provider, 'Profile rejected by administrator.');
        }
    });

    return handleResponse($request, 'Provider updated successfully!', 'admin.providers.index');
}

    public function destroy(Provider $provider)
    {
        DB::transaction(function () use ($provider) {
            // Delete related records first
            
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
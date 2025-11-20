<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class ProfileController extends Controller
{
    /**
     * Display the parent's profile.
     */

    public function edit()
    {
        $user = Auth::user();
        $provider = $user->provider;
        
        return view('panels.provider.profile', compact('user', 'provider'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:20',
        ]);

        $user->update($validated);

        return redirect()->route('provider-profile')
            ->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // If request expects JSON (AJAX from parent profile), return JSON; otherwise redirect back.
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Password updated successfully.'
            ]);
        }

        return back()->with('success', 'Password updated successfully.');
    }

    public function show()
    {
        $user = Auth::user();
        return view('panels.parent.profile', compact('user'));
    }

    /**
     * Update personal information.
     */
  public function updatePersonalInfo(Request $request)
{
    $user = Auth::user();

    $validated = $request->validate([
        'first_name' => ['required', 'string', 'max:255'],
        'last_name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        'phone' => ['nullable', 'string', 'max:20'],
        'profile_picture' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // 2MB max
    ]);

    try {
      // Handle profile picture upload
if ($request->hasFile('profile_picture')) {
    // Delete old profile picture if exists
    if ($user->profile_picture) {
        $oldImagePath = public_path($user->profile_picture);
        if (file_exists($oldImagePath)) {
            unlink($oldImagePath);
        }
    }
    
    // Store new profile picture in public folder
    $image = $request->file('profile_picture');
    $imageName = time() . '_' . $image->getClientOriginalName();
    $imagePath = 'profile-pictures/' . $imageName;
    
    // Move file to public directory
    $image->move(public_path('profile-pictures'), $imageName);
    $validated['profile_picture'] = $imagePath;
}
        $user->update($validated);
        
        return response()->json([
            'success' => true,
            'message' => 'Personal information updated successfully!',
            'user' => $user
        ]);
    } catch (\Exception $e) {
        \Log::error('Profile update error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Failed to update personal information.'
        ], 500);
    }
}
    /**
     * Update location preferences.
     */
    public function updateLocationPreferences(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'zip_code' => ['required', 'string', 'max:10'],
            'search_radius' => ['required', 'integer', 'min:1', 'max:100'],
        ]);

        try {
            $user->update($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Location preferences updated successfully!',
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update location preferences.'
            ], 500);
        }
    }

    /**
     * Update notification preferences.
     */
    public function updateNotificationPreferences(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'email_notifications' => ['boolean'],
            'provider_responses' => ['boolean'],
            'new_provider_suggestions' => ['boolean'],
            'event_reminders' => ['boolean'],
            'marketing_communications' => ['boolean'],
        ]);

        try {
            $user->notification_preferences = $validated;
            $user->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Notification preferences updated successfully!',
                'preferences' => $user->notification_preferences
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update notification preferences.'
            ], 500);
        }
    }

    /**
     * Get current user data for the profile form.
     */
    public function getProfileData()
    {
        $user = Auth::user();
        
        return response()->json([
            'user' => [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'phone' => $user->phone,
                'city' => $user->city,
                'state' => $user->state,
                'zip_code' => $user->zip_code,
                'search_radius' => $user->search_radius,
                'notification_preferences' => $user->notification_preferences,
            ]
        ]);
    }
}
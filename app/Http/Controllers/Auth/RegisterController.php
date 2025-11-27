<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Cleaner;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Default redirect path (fallback)
     * We'll override this dynamically in redirectTo() based on role.
     */
    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Determine where to redirect users after registration based on their role.
     * RegistersUsers will call this if present.
     */
    protected function redirectTo()
    {
        $user = auth()->user();
        if (!$user) {
            return $this->redirectTo;
        }

        if ($user->hasRole('cleaner')) {
            return '/cleaner/dashboard';
        }

        // Customer/parent role
        if ($user->hasRole('customer')) {
            return '/customer/dashboard';
        }

        // Default fallback
        return $this->redirectTo;
    }

    /**
     * Validate registration data
     */
    protected function validator(array $data)
    {
        $rules = [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'in:customer,cleaner'], // ensure valid role
        ];

        // Additional validation for providers
        if ($data['role'] === 'cleaner') {
            $rules = array_merge($rules, [
                'business_name' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'string', 'max:20'],
                'category' => ['required', 'string', 'max:255'],
                'pricing_plan' => ['required', 'string', 'max:255'],
                'years_experience' => ['required', 'string'],
                'address' => ['required', 'string'],
                'city' => ['required', 'string'],
                'state' => ['required', 'string'],
                'zip_code' => ['required', 'string', 'regex:/^[A-Za-z0-9]{3}\s?[A-Za-z0-9]{4}$/'],
                'service_description' => ['required', 'string'],
            ]);
        }

        return Validator::make($data, $rules);
    }

    /**
     * Create new user and provider (if applicable)
     */
    protected function create(array $data)
    {
        // Create the user
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'email'      => $data['email'],
            'password'   => Hash::make($data['password']),
        ]);

        // Assign role via Spatie
        $user->assignRole($data['role']);

        // If provider, store additional provider info
        if (strtolower($data['role']) === 'cleaner') {
            Cleaner::create([
                'name'=> $data['first_name'],
                'user_id'            => $user->id,
                'business_name'      => $data['business_name'],
                'phone'              => $data['phone'],
                'categories_id'           => $data['category'],
                'plans_id'           => $data['pricing_plan'],
                'years_experience'   => $data['years_experience'],
                'address'            => $data['address'],
                'city'               => $data['city'],
                'state'              => $data['state'],
                'zip_code'           => strtoupper(preg_replace('/\s+/', ' ', trim($data['zip_code']))),
                'service_description'=> $data['service_description'],
            ]);
        }

        return $user;
    }
}

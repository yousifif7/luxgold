<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceListingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Change to your authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            // Step 1: Basic Info (solo cleaner)
            'profile_name' => ['required','string','max:255','regex:/^\S+\s+\S+/'],
            'phone_number' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'physical_address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:2',
            'zip_code' => 'required|string|size:5',

            // Step 2: Services
            'sub_categories' => 'required|array|min:1',
            'sub_categories.*' => 'integer',
            'service_description' => 'nullable|string|max:2000',

            // Step 3: Pricing & Schedule
            'price_amount' => 'required|numeric|min:0',
            'pricing_description' => 'nullable|string|max:1000',
            'available_days' => 'nullable|array',
            'available_days.*' => 'string|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'availability_notes' => 'nullable|string|max:500',

            // Step 4: Credentials (removed)
            'special_features' => 'nullable|array',
            'special_features.*' => 'string|in:stem,arts,special,outdoor,language,sports,organic,technology',
            'website' => 'nullable|url|max:500',
            'facebook' => 'nullable|url|max:500',
            'instagram' => 'nullable|url|max:500',

            // Step 5: Media
            'logo' => 'nullable|file|image|mimes:jpeg,png,jpg,gif|max:10240', // 10MB
            'facility_photos' => 'nullable|array',
            'facility_photos.*' => 'file|image|mimes:jpeg,png,jpg,gif|max:10240',
            'license_docs' => 'nullable|array',
            'license_docs.*' => 'file|mimes:jpeg,png,jpg,gif,pdf|max:10240',
        ];

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'profile_name.required' => 'Profile name is required and must include first and last name',
            'profile_name.regex' => 'Please provide both first and last name for the cleaner',
            'phone_number.required' => 'Phone number is required',
            'email.required' => 'Email address is required',
            'email.email' => 'Please enter a valid email address',
            'physical_address.required' => 'Physical address is required',
            'city.required' => 'City is required',
            'zip_code.required' => 'ZIP code is required',
            'zip_code.size' => 'ZIP code must be 5 digits',
            'sub_categories.required' => 'Please select at least one service category',
            'sub_categories.min' => 'Please select at least one service category',
            'price_amount.required' => 'Price amount is required',
            'price_amount.numeric' => 'Price must be a valid number',
            'price_amount.min' => 'Price cannot be negative',
            'end_time.after' => 'End time must be after start time',
            'logo.file' => 'Logo must be a valid file',
            'logo.image' => 'Logo must be an image file',
            'logo.max' => 'Logo file size cannot exceed 10MB',
            'facility_photos.*.image' => 'Facility photos must be image files',
            'facility_photos.*.max' => 'Each facility photo cannot exceed 10MB',
            'license_docs.*.mimes' => 'License documents must be images or PDF files',
            'license_docs.*.max' => 'Each license document cannot exceed 10MB',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'profile_name' => 'profile name',
            'phone_number' => 'phone number',
            'email' => 'email address',
            'physical_address' => 'physical address',
            'zip_code' => 'ZIP code',
            'sub_categories' => 'service categories',
            'price_amount' => 'price amount',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Ensure arrays are properly formatted even if empty
        $this->merge([
            'sub_categories' => $this->sub_categories ?? [],
            'available_days' => $this->available_days ?? [],
            'special_features' => $this->special_features ?? [],
        ]);
    }
}
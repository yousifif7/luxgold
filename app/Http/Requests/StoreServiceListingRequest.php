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
            // Step 1: Basic Info
            'business_name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'role_title' => 'nullable|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'physical_address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:2',
            'zip_code' => 'required|string|size:5',

            // Step 2: Services
            'service_categories' => 'required|array|min:1',
            'service_categories.*' => 'string|in:childcare,tutoring,healthcare,recreation,therapy,transportation',
            'service_description' => 'nullable|string|max:2000',

            // Step 3: Pricing & Schedule
            'price_amount' => 'required|numeric|min:0',
            'pricing_description' => 'nullable|string|max:1000',
            'available_days' => 'nullable|array',
            'available_days.*' => 'string|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'availability_notes' => 'nullable|string|max:500',

            // Step 4: Credentials
            'license_number' => 'nullable|string|max:255',
            'years_operation' => 'nullable|string|max:255',
            'insurance_coverage' => 'nullable|string|max:500',
            'diversity_badges' => 'nullable|array',
            'diversity_badges.*' => 'string|in:women,minority,veteran,family,lgbtq',
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
            'business_name.required' => 'Business name is required',
            'contact_person.required' => 'Contact person name is required',
            'phone_number.required' => 'Phone number is required',
            'email.required' => 'Email address is required',
            'email.email' => 'Please enter a valid email address',
            'physical_address.required' => 'Physical address is required',
            'city.required' => 'City is required',
            'zip_code.required' => 'ZIP code is required',
            'zip_code.size' => 'ZIP code must be 5 digits',
            'service_categories.required' => 'Please select at least one service category',
            'service_categories.min' => 'Please select at least one service category',
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
            'business_name' => 'business name',
            'contact_person' => 'contact person',
            'phone_number' => 'phone number',
            'email' => 'email address',
            'physical_address' => 'physical address',
            'zip_code' => 'ZIP code',
            'service_categories' => 'service categories',
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
            'service_categories' => $this->service_categories ?? [],
            'available_days' => $this->available_days ?? [],
            'diversity_badges' => $this->diversity_badges ?? [],
            'special_features' => $this->special_features ?? [],
        ]);
    }
}
<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceListingRequest;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceListingController extends Controller
{
    /**
     * Show the service listing form
     */
    public function index()
    {
        $serviceListing = Provider::where('user_id', auth()->id())->first();

         return view('service_listing.edit', compact('serviceListing'));
    }

    public function update(Request $request, $id)
    {
        // Authorization check
      /*  if ($serviceListing->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }*/

        $provider=Provider::where('id',$id)->first();

        try {
            \DB::beginTransaction();

            // Handle file removals first
            $this->handleFileRemovals($request, $provider);

            // Handle new file uploads
            $logoPath = $this->handleLogoUpload($request, $provider);
            $facilityPhotosPaths = $this->handleFacilityPhotosUpload($request, $provider);
            $licenseDocsPaths = $this->handleLicenseDocsUpload($request, $provider);

            // Update service listing
            $provider->update([
                'business_name' => $request->business_name,
                'contact_person' => $request->contact_person,
                'role_title' => $request->role_title,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'physical_address' => $request->physical_address,
                'city' => $request->city,
                'state' => $request->state,
                'zip_code' => $request->zip_code,
                
                'service_categories' => $request->service_categories,
                'service_description' => $request->service_description,
                
                'pricing_type' => $request->pricing_type,
                'price_amount' => $request->price_amount,
                'pricing_description' => $request->pricing_description,
                'available_days' => $request->available_days,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'availability_notes' => $request->availability_notes,
                
                'license_number' => $request->license_number,
                'years_operation' => $request->years_operation,
                'insurance_coverage' => $request->insurance_coverage,
                'diversity_badges' => $request->diversity_badges,
                'special_features' => $request->special_features,
                'website' => $request->website,
                'facebook' => $request->facebook,
                'instagram' => $request->instagram,
                
                // Only update file paths if new files were uploaded
                'logo_path' => $logoPath ?: $provider->logo_path,
                'facility_photos_paths' => !empty($facilityPhotosPaths) ? $facilityPhotosPaths : $provider->facility_photos_paths,
                'license_docs_paths' => !empty($licenseDocsPaths) ? $licenseDocsPaths : $provider->license_docs_paths,
                
                // Reset status to pending if significant changes were made
                'status' => $this->shouldResetStatus($request, $provider) ? 'pending' : $provider->status,
            ]);

            \DB::commit();

                    return handleResponse($request, 'Provider profile has been updated successfully!', 'provider/listing/profile');

        } catch (\Exception $e) {
            \DB::rollBack();
            
            \Log::error('Service listing update failed: ' . $e->getMessage());
            
                 return handleResponse($request,  $e->getMessage(), 'provider/listing/profile');

        }
    }

    /**
     * Handle file removals
     */
   private function handleLogoUpload($request, $serviceListing = null)
{
    if ($request->hasFile('logo')) {
        // Delete old logo if exists
        if ($serviceListing && $serviceListing->logo_path && file_exists(public_path($serviceListing->logo_path))) {
            unlink(public_path($serviceListing->logo_path));
        }

        $file = $request->file('logo');
        $filename = 'logo_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $path = 'service-listings/logos';

        // Move file to /public/service-listings/logos/
        $file->move(public_path($path), $filename);

        return "$path/$filename"; // return relative path for DB
    }

    return null;
}

private function handleFacilityPhotosUpload($request, $serviceListing = null)
{
    $paths = [];

    if ($request->hasFile('facility_photos')) {
        foreach ($request->file('facility_photos') as $photo) {
            $filename = 'facility_' . Str::random(10) . '.' . $photo->getClientOriginalExtension();
            $path = 'service-listings/facility-photos';

            $photo->move(public_path($path), $filename);
            $paths[] = "$path/$filename";
        }
    }

    // Merge existing photos if editing
    if ($serviceListing && !empty($serviceListing->facility_photos_paths)) {
        $paths = array_merge(json_decode($serviceListing->facility_photos_paths), $paths);
    }

    return $paths;
}

private function handleLicenseDocsUpload($request, $serviceListing = null)
{
    $paths = [];

    if ($request->hasFile('license_docs')) {
        foreach ($request->file('license_docs') as $doc) {
            $filename = 'license_' . Str::random(10) . '.' . $doc->getClientOriginalExtension();
            $path = 'service-listings/license-docs';

            $doc->move(public_path($path), $filename);
            $paths[] = "$path/$filename";
        }
    }

    // Merge existing docs if editing
    if ($serviceListing && !empty($serviceListing->license_docs_paths)) {
        $paths = array_merge($serviceListing->license_docs_paths, $paths);
    }

    return $paths;
}

private function handleFileRemovals(Request $request, $provider)
{
    // Handle logo removal
    if ($request->has('remove_logo') && $serviceListing->logo_path) {
        if (file_exists(public_path($serviceListing->logo_path))) {
            unlink(public_path($serviceListing->logo_path));
        }
        $serviceListing->update(['logo_path' => null]);
    }

    // Handle facility photos removal
    if ($request->has('remove_facility_photos')) {
        $photosToRemove = $request->remove_facility_photos;
        $currentPhotos = $serviceListing->facility_photos_paths ?? [];

        $updatedPhotos = array_filter($currentPhotos, fn($photo) => !in_array($photo, $photosToRemove));

        foreach ($photosToRemove as $photoToRemove) {
            if (file_exists(public_path($photoToRemove))) {
                unlink(public_path($photoToRemove));
            }
        }

        $serviceListing->update(['facility_photos_paths' => array_values($updatedPhotos)]);
    }

    // Handle license docs removal
    if ($request->has('remove_license_docs')) {
        $docsToRemove = $request->remove_license_docs;
        $currentDocs = $serviceListing->license_docs_paths ?? [];

        $updatedDocs = array_filter($currentDocs, fn($doc) => !in_array($doc, $docsToRemove));

        foreach ($docsToRemove as $docToRemove) {
            if (file_exists(public_path($docToRemove))) {
                unlink(public_path($docToRemove));
            }
        }

        $serviceListing->update(['license_docs_paths' => array_values($updatedDocs)]);
    }
}


    /**
     * Determine if status should be reset to pending
     */
    private function shouldResetStatus(Request $request, $provider)
    {
        // Define fields that would require re-approval
        $criticalFields = [
            'business_name',
            'service_categories',
            'license_number',
            'physical_address'
        ];

        foreach ($criticalFields as $field) {
            if ($request->$field != $provider->$field) {
                return true;
            }
        }

        return false;
    }

    /**
     * Display the specified service listing
     */
    public function show(ServiceListing $serviceListing)
    {
        return view('service-listings.show', compact('serviceListing'));
    }

    /**
     * Delete service listing
     */
    public function destroy(ServiceListing $serviceListing)
    {
        // Authorization check
        if ($serviceListing->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        try {
            // Delete associated files
            if ($serviceListing->logo_path) {
                Storage::disk('public')->delete($serviceListing->logo_path);
            }
            
            if ($serviceListing->facility_photos_paths) {
                foreach ($serviceListing->facility_photos_paths as $photo) {
                    Storage::disk('public')->delete($photo);
                }
            }
            
            if ($serviceListing->license_docs_paths) {
                foreach ($serviceListing->license_docs_paths as $doc) {
                    Storage::disk('public')->delete($doc);
                }
            }

            $serviceListing->delete();

            return redirect()->route('provider-listings')
                ->with('success', 'Service listing deleted successfully.');

        } catch (\Exception $e) {
            \Log::error('Service listing deletion failed: ' . $e->getMessage());
            
            return back()->with('error', 'Failed to delete service listing. Please try again.');
        }
    }
}
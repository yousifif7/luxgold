<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroContent;
use App\Models\Category;
use App\Models\Provider;
use App\Models\City;
use App\Models\Testimonial;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    public function index()
    {
        $heroContents = HeroContent::all();
        $categories = Category::all();
        $featuredProviders = Provider::all();
        $cities = City::all();
        $testimonials = Testimonial::all();
        $resources = Resource::all();
        
        $heroContent = $heroContents->first(); // Assuming only one hero content
        
        return view('admin.content-management', compact(
            'heroContents',
            'heroContent',
            'categories',
            'featuredProviders',
            'cities',
            'testimonials',
            'resources'
        ));
    }
    
    // Hero Content Methods
    public function updateHero(Request $request)
    {
        $request->validate([
            'title_part1' => 'required|string|max:255',
            'title_part2' => 'required|string|max:255',
            'description' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'cta_text' => 'nullable|string|max:100',
            'cta_url' => 'nullable|url',
            'hero_alt_text' => 'nullable|string|max:255',
            'providers_count' => 'required|integer',
            'rating' => 'required|numeric',
            'support_text' => 'required|string|max:255',
            'status'=>'nullable|string'
        ]);

        $heroContent = HeroContent::firstOrNew([]);
        // Only fill allowed fields to avoid mass-assignment issues
        $heroContent->fill($request->only([
            'title_part1',
            'title_part2',
            'description',
            'meta_title',
            'meta_description',
            'cta_text',
            'cta_url',
            'hero_alt_text',
            'providers_count',
            'rating',
            'support_text',
            'status'
        ]));
        $heroContent->save();
        
        return redirect()->back()->with('success', 'Hero content updated successfully!');
    }
    
    
    // City Methods
    public function storeCity(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'providers_count' => 'required|integer',
            'families_count' => 'required|integer',
            'icon_url' => 'required|url',
            'status' => 'string',
            'is_coming_soon' => 'string',
        ]);
        
        City::create($request->all());
        
        return redirect()->back()->with('success', 'City added successfully!');
    }
    
    public function updateCity(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'providers_count' => 'required|integer',
            'families_count' => 'required|integer',
            'icon_url' => 'required|url',
            'status' => 'string',
            'is_coming_soon' => 'string',
        ]);
        
        $city = City::findOrFail($id);
        $city->update($request->all());
        
        return redirect()->back()->with('success', 'City updated successfully!');
    }
    
    public function destroyCity($id)
    {
        $city = City::findOrFail($id);
        $city->delete();
        
        return redirect()->back()->with('success', 'City deleted successfully!');
    }
    
    // Testimonial Methods
    public function storeTestimonial(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string',
            'avatar_url' => 'required|url',
            'status' => 'string',
        ]);
        
        Testimonial::create($request->all());
        
        return redirect()->back()->with('success', 'Testimonial added successfully!');
    }
    
    public function updateTestimonial(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string',
            'avatar_url' => 'required|url',
            'status' => 'string',
        ]);
        
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->update($request->all());
        
        return redirect()->back()->with('success', 'Testimonial updated successfully!');
    }
    
    public function destroyTestimonial($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->delete();
        
        return redirect()->back()->with('success', 'Testimonial deleted successfully!');
    }
    
    // Resource Methods
    public function storeResource(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:255',
            'image_url' => 'required|url',
            'content' => 'required|string',
            'read_time' => 'nullable|string|max:50',
            'status' => 'string',
        ]);
        
        Resource::create($request->all());
        
        return redirect()->back()->with('success', 'Resource added successfully!');
    }
    
    public function updateResource(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:255',
            'image_url' => 'required|url',
            'content' => 'required|string',
            'read_time' => 'nullable|string|max:50',
            'status' => 'string',
        ]);
        
        $resource = Resource::findOrFail($id);
        $resource->update($request->all());
        
        return redirect()->back()->with('success', 'Resource updated successfully!');
    }
    
    public function destroyResource($id)
    {
        $resource = Resource::findOrFail($id);
        $resource->delete();
        
        return redirect()->back()->with('success', 'Resource deleted successfully!');
    }
    
    // Bulk Actions
    public function bulkAction(Request $request)
    {
        $action = $request->input('action');
        $ids = $request->input('ids');
        
        if (!$ids) {
            return redirect()->back()->with('error', 'Please select items to perform action.');
        }
        
        switch ($action) {
            case 'delete':
                $this->bulkDelete($ids, $request->input('type'));
                break;
            case 'activate':
                $this->bulkStatusUpdate($ids, $request->input('type'), true);
                break;
            case 'deactivate':
                $this->bulkStatusUpdate($ids, $request->input('type'), false);
                break;
        }
        
        return redirect()->back()->with('success', 'Bulk action completed successfully!');
    }
    
    private function bulkDelete($ids, $type)
    {
        switch ($type) {
            case 'categories':
                Category::whereIn('id', $ids)->delete();
                break;
            case 'providers':
                FeaturedProvider::whereIn('id', $ids)->delete();
                break;
            case 'cities':
                City::whereIn('id', $ids)->delete();
                break;
            case 'testimonials':
                Testimonial::whereIn('id', $ids)->delete();
                break;
            case 'resources':
                Resource::whereIn('id', $ids)->delete();
                break;
        }
    }
    
    private function bulkStatusUpdate($ids, $type, $status)
    {
        switch ($type) {
            case 'categories':
                Category::whereIn('id', $ids)->update(['status' => $status]);
                break;
            case 'providers':
                FeaturedProvider::whereIn('id', $ids)->update(['status' => $status]);
                break;
            case 'cities':
                City::whereIn('id', $ids)->update(['status' => $status]);
                break;
            case 'testimonials':
                Testimonial::whereIn('id', $ids)->update(['status' => $status]);
                break;
            case 'resources':
                Resource::whereIn('id', $ids)->update(['status' => $status]);
                break;
        }
    }
    
    // Image Upload Methods
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'type' => 'required|string|in:category,provider,testimonial,resource,city'
        ]);
        
        $path = $request->file('image')->store('public/content/' . $request->type);
        $url = Storage::url($path);
        
        return response()->json([
            'success' => true,
            'url' => $url,
            'message' => 'Image uploaded successfully!'
        ]);
    }
    
    // Toggle Status Methods
    public function toggleStatus(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|string|in:category,provider,city,testimonial,resource',
            'status' => 'required|string'
        ]);
        
        $model = $this->getModel($request->type);
        $item = $model::findOrFail($id);
        $item->update(['status' => $request->status]);
        
        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully!'
        ]);
    }
    
    private function getModel($type)
    {
        switch ($type) {
            case 'category': return Category::class;
            case 'provider': return FeaturedProvider::class;
            case 'city': return City::class;
            case 'testimonial': return Testimonial::class;
            case 'resource': return Resource::class;
            default: throw new \Exception('Invalid model type');
        }
    }
    
    // Search and Filter Methods
    public function searchContent(Request $request)
    {
        $type = $request->input('type');
        $search = $request->input('search');
        $status = $request->input('status');
        
        $query = $this->getModel($type)::query();
        
        if ($search) {
            $query->where(function($q) use ($search, $type) {
                switch ($type) {
                    case 'category':
                        $q->where('title', 'like', "%{$search}%")
                          ->orWhere('subtitle', 'like', "%{$search}%");
                        break;
                    case 'provider':
                        $q->where('name', 'like', "%{$search}%")
                          ->orWhere('location', 'like', "%{$search}%");
                        break;
                    case 'city':
                        $q->where('name', 'like', "%{$search}%");
                        break;
                    case 'testimonial':
                        $q->where('name', 'like', "%{$search}%")
                          ->orWhere('content', 'like', "%{$search}%");
                        break;
                    case 'resource':
                        $q->where('title', 'like', "%{$search}%")
                          ->orWhere('category', 'like', "%{$search}%");
                        break;
                }
            });
        }
        
        if ($status !== null) {
            $query->where('status', $status);
        }
        
        $results = $query->get();
        
        return response()->json($results);
    }
}
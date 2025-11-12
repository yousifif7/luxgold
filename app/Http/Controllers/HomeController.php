<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Provider;
use App\Models\HeroContent;
use App\Models\City;
use App\Models\Resource;
use App\Models\Testimonial;
use App\Models\Category;
use App\Models\RecentlyViewed;
use App\Models\Event;
use Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
   

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $heroContent = HeroContent::active()->first();
        $cities = City::active()->ordered()->get();
        $resources = Resource::active()->ordered()->take(3)->get();
        $testimonials = Testimonial::active()->ordered()->take(3)->get();
        $categories=Category::get();
        $providers=Provider::where('is_featured',1)->get();
        $latestEvents=Event::where('start_date', '>=', now())->where('status','active')->get();

        return view('website.index', compact(
            'heroContent',
            'cities',
            'resources',
            'testimonials',
            'categories',
            'providers',
            'latestEvents'
        ));
    }

     public function compare(){


        $compareList = Session::get('compare_list', []);
        $providers = Provider::whereIn('id', $compareList)->get();
        

        return view('website.compare-page',compact('providers'));
    }
public function findProvider(Request $request)
{
    $query = Provider::query();
    
    // Search by business name or description
    if ($request->has('search') && $request->search) {
        $searchTerm = $request->search;
        $query->where(function($q) use ($searchTerm) {
            $q->where('business_name', 'like', "%{$searchTerm}%")
              ->orWhere('service_description', 'like', "%{$searchTerm}%")
              ->orWhere('contact_person', 'like', "%{$searchTerm}%");
        });
    }
    
    // Filter by location
    if ($request->has('location') && $request->location) {
        $location = $request->location;
        $query->where(function($q) use ($location) {
            $q->where('physical_address', 'like', "%{$location}%")
              ->orWhere('city', 'like', "%{$location}%")
              ->orWhere('zip_code', 'like', "%{$location}%");
        });
    }
    
    // Filter by category
    if ($request->has('category') && $request->category != 'all') {
        $query->where('category', $request->category);
    }
    
    // Filter by price range
    if ($request->has('price_min') && $request->price_min) {
        $query->where('price_amount', '>=', $request->price_min);
    }
    if ($request->has('price_max') && $request->price_max) {
        $query->where('price_amount', '<=', $request->price_max);
    }
    
    // Filter by rating
    if ($request->has('rating') && $request->rating) {
        $query->where('rating', '>=', $request->rating);
    }
    
    // Get results
    $providers = $query->get();
    
    return view('website.find-provider', compact('providers'));
}
    public function providerDetail($id){


     if (Auth::user()) {
RecentlyViewed::updateOrCreate(
    [
        'user_id' => Auth::id(),
        'provider_id' => $id,
    ],
    [] // optional: fields to update if record exists
);
     }


 $provider=Provider::where('id',$id)->first();
        return view('website.provider-detail',compact('provider'));
    }

     public function logout(Request $request)
    {
        Auth::logout();

        // Redirect to the client login form
        return redirect('/'); // Change this as needed
    }
}

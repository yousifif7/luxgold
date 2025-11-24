<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Event;
use App\Models\Review;
use App\Models\CareType;
use App\Models\Category;
use App\Models\Resource;
use App\Models\Promotion;
use App\Models\AgesServed;
use App\Models\HeroContent;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Models\DiversityBadge;
use App\Models\RecentlyViewed;
use App\Models\ServicesOfferd;
use App\Models\ProgramsOffered;
use App\Models\SpecialFeatures;
use App\Models\Cleaner as Provider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Builder; // Correct one for Eloquent

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
        $avgRating=Review::where('status','approved')->avg('rating');
        $totalProvider=Provider::count();

        return view('website.index', compact(
            'heroContent',
            'cities',
            'resources',
            'testimonials',
            'categories',
            'providers',
            'latestEvents',
            'avgRating',
            'totalProvider'
        ));
    }

    public function resourceDetails($slug){

        $resource=Resource::where('slug',$slug)->first();

        return view('website.resource',compact('resource'));
    }

     public function compare(){


        $compareList = Session::get('compare_list', []);
        $providers = Provider::whereIn('id', $compareList)->get();
        

        return view('website.compare-page',compact('providers'));
    }

    public function findEvents(Request $request){
$query = Event::query();

        // Search by business name or description
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                    ->orWhere('subtitle', 'like', "%{$searchTerm}%")
                    ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        // Filter by location
        
     
        if ($request->has('age_group') && $request->age_group != 'all') {
            $query->where('ages_served_id', $request->age_group);
        }

        if ($request->filled('price_min') && $request->filled('price_max')) {
    $query->whereBetween('cost', [(float)$request->price_min, (float)$request->price_max]);
}


        
        // Get results
        $events = $query->paginate(12);
        $categories=Category::whereNull('customer_id')->get();
        $ages_served=AgesServed::get();
        $programs_offerd=ProgramsOffered::get();
        $services_offerd=ServicesOfferd::get();

        return view('website.find-event', compact('events','categories','ages_served','services_offerd'));

    }
    public function findProvider(Request $request)
    {
        $query = Provider::query();

        // Search by business name or description
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('business_name', 'like', "%{$searchTerm}%")
                    ->orWhere('service_description', 'like', "%{$searchTerm}%")
                    ->orWhere('contact_person', 'like', "%{$searchTerm}%");
            });
        }

        // Filter by location
        
        // Filter by category
        if ($request->has('category') && $request->category != 'all') {
            $query->where('categories_id', $request->category);
        }
        if ($request->has('age_group') && $request->age_group != 'all') {
            $query->where('ages_served_id', $request->age_group);
        }

        if ($request->filled('price_min') && $request->filled('price_max')) {
    $query->whereBetween('price_amount', [(float)$request->price_min, (float)$request->price_max]);
}


        if ($request->has('rating') && $request->rating) {
    $query->whereHas('approvedReviews', function (Builder $q) use ($request) {
        $q->selectRaw('avg(rating) as avg_rating')
          ->havingRaw('avg(rating) >= ?', [$request->rating]);
    });
}
        // Get results
        $providers = $query->paginate(12);
        $categories=Category::whereNull('customer_id')->get();
        $ages_served=AgesServed::get();
        $programs_offerd=ProgramsOffered::get();
        $services_offerd=ServicesOfferd::get();

        return view('website.find-provider', compact('providers','categories','ages_served','services_offerd'));
    }

    public function eventDetail($id){
        
        $event = Event::where('id', $id)->first();

return view('website.event-detail', compact('event'));
    }
    public function providerDetail($id)
    {

        $provider = Provider::where('id', $id)->first();

        if (Auth::user()) {

        $recent_view = RecentlyViewed::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'cleaner_id' => $provider->id,
            ],
            [
                'viewed_at' => now(),
            ]
        );
        
            // code...
        }

        return view('website.provider-detail', compact('provider'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        // Redirect to the client login form
        return redirect('/'); // Change this as needed
    }
}

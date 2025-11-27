<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\Cleaner as Provider;
use App\Models\Review;
use App\Models\Inquiry;
use App\Models\SavedCleaner;
use App\Models\Event;
use App\Models\RecentlyViewed;
use Auth;
use App\Models\Message;
use App\Models\SavedEvent;
use App\Models\HireRequest;

class ParentPanelController extends Controller
{

public function index()
{
    $user = Auth::user();
    $weekStart = now()->startOfWeek();
    $weekEnd = now()->endOfWeek();

    // Activity Statistics for this week
    $activityStats = [
        'providers_viewed' => RecentlyViewed::where('user_id', $user->id)
            ->whereBetween('viewed_at', [$weekStart, $weekEnd])
            ->count(),
        
        'messages_received' => Message::whereHas('inquiry', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->where('sender_type', 'cleaner')
            ->whereBetween('created_at', [$weekStart, $weekEnd])
            ->count(),
        
        'inquiries_sent' => Inquiry::where('user_id', $user->id)
            ->whereBetween('created_at', [$weekStart, $weekEnd])
            ->count(),
        
        'avg_rating_given' => Review::where('user_id', $user->id)
            ->whereBetween('created_at', [$weekStart, $weekEnd])
            ->avg('rating') ?? 0,
    ];

    // Overall Statistics
    $stats = [
        'saved_providers' => SavedCleaner::where('user_id', $user->id)->count(),
        'upcoming_events' => Event::where('start_date', '>=', now())
            ->whereHas('savedByUsers', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->count(),
        'reviews_given' => Review::where('user_id', $user->id)->count(),
            'hire_requests' => HireRequest::where('user_id', $user->id)->count(),
    ];

    // Recently Viewed Providers (last 7 days)
    $recentlyViewed = RecentlyViewed::with(['cleaner' => function($query) {
        $query->withAvg('reviews', 'rating');
    }])
    ->where('user_id', $user->id)
    ->where('viewed_at', '>=', now()->subDays(7))
    ->orderBy('viewed_at', 'desc')
    ->take(5)
    ->get();

    // Provider Recommendations - Personalized Carousels
    $recommendations = $this->getProviderRecommendations($user);

    // Upcoming Events (next 30 days)
    $upcomingEvents = Event::with('cleaner')
        ->where('start_date', '>=', now())
        ->where('start_date', '<=', now()->addDays(30))
        ->whereHas('savedByUsers', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->orderBy('start_date')
        ->take(3)
        ->get();

    return view('panels.parent.index', compact(
        'activityStats',
        'stats',
        'recentlyViewed',
        'recommendations',
        'upcomingEvents',
        'user'
    ));
}

private function getProviderRecommendations($user)
{
    // Top Rated in Your City
    $topRated = Provider::withAvg('reviews', 'rating')
        ->withCount('reviews')
        ->where('city', $user->city)
        ->where('status', 'approved')
        ->orderBy('reviews_avg_rating', 'desc')
        ->orderBy('reviews_count', 'desc')
        ->take(6)
        ->get();

    // Newly Joined Providers
    $newProviders = Provider::withAvg('reviews', 'rating')
        ->where('status', 'approved')
        ->orderBy('created_at', 'desc')
        ->take(6)
        ->get();

    // Based on What Parents Near You Viewed
    $trendingNearby = Provider::withAvg('reviews', 'rating')
        ->where('city', $user->city)
        ->where('status', 'approved')
        ->whereHas('recentlyViewed', function($query) {
            $query->where('viewed_at', '>=', now()->subDays(7));
        })
        ->withCount(['recentlyViewed as recent_views' => function($query) {
            $query->where('viewed_at', '>=', now()->subDays(7));
        }])
        ->orderBy('recent_views', 'desc')
        ->take(6)
        ->get();

    return [
        'top_rated' => $topRated,
        'new_providers' => $newProviders,
        'trending_nearby' => $trendingNearby,
    ];
}

    private function getSuggestedProviders($user)
    {
        // Get user's saved provider types for recommendations
        $savedProviderTypes = SavedCleaner::with('cleaner')
            ->where('user_id', $user->id)
            ->get()
            ->pluck('provider.service_categories')
            ->unique()
            ->toArray();

        // Get providers with similar types and good ratings
        $suggestedProviders = Provider::withAvg('reviews', 'rating')
            ->when(!empty($savedProviderTypes), function($query) use ($savedProviderTypes) {
                return $query->whereIn('service_categories', $savedProviderTypes);
            })
            ->where('status', 'active')
            ->whereNotIn('id', function($query) use ($user) {
                $query->select('cleaner_id')
                    ->from('saved_cleaners')
                    ->where('user_id', $user->id);
            })
            ->orderBy('reviews_avg_rating', 'desc')
            ->take(5)
            ->get();

        // Calculate match percentage based on various factors
        $suggestedProviders->each(function($provider) use ($user, $savedProviderTypes) {
            $matchScore = 0;
            $maxScore = 4; // Total factors considered

            // Type match (if user has saved similar types)
            if (in_array($provider->type, $savedProviderTypes)) {
                $matchScore++;
            }

            // Rating match (if rating is high)
            if ($provider->reviews_avg_rating >= 4.5) {
                $matchScore++;
            }

            // Location match (simplified - in real app, use actual distance calculation)
            if ($this->calculateLocationMatch($user, $provider)) {
                $matchScore++;
            }

            // Availability match (simplified)
            if ($provider->has_availability) {
                $matchScore++;
            }

            $provider->match_percentage = round(($matchScore / $maxScore) * 100);
        });

        return $suggestedProviders;
    }

    private function calculateLocationMatch($user, $provider)
    {
        // In a real application, you would calculate actual distance
        // between user's location and provider's location
        // This is a simplified version
        return true; // Assume match for demo
    }

    

    public function compare(){


        $compareList = Session::get('compare_list', []);
        $providers = Provider::whereIn('id', $compareList)->get();

        return view('panels.parent.compare',compact('providers'));
    }

     

    public function reviews(){

         $reviews = Review::where('user_id', auth()->id())->get();

        return view('panels.parent.reviews',compact('reviews'));
    }

    public function messages(){
       

        $inquiries = Inquiry::with(['cleaner', 'messages'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        $providers = Provider::where('status', 'active')->get();

        return view('panels.parent.messages',compact('inquiries','cleaners'));

    }

    public function saveItems(){

         $savedProviders = SavedCleaner::with(['cleaner' => function($query) {
            $query->withAvg('reviews', 'rating');
        }])
        ->where('user_id', Auth::id())
        ->latest()
        ->get();

        $savedEvents =  SavedEvent::with(['event.provider'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

          return view('panels.parent.saved-items',compact('savedProviders','savedEvents'));
    }
}

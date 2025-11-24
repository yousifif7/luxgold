<?php
// app/Http/Controllers/ReviewController.php
namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Cleaner as Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $id)
    {

        $provider=Provider::where('id',$id)->first();

         $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000'
        ]);

        // Check if user already reviewed this provider
        $existingReview = Review::where('user_id', Auth::id())
            ->where('cleaner_id', $provider->id)
            ->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'You have already reviewed this cleaner.');
        }

        Review::create([
            'user_id' => Auth::id(),
            'cleaner_id' => $provider->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => 'pending' // Admin approval required
        ]);

        // Update provider rating
        $provider->updateRating();

        return redirect()->back()->with('success', 'Review submitted successfully! It will be visible after approval.');
    }

    public function update(Request $request, Provider $provider, Review $review)
    {
        $this->authorize('update', $review);

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000'
        ]);

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => false // Require re-approval after edit
        ]);

        // Update provider rating
        $provider->updateRating();

        return redirect()->back()->with('success', 'Review updated successfully! It will be visible after approval.');
    }

    public function destroy(Provider $provider, Review $review)
    {
        $this->authorize('delete', $review);

        $review->delete();

        // Update provider rating
        $provider->updateRating();

        return redirect()->back()->with('success', 'Review deleted successfully.');
    }
}
<?php
// app/Http/Controllers/FollowedProviderController.php
namespace App\Http\Controllers;

use App\Models\FollowedProvider;
use App\Models\Cleaner as Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowedProviderController extends Controller
{
 public function store(Provider $provider)
{
    if (!Auth::check()) {
        return response()->json([
            'followed' => false,
            'message' => 'You must be logged in to follow a cleaner.'
        ], 401);
    }

    $existingFollow = FollowedProvider::where('user_id', Auth::id())
        ->where('cleaner_id', $provider->id)
        ->first();

    if ($existingFollow) {
        $existingFollow->delete();
        return response()->json(['followed' => false, 'message' => 'Cleaner unfollowed']);
    }

    FollowedProvider::create([
        'user_id' => Auth::id(),
        'provider_id' => $provider->id
    ]);

    return response()->json(['followed' => true, 'message' => 'Cleaner followed successfully']);
}

}
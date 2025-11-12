<?php
// app/Http/Controllers/FollowedProviderController.php
namespace App\Http\Controllers;

use App\Models\FollowedProvider;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowedProviderController extends Controller
{
    public function store(Provider $provider)
    {
        $existingFollow = FollowedProvider::where('user_id', Auth::id())
            ->where('provider_id', $provider->id)
            ->first();

        if ($existingFollow) {
            $existingFollow->delete();
            return response()->json(['followed' => false, 'message' => 'Provider unfollowed']);
        }

        FollowedProvider::create([
            'user_id' => Auth::id(),
            'provider_id' => $provider->id
        ]);

        return response()->json(['followed' => true, 'message' => 'Provider followed successfully']);
    }
}
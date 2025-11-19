<?php
// app/Http/Controllers/SavedProviderController.php
namespace App\Http\Controllers;

use App\Models\SavedProvider;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedProviderController extends Controller
{
 public function store(Provider $provider)
{
    // Check if user is logged in
    if (!Auth::check()) {
        return response()->json([
            'saved' => false,
            'message' => 'Kindly login first'
        ], 401);
    }

    $existingSave = SavedProvider::where('user_id', Auth::id())
        ->where('provider_id', $provider->id)
        ->first();

    if ($existingSave) {
        $existingSave->delete();
        return response()->json([
            'saved' => false,
            'message' => 'Provider removed from saved list'
        ]);
    }

    SavedProvider::create([
        'user_id' => Auth::id(),
        'provider_id' => $provider->id
    ]);

    return response()->json([
        'saved' => true,
        'message' => 'Provider saved successfully'
    ]);
}
    public function index()
    {
        $savedProviders = Auth::user()->savedProviders()->with('provider')->get();
        return view('website.saved-providers', compact('savedProviders'));
    }
}
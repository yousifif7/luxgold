<?php
// app/Http/Controllers/SavedProviderController.php
namespace App\Http\Controllers;

use App\Models\SavedCleaner;
use App\Models\Cleaner as Provider;
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

    $existingSave = SavedCleaner::where('user_id', Auth::id())
        ->where('cleaner_id', $provider->id)
        ->first();

    if ($existingSave) {
        $existingSave->delete();
        return response()->json([
            'saved' => false,
            'message' => 'Cleaner removed from saved list'
        ]);
    }

    SavedCleaner::create([
        'user_id' => Auth::id(),
        'cleaner_id' => $provider->id
    ]);

    return response()->json([
        'saved' => true,
        'message' => 'Cleaner saved successfully'
    ]);
}
    public function index()
    {
        $savedProviders = Auth::user()->SavedCleaner()->with('cleaner')->get();
        return view('website.saved-providers', compact('savedProviders'));
    }
}
<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HireRequest;
use App\Models\Cleaner;

class HireRequestController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        if (! $user) {
            return redirect()->route('login');
        }

        $provider = Cleaner::where('user_id', $user->id)->first();
        if (! $provider) {
            abort(403, 'Provider profile not found');
        }

        $id = $provider->id;

        $hireRequests = HireRequest::where(function ($q) use ($id) {
            $q->whereJsonContains('cleaner_ids', $id)
              ->orWhere('cleaner_id', $id);
        })->orderBy('created_at', 'desc')->paginate(12);

        return view('panels.provider.hire_requests.index', compact('hireRequests'));
    }
}

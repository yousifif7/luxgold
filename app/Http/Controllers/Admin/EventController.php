<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Storage;
use App\Models\User;
use App\Models\Category;
class EventController extends Controller
{public function index()
{
    $user = Auth::user();

    // ✅ Check if user has 'provider' role (trim any accidental space)
    if ($user->hasRole('provider')) {
        // Only show events belonging to this provider
        $contents = Event::where('provider_id', $user->id)
            ->orderBy('start_date', 'desc')
            ->get();

        $total = Event::where('provider_id', $user->id)->count();
        $pending = Event::where('provider_id', $user->id)
            ->where('status', 'pending')
            ->count();
        $thisWeek = Event::where('provider_id', $user->id)
            ->whereBetween('start_date', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();

        $eventsWithCapacity = Event::where('provider_id', $user->id)
            ->whereNotNull('max_capacity')
            ->where('max_capacity', '>', 0)
            ->get();
    } else {
        // Admins or others see all events
        $contents = Event::orderBy('start_date', 'desc')->get();
        $total = Event::count();
        $pending = Event::where('status', 'pending')->count();
        $thisWeek = Event::whereBetween('start_date', [now()->startOfWeek(), now()->endOfWeek()])->count();

        $eventsWithCapacity = Event::whereNotNull('max_capacity')
            ->where('max_capacity', '>', 0)
            ->get();
    }

    // ✅ Calculate average attendance percentage
    if ($eventsWithCapacity->count() === 0) {
        $avgAttendance = '—';
    } else {
        $avgFraction = $eventsWithCapacity->map(function ($e) {
            $current = (float) ($e->current_capacity ?? 0);
            $max = (float) $e->max_capacity;
            return $max > 0 ? ($current / $max) : 0;
        })->avg();
        $avgAttendance = number_format($avgFraction * 100, 1) . '%';
    }

    $stats = [
        'total' => $total,
        'pending' => $pending,
        'this_week' => $thisWeek,
        'avg_attendance' => $avgAttendance,
    ];

    return view('admin.events.index', compact('contents', 'stats'));
}


 public function store(Request $request)
{
    $validationRules = [
        'title' => 'required|string|max:255',
        'subtitle' => 'nullable|string|max:255',
        'provider_name' => 'nullable|string|max:255',
        'category' => 'nullable|string|max:255',
        'location' => 'nullable|string|max:255',
        'city' => 'nullable|string|max:255',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'cost' => 'nullable|numeric|min:0',
        'status' => 'nullable|in:active,pending,cancelled,published',
        'max_capacity' => 'nullable|integer|min:0',
        'current_capacity' => 'nullable|integer|min:0',
        'age_group' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'author' => 'nullable|string|max:255',
    ];

    if (Auth::check()) {
        if (Auth::user()->hasRole('admin')) {
            // Admin must provide provider_id
            $validationRules['provider_id'] = 'required|exists:users,id';
        }
    }

    $validated = $request->validate($validationRules);

    // Handle image upload
    if ($request->hasFile('image_url')) {
        $image = $request->file('image_url');
        $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $path = 'events';
        $image->move(public_path($path), $filename);
        $validated['image_url'] = asset($path . '/' . $filename);
    }

    // Set provider_id automatically for provider users
    if (Auth::check() && Auth::user()->hasRole('provider')) {
            $validated['provider_id'] = Auth::id();
                $validated['provider_name'] = Auth::user()->first_name;
            
    }

    // Create event
    $event = Event::create(array_merge(
        $validated,
        ['published_at' => $validated['start_date'] ?? now()]
    ));

    return handleResponse($request, 'Event created successfully!', 'admin.events.index');
}


    public function create(){

        $providers=User::role('provider')->get();
        $categories=Category::get();

        return view('admin.events.create',compact('providers','categories'));
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
         $providers=User::role('provider')->get();
         $categories=Category::get();
        // Determine request context
  
            return view('admin.events.edit', compact('event','providers','categories'));
        }

    public function update(Request $request, $id)
{
    $event = Event::findOrFail($id);

    
    $validationRules = [
        'title' => 'required|string|max:255',
        'subtitle' => 'nullable|string|max:255',
        'provider_name' => 'nullable|string|max:255',
        'category' => 'nullable|string|max:255',
        'location' => 'nullable|string|max:255',
        'city' => 'nullable|string|max:255',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'cost' => 'nullable|numeric|min:0',
        'status' => 'nullable|in:active,pending,cancelled,published',
        'max_capacity' => 'nullable|integer|min:0',
        'current_capacity' => 'nullable|integer|min:0',
        'age_group' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'author' => 'nullable|string|max:255',
    ];

    if (Auth::check()) {
        if (Auth::user()->hasRole('admin')) {
            // Admin must provide provider_id
            $validationRules['provider_id'] = 'required|exists:users,id';
        }
    }

        $validated = $request->validate($validationRules);


    // ✅ Handle image upload (replace old one if new uploaded)
 if ($request->hasFile('image_url')) {
    $image = $request->file('image_url');
    $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
    $path = 'events';

    // ✅ Delete old image if exists
    if ($event->image_url) {
        // Extract relative path from full URL
        $oldPath = str_replace(asset(''), '', $event->image_url);
        if (file_exists(public_path($oldPath))) {
            unlink(public_path($oldPath));
        }
    }

    // ✅ Move file to /public/events/
    $image->move(public_path($path), $filename);

    // ✅ Save new image URL (accessible via public path)
    $validated['image_url'] = asset($path . '/' . $filename);
}
    if (Auth::check() && Auth::user()->hasRole('provider')) {
            $validated['provider_id'] = Auth::id();
                $validated['provider_name'] = Auth::user()->first_name;
            
    }


    // ✅ Update record
    $event->update($validated);

    // ✅ AJAX or admin JSON response
    if ($request->ajax() || $request->is('admin/*')) {
        return response()->json([
            'success' => true,
            'message' => 'Event updated successfully!',
            'event' => $event,
        ]);
    }

    // ✅ Redirect for non-AJAX
    return handleResponse($request, 'Event updated successfully!', 'admin.events.index');
}

    public function destroy($id)
    {
        $e = Event::findOrFail($id);
        // if provider user, ensure ownership
        if (Auth::check() && Auth::user()->role === 'provider') {
            $provider = Provider::where('user_id', Auth::id())->first();
            if ($provider && $e->provider_id !== $provider->id) abort(403);
        }

        $e->delete();

        if (request()->is('admin/*') || request()->is('admin')) {
            return redirect()->route('vendor.admin.events.index')->with('success', 'Event deleted successfully');
        }
        if (request()->is('provider/*') || request()->is('provider')) {
            return redirect()->route('provider.events.index')->with('success', 'Event deleted successfully');
        }

        return redirect()->route('events.index')->with('success', 'Event deleted successfully');
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);


        return view('admin.events.show', compact('event'));
    }

    public function approve($id)
    {
        $event = Event::findOrFail($id);
        $event->update(['status' => 'active']);
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => true, 'status' => $event->status, 'event' => $event, 'message' => 'Event approved']);
        }
        if (request()->is('admin/*') || request()->is('admin')) {
            return redirect()->route('vendor.admin.events.index')->with('success', 'Event approved successfully');
        }

        return back()->with('success', 'Event approved successfully');
    }

    public function reject($id)
    {
        $event = Event::findOrFail($id);
        $event->update(['status' => 'cancelled']);
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => true, 'status' => $event->status, 'event' => $event, 'message' => 'Event rejected']);
        }
        if (request()->is('admin/*') || request()->is('admin')) {
            return redirect()->route('vendor.admin.events.index')->with('success', 'Event rejected successfully');
        }

        return back()->with('success', 'Event rejected successfully');
    }
}

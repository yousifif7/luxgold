<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promotion;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::orderBy('sort_order')->get();
        return view('admin.promotions.index', compact('promotions'));
    }

    public function create()
    {
        return view('admin.promotions.create');
    }

    public function store(Request $request)
    {
        // Normalize checkbox inputs so validation treats them as boolean/ints
        $request->merge([
            'is_active' => $request->has('is_active') ? 1 : 0,
            'show_on_homepage' => $request->has('show_on_homepage') ? 1 : 0,
        ]);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image_url' => 'nullable|url',
            'link_url' => 'nullable|url',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date',
            'is_active' => 'nullable|boolean',
            'show_on_homepage' => 'nullable|boolean',
            'sort_order' => 'nullable|integer'
        ]);

        Promotion::create($data);
        return redirect()->route('admin.promotions.index')->with('success', 'Promotion created.');
    }

    public function edit($id)
    {
        $promo = Promotion::findOrFail($id);
        return view('admin.promotions.edit', compact('promo'));
    }

    public function update(Request $request, $id)
    {
        $promo = Promotion::findOrFail($id);
        // Normalize checkbox inputs for update as well
        $request->merge([
            'is_active' => $request->has('is_active') ? 1 : 0,
            'show_on_homepage' => $request->has('show_on_homepage') ? 1 : 0,
        ]);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image_url' => 'nullable|url',
            'link_url' => 'nullable|url',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date',
            'is_active' => 'nullable|boolean',
            'show_on_homepage' => 'nullable|boolean',
            'sort_order' => 'nullable|integer'
        ]);

        $promo->update($data);
        return redirect()->route('admin.promotions.index')->with('success', 'Promotion updated.');
    }

    public function destroy($id)
    {
        Promotion::destroy($id);
        return redirect()->route('admin.promotions.index')->with('success', 'Promotion deleted.');
    }
}

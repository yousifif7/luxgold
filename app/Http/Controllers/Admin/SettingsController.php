<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HeroContent;
use App\Models\User;

class SettingsController extends Controller
{
    /**
     * Display settings page with site-level data (hero defaults etc.)
     */
    public function index()
    {
        $heroContent = HeroContent::first();

        return view('admin.settings', compact('heroContent'));
    }

    /**
     * Update site settings (hero defaults / metadata)
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'title_part1' => 'nullable|string|max:255',
            'title_part2' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'cta_text' => 'nullable|string|max:100',
            'cta_url' => 'nullable|url',
            'hero_alt_text' => 'nullable|string|max:255',
            'hero_image_thumbnail' => 'nullable|url',
            'providers_count' => 'nullable|integer',
            'rating' => 'nullable|numeric',
            'support_text' => 'nullable|string|max:255',
            'status' => 'nullable|boolean'
        ]);

        $hero = HeroContent::firstOrNew([]);
        $hero->fill($request->only([
            'title_part1', 'title_part2', 'description',
            'meta_title', 'meta_description', 'cta_text', 'cta_url',
            'hero_alt_text', 'hero_image_thumbnail',
            'providers_count', 'rating', 'support_text', 'status'
        ]));
        $hero->save();

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }

    // Minimal user/template management methods so routes don't 404
    public function storeUser(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email'
        ]);

        User::create($data + ['password' => bcrypt(str()->random(12))]);

        return redirect()->back()->with('success', 'User created.');
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $data = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
        ]);
        $user->update($data);
        return redirect()->back()->with('success', 'User updated.');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', 'User deleted.');
    }

    public function storeTemplate(Request $request)
    {
        // For now just accept and flash back; persistence can be added later
        $request->validate(['template' => 'required|string']);
        session()->flash('success', 'Template saved (in-memory).');
        return redirect()->back();
    }

    public function updateTemplate(Request $request, $index)
    {
        $request->validate(['template' => 'required|string']);
        session()->flash('success', 'Template updated (in-memory).');
        return redirect()->back();
    }

    public function deleteTemplate($index)
    {
        session()->flash('success', 'Template deleted (in-memory).');
        return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FeatureController extends Controller
{
    public function index()
    {
        $col = 'order';
        $features = Feature::orderBy($col)->get();
        return view('admin.features.index', ['features' => $features]);
    }

    public function create()
    {
        $features = \App\Models\Feature::all();
        return view('admin.features.create', compact('features'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'icon_svg' => 'nullable',
            'icon_image' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'color_class' => 'required|in:blue,gold,red,green,purple',
            'order' => 'integer',
        ]);

        if ($request->hasFile('icon_image')) {
            $validated['icon_image'] = $request->file('icon_image')->store('features/icons', 'public');
        }

        Feature::create($validated);

        return redirect()->route('admin.features.index')->with('success', 'Fitur berhasil ditambahkan.');
    }

    public function edit(Feature $feature)
    {
        return view('admin.features.edit', ['feature' => $feature]);
    }

    public function update(Request $request, Feature $feature)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'icon_svg' => 'nullable',
            'icon_image' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'color_class' => 'required|in:blue,gold,red,green,purple',
            'order' => 'integer',
        ]);

        if ($request->hasFile('icon_image')) {
            if ($feature->icon_image) {
                Storage::disk('public')->delete($feature->icon_image);
            }
            $validated['icon_image'] = $request->file('icon_image')->store('features/icons', 'public');
        } else {
            unset($validated['icon_image']);
        }

        $feature->update($validated);

        return redirect()->route('admin.features.index')->with('success', 'Fitur berhasil diperbarui.');
    }

    public function destroy(Feature $feature)
    {
        if ($feature->icon_image) {
            Storage::disk('public')->delete($feature->icon_image);
        }
        $feature->delete();

        return redirect()->route('admin.features.index')->with('success', 'Fitur berhasil dihapus.');
    }
}

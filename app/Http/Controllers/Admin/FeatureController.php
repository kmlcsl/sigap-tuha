<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;

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
        return view('admin.features.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'icon_svg' => 'nullable',
            'color_class' => 'required|in:blue,gold,red',
            'order' => 'integer',
        ]);

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
            'color_class' => 'required|in:blue,gold,red',
            'order' => 'integer',
        ]);

        $feature->update($validated);

        return redirect()->route('admin.features.index')->with('success', 'Fitur berhasil diperbarui.');
    }

    public function destroy(Feature $feature)
    {
        $feature->delete();

        return redirect()->route('admin.features.index')->with('success', 'Fitur berhasil dihapus.');
    }
}

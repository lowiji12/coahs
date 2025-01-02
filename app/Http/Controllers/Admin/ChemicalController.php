<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chemical;

class ChemicalController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $chemicals = Chemical::when($search, function ($query) use ($search) {
            return $query->where('name', 'like', "%{$search}%")
                         ->orWhere('brand_name', 'like', "%{$search}%")
                         ->orWhere('stock', 'like', "%{$search}%")
                         ->orWhere('expire_date', 'like', "%{$search}%")
                         ->orWhere('location', 'like', "%{$search}%");
        })->get();

        return view('admin.chemicals.index', compact('chemicals'));
    }

    public function create()
    {
        return view('admin.chemicals.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand_name' => 'required|string|max:255',
            'stock' => 'required|integer|min:1',
            'expire_date' => 'required|date',
            'location' => 'required|string|max:255',
        ]);

        $existingChemical = Chemical::where('name', $request->name)
            ->where('brand_name', $request->brand_name)
            ->where('expire_date', $request->expire_date)
            ->where('location', $request->location)
            ->first();

        if ($existingChemical) {
            $existingChemical->increment('stock', $request->stock);
            return redirect()->route('admin.chemicals.index')->with('success', 'Stock updated successfully for the existing chemical.');
        }

        Chemical::create($request->only(['name', 'brand_name', 'stock', 'expire_date', 'location']));

        return redirect()->route('admin.chemicals.index')->with('success', 'Chemical added successfully.');
    }

    public function edit($id)
    {
        $chemical = Chemical::findOrFail($id);
        return view('admin.chemicals.edit', compact('chemical'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand_name' => 'required|string|max:255',
            'stock' => 'required|integer|min:1',
            'expire_date' => 'required|date',
            'location' => 'required|string|max:255',
        ]);

        $chemical = Chemical::findOrFail($id);
        $chemical->update($request->only(['name', 'brand_name', 'stock', 'expire_date', 'location']));

        return redirect()->route('admin.chemicals.index')->with('success', 'Chemical updated successfully.');
    }

    public function delete($id)
    {
        $chemical = Chemical::findOrFail($id);
        $chemical->delete();

        return redirect()->route('admin.chemicals.index')->with('success', 'Chemical deleted successfully.');
    }
}

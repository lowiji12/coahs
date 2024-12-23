<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chemical;

class ChemicalController extends Controller
{
    public function index()
    {
        $chemicals = Chemical::all();
        return view('admin.chemicals.inventory-chemicals', compact('chemicals'));
    }

    public function create()
    {
        return view('admin.chemicals.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'stocks' => 'required|integer',
        ]);

        Chemical::create($request->all());
        return redirect()->route('admin.chemicals.index')->with('success', 'Chemical created successfully.');
    }

    public function edit(Chemical $chemical)
    {
        return view('admin.chemicals.edit', compact('chemical'));
    }

    public function update(Request $request, Chemical $chemical)
    {
        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'stocks' => 'required|integer',
        ]);

        $chemical->update($request->all());
        return redirect()->route('admin.chemicals.index')->with('success', 'Chemical updated successfully.');
    }

    public function destroy(Chemical $chemical)
    {
        $chemical->delete();
        return redirect()->route('admin.chemicals.index')->with('success', 'Chemical deleted successfully.');
    }
}

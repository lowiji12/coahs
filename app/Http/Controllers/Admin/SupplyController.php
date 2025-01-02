<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supply; // Import the Supply model
use Illuminate\Http\Request;

class SupplyController extends Controller
{
    public function index(Request $request)
{
    $query = $request->get('search');
    $supplies = $query
        ? Supply::where('name', 'like', '%' . $query . '%')
            ->orWhere('location', 'like', '%' . $query . '%')
            ->orWhere('stock', 'like', '%' . $query . '%')
            ->get()
        : Supply::all();

    return view('admin.supplies.index', compact('supplies'));
}


    public function create(Request $request)
    {
        return view('admin.supplies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
        ]);

        $supply = Supply::where('name', $request->name)
            ->where('location', $request->location)
            ->first();

        if ($supply) {
            $supply->stock += $request->stock;
            $supply->save();

            return redirect()->route('admin.supplies.index')->with('success', 'Stock updated successfully!');
        } else {
            Supply::create($request->only('name', 'location', 'stock'));

            return redirect()->route('admin.supplies.index')->with('success', 'Supply added successfully!');
        }
    }

    public function edit($id)
    {
        $supply = Supply::findOrFail($id);
        return view('admin.supplies.edit', compact('supply'));
    }

    public function update(Request $request, $id)
    {
        $supply = Supply::findOrFail($id);
        $supply->update($request->only('name', 'location', 'stock'));
        return redirect()->route('admin.supplies.index')->with('success', 'Supply updated successfully!');
    }

    public function destroy($id)
    {
        $supply = Supply::findOrFail($id);
        $supply->delete();
        return redirect()->route('admin.supplies.index')->with('success', 'Supply deleted successfully!');
    }

    public function search(Request $request)
    {
    $query = $request->input('search');
    $supplies = Supply::where('name', 'like', '%' . $query . '%')
        ->orWhere('location', 'like', '%' . $query . '%')
        ->orWhere('stock', 'like', '%' . $query . '%')
        ->get();

    return view('admin.supplies.index', compact('supplies'))->with('search', $query);
    }

}

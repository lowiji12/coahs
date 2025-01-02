<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Equipment;

class EquipmentController extends Controller
{
    // Show all equipment records with search functionality
    public function index(Request $request)
    {
        $query = Equipment::query();

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('location', 'LIKE', "%{$search}%"); 
        }

        $equipment = $query->get();

        return view('admin.equipment.index', compact('equipment'));
    }

    // Show form to create new equipment
    public function create()
    {
        return view('admin.equipment.create');
    }

    // Store new equipment record
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'location' => 'required|string',
        'quantity' => 'required|integer|min:1',
        'expire_date' => 'required|date',
    ]);

    // Check if the equipment with the same name, location, and expire_date already exists
    $existingEquipment = Equipment::where('name', $request->name)
                                   ->where('location', $request->location)
                                   ->where('expire_date', $request->expire_date)
                                   ->first();

    if ($existingEquipment) {
        // If it exists, update the quantity
        $existingEquipment->quantity += $request->quantity;
        $existingEquipment->save();

        return redirect()->route('admin.equipment.index')->with('success', 'Equipment quantity updated successfully!');
    }

    // If it does not exist, create a new equipment record
    Equipment::create($request->only(['name', 'location', 'quantity', 'expire_date']));

    // Add a flash message for success
    session()->flash('success', 'Equipment added successfully!');

    return redirect()->route('admin.equipment.index');
}




    // Show form to edit equipment
    public function edit($id)
    {
        $equipment = Equipment::findOrFail($id);
        return view('admin.equipment.edit', compact('equipment'));
    }

    // Update equipment record
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'location' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'expire_date' => 'required|date',
        ]);

        $equipment = Equipment::findOrFail($id);
        $equipment->update($request->all());

        return redirect()->route('admin.equipment.index')->with('success', 'Equipment updated successfully!');
    }

    // Delete equipment record
    public function destroy($id)
    {
        $equipment = Equipment::findOrFail($id);
        $equipment->delete();

        return redirect()->route('admin.equipment.index')->with('success', 'Equipment deleted successfully!');
    }
}

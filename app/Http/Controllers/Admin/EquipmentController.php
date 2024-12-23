<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Equipment;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipments = Equipment::all();
        return view('admin.Equipments.inventory-equipment', compact('equipments'));
    }

    public function create()
    {
        return view('admin.Equipments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'quantity' => 'required|integer',
        ]);

        Equipment::create($request->all());
        return redirect()->route('admin.equipments.index')->with('success', 'Equipment created successfully.');
    }

    public function edit(Equipment $equipment)
    {
        return view('admin.Equipments.edit', compact('equipment'));
    }

    public function update(Request $request, Equipment $equipment)
    {
        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'quantity' => 'required|integer',
        ]);

        $equipment->update($request->all());
        return redirect()->route('admin.equipments.index')->with('success', 'Equipment updated successfully.');
    }

    public function destroy(Equipment $equipment)
    {
        $equipment->delete();
        return redirect()->route('admin.equipments.index')->with('success', 'Equipment deleted successfully.');
    }
}

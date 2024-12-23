<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medicine;

class MedicineController extends Controller
{
    public function index()
    {
        $medicines = Medicine::all();
        return view('admin.medicines.inventory-medicines', compact('medicines'));
    }

    public function create()
    {
        return view('admin.medicines.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'generic_name' => 'required',
            'brand_name' => 'required',
            'dose' => 'required',
            'form' => 'required',
            'location' => 'required',
            'stock' => 'required',
        ]);

        Medicine::create($request->all());
        return redirect()->route('admin.medicines.index')->with('success', 'Medicine added successfully.');
    }

    public function edit($id)
    {
        $medicine = Medicine::findOrFail($id);
        return view('admin.medicines.edit', compact('medicine'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'generic_name' => 'required',
            'brand_name' => 'required',
            'dose' => 'required',
            'form' => 'required',
            'location' => 'required',
            'stock' => 'required',
        ]);

        $medicine = Medicine::findOrFail($id);
        $medicine->update($request->all());
        return redirect()->route('admin.medicines.index')->with('success', 'Medicine updated successfully.');
    }

    public function destroy($id)
    {
        $medicine = Medicine::findOrFail($id);
        $medicine->delete();
        return redirect()->route('admin.medicines.index')->with('success', 'Medicine deleted successfully.');
    }
}

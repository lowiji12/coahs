<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medicine;

class MedicineController extends Controller
{
    public function index(Request $request)
    {
        $medicines = Medicine::query();

        if ($request->has('search')) {
            $medicines->where('generic_name', 'like', '%' . $request->search . '%');
        }

        $medicines = $medicines->get();

        return view('admin.medicines.index', compact('medicines'));
    }

    public function create()
    {
        return view('admin.medicines.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'generic_name' => 'required|string',
            'brand_name' => 'required|string',
            'dose' => 'required|string',
            'form' => 'nullable|string',
            'other_form' => 'nullable|string',  // added validation for 'other_form'
            'expired_date' => 'required|date',
            'stock' => 'required|integer|min:1',
            'location' => 'required|string',
        ]);

        // Handle 'form' and 'other_form' logic
        $form = $request->input('form');
        $other_form = $request->input('other_form');

        // If the 'form' is empty but 'other_form' is filled, use 'other_form' as the form value
        if (empty($form) && !empty($other_form)) {
            $form = $other_form;
        }

        // Check if the medicine with the same details exists
        $medicine = Medicine::where('generic_name', $request->generic_name)
            ->where('brand_name', $request->brand_name)
            ->where('dose', $request->dose)
            ->where('form', $form)
            ->where('expired_date', $request->expired_date)
            ->where('location', $request->location)
            ->first();

        if ($medicine) {
            // If medicine exists, update the stock
            $medicine->stock += $request->stock;
            $medicine->save();

            return redirect()->route('admin.medicines.index')->with('success', 'Medicine stock updated successfully.');
        } else {
            // If medicine does not exist, create a new record
            $requestData = $request->all();
            $requestData['form'] = $form; // Ensure 'form' is set correctly
            Medicine::create($requestData);

            return redirect()->route('admin.medicines.index')->with('success', 'Medicine added successfully.');
        }
    }

    public function edit($id)
    {
        $medicine = Medicine::findOrFail($id);
        return view('admin.medicines.edit', compact('medicine'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'generic_name' => 'required|string',
            'brand_name' => 'required|string',
            'dose' => 'required|string',
            'form' => 'nullable|string',
            'other_form' => 'nullable|string', // added validation for 'other_form'
            'expired_date' => 'required|date',
            'stock' => 'required|integer',
            'location' => 'required|string',
        ]);

        // Handle 'form' and 'other_form' logic
        $form = $request->input('form');
        $other_form = $request->input('other_form');

        // If the 'form' is empty but 'other_form' is filled, use 'other_form' as the form value
        if (empty($form) && !empty($other_form)) {
            $form = $other_form;
        }

        $medicine = Medicine::findOrFail($id);
        $medicine->update(array_merge($request->all(), ['form' => $form])); // Ensure 'form' is set correctly

        return redirect()->route('admin.medicines.index')->with('success', 'Medicine updated successfully.');
    }

    public function destroy($id)
    {
        $medicine = Medicine::findOrFail($id);
        $medicine->delete();

        return redirect()->route('admin.medicines.index')->with('success', 'Medicine deleted successfully.');
    }
}

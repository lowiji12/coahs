<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Instrument;

class InstrumentController extends Controller
{
    public function index()
    {
        $instruments = Instrument::all();
        return view('admin.instrument.inventory-instruments', compact('instruments'));
    }

    public function create()
    {
        return view('admin.instrument.create-instrument');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'quantity' => 'required|integer',
        ]);

        Instrument::create($request->all());

        return redirect()->route('admin.instruments.index')->with('success', 'Instrument added successfully.');
    }

    public function edit(Instrument $instrument)
    {
        return view('admin.instrument.edit-instrument', compact('instrument'));
    }

    public function update(Request $request, Instrument $instrument)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'quantity' => 'required|integer',
        ]);

        $instrument->update($request->all());

        return redirect()->route('admin.instruments.index')->with('success', 'Instrument updated successfully.');
    }

    public function destroy(Instrument $instrument)
    {
        $instrument->delete();

        return redirect()->route('admin.instruments.index')->with('success', 'Instrument deleted successfully.');
    }
}

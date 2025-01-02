<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Instrument;

class InstrumentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $instruments = Instrument::when($search, function ($query) use ($search) {
            return $query->where('name', 'like', "%$search%")
                         ->orWhere('location', 'like', "%$search%");
        })->get();

        return view('admin.instruments.index', compact('instruments', 'search'));
    }

    public function create()
    {
        return view('admin.instruments.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'location' => 'required',
        'quantity' => 'required|integer',
    ]);

    // Check if an instrument with the same name, location, and quantity exists
    $instrument = Instrument::where('name', $request->name)
                            ->where('location', $request->location)
                            ->first();

    if ($instrument) {
        // Update the existing instrument's quantity
        $instrument->quantity += $request->quantity;
        $instrument->save();

        return redirect()->route('admin.instruments.index')->with('success', 'Instrument quantity updated successfully.');
    }

    // Create a new instrument record
    Instrument::create($request->all());

    return redirect()->route('admin.instruments.index')->with('success', 'Instrument added successfully.');
}

    public function edit($id)
    {
        $instrument = Instrument::findOrFail($id);
        return view('admin.instruments.edit', compact('instrument'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'quantity' => 'required|integer',
        ]);

        $instrument = Instrument::findOrFail($id);
        $instrument->update($request->all());
        return redirect()->route('admin.instruments.index')->with('success', 'Instrument updated successfully.');
    }

    public function destroy($id)
    {
        Instrument::destroy($id);
        return redirect()->route('admin.instruments.index')->with('success', 'Instrument deleted successfully.');
    }
}

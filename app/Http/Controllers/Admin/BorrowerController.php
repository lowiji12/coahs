<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Borrower;

class BorrowerController extends Controller
{
    public function index(Request $request)
{
    // Get the search term from the request
    $search = $request->input('search');
    
    // Query the Borrowers model
    if ($search) {
        $borrowers = Borrower::where('first_name', 'like', "%$search%")
            ->orWhere('last_name', 'like', "%$search%")
            ->orWhere('course', 'like', "%$search%")
            ->orWhere('year_level', 'like', "%$search%")
            ->orWhere('category', 'like', "%$search%")
            ->orWhere('borrowed_item', 'like', "%$search%")
            ->orWhere('borrowed_date', 'like', "%$search%")
            ->orWhere('quantity_borrowed', 'like', "%$search%")
            ->get();
    } else {
        $borrowers = Borrower::all();
    }

    // Pass the borrowers data to the view
    return view('admin.borrowers.index', compact('borrowers'));
}
    public function create()
    {
        return view('admin.borrowers.create');
    }

    public function store(Request $request)
{
    // Validate the incoming request
    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'course' => 'required|string|max:255',
        'year_level' => 'required|string|max:255',
        'category' => 'required|string|max:255',
        'borrowed_item' => 'required|string|max:255',
        'borrowed_date' => 'required|date',
        'quantity_borrowed' => 'required|integer|min:1',
    ]);

    // Check if a borrower with the same combination already exists
    $existingBorrower = Borrower::where('first_name', $request->first_name)
        ->where('last_name', $request->last_name)
        ->where('course', $request->course)
        ->where('year_level', $request->year_level)
        ->where('category', $request->category)
        ->where('borrowed_item', $request->borrowed_item)
        ->where('borrowed_date', $request->borrowed_date)
        ->first();

    if ($existingBorrower) {
        // If exists, increment the quantity_borrowed
        $existingBorrower->quantity_borrowed += $request->quantity_borrowed;
        $existingBorrower->save();

        return redirect()->route('admin.borrowers.index')->with('success', 'Quantity updated for the existing borrower record.');
    }

    // If not exists, create a new borrower record
    Borrower::create($request->only([
        'first_name', 
        'last_name', 
        'course', 
        'year_level', 
        'category', 
        'borrowed_item', 
        'borrowed_date', 
        'quantity_borrowed'
    ]));

    return redirect()->route('admin.borrowers.index')->with('success', 'Borrower added successfully.');
}


    public function edit($id)
    {
        $borrower = Borrower::findOrFail($id);
        return view('admin.borrowers.edit', compact('borrower'));
    }

    public function update(Request $request, $id)
    {
        $borrower = Borrower::findOrFail($id);
        $borrower->update($request->all());
        return redirect()->route('admin.borrowers.index')->with('success', 'Borrower updated successfully');
    }

    public function destroy($id)
    {
        $borrower = Borrower::findOrFail($id);
        $borrower->delete();
        return redirect()->route('admin.borrowers.index')->with('success', 'Borrower deleted successfully');
    }
}

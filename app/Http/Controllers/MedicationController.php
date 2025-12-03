<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medication;

class MedicationController extends Controller
{
    public function index(Request $request)
    {
        $query = Medication::query();

        // Search by name
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by brand
        if ($request->has('brand') && $request->brand != '') {
            $query->where('brand', $request->brand);
        }

        // Paginate 10 medications per page
        $medications = $query->paginate(10)->withQueryString();

        // Get all distinct brands
        $brands = Medication::select('brand')->distinct()->pluck('brand');

        return view('contents.medications', compact('medications', 'brands'));
    }

    public function create()
    {
        return view('create.medications');
    }

   public function store(Request $request)
{
    // Validate inputs
    $request->validate([
        'name' => 'required|string|max:255',
        'brand' => 'nullable|string|max:255',
        'dosage' => 'required|string|max:255',
        'form' => 'required|string|max:255',
        'description' => 'nullable|string',
        'route' => 'nullable|string|max:255',
        'stock' => 'required|integer|min:0',
        'price' => 'required|numeric|min:0',
        'status' => 'required|string|in:Available,Unavailable',
        'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $data = $request->all();

    // Handle picture upload
    if ($request->hasFile('picture')) {
        $file = $request->file('picture');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/medications', $filename);
        $data['picture'] = 'medications/' . $filename;
    }

    // Create medication
    Medication::create($data);

    return redirect()->route('medications.index')->with('success', 'Medication created successfully.');
}

    public function edit(Medication $medication)
    {
        return view('medications.edit', compact('medication'));
    }

    public function update(Request $request, Medication $medication)
{
    // Validate inputs
    $request->validate([
        'name' => 'required|string|max:255',
        'brand' => 'nullable|string|max:255',
        'dosage' => 'required|string|max:255',
        'form' => 'required|string|max:255',
        'description' => 'nullable|string',
        'route' => 'nullable|string|max:255',
        'stock' => 'required|integer|min:0',
        'price' => 'required|numeric|min:0',
        'status' => 'required|string|in:Available,Unavailable',
        'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $data = $request->all();

    // Handle picture upload if there is a file
    if ($request->hasFile('picture')) {
        $file = $request->file('picture');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/medications', $filename);
        $data['picture'] = 'medications/' . $filename;

        // Optionally, delete old picture if exists
        if ($medication->picture && \Storage::exists('public/' . $medication->picture)) {
            \Storage::delete('public/' . $medication->picture);
        }
    }

    // Update medication
    $medication->update($data);

    return redirect()->route('medications.index')->with('success', 'Medication updated successfully.');
}


    public function destroy(Medication $medication)
    {
        $medication->delete();
        return redirect()->route('medications.index')->with('success', 'Medication deleted successfully.');
    }
}

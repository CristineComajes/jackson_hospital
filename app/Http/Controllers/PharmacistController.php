<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pharmacist;

class PharmacistController extends Controller
{
    public function index()
    {
        $pharmacists = Pharmacist::all();
        return view('pharmacists.index', compact('pharmacists'));
    }

    public function create()
    {
        return view('pharmacists.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'license_number'=>'required|unique:pharmacists,license_number',
            'email'=>'required|email|unique:pharmacists,email',
            'username'=>'required|unique:pharmacists,username',
            'password'=>'required'
        ]);

        $data = $request->all();
        $data['password'] = bcrypt($request->password);

        Pharmacist::create($data);
        return redirect()->route('pharmacists.index')->with('success','Pharmacist created successfully.');
    }

    public function edit(Pharmacist $pharmacist)
    {
        return view('pharmacists.edit', compact('pharmacist'));
    }

    public function update(Request $request, Pharmacist $pharmacist)
    {
        $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'license_number'=>'required|unique:pharmacists,license_number,'.$pharmacist->id,
            'email'=>'required|email|unique:pharmacists,email,'.$pharmacist->id,
            'username'=>'required|unique:pharmacists,username,'.$pharmacist->id,
        ]);

        $data = $request->all();
        if($request->password){
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']);
        }

        $pharmacist->update($data);
        return redirect()->route('pharmacists.index')->with('success','Pharmacist updated successfully.');
    }

    public function destroy(Pharmacist $pharmacist)
    {
        $pharmacist->delete();
        return redirect()->route('pharmacists.index')->with('success','Pharmacist deleted successfully.');
    }
}

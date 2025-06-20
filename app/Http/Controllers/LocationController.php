<?php

namespace App\Http\Controllers;

use App\Models\LocationM;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index(){
        $data = LocationM::find(1);
        return view('pages.admin.klocation.index',compact('data'));
    }

    public function store(Request $request)
{
    $request->validate([
        'latitude' => 'required',
        'longitude' => 'required',
        'alamat' => 'required',
        'jarak' => 'required|integer',
    ]);

    LocationM::create($request->all());

    return redirect()->back()->with('success', 'Lokasi berhasil disimpan.');
}

public function update(Request $request, $id)
{
    $request->validate([
        'latitude' => 'required',
        'longitude' => 'required',
        'alamat' => 'required',
        'jarak' => 'required|integer',
    ]);

    $lokasi = LocationM::findOrFail($id);
    $lokasi->update($request->all());

    return redirect()->back()->with('success', 'Lokasi berhasil diperbarui.');
}

}

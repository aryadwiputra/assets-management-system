<?php

namespace App\Http\Controllers;

use App\Models\UnitOfMeasurement;
use Illuminate\Http\Request;

class UnitOfMeasurementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $uom = UnitOfMeasurement::all();

        return view('pages.dashboard.unit_of_measurement.index', compact('uom'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.dashboard.unit_of_measurement.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        UnitOfMeasurement::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('dashboard.unit-of-measurement.index')->with('success', 'Unit of Measurement berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(UnitOfMeasurement $UnitOfMeasurement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $uom = UnitOfMeasurement::find($id);

        return view('pages.dashboard.unit_of_measurement.edit', compact('uom'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        UnitOfMeasurement::find($id)->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('dashboard.unit-of-measurement.index')->with('success', 'Unit of Measurement berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = UnitOfMeasurement::find($id);

        if ($data) {
            $data->delete();
            return redirect()->route('dashboard.unit-of-measurement.index')->with('success', 'Unit of Measurement berhasil dihapus.');
        } else {
            return redirect()->route('dashboard.unit-of-measurement.index')->with('error', 'Unit of Measurement gagal dihapus.');
        }
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Project;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locations = Location::all();

        return view('pages.dashboard.location.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::all();
        return view('pages.dashboard.location.create', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
        ]);

        Location::create([
            'project_id' => $request->project_id,
            'name' => $request->name,
            'description' => $request->description,
            'address' => $request->address,
        ]);

        return redirect()->route('dashboard.locations.index')->with('success', 'Lokasi berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $location = Location::find($id);

        $projects = Project::all();

        return view('pages.dashboard.location.edit', compact('location', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'project_id' => 'required',
            'address' => 'required|string',
        ]);

        Location::find($id)->update([
            'project_id' => $request->project_id,
            'name' => $request->name,
            'description' => $request->description,
            'address' => $request->address,
        ]);

        return redirect()->route('dashboard.locations.index')->with('success', 'Lokasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Location::find($id);

        if ($data) {
            $data->delete();
            return redirect()->route('dashboard.locations.index')->with('success', 'Lokasi berhasil dihapus.');
        } else {
            return redirect()->route('dashboard.locations.index')->with('error', 'Lokasi gagal dihapus.');
        }
    }
}
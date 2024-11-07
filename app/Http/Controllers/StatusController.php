<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $class = Status::all();

        return view('pages.dashboard.status.index', compact('class'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.dashboard.status.create');
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

        Status::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('dashboard.status.index')->with('success', 'Asset Status berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Status $Status)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $asset = Status::find($id);

        return view('pages.dashboard.status.edit', compact('asset'));
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

        Status::find($id)->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('dashboard.status.index')->with('success', 'Asset Status berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Status::find($id);

        if ($data) {
            $data->delete();
            return redirect()->route('dashboard.status.index')->with('success', 'Asset Status berhasil dihapus.');
        } else {
            return redirect()->route('dashboard.status.index')->with('error', 'Asset Status gagal dihapus.');
        }
    }
}
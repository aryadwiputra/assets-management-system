<?php

namespace App\Http\Controllers;

use App\Models\AssetStatus;
use Illuminate\Http\Request;

class AssetStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $class = AssetStatus::all();

        return view('pages.dashboard.asset-status.index', compact('class'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.dashboard.asset-status.create');
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

        AssetStatus::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('dashboard.assets-status.index')->with('success', 'Asset Status berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AssetStatus $AssetStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $asset = AssetStatus::find($id);

        return view('pages.dashboard.asset-status.edit', compact('asset'));
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

        AssetStatus::find($id)->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('dashboard.assets-status.index')->with('success', 'Asset Status berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = AssetStatus::find($id);

        if ($data) {
            $data->delete();
            return redirect()->route('dashboard.assets-status.index')->with('success', 'Asset Status berhasil dihapus.');
        } else {
            return redirect()->route('dashboard.assets-status.index')->with('error', 'Asset Status gagal dihapus.');
        }
    }
}
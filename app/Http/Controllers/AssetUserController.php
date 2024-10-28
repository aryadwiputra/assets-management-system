<?php

namespace App\Http\Controllers;

use App\Models\AssetUser;
use Illuminate\Http\Request;

class AssetUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $class = AssetUser::all();

        return view('pages.dashboard.asset-users.index', compact('class'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.dashboard.asset-users.create');
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

        AssetUser::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('dashboard.assets-users.index')->with('success', 'Asset Class berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AssetUser $assetUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $asset = AssetUser::find($id);

        return view('pages.dashboard.asset-users.edit', compact('asset'));
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

        AssetUser::find($id)->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('dashboard.assets-users.index')->with('success', 'Asset Class berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = AssetUser::find($id);

        if ($data) {
            $data->delete();
            return redirect()->route('dashboard.assets-users.index')->with('success', 'Asset Class berhasil dihapus.');
        } else {
            return redirect()->route('dashboard.assets-users.index')->with('error', 'Asset Class gagal dihapus.');
        }
    }
}
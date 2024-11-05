<?php

namespace App\Http\Controllers;

use App\Models\Warranty;
use Illuminate\Http\Request;

class WarrantyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $warranties = Warranty::all();
        
        return view('pages.dashboard.warranties.index', compact('warranties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.dashboard.warranties.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'period' => 'required|numeric',
        ]);

        Warranty::create([
            'name' => $request->name,
            'period' => $request->period,
        ]);

        return redirect()->route('dashboard.warranties.index')->with('success', 'Garansi berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Warranty $warranty)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $warranty = Warranty::find($id);

        return view('pages.dashboard.warranties.edit', compact('warranty'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'period' => 'required|string',
        ]);

        Warranty::find($id)->update([
            'name' => $request->name,
            'period' => $request->period,
        ]);

        return redirect()->route('dashboard.warranties.index')->with('success', 'Garansi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $warranty = Warranty::find($id);

        $warranty->delete();

        return redirect()->route('dashboard.warranties.index')->with('success','Garansi berhasil dihapus.');
    }
}
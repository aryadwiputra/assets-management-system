<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetBorrowing;
use App\Models\PersonInCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetBorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assets_available = Asset::with(['project', 'person_in_charge', 'location', 'employee'])->where('is_disposal', 0)->where('is_sale', 0)->where('is_borrow', 0)->where('employee_id', null)->get();

        $asset_borrow = AssetBorrowing::with(['asset', 'user', 'employee'])->get();

        return view('pages.dashboard.borrowing.index', compact('assets_available', 'asset_borrow'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $assets = Asset::with(['category', 'company', 'class', 'department', 'employee', 'location', 'person_in_charge', 'project', 'status', 'unit_of_measurement', 'warranty'])->get();

        $person_in_charges = PersonInCharge::all();
        $employees = \App\Models\Employee::all();

        return view('pages.dashboard.borrowing.create', compact('assets', 'employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'asset_id' => 'required',
            'employee_id' => 'required',
            'from_date' => 'required',
            'to_date' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);

        $asset = Asset::findOrFail($request->asset_id);

        $asset->is_borrow = 1;

        $asset->update([
            'is_borrow' => 1,
        ]);

        $asset->borrow()->create([
            'asset_id' => $request->asset_id,
            'employee_id' => $request->employee_id,
            'user_id' => Auth::user()->id,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('dashboard.assets.borrow.index')->with('success', 'Pengajuan pinjam asset berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $assetBorrowing = AssetBorrowing::with(['asset', 'employee'])->findOrFail($id);

        $assets = Asset::with(['category', 'company', 'class', 'department', 'employee', 'location', 'person_in_charge', 'project', 'status', 'unit_of_measurement', 'warranty'])->get();

        $employees = \App\Models\Employee::all();

        return view('pages.dashboard.borrowing.edit', compact('assetBorrowing', 'assets', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'asset_id' => 'required',
            'employee_id' => 'required',
            'from_date' => 'required',
            'to_date' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);

        $assetBorrowing = AssetBorrowing::findOrFail($id);

        $assetBorrowing->update([
            'asset_id' => $request->asset_id,
            'employee_id' => $request->employee_id,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        // Update the asset status if necessary
        $asset = Asset::findOrFail($request->asset_id);
        $asset->update([
            'is_borrow' => $request->status === 'returned' ? 0 : 1,
        ]);

        return redirect()->route('dashboard.assets.borrow.index')->with('success', 'Pengajuan pinjam asset berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $assetBorrowing = AssetBorrowing::findOrFail($id);

        // Update the asset status
        $asset = Asset::findOrFail($assetBorrowing->asset_id);
        $asset->update([
            'is_borrow' => 0,
        ]);

        $assetBorrowing->delete();

        return redirect()->route('dashboard.assets.borrow.index')->with('success', 'Pengajuan pinjam asset berhasil dihapus.');
    }

    public function cron_job()
    {
        $assets = Asset::where('is_borrow', 1)->get();

        // Cek apakah tanggal to_date sudah lewat   
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Location;
use App\Models\Disposal;
use App\Models\disposalFile;
use App\Models\PersonInCharge;
use App\Models\Project;
use App\Models\Status;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DisposalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $disposals = Disposal::with(['project', 'pic', 'status'])->get();

        // echo json_encode($disposals);

        return view('pages.dashboard.disposal.index', compact('disposals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $assets = Asset::with(['category', 'company', 'class', 'department', 'employee', 'location', 'person_in_charge', 'project', 'status', 'unit_of_measurement', 'warranty'])->get();

        $projects = Project::all();
        $statuses = Status::all();
        $person_in_charges = PersonInCharge::all();

        return view('pages.dashboard.disposal.create', compact('assets', 'projects', 'statuses', 'person_in_charges'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required',
            'status_id' => 'required',
            'name' => 'required',
            'pic_id' => 'required',
        ]);

        $disposal = Disposal::create([
            'project_id' => $request->project_id,
            'status_id' => $request->status_id,
            'pic_id' => $request->pic_id,
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'status'=> $request->status,
            'comment'=> $request->comment
        ]);

        return redirect()->route('dashboard.disposals.show', $disposal->id)->with('success', 'Disposal berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Disposal $disposal)
    {
        $disposal->with(['project', 'pic', 'status', 'assets']);

        // $available_assets = Asset::where('pic_id', $disposal->pic_id)->get();

        $available_assets = Asset::where('pic_id', $disposal->pic_id)
            ->whereDoesntHave('disposals', function ($query) use ($disposal) {
                $query->where('disposal_id', $disposal->id);
            })
            ->get();

        return view('pages.dashboard.disposal.show', compact('disposal', 'available_assets'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Disposal $disposal)
    {
        
        $projects = Project::all();
        $statuses = Status::all();
        $person_in_charges = PersonInCharge::all();

        return view('pages.dashboard.disposal.edit', compact('disposal', 'projects', 'statuses', 'person_in_charges'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Disposal $disposal)
    {
        $request->validate([
            'project_id' => 'required',
            'status_id' => 'required',
            'name' => 'required',
            'pic_id' => 'required',
        ]);

        $disposal->update([
            'project_id' => $request->project_id,
            'status_id' => $request->status_id,
            'person_in_charge_id' => $request->person_in_charge_id,
            'pic_id' => $request->pic_id,
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'status'=> $request->status,
            'comment'=> $request->comment
        ]);

        return redirect()->route('dashboard.disposals.show', $disposal->id)->with('success', 'Mutasi berhasil diperbarui.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Disposal $disposal)
    {
        $disposal->delete();

        return redirect()->route('dashboard.disposals.index')->with('success', 'Mutasi berhasil dihapus.');
    }

    /**
     * Done status disposal
     */
    public function done(Disposal $disposal)
    {
        $disposal->update([
            'status' => 'done'
        ]);

        return redirect()->route('dashboard.disposals.show', $disposal->id)->with('success', 'Mutasi berhasil diselesaikan.');
    }

    /**
     * Open status disposal
     */
    public function open(Disposal $disposal)
    {
        $disposal->update([
            'status' => 'open'
        ]);

        return redirect()->route('dashboard.disposals.show', $disposal->id)->with('success', 'Mutasi berhasil dibuka.');
    }

    /**
     * Cancel status disposal
     */
    public function cancel(Disposal $disposal)
    {
        $disposal->update([
            'status' => 'cancel'
        ]);

        return redirect()->route('dashboard.disposals.show', $disposal->id)->with('success', 'Mutasi berhasil dibatalkan.');
    }

    /**
     * Print to PDF
     */
    public function print(Disposal $disposal)
    {
        $data = [
            'disposal' => $disposal->with(['project', 'pic', 'status', 'assets'])->first(),
        ];

        $pdf = Pdf::loadView('pages.dashboard.disposal.print', $data)->setPaper('a4', 'landscape');

        return $pdf->download('disposal' . date('Y-m-d -H-i-s') . '.pdf');
    }

    /**
     * Add an asset to the disposal
     */
    public function addAsset(Request $request)
    {
        $request->validate([
            'asset_id' => 'required',
            'disposal_id' => 'required'
        ]);

        $asset = Asset::find($request->asset_id);

        $disposal_id = $request->disposal_id;

        // Pengecekan apakah sudah ada di database atau belum
        $cek = DB::table('asset_disposal')
            ->where('asset_id', $request->asset_id)
            ->where('disposal_id', $request->disposal_id)
            ->exists();

        if ($cek) {
            return redirect()->route('dashboard.disposals.show', $disposal_id)->with('error', 'Asset sudah ada di mutasi.');
        }

        $asset->disposals()->attach($disposal_id); 

        return redirect()->route('dashboard.disposals.show', $disposal_id)->with('success', 'Asset berhasil ditambahkan ke mutasi.');
    }

    /**
     * Remove an asset from the disposal
     */
    public function removeAsset(Request $request)
    {
        $request->validate([
            'asset_id' => 'required',
            'disposal_id' => 'required'
        ]);

        $asset = Asset::find($request->asset_id);

        $disposal_id = $request->disposal_id;

        $asset->disposals()->detach($disposal_id);

        return redirect()->route('dashboard.disposals.show', $disposal_id)->with('success', 'Asset berhasil dihapus dari mutasi.');
    }

    /**
     * Bulk add assets to the disposal
     */
    public function bulkAddAsset(Request $request)
    {
        $request->validate([
            'asset_ids' => 'required',
            'disposal_id' => 'required'
        ]);

        $asset_ids = $request->asset_ids;
        $disposal_id = $request->disposal_id;

        foreach ($asset_ids as $asset_id) {

            $cek = DB::table('asset_disposal')
            ->where('asset_id', $asset_id)
            ->where('disposal_id', $disposal_id)
            ->exists();

            if ($cek) {
                return redirect()->route('dashboard.disposals.show', $disposal_id)->with('error', 'Asset sudah ada di mutasi.');
            }

            $asset = Asset::find($asset_id);
            $asset->disposals()->attach($disposal_id);
        }
        return redirect()->route('dashboard.disposals.show', $disposal_id)->with('success', 'Asset berhasil ditambahkan ke mutasi.');
    }

    /**
     * Bulk remove assets from the disposal
     */
    public function bulkRemoveAsset(Request $request)
    {
        $request->validate([
            'asset_ids' => 'required',
            'disposal_id' => 'required'
        ]);

        $asset_ids = $request->asset_ids;
        $disposal_id = $request->disposal_id;

        foreach ($asset_ids as $asset_id) {
            $asset = Asset::find($asset_id);
            $asset->disposals()->detach($disposal_id);
        }
        return redirect()->route('dashboard.disposals.show', $disposal_id)->with('success', 'Asset berhasil dihapus dari mutasi.');
    }

    /**
     * Upload file document
     */
    public function uploadDocument($disposal_id, Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);
        
        $file = $request->file('file');

        $filename = time() . '.' . $file->getClientOriginalExtension();

        $file->storeAs('asset/disposal', $filename, 'public');

        disposalFile::create([
            'disposal_id' => $disposal_id,
            'file_name' => $filename,
        ]);

        return redirect()->route('dashboard.disposals.show', $disposal_id)->with('success', 'File berhasil diunggah.');
    }

    /**
     * Delete file document
     */
    public function deleteDocument($disposal_id, $file_id)
    {
        $file = disposalFile::find($file_id);

        // Remove from storage
        Storage::delete('public/asset/disposal/' . $file->file_name);

        $file->delete();

        return redirect()->route('dashboard.disposals.show', $disposal_id)->with('success', 'File berhasil dihapus.');
    }
}
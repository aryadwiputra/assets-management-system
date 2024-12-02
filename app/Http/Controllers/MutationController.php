<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Location;
use App\Models\Mutation;
use App\Models\MutationFile;
use App\Models\PersonInCharge;
use App\Models\Project;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MutationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mutations = Mutation::with(['project', 'pic', 'location'])->get();

        // echo json_encode($mutations);

        return view('pages.dashboard.mutation.index', compact('mutations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $assets = Asset::with(['category', 'company', 'class', 'department', 'employee', 'location', 'person_in_charge', 'project', 'status', 'unit_of_measurement', 'warranty'])->get();

        $projects = Project::all();
        $locations = Location::all();
        $person_in_charges = PersonInCharge::all();

        return view('pages.dashboard.mutation.create', compact('assets', 'projects', 'locations', 'person_in_charges'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required',
            'to_location' => 'required',
            'name' => 'required',
            'pic_id' => 'required',
        ]);

        $mutation = Mutation::create([
            'project_id' => $request->project_id,
            'to_location' => $request->to_location,
            'person_in_charge_id' => $request->person_in_charge_id,
            'pic_id' => $request->pic_id,
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'status'=> $request->status,
            'comment'=> $request->comment
        ]);

        return redirect()->route('dashboard.mutations.show', $mutation->id)->with('success', 'Mutasi berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mutation $mutation)
    {
        $mutation->with(['project', 'pic', 'location', 'assets']);

        // $available_assets = Asset::where('pic_id', $mutation->pic_id)->get();

        $available_assets = Asset::where('pic_id', $mutation->pic_id)
            ->whereDoesntHave('mutations', function ($query) use ($mutation) {
                $query->where('mutation_id', $mutation->id);
            })
            ->get();

        return view('pages.dashboard.mutation.show', compact('mutation', 'available_assets'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mutation $mutation)
    {
        
        $projects = Project::all();
        $locations = Location::all();
        $person_in_charges = PersonInCharge::all();

        return view('pages.dashboard.mutation.edit', compact('mutation', 'projects', 'locations', 'person_in_charges'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mutation $mutation)
    {
        $request->validate([
            'project_id' => 'required',
            'to_location' => 'required',
            'name' => 'required',
            'pic_id' => 'required',
        ]);

        $mutation->update([
            'project_id' => $request->project_id,
            'to_location' => $request->to_location,
            'person_in_charge_id' => $request->person_in_charge_id,
            'pic_id' => $request->pic_id,
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'status'=> $request->status,
            'comment'=> $request->comment
        ]);

        return redirect()->route('dashboard.mutations.show', $mutation->id)->with('success', 'Mutasi berhasil diperbarui.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mutation $mutation)
    {
        $mutation->delete();

        return redirect()->route('dashboard.mutations.index')->with('success', 'Mutasi berhasil dihapus.');
    }

    /**
     * Done status mutation
     */
    public function done(Mutation $mutation)
    {
        $mutation->update([
            'status' => 'done'
        ]);

        return redirect()->route('dashboard.mutations.show', $mutation->id)->with('success', 'Mutasi berhasil diselesaikan.');
    }

    /**
     * Open status mutation
     */
    public function open(Mutation $mutation)
    {
        $mutation->update([
            'status' => 'open'
        ]);

        return redirect()->route('dashboard.mutations.show', $mutation->id)->with('success', 'Mutasi berhasil dibuka.');
    }

    /**
     * Cancel status mutation
     */
    public function cancel(Mutation $mutation)
    {
        $mutation->update([
            'status' => 'cancel'
        ]);

        return redirect()->route('dashboard.mutations.show', $mutation->id)->with('success', 'Mutasi berhasil dibatalkan.');
    }

    /**
     * Print to PDF
     */
    public function print(Mutation $mutation)
    {
        $data = [
            'mutation' => $mutation,
        ];

        $pdf = Pdf::loadView('pages.dashboard.mutation.print', $data)->setPaper('a4', 'landscape');

        return $pdf->download('mutasi.pdf');
    }

    /**
     * Add an asset to the mutation
     */
    public function addAsset(Request $request)
    {
        $request->validate([
            'asset_id' => 'required',
            'mutation_id' => 'required'
        ]);

        $asset = Asset::find($request->asset_id);

        $mutation_id = $request->mutation_id;

        // Pengecekan apakah sudah ada di database atau belum
        $cek = DB::table('asset_mutation')
            ->where('asset_id', $request->asset_id)
            ->where('mutation_id', $request->mutation_id)
            ->exists();

        if ($cek) {
            return redirect()->route('dashboard.mutations.show', $mutation_id)->with('error', 'Asset sudah ada di mutasi.');
        }

        $asset->mutations()->attach($mutation_id); 

        return redirect()->route('dashboard.mutations.show', $mutation_id)->with('success', 'Asset berhasil ditambahkan ke mutasi.');
    }

    /**
     * Remove an asset from the mutation
     */
    public function removeAsset(Request $request)
    {
        $request->validate([
            'asset_id' => 'required',
            'mutation_id' => 'required'
        ]);

        $asset = Asset::find($request->asset_id);

        $mutation_id = $request->mutation_id;

        $asset->mutations()->detach($mutation_id);

        return redirect()->route('dashboard.mutations.show', $mutation_id)->with('success', 'Asset berhasil dihapus dari mutasi.');
    }

    /**
     * Bulk add assets to the mutation
     */
    public function bulkAddAsset(Request $request)
    {
        $request->validate([
            'asset_ids' => 'required',
            'mutation_id' => 'required'
        ]);

        $asset_ids = $request->asset_ids;
        $mutation_id = $request->mutation_id;

        foreach ($asset_ids as $asset_id) {

            $cek = DB::table('asset_mutation')
            ->where('asset_id', $asset_id)
            ->where('mutation_id', $mutation_id)
            ->exists();

            if ($cek) {
                return redirect()->route('dashboard.mutations.show', $mutation_id)->with('error', 'Asset sudah ada di mutasi.');
            }

            $asset = Asset::find($asset_id);
            $asset->mutations()->attach($mutation_id);
        }
        return redirect()->route('dashboard.mutations.show', $mutation_id)->with('success', 'Asset berhasil ditambahkan ke mutasi.');
    }

    /**
     * Bulk remove assets from the mutation
     */
    public function bulkRemoveAsset(Request $request)
    {
        $request->validate([
            'asset_ids' => 'required',
            'mutation_id' => 'required'
        ]);

        $asset_ids = $request->asset_ids;
        $mutation_id = $request->mutation_id;

        foreach ($asset_ids as $asset_id) {
            $asset = Asset::find($asset_id);
            $asset->mutations()->detach($mutation_id);
        }
        return redirect()->route('dashboard.mutations.show', $mutation_id)->with('success', 'Asset berhasil dihapus dari mutasi.');
    }

    /**
     * Upload file document
     */
    public function uploadDocument($mutation_id, Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);
        
        $file = $request->file('file');

        $filename = time() . '.' . $file->getClientOriginalExtension();

        $file->storeAs('asset/document', $filename, 'public');

        MutationFile::create([
            'mutation_id' => $mutation_id,
            'file_name' => $filename,
        ]);

        return redirect()->route('dashboard.mutations.show', $mutation_id)->with('success', 'File berhasil diunggah.');
    }

    /**
     * Delete file document
     */
    public function deleteDocument($mutation_id, $file_id)
    {
        $file = MutationFile::find($file_id);

        // Remove from storage
        Storage::delete('public/asset/document/' . $file->file_name);

        $file->delete();

        return redirect()->route('dashboard.mutations.show', $mutation_id)->with('success', 'File berhasil dihapus.');
    }
}
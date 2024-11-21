<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Sale;
use App\Models\SaleFile;
use App\Models\PersonInCharge;
use App\Models\Project;
use App\Models\Status;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = Sale::with(['project', 'pic'])->get();

        // echo json_encode($sales);

        return view('pages.dashboard.sale.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $assets = Asset::with(['category', 'company', 'class', 'department', 'employee', 'location', 'person_in_charge', 'project', 'status', 'unit_of_measurement', 'warranty'])->get();

        $projects = Project::all();
        $person_in_charges = PersonInCharge::all();

        return view('pages.dashboard.sale.create', compact('assets', 'projects', 'person_in_charges'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required',
            'name' => 'required',
            'pic_id' => 'required',
        ]);

        $sale = Sale::create([
            'project_id' => $request->project_id,
            'pic_id' => $request->pic_id,
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'buyer_name' => $request->buyer_name,
            'buyer_contact' => $request->buyer_contact,
            'date' => $request->date,
            'price' => $request->price,
            'notes' => $request->notes,
            'status'=> $request->status,
        ]);

        return redirect()->route('dashboard.sales.show', $sale->id)->with('success', 'Disposal berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        $sale->with(['project', 'pic', 'assets']);

        $available_assets = Asset::where('pic_id', $sale->pic_id)
            ->whereDoesntHave('sales', function ($query) use ($sale) {
                $query->where('sale_id', $sale->id);
            })
            ->get();

        return view('pages.dashboard.sale.show', compact('sale', 'available_assets'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        $projects = Project::all();
        $person_in_charges = PersonInCharge::all();

        return view('pages.dashboard.sale.edit', compact('sale', 'projects', 'person_in_charges'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        $request->validate([
            'project_id' => 'required',
            'name' => 'required',
            'pic_id' => 'required',
        ]);

        $sale->update([
            'project_id' => $request->project_id,
            'pic_id' => $request->pic_id,
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'buyer_name' => $request->buyer_name,
            'buyer_contact' => $request->buyer_contact,
            'date' => $request->date,
            'price' => $request->price,
            'notes' => $request->notes,
            'status'=> $request->status,
        ]);

        return redirect()->route('dashboard.sales.show', $sale->id)->with('success', 'Mutasi berhasil diperbarui.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        $sale->delete();

        return redirect()->route('dashboard.sales.index')->with('success', 'Mutasi berhasil dihapus.');
    }

    /**
     * Done status sale
     */
    public function done(Sale $sale)
    {
        $sale->update([
            'status' => 'done'
        ]);

        return redirect()->route('dashboard.sales.show', $sale->id)->with('success', 'Mutasi berhasil diselesaikan.');
    }

    /**
     * Open status sale
     */
    public function open(Sale $sale)
    {
        $sale->update([
            'status' => 'open'
        ]);

        return redirect()->route('dashboard.sales.show', $sale->id)->with('success', 'Mutasi berhasil dibuka.');
    }

    /**
     * Cancel status sale
     */
    public function cancel(Sale $sale)
    {
        $sale->update([
            'status' => 'cancel'
        ]);

        return redirect()->route('dashboard.sales.show', $sale->id)->with('success', 'Mutasi berhasil dibatalkan.');
    }

    /**
     * Print to PDF
     */
    public function print(Sale $sale)
    {
        $data = [
            'sale' => $sale->with(['project', 'pic', 'assets'])->first(),
        ];

        $pdf = Pdf::loadView('pages.dashboard.sale.print', $data)->setPaper('a4', 'landscape');

        return $pdf->download('sale' . date('Y-m-d -H-i-s') . '.pdf');
    }

    /**
     * Add an asset to the sale
     */
    public function addAsset(Request $request)
    {
        $request->validate([
            'asset_id' => 'required',
            'sale_id' => 'required'
        ]);

        $asset = Asset::find($request->asset_id);

        $sale_id = $request->sale_id;

        // Pengecekan apakah sudah ada di database atau belum
        $cek = DB::table('asset_sale')
            ->where('asset_id', $request->asset_id)
            ->where('sale_id', $request->sale_id)
            ->exists();

        if ($cek) {
            return redirect()->route('dashboard.sales.show', $sale_id)->with('error', 'Asset sudah ada di mutasi.');
        }

        $asset->sales()->attach($sale_id); 

        return redirect()->route('dashboard.sales.show', $sale_id)->with('success', 'Asset berhasil ditambahkan ke mutasi.');
    }

    /**
     * Remove an asset from the sale
     */
    public function removeAsset(Request $request)
    {
        $request->validate([
            'asset_id' => 'required',
            'sale_id' => 'required'
        ]);

        $asset = Asset::find($request->asset_id);

        $sale_id = $request->sale_id;

        $asset->sales()->detach($sale_id);

        return redirect()->route('dashboard.sales.show', $sale_id)->with('success', 'Asset berhasil dihapus dari mutasi.');
    }

    /**
     * Bulk add assets to the sale
     */
    public function bulkAddAsset(Request $request)
    {
        $request->validate([
            'asset_ids' => 'required',
            'sale_id' => 'required'
        ]);

        $asset_ids = $request->asset_ids;
        $sale_id = $request->sale_id;

        foreach ($asset_ids as $asset_id) {

            $cek = DB::table('asset_sale')
            ->where('asset_id', $asset_id)
            ->where('sale_id', $sale_id)
            ->exists();

            if ($cek) {
                return redirect()->route('dashboard.sales.show', $sale_id)->with('error', 'Asset sudah ada di mutasi.');
            }

            $asset = Asset::find($asset_id);
            $asset->sales()->attach($sale_id);
        }
        return redirect()->route('dashboard.sales.show', $sale_id)->with('success', 'Asset berhasil ditambahkan ke mutasi.');
    }

    /**
     * Bulk remove assets from the sale
     */
    public function bulkRemoveAsset(Request $request)
    {
        $request->validate([
            'asset_ids' => 'required',
            'sale_id' => 'required'
        ]);

        $asset_ids = $request->asset_ids;
        $sale_id = $request->sale_id;

        foreach ($asset_ids as $asset_id) {
            $asset = Asset::find($asset_id);
            $asset->sales()->detach($sale_id);
        }
        return redirect()->route('dashboard.sales.show', $sale_id)->with('success', 'Asset berhasil dihapus dari mutasi.');
    }

    /**
     * Upload file document
     */
    public function uploadDocument($sale_id, Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);
        
        $file = $request->file('file');

        $filename = time() . '.' . $file->getClientOriginalExtension();

        $file->storeAs('asset/sale', $filename, 'public');

        SaleFile::create([
            'sale_id' => $sale_id,
            'file_name' => $filename,
        ]);

        return redirect()->route('dashboard.sales.show', $sale_id)->with('success', 'File berhasil diunggah.');
    }

    /**
     * Delete file document
     */
    public function deleteDocument($sale_id, $file_id)
    {
        $file = SaleFile::find($file_id);

        // Remove from storage
        Storage::delete('public/asset/sale/' . $file->file_name);

        $file->delete();

        return redirect()->route('dashboard.sales.show', $sale_id)->with('success', 'File berhasil dihapus.');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::all();

        return view("pages.dashboard.companies.index", compact("companies"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $settings = Company::all();
        return view("pages.dashboard.companies.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data yang diterima dari form
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'set_prefix_asset' => 'required|boolean',
            'prefix_asset' => 'nullable|string|max:10',
            'set_prefix_document_asset' => 'required|boolean',
            'prefix_document_asset' => 'nullable|string|max:10',
            'set_prefix_mutation_asset' => 'required|boolean',
            'prefix_mutation_asset' => 'nullable|string|max:10',
            'set_prefix_disposal_asset' => 'required|boolean',
            'prefix_disposal_asset' => 'nullable|string|max:10',
            'logo'     => 'sometimes|mimes:jpg,png,jpeg|max:20000',
        ]);

        // Simpan atau update setting di database
        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'set_prefix_asset' => $request->set_prefix_asset,
            'prefix_asset' => $request->prefix_asset,
            'set_prefix_document_asset' => $request->set_prefix_document_asset,
            'prefix_document_asset' => $request->prefix_document_asset,
            'set_prefix_mutation_asset' => $request->set_prefix_mutation_asset,
            'prefix_mutation_asset' => $request->prefix_mutation_asset,
            'set_prefix_disposal_asset' => $request->set_prefix_disposal_asset,
            'prefix_disposal_asset' => $request->prefix_disposal_asset,
        ];

        $company = Company::create($data);

        // Proses upload logo dan favicon jika ada
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $company->update([
                'logo' => $logoPath
            ]);
        }

        if ($request->hasFile('favicon')) {
            $faviconPath = $request->file('favicon')->store('favicons', 'public');
            $company->update([
                'favicon' => $logoPath
            ]);
        }

        // Redirect kembali ke halaman setting dengan pesan sukses
        return redirect()->route('dashboard.companies.index')->with('success', 'Pengaturan berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        $company = Company::find($company->id);

        return view("pages.dashboard.companies.edit", compact("company"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        // Validasi data yang diterima dari form
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'set_prefix_asset' => 'required|boolean',
            'prefix_asset' => 'nullable|string|max:10',
            'set_prefix_document_asset' => 'required|boolean',
            'prefix_document_asset' => 'nullable|string|max:10',
            'set_prefix_mutation_asset' => 'required|boolean',
            'prefix_mutation_asset' => 'nullable|string|max:10',
            'set_prefix_disposal_asset' => 'required|boolean',
            'prefix_disposal_asset' => 'nullable|string|max:10',
            'logo'     => 'sometimes|mimes:jpg,png,jpeg|max:20000',
        ]);

        // Simpan atau update setting di database
        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'set_prefix_asset' => $request->set_prefix_asset,
            'prefix_asset' => $request->prefix_asset,
            'set_prefix_document_asset' => $request->set_prefix_document_asset,
            'prefix_document_asset' => $request->prefix_document_asset,
            'set_prefix_mutation_asset' => $request->set_prefix_mutation_asset,
            'prefix_mutation_asset' => $request->prefix_mutation_asset,
            'set_prefix_disposal_asset' => $request->set_prefix_disposal_asset,
            'prefix_disposal_asset' => $request->prefix_disposal_asset,
        ];

        $company = Company::find($company->id);

        $company->update($data);

        // Proses upload logo dan favicon jika ada
        if ($request->hasFile('logo')) {

            // hapus logo yang lama
            if ($company->logo) {
                Storage::disk('public')->delete($company->logo);
            }

            $logoPath = $request->file('logo')->store('logos', 'public');
            $company->update([
                'logo' => $logoPath
            ]);
        }

        return redirect()->route('dashboard.companies.index')->with('success', 'Perusahaan berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $company = Company::find($company->id);

        // Cek apakah ada logo, jika ada maka hapus
        if ($company->logo) {
            Storage::disk('public')->delete($company->logo);
        }

        $company->delete();

        return redirect()->route('dashboard.companies.index')->with('success', 'Perusahaan berhasil dihapus.');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->all();

        return view('pages.dashboard.settings.index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data yang diterima dari form
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_description' => 'nullable|string',
            'set_prefix_asset' => 'required|boolean',
            'prefix_asset' => 'nullable|string|max:10',
            'set_prefix_document_asset' => 'required|boolean',
            'prefix_document_asset' => 'nullable|string|max:10',
            'set_prefix_mutation_asset' => 'required|boolean',
            'prefix_mutation_asset' => 'nullable|string|max:10',
            'set_prefix_disposal_asset' => 'required|boolean',
            'prefix_disposal_asset' => 'nullable|string|max:10',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Simpan atau update setting di database
        $settings = [
            'company_name' => $request->company_name,
            'company_description' => $request->company_description,
            'set_prefix_asset' => $request->set_prefix_asset,
            'prefix_asset' => $request->prefix_asset,
            'set_prefix_document_asset' => $request->set_prefix_document_asset,
            'prefix_document_asset' => $request->prefix_document_asset,
            'set_prefix_mutation_asset' => $request->set_prefix_mutation_asset,
            'prefix_mutation_asset' => $request->prefix_mutation_asset,
            'set_prefix_disposal_asset' => $request->set_prefix_disposal_asset,
            'prefix_disposal_asset' => $request->prefix_disposal_asset,
        ];


        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        // Proses upload logo dan favicon jika ada
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            Setting::updateOrCreate(
                ['key' => 'logo'],
                ['value' => $logoPath]
            );
        }

        if ($request->hasFile('favicon')) {
            $faviconPath = $request->file('favicon')->store('favicons', 'public');
            Setting::updateOrCreate(
                ['key' => 'favicon'],
                ['value' => $faviconPath]
            );
        }

        // Redirect kembali ke halaman setting dengan pesan sukses
        return redirect()->back()->with('success', 'Pengaturan berhasil disimpan.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $setting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        //
    }
}

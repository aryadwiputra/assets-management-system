<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetRepairElectronicController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'asset_id'=> 'required',
            'service_name'=> 'required',
            'vendor'=> 'required',
            'quantity'=> 'required',
            'unit'=> 'required',
            'price'=> 'required',
            'date'=> 'required',
        ]);

        $asset = Asset::find($request->asset_id);

        $total = $request->price * $request->quantity;
        $asset->repair_electronic()->create([
            'asset_id'=> $request->asset_id,
            'user_id'=> Auth::user()->id,
            'service_name'=> $request->service_name,
            'vendor'=> $request->vendor,
            'quantity'=> $request->quantity,
            'unit'=> $request->unit,
            'price'=> $request->price,
            'date'=> $request->date,
            'total'=> $total
        ]);
        return redirect()->back()->with('success', 'Data Berhasil Disimpan');
    }

    public function show($id)
    {
        $asset = Asset::find($id);

        $repairCar = $asset->repair_electronic()->find($id);
        if (!$repairCar) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }
    
        return response()->json(['success' => true, 'data' => $repairCar]);
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'asset_id' => 'required',
            'service_name' => 'required',
            'vendor' => 'required',
            'quantity' => 'required',
            'unit' => 'required',
            'price' => 'required',
            'date' => 'required',
        ]);
        
        $asset = Asset::find($id);
    
        $repairCar = $asset->repair_electronic()->find($id);
        if (!$repairCar) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }
    
        $total = $request->price * $request->quantity;
        $repairCar->update([
            'asset_id' => $request->asset_id,
            'user_id' => Auth::user()->id,
            'service_name' => $request->service_name,
            'vendor' => $request->vendor,
            'quantity' => $request->quantity,
            'unit' => $request->unit,
            'price' => $request->price,
            'date' => $request->date,
            'total' => $total
        ]);
    
        return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui']);
    }
}

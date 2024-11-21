<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function detail($asset_id)
    {
        $asset = Asset::with('category', 'company', 'class', 'department', 'employee', 'location', 'person_in_charge', 'project', 'status', 'unit_of_measurement', 'warranty')->find($asset_id);

        return view('pages.main.asset-detail', compact('asset'));
    }
}

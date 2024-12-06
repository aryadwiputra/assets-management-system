<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function detail($slug)
    {
        $asset = Asset::with('category', 'company', 'class', 'department', 'employee', 'location', 'person_in_charge', 'project', 'status', 'unit_of_measurement', 'warranty')
            ->where('slug', $slug)
            ->firstOrFail();

        return view('pages.main.asset-detail', compact('asset'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Spatie\Activitylog\Models\Activity;

class LogActivityController extends Controller
{
    public function index()
    {
        $logs = Activity::all();

        return view('pages.dashboard.log.index', compact('logs'));
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\MutationExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function mutation()
    {
        return view('pages.dashboard.report.mutation');
    }

    public function printMutation(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $start_date = $request->start_date;
        $end_date = $request->end_date;

        return Excel::download(new MutationExport($start_date, $end_date), 'mutation_report.xlsx');
    }
}
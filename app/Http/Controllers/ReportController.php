<?php

namespace App\Http\Controllers;

use App\Exports\BorrowExport;
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

    public function borrow()
    {
        return view('pages.dashboard.report.borrow');
    }

    public function printBorrow(Request $request)
    {
        return Excel::download(new BorrowExport($request->start_date, $request->end_date), 'borrow_report.xlsx');
    }

    public function repair_car()
    {
        return view('pages.dashboard.report.repair_car');
    }

    public function printRepairCar(Request $request)
    {
        return Excel::download(new MutationExport($request->start_date, $request->end_date), 'repair_car_report.xlsx');
    }

    public function repair_electronic()
    {
        return view('pages.dashboard.report.repair_electronic');
    }

    public function printRepairElectronic(Request $request)
    {
        return Excel::download(new MutationExport($request->start_date, $request->end_date), 'repair_electronic_report.xlsx');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Department;
use App\Models\PersonInCharge;
use App\Models\Project;
use Illuminate\Http\Request;

class PersonInChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pics = PersonInCharge::with(['project', 'department'])->get();

        return view('pages.dashboard.person_in_charge.index', compact('pics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::all();
        $projects = Project::all();
        $departments = Department::all();
        return view('pages.dashboard.person_in_charge.create', compact('companies', 'projects', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'project_id' => 'required',
            'department_id' => 'required',
        ]);

        PersonInCharge::create([
            'project_id' => $request->project_id,
            'department_id' => $request->department_id,
            'name' => $request->name,
        ]);

        return redirect()->route('dashboard.person-in-charge.index')->with('success', 'Person in Charge berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PersonInCharge $person_in_charge)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pic = PersonInCharge::find($id);
        $companies = Company::all();
        $projects = Project::all();
        $departments = Department::all();

        return view('pages.dashboard.person_in_charge.edit', compact('pic', 'companies', 'projects', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'project_id' => 'required',
        ]);

        PersonInCharge::find($id)->update([
            'project_id' => $request->project_id,
            'department_id' => $request->department_id,
            'name' => $request->name,
        ]);

        return redirect()->route('dashboard.person-in-charge.index')->with('success', 'Person in Charge berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = PersonInCharge::find($id);

        if ($data) {
            $data->delete();
            return redirect()->route('dashboard.person-in-charge.index')->with('success', 'Person in Charge berhasil dihapus.');
        } else {
            return redirect()->route('dashboard.person-in-charge.index')->with('error', 'Person in Charge gagal dihapus.');
        }
    }
}
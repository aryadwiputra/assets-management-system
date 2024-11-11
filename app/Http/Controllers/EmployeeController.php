<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Project;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $class = Employee::all();

        return view('pages.dashboard.employee.index', compact('class'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::all();
        $companies = Company::all();
        $departments = Department::all();
        return view('pages.dashboard.employee.create', compact('companies','projects','departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required',
            'department_id'=> 'required',
            'name' => 'required|string|max:255',
        ]);

        Employee::create([
            'project_id' => $request->project_id,
            'department_id'=> $request->department_id,
            'name' => $request->name,
        ]);

        return redirect()->route('dashboard.employee.index')->with('success', 'Asset Class berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $Employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $asset = Employee::find($id);
        $companies = Company::all();
        $departments = Department::all();
        $projects = Project::all();

        return view('pages.dashboard.employee.edit', compact('asset','companies','projects','departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'project_id' => 'required',
            'department_id'=> 'required',
            'name' => 'required|string|max:255'
        ]);

        Employee::find($id)->update([
            'project_id'=> $request->project_id,
            'department_id'=> $request->department_id,
            'name' => $request->name,
        ]);

        return redirect()->route('dashboard.employee.index')->with('success', 'Asset Class berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Employee::find($id);

        if ($data) {
            $data->delete();
            return redirect()->route('dashboard.employee.index')->with('success', 'Asset Class berhasil dihapus.');
        } else {
            return redirect()->route('dashboard.employee.index')->with('error', 'Asset Class gagal dihapus.');
        }
    }
}
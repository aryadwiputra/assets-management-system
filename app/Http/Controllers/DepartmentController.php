<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $class = Department::all();

        return view('pages.dashboard.department.index', compact('class'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.dashboard.department.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Department::create([
            'name' => $request->name,
        ]);

        return redirect()->route('dashboard.department.index')->with('success', 'Department berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $Department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $asset = Department::find($id);

        return view('pages.dashboard.department.edit', compact('asset'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Department::find($id)->update([
            'name' => $request->name,
        ]);

        return redirect()->route('dashboard.department.index')->with('success', 'Department berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Department::find($id);

        if ($data) {
            $data->delete();
            return redirect()->route('dashboard.department.index')->with('success', 'Department berhasil dihapus.');
        } else {
            return redirect()->route('dashboard.department.index')->with('error', 'Department gagal dihapus.');
        }
    }
}
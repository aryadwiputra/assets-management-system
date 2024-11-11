<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::with('company')->get();

        return view('pages.dashboard.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::all();
        return view('pages.dashboard.projects.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'company_id' => 'required',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
        ]);

        Project::create([
            'company_id' => $request->company_id,
            'name' => $request->name,
            'description' => $request->description,
            'address' => $request->address,
            'slug' => \Illuminate\Support\Str::slug($request->name),
            'is_active' => $request->is_active
        ]);

        return redirect()->route('dashboard.projects.index')->with('success', 'Project berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $project = Project::find($project->id);
        $companies = Company::all();

        return view("pages.dashboard.projects.edit", compact("project", "companies"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'company_id' => 'required',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
        ]);

        $project->update([
            'company_id' => $request->company_id,
            'name' => $request->name,
            'description' => $request->description,
            'address' => $request->address,
            'slug' => \Illuminate\Support\Str::slug($request->name),
            'is_active' => $request->is_active
        ]);

        return redirect()->route('dashboard.projects.index')->with('success', 'Project berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('dashboard.projects.index')->with('success', 'Project berhasil dihapus.');
    }
}
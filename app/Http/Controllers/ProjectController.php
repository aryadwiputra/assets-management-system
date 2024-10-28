<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::all();

        return view('pages.dashboard.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.dashboard.projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
        ]);

        Project::create([
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

        return view("pages.dashboard.projects.edit", compact("project"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
        ]);

        $project->update([
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
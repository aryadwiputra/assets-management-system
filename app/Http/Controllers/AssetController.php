<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Category;
use App\Models\Classes;
use App\Models\Company;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Location;
use App\Models\PersonInCharge;
use App\Models\Project;
use App\Models\Status;
use App\Models\UnitOfMeasurement;
use App\Models\Warranty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $categories = Category::all("id","name");
        // $companies = Company::all();
        // $classes = Classes::all("id","name");
        // $departments = Department::all("id","name");
        // $employees = Employee::all("id","name");
        // $locations = Location::all("id","name");
        // $person_in_charges = PersonInCharge::all("id","name");
        // $projects = Project::all("id","name");
        // $statuses = Status::all("id","name");
        // $unit_of_measurements = UnitOfMeasurement::all("id","name");
        // $warranties = Warranty::all("id","name");

        $assets = Asset::with(['category', 'company', 'class', 'department', 'employee', 'location', 'person_in_charge', 'project', 'status', 'unit_of_measurement', 'warranty'])->get();

        return view('pages.dashboard.assets.index', compact(
            'assets',
            // 'categories',
            // 'companies',
            // 'classes',
            // 'departments',
            // 'employees',
            // 'locations',
            // 'person_in_charges',
            // 'projects',
            // 'statuses',
            // 'unit_of_measurements',
            // 'warranties',
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all("id","name");
        $companies = Company::all();
        $classes = Classes::all("id","name");
        $departments = Department::all("id","name");
        $employees = Employee::all("id","name");
        $locations = Location::all("id","name");
        $person_in_charges = PersonInCharge::all("id","name");
        $projects = Project::all("id","name");
        $statuses = Status::all("id","name");
        $unit_of_measurements = UnitOfMeasurement::all("id","name");
        $warranties = Warranty::all("id","name");

        return view('pages.dashboard.assets.create', compact(
            'categories',
            'companies',
            'classes',
            'departments',
            'employees',
            'locations',
            'person_in_charges',
            'projects',
            'statuses',
            'unit_of_measurements',
            'warranties',
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'location_id'=> 'required',
            'status_id'=> 'required',
            'pic_id'=> 'required',
            'department_id'=> 'required',
            'class_id'=> 'required',
            'category_id'=> 'required',
            'name'=> 'required',
            'number'=> 'required',
            'price'=> 'required',
            'purchase_date'=> 'required',
            'description' => 'required',
            'thumbnail'=> 'required',
        ]);
        
        $file = $request->file('thumbnail');

        $filename = time().'.'.$file->getClientOriginalExtension();

        // $request->thumbnail->move(public_path('images'), $filename);

        // Storage
        Storage::putFileAs('public', $file, $filename);
        
        Asset::create([
            'category_id' => $request->category_id,
            'company_id' => $request->company_id,
            'class_id' => $request->class_id,
            'department_id'=> $request->department_id,
            'employee_id'=> $request->employee_id,
            'location_id'=> $request->location_id,
            'project_id'=> $request->project_id,
            'status_id'=> $request->status_id,
            'pic_id'=> $request->pic_id,
            'unit_of_measurement_id'=> $request->unit_of_measurement_id,
            'warranty_id'=> $request->warranty_id,
            'number'=> $request->number,
            'name'=> $request->name,
            'serial_number'=> $request->serial_number,
            'slug'=> \Illuminate\Support\Str::slug($request->name),
            'price'=> $request->price,
            'purchase_date'=> $request->purchase_date,
            'origin_of_purchase'=> $request->origin_of_purchase,
            'purchase_number'=> $request->purchase_number,
            'description'=> $request->description,
            'status_information'=> $request->status_information,
            'thumbnail'=> $filename,
        ]);

        return redirect()->route('dashboard.assets.index')->with('success','Asset berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(Asset $asset)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asset $asset)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Asset $asset)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asset $asset)
    {
        // Delete File
        Storage::delete('public/'.$asset->thumbnail);
        $asset->delete();

        return redirect()->route('dashboard.assets.index')->with('success', 'Asset berhasil dihapus.');
    }
}
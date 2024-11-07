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

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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

        return view('pages.dashboard.assets.index', compact(
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
            'thubmnail'=> 'required',
        ]);
        
        $file = $request->file('thumbnail');

        $filename = time().'.'.$file->getClientOriginalExtension();

        $request->thumbnail->move(public_path('images'), $filename);
        
        Asset::create([
            'category_id' => $request->category_id,
            'company_id' => $request->company_id,
            'class_id' => $request->class_id,
            'department_id'=> $request->class_id,
            'employee_id'=> $request->class_id,
            'location_id'=> $request->class_id,
            'project_id'=> $request->class_id,
            'status_id'=> $request->class_id,
            'pic_id'=> $request->class_id,
            'unit_of_measurement_id'=> $request->class_id,
            'warranty_id'=> $request->class_id,
            'number'=> $request->class_id,
            'name'=> $request->class_id,
            'serial_number'=> $request->class_id,
            'slug'=> $request->class_id,
            'price'=> $request->class_id,
            'purchase_date'=> $request->class_id,
            'origin_of_purchase'=> $request->class_id,
            'purchase_number'=> $request->class_id,
            'description'=> $request->class_id,
            'status_information'=> $request->class_id,
            'thumbnail'=> $request->class_id,
        ]);
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
        //
    }
}
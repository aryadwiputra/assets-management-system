<?php

namespace App\Http\Controllers;

use App\Imports\AssetImport;
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
use Maatwebsite\Excel\Facades\Excel;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assets = Asset::with(['category', 'company', 'class', 'department', 'employee', 'location', 'person_in_charge', 'project', 'status', 'unit_of_measurement', 'warranty'])->get();

        return view('pages.dashboard.assets.index', compact(
            'assets',
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all("id", "name");
        $companies = Company::all();
        $classes = Classes::all("id", "name", "from", "to");
        $departments = Department::all("id", "name");
        $employees = Employee::all("id", "name");
        $locations = Location::all("id", "name");
        $person_in_charges = PersonInCharge::all("id", "name");
        $projects = Project::all("id", "name");
        $statuses = Status::all("id", "name");
        $unit_of_measurements = UnitOfMeasurement::all("id", "name");
        $warranties = Warranty::all("id", "name");

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
            'location_id' => 'required',
            'status_id' => 'required',
            'pic_id' => 'required',
            'department_id' => 'required',
            'category_id' => 'required',
            'name' => 'required',
            'price' => 'required',
            'purchase_date' => 'required',
            'description' => 'required',
            'thumbnail' => 'required',
        ]);

        // Generate a unique slug
        $slug = $request->name . '-' .  \Illuminate\Support\Str::random(6);

        // Check if the slug already exists
        while (Asset::where('slug', $slug)->exists()) {
            // Generate a new random slug if it already exists
            $slug = $request->name . '-' . \Illuminate\Support\Str::random(6);
        }

        $classes = Classes::all('id', 'from', 'to');

        // pengecekan apakah price berada between dari seluruh data $classes
        foreach ($classes as $class) {
            if ($request->price >= $class->from && $request->price <= $class->to) {
                $class_id = $class->id;
                break;
            } else {
                return back()->with('error', 'Harga tidak sesuai dengan Asset Class')->withInput();
            }
        }

        $file = $request->file('thumbnail');

        $filename = time() . '.' . $file->getClientOriginalExtension();

        $file->storeAs('asset/thumbnails', $filename, 'public');

        $prefix = Company::find($request->company_id)->prefix_asset;

        Asset::create([
            'category_id' => $request->category_id,
            'company_id' => $request->company_id,
            'class_id' => $class_id,
            'department_id' => $request->department_id,
            'employee_id' => $request->employee_id,
            'location_id' => $request->location_id,
            'project_id' => $request->project_id,
            'status_id' => $request->status_id,
            'pic_id' => $request->pic_id,
            'unit_of_measurement_id' => $request->unit_of_measurement_id,
            'warranty_id' => $request->warranty_id,
            'number' => $prefix . $request->number,
            'name' => $request->name,
            'serial_number' => $request->serial_number,
            'slug' =>$slug,
            'price' => $request->price,
            'purchase_date' => $request->purchase_date,
            'origin_of_purchase' => $request->origin_of_purchase,
            'purchase_number' => $request->purchase_number,
            'description' => $request->description,
            'status_information' => $request->status_information,
            'thumbnail' => $filename,
        ]);

        return redirect()->route('dashboard.assets.index')->with('success', 'Asset berhasil dibuat');
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
        $categories = Category::all("id", "name");
        $companies = Company::all();
        $classes = Classes::all("id", "name", "from", "to");
        $departments = Department::all("id", "name");
        $employees = Employee::all("id", "name");
        $locations = Location::all("id", "name");
        $person_in_charges = PersonInCharge::all("id", "name");
        $projects = Project::all("id", "name");
        $statuses = Status::all("id", "name");
        $unit_of_measurements = UnitOfMeasurement::all("id", "name");
        $warranties = Warranty::all("id", "name");

        $asset->load('category', 'company', 'class', 'department', 'employee', 'location', 'person_in_charge', 'project', 'status', 'unit_of_measurement', 'warranty');

        // Buang prefix pada asset number
        $asset->number = str_replace($asset->prefix, '', $asset->number);

        return view('pages.dashboard.assets.edit', compact(
            'asset',
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, Asset $asset)
    {
        $request->validate([
            'location_id' => 'required',
            'status_id' => 'required',
            'pic_id' => 'required',
            'department_id' => 'required',
            'category_id' => 'required',
            'name' => 'required',
            'price' => 'required',
            'purchase_date' => 'required',
            'description' => 'required',
        ]);

        // Generate a unique slug
        $slug = $request->name . '-' .  \Illuminate\Support\Str::random(6);

        // Check if the slug already exists
        while (Asset::where('slug', $slug)->exists()) {
            // Generate a new random slug if it already exists
            $slug = $request->name . '-' . \Illuminate\Support\Str::random(6);
        }

        $classes = Classes::all('id', 'from', 'to');

        // pengecekan apakah price berada between dari seluruh data $classes
        foreach ($classes as $class) {
            if ($request->price >= $class->from && $request->price <= $class->to) {
                $class_id = $class->id;
                break;
            } else {
                return back()->with('error', 'Harga tidak sesuai dengan Asset Class')->withInput();
            }
        }

        if( $request->hasFile('thumbnail') ) {
            Storage::disk('public')->delete('asset/thumbnails/'.$asset->thumbnail);

            $file = $request->file('thumbnail');

            $filename = time().'.'.$file->getClientOriginalExtension();
            
            $file->storeAs('asset/thumbnails', $filename, 'public');

            $asset->update([
                'thumbnail' => $filename,
            ]);
        }

        $prefix = Company::find($request->company_id)->prefix_asset;

        $asset->update([
            'category_id' => $request->category_id,
            'company_id' => $request->company_id,
            'class_id' => $class_id,
            'department_id' => $request->department_id,
            'employee_id' => $request->employee_id,
            'location_id' => $request->location_id,
            'project_id' => $request->project_id,
            'status_id' => $request->status_id,
            'pic_id' => $request->pic_id,
            'unit_of_measurement_id' => $request->unit_of_measurement_id,
            'warranty_id' => $request->warranty_id,
            'name' => $request->name,
            'number' => $prefix . $request->number,
            'serial_number' => $request->serial_number,
            'slug' => $slug,
            'price' => $request->price,
            'purchase_date' => $request->purchase_date,
            'origin_of_purchase' => $request->origin_of_purchase,
            'purchase_number' => $request->purchase_number,
            'description' => $request->description,
            'status_information' => $request->status_information,
            'thumbnail' => $asset->thumbnail
        ]);

        return redirect()->route('dashboard.assets.index')->with('success', 'Asset berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asset $asset)
    {
        // Delete File
        Storage::delete('public/' . $asset->thumbnail);
        $asset->delete();

        return redirect()->route('dashboard.assets.index')->with('success', 'Asset berhasil dihapus.');
    }

    /**
     * Import data from excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:2048',
        ]);

        $file = $request->file('file');
        try {
            Excel::import(new AssetImport, $file);
            return redirect()->back()->with('success', 'Data aset berhasil diimpor.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengimpor data aset.');
        }
        // $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($request->file('file'));

        // $worksheet = $spreadsheet->getActiveSheet();
        // $worksheetArray = $worksheet->toArray();
        // array_shift($worksheetArray);

        // echo '<table style="width:100%"  border="1">';
        // echo '<tr align="center">';
        // echo '<td>Sno</td>';
        // echo '<td>Name</td>';
        // echo '<td>Image</td>';
        // echo '</tr>';

        // foreach ($worksheetArray as $key => $value) {

        //     $worksheet = $spreadsheet->getActiveSheet();
        //     $drawing = $worksheet->getDrawingCollection()[$key];

        //     $zipReader = fopen($drawing->getPath(), 'r');
        //     $imageContents = '';
        //     while (!feof($zipReader)) {
        //         $imageContents .= fread($zipReader, 1024);
        //     }
        //     fclose($zipReader);
        //     $extension = $drawing->getExtension();

        //     echo '<tr align="center">';
        //     echo '<td>' . $value[0] . '</td>';
        //     echo '<td>' . $value[1] . '</td>';
        //     echo '<td><img  height="150px" width="150px"   src="data:image/jpeg;base64,' . base64_encode($imageContents) . '"/></td>';
        //     echo '</tr>';

        // }
    }
}
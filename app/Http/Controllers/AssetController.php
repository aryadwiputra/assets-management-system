<?php

namespace App\Http\Controllers;

use App\Imports\AssetImport;
use App\Models\Asset;
use App\Models\AssetHistory;
use App\Models\AssetPhoto;
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
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assets = Asset::with(['category', 'company', 'class', 'department', 'employee', 'location', 'person_in_charge', 'project', 'status', 'unit_of_measurement', 'warranty'])->get();

        $locations = Location::all();
        $pics = PersonInCharge::all();
        $employees = Employee::all();

        return view('pages.dashboard.assets.index', compact(
            'assets',
            'locations',
            'pics',
            'employees'
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
        $slug = Str::slug($request->name) . '-' .  \Illuminate\Support\Str::random(6);

        // Check if the slug already exists
        while (Asset::where('slug', $slug)->exists()) {
            // Generate a new random slug if it already exists
            $slug = Str::slug($request->name) . '-' . \Illuminate\Support\Str::random(6);
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

        $thumbnailPath = 'asset/thumbnails/' . $filename;

        $file->storeAs('asset/thumbnails', $filename, 'public');

        $prefix = Company::find($request->company_id)->prefix_asset;

        $asset = Asset::create([
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
            'erp_number' => $request->erp_number,
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
            'thumbnail' => $thumbnailPath,
        ]);

        // Foreach photos
        if($asset)
        {
            if($request->photos)
            {
                foreach ($request->photos as $photo) {
                    // Save photos to storage
                    $filename = time() . '-' . $asset->name . '-' . \Illuminate\Support\Str::random(6) . '.' . $photo->getClientOriginalExtension();

                    $photo->storeAs('asset/photos', $filename, 'public');

                    $asset->photos()->create([
                        'photo' => $filename
                    ]);
                }
            }

            // QR Code
            $qr = QrCode::format('png')->generate(route('assets.detail', $slug));
            $qrImageName = $slug . ".png";

            Storage::disk('public')->put('asset/qr/' . $qrImageName, $qr);
        }

        return redirect()->route('dashboard.assets.index')->with('success', 'Asset berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(Asset $asset)
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

        return view('pages.dashboard.assets.show', compact(
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
        $slug = Str::slug($request->name) . '-' .  \Illuminate\Support\Str::random(6);

        // Check if the slug already exists
        while (Asset::where('slug', $slug)->exists()) {
            // Generate a new random slug if it already exists
            $slug = Str::slug($request->name) . '-' . \Illuminate\Support\Str::random(6);
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

        // Delete QR Code
        Storage::disk('public')->delete('asset/qr/' . $asset->slug . ".png");

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
            'erp_number' => $request->erp_number,
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

        if($request->photos)
        {
            foreach ($request->photos as $photo) {
                // Save photos to storage
                $filename = time() . '-' . $asset->name . '-' . \Illuminate\Support\Str::random(6) . '.' . $photo->getClientOriginalExtension();

                $photo->storeAs('asset/photos', $filename, 'public');

                $asset->photos()->create([
                    'photo' => $filename
                ]);
            }
        }

        // Insert New QR Code
        $qr = QrCode::format('png')->generate(route('assets.detail', $slug));

        $qrImageName = $slug . ".png";

        Storage::disk('public')->put('asset/qr/' . $qrImageName, $qr);

        return redirect()->route('dashboard.assets.index')->with('success', 'Asset berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asset $asset)
    {
        // Delete File
        Storage::delete('public/' . $asset->thumbnail);        
        // Delete QR Code
        Storage::disk('public')->delete('asset/qr/' . $asset->slug . ".png");
        $asset->delete();

        return redirect()->route('dashboard.assets.index')->with('success', 'Asset berhasil dihapus.');
    }

    /**
     * Riwayat mutasi dari asset
     */
    public function mutation(Asset $asset)
    {
        // Ambil riwayat mutasi aset
        $mutations = $asset->mutations()->orderBy('created_at', 'desc')->get();

        return view('pages.dashboard.assets.mutation', compact('asset', 'mutations'));
    }
    
    /**
     * Delete photo
     */
    public function deletePhoto()
    {
        $photo_id = request('id');

        $photo = AssetPhoto::find($photo_id);

        // Delete photo
        Storage::disk('public')->delete('asset/photos/' . $photo->photo);

        // Delete photo
        $photo->delete();

        return response()->json(['success' => 'Photo deleted successfully.']);
    }
    /**
     * Import data from excel
     */
    public function import(Request $request)
    {
        // Validate the file
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:2048',
        ]);

        $file = $request->file('file');
        try {
            // Load the Excel file
            $spreadsheet = IOFactory::load($file);
            $worksheet = $spreadsheet->getActiveSheet();
            $worksheetArray = $worksheet->toArray();
            array_shift($worksheetArray);

            foreach ($worksheetArray as $key => $value) {
                // Skip empty rows
                if (empty($value[0])) {
                    continue;
                }
                $drawing = $worksheet->getDrawingCollection()[$key];

                $thumbnailPath = null;
                $thumbnailExtension = null;

                if ($drawing) {
                    $zipReader = fopen($drawing->getPath(), 'r');
                    $imageContents = '';
                    while (!feof($zipReader)) {
                        $imageContents .= fread($zipReader, 1024);
                    }
                    fclose($zipReader);
                    $thumbnailExtension = $drawing->getExtension();

                    // Generate a unique filename
                    $filename = 'thumbnail_' . time() . '.' . $thumbnailExtension;
                    $thumbnailPath = "asset/thumbnails/{$filename}";

                    // Save the image to the server
                    Storage::disk('public')->put($thumbnailPath, $imageContents);

                    // Log the result of the save operation
                    if (Storage::disk('public')->exists($thumbnailPath)) {
                        Log::info("Thumbnail saved successfully: " . $thumbnailPath);
                    } else {
                        Log::error("Failed to save thumbnail: " . $thumbnailPath);
                    }
                }

                 // Generate a unique slug
                $slug = Str::slug(isset($value[12]) ? $value[12] : null) . '-' .  \Illuminate\Support\Str::random(6);

                // Check if the slug already exists
                while (Asset::where('slug', $slug)->exists()) {
                    // Generate a new random slug if it already exists
                    $slug = Str::slug(isset($value[12]) ? $value[12] : null) . '-' . \Illuminate\Support\Str::random(6);
                }

                // Ensure all required keys are set
                $data = [
                    'company_id' => isset($value[0]) ? $value[0] : null,
                    'category_id' => isset($value[1]) ? $value[1] : null,
                    'class_id' => isset($value[2]) ? $value[2] : null,
                    'department_id' => isset($value[3]) ? $value[3] : null,
                    'employee_id' => isset($value[4]) ? $value[4] : null,
                    'location_id' => isset($value[5]) ? $value[5] : null,
                    'project_id' => isset($value[6]) ? $value[6] : null,
                    'status_id' => isset($value[7]) ? $value[7] : null,
                    'pic_id' => isset($value[8]) ? $value[8] : null,
                    'unit_of_measurement_id' => isset($value[9]) ? $value[9] : null,
                    'warranty_id' => isset($value[10]) ? $value[10] : null,
                    'erp_number' => isset($value[11]) ? $value[11] : null,
                    'number' => isset($value[12]) ? $value[12] : null,
                    'name' => isset($value[13]) ? $value[13] : null,
                    'serial_number' => isset($value[14]) ? $value[14] : null,
                    'slug' => $slug,
                    'price' => isset($value[16]) ? $value[16] : null,
                    'purchase_date' => isset($value[17]) ? $this->convertExcelDate($value[17]) : null,
                    'origin_of_purchase' => isset($value[18]) ? $value[18] : null,
                    'purchase_number' => isset($value[19]) ? $value[19] : null,
                    'description' => isset($value[20]) ? $value[20] : null,
                    'status_information' => isset($value[21]) ? $value[21] : null,
                    'thumbnail' => $thumbnailPath,
                    'thumbnail_extension' => $thumbnailExtension,
                    'thumbnail_path' => $thumbnailPath,
                    'created_at' => now(),
                    'updated_at' => now()
                ];

                // Insert into database
                DB::table('assets')->insert($data);

                // QR Code
                $qr = QrCode::format('png')->generate(route('assets.detail', $slug));
                $qrImageName = $slug . ".png";

                Storage::disk('public')->put('asset/qr/' . $qrImageName, $qr);
            }

            return redirect()->back()->with('success', 'Data aset berhasil diimpor.');
        } catch (\Exception $e) {
            Log::error("Error importing assets: " . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengimpor data aset.');
        }
    }

    private function convertExcelDate($excelDate)
    {
        if (is_numeric($excelDate)) {
            // Excel date starts from 1900-01-01, but Excel has a bug where it treats 1900 as a leap year
            // So, we need to subtract 2 days to correct for this
            $startDate = Carbon::create(1900, 1, 1);
            return $startDate->addDays($excelDate - 2)->format('Y-m-d');
        } elseif (is_string($excelDate)) {
            // Try to parse the date string
            $date = Carbon::createFromFormat('m/d/Y', $excelDate);
            if ($date) {
                return $date->format('Y-m-d');
            }
            // Fallback to default format
            $date = Carbon::createFromFormat('Y-m-d', $excelDate);
            if ($date) {
                return $date->format('Y-m-d');
            }
        }
        return null;
    }

    public function printQR(Request $request)
    {
        $ids = $request->query('ids');
        $assets = Asset::whereIn('id', explode(',', $ids))->get();

        // Debugging: Cek path gambar
        foreach ($assets as $asset) {
            Log::info('QR Code Path: ' . url('storage/asset/qr/' . $asset->slug . '.png'));
        }

        $pdf = Pdf::loadView('pages.dashboard.assets.qr', compact('assets'));
        return $pdf->download('qr-codes-' . date('Y-m-d -H-i-s') . '.pdf');
    }
}
<?php

namespace App\Imports;

use App\Models\Asset;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;

class AssetImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // 
        $thumbnail = $row['thumbnail'];

        $thumbnailPath = null;
        if ($thumbnail) {
            $fileContents = base64_decode($thumbnail); // Jika base64, decode ke binary
            $fileName = 'thumbnail_' . time() . '.jpg';
            $thumbnailPath = "asset/thumbnails/{$fileName}";
            Storage::put($thumbnailPath, $fileContents);
        }

        return new Asset([
            'company_id' => $row['company_id'],
            'category_id' => $row['category_id'],
            'class_id' => $row['class_id'],
            'department_id' => $row['department_id'],
            'employee_id' => $row['employee_id'],
            'location_id' => $row['location_id'],
            'project_id' => $row['project_id'],
            'status_id' => $row['status_id'],
            'pic_id' => $row['pic_id'],
            'unit_of_measurement_id' => $row['unit_of_measurement_id'],
            'warranty_id' => $row['warranty_id'],
            'number' => $row['number'],
            'name' => $row['name'],
            'serial_number' => $row['serial_number'],
            'slug' => $row['slug'],
            'price' => $row['price'],
            'purchase_date' => $this->convertExcelDate($row['purchase_date']),
            'origin_of_purchase' => $row['origin_of_purchase'],
            'purchase_number' => $row['purchase_number'],
            'description' => $row['description'],
            'status_information' => $row['status_information'],
            'thumbnail' => $thumbnailPath
        ]);
    }

    private function handleThumbnail($thumbnailPath)
    {
        if ($thumbnailPath) {
            try {
                // Assuming the path is a URL or a local path to the image
                $contents = file_get_contents($thumbnailPath);
                if ($contents === false) {
                    Log::error("Failed to download thumbnail from: $thumbnailPath");
                    return null;
                }
                $path = Storage::put('assets/thumbnails', $contents);
                return $path;
            } catch (\Exception $e) {
                Log::error("Error handling thumbnail: " . $e->getMessage());
                return null;
            }
        }
        return null;
    }

    private function convertExcelDate($excelDate)
    {
        if (is_numeric($excelDate)) {
            // Excel date starts from 1900-01-01, but Excel has a bug where it treats 1900 as a leap year
            // So, we need to subtract 2 days to correct for this
            $startDate = Carbon::create(1900, 1, 1);
            return $startDate->addDays($excelDate - 2)->format('Y-m-d');
        }
        return $excelDate;
    }
}
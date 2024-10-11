<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LogController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // Path to the log file
        $logFile = storage_path('logs/laravel.log');

        // Baca file log
        $logs = [];
        if (File::exists($logFile)) {
            $logContent = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            // Proses setiap baris log
            foreach ($logContent as $log) {
                // Memeriksa status log
                if (strpos($log, 'ERROR') !== false) {
                    $status = 'ERROR';
                } elseif (strpos($log, 'WARNING') !== false) {
                    $status = 'WARNING';
                } elseif (strpos($log, 'INFO') !== false) {
                    $status = 'INFO';
                } else {
                    $status = 'UNKNOWN'; // Jika tidak sesuai dengan status umum
                }

                // Simpan log beserta statusnya ke dalam array
                $logs[] = [
                    'status' => $status,
                    'message' => $log
                ];
            }
        }

        return view('pages.dashboard.logs.index', compact('logs'));
    }
}

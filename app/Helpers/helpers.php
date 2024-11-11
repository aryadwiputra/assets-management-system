<?php

if (!function_exists('generate_breadcrumb')) {
    function generate_breadcrumb($route)
    {
        switch ($route) {
            case 'dashboard':
                return [
                    ['url' => route('dashboard'), 'label' => 'Dashboard'],
                ];

            case 'users.index':
                return [
                    ['url' => route('dashboard'), 'label' => 'Dashboard'],
                    ['url' => route('users.index'), 'label' => 'Users'],
                ];
            case 'users.create':
                return [
                    ['url' => route('users.index'), 'label' => 'Users'],
                    ['url' => route('users.create'), 'label' => 'Create'],
                ];
            default:
                return [
                    ['url' => route('dashboard'), 'label' => 'Dashboard'],
                ];
        }
    }
}

if (!function_exists('get_setting')) {
    function get_setting($key)
    {
        $setting = \App\Models\Setting::where('key', $key)->first();
        return $setting->value;
    }
}

if(!function_exists('format_rupiah')){ 
    function formatRupiah($number)
    {
        return "Rp " . number_format($number, 0, ',', '.');
        
    }
}
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

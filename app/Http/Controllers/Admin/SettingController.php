<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function index()
    {
        $app_name = config('app.name');
        $app_version = '1.0';
        $laravel_version = app()->version();
        $php_version = PHP_VERSION;

        return view('admin.settings.index', ['app_name' => $app_name, 'app_version' => $app_version, 'laravel_version' => $laravel_version, 'php_version' => $php_version]);
    }
}

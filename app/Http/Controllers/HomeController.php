<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $column = 'order';
        $features = Feature::query()->orderBy($column)->get();
        return view('beranda', ['features' => $features]);
    }
}

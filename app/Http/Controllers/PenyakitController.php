<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataPenyakit;

class PenyakitController extends Controller
{
    public function index()
    {
        $data = DataPenyakit::all(); 
        return view('menu-gibran', compact('data'));
    }
}
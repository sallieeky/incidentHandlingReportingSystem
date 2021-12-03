<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use App\Models\Wilayah;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $wilayah = Wilayah::all();
        $instansi = Instansi::orderBy("jumlah_penanganan", 'DESC')->get();
        return view('dashboard', compact('wilayah', 'instansi'));
    }
}

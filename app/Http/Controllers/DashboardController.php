<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\Instansi;
use App\Models\Jenis;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Wilayah;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function login()
    {
        return view('login');
    }
    public function loginPost(Request $request)
    {
        $request->validate([
            "username" => "required",
            'password' => 'required'
        ]);
        $credentials = $request->only('username', 'password');
        if (auth()->attempt($credentials)) {
            return redirect("/");
        }
        return redirect()->back()->with('error', 'username atau password salah');
    }

    public function dashboard()
    {
        $wilayah = Wilayah::all();
        $incident = Incident::all();

        $instansi = Instansi::with("incident")->withCount('incident')->orderBy('incident_count', 'desc')->orderBy('incident_count', 'desc')->get();
        foreach ($instansi as $key => $value) {
            $instansi[$key]->mean_time = round($value->incident->avg('lama_penanganan'), 2);
        }

        $jenis = Jenis::with("incident")->withCount('incident')->orderBy('incident_count', 'desc')->get();
        foreach ($jenis as $key => $value) {
            $jenis[$key]->mean_time = round($value->incident->avg('lama_penanganan'), 2);
        }
        $kecamatan = Kecamatan::withCount('incident')->orderBy('incident_count', 'desc')->with(['kelurahan' => function ($query) {
            $query->withCount('incident')->orderBy('incident_count', 'desc');
        }])->get();
        $kelurahan = Kelurahan::where("kecamatan_id", $kecamatan->first()->id)->withCount('incident')->orderBy('incident_count', 'desc')->get();
        return view('dashboard', compact('wilayah', 'instansi', 'incident', 'jenis', 'kecamatan', 'kelurahan'));
    }

    public function kelolaLaporan()
    {
        $instansi = Instansi::all();
        $kecamatan = Kecamatan::all();
        $kelurahan = Kelurahan::where("kecamatan_id", 1)->get();
        $jenis = Jenis::all();

        $incident = Incident::all();
        return view('laporan', compact('instansi', 'kecamatan', 'kelurahan', 'jenis', 'incident'));
    }

    public function tambahLaporan(Request $request)
    {
        $request->validate([
            "instansi_id" => "required",
            "kecamatan_id" => "required",
            "kelurahan_id" => "required",
            "jenis_id" => "required",
            "lat" => "required",
            "lng" => "required",
            "waktu_kejadian" => "required",
            'waktu_penanganan' => 'required'
        ], [
            "instansi_id.required" => "Instansi harus diisi",
            "kecamatan_id.required" => "Kecamatan harus diisi",
            "kelurahan_id.required" => "Kelurahan harus diisi",
            "jenis.required" => "Jenis harus diisi",
            "lat.required" => "Latitude dan Longitude harus diisi",
            "waktu_kejadian.required" => "Waktu kejadian harus diisi",
            "waktu_penanganan.required" => "Waktu penanganan harus diisi",
        ]);
        Incident::create($request->all());
        return back()->with('success', 'Laporan berhasil ditambahkan');
    }

    public function hapusLaporan(Request $request)
    {
        Incident::find($request->id)->delete();
        return back()->with('success', 'Laporan berhasil dihapus');
    }
}

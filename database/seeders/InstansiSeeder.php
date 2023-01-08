<?php

namespace Database\Seeders;

use App\Models\Instansi;
use Illuminate\Database\Seeder;

class InstansiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Buat list nama instansi/dinas dispatcher yang ada di manokwari
        $instansi = [
            "Dinas Pendidikan",
            "Dinas Sosial",
            "Dinas Pekerjaan Umum",
            "Dinas Pemberdayaan Masyarakat dan Kampung",
            "Dinas Penanaman Modal",
            "Dinas Kesehatan",
            "Dinas Tenaga Kerja dan Transmigrasi",
            "Dinas Pemberdayaan Perempuan dan Perlindungan Anak",
            "Dinas Perhubungan",
            "Dinas Kelautan dan Perikanan",
            "Dinas Kehutanan",
            "Dinas Pertanian dan Ketahanan Pangan",
            "Dinas Lingkungan Hidup dan Pertanahan",
        ];

        // Looping untuk membuat data instansi
        foreach ($instansi as $key => $value) {
            Instansi::create([
                "nama" => $value,
                "alamat" => "Jl. Raya Manokwari No. 1",
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(WilayahSeeder::class);
        $this->call(InstansiSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(KecamatanSeeder::class);
        $this->call(KelurahanSeeder::class);
        $this->call(JenisSeeder::class);
        $this->call(IncidentSeeder::class);
    }
}

<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HalamanUtamaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * @return void
     */
    public function run()
    {
        DB::table('halamanutama')->insert([
            'id_halamanutama' => 1,
            'headline' => 'Selamat Datang di Website Saya',
        ]);
    }
}

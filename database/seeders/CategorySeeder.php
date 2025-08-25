<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            ['id' => 20, 'name' => 'Energi', 'slug' => 'energi'],
            ['id' => 24, 'name' => 'Berita', 'slug' => 'berita'],
            ['id' => 25, 'name' => 'Ketenagalistrikan', 'slug' => 'ketenagalistrikan'],
            ['id' => 28, 'name' => 'Pengusahaan Minerba', 'slug' => 'pengusahaan-minerba'],
            ['id' => 29, 'name' => 'Teknik dan Penerimaan Minerba', 'slug' => 'teknik-dan-penerimaan-minerba'],
            ['id' => 31, 'name' => 'Geolab', 'slug' => 'geolab'],
            ['id' => 33, 'name' => 'Edukasi', 'slug' => 'edukasi'],
        ]);
    }
}
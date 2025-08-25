<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            [
                'id' => 1,
                'key' => 'app_name',
                'value' => 'Web Portal Dinas ESDM Sumsel',
                'created_at' => '2025-08-06 15:44:13',
                'updated_at' => '2025-08-06 15:44:13',
            ],
            [
                'id' => 2,
                'key' => 'alamat_kantor',
                'value' => 'Jalan Angkatan 45 No. 2440, Kelurahan Demang Lebar Daun, Kecamatan Ilir Barat I, Palembang - 30137',
                'created_at' => '2025-08-06 15:44:13',
                'updated_at' => '2025-08-06 16:12:41',
            ],
            [
                'id' => 3,
                'key' => 'email_kontak',
                'value' => 'desdm.sumselprov@gmail.com',
                'created_at' => '2025-08-06 15:44:13',
                'updated_at' => '2025-08-06 15:47:13',
            ],
            [
                'id' => 4,
                'key' => 'telp_kontak',
                'value' => '0711-379040',
                'created_at' => '2025-08-06 15:44:13',
                'updated_at' => '2025-08-06 16:51:28',
            ],
            [
                'id' => 5,
                'key' => 'facebook_url',
                'value' => 'http://www.facebook.com/desdm.sumsel.16',
                'created_at' => '2025-08-06 15:44:13',
                'updated_at' => '2025-08-06 15:44:13',
            ],
            [
                'id' => 6,
                'key' => 'twitter_url',
                'value' => 'https://twitter.com/desdm_sumsel',
                'created_at' => '2025-08-06 15:44:13',
                'updated_at' => '2025-08-06 15:44:13',
            ],
            [
                'id' => 7,
                'key' => 'instagram_url',
                'value' => 'https://instagram.com/desdm.sumselprov',
                'created_at' => '2025-08-06 15:44:13',
                'updated_at' => '2025-08-06 15:44:13',
            ],
            [
                'id' => 8,
                'key' => 'youtube_url',
                'value' => 'https://www.youtube.com/channel/UCwKZOLdzXtcmLsh4eFGvm8A',
                'created_at' => '2025-08-06 15:52:22',
                'updated_at' => '2025-08-06 15:52:22',
            ],
            [
                'id' => 9,
                'key' => 'app_logo',
                'value' => 'images/settings/logo.png',
                'created_at' => '2025-08-06 16:40:49',
                'updated_at' => '2025-08-06 16:40:49',
            ],
            [
                'id' => 10,
                'key' => 'app_favicon',
                'value' => 'images/settings/favicon.png',
                'created_at' => '2025-08-06 16:40:49',
                'updated_at' => '2025-08-06 16:40:49',
            ],
            [
                'id' => 11,
                'key' => 'visitors',
                'value' => '1980',
                'created_at' => '2025-08-10 05:11:45',
                'updated_at' => '2025-08-25 16:07:53',
            ],
        ]);
    }
}
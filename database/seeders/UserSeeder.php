<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'Superman',
                'role' => 'super_admin',
                'email' => 'k8ten.effo@gmail.com',
                'telp' => null,
                'alamat' => null,
                'email_verified_at' => '2025-07-24 13:00:40',
                'password' => '$2y$12$tyvQw6oOQLdaDwqr1e4Gy.2M7uCH4FWgm.RIChCt4JXfYOeTiwWEG',
                'remember_token' => null,
                'created_at' => '2025-07-24 13:00:40',
                'updated_at' => '2025-08-24 16:09:30',
            ],
            [
                'id' => 2,
                'name' => 'Admin PPID',
                'role' => 'ppid_admin',
                'email' => 'tim.desdm.2021@gmail.com',
                'telp' => null,
                'alamat' => null,
                'email_verified_at' => '2025-08-13 17:33:52',
                'password' => '$2y$12$L.ddlovAb.CTjUcCgVoHi.kuM610mokyUQGoGAlgayAYd4hVzqQOS',
                'remember_token' => null,
                'created_at' => '2025-07-28 02:06:41',
                'updated_at' => '2025-08-24 16:10:05',
            ],
            [
                'id' => 4,
                'name' => 'Admin Berita',
                'role' => 'editor',
                'email' => 'k8ten.effo0@gmail.com',
                'telp' => null,
                'alamat' => null,
                'email_verified_at' => '2025-08-13 17:25:40',
                'password' => '$2y$12$nIGcmoj8vdiuDLxp.9AUHe7vUTFbK4WknVRFaF.NI2Zc5.7g4Z5P2',
                'remember_token' => null,
                'created_at' => '2025-08-10 14:27:27',
                'updated_at' => '2025-08-24 16:12:35',
            ],
        ]);
    }
}
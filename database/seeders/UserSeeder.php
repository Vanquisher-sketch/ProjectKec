<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin simdawani',
            'email' => 'admin@gmail.com',
            'password' => 'password',
            'status' => 'approved',
            'role_id' => '1', // =>'Admin'
        ]);

        User::create([
            'name' => 'kecamatan tawang',
            'email' => 'tawang@gmail.com',
            'password' => 'tawanghebat',
            'status' => 'approved',
            'role_id' => '2', // =>'Kecamatan'
        ]);

        User::create([
            'name' => 'Kelurahan',
            'email' => 'kelurahan@gmail.com',
            'password' => 'password',
            'status' => 'approved',
            'role_id' => '3', // =>'Kelurahan'
        ]);

        User::create([
            'name' => 'Rukun Wareg',
            'email' => 'rw@gmail.com',
            'password' => 'rwmadep',
            'status' => 'approved',
            'role_id' => '4', // =>'RW'
        ]);

         User::create([
            'name' => 'Rukun Tentangga',
            'email' => 'rt@gmail.com',
            'password' => 'rtcemerlang',
            'status' => 'approved',
            'role_id' => '5', // =>'Admin'
        ]);
    }
}

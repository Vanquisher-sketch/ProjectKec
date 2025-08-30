<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kosongkan tabel dulu agar tidak ada duplikasi jika dijalankan ulang
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Role::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Biarkan database menentukan ID secara otomatis
        // Gunakan nama dalam format UPPERCASE agar konsisten dengan UserSeeder

        // 1. Peran untuk Super Admin / Developer
        Role::create(['name' => 'SUPERADMIN']);

        // 2. Peran untuk hierarki wilayah
        Role::create(['name' => 'KECAMATAN']);
        Role::create(['name' => 'KELURAHAN']);
        Role::create(['name' => 'RW']);
        Role::create(['name' => 'RT']);
    }
}

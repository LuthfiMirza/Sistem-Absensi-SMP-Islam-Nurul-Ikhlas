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
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'operator', // ID 1
        ]);
        Role::create([
            'name' => 'karyawan', // ID 2
        ]);
        Role::create([
            'name' => 'guru', // ID 3
        ]);
    }
}

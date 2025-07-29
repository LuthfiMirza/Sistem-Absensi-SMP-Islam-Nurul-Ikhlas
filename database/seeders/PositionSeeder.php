<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $positions = [
            ["name" => "Pegawai \"Biasa\"", "type" => "karyawan"],
            ["name" => "Manager", "type" => "karyawan"],
            ["name" => "Direktur", "type" => "karyawan"],
            ["name" => "Operator", "type" => "karyawan"],
            ["name" => "Guru Matematika", "type" => "guru"],
            ["name" => "Guru Bahasa Indonesia", "type" => "guru"],
            ["name" => "Guru Bahasa Inggris", "type" => "guru"],
            ["name" => "Guru IPA", "type" => "guru"],
            ["name" => "Guru IPS", "type" => "guru"],
            ["name" => "Guru Olahraga", "type" => "guru"],
            ["name" => "Guru Seni", "type" => "guru"],
            ["name" => "Wali Kelas", "type" => "guru"],
        ];

        foreach ($positions as $position) {
            Position::create($position);
        }
    }
}

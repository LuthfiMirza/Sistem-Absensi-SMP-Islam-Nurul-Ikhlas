<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Update existing positions
        Position::where('id', 1)->update(['name' => 'Bahasa Indonesia', 'type' => 'guru']);
        Position::where('id', 2)->update(['name' => 'Matematika', 'type' => 'guru']);
        Position::where('id', 3)->update(['name' => 'Bahasa Inggris', 'type' => 'guru']);
        Position::where('id', 4)->update(['name' => 'Tata Usaha', 'type' => 'karyawan']);

        // Mata Pelajaran untuk Guru (tambahan)
        $guruPositions = [
            'IPA (Fisika)',
            'IPA (Biologi)',
            'IPS',
            'PKN',
            'Agama Islam',
            'Seni Budaya',
            'Penjaskes',
            'Prakarya',
            'Bahasa Daerah',
            'BK (Bimbingan Konseling)'
        ];

        foreach ($guruPositions as $position) {
            if (!Position::where('name', $position)->exists()) {
                Position::create([
                    'name' => $position,
                    'type' => 'guru'
                ]);
            }
        }

        // Divisi untuk Karyawan (tambahan)
        $karyawanPositions = [
            'Perpustakaan',
            'Security',
            'Kebersihan',
            'Kantin',
            'Laboratorium',
            'IT Support',
            'Penjaga Sekolah'
        ];

        foreach ($karyawanPositions as $position) {
            if (!Position::where('name', $position)->exists()) {
                Position::create([
                    'name' => $position,
                    'type' => 'karyawan'
                ]);
            }
        }
    }
}
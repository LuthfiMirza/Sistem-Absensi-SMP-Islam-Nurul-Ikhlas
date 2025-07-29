<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $divisions = [
            [
                'name' => 'Administrasi',
                'description' => 'Divisi yang menangani administrasi sekolah'
            ],
            [
                'name' => 'Kurikulum',
                'description' => 'Divisi yang menangani kurikulum dan pembelajaran'
            ],
            [
                'name' => 'Kesiswaan',
                'description' => 'Divisi yang menangani urusan kesiswaan'
            ],
            [
                'name' => 'Sarana Prasarana',
                'description' => 'Divisi yang menangani sarana dan prasarana sekolah'
            ],
            [
                'name' => 'Humas',
                'description' => 'Divisi hubungan masyarakat'
            ]
        ];

        foreach ($divisions as $division) {
            Division::create($division);
        }
    }
}

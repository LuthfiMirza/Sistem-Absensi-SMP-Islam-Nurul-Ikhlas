<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teachers = User::where('role_id', User::GURU_ROLE_ID)->get();
        
        $classes = [
            ['name' => 'X IPA 1', 'grade_level' => '10'],
            ['name' => 'X IPA 2', 'grade_level' => '10'],
            ['name' => 'X IPS 1', 'grade_level' => '10'],
            ['name' => 'X IPS 2', 'grade_level' => '10'],
            ['name' => 'XI IPA 1', 'grade_level' => '11'],
            ['name' => 'XI IPA 2', 'grade_level' => '11'],
            ['name' => 'XI IPS 1', 'grade_level' => '11'],
            ['name' => 'XI IPS 2', 'grade_level' => '11'],
            ['name' => 'XII IPA 1', 'grade_level' => '12'],
            ['name' => 'XII IPA 2', 'grade_level' => '12'],
            ['name' => 'XII IPS 1', 'grade_level' => '12'],
            ['name' => 'XII IPS 2', 'grade_level' => '12'],
        ];

        foreach ($classes as $index => $class) {
            SchoolClass::create([
                'name' => $class['name'],
                'grade_level' => $class['grade_level'],
                'description' => 'Kelas ' . $class['name'],
                'teacher_id' => $teachers->count() > 0 ? $teachers[$index % $teachers->count()]->id : null
            ]);
        }
    }
}

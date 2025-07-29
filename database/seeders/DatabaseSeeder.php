<?php

namespace Database\Seeders;

use App\Models\Position;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(PositionSeeder::class);
        $this->call(DivisionSeeder::class);

        // User Muhammad Pauzi dengan data yang diminta
        \App\Models\User::factory()->create([
            'name' => 'Muhammad Pauzi',
            'email' => 'pauji@gmail.com',
            'password' => bcrypt('pauji123'),
            'role_id' => Role::where('name', 'operator')->first()->id,
            'position_id' => Position::where('name', 'Operator')->first()->id,
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Muhammad Pauzi (Admin)',
            'email' => 'admin@gmail.com',
            'role_id' => Role::where('name', 'operator')->first()->id,
            'position_id' => Position::where('name', 'Operator')->first()->id,
        ]);
        \App\Models\User::factory(1)->create([
            'role_id' => Role::where('name', 'operator')->first()->id,
            'position_id' => Position::where('name', 'Operator')->first()->id,
        ]);

        // Real teacher data
        $teacherPositions = Position::where('type', 'guru')->get();
        $divisions = \App\Models\Division::all();
        
        $teachers = [
            ['name' => 'Dr. Siti Nurhaliza, S.Pd., M.Pd.', 'email' => 'siti.nurhaliza@sekolah.com', 'phone' => '081234567890'],
            ['name' => 'Ahmad Fauzi, S.Si., M.Pd.', 'email' => 'ahmad.fauzi@sekolah.com', 'phone' => '081234567891'],
            ['name' => 'Rina Kartika, S.Pd.', 'email' => 'rina.kartika@sekolah.com', 'phone' => '081234567892'],
            ['name' => 'Budi Santoso, S.Pd., M.Pd.', 'email' => 'budi.santoso@sekolah.com', 'phone' => '081234567893'],
            ['name' => 'Maya Sari, S.Pd.', 'email' => 'maya.sari@sekolah.com', 'phone' => '081234567894'],
            ['name' => 'Dedi Kurniawan, S.Pd.', 'email' => 'dedi.kurniawan@sekolah.com', 'phone' => '081234567895'],
            ['name' => 'Lina Marlina, S.Pd., M.Pd.', 'email' => 'lina.marlina@sekolah.com', 'phone' => '081234567896'],
            ['name' => 'Rudi Hermawan, S.Pd.', 'email' => 'rudi.hermawan@sekolah.com', 'phone' => '081234567897'],
        ];

        foreach ($teachers as $teacher) {
            \App\Models\User::create([
                'name' => $teacher['name'],
                'email' => $teacher['email'],
                'phone' => $teacher['phone'],
                'password' => bcrypt('password123'),
                'role_id' => \App\Models\User::GURU_ROLE_ID,
                'position_id' => $teacherPositions->random()->id,
                'division_id' => $divisions->random()->id,
            ]);
        }

        // Real employee data
        $employeePositions = Position::where('type', 'karyawan')->get();
        
        $employees = [
            ['name' => 'Ani Suryani', 'email' => 'ani.suryani@sekolah.com', 'phone' => '081234567898'],
            ['name' => 'Bambang Wijaya', 'email' => 'bambang.wijaya@sekolah.com', 'phone' => '081234567899'],
            ['name' => 'Citra Dewi', 'email' => 'citra.dewi@sekolah.com', 'phone' => '081234567800'],
            ['name' => 'Dani Pratama', 'email' => 'dani.pratama@sekolah.com', 'phone' => '081234567801'],
            ['name' => 'Eka Putri', 'email' => 'eka.putri@sekolah.com', 'phone' => '081234567802'],
            ['name' => 'Fajar Nugroho', 'email' => 'fajar.nugroho@sekolah.com', 'phone' => '081234567803'],
        ];

        foreach ($employees as $employee) {
            \App\Models\User::create([
                'name' => $employee['name'],
                'email' => $employee['email'],
                'phone' => $employee['phone'],
                'password' => bcrypt('password123'),
                'role_id' => \App\Models\User::KARYAWAN_ROLE_ID,
                'position_id' => $employeePositions->random()->id,
                'division_id' => $divisions->random()->id,
            ]);
        }

        // Seed class data
        $this->call(SchoolClassSeeder::class);

        // Seed attendance data
        $this->call(AttendanceSeeder::class);
    }
}

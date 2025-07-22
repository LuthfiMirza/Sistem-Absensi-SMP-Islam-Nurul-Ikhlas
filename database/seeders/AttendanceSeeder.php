<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Position;
use App\Models\User;
use App\Models\Presence;
use App\Models\Holiday;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create holidays first
        $this->createHolidays();
        
        // Create attendance schedules
        $attendances = $this->createAttendances();
        
        // Create presence records for the last 30 days
        $this->createPresences($attendances);
    }

    private function createHolidays()
    {
        $holidays = [
            [
                'holiday_date' => '2024-01-01',
                'title' => 'Tahun Baru Masehi',
                'description' => 'Hari libur nasional untuk merayakan tahun baru masehi'
            ],
            [
                'holiday_date' => '2024-02-10',
                'title' => 'Tahun Baru Imlek',
                'description' => 'Hari libur nasional untuk merayakan tahun baru Imlek'
            ],
            [
                'holiday_date' => '2024-03-11',
                'title' => 'Hari Raya Nyepi',
                'description' => 'Hari libur nasional untuk merayakan Hari Raya Nyepi'
            ],
            [
                'holiday_date' => '2024-03-29',
                'title' => 'Wafat Isa Almasih',
                'description' => 'Hari libur nasional untuk memperingati Wafat Isa Almasih'
            ],
            [
                'holiday_date' => '2024-04-10',
                'title' => 'Hari Raya Idul Fitri',
                'description' => 'Hari libur nasional untuk merayakan Hari Raya Idul Fitri'
            ],
            [
                'holiday_date' => '2024-04-11',
                'title' => 'Hari Raya Idul Fitri',
                'description' => 'Hari libur nasional untuk merayakan Hari Raya Idul Fitri (hari kedua)'
            ],
            [
                'holiday_date' => '2024-05-01',
                'title' => 'Hari Buruh Internasional',
                'description' => 'Hari libur nasional untuk memperingati Hari Buruh Internasional'
            ],
            [
                'holiday_date' => '2024-05-09',
                'title' => 'Kenaikan Isa Almasih',
                'description' => 'Hari libur nasional untuk memperingati Kenaikan Isa Almasih'
            ],
            [
                'holiday_date' => '2024-05-23',
                'title' => 'Hari Raya Waisak',
                'description' => 'Hari libur nasional untuk merayakan Hari Raya Waisak'
            ],
            [
                'holiday_date' => '2024-06-01',
                'title' => 'Hari Lahir Pancasila',
                'description' => 'Hari libur nasional untuk memperingati Hari Lahir Pancasila'
            ],
            [
                'holiday_date' => '2024-06-17',
                'title' => 'Hari Raya Idul Adha',
                'description' => 'Hari libur nasional untuk merayakan Hari Raya Idul Adha'
            ],
            [
                'holiday_date' => '2024-07-07',
                'title' => 'Tahun Baru Islam',
                'description' => 'Hari libur nasional untuk merayakan Tahun Baru Islam'
            ],
            [
                'holiday_date' => '2024-08-17',
                'title' => 'Hari Kemerdekaan RI',
                'description' => 'Hari libur nasional untuk memperingati Hari Kemerdekaan Republik Indonesia'
            ],
            [
                'holiday_date' => '2024-09-16',
                'title' => 'Maulid Nabi Muhammad SAW',
                'description' => 'Hari libur nasional untuk memperingati Maulid Nabi Muhammad SAW'
            ],
            [
                'holiday_date' => '2024-12-25',
                'title' => 'Hari Raya Natal',
                'description' => 'Hari libur nasional untuk merayakan Hari Raya Natal'
            ],
        ];

        foreach ($holidays as $holiday) {
            Holiday::create($holiday);
        }
    }

    private function createAttendances()
    {
        $positions = Position::all();
        $attendances = [];

        // Attendance for Regular Staff (Pegawai Biasa)
        $regularAttendance = Attendance::create([
            'title' => 'Absensi Pegawai Reguler',
            'description' => 'Jadwal absensi untuk pegawai reguler dengan jam kerja standar',
            'start_time' => '07:00:00',
            'batas_start_time' => '08:30:00',
            'end_time' => '16:00:00',
            'batas_end_time' => '18:00:00',
            'code' => Str::random(10),
        ]);

        // Attach positions to attendance
        $regularPositions = $positions->whereIn('name', ['Pegawai "Biasa"', 'Operator'])->pluck('id');
        $regularAttendance->positions()->attach($regularPositions);
        $attendances[] = $regularAttendance;

        // Attendance for Management (Manager & Direktur)
        $managementAttendance = Attendance::create([
            'title' => 'Absensi Manajemen',
            'description' => 'Jadwal absensi untuk level manajemen dengan fleksibilitas waktu',
            'start_time' => '08:00:00',
            'batas_start_time' => '09:30:00',
            'end_time' => '17:00:00',
            'batas_end_time' => '19:00:00',
            'code' => Str::random(10),
        ]);

        $managementPositions = $positions->whereIn('name', ['Manager', 'Direktur'])->pluck('id');
        $managementAttendance->positions()->attach($managementPositions);
        $attendances[] = $managementAttendance;

        // Weekend/Shift Attendance
        $shiftAttendance = Attendance::create([
            'title' => 'Absensi Shift Weekend',
            'description' => 'Jadwal absensi untuk shift weekend dan hari libur',
            'start_time' => '09:00:00',
            'batas_start_time' => '10:00:00',
            'end_time' => '15:00:00',
            'batas_end_time' => '16:00:00',
            'code' => null, // No QR code for shift
        ]);

        // Attach all positions to shift attendance
        $shiftAttendance->positions()->attach($positions->pluck('id'));
        $attendances[] = $shiftAttendance;

        return $attendances;
    }

    private function createPresences($attendances)
    {
        $users = User::onlyEmployees()->with('position')->get();
        $startDate = Carbon::now()->subDays(30);
        $endDate = Carbon::now();

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            // Skip weekends for regular attendance (Saturday & Sunday)
            if ($date->isWeekend()) {
                continue;
            }

            // Skip holidays
            $isHoliday = Holiday::where('holiday_date', $date->toDateString())->exists();
            if ($isHoliday) {
                continue;
            }

            foreach ($users as $user) {
                // Find appropriate attendance for user's position
                $attendance = $this->getAttendanceForUser($user, $attendances);
                
                if (!$attendance) {
                    continue;
                }

                // 85% chance of attendance (some people might be absent)
                if (rand(1, 100) > 85) {
                    continue;
                }

                // 10% chance of permission (izin)
                $isPermission = rand(1, 100) <= 10;

                // Generate realistic times
                $presenceData = $this->generatePresenceTimes($attendance, $date, $isPermission);

                Presence::create([
                    'user_id' => $user->id,
                    'attendance_id' => $attendance->id,
                    'presence_date' => $date->toDateString(),
                    'presence_enter_time' => $presenceData['enter_time'],
                    'presence_out_time' => $presenceData['out_time'],
                    'is_permission' => $isPermission,
                    'created_at' => $date->copy()->setTime(
                        Carbon::parse($presenceData['enter_time'])->hour,
                        Carbon::parse($presenceData['enter_time'])->minute
                    ),
                    'updated_at' => $presenceData['out_time'] ? 
                        $date->copy()->setTime(
                            Carbon::parse($presenceData['out_time'])->hour,
                            Carbon::parse($presenceData['out_time'])->minute
                        ) : 
                        $date->copy()->setTime(
                            Carbon::parse($presenceData['enter_time'])->hour,
                            Carbon::parse($presenceData['enter_time'])->minute
                        ),
                ]);
            }
        }
    }

    private function getAttendanceForUser($user, $attendances)
    {
        foreach ($attendances as $attendance) {
            if ($attendance->positions->contains('id', $user->position_id)) {
                // For management, prefer management attendance
                if (in_array($user->position->name, ['Manager', 'Direktur']) && 
                    $attendance->title === 'Absensi Manajemen') {
                    return $attendance;
                }
                
                // For regular staff, prefer regular attendance
                if (in_array($user->position->name, ['Pegawai "Biasa"', 'Operator']) && 
                    $attendance->title === 'Absensi Pegawai Reguler') {
                    return $attendance;
                }
            }
        }

        // Fallback to first available attendance
        return $attendances[0] ?? null;
    }

    private function generatePresenceTimes($attendance, $date, $isPermission)
    {
        $startTime = Carbon::parse($attendance->start_time);
        $batasStartTime = Carbon::parse($attendance->batas_start_time);
        $endTime = Carbon::parse($attendance->end_time);
        $batasEndTime = Carbon::parse($attendance->batas_end_time);

        if ($isPermission) {
            // For permission, just set enter time and no out time
            $enterTime = $startTime->copy()->addMinutes(rand(0, 60));
            return [
                'enter_time' => $enterTime->format('H:i:s'),
                'out_time' => null,
            ];
        }

        // Generate realistic enter time (mostly on time, some late)
        $enterTimeVariation = rand(-30, 90); // -30 minutes early to 90 minutes late
        $enterTime = $startTime->copy()->addMinutes($enterTimeVariation);

        // Ensure enter time doesn't exceed batas_start_time too much
        if ($enterTime->gt($batasStartTime)) {
            $enterTime = $batasStartTime->copy()->subMinutes(rand(0, 30));
        }

        // 15% chance of not checking out (forgot to check out)
        if (rand(1, 100) <= 15) {
            return [
                'enter_time' => $enterTime->format('H:i:s'),
                'out_time' => null,
            ];
        }

        // Generate realistic out time
        $workDuration = rand(480, 600); // 8-10 hours of work in minutes
        $outTime = $enterTime->copy()->addMinutes($workDuration);

        // Ensure out time is within reasonable bounds
        if ($outTime->lt($endTime)) {
            $outTime = $endTime->copy()->addMinutes(rand(0, 60));
        }

        if ($outTime->gt($batasEndTime)) {
            $outTime = $batasEndTime->copy()->subMinutes(rand(0, 30));
        }

        return [
            'enter_time' => $enterTime->format('H:i:s'),
            'out_time' => $outTime->format('H:i:s'),
        ];
    }
}
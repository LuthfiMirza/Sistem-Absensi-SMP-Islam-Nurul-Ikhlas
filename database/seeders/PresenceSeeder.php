<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\User;
use App\Models\Presence;
use App\Models\Holiday;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PresenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * This seeder creates presence records for existing attendances and users
     *
     * @return void
     */
    public function run()
    {
        $attendances = Attendance::with('positions')->get();
        $users = User::onlyEmployees()->with('position')->get();
        
        if ($attendances->isEmpty()) {
            $this->command->error('No attendances found. Please run AttendanceSeeder first.');
            return;
        }

        if ($users->isEmpty()) {
            $this->command->error('No employee users found. Please create users first.');
            return;
        }

        // Create presence records for the last 7 days (for testing)
        $startDate = Carbon::now()->subDays(7);
        $endDate = Carbon::now();

        $this->command->info("Creating presence records from {$startDate->toDateString()} to {$endDate->toDateString()}");

        $totalCreated = 0;

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            // Skip weekends for regular attendance
            if ($date->isWeekend()) {
                $this->command->info("Skipping weekend: {$date->toDateString()}");
                continue;
            }

            // Skip holidays
            $isHoliday = Holiday::where('holiday_date', $date->toDateString())->exists();
            if ($isHoliday) {
                $this->command->info("Skipping holiday: {$date->toDateString()}");
                continue;
            }

            $this->command->info("Processing date: {$date->toDateString()}");

            foreach ($users as $user) {
                // Find appropriate attendance for user's position
                $attendance = $this->getAttendanceForUser($user, $attendances);
                
                if (!$attendance) {
                    continue;
                }

                // Check if presence already exists
                $existingPresence = Presence::where('user_id', $user->id)
                    ->where('attendance_id', $attendance->id)
                    ->where('presence_date', $date->toDateString())
                    ->first();

                if ($existingPresence) {
                    continue; // Skip if already exists
                }

                // 90% chance of attendance (higher for testing)
                if (rand(1, 100) > 90) {
                    continue;
                }

                // 5% chance of permission (izin)
                $isPermission = rand(1, 100) <= 5;

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

                $totalCreated++;
            }
        }

        $this->command->info("Created {$totalCreated} presence records.");
    }

    private function getAttendanceForUser($user, $attendances)
    {
        foreach ($attendances as $attendance) {
            if ($attendance->positions->contains('id', $user->position_id)) {
                // For management, prefer management attendance
                if (in_array($user->position->name, ['Manager', 'Direktur']) && 
                    str_contains($attendance->title, 'Manajemen')) {
                    return $attendance;
                }
                
                // For regular staff, prefer regular attendance
                if (in_array($user->position->name, ['Pegawai "Biasa"', 'Operator']) && 
                    str_contains($attendance->title, 'Reguler')) {
                    return $attendance;
                }
            }
        }

        // Fallback to first available attendance for user's position
        foreach ($attendances as $attendance) {
            if ($attendance->positions->contains('id', $user->position_id)) {
                return $attendance;
            }
        }

        return null;
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
        $enterTimeVariation = rand(-15, 60); // -15 minutes early to 60 minutes late
        $enterTime = $startTime->copy()->addMinutes($enterTimeVariation);

        // Ensure enter time doesn't exceed batas_start_time too much
        if ($enterTime->gt($batasStartTime)) {
            $enterTime = $batasStartTime->copy()->subMinutes(rand(0, 15));
        }

        // 10% chance of not checking out (forgot to check out)
        if (rand(1, 100) <= 10) {
            return [
                'enter_time' => $enterTime->format('H:i:s'),
                'out_time' => null,
            ];
        }

        // Generate realistic out time
        $workDuration = rand(480, 540); // 8-9 hours of work in minutes
        $outTime = $enterTime->copy()->addMinutes($workDuration);

        // Ensure out time is within reasonable bounds
        if ($outTime->lt($endTime)) {
            $outTime = $endTime->copy()->addMinutes(rand(0, 30));
        }

        if ($outTime->gt($batasEndTime)) {
            $outTime = $batasEndTime->copy()->subMinutes(rand(0, 15));
        }

        return [
            'enter_time' => $enterTime->format('H:i:s'),
            'out_time' => $outTime->format('H:i:s'),
        ];
    }
}
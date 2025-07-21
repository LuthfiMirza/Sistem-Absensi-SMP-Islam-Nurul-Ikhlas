<?php
/**
 * Script untuk mengecek data attendance di database
 * Jalankan dengan: php check_attendance_data.php
 */

require_once 'vendor/autoload.php';

// Load Laravel app
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Attendance;
use App\Models\User;
use App\Models\Position;

echo "🔍 Checking Attendance Data...\n\n";

// Check attendances
$attendances = Attendance::all();
echo "📋 Total Attendances: " . $attendances->count() . "\n";

if ($attendances->count() > 0) {
    echo "\n📝 Attendance List:\n";
    foreach ($attendances as $attendance) {
        echo "  - ID: {$attendance->id} | Title: {$attendance->title}\n";
        echo "    Time: {$attendance->start_time} - {$attendance->end_time}\n";
        echo "    Code: " . ($attendance->code ?: 'No QR Code') . "\n";
        
        // Check positions for this attendance
        $positions = $attendance->positions;
        echo "    Positions: ";
        if ($positions->count() > 0) {
            echo $positions->pluck('name')->implode(', ') . "\n";
        } else {
            echo "No positions assigned\n";
        }
        echo "\n";
    }
} else {
    echo "❌ No attendance data found!\n";
    echo "💡 You need to create attendance data first.\n\n";
}

// Check users with guru/karyawan role
$users = User::whereIn('role_id', [2, 3])->with(['role', 'position'])->get();
echo "👥 Total Guru/Karyawan Users: " . $users->count() . "\n";

if ($users->count() > 0) {
    echo "\n👤 User List:\n";
    foreach ($users as $user) {
        echo "  - ID: {$user->id} | Name: {$user->name}\n";
        echo "    Role: {$user->role->name}\n";
        echo "    Position: " . ($user->position->name ?? 'No position') . "\n";
        echo "    Position ID: " . ($user->position_id ?? 'NULL') . "\n\n";
    }
} else {
    echo "❌ No guru/karyawan users found!\n\n";
}

// Check positions
$positions = Position::all();
echo "🏢 Total Positions: " . $positions->count() . "\n";

if ($positions->count() > 0) {
    echo "\n📍 Position List:\n";
    foreach ($positions as $position) {
        echo "  - ID: {$position->id} | Name: {$position->name}\n";
    }
    echo "\n";
}

// Check attendance-position relationships
echo "🔗 Checking Attendance-Position Relationships:\n";
foreach ($attendances as $attendance) {
    $positions = $attendance->positions;
    echo "  Attendance '{$attendance->title}' -> ";
    if ($positions->count() > 0) {
        echo $positions->count() . " position(s)\n";
    } else {
        echo "❌ No positions assigned!\n";
    }
}

echo "\n✅ Data check completed!\n";

// Recommendations
echo "\n💡 Recommendations:\n";
if ($attendances->count() == 0) {
    echo "  1. Create attendance data through admin panel\n";
}
if ($users->count() == 0) {
    echo "  2. Create guru/karyawan users\n";
}
if ($positions->count() == 0) {
    echo "  3. Create position data\n";
}

$unassignedUsers = $users->where('position_id', null);
if ($unassignedUsers->count() > 0) {
    echo "  4. Assign positions to " . $unassignedUsers->count() . " users\n";
}

$attendancesWithoutPositions = $attendances->filter(function($attendance) {
    return $attendance->positions->count() == 0;
});
if ($attendancesWithoutPositions->count() > 0) {
    echo "  5. Assign positions to " . $attendancesWithoutPositions->count() . " attendances\n";
}

echo "\n🚀 If all data is ready, you can access:\n";
echo "   - Home: http://127.0.0.1:8000/home\n";
echo "   - Test: http://127.0.0.1:8000/test-sidebar\n";
?>
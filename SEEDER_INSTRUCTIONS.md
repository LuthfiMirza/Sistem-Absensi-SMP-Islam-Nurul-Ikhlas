# Attendance System Seeder Instructions

This document explains how to use the seeders for the attendance system.

## Available Seeders

### 1. AttendanceSeeder
Creates comprehensive attendance data including:
- **Holidays**: Indonesian national holidays for 2024
- **Attendance Schedules**: Different schedules for different position types
- **Presence Records**: 30 days of realistic attendance data

### 2. PresenceSeeder
Creates only presence records for existing attendances and users (useful for testing with fresh data).

## How to Run Seeders

### Run All Seeders (Recommended for fresh installation)
```bash
php artisan db:seed
```

### Run Specific Seeders

#### Run only AttendanceSeeder
```bash
php artisan db:seed --class=AttendanceSeeder
```

#### Run only PresenceSeeder (for testing)
```bash
php artisan db:seed --class=PresenceSeeder
```

## What Gets Created

### Holidays
- Indonesian national holidays for 2024
- Includes major religious and national holidays

### Attendance Schedules

#### 1. Regular Staff Attendance
- **Positions**: Pegawai "Biasa", Operator
- **Check-in**: 07:00 - 08:30
- **Check-out**: 16:00 - 18:00
- **QR Code**: Enabled

#### 2. Management Attendance
- **Positions**: Manager, Direktur
- **Check-in**: 08:00 - 09:30
- **Check-out**: 17:00 - 19:00
- **QR Code**: Enabled

#### 3. Weekend/Shift Attendance
- **Positions**: All positions
- **Check-in**: 09:00 - 10:00
- **Check-out**: 15:00 - 16:00
- **QR Code**: Disabled

### Presence Records
- **Duration**: Last 30 days (AttendanceSeeder) or Last 7 days (PresenceSeeder)
- **Attendance Rate**: ~85% (realistic absence rate)
- **Permission Rate**: ~10% (izin/permission)
- **Realistic Times**: Varied check-in/check-out times
- **Missing Check-out**: ~15% (forgot to check out)

## Data Characteristics

### Realistic Scenarios
1. **On-time arrivals**: Most employees arrive on time
2. **Late arrivals**: Some employees arrive late (within limits)
3. **Early departures**: Rare cases of early departure
4. **Overtime**: Some employees work overtime
5. **Permissions**: Some employees take permission (izin)
6. **Forgotten check-outs**: Some employees forget to check out

### Time Variations
- **Check-in**: Can be 30 minutes early to 90 minutes late
- **Check-out**: Based on work duration (8-10 hours)
- **Work Duration**: Realistic work hours with variations

## Prerequisites

Before running the seeders, ensure:

1. **Database is migrated**:
   ```bash
   php artisan migrate
   ```

2. **Basic seeders are run** (roles, positions, users):
   ```bash
   php artisan db:seed --class=RoleSeeder
   php artisan db:seed --class=PositionSeeder
   ```

3. **Users exist**: At least some employee users should exist

## Testing the Data

After running the seeders, you can:

1. **View Attendances**: Check the attendances table for created schedules
2. **View Presences**: Check the presences table for attendance records
3. **Test the UI**: Visit the presence table at `/presences/{attendance_id}`
4. **Export Data**: Test the export functionality with the seeded data

## Customization

You can modify the seeders to:

- **Change date ranges**: Modify the date ranges in the seeders
- **Adjust attendance rates**: Change the probability of attendance
- **Add more holidays**: Add additional holidays to the list
- **Modify work schedules**: Adjust the time ranges for different positions
- **Add more attendance types**: Create additional attendance schedules

## Troubleshooting

### Common Issues

1. **No users found**: Make sure users are created before running AttendanceSeeder
2. **No attendances found**: Run AttendanceSeeder before PresenceSeeder
3. **Duplicate data**: The seeders check for existing data to avoid duplicates

### Reset Data

To reset and reseed:
```bash
php artisan migrate:fresh --seed
```

**Warning**: This will delete all existing data!

## Example Usage

```bash
# Fresh installation
php artisan migrate:fresh
php artisan db:seed

# Add more test data
php artisan db:seed --class=PresenceSeeder

# Reset everything
php artisan migrate:fresh --seed
```
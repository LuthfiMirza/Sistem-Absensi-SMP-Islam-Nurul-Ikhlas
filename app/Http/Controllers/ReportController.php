<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Presence;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index', [
            'title' => 'Laporan Absensi'
        ]);
    }

    public function attendanceReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'user_id' => 'nullable|exists:users,id',
            'format' => 'required|in:view,pdf'
        ]);

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        $query = Attendance::whereBetween('created_at', [$startDate, $endDate])
            ->with(['presences.user', 'permissions.user']);

        $attendances = $query->get();

        // Filter by user if specified
        if ($request->user_id) {
            $user = User::find($request->user_id);
            $attendances = $attendances->filter(function ($attendance) use ($request) {
                return $attendance->presences->contains('user_id', $request->user_id) ||
                       $attendance->permissions->contains('user_id', $request->user_id);
            });
        }

        $data = [
            'title' => 'Laporan Absensi',
            'attendances' => $attendances,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'user' => $request->user_id ? User::find($request->user_id) : null
        ];

        if ($request->format === 'pdf') {
            $pdf = Pdf::loadView('reports.attendance-pdf', $data);
            return $pdf->download('laporan-absensi-' . $startDate->format('Y-m-d') . '-' . $endDate->format('Y-m-d') . '.pdf');
        }

        return view('reports.attendance', $data);
    }

    public function recapitulation(Request $request)
    {
        $request->validate([
            'month' => 'required|integer|between:1,12',
            'year' => 'required|integer|min:2020',
            'format' => 'required|in:view,pdf'
        ]);

        $month = $request->month;
        $year = $request->year;

        $startDate = Carbon::create($year, $month, 1);
        $endDate = $startDate->copy()->endOfMonth();

        // Get all users (employees and teachers)
        $users = User::onlyEmployees()->with(['role', 'position', 'division'])->get();

        $recapData = [];

        foreach ($users as $user) {
            $attendances = Attendance::whereBetween('created_at', [$startDate, $endDate])->get();
            
            $userData = [
                'user' => $user,
                'total_days' => $attendances->count(),
                'present_days' => 0,
                'absent_days' => 0,
                'permission_days' => 0,
                'late_days' => 0
            ];

            foreach ($attendances as $attendance) {
                $presence = $attendance->presences()->where('user_id', $user->id)->first();
                $permission = $attendance->permissions()->where('user_id', $user->id)->first();

                if ($presence) {
                    $userData['present_days']++;
                    if ($presence->presence_enter_time > $attendance->start_time) {
                        $userData['late_days']++;
                    }
                } elseif ($permission && $permission->is_accepted) {
                    $userData['permission_days']++;
                } else {
                    $userData['absent_days']++;
                }
            }

            $recapData[] = $userData;
        }

        $data = [
            'title' => 'Rekapitulasi Absensi',
            'recapData' => $recapData,
            'month' => $month,
            'year' => $year,
            'monthName' => Carbon::create($year, $month, 1)->format('F'),
            'start_date' => $startDate,
            'end_date' => $endDate
        ];

        if ($request->format === 'pdf') {
            $pdf = Pdf::loadView('reports.recapitulation-pdf', $data);
            return $pdf->download('rekapitulasi-absensi-' . $data['monthName'] . '-' . $year . '.pdf');
        }

        return view('reports.recapitulation', $data);
    }

    public function permissionReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'type' => 'nullable|in:same_day,leave',
            'status' => 'nullable|in:pending,accepted,rejected',
            'format' => 'required|in:view,pdf'
        ]);

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        $query = Permission::with(['user', 'attendance'])
            ->whereBetween('permission_date', [$startDate, $endDate]);

        if ($request->type) {
            $query->where('type', $request->type);
        }

        if ($request->status) {
            if ($request->status === 'pending') {
                $query->whereNull('is_accepted');
            } elseif ($request->status === 'accepted') {
                $query->where('is_accepted', true);
            } else {
                $query->where('is_accepted', false);
            }
        }

        $permissions = $query->latest()->get();

        $data = [
            'title' => 'Laporan Izin',
            'permissions' => $permissions,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'type' => $request->type,
            'status' => $request->status
        ];

        if ($request->format === 'pdf') {
            $pdf = Pdf::loadView('reports.permission-pdf', $data);
            return $pdf->download('laporan-izin-' . $startDate->format('Y-m-d') . '-' . $endDate->format('Y-m-d') . '.pdf');
        }

        return view('reports.permission', $data);
    }
}

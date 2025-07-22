<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        return view('attendances.index', [
            "title" => "Absensi"
        ]);
    }

    public function create()
    {
        return view('attendances.create', [
            "title" => "Tambah Data Absensi"
        ]);
    }

    public function show(Attendance $attendance)
    {
        return view('attendances.show', [
            "title" => "Detail Absensi",
            "attendance" => $attendance
        ]);
    }

    public function edit(Attendance $attendance)
    {
        return view('attendances.edit', [
            "title" => "Edit Data Absensi",
            "attendance" => $attendance
        ]);
    }
}

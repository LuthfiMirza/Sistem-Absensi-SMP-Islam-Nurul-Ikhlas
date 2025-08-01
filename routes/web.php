<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Default redirect
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->isUser() ? redirect()->route('home.index') : redirect()->route('dashboard.index');
    }
    return redirect()->route('auth.login');
});

// Debug route to check user role
Route::get('/debug-user', function () {
    if (auth()->check()) {
        $user = auth()->user();
        return response()->json([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'role_id' => $user->role_id,
            'role_name' => $user->role ? $user->role->name : 'No role',
            'isOperator' => $user->isOperator(),
            'isUser' => $user->isUser(),
        ]);
    }
    return response()->json(['message' => 'Not authenticated']);
})->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::middleware('role:operator')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
        // positions
        Route::resource('/positions', PositionController::class);
        Route::get('/positions/bulk-edit', [PositionController::class, 'bulkEdit'])->name('positions.bulk-edit');
        Route::delete('/positions/bulk-delete', [PositionController::class, 'bulkDelete'])->name('positions.bulk-delete');
        // employees
        Route::resource('/employees', EmployeeController::class);
        Route::get('/employees/bulk-edit', [EmployeeController::class, 'edit'])->name('employees.bulk-edit');
        Route::delete('/employees/bulk-delete', [EmployeeController::class, 'bulkDelete'])->name('employees.bulk-delete');
        // holidays (hari libur)
        Route::resource('/holidays', HolidayController::class)->only(['index', 'create']);
        Route::get('/holidays/edit', [HolidayController::class, 'edit'])->name('holidays.edit');
        // attendances (absensi)
        Route::resource('/attendances', AttendanceController::class)->only(['index', 'create', 'show', 'edit']);

        // presences (kehadiran)
        Route::resource('/presences', PresenceController::class)->only(['index']);
        Route::get('/presences/qrcode', [PresenceController::class, 'showQrcode'])->name('presences.qrcode');
        Route::get('/presences/qrcode/download-pdf', [PresenceController::class, 'downloadQrCodePDF'])->name('presences.qrcode.download-pdf');
        Route::get('/presences/{attendance}', [PresenceController::class, 'show'])->name('presences.show');
        // not present data
        Route::get('/presences/{attendance}/not-present', [PresenceController::class, 'notPresent'])->name('presences.not-present');
        Route::post('/presences/{attendance}/not-present', [PresenceController::class, 'notPresent']);
        // present (url untuk menambahkan/mengubah user yang tidak hadir menjadi hadir)
        Route::post('/presences/{attendance}/present', [PresenceController::class, 'presentUser'])->name('presences.present');
        Route::post('/presences/{attendance}/acceptPermission', [PresenceController::class, 'acceptPermission'])->name('presences.acceptPermission');
        // employees permissions
        Route::get('/presences/{attendance}/permissions', [PresenceController::class, 'permissions'])->name('presences.permissions');
        
        // divisions
        Route::resource('/divisions', DivisionController::class);
        
        // permissions management (operator only) - view and delete
        Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
        Route::get('/permissions/{permission}', [PermissionController::class, 'show'])->name('permissions.show');
        Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
        
        // reports
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/attendance', [ReportController::class, 'attendanceReport'])->name('reports.attendance');
        Route::get('/reports/recapitulation', [ReportController::class, 'recapitulation'])->name('reports.recapitulation');
        Route::get('/reports/permissions', [ReportController::class, 'permissionReport'])->name('reports.permissions');
    });

    Route::middleware('role:karyawan,guru')->name('home.')->group(function () {
        Route::get('/home', [HomeController::class, 'index'])->name('index');
        // destination after scan qrcode
        Route::post('/absensi/qrcode', [HomeController::class, 'sendEnterPresenceUsingQRCode'])->name('sendEnterPresenceUsingQRCode');
        Route::post('/absensi/qrcode/out', [HomeController::class, 'sendOutPresenceUsingQRCode'])->name('sendOutPresenceUsingQRCode');

        Route::get('/absensi/{attendance}', [HomeController::class, 'show'])->name('show');
        Route::get('/absensi/{attendance}/permission', [HomeController::class, 'permission'])->name('permission');
    });

    // Routes khusus untuk karyawan (bukan guru)
    Route::middleware('role:karyawan')->name('home.')->group(function () {
        // Additional routes for accessing presence management pages (read-only for employees)
        Route::get('/absensi/{attendance}/detail', [PresenceController::class, 'show'])->name('detail');
        Route::get('/absensi/{attendance}/permissions', [PresenceController::class, 'permissions'])->name('permissions');
        Route::get('/absensi/{attendance}/not-present', [PresenceController::class, 'notPresent'])->name('not-present');
    });

    // Permission routes for employees only (not guru)
    Route::middleware('role:karyawan')->group(function () {
        Route::resource('/my-permissions', PermissionController::class)->except(['index', 'show']);
    });
    
    // View permissions for all authenticated users
    Route::get('/my-permissions', [PermissionController::class, 'index'])->name('my-permissions.index');
    Route::get('/my-permissions/{permission}', [PermissionController::class, 'show'])->name('my-permissions.show');
    
    // Permission creation route for karyawan only
    Route::middleware('role:karyawan')->group(function () {
        Route::get('/my-permissions/create', [PermissionController::class, 'create'])->name('my-permissions.create');
    });

    // Profile and password update routes for all authenticated users
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile.index');
    Route::put('/profile/password', [AuthController::class, 'updatePassword'])->name('profile.password.update');

    Route::delete('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    
    // Test route untuk debug sidebar
    Route::get('/test-sidebar', function() {
        return view('test-sidebar', ['title' => 'Test Sidebar']);
    })->name('test.sidebar');
});

Route::middleware('guest')->group(function () {
    // auth
    Route::get('/login', [AuthController::class, 'index'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'authenticate']);
});
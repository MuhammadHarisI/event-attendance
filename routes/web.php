<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth', 'role:super_user'])
    ->get('/super/dashboard', [DashboardController::class, 'superUser'])
    ->name('super.dashboard');
    
Route::middleware(['auth', 'role:super_user'])
    ->group(function () {

        Route::post('/events/{event}/activate', [EventController::class, 'activate'])
            ->name('events.activate');

        Route::post('/events/{event}/finish', [EventController::class, 'finish'])
            ->name('events.finish');

        Route::resource('events', EventController::class)
            ->except(['index', 'show']);

        Route::resource('participants', ParticipantController::class);

        Route::get('/events/{event}/admins', [EventController::class, 'admins'])
            ->name('events.admins');

        Route::post('/events/{event}/admins', [EventController::class, 'assignAdmin'])
            ->name('events.admins.assign');

        Route::delete('/events/{event}/admins/{user}', [EventController::class, 'removeAdmin'])
            ->name('events.admins.remove');
    });

    Route::middleware(['auth'])
            ->get('/participant-import-template', function () {
                return response()->download(
                    public_path('participant-import-template.xlsx')
                );
            })->name('participants.import.template');

    Route::get('/attendance/{qr_token}', [AttendanceController::class, 'form'])
            ->name('attendance.form');

    Route::post('/attendance/{qr_token}', [AttendanceController::class, 'check'])
            ->name('attendance.check');

    Route::middleware(['auth', 'role:super_user,admin'])
        ->get('/events', [EventController::class, 'index'])
        ->name('events.index');

    Route::middleware(['auth', 'role:super_user,admin', 'event.access'])
        ->get('/events/{event}', [EventController::class, 'show'])
        ->name('events.show');

    Route::middleware(['auth', 'role:super_user,admin', 'event.access'])
        ->get('/events/{event}/attendances', [AttendanceController::class, 'index'])
        ->name('events.attendances.index');

    Route::middleware(['auth', 'role:super_user,admin', 'event.access'])
        ->get('/events/{event}/attendances/export', [AttendanceController::class, 'export'])
        ->name('events.attendances.export');

    Route::middleware(['auth', 'role:super_user,admin', 'event.access'])
        ->get('/events/{event}/participants', [EventController::class, 'participants'])
        ->name('events.participants');

    Route::middleware(['auth', 'role:super_user,admin', 'event.access'])
        ->post('/events/{event}/participants', [EventController::class, 'addParticipant'])
        ->name('events.participants.add');

    Route::middleware(['auth', 'role:super_user,admin', 'event.access'])
        ->post('/events/{event}/participants/import', [EventController::class, 'importParticipants'])
        ->name('events.participants.import');

    Route::middleware(['auth', 'role:super_user,admin', 'event.access'])
        ->delete('/events/{event}/participants/{participant}', [EventController::class, 'removeParticipant'])
        ->name('events.participants.remove');

    Route::middleware(['auth', 'role:super_user,admin', 'event.access'])
        ->get('/events/{event}/qr', [EventController::class, 'qr'])
        ->name('events.qr');

    Route::middleware(['auth', 'role:admin'])
        ->get('/admin/dashboard', [DashboardController::class, 'admin'])
        ->name('admin.dashboard');
    Route::middleware(['auth', 'role:super_user'])
        ->resource('users', UserController::class)
        ->only([
            'index',
            'create',
            'store',
            'edit',
            'update',
            'destroy',
        ]);

require __DIR__.'/auth.php';

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MyRequestController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\MyComplaintController;
use App\Http\Controllers\RequestTypeController;
use App\Http\Controllers\NotificationController;

Route::fallback(function () {
    if(Auth::user()){
        return response()->view('errors.404', [], 404);
        
    }else{
        return response()->view('errors.404ns', [], 404);

    }
})->name('error.404');

// Route::get('/error/{code}', [\App\Http\Controllers\ErrorController::class, 'index'])->name('error.index');

Route::get('/', [HomeController::class, 'index'])->name('/');
Route::get('pengajuan', [HomeController::class, 'submission'])->name('pengajuan.index');
Route::get('pengaduan', [HomeController::class, 'complaint'])->name('pengaduan.index');
// Route::post('pengaduan', [HomeController::class, 'storeComplaint'])->name('complaint.store');
Route::get('profil', [HomeController::class, 'profile'])->name('profil.index');


Route::get('/informasi', [HomeController::class, 'information'])->name('informasi.index');
Route::get('/informasi/{id}', [HomeController::class, 'showInformation'])->name('informasi.show');



// Authentication Routes
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'doregister']);
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('pengaduan-saya/check', [DashboardController::class, 'checkComplaintStatus'])->name('pengaduan-saya.check');
    Route::prefix('data-masyarakat')->group(function () {
        Route::get('/', [ResidentController::class, 'index'])->name('data-masyarakat.index');
        Route::get('/show/{id}', [ResidentController::class, 'show'])->name('data-masyarakat.show');
        Route::get('/create', [ResidentController::class, 'create'])->name('data-masyarakat.create');
        Route::post('/store', [ResidentController::class, 'store'])->name('data-masyarakat.store');
        Route::get('/edit/{id}', [ResidentController::class, 'edit'])->name('data-masyarakat.edit');
        Route::put('/update/{id}', [ResidentController::class, 'update'])->name('data-masyarakat.update');
        Route::delete('/delete/{id}', [ResidentController::class, 'destroy'])->name('data-masyarakat.destroy');
    });
    
    Route::prefix('manajemen-pengguna')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('manajemen-pengguna.index');
        Route::get('/create', [UserController::class, 'create'])->name('manajemen-pengguna.create');
        Route::post('/store', [UserController::class, 'store'])->name('manajemen-pengguna.store');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('manajemen-pengguna.edit');
        Route::put('/update/{id}', [UserController::class, 'update'])->name('manajemen-pengguna.update');
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('manajemen-pengguna.destroy');
    });

    Route::prefix('jenis-permohonan')->group(function () {
        Route::get('/', [RequestTypeController::class, 'index'])->name('jenis-permohonan.index');
        Route::get('/create', [RequestTypeController::class, 'create'])->name('jenis-permohonan.create');
        Route::post('/store', [RequestTypeController::class, 'store'])->name('jenis-permohonan.store');
        Route::get('/show/{id}', [RequestTypeController::class, 'show'])->name('jenis-permohonan.show');
        Route::get('/edit/{id}', [RequestTypeController::class, 'edit'])->name('jenis-permohonan.edit');
        Route::put('/update/{id}', [RequestTypeController::class, 'update'])->name('jenis-permohonan.update');
        Route::delete('/delete/{id}', [RequestTypeController::class, 'destroy'])->name('jenis-permohonan.destroy');
    });

    Route::prefix('data-pengajuan')->group(function () {
        Route::get('/', [RequestController::class, 'index'])->name('data-pengajuan.index');
        Route::get('show/{id}', [RequestController::class, 'show'])->name('data-pengajuan.show');
        Route::get('/print/{id}', [RequestController::class, 'print'])->name('data-pengajuan.print');

        Route::get('verifikasi-operator/{id}', [RequestController::class, 'verifikasiOperator'])->name('data-pengajuan.verifikasi-operator');
        Route::put('verifikasi-operator/{id}', [RequestController::class, 'updateVerifikasi'])->name('verifikasi-operator.update');
        Route::get('verifikasi-admin/{id}', [RequestController::class, 'verifikasiAdmin'])->name('data-pengajuan.verifikasi-admin');
        Route::put('verifikasi-admin/{id}', [RequestController::class, 'updateVerifikasi'])->name('verifikasi-admin.update');
    });

    Route::prefix('pengajuan-saya')->group(function () {
        Route::get('form/{requestTypeCode}', [MyRequestController::class, 'form'])->name('pengajuan-saya.form');
        Route::get('/', [MyRequestController::class, 'index'])->name('pengajuan-saya.index');
        Route::get('/create', [MyRequestController::class, 'create'])->name('pengajuan-saya.create');
        Route::post('/store', [MyRequestController::class, 'store'])->name('pengajuan-saya.store');
        Route::get('/show/{id}', [MyRequestController::class, 'show'])->name('pengajuan-saya.show');
        Route::get('/edit/{id}', [MyRequestController::class, 'edit'])->name('pengajuan-saya.edit');
        Route::get('/print/{id}', [MyRequestController::class, 'print'])->name('pengajuan-saya.print');
        Route::put('/update/{id}', [MyRequestController::class, 'update'])->name('pengajuan-saya.update');
        Route::delete('/delete/{id}', [MyRequestController::class, 'destroy'])->name('pengajuan-saya.destroy');
        Route::get('/check', [MyRequestController::class, 'checkStatus'])->name('pengajuan-saya.check');
    });

    Route::prefix('pengaduan-saya')->group(function () {
        Route::get('/', [MyComplaintController::class, 'index'])->name('pengaduan-saya.index');
        Route::get('/create', [MyComplaintController::class, 'create'])->name('pengaduan-saya.create');
        Route::post('/store', [MyComplaintController::class, 'store'])->name('pengaduan-saya.store');
        Route::get('/show/{id}', [MyComplaintController::class, 'show'])->name('pengaduan-saya.show');
        Route::get('/edit/{id}', [MyComplaintController::class, 'edit'])->name('pengaduan-saya.edit');
        Route::put('/update/{id}', [MyComplaintController::class, 'update'])->name('pengaduan-saya.update');
        Route::delete('/delete/{id}', [MyComplaintController::class, 'destroy'])->name('pengaduan-saya.destroy');
        Route::get('/check', [MyComplaintController::class, 'checkStatus'])->name('pengaduan-saya.check');
    });


    Route::prefix('data-pengaduan')->group(function () {
        Route::get('/', [ComplaintController::class, 'index'])->name('data-pengaduan.index');
        Route::get('/show/{id}', [ComplaintController::class, 'show'])->name('data-pengaduan.show');
        Route::get('verifikasi-operator/{id}', [ComplaintController::class, 'verifikasiOperator'])->name('data-pengaduan.verifikasi-operator');
        Route::post('verifikasi-process/{id}', [ComplaintController::class, 'verifikasiProcess'])->name('data-pengaduan.verifikasi-process');
        Route::get('verifikasi-admin/{id}', [ComplaintController::class, 'verifikasiAdmin'])->name('data-pengaduan.verifikasi-admin');
        Route::post('verifikasi-admin-process/{id}', [ComplaintController::class, 'verifikasiAdminProcess'])->name('data-pengaduan.verifikasi-admin-process');
    });
    // Route::resource('pengaduan-saya', MyComplaintController::class);

    Route::prefix('informasi-kelurahan')->group(function () {
        Route::get('/', [InformationController::class, 'index'])->name('informasi-kelurahan.index');
        Route::get('/create', [InformationController::class, 'create'])->name('informasi-kelurahan.create');
        Route::post('/store', [InformationController::class, 'store'])->name('informasi-kelurahan.store');
        Route::get('/show/{id}', [InformationController::class, 'show'])->name('informasi-kelurahan.show');
        Route::get('/edit/{id}', [InformationController::class, 'edit'])->name('informasi-kelurahan.edit');
        Route::put('/update/{id}', [InformationController::class, 'update'])->name('informasi-kelurahan.update');
        Route::delete('/delete/{id}', [InformationController::class, 'destroy'])->name('informasi-kelurahan.destroy');
        Route::post('{id}/toggle-status', [InformationController::class, 'toggleStatus'])->name('informasi-kelurahan.toggle-status');
    });

    Route::prefix('notifikasi')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('notifikasi.index');
        Route::post('{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifikasi.mark-as-read');
        Route::post('mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifikasi.mark-all-read');

    });


    Route::prefix('verifikasi-pendaftaran')->group(function () {
        Route::get('{id}', [UserController::class, 'verification'])->name('verifikasi-pendaftaran.index');
        Route::post('{id}/verify', [UserController::class, 'verify'])->name('verifikasi-pendaftaran.verify');
    });


    Route::get('profile', [UserController::class, 'profile'])->name('profile.index');
    Route::put('profile/update', [UserController::class, 'profile'])->name('profile.update');
    
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings/store', [SettingController::class, 'save'])->name('settings.store');

    Route::get('profil-kelurahan', [SettingController::class, 'profile'])->name('profil-kelurahan.index');
    Route::post('profil-kelurahan/store', [SettingController::class, 'saveProfile'])->name('profil-kelurahan.store');
    
    
});

// Route::resource('data-masyarakat', ResidentController::class);


<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KhachHangController;
use App\Http\Controllers\HangHoaController;
use App\Http\Controllers\ChiTietController;
use App\Http\Controllers\ChiTietsController;
use App\Http\Controllers\ThongBaoXuatHangController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PrintController;

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Home / Profile
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/about', [HomeController::class, 'about'])->name('about');
    Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
    Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile');
    Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

    // Khach Hang & Hang Hoa CRUD
    Route::resource('khach-hangs', KhachHangController::class);
    Route::resource('hang-hoas', HangHoaController::class);

    // Chi Tiet Excel (Import/Export)
    Route::get('/chi-tiet/import', [ChiTietController::class, 'showImport'])->name('chi-tiet.import');
    Route::post('/chi-tiet/import', [ChiTietController::class, 'import']);
    Route::get('/chi-tiet/export-template', [ChiTietController::class, 'exportTemplate'])->name('chi-tiet.export-template');

    // Chi Tiets (Printed Shipping Marks)
    Route::resource('chi-tiets', ChiTietsController::class);
    Route::post('/chi-tiets/{id}/confirm-print', [ChiTietsController::class, 'confirmPrint'])->name('chi-tiets.confirm-print');

    // Mẫu In (Prints)
    Route::get('/prints/select/{id}', [PrintController::class, 'select'])->name('prints.select');
    Route::post('/prints/generate/{id}', [PrintController::class, 'generate'])->name('prints.generate');

    // Thong Bao Xuat Hang
    Route::get('/thong-bao', [ThongBaoXuatHangController::class, 'index'])->name('thong-bao.index');
    Route::get('/thong-bao/quick-create', [ThongBaoXuatHangController::class, 'quickCreate'])->name('thong-bao.quick-create');
    Route::post('/thong-bao/quick-create', [ThongBaoXuatHangController::class, 'storeQuickCreate'])->name('thong-bao.quick-create.store');
    Route::get('/thong-bao/{id}/edit', [ThongBaoXuatHangController::class, 'edit'])->name('thong-bao.edit');
    Route::get('/thong-bao/{id}', [ThongBaoXuatHangController::class, 'show'])->name('thong-bao.show');
    Route::post('/thong-bao/{id}/edit', [ThongBaoXuatHangController::class, 'update'])->name('thong-bao.update');
    Route::delete('/thong-bao/{id}', [ThongBaoXuatHangController::class, 'destroy'])->name('thong-bao.destroy');

    // Containers Management inside Thong Bao Flow
    Route::get('/thong-bao/{id}/containers', [ThongBaoXuatHangController::class, 'manageContainers'])->name('thong-bao.containers');
    Route::post('/thong-bao/{id}/containers', [ThongBaoXuatHangController::class, 'storeContainer'])->name('thong-bao.containers.store');
    Route::get('/containers/{id}/edit', [ThongBaoXuatHangController::class, 'editContainer'])->name('containers.edit');
    Route::post('/containers/{id}/edit', [ThongBaoXuatHangController::class, 'updateContainer'])->name('containers.update');
    Route::get('/containers/{id}/delete', [ThongBaoXuatHangController::class, 'deleteContainer'])->name('containers.delete-confirm');
    Route::delete('/containers/{id}', [ThongBaoXuatHangController::class, 'destroyContainer'])->name('containers.delete');

    // Báo cáo & PDF
    Route::get('/thong-bao/{id}/report', [ThongBaoXuatHangController::class, 'viewReport'])->name('thong-bao.report');
    Route::get('/thong-bao/{id}/pdf', [ThongBaoXuatHangController::class, 'downloadPdf'])->name('thong-bao.pdf');

    // User Management
    Route::resource('users', UserController::class);
    Route::get('/users/{id}/password', [UserController::class, 'editPassword'])->name('users.password.edit');
    Route::post('/users/{id}/password', [UserController::class, 'updatePassword'])->name('users.password.update');
});


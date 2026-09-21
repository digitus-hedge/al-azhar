<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\StatController;
use App\Http\Controllers\Admin\NewsNoticeController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\AboutController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->name('admin.')->group(function () {

    // Guest routes (login)
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.submit');

    Route::middleware('auth')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('home', [DashboardController::class, 'home'])->name('home');


        Route::get('home/banner', [BannerController::class, 'index'])->name('home.banner');       // Shows form directly (pre-filled if exists)
        Route::post('home/banner', [BannerController::class, 'store'])->name('home.banner.store'); // Creates or updates

        Route::get('home/stats', [StatController::class, 'index'])->name('home.stats');
        Route::post('home/stats', [StatController::class, 'store'])->name('home.stats.store');


        Route::get('staff', [StaffController::class, 'index'])->name('staff');
        Route::get('staff/create', [StaffController::class, 'create'])->name('staff.create');
        Route::post('staff', [StaffController::class, 'store'])->name('staff.store');
        Route::get('staff/{staffMember}/edit', [StaffController::class, 'edit'])->name('staff.edit');
        Route::put('staff/{staffMember}', [StaffController::class, 'update'])->name('staff.update');
        Route::delete('staff/{staffMember}', [StaffController::class, 'destroy'])->name('staff.destroy');


        Route::get('news-notices', [NewsNoticeController::class, 'index'])->name('news-notices');
        Route::get('news-notices/create', [NewsNoticeController::class, 'create'])->name('news-notices.create');
        Route::post('news-notices', [NewsNoticeController::class, 'store'])->name('news-notices.store');
        Route::get('news-notices/{newsNotice}/edit', [NewsNoticeController::class, 'edit'])->name('news-notices.edit');
        Route::put('news-notices/{newsNotice}', [NewsNoticeController::class, 'update'])->name('news-notices.update');
        Route::delete('news-notices/{newsNotice}', [NewsNoticeController::class, 'destroy'])->name('news-notices.destroy');

        Route::get('about', [AboutController::class, 'index'])->name('about');
        Route::post('about', [AboutController::class, 'store'])->name('about.store');

        Route::get('events', [EventController::class, 'index'])->name('events');
        Route::get('events/create', [EventController::class, 'create'])->name('events.create');
        Route::post('events', [EventController::class, 'store'])->name('events.store');
        Route::get('events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
        Route::put('events/{event}', [EventController::class, 'update'])->name('events.update');
        Route::delete('events/{event}', [EventController::class, 'destroy'])->name('events.destroy');


        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    });
});

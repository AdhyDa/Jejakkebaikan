<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Campaign Routes
Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaigns.index');

Route::middleware('auth')->group(function () {
    // Campaign Management - Route create HARUS di atas route {id}
    Route::get('/campaigns/create', [CampaignController::class, 'create'])->name('campaigns.create');
    Route::post('/campaigns', [CampaignController::class, 'store'])->name('campaigns.store');
    Route::get('/campaigns/{id}/edit', [CampaignController::class, 'edit'])->name('campaigns.edit');
    Route::put('/campaigns/{id}', [CampaignController::class, 'update'])->name('campaigns.update');
    Route::delete('/campaigns/{id}', [CampaignController::class, 'destroy'])->name('campaigns.destroy');

    // Donation Routes
    Route::post('/campaigns/{id}/donate-money', [DonationController::class, 'donateMoney'])->name('donations.money');
    Route::post('/campaigns/{id}/donate-goods', [DonationController::class, 'donateGoods'])->name('donations.goods');
    Route::post('/campaigns/{id}/register-volunteer', [DonationController::class, 'registerVolunteer'])->name('donations.volunteer');

    // Donation Management
    Route::post('/donations/goods/{id}/received', [DonationController::class, 'markGoodsReceived'])->name('donations.goods.received');
    Route::post('/donations/volunteer/{id}/approve', [DonationController::class, 'approveVolunteer'])->name('donations.volunteer.approve');
    Route::post('/donations/volunteer/{id}/reject', [DonationController::class, 'rejectVolunteer'])->name('donations.volunteer.reject');

    // Dashboard Routes
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->middleware('admin')->name('index');
        Route::get('/campaigns/{id}/manage', [DashboardController::class, 'manageCampaign'])->name('campaigns.manage');

        // Profile
        Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
        Route::put('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');

        // Password
        Route::get('/change-password', [DashboardController::class, 'changePassword'])->middleware('admin')->name('change-password');
        Route::put('/change-password', [DashboardController::class, 'updatePassword'])->middleware('admin')->name('password.update');

        // Donation History
        Route::get('/donation-history', [DashboardController::class, 'donationHistory'])->name('donation-history');

        // Campaign Status Update
        Route::post('/campaigns/{id}/update-status', [DashboardController::class, 'updateCampaignStatus'])->name('campaigns.update-status');

        // Campaign Updates (News)
        Route::post('/campaigns/{id}/add-update', [DashboardController::class, 'addCampaignUpdate'])->name('campaigns.add-update');

        // Campaign Delete
        Route::delete('/campaigns/{id}', [DashboardController::class, 'deleteCampaign'])->name('campaigns.delete');

        // Delete Account
        Route::get('/account', [DashboardController::class, 'showDeleteAccount'])->name('account.show');
        Route::delete('/account', [DashboardController::class, 'deleteAccount'])->name('account.delete');
    });

    // User Routes
    Route::view('/user/edit', 'user.edit')->name('user.edit');
    Route::get('/user/history', [DashboardController::class, 'donationHistory'])->name('user.history');
    Route::get('/user/change-password', [DashboardController::class, 'userChangePassword'])->name('user.change-password');
    Route::put('/user/change-password', [DashboardController::class, 'updatePassword'])->name('user.password.update');
});

// Campaign show route - HARUS setelah semua route spesifik
Route::get('/campaigns/{slug}', [CampaignController::class, 'show'])->name('campaigns.show');

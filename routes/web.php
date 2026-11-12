<?php

use App\Http\Controllers\ConversationController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Customer\CategoryController;
use App\Http\Controllers\Customer\ProfessionalController;
use App\Http\Controllers\Customer\ServiceRequestController;
use App\Http\Controllers\Professional\ProfileController as ProProfileController;
use App\Http\Controllers\Professional\RequestController as ProRequestController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminVerificationController;
use App\Http\Controllers\Admin\AdminRequestController;
use App\Http\Controllers\Admin\AdminCategoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['fr', 'en', 'de'])) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return back();
})->name('lang.switch');
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Categories
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

// Professionals
Route::get('/professionals', [ProfessionalController::class, 'index'])->name('professionals.index');
Route::get('/professionals/{provider}', [ProfessionalController::class, 'show'])->name('professionals.show');

// Static pages
Route::view('/about', 'pages.about')->name('about');
Route::view('/contact', 'pages.contact')->name('contact');

/*
|--------------------------------------------------------------------------
| Auth Routes (all logged-in users)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Conversations (Messaging) — Customer + Professional
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/conversations', [ConversationController::class, 'index'])->name('conversations.index');
    Route::get('/conversations/{conversation}', [ConversationController::class, 'show'])->name('conversations.show');
    Route::post('/conversations/{conversation}/messages', [MessageController::class, 'store'])->name('conversations.messages.store');
});

/*
|--------------------------------------------------------------------------
| Reviews
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::post('/requests/{serviceRequest}/review', [ReviewController::class, 'store'])->name('reviews.store');
});

/*
|--------------------------------------------------------------------------
| Professional Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:professional'])->prefix('pro')->name('pro.')->group(function () {
    // Profile
    Route::get('/profile', [ProProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/services', [ProProfileController::class, 'updateServices'])->name('profile.services');
    Route::put('/profile/areas', [ProProfileController::class, 'updateAreas'])->name('profile.areas');
    Route::put('/profile/availability', [ProProfileController::class, 'updateAvailability'])->name('profile.availability');

    // Requests
    Route::get('/requests', [ProRequestController::class, 'index'])->name('requests.index');
    Route::get('/requests/{serviceRequest}', [ProRequestController::class, 'show'])->name('requests.show');
    Route::post('/requests/{serviceRequest}/accept', [ProRequestController::class, 'accept'])->name('requests.accept');
    Route::post('/requests/{serviceRequest}/decline', [ProRequestController::class, 'decline'])->name('requests.decline');
    Route::post('/requests/{serviceRequest}/start', [ProRequestController::class, 'start'])->name('requests.start');
    Route::post('/requests/{serviceRequest}/complete', [ProRequestController::class, 'complete'])->name('requests.complete');
});

/*
|--------------------------------------------------------------------------
| Customer Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/requests', [ServiceRequestController::class, 'index'])->name('requests.index');
    Route::get('/requests/create', [ServiceRequestController::class, 'create'])->name('requests.create');
    Route::post('/requests', [ServiceRequestController::class, 'store'])->name('requests.store');
    Route::get('/requests/{serviceRequest}', [ServiceRequestController::class, 'show'])->name('requests.show');
    Route::post('/requests/{serviceRequest}/cancel', [ServiceRequestController::class, 'cancel'])->name('requests.cancel');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Users
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::patch('/users/{user}/suspend', [AdminUserController::class, 'suspend'])->name('users.suspend');
    Route::patch('/users/{user}/activate', [AdminUserController::class, 'activate'])->name('users.activate');

    // Verification
    Route::get('/verification', [AdminVerificationController::class, 'index'])->name('verification.index');
    Route::post('/verification/{provider}/verify', [AdminVerificationController::class, 'verify'])->name('verification.verify');
    Route::post('/verification/{provider}/reject', [AdminVerificationController::class, 'reject'])->name('verification.reject');

    // Requests
    Route::get('/requests', [AdminRequestController::class, 'index'])->name('requests.index');

    // Categories
    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');
});

/*
|--------------------------------------------------------------------------
| Auth Scaffolding (Breeze)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';

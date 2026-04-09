<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\Auth\ProviderController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;

use App\Http\Middleware\CheckAdmin;
use App\Http\Middleware\CheckAgeGate;
use Illuminate\Support\Facades\Route;

// Age Gate Middleware applied to customer viewing routes
Route::middleware([CheckAgeGate::class])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');
    
    Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');
});

Route::get('/generate-image/{name}', [ProductImageController::class, 'generateImage']);

// Google Socialite
Route::get('/auth/google', [ProviderController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [ProviderController::class, 'callback']);

// Authenticated User Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');

    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{product}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::post('/wishlist/remove/{product}', [WishlistController::class, 'remove'])->name('wishlist.remove');
});

// Admin Routes
Route::middleware(['auth', CheckAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', AdminCategoryController::class);
    Route::delete('products/delete-all', [AdminProductController::class, 'deleteAll'])->name('products.deleteAll');
    Route::resource('products', AdminProductController::class);
    Route::post('products/import', [AdminProductController::class, 'import'])->name('products.import');
    Route::post('products/sync-ubereats', [AdminProductController::class, 'syncToUberEats'])->name('products.sync-ubereats');
    Route::post('ubereats/webhook', [UberEatsWebhookController::class, 'handle']);
    Route::resource('users', AdminUserController::class);
    Route::resource('reviews', AdminReviewController::class);
    
    Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [AdminSettingController::class, 'store'])->name('settings.store');
    Route::post('/settings/upload-images', [AdminSettingController::class, 'updateImages'])->name('settings.updateImages');
});

require __DIR__.'/auth.php';

<?php

use App\Http\Controllers\SettingsController;
use App\Http\Controllers\WishlistController;
use App\Models\Settings;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
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



Route::middleware(['verify.shopify'])->group(function () {
    Route::get('/', function () {
        $shop = Auth::user();
        $setting = Settings::where("shop_id", $shop->name)->first();
        return view('dashboard', [
            "settings" => $setting
        ]);
        // dd(request()->path());
    })->name('home');
    Route::get('/products', [WishlistController::class, "index"])->name('products');
    Route::view('/customers', 'customers')->name('customers');
    Route::view('/settings', 'settings')->name('settings');
    Route::post('/configuretheme', [SettingsController::class, 'create']);
    // Route::get('test', [WishlistController::class, "index"]);
});

// clientside API

Route::post('/api/addToWishlist', [WishlistController::class, "store"]);
Route::post('/api/removeFromWishlist', [WishlistController::class, "destroy"]);
Route::post('/api/wishlistItemExists', [WishlistController::class, "show"]);

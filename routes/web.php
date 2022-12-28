<?php

use App\Http\Controllers\SettingsController;
use App\Http\Controllers\WishlistController;
use App\Models\Settings;
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
    Route::view('/products', 'products')->name('products');
    Route::view('/customers', 'customers')->name('customers');
    Route::view('/settings', 'settings')->name('settings');
    Route::post('/configuretheme', [SettingsController::class, 'create']);
    Route::get('test', function () {
        $shop = Auth::user();
        $scriptTags = $shop->api()->rest('GET', '/admin/api/2022-10/script_tags.json');

        return json_encode($scriptTags);
    });
});

// clientside API

Route::post('/api/addToWishlist', [WishlistController::class, "store"]);
Route::post('/api/removeFromWishlist', [WishlistController::class, "destroy"]);

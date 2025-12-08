<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DeepLinkController;


Route::get('/run-command', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('migrate');
    return "Command executed!";
});


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/get_home_data_page_wise', [HomeController::class, 'get_home_data_page_wise'])->name('get_home_data_page_wise');


Route::get('brands', [HomeController::class, 'brands'])->name('brands');
Route::get('offer', [HomeController::class, 'offer'])->name('offer');
Route::get('events', [HomeController::class, 'events'])->name('events');
Route::get('about_brand/{id}', [HomeController::class, 'about_brand'])->name('about_brand');
Route::get('about_us', [HomeController::class, 'about_us'])->name('about');
Route::get('contact_us', [HomeController::class, 'contact_us'])->name('contact_us');
Route::get('about_brand_offer', [HomeController::class, 'about_brand_offer'])->name('about_brand_offer');
Route::get('events_details', [HomeController::class, 'events_details'])->name('events_details');
Route::get('profile', [HomeController::class, 'profile'])->name('profile');
Route::get('shopping', [HomeController::class, 'shopping'])->name('shopping');
Route::get('hot_deal', [HomeController::class, 'hot_deal'])->name('hot_deal');
Route::get('fashion_apparel', [HomeController::class, 'fashion_apparel'])->name('fashion_apparel');
Route::get('order_summary', [HomeController::class, 'order_summary'])->name('order_summary');
Route::get('cart', [HomeController::class, 'cart'])->name('cart');
Route::get('categories', [HomeController::class, 'categories'])->name('categories');
Route::get('history', [HomeController::class, 'history'])->name('history');

Route::get('/d/{code}/{id}/{type}', [DeepLinkController::class, 'redirect'])->name('deeplink.redirect');


Route::middleware(['auth'])->group(function () {

   

});
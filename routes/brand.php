<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Brand\LoginController;
use App\Http\Controllers\Brand\DashboardController;
use App\Http\Controllers\Brand\BranchController;
use App\Http\Controllers\Brand\ProductController;
use App\Http\Controllers\Brand\OrderController;
use App\Http\Controllers\Brand\BookingController;


Route::get('brand/login', [LoginController::class, 'showLoginForm'])->name('brand.login');
Route::post('brand/send_otp', [LoginController::class, 'send_otp'])->name('brand.send_otp');
Route::get('brand/showotp', [LoginController::class, 'showotp'])->name('brand.showotp');
Route::post('brand/verify_otp', [LoginController::class, 'verify_otp'])->name('brand.verify_otp');
Route::get('brand/logout', [LoginController::class, 'logout'])->name('brand.logout');



Route::middleware(['brand'])->group(function () {
    Route::get('/brand/dashboard', [DashboardController::class, 'index'])->name('brand.dashboard');

     /* Branch */
        Route::get('/brand/branch', [BranchController::class, 'index'])->name('brand.branch');
        Route::get('/brand/branch_list', [BranchController::class, 'get_list'])->name('brand.branch_list');
        Route::get('/brand/branch_edit/{id}', [BranchController::class, 'branch_edit'])->name('brand.branch_edit');
        Route::post('/brand/update_branch', [BranchController::class, 'update_branch'])->name('brand.update_branch');
        Route::post('/brand/branch_status_change', [BranchController::class, 'branch_status_change'])->name('brand.branch_status_change');
        Route::post('/brand/branch_delete', [BranchController::class, 'branch_delete'])->name('brand.branch_delete');
        Route::post('/brand/menu_delete', [BranchController::class, 'menu_delete'])->name('brand.menu_delete');
    /* Branch */

    /* Product */
        Route::get('/brand/product', [ProductController::class, 'index'])->name('brand.product');
        Route::get('/brand/product_list', [ProductController::class, 'get_list'])->name('brand.product_list');
        Route::get('/brand/add_product', [ProductController::class, 'add_product'])->name('brand.add_product');
        Route::post('/brand/insert_product', [ProductController::class, 'insert_product'])->name('brand.insert_product');
        Route::get('/brand/product_edit/{id}', [ProductController::class, 'product_edit'])->name('brand.product_edit');
        Route::post('/brand/update_product', [ProductController::class, 'update_product'])->name('brand.update_product');
    /* Product */

     /* Order */
        Route::get('/brand/order', [OrderController::class, 'index'])->name('brand.order');
        Route::get('/brand/order_list', [OrderController::class, 'get_list'])->name('brand.order_list');
        Route::get('/brand/order_view/{id}', [OrderController::class, 'order_view'])->name('brand.order_view');
        Route::post('/brand/order_change_status', [OrderController::class, 'order_change_status'])->name('brand.order_change_status');
    /* Order */

    /* Booking */
        Route::get('/brand/booking', [BookingController::class, 'index'])->name('brand.booking');
        Route::get('/brand/booking_list', [BookingController::class, 'get_list'])->name('brand.booking_list');
        Route::get('/brand/booking_view/{id}', [BookingController::class, 'booking_view'])->name('brand.booking_view');
        Route::post('/brand/booking_change_status', [BookingController::class, 'booking_change_status'])->name('brand.booking_change_status');
    /* Booking */

});

?>
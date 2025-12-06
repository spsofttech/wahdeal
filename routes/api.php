<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\OfferController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\DealController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\PlanController;
use App\Http\Controllers\Api\UserLocationController;
use App\Http\Controllers\Api\FashionController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\HelpController;
use App\Http\Controllers\Api\BookingController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('send_otp', [UserController::class, 'send_otp']);
Route::post('verify_otp', [UserController::class, 'verify_otp']);
Route::post('login', [UserController::class, 'login']);

Route::post('/home', [HomeController::class, 'index']);
Route::post('category', [CategoryController::class, 'index']);
Route::get('offer_type', [OfferController::class, 'offer_type']);
Route::post('offer', [OfferController::class, 'index']);
Route::post('brand', [BrandController::class, 'index']);

Route::post('category_product', [ProductController::class, 'index']);
Route::post('product', [ProductController::class, 'product']);


Route::post('/event', [EventController::class, 'index']);
Route::post('/event_detail', [EventController::class, 'event_detail']);

Route::post('plan', [PlanController::class, 'index']);


Route::post('/fashion_home', [FashionController::class, 'index']);
Route::post('/fashion_category_product', [FashionController::class, 'fashion_category_product']);
Route::post('/fashion_product_detail', [FashionController::class, 'fashion_product_detail']);

Route::post('/get_product_size_color', [CartController::class, 'get_product_size_color']);
Route::post('/get_cart_product_brand', [CartController::class, 'get_cart_product_brand']);

Route::middleware(['jwt.auth'])->group(function () {

    /* Home */
    Route::post('like_unlike', [HomeController::class, 'like_unlike']);
    /* Home */

    /* profile */
    Route::get('/user_profile', [UserController::class, 'user_profile']);
    Route::post('update_profile', [UserController::class, 'update_profile']);
    Route::post('update_password', [UserController::class, 'update_password']);
    Route::post('promo_code_submit', [UserController::class, 'promo_code_submit']);
    Route::post('invited_friend', [UserController::class, 'invited_friend']);
    /* profile */

    
    /* Address */
    Route::post('add_address', [AddressController::class, 'store']);
    Route::post('update_address', [AddressController::class, 'update']);
    /* Address */


    /* Product */
    Route::post('add_rating', [ProductController::class, 'add_rating']);
    Route::post('edit_rating', [ProductController::class, 'edit_rating']);
    Route::post('delete_rating', [ProductController::class, 'delete_rating']);
    /* Product */


    /* Deals */
    Route::post('redeem', [DealController::class, 'redeem']);
    Route::post('active_deal', [DealController::class, 'active_deal']);
    Route::post('expired_deal', [DealController::class, 'expired_deal']);
    Route::post('favorite', [DealController::class, 'favorite']);
    Route::post('fashion_favorite', [DealController::class, 'fashion_favorite']);
    /* Deals */

    

     /* Setting */
    Route::post('notification_setting', [SettingController::class, 'notification_setting']);
    /* Setting */

    
    /* Event Ticket */
    Route::post('/event_ticket', [EventController::class, 'event_ticket']);
    /* Event Ticket */


    /* Payment History */
    Route::get('/payment_history', [PaymentController::class, 'index']);
    Route::get('/purchase_history', [PaymentController::class, 'purchase_history']);
    /* Payment History */


    /* User Location */
    Route::post('/user_location', [UserLocationController::class, 'index']);
    Route::post('/user_location_set', [UserLocationController::class, 'user_location_set']);
    Route::post('/user_location_delete', [UserLocationController::class, 'user_location_delete']);
    /* User Location */


    
    /* Cart */
    Route::post('/add_to_cart', [CartController::class, 'add_to_cart']);
    Route::post('/my_cart', [CartController::class, 'my_cart']);
    Route::post('/add_cart_item', [CartController::class, 'add_cart_item']);
    Route::post('/minus_cart_item', [CartController::class, 'minus_cart_item']);
    Route::post('/change_cart_item_size', [CartController::class, 'change_cart_item_size']);
    Route::post('/delete_cart_item', [CartController::class, 'delete_cart_item']);

    
   /* Cart */


    /* Order */
        Route::post('/create_order', [OrderController::class, 'create_order']);
        Route::post('/order_history', [OrderController::class, 'order_history']);
        Route::post('/order_detail', [OrderController::class, 'order_detail']);
        Route::post('/change_order_delivery_address', [OrderController::class, 'change_order_delivery_address']);
        Route::post('/cancel_order_item', [OrderController::class, 'cancel_order_item']);
        Route::post('/cancel_order', [OrderController::class, 'cancel_order']);
    /* Order */


    /* Order Help Support */
        Route::get('/order_support_category', [HelpController::class, 'order_support_category']);
    /* Order Help Support */


    /* Booking */
        Route::post('/create_booking', [BookingController::class, 'create_booking']);
        Route::post('/booking_history', [BookingController::class, 'booking_history']);
        Route::post('/booking_cancel', [BookingController::class, 'booking_cancel']);
    /* Booking */

    


    Route::post('/logout', [UserController::class, 'logout']);
});
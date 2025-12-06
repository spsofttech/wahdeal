<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\EventCategoryController;
use App\Http\Controllers\Admin\OfferTypeController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\EventPassController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\FashionBannerController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ProductIssueCategoryController;
use App\Http\Controllers\Admin\ProductIssueReasonController;
use App\Http\Controllers\Admin\CategoryFormFieldOptionController;
use App\Http\Controllers\Admin\CategoryFormFieldController;
use App\Http\Controllers\Admin\BookingCancelReasonController;
use App\Http\Controllers\Admin\BranchRequestController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ProductRequestController;





Route::get('admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/send_otp', [AdminController::class, 'send_otp'])->name('admin.send_otp');
Route::get('admin/showotp', [AdminController::class, 'showotp'])->name('admin.showotp');
Route::post('admin/verify_otp', [AdminController::class, 'verify_otp'])->name('admin.verify_otp');
Route::get('admin/logout', [AdminController::class, 'logout'])->name('admin.logout');



Route::middleware(['admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    /* Category */
        Route::get('/admin/category', [CategoryController::class, 'index'])->name('admin.category');
        Route::get('/admin/category_list', [CategoryController::class, 'get_list'])->name('admin.category_list');
        Route::post('/admin/category_reorder', [CategoryController::class, 'category_reorder'])->name('admin.category_reorder');
        Route::get('/admin/add_category', [CategoryController::class, 'add_category'])->name('admin.add_category');
        Route::post('/admin/insert_category', [CategoryController::class, 'insert_category'])->name('admin.insert_category');
        Route::post('/admin/category_status_change', [CategoryController::class, 'category_status_change'])->name('admin.category_status_change');
        Route::get('/admin/category_edit/{id}', [CategoryController::class, 'category_edit'])->name('admin.category_edit');
        Route::post('/admin/update_category', [CategoryController::class, 'update_category'])->name('admin.update_category');
        Route::post('/admin/category_delete', [CategoryController::class, 'category_delete'])->name('admin.category_delete');
    /* Category */


    /* Sub Category */
        Route::get('/admin/sub_category', [SubCategoryController::class, 'index'])->name('admin.sub_category');
        Route::get('/admin/sub_category_list', [SubCategoryController::class, 'get_list'])->name('admin.sub_category_list');
        Route::post('/admin/sub_category_reorder', [SubCategoryController::class, 'sub_category_reorder'])->name('admin.sub_category_reorder');
        Route::get('/admin/add_subcategory', [SubCategoryController::class, 'add_subcategory'])->name('admin.add_subcategory');
        Route::post('/admin/insert_sub_category', [SubCategoryController::class, 'insert_sub_category'])->name('admin.insert_sub_category');
        Route::post('/admin/sub_category_status_change', [SubCategoryController::class, 'sub_category_status_change'])->name('admin.sub_category_status_change');
        Route::get('/admin/sub_category_edit/{id}', [SubCategoryController::class, 'sub_category_edit'])->name('admin.sub_category_edit');
        Route::post('/admin/update_sub_category', [SubCategoryController::class, 'update_sub_category'])->name('admin.update_sub_category');
        Route::post('/admin/sub_category_delete', [SubCategoryController::class, 'sub_category_delete'])->name('admin.sub_category_delete');
    /* Sub Category */


     /* Event Category */
        Route::get('/admin/event_category', [EventCategoryController::class, 'index'])->name('admin.event_category');
        Route::get('/admin/event_category_list', [EventCategoryController::class, 'get_list'])->name('admin.event_category_list');
        Route::post('/admin/event_category_reorder', [EventCategoryController::class, 'category_reorder'])->name('admin.event_category_reorder');
        Route::get('/admin/add_event_category', [EventCategoryController::class, 'add_event_category'])->name('admin.add_event_category');
        Route::post('/admin/insert_event_category', [EventCategoryController::class, 'insert_event_category'])->name('admin.insert_event_category');
        Route::post('/admin/event_category_status_change', [EventCategoryController::class, 'category_status_change'])->name('admin.event_category_status_change');
        Route::get('/admin/event_category_edit/{id}', [EventCategoryController::class, 'event_category_edit'])->name('admin.event_category_edit');
        Route::post('/admin/update_event_category', [EventCategoryController::class, 'update_event_category'])->name('admin.update_event_category');
        Route::post('/admin/event_category_delete', [EventCategoryController::class, 'category_delete'])->name('admin.event_category_delete');
    /* Event Category */


    


    /* Brand */
        Route::get('/admin/brand', [BrandController::class, 'index'])->name('admin.brand');
        Route::get('/admin/brand_list', [BrandController::class, 'get_list'])->name('admin.brand_list');
        Route::get('/admin/add_brand', [BrandController::class, 'add_brand'])->name('admin.add_brand');
        Route::post('/admin/insert_brand', [BrandController::class, 'insert_brand'])->name('admin.insert_brand');
        Route::get('/admin/brand_view/{id}', [BrandController::class, 'brand_view'])->name('admin.brand_view');
        Route::get('/admin/brand_edit/{id}', [BrandController::class, 'brand_edit'])->name('admin.brand_edit');
        Route::post('/admin/update_brand', [BrandController::class, 'update_brand'])->name('admin.update_brand');
        Route::post('/admin/brand_status_change', [BrandController::class, 'brand_status_change'])->name('admin.brand_status_change');
        Route::post('/admin/change_promote_status', [BrandController::class, 'change_promote_status'])->name('admin.change_promote_status');
        Route::post('/admin/brand_delete', [BrandController::class, 'brand_delete'])->name('admin.brand_delete');
        Route::post('/admin/menu_delete', [BrandController::class, 'menu_delete'])->name('admin.menu_delete');
        Route::post('/admin/brand_gallery_delete', [BrandController::class, 'brand_gallery_delete'])->name('admin.brand_gallery_delete');
        Route::post('/admin/get_subcategory', [BrandController::class, 'get_subcategory'])->name('admin.get_subcategory');
    /* Brand */


    /* Branch */
        Route::get('/admin/branch', [BranchController::class, 'index'])->name('admin.branch');
        Route::get('/admin/branch_list', [BranchController::class, 'get_list'])->name('admin.branch_list');
        Route::get('/admin/add_branch', [BranchController::class, 'add_branch'])->name('admin.add_branch');
        Route::post('/admin/insert_branch', [BranchController::class, 'insert_branch'])->name('admin.insert_branch');
        Route::get('/admin/branch_edit/{id}', [BranchController::class, 'branch_edit'])->name('admin.branch_edit');
        Route::post('/admin/update_branch', [BranchController::class, 'update_branch'])->name('admin.update_branch');
        Route::post('/admin/branch_status_change', [BranchController::class, 'branch_status_change'])->name('admin.branch_status_change');
        Route::post('/admin/branch_delete', [BranchController::class, 'branch_delete'])->name('admin.branch_delete');
    /* Branch */

    /* Branch Request */
        Route::get('/admin/branch_request', [BranchRequestController::class, 'index'])->name('admin.branch_request');
        Route::get('/admin/branch_request_list', [BranchRequestController::class, 'get_list'])->name('admin.branch_request_list');
        Route::get('/admin/branch_request_view/{id}', [BranchRequestController::class, 'branch_request_view'])->name('admin.branch_request_view');
        Route::post('/admin/branch_request_change_status', [BranchRequestController::class, 'branch_request_change_status'])->name('admin.branch_request_change_status');
    /* Branch Request */


    /* Banner */
        Route::get('/admin/banner', [BannerController::class, 'index'])->name('admin.banner');
        Route::get('/admin/banner_list', [BannerController::class, 'get_list'])->name('admin.banner_list');
        Route::get('/admin/add_banner', [BannerController::class, 'add_banner'])->name('admin.add_banner');
        Route::post('/admin/insert_banner', [BannerController::class, 'insert_banner'])->name('admin.insert_banner');
        Route::get('/admin/banner_edit/{id}', [BannerController::class, 'banner_edit'])->name('admin.banner_edit');
        Route::post('/admin/update_banner', [BannerController::class, 'update_banner'])->name('admin.update_banner');
        Route::post('/admin/banner_status_change', [BannerController::class, 'banner_status_change'])->name('admin.banner_status_change');
        Route::post('/admin/banner_delete', [BannerController::class, 'banner_delete'])->name('admin.banner_delete');
   /* Banner */



    /* Fashion Banner */
        Route::get('/admin/fashion_banner', [FashionBannerController::class, 'index'])->name('admin.fashion_banner');
        Route::get('/admin/fashion_banner_list', [FashionBannerController::class, 'get_list'])->name('admin.fashion_banner_list');
        Route::get('/admin/add_fashion_banner', [FashionBannerController::class, 'add_fashion_banner'])->name('admin.add_fashion_banner');
        Route::post('/admin/insert_fashion_banner', [FashionBannerController::class, 'insert_fashion_banner'])->name('admin.insert_fashion_banner');
        Route::get('/admin/fashion_banner_edit/{id}', [FashionBannerController::class, 'fashion_banner_edit'])->name('admin.fashion_banner_edit');
        Route::post('/admin/update_fashion_banner', [FashionBannerController::class, 'update_fashion_banner'])->name('admin.update_fashion_banner');
        Route::post('/admin/fashion_banner_status_change', [FashionBannerController::class, 'fashion_banner_status_change'])->name('admin.fashion_banner_status_change');
        Route::post('/admin/fashion_banner_delete', [FashionBannerController::class, 'fashion_banner_delete'])->name('admin.fashion_banner_delete');
   /* Fashion Banner */



   /* Product */
        Route::get('/admin/product', [ProductController::class, 'index'])->name('admin.product');
        Route::get('/admin/product_list', [ProductController::class, 'get_list'])->name('admin.product_list');
        Route::get('/admin/add_product', [ProductController::class, 'add_product'])->name('admin.add_product');
        Route::post('/admin/new_product_insert', [ProductController::class, 'new_product_insert'])->name('admin.new_product_insert');
        Route::get('/admin/product_view/{id}', [ProductController::class, 'product_view'])->name('admin.product_view');
        Route::get('/admin/product_edit/{id}', [ProductController::class, 'product_edit'])->name('admin.product_edit');
        Route::post('/admin/update_product', [ProductController::class, 'update_product'])->name('admin.update_product');
        Route::post('/admin/product_status_change', [ProductController::class, 'product_status_change'])->name('admin.product_status_change');
        Route::post('/admin/change_product_promote_status', [ProductController::class, 'change_product_promote_status'])->name('admin.change_product_promote_status');
        Route::post('/admin/product_delete', [ProductController::class, 'product_delete'])->name('admin.product_delete');
        Route::post('/admin/get_brand', [ProductController::class, 'get_brand'])->name('admin.get_brand');
        Route::post('/admin/product_image_delete', [ProductController::class, 'product_image_delete'])->name('admin.product_image_delete');
        Route::post('/admin/product_price_delete', [ProductController::class, 'product_price_delete'])->name('admin.product_price_delete');
    /* Product */

    /* Product Request */
        Route::get('/admin/product_request', [ProductRequestController::class, 'index'])->name('admin.product_request');
        Route::get('/admin/product_request_list', [ProductRequestController::class, 'get_list'])->name('admin.product_request_list');
        Route::get('/admin/product_request_view/{id}', [ProductRequestController::class, 'product_request_view'])->name('admin.product_request_view');
        Route::post('/admin/product_request_change_status', [ProductRequestController::class, 'product_request_change_status'])->name('admin.product_request_change_status');
    /* Product Request */


    
    /* Size */
        Route::get('/admin/size', [SizeController::class, 'index'])->name('admin.size');
        Route::get('/admin/size_list', [SizeController::class, 'get_list'])->name('admin.size_list');
        Route::get('/admin/add_size', [SizeController::class, 'add_size'])->name('admin.add_size');
        Route::post('/admin/insert_size', [SizeController::class, 'insert_size'])->name('admin.insert_size');
        Route::get('/admin/size_edit/{id}', [SizeController::class, 'size_edit'])->name('admin.size_edit');
        Route::post('/admin/update_size', [SizeController::class, 'update_size'])->name('admin.update_size');
        Route::post('/admin/size_status_change', [SizeController::class, 'size_status_change'])->name('admin.size_status_change');
        Route::post('/admin/size_delete', [SizeController::class, 'size_delete'])->name('admin.size_delete');
    /* Size */


    /* Color */
        Route::get('/admin/color', [ColorController::class, 'index'])->name('admin.color');
        Route::get('/admin/color_list', [ColorController::class, 'get_list'])->name('admin.color_list');
        Route::get('/admin/add_color', [ColorController::class, 'add_color'])->name('admin.add_color');
        Route::post('/admin/insert_color', [ColorController::class, 'insert_color'])->name('admin.insert_color');
        Route::get('/admin/color_edit/{id}', [ColorController::class, 'color_edit'])->name('admin.color_edit');
         Route::post('/admin/update_color', [ColorController::class, 'update_color'])->name('admin.update_color');
        Route::post('/admin/color_status_change', [ColorController::class, 'color_status_change'])->name('admin.color_status_change');
        Route::post('/admin/color_delete', [ColorController::class, 'color_delete'])->name('admin.color_delete');
    /* Color */



    /* Plan */
        Route::get('/admin/plan', [PlanController::class, 'index'])->name('admin.plan');
        Route::get('/admin/plan_list', [PlanController::class, 'get_list'])->name('admin.plan_list');
        Route::get('/admin/add_plan', [PlanController::class, 'add_plan'])->name('admin.add_plan');
        Route::post('/admin/insert_plan', [PlanController::class, 'insert_plan'])->name('admin.insert_plan');
        Route::get('/admin/plan_edit/{id}', [PlanController::class, 'plan_edit'])->name('admin.plan_edit');
        Route::post('/admin/update_plan', [PlanController::class, 'update_plan'])->name('admin.update_plan');
        Route::post('/admin/plan_status_change', [PlanController::class, 'plan_status_change'])->name('admin.plan_status_change');
        Route::post('/admin/plan_delete', [PlanController::class, 'plan_delete'])->name('admin.plan_delete');
    /* Plan */



    /* Offer Type */
        Route::get('/admin/offer_type', [OfferTypeController::class, 'index'])->name('admin.offer_type');
        Route::get('/admin/offer_type_list', [OfferTypeController::class, 'get_list'])->name('admin.offer_type_list');
        Route::get('/admin/add_offer_type', [OfferTypeController::class, 'add_offer_type'])->name('admin.add_offer_type');
        Route::post('/admin/insert_offer_type', [OfferTypeController::class, 'insert_offer_type'])->name('admin.insert_offer_type');
        Route::get('/admin/offer_type_edit/{id}', [OfferTypeController::class, 'offer_type_edit'])->name('admin.offer_type_edit');
        Route::post('/admin/update_offer_type', [OfferTypeController::class, 'update_offer_type'])->name('admin.update_offer_type');
        Route::post('/admin/offer_type_status_change', [OfferTypeController::class, 'offer_type_status_change'])->name('admin.offer_type_status_change');
        Route::post('/admin/offer_type_delete', [OfferTypeController::class, 'offer_type_delete'])->name('admin.offer_type_delete');
    /* Offer Type */



     /* Offer*/
        Route::get('/admin/offer', [OfferController::class, 'index'])->name('admin.offer');
        Route::get('/admin/offer_list', [OfferController::class, 'get_list'])->name('admin.offer_list');
        Route::get('/admin/add_offer', [OfferController::class, 'add_offer'])->name('admin.add_offer');
        Route::post('/admin/insert_offer', [OfferController::class, 'insert_offer'])->name('admin.insert_offer');
        Route::get('/admin/offer_edit/{id}', [OfferController::class, 'offer_edit'])->name('admin.offer_edit');
        Route::post('/admin/update_offer', [OfferController::class, 'update_offer'])->name('admin.update_offer');
        Route::post('/admin/offer_status_change', [OfferController::class, 'offer_status_change'])->name('admin.offer_status_change');
        Route::post('/admin/offer_delete', [OfferController::class, 'offer_delete'])->name('admin.offer_delete');
        Route::post('/admin/get_branch_using_product', [OfferController::class, 'get_branch_using_product'])->name('admin.get_branch_using_product');
        Route::post('/admin/get_branch_using_brand', [OfferController::class, 'get_branch_using_brand'])->name('admin.get_branch_using_brand');
        
    /* Offer*/


    /* Event */
        Route::get('/admin/event', [EventController::class, 'index'])->name('admin.event');
        Route::get('/admin/event_list', [EventController::class, 'get_list'])->name('admin.event_list');
        Route::get('/admin/add_event', [EventController::class, 'add_event'])->name('admin.add_event');
        Route::post('/admin/insert_event', [EventController::class, 'insert_event'])->name('admin.insert_event');
        Route::get('/admin/event_edit/{id}', [EventController::class, 'event_edit'])->name('admin.event_edit');
        Route::post('/admin/update_event', [EventController::class, 'update_event'])->name('admin.update_event');
        Route::get('/admin/event_view/{id}', [EventController::class, 'event_view'])->name('admin.event_view');
        Route::post('/admin/event_status_change', [EventController::class, 'event_status_change'])->name('admin.event_status_change');
        Route::post('/admin/event_delete', [EventController::class, 'event_delete'])->name('admin.event_delete');
        Route::post('/admin/celebrity_delete', [EventController::class, 'celebrity_delete'])->name('admin.celebrity_delete');
    /* Event */


    /* Event */
        Route::get('/admin/event_pass', [EventPassController::class, 'index'])->name('admin.event_pass');
        Route::get('/admin/event_pass_list', [EventPassController::class, 'get_list'])->name('admin.event_pass_list');
        Route::get('/admin/add_event_pass', [EventPassController::class, 'add_event_pass'])->name('admin.add_event_pass');
        Route::post('/admin/insert_event_pass', [EventPassController::class, 'insert_event_pass'])->name('admin.insert_event_pass');
        Route::get('/admin/event_pass_edit/{id}', [EventPassController::class, 'event_pass_edit'])->name('admin.event_pass_edit');
        Route::post('/admin/update_event_pass', [EventPassController::class, 'update_event_pass'])->name('admin.update_event_pass');
        Route::post('/admin/delete_event_pass', [EventPassController::class, 'delete_event_pass'])->name('admin.delete_event_pass');
    /* Event */



    /* User*/
        Route::get('/admin/user', [UserController::class, 'index'])->name('admin.user');
        Route::get('/admin/user_list', [UserController::class, 'get_list'])->name('admin.user_list');
        Route::get('/admin/user_view/{id}', [UserController::class, 'user_view'])->name('admin.user_view');
        Route::get('/admin/user_edit/{id}', [UserController::class, 'user_edit'])->name('admin.user_edit');
        Route::post('/admin/update_user', [UserController::class, 'update_user'])->name('admin.update_user');
        Route::post('/admin/user_status_change', [UserController::class, 'user_status_change'])->name('admin.user_status_change');
        Route::post('/admin/user_delete', [UserController::class, 'user_delete'])->name('admin.user_delete');
    /* User*/


    /* Coupon */
        Route::get('/admin/coupon', [CouponController::class, 'index'])->name('admin.coupon');
        Route::get('/admin/coupon_list', [CouponController::class, 'get_list'])->name('admin.coupon_list');
        Route::get('/admin/add_coupon', [CouponController::class, 'add_coupon'])->name('admin.add_coupon');
        Route::post('/admin/insert_coupon', [CouponController::class, 'insert_coupon'])->name('admin.insert_coupon');
        Route::get('/admin/coupon_edit/{id}', [CouponController::class, 'coupon_edit'])->name('admin.coupon_edit');
        Route::post('/admin/update_coupon', [CouponController::class, 'update_coupon'])->name('admin.update_coupon');
        Route::post('/admin/coupon_status_change', [CouponController::class, 'coupon_status_change'])->name('admin.coupon_status_change');
        Route::post('/admin/coupon_delete', [CouponController::class, 'coupon_delete'])->name('admin.coupon_delete');
    /* Coupon */

    /* Role */
        Route::get('/admin/role', [RoleController::class, 'index'])->name('admin.role');
        Route::post('/admin/get_role_using_branch', [RoleController::class, 'get_role_using_branch'])->name('admin.get_role_using_branch');
        Route::post('/admin/insert_role', [RoleController::class, 'insert_role'])->name('admin.insert_role');
    /* Role */


    /* Product Issue Category */
        Route::get('/admin/product_issue_category', [ProductIssueCategoryController::class, 'index'])->name('admin.product_issue_category');
        Route::get('/admin/product_issue_category_list', [ProductIssueCategoryController::class, 'get_list'])->name('admin.product_issue_category_list');
        Route::get('/admin/add_product_issue_category', [ProductIssueCategoryController::class, 'add_product_issue_category'])->name('admin.add_product_issue_category');
        Route::post('/admin/insert_product_issue_category', [ProductIssueCategoryController::class, 'insert_product_issue_category'])->name('admin.insert_product_issue_category');
        Route::get('/admin/product_issue_category_edit/{id}', [ProductIssueCategoryController::class, 'product_issue_category_edit'])->name('admin.product_issue_category_edit');
        Route::post('/admin/update_product_issue_category', [ProductIssueCategoryController::class, 'update_product_issue_category'])->name('admin.update_product_issue_category');
        Route::post('/admin/product_issue_category_status_change', [ProductIssueCategoryController::class, 'product_issue_category_status_change'])->name('admin.product_issue_category_status_change');
        Route::post('/admin/product_issue_category_delete', [ProductIssueCategoryController::class, 'product_issue_category_delete'])->name('admin.product_issue_category_delete');
    /* Product Issue Category */


    /* Product Issue Reason */
        Route::get('/admin/product_issue_reason', [ProductIssueReasonController::class, 'index'])->name('admin.product_issue_reason');
        Route::get('/admin/product_issue_reason_list', [ProductIssueReasonController::class, 'get_list'])->name('admin.product_issue_reason_list');
        Route::get('/admin/add_product_issue_reason', [ProductIssueReasonController::class, 'add_product_issue_reason'])->name('admin.add_product_issue_reason');
        Route::post('/admin/insert_product_issue_reason', [ProductIssueReasonController::class, 'insert_product_issue_reason'])->name('admin.insert_product_issue_reason');
        Route::get('/admin/product_issue_reason_edit/{id}', [ProductIssueReasonController::class, 'product_issue_reason_edit'])->name('admin.product_issue_reason_edit');
        Route::post('/admin/update_product_issue_reason', [ProductIssueReasonController::class, 'update_product_issue_reason'])->name('admin.update_product_issue_reason');
        Route::post('/admin/product_issue_reason_status_change', [ProductIssueReasonController::class, 'product_issue_reason_status_change'])->name('admin.product_issue_reason_status_change');
        Route::post('/admin/product_issue_reason_delete', [ProductIssueReasonController::class, 'product_issue_reason_delete'])->name('admin.product_issue_reason_delete');
    /* Product Issue Reason */


    /* Booking Reason */
        Route::get('/admin/booking_cancel_reason', [BookingCancelReasonController::class, 'index'])->name('admin.booking_cancel_reason');
        Route::get('/admin/booking_cancel_reason_list', [BookingCancelReasonController::class, 'get_list'])->name('admin.booking_cancel_reason_list');
        Route::get('/admin/add_booking_cancel_reason', [BookingCancelReasonController::class, 'add_booking_cancel_reason'])->name('admin.add_booking_cancel_reason');
        Route::post('/admin/insert_booking_cancel_reason', [BookingCancelReasonController::class, 'insert_booking_cancel_reason'])->name('admin.insert_booking_cancel_reason');
        Route::get('/admin/booking_cancel_reason_edit/{id}', [BookingCancelReasonController::class, 'booking_cancel_reason_edit'])->name('admin.booking_cancel_reason_edit');
        Route::post('/admin/update_booking_cancel_reason', [BookingCancelReasonController::class, 'update_booking_cancel_reason'])->name('admin.update_booking_cancel_reason');
        Route::post('/admin/booking_cancel_reason_status_change', [BookingCancelReasonController::class, 'booking_cancel_reason_status_change'])->name('admin.booking_cancel_reason_status_change');
        Route::post('/admin/booking_cancel_reason_delete', [BookingCancelReasonController::class, 'booking_cancel_reason_delete'])->name('admin.booking_cancel_reason_delete');
    /* Booking Reason */



    /* Category Booking Form Field Option */
        Route::get('/admin/category_form_field_option', [CategoryFormFieldOptionController::class, 'index'])->name('admin.category_form_field_option');
        Route::get('/admin/category_form_field_option_list', [CategoryFormFieldOptionController::class, 'get_list'])->name('admin.category_form_field_option_list');
        Route::get('/admin/add_category_form_field_option', [CategoryFormFieldOptionController::class, 'add_category_form_field_option'])->name('admin.add_category_form_field_option');
        Route::post('/admin/insert_category_form_field_option', [CategoryFormFieldOptionController::class, 'insert_category_form_field_option'])->name('admin.insert_category_form_field_option');
        Route::get('/admin/category_form_field_option_edit/{id}', [CategoryFormFieldOptionController::class, 'category_form_field_option_edit'])->name('admin.category_form_field_option_edit');
        Route::post('/admin/update_category_form_field_option', [CategoryFormFieldOptionController::class, 'update_category_form_field_option'])->name('admin.update_category_form_field_option');
        Route::post('/admin/category_form_field_option_status_change', [CategoryFormFieldOptionController::class, 'category_form_field_option_status_change'])->name('admin.category_form_field_option_status_change');
        Route::post('/admin/category_form_field_option_delete', [CategoryFormFieldOptionController::class, 'category_form_field_option_delete'])->name('admin.category_form_field_option_delete');
    /* Category Booking Form Field Option */



    /* Category Booking Form Field */
        Route::get('/admin/category_form_field', [CategoryFormFieldController::class, 'index'])->name('admin.category_form_field');
        Route::get('/admin/category_form_field_list', [CategoryFormFieldController::class, 'get_list'])->name('admin.category_form_field_list');
        Route::get('/admin/add_category_form_field', [CategoryFormFieldController::class, 'add_category_form_field'])->name('admin.add_category_form_field');
        Route::post('/admin/insert_category_form_field', [CategoryFormFieldController::class, 'insert_category_form_field'])->name('admin.insert_category_form_field');
        Route::get('/admin/category_form_field_edit/{id}', [CategoryFormFieldController::class, 'category_form_field_edit'])->name('admin.category_form_field_edit');
        Route::post('/admin/category_form_field_status_change', [CategoryFormFieldController::class, 'category_form_field_status_change'])->name('admin.category_form_field_status_change');
        Route::post('/admin/update_category_form_field', [CategoryFormFieldController::class, 'update_category_form_field'])->name('admin.update_category_form_field');
    /* Category Booking Form Field */


     /* Profile */
        Route::get('/admin/profile', [AdminController::class, 'profile'])->name('admin.profile');
        Route::post('/admin/update_profile', [AdminController::class, 'update_profile'])->name('admin.update_profile');
     /* Profile */


});
?>
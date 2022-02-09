<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\GithubController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\StripePaymentController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;


Auth::routes(['verify' => true]);

// frontend
Route::get('/', [FrontendController::class, 'welcome'])->name('frontend');
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('verified', 'admincheck');
Route::get('/main', [FrontendController::class, 'main']);
Route::get('/product/details/{product_id}', [FrontendController::class, 'product_detail'])->name('details');
Route::post('/getsize', [FrontendController::class, 'getsize']);
Route::post('/getquantity', [FrontendController::class, 'getquantity']);
Route::get('/checkout', [FrontendController::class, 'checkout'])->name('checkout');
Route::get('/404', [FrontendController::class, 'err_404'])->name('404');
Route::get('/myaccount', [FrontendController::class, 'myaccount'])->name('myaccount');

//Verified
Route::group(['middleware' => ['verified']], function(){
    Route::get('/myaccount', [FrontendController::class, 'myaccount'])->name('myaccount');
});


// Category
Route::get('/category', [CategoryController::class, 'index'])->middleware('admincheck');
Route::post('/category/insert', [CategoryController::class, 'insert']);
Route::get('/category/delete/{category_id}', [CategoryController::class, 'delete']);
Route::get('/category/edit/{category_id}', [CategoryController::class, 'edit']);
Route::post('/category/update', [CategoryController::class, 'update']);
Route::get('/category/restore/{category_id}', [CategoryController::class, 'restore']);
Route::get('/category/permanent/delete/{category_id}', [CategoryController::class, 'perdelete']);
Route::post('/mark/delete', [CategoryController::class, 'mark_delete']);
Route::get('/category/status/{category_id}', [CategoryController::class, 'category_status']);



// SubCategory
Route::get('/subcategory', [SubCategoryController::class, 'index']);
Route::post('/subcategory/insert', [SubCategoryController::class, 'insert']);
Route::get('/subcategory/delete/{subcategory_id}', [SubCategoryController::class, 'delete']);
Route::get('/subcategory/edit/{subcategory_id}', [SubCategoryController::class, 'edit']);
Route::post('/subcategory/update', [SubCategoryController::class, 'update']);

//Profile
Route::get('/profile', [ProfileController::class, 'index']);
Route::post('/name/update', [ProfileController::class, 'nameupdate']);
Route::post('/password/update', [ProfileController::class, 'passupdate']);
Route::post('/photo/update', [ProfileController::class, 'photoupdate']);

// Products
Route::get('/add/product', [ProductController::class, 'index']);
Route::post('/product/insert', [ProductController::class, 'insert']);
Route::get('/product', [ProductController::class, 'allproduct']);

//inventory
Route::get('/add/color', [ProductController::class, 'addcolor']);
Route::post('/color/insert', [ProductController::class, 'colorinsert']);
Route::get('/add/size', [ProductController::class, 'addsize']);
Route::post('/size/insert', [ProductController::class, 'sizeinsert']);
Route::get('/add/inventory/{product_id}', [InventoryController::class, 'inventory']);
Route::post('/insert/inventory', [InventoryController::class, 'inventory_insert']);

//Cart
Route::post('/add/to/cart', [CartController::class, 'addtocart']);
Route::get('/cart/delete/{cart_id}', [CartController::class, 'cart_delete'])->name('cart.remove');
Route::get('/cart', [CartController::class, 'cart'])->name('cart');
Route::post('/cart/update', [CartController::class, 'cartupdate'])->name('cart.update');
Route::get('/cart/clear', [CartController::class, 'cart_clear'])->name('cart.clear');
Route::get('/cart/{coupon_code}', [CartController::class, 'cart'])->name('cart');

//Coupon
Route::get('/coupon', [CouponController::class, 'coupon'])->name('coupon');
Route::post('/coupon/insert', [CouponController::class, 'coupon_insert'])->name('coupon.insert');


//Add User
Route::post('/insert/user', [UserController::class, 'insert_user'])->name('insert_user');


//Checkout
Route::post('/getCityList', [CheckoutController::class, 'getCityList'])->name('getCityList');


//Order
Route::post('/order', [CheckoutController::class, 'order_insert']);
Route::get('/order/confirmed', [CheckoutController::class, 'order_confirm']);


// SSLCOMMERZ Start
Route::get('/sslcommerz', [SslCommerzPaymentController::class, 'sslcommerz']);

Route::post('/pay', [SslCommerzPaymentController::class, 'index']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END


//Stripe Payment
Route::get('stripe', [StripePaymentController::class, 'stripe']);
Route::post('stripe', [StripePaymentController::class, 'stripePost'])->name('stripe.post');


//Invoice
Route::get('/invoice/download/{order_id}', [InvoiceController::class, 'invoice_download'])->name('invoice.download');

//Verify Email
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


// Review
Route::post('/review', [FrontendController::class, 'review']);

//Social Login
Route::get('/github/redirect', [GithubController::class, 'github_redirect'])->name('github.redirect');
Route::get('/github/callback', [GithubController::class, 'github_callback'])->name('github.callback');

Route::get('/google/redirect', [GoogleController::class, 'google_redirect'])->name('google.redirect');
Route::get('/google/callback', [GoogleController::class, 'google_callback'])->name('google.callback');









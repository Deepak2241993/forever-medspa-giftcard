<?php

use Illuminate\Support\Facades\Route;
// use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
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
// Auth::routes();


Route::get('/login',[AdminController::class,'login'])->name('login');
Route::get('/logout',[AdminController::class,'logout'])->name('logout');
Route::post('/login',[AdminController::class,'login_post'])->name('login-post');
Route::view('email','email.giftcard');


//For All Admin  Route
Route::prefix('admin')->middleware('login')->group(function () {
Route::get('/admin-dashboard', 'HomeController@root')->name('root');
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');
Route::resource('/gift', GiftController::class);
Route::resource('/all-order-history', TransactionHistoryController::class);
Route::resource('/coupon', GiftCouponController::class);
Route::resource('/gift-category', GiftCategoryController::class);
Route::resource('/medspa-gift', MedsapGiftController::class);
Route::resource('/email-template', EmailTemplateController::class);
Route::post('/giftcards-history', 'GiftController@history')->name('giftcards-history');
Route::get('/giftcards-view', 'GiftController@redeem_view')->name('giftcards-view');
Route::get('/giftcards-redeem-view', 'GiftController@history_view')->name('giftcards-redeem-view');
Route::post('/giftcards-redeem', 'GiftController@redeem_store')->name('giftcards-redeem');
Route::post('/ckeditor-image-post', 'CkeditorController@uploadImage')->name('ckeditor-image-upload');

// New Route
Route::get('/cardgenerated-list','GiftsendController@cardgeneratedList')->name('cardgenerated-list');
Route::post('/cardview-route','APIController@cardview')->name('cardview-route');
Route::get('/giftcardredeem-view','GiftsendController@giftcardredeemView')->name('giftcardredeem-view');
Route::get('/giftcardsearch','GiftsendController@GiftCardSearch')->name('giftcard-search');
Route::post('/giftcardredeem','GiftsendController@giftcardredeem')->name('giftcardredeem');
Route::post('/giftcardstatment','GiftsendController@giftcardstatment')->name('giftcardstatment');
Route::get('/giftcards-sale', 'GiftsendController@giftsale')->name('giftcards-sale');
Route::post('/giftcancel','GiftsendController@giftcancel')->name('giftcancel');
Route::resource('/category', ProductCategoryController::class);
Route::resource('/product', ProductController::class);
// Popular Officers
Route::resource('/popular-offers', PopularOfferController::class);

Route::post('/giftcard-purchase','GiftsendController@GiftPurchase')->name('giftcard-purchase');
Route::get('/giftcard-purchases-success','GiftsendController@GiftPurchaseSuccess')->name('giftcard-purchases-success');
Route::post('/giftcard-payment-update','GiftsendController@updatePaymentStatus')->name('giftcard-payment-update');

//  For Mail Resend Option
Route::get('/resendmail_view','GiftsendController@Resendmail_view')->name('Resendmail_view');
Route::post('/resendmail','GiftsendController@Resendmail')->name('resendmail');
// For Keywords Search
Route::get('search-keywords-reports','ProductController@KeywordsReports')->name('keywords_reports');
Route::get('export-keywords','ProductController@ExportDate')->name('export_date');

});


// For All User Route
    Route::prefix('users')->middleware('login')->group(function () {

    Route::get('/user-dashboard', 'HomeController@dashboard')->name('dashboard');
    // Route::resource('/gift', GiftController::class);
    Route::resource('/order-history', TransactionHistoryController::class);

    });

Route::get('/',[App\Http\Controllers\GiftController::class,'christmas_gift_card'])->name('home');
Route::post('/send-gift-cards','GiftController@store')->name('send-gift-cards');

Route::get('/strip_form',[App\Http\Controllers\StripeController::class,'formview']);
Route::post('/payment',[App\Http\Controllers\StripeController::class,'makepayment']);
Route::get('/success', function () {
    return view('stripe.thanks');
});
Route::get('/failed', function () {
    return view('stripe.failed');
});



//  New Code For API URL Call
Route::post('/sendgift','GiftsendController@sendgift')->name('sendgift');
Route::post('/selfgift','GiftsendController@selfgift')->name('selfgift');


Route::post('/coupon-verify','GiftsendController@giftvalidate')->name('coupon-verify');
Route::post('/giftcardpayment',[App\Http\Controllers\StripeController::class,'giftcardpayment'])->name('giftcardpayment');
Route::post('/balance-check','GiftsendController@knowbalance')->name('balance-check');
Route::post('/payment_cnf','GiftsendController@payment_confirmation')->name('payment_cnf');

//  Product Page Route
Route::get('product-page/{token?}/{slug}', 'ProductController@productpage')->name('product_list');

Route::get('productdetails/{slug}','ProductController@productdetails')->name('productdetails');
Route::get('category/{token?}','ProductCategoryController@categorytpage')->name('category');
Route::get('services/{slug}','ProductController@productpage')->name('product');
Route::get('service/{slug}','ProductController@productdetails')->name('productdetails');
// Route::get('product-category-wise/{id}','ProductController@productCategory')->name('productCategory');
Route::post('services-search','ProductController@ServicesSearch')->name('ServicesSearch');
Route::get('popular-service/{id}','ProductController@PopularService')->name('PopularService');
// Front Route for PopularOffer
Route::get('popular-deals','PopularOfferController@popularDeals')->name('popularDeals');
Route::post('cart','PopularOfferController@Cart')->name('cart');
Route::get('cartview','PopularOfferController@Cartview')->name('cartview');
Route::post('/cart/remove','PopularOfferController@CartRemove')->name('cartremove');
Route::get('checkout','PopularOfferController@Checkout')->name('checkout');
Route::post('/giftcards-validate', 'GiftController@giftcardValidate')->name('giftcards-validate');

//  for Product payment URL
Route::post('checkout-process','StripeController@CheckoutProcess')->name('checkout_process');
Route::get('stripe/checkout/success','StripeController@stripcheckoutSuccess')->name('strip_checkout_success');
//  for Product payment URL

Route::post('createslug','ProductCategoryController@slugCreate')->name('slugCreate');



Route::resource('/product', ProductController::class);


Route::get('/clear-cache', function() {
    Artisan::call('cache:clear ');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    echo Artisan::output();
});



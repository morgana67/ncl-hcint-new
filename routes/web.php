<?php

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
//
Route::get('/test', function() {
    echo bcrypt("asdqwe123");
});
Route::get('/', 'HomeController@index')->name('home');
Route::get('/shop', 'HomeController@shop')->name('shop');
Route::get('/product/{slug}', 'HomeController@product_detail')->name('product_detail');
Route::get('/bundle', 'BundleController@index')->name('bundle.index');
Route::get('/bundle/{slug}', 'BundleController@show')->name('bundle.show');
Route::get('/testlistbydisease/{id}', 'HomeController@testlistbydisease')->name('testlistbydisease');
Route::get('/testbydisease', 'HomeController@testbydisease')->name('testbydisease');
Route::get('/blog/{slug?}', 'HomeController@blog')->name('blog');
Route::get('/blog/post/{slug}', 'HomeController@post_detail')->name('post_detail');
Route::get('/faq', 'HomeController@faq')->name('faq');
Route::get('/how-to-order', 'HomeController@howToOrder')->name('how-to-order');
Route::get('/about-us','HomeController@aboutUs')->name('about_us');
Route::get('/privacy', 'HomeController@privacy')->name('privacy');
Route::get('/terms', 'HomeController@terms')->name('terms');
Route::get('/credits', 'HomeController@credits')->name('credits');
Route::get('/page/{slug}', 'HomeController@page_detail')->name('page_detail');
Route::get('/locations', 'HomeController@locations')->name('locations');
Route::get('location/{site_code}', 'HomeController@location')->name('location');

Route::get('/login', function () {Auth::guard('customer')->logout(); return view('login');});
Route::get('/forgot', function () {return view('forgot');});
Route::get('/register', function () {return view('register');});
Route::get('/signup', function () {return view('signup');});

Route::match(['GET'],'/order_approved','PwnhealthController@order_approved')->name('order_approved');
Route::match(['GET'],'/order_rejected','PwnhealthController@order_rejected')->name('order_rejected');
Route::match(['GET'],'/order_canceled','PwnhealthController@order_canceled')->name('order_canceled');
Route::match(['GET'],'/order_deferred','PwnhealthController@order_deferred')->name('order_deferred');
Route::match(['GET'],'/result_released','PwnhealthController@result_released')->name('result_released');
Route::match(['GET'],'/result_on_hold','PwnhealthController@result_on_hold')->name('result_on_hold');

Route::get('/results','PwnhealthController@status')->name('webhooks_status');


Auth::routes();
Route::get('/doctor-registration','Auth\RegisterController@doctorRegister')->name('doctorRegister');


Route::post('/post-register','Auth\RegisterController@postRegister')->name('postRegister');
Route::post('/reset-password','Auth\ResetPasswordController@reset_password')->name('resetPassword');
Route::match(['get','post'],'/change-password','Auth\ResetPasswordController@change_password')->name('changePassword');

Route::get('/verify-account','Auth\RegisterController@verifyAccount')->name('verifyAccount');

Route::group(['prefix' => 'cart','as' => 'cart.'],function (){
    Route::post('add','CartController@add')->name('add');
    Route::post('addMultiple','CartController@addMultiple')->name('addMultiple');
    Route::get('view','CartController@view')->name('view');
    Route::post('update','CartController@update')->name('update');
    Route::post('remove','CartController@remove')->name('remove');
    Route::get('removeAll','CartController@removeAll')->name('removeAll');

});

Route::group(['middleware' => 'customer'],function (){
    Route::group(['prefix' => 'profile','as' => 'profile.'],function (){
        Route::match(['get','post'],'/','ProfileController@profile')->name('profile');
        Route::match(['get','post'],'/change-password','ProfileController@changePassword')->name('changePassword');
    });
    Route::get('my-orders','ProfileController@myOrder')->name('myOrder');
    Route::get('order-detail/{id}','ProfileController@orderDetail')->name('orderDetail');

    Route::group(['prefix' => 'cart','as' => 'cart.'],function (){
        Route::get('/checkout', 'CheckoutController@view')->name('checkout');
        Route::post('/checkoutProceed', 'CheckoutController@checkoutProceed')->name('checkoutProceed');
    });

    Route::get('/order-success/{id?}/{sendMail?}','CheckoutController@orderSuccess')->name('order-success');
    Route::get('findOldInfoByNickname','CheckoutController@findOldInfoByNickname')->name('findOldInfoByNickname');
    Route::get('drAddTests','CheckoutController@drAddTests')->name('drAddTests');
});

Route::get('downloadRequisitionOrder/{id}','ProfileController@downloadRequisitionOrder')->name('downloadRequisitionOrder');
Route::get('downloadResultTest/{id}','ProfileController@downloadResultTest')->name('downloadResultTest');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();

    Route::get('forgot-password', 'Admin\ForgotPasswordController@showLinkRequestForm')->name('admin.forgot-password.get');
    Route::post('forgot-password', 'Admin\ForgotPasswordController@reset_password')->name('admin.forgot-password.post');
});
Route::group(['prefix' => 'admin','namespace' => 'Admin','as' => 'admin.','middleware' => ['auth']], function () {
    Route::group(['prefix' => 'orders','as' => 'orders.',],function (){
        Route::get('/','OrderController@index')->name('index');
        Route::match(['get','post'],'detail/{id}','OrderController@detail')->name('detail');
        Route::delete('destroy/{id}','OrderController@destroy')->name('destroy');
        Route::post('updateOrderStatus/{id}','OrderController@updateOrderStatus')->name('updateOrderStatus');
        Route::post('updatePaymentStatus/{id}','OrderController@updatePaymentStatus')->name('updatePaymentStatus');
        Route::post('publicPwhResult/{id}','OrderController@publicPwhResult')->name('publicPwhResult');
    });

    Route::group(['prefix' => 'page-static','as' => 'page-static.',],function (){
        Route::get('/','PageStaticController@index')->name('index');
        Route::match(['get','post'],'detail/{code?}','PageStaticController@detail')->name('detail');
    });
});



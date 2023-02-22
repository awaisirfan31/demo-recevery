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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/','Auth\AdminLoginController@LoginView')->name('login');
Route::post('/login','Auth\AdminLoginController@Login')->name('admin.login');

Route::middleware(['auth:admin'])->group(function () {
    Route::get('logout', 'Auth\AdminLoginController@Logout')->name('admin.logout');
    Route::get('dashboard','DashboardController@index')->name('dashboard');    
    Route::get('dashboard-graph','DashboardController@graph')->name('dashboard-graph');    
    Route::get('profile/{id}','ProfileController@ShowProfile')->name('profile');
    Route::post('self-profile-update', 'ProfileController@ProfileUpdate')->name('self-profile-update');
    Route::post('self-password', 'ProfileController@PasswordUpdate')->name('self-password');
    Route::post('payment', 'Dealer\PaymentController@Payment')->name('payment');
    Route::get('view-invoices/{id}', 'Dealer\PaymentController@Invoice')->name('view-invoices');
    Route::get('download-invoices/{id}', 'Dealer\PaymentController@downloadInvoice')->name('download-invoices');
    Route::get('print-invoices/{id}', 'Dealer\PaymentController@printInvoice')->name('print-invoices');
    Route::post('adjustment', 'Dealer\PaymentController@AdjustmentDetail')->name('adjustment');

    Route::get('ledger', 'LedgerController@showLedger')->name('ledger');
    // Route::get('ledger_data', 'LedgerController@showLedger')->name('showledger');
    Route::post('view-invoice', 'Dealer\PaymentController@ViewInvoice')->name('view-invoice');
    Route::post('change-status','ProfileController@statusChange')->name('change-status');
    

    Route::resources([
        'city' => 'Superadmin\CityController',
        'admin' =>'Superadmin\AdminController',
        'area' =>'Admin\AreaController',
        'dealer' => 'Admin\DealerController',
        'user' => 'Dealer\UserController'
    ]);
});
// Auth::routes(['register'=>false]);

Route::get('/home', 'HomeController@index')->name('home');

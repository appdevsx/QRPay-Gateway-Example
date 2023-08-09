<?php

use App\Http\Controllers\PaymentGatewayController;
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

Route::get('/', function () {
    return view('pay-page');
})->name('pay.page');


Route::controller(PaymentGatewayController::class)->prefix('payment-gateway')->name('pay.')->group(function(){
    Route::get('get-token','getToken')->name('get.token');
    Route::post('initiate-payment','initiatePayment')->name('initiate.payment');
    Route::get('success','paySuccess')->name('success');
    Route::get('cancel','payCancel')->name('cancel');

});



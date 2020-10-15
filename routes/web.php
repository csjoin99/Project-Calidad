<?php

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
/* Pagina principal */
Route::get('/','App\Http\Controllers\Shopstore@index')->name("shop");

/* Carrito de Compras */
/* Pagina de carrito de compra */
Route::get('/shop/cart','App\Http\Controllers\Shoppingcart@index')->name("shop.cart");
/* Funcion para almacenar producto en carrito */
Route::post('/shop/cart/store','App\Http\Controllers\Shoppingcart@store')->name("shop.cart.store");
/* Funcion para eliminar producto de carrito de compra */
Route::delete('/shop/cart/{product}','App\Http\Controllers\Shoppingcart@destroy')->name("shop.cart.destroy");
Route::patch('/shop/cart/{product}','App\Http\Controllers\Shoppingcart@update')->name("shop.cart.update");

/* Checkout */
/* Pagina para elegir metodo de pago */
Route::get('/shop/checkout','App\Http\Controllers\VentaController@index')->name("shop.checkout");
/* Metodo contre entrega */
Route::post('/shop/checkout/upondelivery','App\Http\Controllers\VentaController@PayUponDelivery')->name("shop.checkout.upondelivery");
/* Metodo paypal */
Route::get('/shop/checkout/paypal','App\Http\Controllers\VentaController@paypal')->name("shop.checkout.paypal");
/* Paypal status */
Route::get('/shop/checkout/paypal/status','App\Http\Controllers\VentaController@paypalStatus')->name("shop.checkout.status");

/* PDF */
Route::get('/pdf/invoice','App\Http\Controllers\pdfgenerator@index')->name("pdf.invoice");

/* Productos */
/* Pagina de productos */
Route::get('/shop','App\Http\Controllers\ArticuloController@showstore')->name("shop.products");
/* Pagina de informacion de producto */
Route::get('/shop/{product}','App\Http\Controllers\ArticuloController@showproduct')->name('shop.show');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

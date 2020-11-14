<?php

use Illuminate\Contracts\Session\Session;
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

/* Autentificacion guest */
Auth::routes();

/* Admin */
//Login
Route::get('/admin/login', [App\Http\Controllers\Auth\LoginController::class, 'showAdminLoginForm'] )->name('login.admin');
//Dashboard
Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'] )->name('admin');
//Users
Route::get('/admin/users', [App\Http\Controllers\AdminController::class, 'usuariosShow'] )->name('admin.users');
//Articulos show
Route::get('/admin/articulos', [App\Http\Controllers\AdminController::class, 'articulosShow'] )->name('admin.articulos');
//Articulos obtener datos
Route::get('/admin/articulosget', [App\Http\Controllers\AdminController::class, 'articulosGet'] )->name('admin.get.articulos');
//Articulos insert
Route::post('/admin/articulos/store', [App\Http\Controllers\ArticuloController::class, 'store'] )->name('admin.articulos.store');
//Articulos edit
Route::post('/admin/articulos/edit/{id}', [App\Http\Controllers\ArticuloController::class, 'edit'] )->name('admin.articulos.edit');
//Articulo destroy
Route::post('/admin/articulos/destroy/{id}', [App\Http\Controllers\ArticuloController::class, 'destroy'] )->name('admin.articulos.destroy');
//Login verificación
Route::post('/admin/login', [App\Http\Controllers\Auth\LoginController::class, 'adminLogin'])->name('login.admin');
//Articulo Talla
Route::get('/admin/articulostalla', [App\Http\Controllers\AdminController::class, 'articulosTallaShow'] )->name('admin.articulotalla');
//Articulo talla obtener añadir
Route::patch('/admin/articulostalla/obtain/{id}', [App\Http\Controllers\ArticuloTallaController::class, 'getTallaArticulo'] )->name('admin.articulotalla.obtain');
//Articulo talla store
Route::post('/admin/articulostalla/store', [App\Http\Controllers\ArticuloTallaController::class, 'store'] )->name('admin.articulotalla.store');
//Articulo talla edit
Route::post('/admin/articulostalla/edit', [App\Http\Controllers\ArticuloTallaController::class, 'edit'] )->name('admin.articulotalla.edit');
//Articulo talla destroy
Route::post('/admin/articulostalla/destroy', [App\Http\Controllers\ArticuloTallaController::class, 'destroy'] )->name('admin.articulotalla.destroy');

/* Pagina compra */
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('main');

/* Checkout */
//Pagina checkout
Route::get('/checkout', [App\Http\Controllers\VentaController::class, 'index'] )->name('shop.checkout');
//Contra entrega
Route::post('/checkout/upondelivery',[App\Http\Controllers\VentaController::class, 'PayUponDelivery'] )->name("shop.checkout.upondelivery");
//Paypal
Route::get('/checkout/paypal',[App\Http\Controllers\VentaController::class, 'paypal'])->name("shop.checkout.paypal");
//Paypal-status
Route::get('/checkout/paypal/status',[App\Http\Controllers\VentaController::class, 'paypalStatus'])->name("shop.checkout.status");

/* Carrito compra */
//Pagina carrito de compra
Route::get('/cart', [App\Http\Controllers\Shoppingcart::class, 'index'] )->name('shop.cart');
//Obtener articulos de carrito de compra  
Route::get('/cart/get', [App\Http\Controllers\Shoppingcart::class, 'getCartContent'] )->name('shop.getcart');
//Añadir producto a carrito de compra
Route::post('/cart/store', [App\Http\Controllers\Shoppingcart::class, 'store'] )->name('shop.cart.store');
//Eliminar producto a carrito de compra
Route::delete('/cart/{product}', [App\Http\Controllers\Shoppingcart::class, 'destroy'] )->name('shop.cart.destroy');
//Actualizar cantidad de productos en carrito de compra
Route::patch('/cart/{product}', [App\Http\Controllers\Shoppingcart::class, 'update'] )->name('shop.cart.update');

/* Productos compra */
//Producto info
Route::get('/product/{product}', [App\Http\Controllers\ArticuloController::class, 'showProduct'] )->name('shop.product');
//Productos filtro genero
Route::get('/products/{gender}', [App\Http\Controllers\ArticuloController::class, 'showProducts'] )->name('shop.products');
//Productos filtro genero obtener consulta
Route::get('/productsget/{gender}', [App\Http\Controllers\ArticuloController::class, 'showProductsFilter'] )->name('shop.products.filter');
//Productos filtro categoria
Route::post('/productsget/{gender}', [App\Http\Controllers\ArticuloController::class, 'showProductsFilter'] )->name('shop.products.filterpost');

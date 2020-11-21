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
Route::get('/admin', [App\Http\Controllers\AdminController::class, 'dashboardAdmin'] )->name('admin');
//Users
Route::get('/admin/users', [App\Http\Controllers\AdminController::class, 'listaUsuarios'] )->name('admin.users');
//Articulos show
Route::get('/admin/articulos', [App\Http\Controllers\ArticuloController::class, 'vistaArticulos'] )->name('admin.articulos');
//Articulos obtener datos
Route::get('/admin/articulos/get', [App\Http\Controllers\ArticuloController::class, 'listaArticulos'] )->name('admin.get.articulos');
//Articulos insert
Route::post('/admin/articulos/store', [App\Http\Controllers\ArticuloController::class, 'insertArticulos'] )->name('admin.articulos.store');
//Articulos edit
Route::post('/admin/articulos/edit/{id}', [App\Http\Controllers\ArticuloController::class, 'editArticulos'] )->name('admin.articulos.edit');
//Articulo destroy
Route::post('/admin/articulos/destroy/{id}', [App\Http\Controllers\ArticuloController::class, 'destroyArticulos'] )->name('admin.articulos.destroy');
//Login verificación
Route::post('/admin/login', [App\Http\Controllers\Auth\LoginController::class, 'adminLogin'])->name('login.admin');
//Articulo Talla
Route::get('/admin/articulostalla', [App\Http\Controllers\ArticuloTallaController::class, 'paginaArticuloTalla'] )->name('admin.articulotalla');
//Articulos obtener datos
Route::get('/admin/articulostalla/get', [App\Http\Controllers\ArticuloTallaController::class, 'listaArticuloTalla'] )->name('admin.articulotalla.get');
//Articulo talla obtener añadir
Route::patch('/admin/articulostalla/obtain/{id}', [App\Http\Controllers\TallaController::class, 'obtenerTallas'] )->name('admin.articulotalla.obtain');
//Articulo talla store
Route::post('/admin/articulostalla/store', [App\Http\Controllers\ArticuloTallaController::class, 'insertArticuloTalla'] )->name('admin.articulotalla.store');
//Articulo talla edit
Route::post('/admin/articulostalla/edit', [App\Http\Controllers\ArticuloTallaController::class, 'editArticuloTalla'] )->name('admin.articulotalla.edit');
//Articulo talla destroy
Route::post('/admin/articulostalla/destroy/{id}', [App\Http\Controllers\ArticuloTallaController::class, 'destroyArticuloTalla'] )->name('admin.articulotalla.destroy');

/* Pagina principal */
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('main');

/* Checkout */
//Pagina checkout
Route::get('/checkout', [App\Http\Controllers\VentaController::class, 'paginaCheckout'] )->name('shop.checkout');
//Contra entrega
Route::post('/checkout/upondelivery',[App\Http\Controllers\VentaController::class, 'PayUponDelivery'] )->name("shop.checkout.upondelivery");
//Paypal
Route::get('/checkout/paypal',[App\Http\Controllers\VentaController::class, 'paypal'])->name("shop.checkout.paypal");
//Paypal-status
Route::get('/checkout/paypal/status',[App\Http\Controllers\VentaController::class, 'paypalStatus'])->name("shop.checkout.status");

/* Carrito compra */
//Pagina carrito de compra
Route::get('/cart', [App\Http\Controllers\Shoppingcart::class, 'paginaShoppingCart'] )->name('shop.cart');
//Obtener articulos de carrito de compra  
Route::get('/cart/get', [App\Http\Controllers\Shoppingcart::class, 'contenidoShoppingCart'] )->name('shop.getcart');
//Añadir producto a carrito de compra
Route::post('/cart/store', [App\Http\Controllers\Shoppingcart::class, 'añadirItemShoppingCart'] )->name('shop.cart.store');
//Eliminar producto a carrito de compra
Route::delete('/cart/{product}', [App\Http\Controllers\Shoppingcart::class, 'quitarItemShoppingCart'] )->name('shop.cart.destroy');
//Actualizar cantidad de productos en carrito de compra
Route::patch('/cart/{product}', [App\Http\Controllers\Shoppingcart::class, 'actualizarCantidadShoppingCart'] )->name('shop.cart.update');

/* Productos compra */
//Producto info
Route::get('/product/{product}', [App\Http\Controllers\ShopStoreController::class, 'showInfoProduct'] )->name('shop.product');
//Productos lista
Route::get('/products/{gender}', [App\Http\Controllers\ShopStoreController::class, 'showListProducts'] )->name('shop.products');
//Productos filtro 
Route::get('/productsget/{gender}', [App\Http\Controllers\ShopStoreController::class, 'FiltroProducts'] )->name('shop.products.filter');

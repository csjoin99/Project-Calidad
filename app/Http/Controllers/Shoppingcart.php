<?php

namespace App\Http\Controllers;

use App\Models\articulo;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Shoppingcart extends Controller
{
    //
    public function paginaShoppingCart()
    {
        $recomendaciones = DB::select('select * from (SELECT *,(select COUNT(*) from articulo_tallas where 
        articulo_tallas.idArticuloS=articulos.idArticulo and articulo_tallas.estadoArticuloTalla!=0) 
        as cant from articulos where articulos.estadoArticulo!=0 order by articulos.idArticulo ASC) 
        as b where b.cant !=0 ORDER BY RAND() LIMIT 4');
        return view('shop.shoppingcart')->with([
            'Titulo' => 'Carrito de compra',
            'moreproducts' => $recomendaciones
        ]);
    }
    public function contenidoShoppingCart()
    {
        $cart_content = Cart::content();
        $cart_precios = [
            'total' => Cart::Total(),
            'subtotal' => number_format(((float)Cart::Total() / 1.18), 2),
            'igv' => number_format(((float)Cart::Total() / 1.18 * 0.18), 2)
        ];
        $cart_cantidad = Cart::count();
        return [$cart_content, $cart_precios, $cart_cantidad];
    }
    public function añadirItemShoppingCart(Request $request)
    {
        $find_duplicates = Cart::search(function ($cartItem, $rowId) use ($request) {
            return $cartItem->id === $request->idArticuloTalla;
        });
        if ($find_duplicates->isNotEmpty()) {
            return redirect()->route('shop.cart');
        }
        Cart::add(
            $request->idArticuloTalla,
            $request->nombreArticulo,
            1,
            number_format($request->precioArticulo, 2),
            [
                'nombreTalla' => $request->nombreTalla,
                'categoriaArticulo' => $request->categoriaArticulo,
                'photoArticulo' => $request->photoArticulo
            ]
        );
        return redirect()->route('shop.cart');
    }
    public function quitarItemShoppingCart($id)
    {
        Cart::remove($id);
        return 'Se quito el artículo';
    }
    public function actualizarCantidadShoppingCart(Request $request, $id)
    {
        $currentcant = DB::table('articulo_tallas')->where('idArticuloTalla', $request->iditem)->value('stockArticulo');
        $newcant = $currentcant - $request->qty;
        if($newcant<0){
            return "No hay suficiente stock del articulo";
        }
        Cart::update($id, $request->qty);
        return 'Se actualizo la cantidad de artículos';
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\articulo;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class Shoppingcart extends Controller
{
    //
    public function index()
    {
        $moreproducts = articulo::inRandomOrder()->take(4)->get();
        return view('shop.shoppingcart')->with([
            'Titulo' => 'Carrito de compra',
            'moreproducts' => $moreproducts
        ]);
    }
    public function getCartContent()
    {
        $cart = Cart::content();
        $cartcontent = [
            'total' => Cart::Total(),
            'subtotal' => number_format((Cart::Total() / 1.18), 2),
            'igv' => number_format((Cart::Total() / 1.18 * 0.18), 2)
        ];
        $cant = Cart::count();
        return [$cart, $cartcontent, $cant];
    }
    public function store(Request $request)
    {
        $duplicates = Cart::search(function ($cartItem, $rowId) use ($request) {
            return $cartItem->id === $request->idArticuloTalla;
        });
        if ($duplicates->isNotEmpty()) {
            return redirect()->route('shop.cart')->with('success_message', 'El artículo ya se encuentra en su carrito de compra');
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
        return redirect()->route('shop.cart')->with('success_message', 'El producto fue agregado a su carrito de compra');
    }
    public function destroy($id)
    {
        Cart::remove($id);
        return 'Se quito el artículo';
    }
    public function update(Request $request, $id)
    {
        Cart::update($id, $request->qty);
        return 'Se actualizo la cantidad de artículos';
    }
}

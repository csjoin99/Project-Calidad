<?php

namespace App\Http\Controllers;

use App\Models\articulo;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class Shoppingcart extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $moreproducts = articulo::inRandomOrder()->take(4)->get();
        return view('shop.shoppingcart')->with([
            'Titulo' => 'Carrito de compra',
            'moreproducts' => $moreproducts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
            $request->precioArticulo,
            [
                'nombreTalla' => $request->nombreTalla,
                'categoriaArticulo' => $request->categoriaArticulo
            ]
        );
        
        return redirect()->route('shop.cart')->with('success_message', 'El producto fue agregado a su carrito de compra');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        Cart::update($id, $request->quantity);
        return response()->json(['success'=>true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Cart::remove($id);
        return back()->with('success_message','Se quito el artículo');
    }
}

<?php

namespace App\Http\Controllers;

use Error;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function paginaCheckout()
    {
        if (!Auth::user()) {
            return redirect()->route('login')->with('error', 'Debes estar logeado para hacer esta operación');
        }
        if (!$this->checkStockArticulos()) {
            return redirect()->route('shop.cart')->with('failure_message', 'No hay stock suficiente');
        }
        $distritos_json = file_get_contents("json/distritos.json");
        $distritos = json_decode($distritos_json);
        return view('shop.checkout')->with(['Titulo' => 'Checkout', 'distritos' => $distritos]);
    }

    public function setNroVenta(int $nro)
    {
        if (!Auth::user()) {
            return redirect()->route('login')->with('error', 'Debes estar logeado para hacer esta operación');
        }
        $nro++;
        if ($nro > 9999) {
            $nro = 0;
        }
        if ($nro < 10) {
            $nroComprobante = '000' . strval($nro);
        } else {
            if ($nro < 100) {
                $nroComprobante = '00' . strval($nro);
            } else {
                if ($nro < 1000) {
                    $nroComprobante = '0' . strval($nro);
                } else {
                    $nroComprobante = strval($nro);
                }
            }
        }
        return $nroComprobante;
    }

    public function setSeriaVenta(int $nro, int $serie)
    {
        if ($nro++ > 9999) {
            $serie = +1;
        }
        if ($serie < 10) {
            $nroSerie = '00' . strval($serie);
        } else {
            if ($serie < 100) {
                $nroSerie = '0' . strval($serie);
            } else {
                $nroSerie = strval($serie);
            }
        }
        return $nroSerie;
    }
    public function checkStockArticulos()
    {
        foreach (Cart::content() as $item) {
            $currentcant = DB::table('articulo_tallas')->where('idArticuloTalla', $item->id)->value('stockArticulo');
            $newcant = $currentcant - $item->qty;
            if ($newcant < 0) {
                return false;
            }
        }
        return true;
    }
    public function updateStockArticulos($ventaid)
    {
        foreach (Cart::content() as $item) {
            DB::table('detalle_ventas')->insert(
                [
                    'idVentaD' => $ventaid,
                    'idArticuloTallaD' => $item->id,
                    'cantidad' => $item->qty,
                    'precioVentaD' => $item->price
                ]
            );
        }
    }
}

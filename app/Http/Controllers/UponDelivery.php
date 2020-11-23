<?php

namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UponDelivery extends Controller
{
    public function PayUponDelivery(Request $request)
    {
        if (!Auth::user()) {
            return redirect()->route('login')->with('error', 'Debes estar logeado para hacer esta operación');
        }
        try {
            $user = Auth::user();
            $clienteid = $user->id;
            $fullname = $user->firstname . " " . $user->lastname;
            $lastventa = DB::table('ventas')->latest('idVenta')->first();
            if ($lastventa == null) {
                $nroSerie = '001';
                $nroComprobante = '0000';
            } else {
                $currentNro = (int)$lastventa->numComprobanteVenta;
                $currentSerie = (int)$lastventa->serieComprobanteVenta;
                $nroComprobante = app(VentaController::class)->setNroVenta($currentNro);
                $nroSerie = app(VentaController::class)->setSeriaVenta($currentNro, $currentSerie);
            }
            $day = date("Y/m/d");
            $ventaid = DB::table('ventas')->insertGetId([
                'idClienteV' => $clienteid,
                'serieComprobanteVenta' => $nroSerie,
                'numComprobanteVenta' => $nroComprobante,
                'customerVenta' => $fullname,
                'fechaVenta' => $day,
                'totalVenta' => Cart::total(),
                'impuestoVenta' => number_format((Cart::Total()/1.18*0.18), 2),
                'direccionVenta' => $request->direccion,
                'distritoVenta' => $request->distrito
            ]);
            app(VentaController::class)->updateStockArticulos($ventaid);
            $pdfdoc = app(PDFgenerator::class)->index($clienteid, $ventaid);
            Cart::destroy();
            $correo = $user->email;
            app(Mailer::class)->index($pdfdoc, $fullname, $correo);
            return redirect()->route('main')->with('success_message', 'Su compra se ha realizado con exito');
        } catch (\Throwable $th) {
            return redirect()->route('main')->with('failure_message', 'No se pudo proceder con la compra');
        }
    }
}

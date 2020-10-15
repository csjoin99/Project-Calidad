<?php

namespace App\Http\Controllers;

use App\Models\venta;
/* use Barryvdh\DomPDF\PDF; */
use Barryvdh\DomPDF\Facade as PDF;
use Facade\FlareClient\View;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use PayPal\Api\Amount;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\PayerInfo;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ShippingAddress;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Rest\ApiContext;


class VentaController extends Controller
{

    private $apiContext;

    public function __construct()
    {
        $paypalConfig = Config::get('paypal');
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                $paypalConfig['cliente_id'],
                $paypalConfig['secret']
            )
        );
        /* $this->middleware('auth'); */
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::user()) {

            return redirect()->route('login')->with('error', 'Debes estar logeado para hacer esta operación');
        }
        return view('shop.checkout')->with('Titulo', 'Checkout');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function show(venta $venta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function edit(venta $venta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, venta $venta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function destroy(venta $venta)
    {
        //
    }

    public function paypal(request $request)
    {

        if (!Auth::user()) {
            return redirect()->route('login')->with('error', 'Debes estar logeado para hacer esta operación');
        }
        $user = Auth::user();

        $userfullname = $user->firstname . " " . $user->lastname;

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new Amount();
        $amount->setTotal(Cart::total());
        $amount->setCurrency('USD');

        $shipping_address = new ShippingAddress();
        $shipping_address->setRecipientName($userfullname);/* Poner nombre de usuario */
        $shipping_address->setCity($request->distrito);
        $shipping_address->setState("Lima");
        $shipping_address->setPostalCode("07001");
        $shipping_address->setCountryCode("PE");
        $shipping_address->setLine1($request->direccion);
        $shipping_address->setPhone($user->telefono);/* Poner celular de login */

        $itemlist = new ItemList();
        $itemlist->setShippingAddress($shipping_address);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemlist);

        $callbackUrl = Route('shop.checkout.status');
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($callbackUrl)
            ->setCancelUrl($callbackUrl);

        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions(array($transaction))
            ->setRedirectUrls($redirectUrls);
        try {
            $payment->create($this->apiContext);
            return redirect()->away($payment->getApprovalLink());
        } catch (PayPalConnectionException $ex) {
            return redirect()->route('shop')->with('failure_message', 'No se pudo proceder con el pago a travez de paypal' . $ex->getMessage());
        }
    }

    public function paypalStatus(Request $request)
    {
        if (!Auth::user()) {
            return redirect()->route('login')->with('error', 'Debes estar logeado para hacer esta operación');
        }

        $paymentId = $request->paymentId;
        $token = $request->token;
        $PayerID = $request->PayerID;

        if (!$paymentId || !$token || !$PayerID) {
            return redirect()->route('shop')->with('failure_message', 'No se pudo proceder con el pago a travez de paypal');
        }
        $payment = Payment::get($paymentId, $this->apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId($PayerID);

        $result = $payment->execute($execution, $this->apiContext);

        if ($result->getState() === 'approved') {
            $nombre = $result->payer->payer_info->first_name;
            $apellido = $result->payer->payer_info->last_name;
            $email = $result->payer->payer_info->email;
            $city = $result->payer->payer_info->shipping_address->city;
            $address = $result->payer->payer_info->shipping_address->line1;

            $user = Auth::user();

            $clienteid = $user->id;
            $accountmail = $user->email;

            $lastventa = DB::table('ventas')->latest('idVenta')->first();
            if ($lastventa == null) {
                $nroSerie = '001';
                $nroComprobante = '0000';
            } else {
                $currentNro = (int)$lastventa->numComprobanteVenta;
                $currentSerie = (int)$lastventa->serieComprobanteVenta;
                $nroComprobante = $this->setNroVenta($currentNro);
                $nroSerie = $this->setSeriaVenta($currentNro, $currentSerie);
            }
            $day = date("Y/m/d");
            $fullname = $nombre . " " . $apellido;
            $ventaid = DB::table('ventas')->insertGetId([
                'idClienteV' => $clienteid,
                'serieComprobanteVenta' => $nroSerie,
                'numComprobanteVenta' => $nroComprobante,
                'customerVenta' => $fullname,
                'fechaVenta' => $day,
                'totalVenta' => Cart::total(),
                'impuestoVenta' => Cart::tax(),
                'direccionVenta' => $address,
                'distritoVenta' => $city
            ]);
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

            $pdfdoc = app(pdfgenerator::class)->index($clienteid, $ventaid);
            Cart::destroy();

            app(mailer::class)->index($pdfdoc, $fullname, $accountmail);
            return redirect()->route('shop')->with('success_message', 'Su compra con Paypal se realizó la compra');
        }
    }

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
                $nroComprobante = $this->setNroVenta($currentNro);
                $nroSerie = $this->setSeriaVenta($currentNro, $currentSerie);
            }
            $day = date("Y/m/d");
            $ventaid = DB::table('ventas')->insertGetId([
                'idClienteV' => $clienteid,
                'serieComprobanteVenta' => $nroSerie,
                'numComprobanteVenta' => $nroComprobante,
                'customerVenta' => $fullname,
                'fechaVenta' => $day,
                'totalVenta' => Cart::total(),
                'impuestoVenta' => Cart::tax(),
                'direccionVenta' => $request->direccion,
                'distritoVenta' => $request->distrito
            ]);
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
            $pdfdoc = app(pdfgenerator::class)->index($clienteid, $ventaid);
            Cart::destroy();
            $correo = $user->email;
            app(mailer::class)->index($pdfdoc, $fullname, $correo);
            return redirect()->route('shop')->with('success_message', 'Su compra se ha realizado con exito');
        } catch (\Throwable $th) {
            return redirect()->route('shop')->with('failure_message', 'No se pudo proceder con la compra');
        }
    }

    private function setNroVenta(int $nro)
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

    private function setSeriaVenta(int $nro, int $serie)
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
}

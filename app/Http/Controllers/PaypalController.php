<?php

namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use PayPal\Api\Amount;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ShippingAddress;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Rest\ApiContext;

class PaypalController extends Controller
{
    private $apiContext;
    private $dolar = 1;
    public function __construct()
    {
        $paypalConfig = Config::get('paypal');
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                $paypalConfig['cliente_id'],
                $paypalConfig['secret']
            )
        );
        $client = new  \GuzzleHttp\Client();
        $response = $client->request('GET','http://api.currencylayer.com/live?access_key=dbbdac13ca743669ac22d19ae35b083d&currencies=PEN');
        if($response->getStatusCode()==200){
            $apidata = json_decode($response->getBody()->getContents());
            if($apidata->success){
                $this->dolar = $apidata->quotes->USDPEN;
            }
        }
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
        $costo_carro = Cart::total()/$this->dolar;
        $amount->setTotal(number_format($costo_carro,2));
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
            return redirect()->route('main')->with('failure_message', 'No se pudo proceder con el pago a travez de paypal' . $ex->getMessage());
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
            return redirect()->route('main')->with('failure_message', 'No se pudo proceder con el pago a travez de paypal');
        }
        $payment = Payment::get($paymentId, $this->apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId($PayerID);
        $result = $payment->execute($execution, $this->apiContext);
        if ($result->getState() === 'approved') {
            $nombre = $result->payer->payer_info->first_name;
            $apellido = $result->payer->payer_info->last_name;
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
                $nroComprobante = app(VentaController::class)->setNroVenta($currentNro);
                $nroSerie = app(VentaController::class)->setSeriaVenta($currentNro, $currentSerie);
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
                'impuestoVenta' => number_format((Cart::Total()/1.18*0.18), 2),
                'direccionVenta' => $address,
                'distritoVenta' => $city
            ]);
            app(VentaController::class)->updateStockArticulos($ventaid);
            $pdfdoc = app(PDFgenerator::class)->index($clienteid, $ventaid);
            Cart::destroy();
            app(Mailer::class)->index($pdfdoc, $fullname, $accountmail);
            return redirect()->route('main')->with('success_message', 'Su compra con Paypal se realizó la compra');
        }
    }
}

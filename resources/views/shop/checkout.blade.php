@extends('layouts.guestmain')
@section('content')
<div class="mt-5">
    <!-- For demo purpose -->
    <div class="container">
        <div class="row mb-4">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="">Elija un metodo de pago</h2>
            </div>
        </div> <!-- End -->
        <div class="row mb-5">
            <div class="col-lg-7 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">
                            <!-- Credit card form tabs -->
                            <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">
                                <li class="nav-item"> <a data-toggle="pill" href="#contraentrega"
                                        class="nav-link active "> <i class="fas fa-money-bill-wave mr-2"></i> Contra
                                        entrega </a> </li>
                                <li class="nav-item"> <a data-toggle="pill" href="#paypal" class="nav-link "> <i
                                            class="fab fa-paypal mr-2"></i> Paypal </a> </li>
                            </ul>
                        </div> <!-- End -->
                        <!-- Credit card form content -->
                        <div class="tab-content">
                            <!-- credit card info-->
                            <div id="contraentrega" class="tab-pane fade show active pt-3">
                                <form action=" {{ route('shop.checkout.upondelivery') }} " method="POST">
                                    {{ csrf_field() }}
                                    <div class="form-group"> 
                                        <label for="username">
                                            <h6>Distrito</h6>
                                        </label> 
                                            <select name="distrito" class="form-control " required>
                                                <option value="" hidden>Seleccione un distrito</option>
                                                @foreach ($distritos as $distrito)
                                                    <option value='{{$distrito->nombre_ubigeo}}'>{{$distrito->nombre_ubigeo}}</option>
                                                @endforeach
                                            </select>
                                    </div>
                                    <div class="form-group"> 
                                        <label for="cardNumber">
                                            <h6>Dirección</h6>
                                        </label>
                                        <div class="input-group"> 
                                            <input type="text" name="direccion"
                                                placeholder="Ingrese su dirección" class="form-control " required>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="subscribe btn btn-primary btn-block shadow-sm">
                                            Confirmar Compra
                                        </button>         
                                </form>
                            </div>
                        </div>
                        <div id="paypal" class="tab-pane fade pt-3">
                            <form method="GET" action="{{ route('shop.checkout.paypal') }}"
                                class="pt-3 pb-3 d-flex flex-column">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="distrito">
                                        <h6>Distrito</h6>
                                    </label>
                                    <div class="input-group">
                                            <select name="distrito" class="form-control " required>
                                                <option value="" hidden>Seleccione un distrito</option>
                                                @foreach ($distritos as $distrito)
                                                    <option value='{{$distrito->nombre_ubigeo}}'>{{$distrito->nombre_ubigeo}}</option>
                                                @endforeach
                                            </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="direccion">
                                            <h6>Dirección</h6>
                                        </label>
                                        <div class="input-group">
                                            <input type="text" name="direccion" placeholder="Ingrese su dirección"
                                                class="form-control " required>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex justify-content-center">
                                        <button type="submit" class="btn btn-primary "><i
                                                class="fab fa-paypal mr-2"></i>
                                            Entra
                                            a tu cuenta de Paypal</button>
                                    </div>
                                </div>
                            </form>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        {{-- Carrito Lista --}}
        @if (Cart::count() > 0)
            <div class="col-lg-4 mb-5">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Tu carrito</span>
                </h4>
                <ul class="list-group mb-3 z-depth-1">
                    @foreach (Cart::content() as $item)
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-0">{{ $item->name }}</h6>
                                <small class="text-muted">{{ $item->options->categoriaArticulo }}</small>
                            </div>
                            <span class="text-muted">S/. {{ $item->price }}</span>
                        </li>
                    @endforeach                   
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total </span>
                        <strong>S/. {{ Cart::Total() }}</strong>
                    </li>
                </ul>
            </div>
        @endif
    </div>
</div>
<script type="text/javascript" src="{{asset('json/distritos.json')}}"></script>
<script type="text/javascript" src="{{asset('js/distritos.js')}}"></script>
@endsection





@extends('layouts.guestmain')
@section('content')
<section id="cartview" class="container mt-5 mb-5">
    <div :key="componentKey" class="row">
        <div v-if="cant" class="row">
            <div class="col-lg-8">
                <div class="card wish-list mb-3">
                    <div class="card-body">
                        <h5>Carrito con <span>@{{ cant }}</span> artículo(s)</h5>
                        <p v-if="message"> @{{ message }} </p>
                        {{-- @if (session()->has('success_message'))
                            <p> {{ session()->get('success_message') }} </p>
                        @endif --}}
                        <div v-for="item in items">
                            <hr class="mb-4">
                            <div class="row mb-4 mt-5">
                                <div class="col-md-5 col-lg-3 col-xl-3">
                                    <div class="view zoom overlay z-depth-1 rounded mb-3 mb-md-0">
                                        <a :href="'/products/'+item.name">
                                            <img class="img-fluid w-100" v-if="item.options.photoArticulo" v-bind:src="'store/'+item.options.photoArticulo" alt="">
                                            <img class="img-fluid w-100" v-else v-bind:src="'store/no-image.jpg'" alt="">       
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-7 col-lg-9 col-xl-9">
                                    <div>
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h5>@{{ item.name }}</h5>
                                                <p class="mb-3 text-muted text-uppercase small">
                                                    @{{ item.options.categoriaArticulo }}</p>
                                                <p class="mb-3 text-muted text-uppercase small">Talla
                                                    @{{ item.options.nombreTalla }}</p>
                                            </div>
                                            <div>
                                                <div class="def-number-input number-input safari_only mb-0 w-100">
                                                    <button
                                                        v-on:click.prevent="quitar(item)"
                                                        class="minus"><i class="fas fa-minus"></i></button>
                                                    <input v-on:input.prevent="modificar(item)" class="quantity" v-model="item.qty" min="1" name="quantity" 
                                                        type="number" data-id="item.rowId">
                                                    <button
                                                        v-on:click.prevent="agregar(item)"
                                                        class="plus"><i class="fas fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <button v-on:click.prevent="eliminar(item)" type="submit" class="text-red no-btn">
                                                    <i class="fas fa-trash-alt mr-1 text-red"></i> Quitar artículo
                                                </button>
                                            </div>
                                            <p class="mb-0"><span><strong>S/. @{{ item.price }}</strong></span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="mb-3">Monto total</h5>
                        <ul class="list-group list-group-flush">
                            <li
                                class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                                Subtotal
                                <span>S/. @{{totalcart.subtotal}} </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                Costo de envío
                                <span>Gratis</span>
                            </li>
                            <li
                                class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                                IGV
                                <span>S/. @{{totalcart.igv}} </span>
                            </li>
                            <li
                                class="list-group-item d-flex justify-content-between align-items-center border-right-0 border-bottom-0 border-left-0 px-0 mb-3">
                                <div>
                                    <strong>Monto total</strong>
                                </div>
                                <span><strong>S/. @{{totalcart.total}}</strong></span>
                            </li>
                        </ul>
                        <a class="btn btn-primary btn-block waves-effect waves-light"
                            href=" {{ route('shop.checkout') }} ">Comprar</a>
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="col-lg-12">
            <div class="card wish-list mb-3">
                <div class="card-body">
                    <h5 class="mb-5">El carrito de compras no tiene artículos</h5>
                    <a href=" {{ route('shop.products.hombre') }} ">Seguir comprando</a>
                </div>
            </div>
        </div>
        
    </div>
</section>
<div class="recomendacion">
    <div class="container">
        <h3>Te recomendamos</h3>
        <div class="row mb-5 p-5">
            @foreach ($moreproducts as $moreproduct)
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card h-100">
                        <a class="border-bottom" href="{{ route('shop.product', $moreproduct->nombreArticulo) }}">
                            @if($moreproduct->photoArticulo)
                                <img class="card-img-top" src="{{ asset('store/'.$moreproduct->photoArticulo) }}" alt="">
                            @else
                                <img class="card-img-top" src="{{ asset('store/no-image.jpg') }}" alt="">
                            @endif
                        </a>
                        <div class="card-body">
                            <h4 class="card-title">
                                <a class="shop-name"
                                    href="{{ route('shop.product', $moreproduct->nombreArticulo) }}">{{ $moreproduct->nombreArticulo }}</a>
                            </h4>
                            <p class="card-text">{{ $moreproduct->categoriaArticulo }}</p>
                            <div class="shop-price">
                                <h5>Precio</h5>
                                <h5>S/. {{ $moreproduct->precioArticulo }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/cart.js') }}"></script>
@endsection






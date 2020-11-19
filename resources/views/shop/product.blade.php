@extends('layouts.guestmain')
@section('content')
<div class="body-content">
    <div class="container">
        @if ($empty ?? '')
                <div class="alert alert-danger" role="alert">
                    {{ $empty }}
                </div>
        @endif
        <div class="row mb-5">      
            <div class="col-md-6">
                @if($product[0]->photoArticulo)
                    <img class="card-img-top border border-white" src="{{ asset('store/'.$product[0]->photoArticulo) }}" alt="{{$product[0]->photoArticulo}}">    
                @else
                    <img class="card-img-top border border-white" src="{{ asset('store/no-image.jpg') }}" alt="{{$product[0]->photoArticulo}}">
                @endif
                {{-- <img class="card-img-top border border-white" src="{{ asset('store/'.$product[0]->photoArticulo) }}" alt="{{$product[0]->photoArticulo}}"> --}}
            </div>
            <div class="col-md-6 d-flex flex-column justify-content-center">
                <h3>{{ $product[0]->nombreArticulo }}</h3>
                <h5>{{ $product[0]->categoriaArticulo }}</h5>
                <h4 class="pt-3 pb-3 border-top border-bottom">Precio: S/. {{ $product[0]->precioArticulo }}</h4>
                <h5>Tallas</h5>
                <div class="d-flex flex-row justify-content-around mt-3 mb-4">
                    @foreach ($tallas as $talla)
                        <button id="{{ $talla->idArticuloTalla }}" name="{{ $talla->stockArticulo }}"
                            class="mr-4 button-talla">{{ $talla->nombreTalla }}</button>
                    @endforeach
                </div>
                <form action="{{ route('shop.cart.store') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="idArticuloTalla" id="idArticuloTalla">
                    <input type="hidden" name="nombreArticulo" value="{{ $product[0]->nombreArticulo }}">
                    <input type="hidden" name="precioArticulo" value="{{ $product[0]->precioArticulo }}">
                    <input type="hidden" name="nombreTalla" id="nombreTalla">
                    <input type="hidden" name="photoArticulo" id="photoArticulo" value="{{ $product[0]->photoArticulo }}">
                    <input type="hidden" name="categoriaArticulo" value="{{ $product[0]->categoriaArticulo }}">
                    <button id="submit-add-chart" type="submit" class="btn btn-danger btn-block btn-lg" disabled>Añadir
                        a carrito</button>
                </form>
            </div>
        </div>
    </div>
    <div class="recomendacion">
        <div class="container">
            <h3>Te recomendamos</h3>
            <div class="row mb-5 p-5">
                @foreach ($moreproducts as $moreproduct)
                    <div class="col-lg-3 col-md-6 mb-4">

                        <div class="card h-100">
                            <a class="border-bottom" href="{{ route('shop.product', $moreproduct->nombreArticulo) }}">
                                @if($moreproduct->photoArticulo)
                                    <img style="height: 250px;object-fit: cover" class="card-img-top" src="{{ asset('store/'.$moreproduct->photoArticulo) }}" alt="{{$moreproduct->photoArticulo}}">
                                @else
                                    <img style="height: 250px;object-fit: cover" class="card-img-top" src="{{ asset('store/no-image.jpg') }}" alt="{{$moreproduct->photoArticulo}}">
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
</div>
<script src="{{ asset('js/shopProduct.js') }}"></script>
@endsection







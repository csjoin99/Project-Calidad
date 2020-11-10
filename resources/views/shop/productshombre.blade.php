@extends('layouts.guestmain')
@section('content')
<div class="body-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <h3 class="my-2"><strong>Categorías</strong></h3>
                <div class="list-group product-category mb-5">
                    <a href="{{route('shop.products.hombre')}}" class="nav-link">Todos</a>
                    <a href="{{route('shop.products.hombre',['category'=>'Casaca'])}}" class="nav-link">Casacas</a>
                    <a href="{{route('shop.products.hombre',['category'=>'Jean'])}}" class="nav-link">Jeans</a>
                </div>
            </div>
            <div class="col-lg-9">
                <h2 class=""><strong> {{$genderTitulo}} </strong></h2>
                <div class="row mb-5">
                    @forelse($products as $product)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100">
                            <a class="border-bottom" href="{{route('shop.product',$product->nombreArticulo)}}">
                                @if($product->photoArticulo)
                                    <img class="card-img-top" src="{{asset('store/'.$product->photoArticulo)}}" alt="{{$product->photoArticulo}}">       
                                @else
                                    <img class="card-img-top" src="{{asset('store/no-image.jpg')}}" alt="{{$product->photoArticulo}}"> 
                                @endif
                            </a>
                            <div class="card-body">
                                <h4 class="card-title">
                                    <a class="shop-name" href="{{route('shop.product',$product->nombreArticulo)}}">{{$product->nombreArticulo}}</a>
                                </h4>
                                <p class="card-text">{{$product->categoriaArticulo}}</p>
                                <div class="shop-price">
                                    <h5>Precio</h5>
                                    <h5>S/. {{$product->precioArticulo}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <h5 class="mt-5">No se encontraron artículos</h5>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection




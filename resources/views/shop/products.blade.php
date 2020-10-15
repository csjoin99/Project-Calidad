@include('template/header')
<div class="body-content">


    <div class="container">

        <div class="row">

            <div class="col-lg-3">

                <h1 class="my-4">Categorías</h1>
                <div class="list-group product-category">
                    <a href="#" class="list-group-item">Jean</a>
                    <a href="#" class="list-group-item">Casacas</a>
                    <a href="#" class="list-group-item">Shorts</a>
                </div>

            </div>

            <div class="col-lg-9">
                <div class="row">
                    @foreach($products as $product)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100">
                            <a class="border-bottom" href="{{route('shop.show',$product->nombreArticulo)}}"><img class="card-img-top" src="{{asset('images/jean-1.jpg')}}" alt=""></a>
                            
                            <div class="card-body">
                                <h4 class="card-title">
                                    <a class="shop-name" href="{{route('shop.show',$product->nombreArticulo)}}">{{$product->nombreArticulo}}</a>
                                </h4>
                                <p class="card-text">{{$product->categoriaArticulo}}</p>
                                <div class="shop-price">
                                    <h5>Precio</h5>
                                    <h5>S/. {{$product->precioArticulo}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endforeach


                </div>

            </div>
        </div>

    </div>

</div>

@include('template/footer')
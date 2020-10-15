@include('template/header')

<section class="container mt-5 mb-5">
    <div id="app" class="row">
        @if (Cart::count() > 0)
            <div class="col-lg-8">
                <div class="card wish-list mb-3">
                    <div class="card-body">
                        <h5>Carrito con <span>{{ Cart::count() }}</span> artículo(s)</h5>

                        @if (session()->has('success_message'))
                            <p> {{ session()->get('success_message') }} </p>
                        @endif

                        @foreach (Cart::content() as $item)
                            <hr class="mb-4">
                            <div class="row mb-4 mt-5">
                                <div class="col-md-5 col-lg-3 col-xl-3">
                                    <div class="view zoom overlay z-depth-1 rounded mb-3 mb-md-0">
                                        <a href="{{ route('shop.show', $item->name) }}">
                                            <img class="img-fluid w-100" src="{{ asset('images/jean-1.jpg') }}">
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-7 col-lg-9 col-xl-9">
                                    <div>
                                        <div class="d-flex justify-content-between">
                                            <div>

                                                <h5>{{ $item->name }}</h5>
                                                <p class="mb-3 text-muted text-uppercase small">
                                                    {{ $item->options->categoriaArticulo }}</p>
                                                <p class="mb-3 text-muted text-uppercase small">Talla
                                                    {{ $item->options->nombreTalla }}</p>
                                            </div>
                                            <div>
                                                <div class="def-number-input number-input safari_only mb-0 w-100">
                                                    <button
                                                        onclick="this.parentNode.querySelector('input[type=number]').stepDown()"
                                                        class="minus"><i class="fas fa-minus"></i></button>
                                                    <input class="quantity" min="1" name="quantity"
                                                        value="{{ $item->qty }}" type="number"
                                                        data-id="{{ $item->rowId }}">
                                                    <button
                                                        onclick="this.parentNode.querySelector('input[type=number]').stepUp()"
                                                        class="plus"><i class="fas fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <form action="{{ route('shop.cart.destroy', $item->rowId) }}"
                                                    method="POST">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button type="submit" class="text-red no-btn">
                                                        <i class="fas fa-trash-alt mr-1 text-red"></i> Quitar artículo
                                                    </button>
                                                </form>
                                            </div>
                                            <p class="mb-0"><span><strong>S/. {{ $item->price }}</strong></span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach
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
                                <span>S/. {{ Cart::Subtotal() }} </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                Costo de envío
                                <span>Gratis</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                IGV
                                <span>S/. {{ Cart::Tax() }}</span>
                            </li>
                            <li
                                class="list-group-item d-flex justify-content-between align-items-center border-right-0 border-bottom-0 border-left-0 px-0 mb-3">
                                <div>
                                    <strong>Monto total</strong>
                                </div>
                                <span><strong>S/. {{ Cart::Total() }}</strong></span>
                            </li>
                        </ul>
                        <a class="btn btn-primary btn-block waves-effect waves-light"
                            href=" {{ route('shop.checkout') }} ">Comprar</a>

                    </div>
                </div>
            </div>
        @else
            <div class="col-lg-12">
                <div class="card wish-list mb-3">
                    <div class="card-body">
                        <h5 class="mb-5">El carrito de compras no tiene artículos</h5>
                        <a href=" {{ route('shop.products') }} ">Seguir comprando</a>
                    </div>
                </div>
            </div>
        @endif

    </div>
</section>
<div class="recomendacion">
    <div class="container">
        <h3>Te recomendamos</h3>
        <div class="row mb-5 p-5">

            @foreach ($moreproducts as $moreproduct)
                <div class="col-lg-3 col-md-6 mb-4">

                    <div class="card h-100">
                        <a class="border-bottom" href="{{ route('shop.show', $moreproduct->nombreArticulo) }}"><img
                                class="card-img-top" src="{{ asset('images/jean-1.jpg') }}" alt=""></a>
                        <div class="card-body">
                            <h4 class="card-title">
                                <a class="shop-name"
                                    href="{{ route('shop.show', $moreproduct->nombreArticulo) }}">{{ $moreproduct->nombreArticulo }}</a>
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
<script>
    const classname = document.getElementsByClassName('quantity');
    const plus = document.getElementsByClassName('plus');
    const minus = document.getElementsByClassName('minus');
    /* Text box */
    for (let i = 0; i < classname.length; i++) {
        classname[i].addEventListener("change", function() {
            const id = classname[i].getAttribute('data-id');
            axios.patch(`/shop/cart/${id}`, {
                    quantity: this.value
                })
                .then(function(response) {
                    console.log(response);
                    document.location.reload(true)
                })
                .catch(function(error) {
                    console.log(error);
                });
        });
    }
    /* Plus */
    for (let i = 0; i < classname.length; i++) {
        plus[i].addEventListener("click", function() {
            const id = classname[i].getAttribute('data-id');
            axios.patch(`/shop/cart/${id}`, {
                    quantity: classname[i].value
                })
                .then(function(response) {

                    console.log(response);
                    document.location.reload(true)
                    
                })
                .catch(function(error) {
                    console.log(error);
                });
        });
    }
    /* Minus */
    for (let i = 0; i < classname.length; i++) {
        minus[i].addEventListener("click", function() {
            const id = classname[i].getAttribute('data-id');
            axios.patch(`/shop/cart/${id}`, {
                    quantity: classname[i].value
                })
                .then(function(response) {
                    console.log(response);
                    document.location.reload(true)
                })
                .catch(function(error) {
                    console.log(error);
                });
        });
    }
</script>
@include('template/footer')

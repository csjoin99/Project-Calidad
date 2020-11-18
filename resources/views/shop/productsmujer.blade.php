@extends('layouts.guestmain')
@section('content')
<div id="showarticulos" class="body-content">
    <div :key="componentKey" class="container">
        <div class="row">
            <div class="col-lg-3">
                <h3 class="my-2"><strong>Categorías</strong></h3>
                <div class="list-group product-category mb-5">
                    <a href="#" v-on:click.prevent="filtrar()" class="nav-link">Todos</a>
                    <a href="#" v-on:click.prevent="filtrar('Casaca')" class="nav-link">Casacas</a>
                    <a href="#" v-on:click.prevent="filtrar('Jean')" class="nav-link">Jeans</a>
                </div>
            </div>
            <div class="col-lg-9">
                <h2 class=""><strong v-text="categoria"></strong></h2>
                <div v-if="cant" class="row mb-5"> 
                    <div  v-for="articulo in articulos" class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100">
                            <a class="border-bottom" v-bind:href="'/product/'+ articulo.nombreArticulo">
                                    <img style="height: 250px;object-fit: cover" v-if="articulo.photoArticulo" class="card-img-top" v-bind:src="articulo.photoArticulo" :alt="articulo.nombreArticulo">       
                                    <img style="height: 250px;object-fit: cover" v-else class="card-img-top" src="{{asset('store/no-image.jpg')}}" :alt="articulo.nombreArticulo"> 
                            </a>
                            <div class="card-body">
                                <h4 class="card-title">
                                    <a class="shop-name" v-bind:href="'/product/'+ articulo.nombreArticulo" v-text="articulo.nombreArticulo"></a>
                                </h4>
                                <p class="card-text" v-text="articulo.categoriaArticulo"></p>
                                <div class="shop-price">
                                    <h5>Precio</h5>
                                    <h5>S/. <span v-text="articulo.precioArticulo"></span></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else class="row mb-5">
                    <h5  class="mt-5">No se encontraron artículos</h5>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    window.gender = {!! json_encode($genero) !!};
</script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/showarticulos.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>    
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/javascript.util/0.12.12/javascript.util.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
@endsection




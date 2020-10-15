@include('template/header')


<div class="body-content">
    @if (session()->has('success_message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session()->get('success_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (session()->has('failure_message'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session()->get('failure_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="{{ asset('images/image1.jpg') }}" alt="First slide">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Compromiso</h5>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="{{ asset('images/image2.jpg') }}" alt="Second slide">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Calidad</h5>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="{{ asset('images/image3.jpg') }}" alt="Third slide">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Puntualidad</h5>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <div class="container mt-5 w-100">
        <div class="row alig-vertical">
            <div class="col-md-6">
                <div class="grid-col-2">
                    <div>
                        <img src="{{ asset('images/empresa1.jpg') }}" alt="">
                    </div>
                    <div>
                        <img src="{{ asset('images/empresa2.jpg') }}" alt="">
                    </div>
                    <div>
                        <img src="{{ asset('images/empresa3.jpg') }}" alt="">
                    </div>
                    <div>
                        <img src="{{ asset('images/empresa4.jpg') }}" alt="">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h2>#Estilos</h2>
                <p class="style-text">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Repudiandae numquam
                    aliquid minima quaerat saepe est, perspiciatis quasi sequi doloribus, illo ex id necessitatibus sint
                    repellendus, velit a officia ab fuga.</p>
                <p>Para saber mas de nosotros entra a nuestra pagina de Facebook</p>
                <button class="btn btn-primary btn-lg">Ir a la página</button>
            </div>
        </div>
    </div>
    <div class="body-info mt-5">
        <h1>Ropa a pedido</h1>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-center">
                <div class="card card-product-1">
                    <img src="{{ asset('images/card1.jpg') }}" alt="">
                    <div class="card-img-overlay text-white card-product">
                        <div class="card-title">
                            Jeans
                        </div>
                        <div class="card-text">
                            Jeans al mejor precio
                        </div>
                        <a href="{{ route('shop.products') }}" class="btn btn-success btn-lg mt-3">Ver catalogo</a>
                    </div>

                </div>
            </div>
            <div class="col-md-6 text-center">
                <div class="card card-product-1">
                    <img src="{{ asset('images/card2.jpg') }}" alt="">
                    <div class="card-img-overlay text-white card-product">
                        <div class="card-title">
                            Pantalones
                        </div>
                        <div class="card-text">
                            Pantalones al mejor precio
                        </div>
                        <a href="{{ route('shop.products') }}" class="btn btn-success btn-lg mt-3">Ver catalogo</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="contactanos mt-5 w-100">
        <div class="container ">
            <h3 class="mt-5 mb-5 text-center">Dejanos un mensaje</h3>
            <form action="">
                <div class="form-group">
                    <div class="label">Nombre:</div>
                    <input name="nombre" type="text" class="form-control" placeholder="Nombre">
                </div>
                <div class="form-group">
                    <div class="label">Nro de celular:</div>
                    <input name="celular" type="tel" class="form-control" placeholder="Celular">
                </div>
                <div class="form-group">
                    <div class="label">Tu mensaje:</div>
                    <textarea name="mensaje" type="text" class="form-control" placeholder="Mensaje"></textarea>
                </div>
                <input type="submit" class="btn btn-primary btn-lg btn-block mt-5 mb-5">
            </form>
        </div>
    </div>
    <section class="ubicacion" id="Ubicanos">

        <div class="container">
            <h3 class="text-center text-uppercase py-5">Nuestra ubicacion</h3>
            <div class="mapa">
                <iframe class="map"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d975.9382569990597!2d-77.02428294526361!3d-11.922268246924585!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9105d15889b76e93%3A0xa8021ebde06f9592!2sColegio%20Cristo%20Hijo%20de%20Dios%202075!5e0!3m2!1ses-419!2spe!4v1601427293989!5m2!1ses-419!2spe"
                    frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
            </div>
        </div>

    </section>
</div>
@include('template/footer')

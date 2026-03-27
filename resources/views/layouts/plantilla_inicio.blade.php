<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Misky Selva</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon"  href="{{asset('ca.png') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href=" https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
{{--    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">--}}
{{--    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">--}}
    <link rel="stylesheet" href="{{asset('fontawasone/css/all.css')}}">
{{--    <link rel="stylesheet" href="{{asset('../vendor/twbs/bootstrap-icons/font/bootstrap-icons.css')}}">--}}
{{--    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>--}}
    <link rel="stylesheet" href="{{asset('css/bootstrap-icons.css')}}">

    <!-- Libraries Stylesheet -->
    <link href="{{asset('inicio/lib/animate/animate.min.css')}}" rel="stylesheet">
    <link href="{{asset('inicio/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('inicio/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{asset('inicio/css/style.css')}}" rel="stylesheet">
    <script src="{{asset('inicio/js/jquery-3.4.1.min.js')}}"></script>

</head>

<body>

<div class="modal fade" id="terminmmos_condiciones" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">TERMINOS Y CONDICIONES</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        @if($idioma == "es")
                            <b class="text-primary">NUESTRO SITIO WEB</b>
                            <p class="text-justify">El acceso y uso del sitio web de Miski Selva SRL están regidos por la legislación correspondiente de la Republica del Perú, así como por los “términos y Condiciones” establecidos por Miski Selva SRL. Por lo consiguiente; todas las visitas y todos los contratos y transacciones que se realicen en este sitio y sus efectos jurídicos quedaran regidos por estas reglas y sometidos a la legislación respectiva.</p>

                            <b class="text-primary">TERMINOS Y CONDICIONES </b>
                            <p>Es requisito para permanecer y navegar en la web de Miski Selva SRL, aceptar los términos y condiciones siguientes:</p>
                            <ul>
                                <li>a.- Para realizar algún pedido o transacción en este sitio, no es necesario estar registrado pero
                                    se recomienda el registro para agilizar el proceso en transacciones futuras.
                                </li>
                                <li>
                                    b.- Contraseñas: Cada usuario que se registre, dispondrá de un nombre y contraseña definitiva
                                    que le permitirá el acceso personalizado, confidencial y seguro. El usuario tendrá la posibilidad
                                    de cambiar la clave de acceso, para lo cual debe de seguir el procedimiento establecido en el
                                    sitio respectico. El usuario es totalmente responsable de mantener la confidencialidad de su
                                    clave secreta registrada en este sitio web, la cual le da acceso a efectuar compras, solicitar
                                    servicios y obtener información. Dicha clave o contraseña es única y exclusivamente de uso
                                    personal y su entrega a terceros, no involucra ninguna responsabilidad de Miski Selva SRL.
                                </li>
                                <li>
                                    c.- Capacidad legal: Nuestros servicios solo están disponibles para personas que tengan capacidad
                                    legal para contratar. Personas que no demuestren esa capacidad entre ellos los menores de
                                    edad o usuarios de Miski Selva SRL que hayan sido suspendidos temporalmente o
                                    inhabilitados, no podrán utilizar nuestros servicios.
                                    Los actos que los menores realicen en este sitio web serán responsabilidad de sus padres,
                                    tutores, encargados o curadores y por lo tanto se considerarán realizados por estos en ejercicio
                                    de la representación legal con la que cuentan.

                                </li>
                                <li>
                                    d.- Quien registre un usuario como empresa afirmara que:
                                    <ul>
                                        <li>I. Cuenta con capacidad para contratar en representación de tal entidad y obliga a la misma
                                            en los términos de este acuerdo.
                                        </li>
                                        <li>
                                            II. La dirección señalada en el registro es el domicilio legal y/o fiscal de dicha entidad.
                                        </li>
                                        <li>
                                            III. Cualquier otra información presentada a Miski Selva SRL es verdadera, precisa, actualizada,
                                            completa y oportuna.

                                        </li>
                                    </ul>
                                </li>

                            </ul>
                            <b class="text-primary">PROCESO DE VENTAS</b>
                            <b class="d-block   ">CONDICION DE VENTA</b>
                            <ul>
                                <li>1.- La venta al por menor es a partir de 1 producto de Miski Selva SRL</li>
                                <li>2.- La venta al por mayor es a partir de ….. productos de Miski Selva SRL</li>
                            </ul>
                            <b>La venta al por mayor es a partir de ….. productos de Miski Selva SRL</b>
                            <ul>
                                <li>1.- En PRODUCTOS seleccionar cada producto y cantidad que desee adquirir.</li>
                            </ul>
                        @else

                            <b class="text-primary">TERMS AND CONDITIONS</b>
                            <p>It is a requirement to stay and navigate on the Miski Selva SRL website to accept the following terms and conditions:</p>

                            <ul>
                                <li>a.- To place an order or make a transaction on this site, it is not necessary to be registered, but registration is recommended to expedite future transactions.</li>
                                <li>
                                    b.- Passwords: Each registered user will have a username and a permanent password that will allow personalized, confidential, and secure access. The user will have the possibility to change the access key, for which they must follow the procedure established on the respective site. The user is entirely responsible for maintaining the confidentiality of their secret password registered on this website, which gives them access to make purchases, request services, and obtain information. Such a password is unique and exclusively for personal use, and its delivery to third parties does not involve any responsibility on the part of Miski Selva SRL.
                                </li>
                                <li>
                                    c.- Legal Capacity: Our services are only available to people who have the legal capacity to contract. People who do not demonstrate that capacity, including minors or Miski Selva SRL users who have been temporarily suspended or disabled, cannot use our services. The acts that minors carry out on this website will be the responsibility of their parents, guardians, trustees, or curators, and therefore, they will be considered as carried out by them in the exercise of their legal representation.
                                </li>
                                <li>
                                    d.- Anyone registering as a company will affirm that:
                                    <ul>
                                        <li>I. They have the capacity to contract on behalf of such an entity and bind it to the terms of this agreement.</li>
                                        <li>
                                            II. The address provided in the registration is the legal and/or fiscal domicile of the entity.
                                        </li>
                                        <li>
                                            III. Any other information presented to Miski Selva SRL is true, accurate, up-to-date, complete, and timely.

                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            **<b class="text-primary">SALES PROCESS</b>
                            **<b class="d-block   ">SALES CONDITION</b>
                            <ul>
                                <li>1.- Retail sales start from 1 product from Miski Selva SRL.</li>
                                <li>2.- Wholesale sales start from ..... products from Miski Selva SRL.</li>
                            </ul>
                            Wholesale sales start from ..... products from Miski Selva SRL
                            <ul>
                                <li>1.- In PRODUCTS, select each product and quantity you wish to purchase.</li>
                            </ul>
                        @endif

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Spinner Start -->
<div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-border text-primary" role="status"></div>
</div>
<!-- Spinner End -->


@if(count($oferta_descuento) > 0)
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" >
            <div class="modal-content" >
                <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="false">
                    <div class="carousel-indicators">
                        @if(count($oferta_descuento) >1)
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        @endif
                    </div>
                    @php $a = 1; @endphp
                    @foreach($oferta_descuento as $o)
                        <div class="carousel-inner">
                            <div class="carousel-item {{$a == 1 ? 'active' : ' '}}">
                                <img src="{{asset($o->oferta_foto)}}" class="d-block w-100" alt="...">
                                {{--                                    style="display: flex!important;justify-content: center;align-items: center"--}}
                                <div class="carousel-caption d-none d-md-block text-center" >
                                    {{--                                        <h1 class="mt-2" style="">{{$o->oferta_nombre}}</h1>--}}
                                </div>
                            </div>
                        </div>
                        @php $a++ @endphp
                    @endforeach
                    @if(count($oferta_descuento) >1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    @endif
                </div>
                <button type="button" class="btn btn-primary">Ver Detalles</button>
            </div>
        </div>
    </div>
@endif


@include('layouts.navbar_inicio')

@yield('content_inicio')

@include('layouts.footer_inicio')

<!-- Back to Top -->
<a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i class="fa-solid fa-arrow-up"></i></a>
<!-- JavaScript Libraries -->
<script src="{{asset('inicio/js/jquery-3.4.1.min.js')}}"></script>
{{--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>--}}
<script src="{{asset('inicio/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('inicio/lib/wow/wow.min.js')}}"></script>
<script src="{{asset('inicio/lib/easing/easing.min.js')}}"></script>
<script src="{{asset('inicio/lib/waypoints/waypoints.min.js')}}"></script>
<script src="{{asset('inicio/lib/owlcarousel/owl.carousel.min.js')}}"></script>

<!-- Template Javascript -->
<script src="{{asset('js/domain.js')}}"></script>
<script src="{{asset('js/tours.js')}}"></script>
<script src="{{asset('inicio/js/main.js')}}"></script>
<script src="{{asset('inicio/js/inicio.js')}}"></script>
<script src="{{asset('js/globalfunctions.js')}}"></script>

<script src="{{asset('js/datatable.js')}}"></script>
<script src="{{asset('js/datatable/datatable_1.js')}}"></script>
<script src="{{asset('js/datatable/datatable_2.js')}}"></script>
<script src="{{asset('js/datatable/datatable_3.js')}}"></script>

</body>

</html>

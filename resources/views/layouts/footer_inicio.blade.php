<!-- Footer Start -->
<div class="container-fluid bg-dark footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-lg-3 col-md-12 col-sm-12 ">
                <h4 class="text-light mb-4">{{$idioma == "es" ? ' DIRECCIÓN': ' ADDRESS'}}</h4>
                <p><i class="fa fa-map-marker-alt me-3"></i>{{$contactanos[4]->contacto_valor}}</p>
                <p><i class="fa fa-phone-alt me-3"></i>+51 {{$contactanos[5]->contacto_valor}}</p>
                <p><i class="fa fa-phone-alt me-3"></i>+51 {{$contactanos[6]->contacto_valor}}</p>
                <p><a href="mailto:{{$contactanos[9]->contacto_valor}}" style="    color: #999999;"><i class="fa fa-envelope me-3"></i> {{$contactanos[9]->contacto_valor}}</a></p>
                <p><a href="mailto:{{$contactanos[10]->contacto_valor}}" style="    color: #999999;"><i class="fa fa-envelope me-3"></i> {{$contactanos[10]->contacto_valor}}</a></p>
            </div>
            <div class="col-lg-3 col-md-12 col-sm-12 ">
                <h4 class="text-light mb-4">{{$idioma == "es" ? ' Enlaces rápidos': ' Quick links'}}</h4>
                <a class="btn btn-link" href="{{route('inicio.nosotros')}}">{{$idioma == "es" ? ' Conócenos': ' know us'}}</a>
                <a class="btn btn-link" href="{{route('inicio.contactanos')}}">{{$idioma == "es" ? ' Contáctanos': ' Contact us'}}</a>
                <a class="btn btn-link" href="{{route('inicio.productos')}}">{{$idioma == "es" ? 'Productos' : 'Products'}}</a>
                <a class="btn btn-link" href="{{route('inicio.tiendas')}}">{{$idioma == 'es' ?'Socios comerciales':'Business partners'}}</a>
                {{--                <a class="btn btn-link" href="">Apoyo</a>--}}
                <a class="btn btn-link" href="{{route('admin')}}">{{$idioma == 'es' ?'Intranet':'Intranet'}}</a>
                <a class="btn btn-link" data-bs-toggle="modal" data-bs-target="#terminmmos_condiciones" >{{$idioma == 'es' ?'TERMINOS Y CONDICIONES':'TERMS AND CONDITIONS'}}</a>
            </div>
            <div class="col-lg-3 col-md-12 col-sm-12 ">
                <h4 class="text-light mb-4">{{$idioma == 'es' ?'0fertas y promociones':'Offers and promotions'}}</h4>
                <p>{{$idioma == 'es' ?'Enviamos un correo electrónico para acceder a las promociones.':'We send an email to access the promotions.'}}</p>
                <div class="position-relative mx-auto" style="max-width: 500px;">
{{--                    <input class="form-control bg-transparent w-100 py-3 ps-4 pe-5" type="text" placeholder="Correo">--}}
                    <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2 w-100" style="border-radius: 40px"  data-bs-toggle="modal" data-bs-target="#exampleModal">{{$idioma == 'es' ?'Ver Ofertas':'See Offers'}}</button>
                </div>

            </div>
            <div class="col-lg-3 col-md-12 col-sm-12 align-items-center d-flex justify-content-center flex-column" >
                <img src="{{asset('inicio/img/logo.png')}}" class="w-75" alt="" >
                <div class="d-flex pt-4">
                    @php
                        $w = explode(' ',$contactanos[7]->contacto_valor);
                        $w2 = explode(' ',$contactanos[8]->contacto_valor);
                    @endphp
                    <a class="btn btn-square btn-outline-light rounded-circle me-1" href="{{$contactanos[2]->contacto_valor}}" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a class="btn btn-square btn-outline-light rounded-circle me-1" href="{{$contactanos[0]->contacto_valor}}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-square btn-outline-light rounded-circle me-1" href="{{$contactanos[1]->contacto_valor}}" target="_blank"><i class="fab fa-youtube"></i></a>
                    <a class="btn btn-square btn-outline-light rounded-circle me-1" href="https://wa.me/{{$w[0].$w[1].$w[2].$w[3]}}" target="_blank"><i class="fa-brands fa-whatsapp " ></i></a>
                    <a class="btn btn-square btn-outline-light rounded-circle me-1"title="{{$contactanos[9]->contacto_valor}}"  href="mailto:{{$contactanos[9]->contacto_valor}}" target="_blank"><i class="fa fa-envelope " ></i></a>
                    <a class="btn btn-square btn-outline-light rounded-circle me-1"  title="{{$contactanos[10]->contacto_valor}}"  href="mailto:{{$contactanos[10]->contacto_valor}}" target="_blank"><i class="fa fa-envelope " ></i></a>
                </div>
            </div>

            <div class="col-lg-5 col-md-12 col-sm-12">
                <h4 class="text-light mb-4">{{$idioma == "es" ? 'Formas de pago' : 'Payment Methods'}}</h4>
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <a class="btn btn-link" >Visa</a>
                        <a class="btn btn-link" >Mastercard</a>
                        <a class="btn btn-link" >American Express</a>
                        <a class="btn btn-link">Diners Club</a>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <a class="btn btn-link">Yape</a>
                        <a class="btn btn-link">Plin</a>
                        <a class="btn btn-link">Tunki</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="container-fluid copyright">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    Copyright  &copy; <?= date('Y'); ?> Hecho con <i class="fa fa-heart" aria-hidden="true"></i> por <a href="#">Misky Selva</a> .
                </div>
                {{--                <div class="col-md-6 text-center text-md-end">--}}
                <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                {{--                    Designed By <a href="https://htmlcodex.com">HTML Codex</a>--}}
                {{--                    <br>Distributed By: <a href="https://themewagon.com" target="_blank">ThemeWagon</a>--}}
                {{--                </div>--}}
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->

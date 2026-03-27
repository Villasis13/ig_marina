<!-- Navbar Start -->
<div class="container-fluid fixed-top px-0 wow fadeIn" data-wow-delay="0.1s">
    <div class="top-bar row gx-0 align-items-center d-none d-lg-flex">
        <div class="col-lg-10 px-5 text-start">
            <small><a href="https://goo.gl/maps/ZbXRg6cFb8DfcDpy9" target="_blank"><i class="fa fa-map-marker-alt me-2"></i>{{$contactanos[4]->contacto_valor}}</a></small>
            <small class="ms-4"><a href="mailto:{{$contactanos[9]->contacto_valor}}"><i class="fa fa-envelope me-2"></i>{{$contactanos[9]->contacto_valor}}</a></small>
            <small class="ms-4"><a href="mailto:{{$contactanos[10]->contacto_valor}}"><i class="fa fa-envelope me-2"></i>{{$contactanos[10]->contacto_valor}}</a></small>
            @php
                $w = explode(' ',$contactanos[7]->contacto_valor);
                $w2 = explode(' ',$contactanos[8]->contacto_valor);
            @endphp
            <small class="ms-4"><a href="https://wa.me/{{$w[0].$w[1].$w[2].$w[3]}}" target="_blank"><i class="fa-brands fa-whatsapp me-2" ></i>{{$contactanos[7]->contacto_valor}}</a></small>
            <small class="ms-4"><a href="https://wa.me/{{$w2[0].$w2[1].$w2[2].$w2[3]}}" target="_blank"><i class="fa-brands fa-whatsapp me-2" ></i>{{$contactanos[8]->contacto_valor}}</a></small>
        </div>
        <div class="col-lg-2  text-start">
            <small>Síguenos:</small>
            <a class="text-body ms-3" href="{{$contactanos[0]->contacto_valor}}"><i class="fab fa-facebook-f"></i></a>
            <a class="text-body ms-3" href="#"><i class="fab fa-tiktok"></i></a>
            <a class="text-body ms-3" href="{{$contactanos[1]->contacto_valor}}"><i class="fab fa-youtube"></i></a>
            <a class="text-body ms-3" href="{{$contactanos[2]->contacto_valor}}"><i class="fab fa-instagram"></i></a>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light py-lg-0 px-lg-5 wow fadeIn" data-wow-delay="0.1s">
        <a href="{{route('inicio.nosotros')}}" class="navbar-brand ms-4 ms-lg-0">
            <img src="{{asset('inicio/img/logo.png')}}" alt="" style="width: 150px;">
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon" ></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarCollapse">
            <div class="navbar-nav  navbar-nav-scroll p-2" style="--bs-scroll-height: 500px;">
                <a href="{{route('inicio.inicio')}}" class="nav-item nav-link active">{{$idioma == "es" ? 'Inicio ' : 'Home'}}</a>
                <a href="{{route('inicio.nosotros')}}" class="nav-item nav-link">{{$idioma == "es" ? 'Conócenos ' : 'know us'}}</a>
                <a href="{{route('inicio.productos')}}" class="nav-item nav-link">{{$idioma == "es" ? 'Productos' : 'Products'}}</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle " data-bs-toggle="dropdown">{{$idioma == "es" ? 'Importante' : 'Important'}}</a>
                    <div class="dropdown-menu m-0">
                        <a href="{{route('inicio.tiendas')}}" class="dropdown-item">{{$idioma == 'es' ?'Socios comerciales':'Business partners'}}</a>
                        <a href="{{route('inicio.curiosidades')}}" class="dropdown-item">{{$idioma =="es" ? 'Curiosidades' : 'Curiosities'}}</a>
                        <a href="{{route('inicio.evento')}}" class="dropdown-item">{{$idioma =="es" ? 'Eventos' : 'Events'}}</a>
                    </div>
                </div>
{{--                <a href="{{route('inicio.tiendas')}}" class="nav-item nav-link"></a>--}}
{{--                <a href="{{route('inicio.')}}" class="nav-item nav-link">Curiosidades</a>--}}
                <a href="{{route('inicio.contactanos')}}" class="nav-item nav-link">{{$idioma =="es" ? 'Contáctanos' : 'Contact us'}}</a>
                <div class="nav-item dropdown">
                    @if($idioma == "es")
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><img src="{{asset('es.png')}}"   style="width: 28px;border-radius: 50%" alt=""></a>
                    @else
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><img src="{{asset('en.jpg')}}" style="width: 28px;border-radius: 50%" alt=""></a>
                    @endif
                    <div class="dropdown-menu m-0">
                        <a href="{{route('inicio.cambiar_inicio',"es")}}" class="dropdown-item"><img src="{{asset('es.png')}}"   style="width: 28px;border-radius: 50%" alt=""> Español</a>
                        <a href="{{route('inicio.cambiar_inicio',"en")}}" class="dropdown-item"><img src="{{asset('en.jpg')}}" style="width: 28px;border-radius: 50%" alt=""> Ingles</a>
                    </div>
                </div>
                @if(session()->has('datos_usuario'))
                    <a href="{{route('inicio.Detalles_usuarios')}}" class="nav-item nav-link text-primary" style="text-transform: capitalize;font-weight: 600">{{ session('datos_usuario')['nombre'] }}</a>
                    <a class="nav-item nav-link " id="btn_sign_off"><i class="fa-solid fa-door-open" style="font-size: 20px"></i></a>
                @else
                    <a href="{{route('inicio.login_')}}" class="nav-item nav-link"><i class="fa-solid fa-user-tie" style="font-size: 20px"></i>{{$idioma == "es" ? ' Regístrate' : ' Sign up'}} </a>
                @endif
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle " data-bs-toggle="dropdown">
                        @if(count(session('shop', [])) > 0)
                            <i class="fa-solid fa-cart-shopping  fa-bounce text-body" style="font-size: 20px"></i>
                        @else
                            <i class="fa-solid fa-cart-shopping  text-body" style="font-size: 20px"></i>
                        @endif
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{count(session('shop', []))}}+
                            <span class="visually-hidden">unread messages</span>
                          </span>
                    </a>
                    @if(count(session('shop', [])) > 0)
                        <div class="dropdown-menu m-0" style="min-width: 16rem;    border-radius: 30px;">
                          <div class="card-body contenedor-scroll " style="overflow-y: scroll;max-height: 250px">
                              @foreach(session('shop', []) as $item)
                                  <div class="row mb-3 pb-3 border-bottom ">
                                      <div class="col-lg-10 col-md-10 col-sm-10 mb-3">
                                          <h6 class="m-0" style="font-weight: 400">@php echo $idioma == "es" ? $item[1] : $item[7] @endphp</h6>
                                      </div>
                                      <div class="col-lg-2 col-md-2 col-sm-2 mb-3">
                                              @if($idioma == "es")
                                              <button data-title ="Eliminar" class="btn btn-sm" type="button" onclick=" preguntar('¿Está seguro que desea eliminar este articulo?','eliminar_producto_carrito','Si','No','{{ $item[5]}}','{{$item[0] != 0 ? 1 :2 }}')"><i class="fa fa-trash text-danger"></i></button>
                                          @else
                                              <button data-title ="Eliminar" class="btn btn-sm" type="button" onclick=" preguntar('Are you sure you want to delete this article?','eliminar_producto_carrito','Si','No','{{ $item[5]}}','{{$item[0] != 0 ? 1 :2}}')"><i class="fa fa-trash text-danger"></i></button>
                                          @endif
                                      </div>
                                      <div class="col-lg-6 col-md-6 col-sm-6">
                                          <h5 class="m-0" style="">{{$idioma == "es" ? 'S/ ':'$ '}} {{$idioma == "es" ? round($item[3],2):round($item[3]/$tipo_cambio,2)}}</h5>
                                      </div>
                                      <div class="col-lg-6 col-md-6 col-sm-6">
                                          @if($item[0] != 0)
                                              <div class="d-flex align-items-center justify-content-between">
                                                  <div class="conteo_producto restar_cantidad"  onclick="spam_resta('cantidad_producto__{{ $item[5] }}')" r_r="{{ $item[5] }}" style="width: 30px;height: 30px;font-size: 24px;font-weight: 900">-</div>
                                                  <input type="text" class="w-50  text-center" style="border: none;background: none;outline: none" readonly id="cantidad_producto__{{ $item[5] }}" name="cantidad_producto__{{ $item[5] }}" value="{{ $item[2] }}">
                                                  <div class="conteo_producto sumar_cantidad"  onclick="spam_sumar('cantidad_producto__{{ $item[5] }}')" s_s="{{ $item[5] }}" style="width: 30px;height: 30px;font-size: 24px;font-weight: 900">+</div>
                                              </div>
                                          @endif
                                      </div>
                                  </div>
                              @endforeach
                          </div>
                            @if(count(session('shop', [])) > 0)
                                <div class="card-footer">
                                    <div class="row ">
                                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                            <a class="btn  text-white bg-success w-100 btn-sm " href="{{route('inicio.carrito')}}"><i class="fa fa-cart-plus"></i>{{$idioma == "es" ? ' Carrito' : ' Trolley'}} </a>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                            <a class="btn  text-white bg-danger w-100  btn-sm " href="{{route('inicio.venta')}}"><i class="fa fa-money-bill"></i> {{$idioma == "es" ? ' Pagar' : ' Pay'}}</a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
{{--                <a href="#" class="nav-item nav-link">--}}
{{--                    @if(count($oferta)  > 0)--}}
{{--                        <img src="{{asset('inicio/img/iconoajisactivo.png')}}" style="width: 50%" class=" fa-bounce" alt="">--}}
{{--                    @else--}}
{{--                        <img src="{{asset('inicio/img/iconoajis.png')}}" alt="" style="width: 50%">--}}
{{--                    @endif--}}
{{--                </a>--}}
                <div class="nav-item dropdown">
                    <a href="{{route('inicio.oferta')}}" class="nav-link " >
                        @if(count($oferta_descuento)  > 0 || count($oferta_paquete)  > 0 )
                            <i class="fa-solid fa-fire fa-bounce text-danger"  title="Oferta" style="font-size: 20px"></i>
                        @else
                            <i class="fa-solid fa-fire  text-body" title="Oferta" style="font-size: 20px"></i>
                        @endif
                    </a>
                </div>

{{--                <div class="dropdown d-flex flex-column align-items-center justify-content-center ">--}}
{{--                    <button type="button" class="btn  dropdown-toggle position-relative"   data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">--}}
{{--                        <i class="fa-solid fa-cart-shopping text-body" style="font-size: 20px"></i>--}}
{{--                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">--}}
{{--                            {{count(session('shop', []))}}+--}}
{{--                            <span class="visually-hidden">unread messages</span>--}}
{{--                          </span>--}}
{{--                    </button>--}}
{{--                    @if(count(session('shop', [])) > 0)--}}
{{--                        <div class="  dropdown-menu" style="left: -190px!important;min-width: 27rem!important;">--}}
{{--                            <div class="card-body">--}}



{{--                            </div>--}}

{{--                        </div>--}}
{{--                    @endif--}}
{{--                </div>--}}
            </div>


        </div>

    </nav>
</div>
<!-- Navbar End -->

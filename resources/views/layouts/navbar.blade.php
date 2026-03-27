<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo d-flex justify-content-center mb-2">
        <a href="{{route('admin')}}" class="app-brand-link">
          <span class="app-brand-logo demo">
            <img src="{{asset('logo_IGLM.png')}}" alt="" style="max-width: 250px">
          </span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Layouts -->
        @php
            $menu = app('menu');
        @endphp
        @foreach($menu as $m)
            @can($m->menu_controlador)
                @php $menu = explode('.',Request::route()->getName()) @endphp
                <li class="menu-item {{ ($menu[0]==$m->menu_controlador)?'open':''  }}  ">
                    <a href="javascript:void(0);" class="menu-link menu-toggle  ">
                        <i class="menu-icon {{$m->menu_icono}}"></i>
                        <div>{{$m->menu_nombre }}</div>
                    </a>
                    @foreach($m->submenu as $sub)
                    <ul class="quitar_hover_navbar menu-sub ">
                        @can($sub->submenu_funcion)
                        @if( $menu[0] != "admin" )
                            <li class="menu-item {{ ($sub->submenu_funcion == $menu[1]) ? 'active' : '' }} ">
                        @else
                            <li class="menu-item  ">
                        @endif
                            <a href="{{url($m->menu_controlador.'/'.$sub->submenu_funcion)}}" class="quitar_hover_op menu-link">
                                <div>{{$sub->submenu_nombre}}</div>
                            </a>
                        </li>
                        @endcan
                    </ul>
                    @endforeach
                </li>
            @endcan
        @endforeach

    </ul>
</aside>

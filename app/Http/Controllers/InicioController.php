<?php

namespace App\Http\Controllers;
use App\Mail\Cambiar;
use App\Mail\Cliente;
use App\Mail\Dueño;
use App\Models\Tipografia;
use App\Models\Visualizacion;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Carbon;
use App\Mail\MiCorreo;
use App\Models\Actividad;
use App\Models\Agencias;
use App\Models\Banner_inicio;
use App\Models\Caja;
use App\Models\Categoria;
use App\Models\Clientes;
use App\Models\Clientes_miski;
use App\Models\Contacto;
use App\Models\Curiosidades;
use App\Models\Direccion_usuario;
use App\Models\Distribuidor;
use App\Models\Empresa;
use App\Models\Eventos;
use App\Models\General;
use App\Models\Imagenes_producto;
use App\Models\Ins_distribucion;
use App\Models\Logs;
use App\Models\Menu;
use App\Models\Moneda;
use App\Models\Nosotros_descripcion;
use App\Models\Nosotros_fotografia;
use App\Models\Nosotros_valores;
use App\Models\Nutrientes;
use App\Models\Oferta;
use App\Models\Oferta_detalle;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\Recursos;
use App\Models\Serie;
use App\Models\Tipo_cambio;
use App\Models\Tipo_documento;
use App\Models\Transaccion;
use App\Models\User;
use App\Models\Usuariosmisky;
use App\Models\Venta_detalle;
use App\Models\Ventas;
use App\Models\Ventas_detalle_pago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Luecano\NumeroALetras\NumeroALetras;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class InicioController extends Controller
{
    protected  $oferta;
    public function __construct()
    {
        $this->oferta = new Oferta();
    }

    public function inicio(){
        try {
            // Verificar si existe la variable de sesión 'shop'
//            if (Session::has('shop')) {
//                $shop_data = Session::get('shop');
//            } else {
//                // Si no existe, inicializarla como un array vacío
//                Session::put('shop', []);
//                $shop_data = [];
//            }
//            // Verificar si $shop_data tiene elementos y actualizar la variable de sesión 'shop'
//            if (count($shop_data) > 0) {
//                Session::put('shop', $shop_data);
//            }
//
////            Visualizacion::activarVisualizacion();
//            return view('welcome');


            if (auth()->check()) {
                return redirect('admin');
            }
            return view('auth/login');

        }catch (\Exception $e){
            echo "<script>
                alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");
                window.location.href = '" . route('inicio.inicio') . "';
            </script>";
        }
    }







}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function login(){
        try{
            if (auth()->check()) {
                return redirect('admin');
            }
            return view('auth/login');
        }catch (\Exception $e){
            echo "<script language=\"javascript\">
                    alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");
                </script>";
//            echo "<script language=\"javascript\">window.location.href= ruta_global + \"". "menu/principal" ."\";</script>";
        }
    }
    public function iniciar_sesion(Request $request){
        try {
            $res = false;
            $credentials = $request->only('username', 'password');
            $remember = $request->filled('remember');
            if (Auth::attempt($credentials, $remember)) {
                $res = true;
            }
            return response(json_encode($res),200)->header('Content-type','text/plain');
        }catch  (\Exception $e){
            return response(json_encode($e),200)->header('Content-type','text/plain');
        }
    }
    public function cerrar_session(){
        Session::flush();
        Auth::logout();
        return redirect('/');
    }
}

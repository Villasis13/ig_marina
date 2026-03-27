<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class Visualizacion extends Model
{
    use HasFactory;
    protected $table = "visualizacion";
    protected $primaryKey = "id_visualizacion";
    public static function activarVisualizacion($id = null){
        $save = DB::table('visualizacion')->insert(['visualizacion_tipo'=>!$id ? 0 : $id,'visualizacion_fecha'=>date('Y-m-d H:i:s')]);
        $result = $save ? 1 : 2;
        return $result;
    }

    public static function listarConteoVistasHome($id = null){
        $datos = DB::table('visualizacion')
            ->where('visualizacion_tipo','=',0)->count();
        return $datos;
    }

    public static function listarConteoVistasproductos($id = null){
        // Obtener la fecha de hace una semana desde hoy
        $fecha_hace_una_semana = Carbon::now()->subWeek();
        $datos = DB::table('visualizacion')
            ->join('producto', 'producto.id_producto', '=', 'visualizacion.visualizacion_tipo')
            ->join('recetas as r','r.id_recetas','=','producto.id_recetas')
            ->select('r.recetas_nombre', 'producto.id_producto', DB::raw('count(*) as count'))
            ->where('visualizacion.visualizacion_fecha', '>=', $fecha_hace_una_semana)
            ->groupBy('r.recetas_nombre', 'producto.id_producto')
            ->get();
        return $datos;
    }

    public static function listarConteosemanas(){
        // Obtén la fecha actual
        $fechaActual = Carbon::now();
        // Inicializa el conteo de cada día a 0
        $conteoPorDia = [
            'Monday' => 0, // Lunes
            'Tuesday' => 0, // Martes
            'Wednesday' => 0, // Miércoles
            'Thursday' => 0, // Jueves
            'Friday' => 0, // Viernes
            'Saturday' => 0, // Sábado
            'Sunday' => 0  // Domingo
        ];

        // Obtén los datos de los últimos 7 días, en el orden correcto
        for ($i = 6; $i >= 0; $i--) {
            $fechaDia = $fechaActual->copy()->subDays($i);
            $nombreDia = $fechaDia->format('l');
            $conteo = DB::table('visualizacion')
                ->whereDate('visualizacion.visualizacion_fecha', '=', $fechaDia->toDateString())
                ->where('visualizacion.visualizacion_tipo', '=', 0)
                ->count();

            $finalData[] = [
                'dia_semana' => $nombreDia,
                'numero_dia' => Carbon::parse($fechaDia)->day,
                'numero_mes' => Carbon::parse($fechaDia)->month,
                'conteo' => $conteo
            ];
        }

        return $finalData;
    }

}

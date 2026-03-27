<?php

namespace App\Console\Commands;

use App\Models\Logs;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class logData extends Command
{
    private $logs;
    public function __construct()
    {
        parent::__construct(); // Llama al constructor de la clase padre

        $this->logs = new Logs(); // Inicializa el objeto Logs
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'log:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup the database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {

            $productos = DB::table('productos as p')
               ->join('tipo_afectacion as ta','ta.id_tipo_afectacion','=','p.id_tipo_afectacion')
               ->where([['p.pro_estado','=',1],['p.pro_precio_uni_ma','=',0]])->get();
            foreach ($productos as $p){
                $pre = $p->pro_precio_uni;
                DB::table('productos')->where('id_pro','=',$p->id_pro)
                    ->update(['pro_precio_uni_ma'=>$pre]);
            }
//           $productos = DB::table('productos as p')
//               ->join('tipo_afectacion as ta','ta.id_tipo_afectacion','=','p.id_tipo_afectacion')
//               ->where('p.pro_estado','=',1)->get();
//
//           foreach ($productos as $p){
//               $precio_u = $p->pro_precio_uni;
//               $precio_m = $p->pro_precio_uni_ma;
//               $precioUNuevo = $precio_u / $p->pro_porcen_igv;
//               $precioUMNuevo = $precio_m / $p->pro_porcen_igv;
//               $precioUNuevo = round($precioUNuevo,2);
//               $precioUMNuevo = round($precioUMNuevo,2);
//               DB::table('productos')
//                   ->where('id_pro','=',$p->id_pro)
//                   ->update([
//                      'pro_precio_valor'=>$precioUNuevo,
//                      'pro_precio_valor_ma'=>$precioUMNuevo,
//                   ]);
//           }

        }catch (\Exception $e) {
            $this->logs->insertarLog($e);
        }
//        $this->info('Database backed up successfully to ' . $path);
    }
}

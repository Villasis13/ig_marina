<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GuiaRemisionDetalle extends Model
{
    use HasFactory;

    protected $table = 'guia_remision_detalle';
    protected $primaryKey = 'id_guia_detalle';

    protected $fillable = [
        'id_guia',
        'guia_remision_detalle_descripcion',
        'guia_remision_detalle_cantidad',
        'guia_remision_peso',
        'guia_remision_detalle_um',
    ];

    public function listar_detalle_x_guia($id_guia)
    {
        try {
            return DB::table('guia_remision_detalle')
                ->where('id_guia', $id_guia)
                ->get();
        } catch (\Exception $e) {
            return collect();
        }
    }
}

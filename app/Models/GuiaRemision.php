<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GuiaRemision extends Model
{
    use HasFactory;

    protected $table = 'guia_remision';
    protected $primaryKey = 'id_guia';

    protected $fillable = [
        'id_empresa', 'id_clientes', 'id_venta', 'id_users',
        'guia_tipo', 'guia_serie', 'guia_correlativo', 'guia_emision', 'guia_fecha_traslado',
        'guia_motivo', 'guia_tipo_trans', 'guia_unidad_medida', 'guia_peso_bruto', 'guia_n_bulto',
        'guia_placa', 'guia_carreta', 'vehiculo_marca', 'guia_certificado_mtc',
        'guia_licencia_conductor', 'guia_conductor_nombre', 'guia_conductor_apellidos',
        'guia_conductor_documento_tipo', 'guia_conductor_numero',
        'guia_tipo_doc_trans', 'guia_num_doc_trans', 'guia_denominacion',
        'guia_denominacion_desti', 'guia_direccion_desti', 'guia_num_doc_desti', 'guia_tipo_doc_desti',
        'guia_direccion_part', 'guia_ubigeo_part', 'guia_direccion_llega', 'guia_ubigeo_llega',
        'guia_observacion',
    ];

    public function listar_guias_pendientes(array $filtros = [])
    {
        try {
            $query = DB::table('guia_remision as gr')
                ->join('clientes as c', 'gr.id_clientes', '=', 'c.id_clientes')
                ->join('empresa as e', 'gr.id_empresa', '=', 'e.id_empresa')
                ->select('gr.*', 'c.cliente_razonsocial', 'c.cliente_nombre', 'c.cliente_numero',
                         'e.empresa_razon_social', 'e.empresa_ruc')
                ->where('gr.guia_estado_sunat', 0);

            if (!empty($filtros['guia_tipo'])) {
                $query->where('gr.guia_tipo', $filtros['guia_tipo']);
            }
            if (!empty($filtros['fecha_inicio']) && !empty($filtros['fecha_final'])) {
                $query->whereBetween(DB::raw('DATE(gr.created_at)'), [$filtros['fecha_inicio'], $filtros['fecha_final']]);
            }

            return $query->orderBy('gr.created_at', 'desc')->get();
        } catch (\Exception $e) {
            return collect();
        }
    }

    public function listar_guias_historial(array $filtros = [])
    {
        try {
            $query = DB::table('guia_remision as gr')
                ->join('clientes as c', 'gr.id_clientes', '=', 'c.id_clientes')
                ->join('empresa as e', 'gr.id_empresa', '=', 'e.id_empresa')
                ->select('gr.*', 'c.cliente_razonsocial', 'c.cliente_nombre', 'c.cliente_numero',
                         'e.empresa_razon_social', 'e.empresa_ruc')
                ->where('gr.guia_estado_sunat', 1);

            if (!empty($filtros['guia_tipo'])) {
                $query->where('gr.guia_tipo', $filtros['guia_tipo']);
            }
            if (!empty($filtros['fecha_inicio']) && !empty($filtros['fecha_final'])) {
                $query->whereBetween(DB::raw('DATE(gr.guia_fecha_envio)'), [$filtros['fecha_inicio'], $filtros['fecha_final']]);
            }

            return $query->orderBy('gr.guia_fecha_envio', 'desc')->get();
        } catch (\Exception $e) {
            return collect();
        }
    }

    public function listar_guia_x_id($id)
    {
        try {
            return DB::table('guia_remision as gr')
                ->join('clientes as c', 'gr.id_clientes', '=', 'c.id_clientes')
                ->join('tipo_documento as td', 'c.id_tipo_documento', '=', 'td.id_tipo_documento')
                ->where('gr.id_guia', $id)
                ->first();
        } catch (\Exception $e) {
            return null;
        }
    }

    public function proximo_correlativo($id_empresa, $guia_tipo)
    {
        try {
            $prefijo = $guia_tipo === '09' ? 'T001' : 'V001';
            $ultimo = DB::table('guia_remision')
                ->where('id_empresa', $id_empresa)
                ->where('guia_tipo', $guia_tipo)
                ->where('guia_serie', $prefijo)
                ->max('guia_correlativo');
            return $ultimo ? intval($ultimo) + 1 : 1;
        } catch (\Exception $e) {
            return 1;
        }
    }
}

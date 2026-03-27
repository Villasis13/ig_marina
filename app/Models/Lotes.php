<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lotes extends Model
{
    protected $table = 'lotes';
    protected $primaryKey = 'id_lote';

    protected $fillable = [
        'id_pro', 'numero_lote', 'fecha_vencimiento',
        'cantidad', 'observaciones', 'estado', 'id_orden_compra',
    ];

    public function producto()
    {
        return $this->belongsTo(Productos::class, 'id_pro');
    }

    /** Lotes disponibles de un producto */
    public static function disponibles(int $idPro)
    {
        return self::where('id_pro', $idPro)
            ->where('estado', 'disponible')
            ->get();
    }

    /** Stock = suma de cantidad disponible en todos los lotes */
    public static function stockDisponible(int $idPro): int
    {
        return (int) self::where('id_pro', $idPro)
            ->where('estado', 'disponible')
            ->sum('cantidad');
    }
}

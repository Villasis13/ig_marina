<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    protected $table    = 'series';
    protected $primaryKey = 'id_serie';

    protected $fillable = [
        'id_pro', 'numero_serie', 'numero_motor',
        'color', 'anio_fabricacion', 'estado',
        'id_orden_compra', 'id_venta', 'observaciones',
    ];

    public function producto()
    {
        return $this->belongsTo(Productos::class, 'id_pro');
    }

    /** Series disponibles de un producto */
    public static function disponibles(int $idPro)
    {
        return self::where('id_pro', $idPro)
            ->where('estado', 'disponible')
            ->get();
    }

    /** Stock = cantidad de series disponibles */
    public static function stockDisponible(int $idPro): int
    {
        return self::where('id_pro', $idPro)
            ->where('estado', 'disponible')
            ->count();
    }
}

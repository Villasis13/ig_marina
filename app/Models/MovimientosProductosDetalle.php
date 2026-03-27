<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimientosProductosDetalle extends Model
{
    use HasFactory;
    protected $table = "movimientos_productos_detalle";
    protected $primaryKey = "id_movimientos_productos_detalle";
}

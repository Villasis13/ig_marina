<?php

namespace App\Exports;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
class OrdenCompraHistorial implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    use Exportable;
//    public $datos;
//    public function __construct($datos)
//    {
//        $this->datos = $datos;
//    }

    public function collection()
    {
        return User::all();
    }
}

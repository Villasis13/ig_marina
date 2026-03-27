<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromQuery;

class ProductsExport implements FromView
{

    public function view(): View
    {

        $invoices = DB::table('users')->where('users_estado','=',1)->get();
        return view('logistica.order_compra_excel',compact('invoices'));
    }
}


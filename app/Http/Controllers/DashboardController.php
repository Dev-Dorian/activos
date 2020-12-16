<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $anio=date('Y');
        $articulos=DB::table('articulos as i')
        ->select(DB::raw('MONTH(i.fcompra) as mes'),
        DB::raw('YEAR(i.fcompra) as anio'),
        DB::raw('SUM(i.costo) as costo'))
        ->whereYear('i.fcompra',$anio)
        ->groupBy(DB::raw('MONTH(i.fcompra)'),DB::raw('YEAR(i.fcompra)'))
        ->get();

        return ['articulos'=>$articulos, 'anio'=>$anio];   
    }
}

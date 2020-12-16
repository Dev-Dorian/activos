<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Depreciacion;

class DepreciacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {       
        if(!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar==''){
            $depreciaciones = Depreciacion::join('articulos','depreciaciones.codigo','=','articulos.codigo')
            ->select('depreciaciones.codigo',            
            'articulos.nombre as nombre_articulo',
            'depreciaciones.fechaDepreciacion',                  
            'articulos.fcompra as fcompra_articulo',
            'articulos.vidaUtil as vidaUtil_articulo',
            'articulos.costo as costo_articulo',
            'depreciaciones.montoDepreciado',
            'depreciaciones.depreciacionAcumulada',
            'depreciaciones.valorLibros')            
            ->orderBy('depreciaciones.codigo','desc')->paginate(10);
        }
        else{
            $depreciaciones = Depreciacion::join('articulos','depreciaciones.codigo','=','articulos.codigo')
            ->select('depreciaciones.codigo',            
            'articulos.nombre as nombre_articulo',
            'depreciaciones.fechaDepreciacion',                    
            'articulos.fcompra as fcompra_articulo',
            'articulos.vidaUtil as vidaUtil_articulo',
            'articulos.costo as costo_articulo',
            'depreciaciones.montoDepreciado',
            'depreciaciones.depreciacionAcumulada',
            'depreciaciones.valorLibros')    
            ->where('articulos.'.$criterio, 'like', '%'. $buscar .'%')
            ->orderBy('depreciaciones.codigo','desc')->paginate(10);        
            //->where($criterio, 'like', '%'. $buscar .'%')
            //->orderBy('depreciaciones.codigo', 'desc')->paginate(10);

           
        }
        

        

        return [
            'pagination' => [
                'total'         => $depreciaciones->total(),
                'current_page'  => $depreciaciones->currentPage(),
                'per_page'      => $depreciaciones->perPage(),
                'last_page'     => $depreciaciones->lastPage(),
                'from'          => $depreciaciones->firstItem(),
                'to'            => $depreciaciones->lastItem(),
            ],
            'depreciaciones' => $depreciaciones
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $depreciacion = new Depreciacion();
        $depreciacion->codigo = $request->codigo;
        $depreciacion->fechaDepreciacion = $request->fechaDepreciacion;
        $depreciacion->montoDepreciado = $request->montoDepreciado;            
        $depreciacion->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Ubicacion;

class UbicacionController extends Controller
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
            $ubicaciones = Ubicacion::orderBy('id','desc')->paginate(5);
        }
        else{
            $ubicaciones = Ubicacion::where($criterio, 'like', '%'. $buscar .'%')->orderBy('id', 'desc')->paginate(5);
        }

        

        return [
            'pagination' => [
                'total'         => $ubicaciones->total(),
                'current_page'  => $ubicaciones->currentPage(),
                'per_page'      => $ubicaciones->perPage(),
                'last_page'     => $ubicaciones->lastPage(),
                'from'          => $ubicaciones->firstItem(),
                'to'            => $ubicaciones->lastItem(),
            ],
            'ubicaciones' => $ubicaciones
        ];
    }

    public function selectUbicacion(Request $request){
        if(!$request->ajax()) return redirect('/');
        $ubicaciones = Ubicacion::where('condicionUbicacion','=','1')
        ->select('id','nombreUbicacion')->orderBy('nombreUbicacion','asc')->get();
        return ['ubicaciones'=>$ubicaciones];

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
        $ubicacion = new Ubicacion();
        $ubicacion->nombreUbicacion = $request->nombreUbicacion;
        $ubicacion->descripcionUbicacion = $request->descripcionUbicacion;
        $ubicacion->condicionUbicacion = '1';
        $ubicacion->idusuario = \Auth::user()->id;
        $ubicacion->save();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        // no creamos un nuevo objeto sino que buscamos la ubicacion registrada
        $ubicacion = Ubicacion::findOrFail($request->id);
        $ubicacion->nombreUbicacion = $request->nombreUbicacion;
        $ubicacion->descripcionUbicacion = $request->descripcionUbicacion;
        $ubicacion->condicionUbicacion = '1';
        $ubicacion->idusuario = \Auth::user()->id;
        $ubicacion->save();
    }

    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        // no creamos un nuevo objeto sino que buscamos la ubicacion registrada
        $ubicacion = Ubicacion::findOrFail($request->id);
        $ubicacion->condicionUbicacion = '0';
        $ubicacion->idusuario = \Auth::user()->id;
        $ubicacion->save();
    }

    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        // no creamos un nuevo objeto sino que buscamos la ubicacion registrada
        $ubicacion = Ubicacion::findOrFail($request->id);
        $ubicacion->condicionUbicacion = '1';
        $ubicacion->idusuario = \Auth::user()->id;
        $ubicacion->save();
    }
}

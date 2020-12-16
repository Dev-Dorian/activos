<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Responsable;

class ResponsableController extends Controller
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
            $responsables = Responsable::orderBy('id','desc')->paginate(5);
        }
        else{
            $responsables = Responsable::where($criterio, 'like', '%'. $buscar .'%')->orderBy('id', 'desc')->paginate(5);
        }

        

        return [
            'pagination' => [
                'total'         => $responsables->total(),
                'current_page'  => $responsables->currentPage(),
                'per_page'      => $responsables->perPage(),
                'last_page'     => $responsables->lastPage(),
                'from'          => $responsables->firstItem(),
                'to'            => $responsables->lastItem(),
            ],
            'responsables' => $responsables
        ];
       
    }

    public function selectResponsable(Request $request){
        if(!$request->ajax()) return redirect('/');
        $responsables = Responsable::where('condicion','=','1')
        ->select('id','nombreResponsable')->orderBy('nombreResponsable','asc')->get();
        return ['responsables'=>$responsables];

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
        $responsable = new Responsable();
        $responsable->nombreResponsable = $request->nombreResponsable;
        $responsable->num_documento = $request->num_documento;
        $responsable->telefonoResponsable = $request->telefonoResponsable;
        $responsable->descripcionResponsable = $request->descripcionResponsable;
        $responsable->condicion = '1';
        $responsable->idusuario = \Auth::user()->id;
        $responsable->save();
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
        // no creamos un nuevo objeto sino que buscamos la Responsable registrada
        $responsable = Responsable::findOrFail($request->id);
        $responsable->nombreResponsable = $request->nombreResponsable;
        $responsable->num_documento = $request->num_documento;
        $responsable->telefonoResponsable = $request->telefonoResponsable;
        $responsable->descripcionResponsable = $request->descripcionResponsable;
        $responsable->condicion = '1';
        $responsable->idusuario = \Auth::user()->id;
        $responsable->save();
    }

    

    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        // no creamos un nuevo objeto sino que buscamos la Responsable registrada
        $responsable = Responsable::findOrFail($request->id);
        $responsable->condicion = '0';
        $responsable->idusuario = \Auth::user()->id;
        $responsable->save();
    }

    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        // no creamos un nuevo objeto sino que buscamos la Responsable registrada
        $responsable = Responsable::findOrFail($request->id);
        $responsable->condicion = '1';
        $responsable->idusuario = \Auth::user()->id;
        $responsable->save();
    }

}

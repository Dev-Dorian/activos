<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Articulo;
use App\Categoria;
use App\Ubicacion;
use App\Responsable;
use App\User;
use App\Depreciacion;
use Illuminate\Support\Facades\DB;


class reportesGeneralesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    public function listarPdf(){
        $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
        ->join('ubicaciones','articulos.idubicacion','=','ubicaciones.id')    
        ->join('responsables','articulos.idresponsable','=','responsables.id')               
        ->select('articulos.id','articulos.idcategoria','articulos.idubicacion',
        'articulos.idresponsable',
        'articulos.codigo','articulos.nombre',
        'categorias.nombre as nombre_categoria','ubicaciones.nombreUbicacion as nombre_ubicacion',
        //'responsables.nombre as nombre_responsable',
        'articulos.costo','articulos.vresidual','articulos.fcompra','articulos.vidaUtil','articulos.fechaSalida',
        'articulos.descripcion','articulos.imagen','articulos.condicion')
        ->orderBy('articulos.id','desc')->get();

        $cont=Articulo::count();

        $pdf = \PDF::loadView('pdf.articulospdf',['articulos'=>$articulos,'cont'=>$cont])->setPaper('a4', 'portrait');
        return $pdf->download('articulos.pdf');
    }

    public function listarPdf1(){
        $categorias = Categoria::join('users','categorias.idusuario','=','users.id')             
        ->select('categorias.id','categorias.idusuario','categorias.nombre',
        'categorias.descripcion','categorias.created_at','categorias.updated_at',
        'categorias.condicion','users.nombre as nombre_users'
    )->orderBy('categorias.id','desc')->get();

        $cont=Categoria::count();

        $pdf = \PDF::loadView('pdf.categoriaspdf',['categorias'=>$categorias,'cont'=>$cont])->setPaper('a4', 'portrait');
        return $pdf->download('categorias.pdf');
        //return $pdf->stream();
    }

    public function listarPdf2(){
        $ubicaciones = Ubicacion::join('users','ubicaciones.idusuario','=','users.id')             
        ->select('ubicaciones.id','ubicaciones.idusuario','ubicaciones.nombreUbicacion',
        'ubicaciones.descripcionUbicacion',
        'ubicaciones.condicionUbicacion','ubicaciones.created_at','ubicaciones.updated_at',
        'users.nombre as nombre_users'
    )->orderBy('ubicaciones.id','desc')->get();

        $cont=Ubicacion::count();

        $pdf = \PDF::loadView('pdf.ubicacionespdf',['ubicaciones'=>$ubicaciones,'cont'=>$cont])->setPaper('a4', 'portrait');
        return $pdf->download('ubicaciones.pdf');
    }

    public function listarPdf3(){
        $responsables = Responsable::join('users','responsables.idusuario','=','users.id')             
        ->select('responsables.id','responsables.idusuario','responsables.nombreResponsable',
        'responsables.num_documento','responsables.telefonoResponsable','responsables.descripcionResponsable',
        'responsables.condicion','responsables.created_at','responsables.updated_at',
        'users.nombre as nombre_users'
    )->orderBy('responsables.id','desc')->get();

        $cont=Responsable::count();

        $pdf = \PDF::loadView('pdf.responsablespdf',['responsables'=>$responsables,'cont'=>$cont])->setPaper('a4', 'portrait');
        return $pdf->download('responsables.pdf');
    }

    public function listarPdf4(){
        $users = User::
        //join('users','users.idusuario','=','users.id')             
        //->
        join('roles','users.idrol','=','roles.id')             
        ->select('users.id',
       // 'users.idusuario',
        'users.nombre',
        //'users.tipo_documento',
        //'users.num_documento',
        //'users.direccion',
        //'users.telefono',
        'users.email',
        'users.usuario',
        'users.password',
        'users.condicion',
        'users.idrol',
        'roles.nombre as nombre_rol',

        'users.remember_token',     
        'users.created_at',
        'users.updated_at'
    )->orderBy('users.id','desc')->get();

        $cont=User::count();

        $pdf = \PDF::loadView('pdf.userspdf',['users'=>$users,'cont'=>$cont])->setPaper('a4', 'portrait');
        return $pdf->download('usuarios.pdf');
    }

    public function listarPdf5(){

        $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')          
        ->select('categorias.nombre',DB::raw('SUM(articulos.costo) as costo'))
        ->groupBy('categorias.id','categorias.nombre')
        ->orderBy('articulos.id','desc')->get();

        $cont=Articulo::count();
            
        //$categorias = Categoria::select('categorias.id','categorias.nombre')        
        //->orderBy('categorias.id','asc')->get();

        //$cont=Categoria::count();

        //$pdf = \PDF::loadView('pdf.chart',['articulos'=>$articulos,'cont'=>$cont])->setPaper('a4', 'portrait');
        //$pdf->setOptions('enable-javascript', true); 
        //$pdf->setOptions('javascript-delay', 1000); 
        //$pdf->setOptions('no-stop-slow-scripts', true); 
        //$pdf->setOptions('enable-smart-shrinking', true); 
        //return $pdf->stream();
        return view('pdf.chart',['articulos'=>$articulos]);
        

        

        //$pdf = \PDF::loadView('pdf.chart',['categorias'=>$categorias]);
        //return $pdf->download('chart.pdf');

    }
    public function listarPdf6(){
        $depreciaciones = Depreciacion::join('articulos','depreciaciones.codigo','=','articulos.codigo')             
        ->select('depreciaciones.id','depreciaciones.codigo','depreciaciones.fechaDepreciacion',
        'depreciaciones.montoDepreciado',
        'depreciaciones.depreciacionAcumulada','depreciaciones.valorLibros',        
        'articulos.nombre as nombre_articulo')
        ->orderBy('depreciaciones.id','desc')->get();

        $cont=Depreciacion::count();

        $pdf = \PDF::loadView('pdf.depreciacionespdf',['depreciaciones'=>$depreciaciones,'cont'=>$cont])->setPaper('a4', 'portrait');
        return $pdf->download('depreciaciones.pdf');
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

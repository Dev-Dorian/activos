<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Auditoria;
use App\Auditoria1;
use App\Auditoria2;
use App\Auditoria3;
use App\Auditoria4;

class AuditoriaController extends Controller
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
    public function listarPdf(){
        $categorias_auditoria = Auditoria::join('users','categorias_auditoria.usuario','=','users.id')             
        ->select('categorias_auditoria.id','categorias_auditoria.usuario','categorias_auditoria.nombre',
        'categorias_auditoria.descripcion','categorias_auditoria.created','categorias_auditoria.modified',
        'categorias_auditoria.condicion','users.nombre as nombre_users','categorias_auditoria.accion'
    )->orderBy('categorias_auditoria.id','desc')->get();

        $cont=Auditoria::count();

        $pdf = \PDF::loadView('pdf.audicategoriaspdf',['categorias_auditoria'=>$categorias_auditoria,'cont'=>$cont])->setPaper('a4', 'portrait');
        return $pdf->download('categorias_auditoria.pdf');
    }

    public function listarPdf1(){
        $responsables_auditoria = Auditoria1::join('users','responsables_auditoria.idusuario','=','users.id')             
        ->select('responsables_auditoria.id','responsables_auditoria.idusuario','responsables_auditoria.nombreResponsable',
        'responsables_auditoria.num_documento','responsables_auditoria.telefonoResponsable','responsables_auditoria.descripcionResponsable',
        'responsables_auditoria.condicion','responsables_auditoria.created_at','responsables_auditoria.updated_at',
        'users.nombre as nombre_users','responsables_auditoria.accion'
    )->orderBy('responsables_auditoria.id','desc')->get();

        $cont=Auditoria1::count();

        $pdf = \PDF::loadView('pdf.audiresponsablespdf',['responsables_auditoria'=>$responsables_auditoria,'cont'=>$cont])->setPaper('a4', 'portrait');
        return $pdf->download('responsables_auditoria.pdf');
    }

    public function listarPdf2(){
        $ubicaciones_auditoria = Auditoria2::join('users','ubicaciones_auditoria.idusuario','=','users.id')             
        ->select('ubicaciones_auditoria.id','ubicaciones_auditoria.idusuario','ubicaciones_auditoria.nombreUbicacion',
        'ubicaciones_auditoria.descripcionUbicacion',
        'ubicaciones_auditoria.condicionUbicacion','ubicaciones_auditoria.created_at','ubicaciones_auditoria.updated_at',
        'users.nombre as nombre_users','ubicaciones_auditoria.accion'
    )->orderBy('ubicaciones_auditoria.id','desc')->get();

        $cont=Auditoria2::count();

        $pdf = \PDF::loadView('pdf.audiubicacionespdf',['ubicaciones_auditoria'=>$ubicaciones_auditoria,'cont'=>$cont])->setPaper('a4', 'portrait');
        return $pdf->download('ubicaciones_auditoria.pdf');
    }

    public function listarPdf3(){
        $articulos_auditoria = Auditoria3::join('users','articulos_auditoria.idusuario','=','users.id')  
        ->join('categorias','articulos_auditoria.idcategoria','=','categorias.id')
        ->join('ubicaciones','articulos_auditoria.idubicacion','=','ubicaciones.id')    
        ->join('responsables','articulos_auditoria.idresponsable','=','responsables.id')            
        ->select('articulos_auditoria.id','articulos_auditoria.idusuario',
        'articulos_auditoria.codigo',
        'articulos_auditoria.nombre',
        'articulos_auditoria.costo',
        'articulos_auditoria.vresidual',
        'articulos_auditoria.fcompra',
        'articulos_auditoria.vidaUtil',
        'articulos_auditoria.fechaSalida',
        'articulos_auditoria.descripcion',
        'articulos_auditoria.imagen',
        'articulos_auditoria.condicion',
        'articulos_auditoria.created_at',
        'articulos_auditoria.updated_at',
        'articulos_auditoria.accion',

        'articulos_auditoria.idcategoria',
        'articulos_auditoria.idubicacion',
        'articulos_auditoria.idresponsable',

        'categorias.nombre as nombre_categoria',
        'ubicaciones.nombreUbicacion as nombre_ubicacion',
        'responsables.nombreResponsable as nombre_responsable',


        'users.nombre as nombre_users'
    )->orderBy('articulos_auditoria.id','desc')->get();

        $cont=Auditoria3::count();

        $pdf = \PDF::loadView('pdf.audiarticulospdf',['articulos_auditoria'=>$articulos_auditoria,'cont'=>$cont])->setPaper('a4', 'portrait');
        return $pdf->download('articulos_auditoria.pdf');
    }

    public function listarPdf4(){
        $users_auditoria = Auditoria4::
        //join('users','users_auditoria.idusuario','=','users.id')             
        //->
        join('roles','users_auditoria.idrol','=','roles.id')             
        ->select('users_auditoria.id',
       // 'users_auditoria.idusuario',
        'users_auditoria.nombre',
        //'users_auditoria.tipo_documento',
        //'users_auditoria.num_documento',
        //'users_auditoria.direccion',
        //'users_auditoria.telefono',
        'users_auditoria.email',
        'users_auditoria.usuario',
        'users_auditoria.password',
        'users_auditoria.condicion',
        'users_auditoria.idrol',
        'roles.nombre as nombre_rol',

        'users_auditoria.remember_token',     
        'users_auditoria.created_at',
        'users_auditoria.updated_at',

        'users_auditoria.accion'
    )->orderBy('users_auditoria.id','desc')->get();

        $cont=Auditoria4::count();

        $pdf = \PDF::loadView('pdf.audiuserspdf',['users_auditoria'=>$users_auditoria,'cont'=>$cont])->setPaper('a4', 'portrait');
        return $pdf->download('users_auditoria.pdf');
    }

    public function store(Request $request)
    {
        //
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use App\Articulo;

class ArticuloController extends Controller
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
            ->orderBy('articulos.id','desc')->paginate(5);
        }
        else{
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
            ->where('articulos.'.$criterio, 'like', '%'. $buscar .'%')
            ->orderBy('articulos.id','desc')->paginate(5);

            //$articulos = Categoria::where($criterio, 'like', '%'. $buscar .'%')->orderBy('id', 'desc')->paginate(3);
        }

        

        return [
            'pagination' => [
                'total'         => $articulos->total(),
                'current_page'  => $articulos->currentPage(),
                'per_page'      => $articulos->perPage(),
                'last_page'     => $articulos->lastPage(),
                'from'          => $articulos->firstItem(),
                'to'            => $articulos->lastItem(),
            ],
            'articulos' => $articulos
        ];
       
    }

    public function listarPdf(){
        $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
        ->join('ubicaciones','articulos.idubicacion','=','ubicaciones.id')    
        ->join('responsables','articulos.idresponsable','=','responsables.id')               
        ->select('articulos.id','articulos.idcategoria','articulos.idubicacion',
        'articulos.idresponsable',
        'articulos.codigo','articulos.nombre',
        'categorias.nombre as nombre_categoria','ubicaciones.nombreUbicacion as nombre_ubicacion',
        //'responsables.nombreResponsable as nombre_responsable',
        'articulos.costo','articulos.vresidual','articulos.fcompra','articulos.vidaUtil','articulos.fechaSalida',
        'articulos.descripcion','articulos.imagen','articulos.condicion')
        ->orderBy('articulos.id','desc')->get();

        $cont=Articulo::count();

        $pdf = \PDF::loadView('pdf.articulospdf',['articulos'=>$articulos,'cont'=>$cont])->setPaper('a4', 'portrait');
        return $pdf->download('articulos.pdf');
    }

    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $articulo = new Articulo();
        $articulo->idcategoria = $request->idcategoria;
        $articulo->idubicacion = $request->idubicacion;
        $articulo->idresponsable = $request->idresponsable;
        $articulo->codigo = $request->codigo;
        $articulo->nombre = $request->nombre;
        $articulo->costo = $request->costo;
        $articulo->vresidual = $request->vresidual;
        $articulo->fcompra = $request->fcompra;
        $articulo->vidaUtil = $request->vidaUtil;
        $articulo->fechaSalida = $request->fechaSalida;
        $articulo->descripcion = $request->descripcion;
        $articulo->condicion = $request->condicion;
        $articulo->imagen = $request->imagen;        
        $articulo->idusuario = \Auth::user()->id;

                    //inicio registrar imagen
                    $exploded = explode(',',$request->imagen);
                    $decoded = base64_decode($exploded[1]);
            
                    if(str_contains($exploded[0],'jpeg')){
            
                        $extension = 'jpg';
            
                    } else{
            
                        $extension = 'png'; 
                    }
            
                    $fileName= str_random().'.'.$extension;
                    
                    $path = public_path().'/img/articulo/'.$fileName;
            
                    file_put_contents($path,$decoded);
            
                    $articulo->imagen = $fileName;
            
                    //fin registrar imagen

        $articulo->save();
    }

    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        // no creamos un nuevo objeto sino que buscamos la categoria registrada
        $articulo = Articulo::findOrFail($request->id);
        $articulo->idcategoria = $request->idcategoria;
        $articulo->idubicacion = $request->idubicacion;
        $articulo->idresponsable = $request->idresponsable;
        $articulo->codigo = $request->codigo;
        $articulo->nombre = $request->nombre;
        $articulo->costo = $request->costo;
        $articulo->vresidual = $request->vresidual;
        $articulo->fcompra = $request->fcompra;
        $articulo->vidaUtil = $request->vidaUtil;
        $articulo->fechaSalida = $request->fechaSalida;
        $articulo->descripcion = $request->descripcion;
        $articulo->condicion = $request->condicion;
        $articulo->imagen = $request->imagen;        
        $articulo->idusuario = \Auth::user()->id;

        //Editar imagen

        $currentPhoto = $articulo->imagen; 

        if($request->imagen != $currentPhoto){

            $exploded = explode(',',$request->imagen);
            $decoded = base64_decode($exploded[1]);
    
            if(str_contains($exploded[0],'jpeg')){
    
                $extension = 'jpg';
    
            } else{
    
                $extension = 'png'; 
            }
    
            $fileName= str_random().'.'.$extension;
            
            $path = public_path().'/img/articulo/'.$fileName;
    
            file_put_contents($path,$decoded);

            /*inicio eliminar del servidor*/
            $articuloImagen = public_path('/img/articulo/').$currentPhoto;
            if(file_exists($articuloImagen)){
                @unlink($articuloImagen);
            }

            /*fin eliminar del servidor*/
    
            $articulo->imagen = $fileName;

    }
    //fin editar imagen

        $articulo->save();
    }

    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        // no creamos un nuevo objeto sino que buscamos la categoria registrada
        $articulo = Articulo::findOrFail($request->id);
        $articulo->condicion = '0';
        $articulo->idusuario = \Auth::user()->id;
        $articulo->save();
    }

    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        // no creamos un nuevo objeto sino que buscamos la categoria registrada
        $articulo = Articulo::findOrFail($request->id);
        $articulo->condicion = '1';
        $articulo->idusuario = \Auth::user()->id;
        $articulo->save();
    }

    
}

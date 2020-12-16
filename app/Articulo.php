<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    protected $table = 'articulos';

    protected $fillable = [
        'idcategoria','idubicacion','idresponsable','codigo','nombre','costo','vresidual',
        'fcompra','vidaUtil','fechaSalida','descripcion','imagen','condicion','idusuario'
    ];
    public function categoria(){
        return $this->belongsTo('App\Categoria');
    
    }
    public function ubicacion(){
        return $this->belongsTo('App\Ubicacion');
    
    }
    public function responsable(){
        return $this->belongsTo('App\Responsable');
    
    }
    public function usuario()
    {
        return $this->belongsTo('App\User');
    }

    
}

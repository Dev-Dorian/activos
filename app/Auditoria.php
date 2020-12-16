<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Auditoria extends Model
{
    protected $table = 'categorias_auditoria';
    

    protected $fillable = ['nombre','descripcion','condicion','idusuario'];

    public function articulos(){
        return $this->hasMany('App\Articulo');
    }
    public function usuario()
    {
        return $this->belongsTo('App\User');
    }
}

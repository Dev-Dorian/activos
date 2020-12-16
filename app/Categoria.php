<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    // Laravel ya sobre entiende la table de categoria con base a la clase categoria
    protected $table = 'categorias';
    // laravel ya reconoce cual es su primery key por lo tanto no hace falta ponerla
    //protected $primaryKey = 'id';
    protected $fillable = ['nombre','descripcion','condicion','idusuario'];

    //Indica que varias categorias puede pertener a un articulo, un articulo solo a una categoria
    public function articulos(){
        return $this->hasMany('App\Articulo');
    }
    public function usuario()
    {
        return $this->belongsTo('App\User');
    }
}

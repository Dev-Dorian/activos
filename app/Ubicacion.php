<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    // Laravel ya sobre entiende la table de ubicacion con base a la clase ubicacion
    protected $table = 'ubicaciones';
    // laravel ya reconoce cual es su primery key por lo tanto no hace falta ponerla
    //protected $primaryKey = 'id';
    protected $fillable = ['nombreUbicacion','descripcionUbicacion','condicionUbicacion','idusuario'];

    //Indica que varias ubicaciones puede pertener a un articulo, un articulo solo a una ubicacion
    public function articulos(){
       return $this->hasMany('App\Articulo');
    }
    public function usuario()
    {
        return $this->belongsTo('App\User');
    }
}

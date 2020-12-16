<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Responsable extends Model
{
        // Laravel ya sobre entiende la table de responsables con base a la clase responsable
        protected $table = 'responsables';
        // laravel ya reconoce cual es su primery key por lo tanto no hace falta ponerla
        //protected $primaryKey = 'id';
        protected $fillable = ['nombreResponsable','num_documento','telefonoResponsable','descripcionResponsable','condicion','idusuario'];
    
        //Indica que varias responsables puede pertener a un articulo, un articulo solo a una responsable
        public function articulos(){
            return $this->hasMany('App\Articulo');
        }
        public function usuario()
        {
            return $this->belongsTo('App\User');
        }
}

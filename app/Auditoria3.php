<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Auditoria3 extends Model
{
    protected $table = 'articulos_auditoria';

    public function usuario()
    {
        return $this->belongsTo('App\User');
    }
    public function categoria(){
        return $this->belongsTo('App\Categoria');
    
    }
    public function ubicacion(){
        return $this->belongsTo('App\Ubicacion');
    
    }
    public function responsable(){
        return $this->belongsTo('App\Responsable');
    
    }
}

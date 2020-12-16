<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Depreciacion extends Model
{
    protected $table = 'depreciaciones';

    protected $fillable = [
        'codigo','fechaDepreciacion','montoDepreciado','depreciacionAcumulada','valorLibros'
    ];

    public function articulo(){
        return $this->belongsTo('App\Articulo');
    
    }
}

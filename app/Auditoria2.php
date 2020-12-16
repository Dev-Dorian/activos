<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Auditoria2 extends Model
{
    protected $table = 'ubicaciones_auditoria';

    public function usuario()
    {
        return $this->belongsTo('App\User');
    }
}

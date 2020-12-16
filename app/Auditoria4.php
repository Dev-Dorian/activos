<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Auditoria4 extends Model
{
    protected $table = 'users_auditoria';

    public function usuario()
    {
        return $this->belongsTo('App\User');
    }

    public function rol()
    {
        return $this->belongsTo('App\Rol');
    }
}

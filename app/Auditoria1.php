<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Auditoria1 extends Model
{
    protected $table = 'responsables_auditoria';

    public function usuario()
    {
        return $this->belongsTo('App\User');
    }
}

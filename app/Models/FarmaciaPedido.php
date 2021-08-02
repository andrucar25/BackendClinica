<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FarmaciaPedido extends Model
{
    protected $table = 'farmaciapedido';
    protected $primaryKey = 'idFarmaciaPedido';
    public $timestamps = false;

    public function teleconsulta()
    {
        return $this->belongsTo('App\Models\Teleconsulta', 'idTeleconsulta');
    }
}

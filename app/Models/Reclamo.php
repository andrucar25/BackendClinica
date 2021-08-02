<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reclamo extends Model
{
    protected $table = 'reclamo';
    protected $primaryKey = 'idReclamo';
    public $timestamps = false;

    public function paciente()
    {
        return $this->belongsTo('App\Models\Paciente', 'idPaciente');
    }
}

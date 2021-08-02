<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laboratorio extends Model
{
    protected $table = 'laboratorio';
    protected $primaryKey = 'idLaboratorio';
    public $timestamps = false;

    public function paciente()
    {
        return $this->belongsTo('App\Models\Paciente', 'idPaciente');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teleconsulta extends Model
{
    protected $table = 'teleconsulta';
    protected $primaryKey = 'idTeleconsulta';
    public $timestamps = false;

    public function archivosTeleconsultas()
    {
        return $this->hasMany('App\Models\ArchivoTeleconsulta', 'idTeleconsulta');
    }

    public function farmaciaPedido()
    {
        return $this->hasOne('App\Models\FarmaciaPedido', 'idTeleconsulta');
    }

    public function medico()
    {
        return $this->belongsTo('App\Models\Medico', 'idMedico');
    }

    public function paciente()
    {
        return $this->belongsTo('App\Models\Paciente', 'idPaciente');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchivoTeleconsulta extends Model
{
    protected $table = 'archivoteleconsulta';
    protected $primaryKey = 'idArchivoTeleconsulta';
    public $timestamps = false;

    public function teleconsulta()
    {
        return $this->belongsTo('App\Models\Teleconsulta', 'idTeleconsulta');
    }
}

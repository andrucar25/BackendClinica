<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $table = 'comentario';
    protected $primaryKey = 'idComentario';
    public $timestamps = false;

    public function medico()
    {
        return $this->belongsTo('App\Models\Medico', 'idMedico');
    }

    public function paciente()
    {
        return $this->belongsTo('App\Models\Paciente', 'idPaciente');
    }
}

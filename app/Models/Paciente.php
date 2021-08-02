<?php

namespace App\Models;


use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Paciente extends Model
{
    use Authenticatable;
    protected $table = 'paciente';
    protected $primaryKey = 'idPaciente';
    public $timestamps = false;

    public function teleconsultas()
    {
        return $this->hasMany('App\Models\Teleconsulta', 'idTeleconsulta');
    }

    public function laboratoriosCita()
    {
        return $this->hasMany('App\Models\Laboratorio', 'idLaboratorioCita');
    }

    public function chatsMedico()
    {
        return $this->hasMany('App\Models\ChatMedico', 'idChatMedico');
    }

    public function comentarios()
    {
        return $this->hasMany('App\Models\Comentario', 'idComentario');
    }

    public function reclamos()
    {
        return $this->hasMany('App\Models\Reclamo', 'idReclamo');
    }

}
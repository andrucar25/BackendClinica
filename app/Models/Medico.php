<?php

namespace App\Models;


use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Medico extends Model
{
    use Authenticatable;
    protected $table = 'medico';
    protected $primaryKey = 'idMedico';
    public $timestamps = false;

    public function teleconsultas()
    {
        return $this->hasMany('App\Models\Teleconsulta', 'idTeleconsulta');
    }

    public function horariosMedico()
    {
        return $this->hasMany('App\Models\HorarioMedico', 'idHorarioMedico');
    }

    public function chatsMedico()
    {
        return $this->hasMany('App\Models\ChatMedico', 'idChatMedico');
    }

    public function comentarios()
    {
        return $this->hasMany('App\Models\Comentario', 'idComentario');
    }

    public function especialidad()
    {
        return $this->belongsTo('App\Models\Especialidad', 'idEspecialidad');
    }

}
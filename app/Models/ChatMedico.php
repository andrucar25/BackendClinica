<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMedico extends Model
{
    protected $table = 'chatmedico';
    protected $primaryKey = 'idChatMedico';
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

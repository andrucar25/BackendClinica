<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HorarioMedico extends Model
{
    protected $table = 'horariomedico';
    protected $primaryKey = 'idHorarioMedico';
    public $timestamps = false;

    
    public function medico()
    {
        return $this->belongsTo('App\Models\Medico', 'idMedico');
    }
}

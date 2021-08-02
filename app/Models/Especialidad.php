<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    protected $table = 'especialidad';
    protected $primaryKey = 'idEspecialidad';
    public $timestamps = false;


    public function medico()
    {
        return $this->hasOne('App\Models\Medico', 'idEspecialidad');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EquipoMedico extends Model
{
    protected $primaryKey = 'ID_EQUIPO_MEDICO';
    public $timestamps = false;
    protected $table = 'equipo_medico';
}

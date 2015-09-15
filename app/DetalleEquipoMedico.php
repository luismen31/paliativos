<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleEquipoMedico extends Model
{
    protected $primaryKey = 'ID_EQUIPO_MEDICO';
    public $timestamps = false;
    protected $table = 'detalle_equipo_medico';
}

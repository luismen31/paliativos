<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DatoProfesionalSalud extends Model
{
    protected $primaryKey = 'ID_PROFESIONAL';
    public $timestamps = false;
    protected $table = 'datos_profesionales_salud';
}

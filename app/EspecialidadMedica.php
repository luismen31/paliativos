<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EspecialidadMedica extends Model
{
    protected $primaryKey = 'ID_ESPECIALIDAD_MEDICA';
    public $timestamps = false;
    protected $table = 'especialidades_medicas';
}

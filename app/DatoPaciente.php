<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DatoPaciente extends Model
{
	protected $primaryKey = 'ID_PACIENTE';
	public $timestamps = false;
    protected $table = 'datos_pacientes';
}

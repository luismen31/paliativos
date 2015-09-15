<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AtencionPaciente extends Model
{
	protected $primaryKey = 'ID_ATENCION';
	public $timestamps = false;
    protected $table = 'atencion_paciente';
}

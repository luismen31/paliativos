<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicioMedico extends Model
{
	protected $primaryKey = 'ID_SERVICIO';   
    public $timestamps = false;
    protected $table = 'servicios_medicos';
}

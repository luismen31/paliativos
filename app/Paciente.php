<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
	protected $primaryKey = 'ID_PACIENTE';
    public $timestamps = false;
    protected $table = 'pacientes';    
}

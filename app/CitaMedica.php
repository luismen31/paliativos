<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CitaMedica extends Model
{
	protected $primaryKey = 'ID_CITA';
	public $timestamps = false;
    protected $table = 'citas_medicas';
}

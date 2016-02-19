<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleDiagnosticoAdmision extends Model
{
	protected $primaryKey = 'SECUENCIA';
	public $timestamps = false;
    protected $table = 'detalle_diagnostico_admision';
}

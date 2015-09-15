<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleDiagnosticoAdmision extends Model
{
	protected $primaryKey = 'ID_DIAGNOSTICO_ADMISION';
	public $timestamps = false;
    protected $table = 'detalle_diagnostico_admision';
}

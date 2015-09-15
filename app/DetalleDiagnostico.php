<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleDiagnostico extends Model
{
    protected $primaryKey = 'ID_DIAGNOSTICO';
    public $timestamps = false;
    protected $table = 'detalle_diagnostico';
}

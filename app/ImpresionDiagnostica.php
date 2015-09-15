<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImpresionDiagnostica extends Model
{
    protected $primaryKey = 'ID_IMPRESION_DIAGNOSTICA';
    public $timestamps = false;
    protected $table = 'impresion_diagnostica';
}

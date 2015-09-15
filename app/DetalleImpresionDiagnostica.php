<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleImpresionDiagnostica extends Model
{
    protected $primaryKey = 'ID_DETALLE_IMPRESION_DIAGNOSTICA';
    public $timestamps = false;
    protected $table = 'detalle_impresion_diagnostica';
}

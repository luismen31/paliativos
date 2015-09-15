<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleRegistroVisitaDomiciliaria extends Model
{
    protected $primaryKey = 'ID_RVD';
    public $timestamps = false;
    protected $table = 'detalle_registro_visitas_domiciliarias';
}

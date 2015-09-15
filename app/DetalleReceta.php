<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleReceta extends Model
{
    protected $primaryKey = 'ID_DETALLE_RECETA';
    public $timestamps = false;
    protected $table = 'detalle_receta';
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleRda extends Model
{
    protected $primaryKey = 'ID_RDA';
    public $timestamps = false;
    protected $table = 'detalle_rda';
}

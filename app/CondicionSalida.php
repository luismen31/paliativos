<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CondicionSalida extends Model
{
    protected $primaryKey = 'ID_CONDICION_SALIDA';
    public $timestamps = false;
    protected $table = 'condicion_salida';
}

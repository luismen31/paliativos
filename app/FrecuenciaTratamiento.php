<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FrecuenciaTratamiento extends Model
{
    protected $primaryKey = 'ID_FRECUENCIA_TRATAMIENTO';
    public $timestamps = false;
    protected $table = 'frecuencias_tratamientos';
}

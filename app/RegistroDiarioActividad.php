<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistroDiarioActividad extends Model
{
    public $timestamps = false;
  	protected $primaryKey = 'ID_RDA';
    protected $table = 'registro_diario_actividades';
}

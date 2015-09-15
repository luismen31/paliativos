<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CuidadoTratamiento extends Model
{
    protected $primaryKey = 'ID_CUIDADOS_TRATAMIENTOS';
    public $timestamps = false;
    protected $table = 'cuidados_tratamientos';
}

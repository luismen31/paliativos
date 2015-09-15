<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoPaciente extends Model
{
    protected $primaryKey = 'ID_ESTADO_PACIENTE';
    public $timestamps = false;
    protected $table = 'estados_civiles';
}

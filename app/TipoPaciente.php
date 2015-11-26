<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoPaciente extends Model
{
    protected $primaryKey = 'ID_TIPO_PACIENTE'; 
    public $timestamps = false;
    protected $table = 'tipo_paciente';
}

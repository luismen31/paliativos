<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoriaPaciente extends Model
{
    protected $primaryKey = 'ID_HISTORIA_PACIENTE';
    public $timestamps = false;
    protected $table = 'historia_paciente';
}

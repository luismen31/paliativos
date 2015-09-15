<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfesionalSalud extends Model
{
    protected $primaryKey = 'ID_PROFESIONAL';
    public $timestamps = false;
    protected $table = 'profesionales_salud';
}

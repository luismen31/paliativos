<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResidenciaHabitual extends Model
{
    protected $primaryKey = 'ID_RESIDENCIA_HABITUAL';
    public $timestamps = false;
    protected $table = 'residencia_habitual';
}

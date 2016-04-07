<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PeriodoTratamiento extends Model
{
    public $timestamps = false;
    protected $table = 'periodo_tratamiento';
    protected $primaryKey = 'ID_PERIODO';
}

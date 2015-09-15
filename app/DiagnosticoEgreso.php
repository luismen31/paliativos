<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiagnosticoEgreso extends Model
{
    protected $primaryKey = 'ID_DIAGNOSTICO_EGRESO';
    public $timestamps = false;
    protected $table = 'diagnostico_egreso';
}

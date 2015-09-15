<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiagnosticoAdmision extends Model
{
    protected $primaryKey = 'ID_DIAGNOSTICO_ADMISION';
    public $timestamps = false;
    protected $table = 'diagnostico_admision';
}

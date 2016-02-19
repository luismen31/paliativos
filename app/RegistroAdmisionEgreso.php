<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistroAdmisionEgreso extends Model
{
    public $timestamps = false;
    protected $table = 'registro_admision_egreso';
    protected $primaryKey = 'ID_REGISTRO_ADMISION_EGRESO';
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreferenciaRecuperacionAcceso extends Model
{
    protected $primaryKey = 'ID_USUARIO';
    public $timestamps = false;
    protected $table = 'preferencias_recuperacion_acceso';
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SesionUsuario extends Model
{
    public $timestamps = false;
    protected $table = 'sesiones_usuarios';
    protected $primaryKey = 'ID_SESION';
}

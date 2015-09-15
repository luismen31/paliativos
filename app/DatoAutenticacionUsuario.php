<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DatoAutenticacionUsuario extends Model
{
    protected $primaryKey = 'ID_USUARIO';
    public $timestamps = false;
    protected $table = 'datos_autenticacion_usuario';
}

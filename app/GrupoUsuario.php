<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrupoUsuario extends Model
{
    protected $primaryKey = 'ID_GRUPO_USUARIO';
    public $timestamps = false;
    protected $table = 'grupos_usuarios';
}

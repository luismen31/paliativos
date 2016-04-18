<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreguntaSeguridad extends Model
{
    public $timestamps = false;
    protected $table = 'preguntas_seguridad';
    protected $primaryKey = 'ID_PREGUNTA';
}

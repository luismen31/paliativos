<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoExamen extends Model
{
    public $timestamps = false;
    protected $table = 'tipo_examen';
    protected $primaryKey = 'ID_TIPO_EXAMEN';
}

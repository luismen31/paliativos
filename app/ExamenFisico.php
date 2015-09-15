<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamenFisico extends Model
{
    protected $primaryKey = 'ID_EXAMEN_FISICO';
    public $timestamps = false;
    protected $table = 'examen_fisico';
}

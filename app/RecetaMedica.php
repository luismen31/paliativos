<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecetaMedica extends Model
{
    public $timestamps = false;
    protected $table = 'recetas_medicas';
    protected $primaryKey = 'ID_RECETA';
}

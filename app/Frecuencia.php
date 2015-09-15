<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Frecuencia extends Model
{
    protected $primaryKey = 'ID_FRECUENCIA';
    public $timestamps = false;
    protected $table = 'frecuencia';
}

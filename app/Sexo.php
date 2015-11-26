<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sexo extends Model
{
    protected $primaryKey = 'ID_SEXO';
    public $timestamps = false;
    protected $table = 'sexo';
}

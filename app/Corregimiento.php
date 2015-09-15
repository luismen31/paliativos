<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Corregimiento extends Model
{
    protected $primaryKey = 'ID_CORREGIMIENTO';
    public $timestamps = false;
    protected $table = 'corregimientos';
}

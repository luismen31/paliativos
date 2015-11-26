<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Referido extends Model
{
    protected $primaryKey = 'ID_REFERIDO';
    public $timestamps = false;
    protected $table = 'referido';
}

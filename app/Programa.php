<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Programa extends Model
{
    protected $primaryKey = 'ID_PROGRAMA';
    public $timestamps = false;
    protected $table = 'programa';
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trazabilidad extends Model
{
    protected $primaryKey = 'ID_TRAZABILIDAD';
    public $timestamps = false;
    protected $table = 'trazabilidad';
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diagnostico extends Model
{
    protected $primaryKey = 'ID_DIAGNOSTICO';
    public $timestamps = false;
    protected $table = 'diagnostico';
}

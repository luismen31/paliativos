<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
    protected $primaryKey = 'ID_SALA';
    public $timestamps = false;
    protected $table = 'sala';
}

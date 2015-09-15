<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distrito extends Model
{
    protected $primaryKey = 'ID_DISTRITO';
    public $timestamps = false;
    protected $table = 'distritos';
}

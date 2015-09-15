<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institucion extends Model
{
    protected $primaryKey = 'ID_INSTITUCION';
    public $timestamps = false;
    protected $table = 'institucion';
}

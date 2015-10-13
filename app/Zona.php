<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zona extends Model
{
   	protected $primaryKey = 'ID_ZONA';
    public $timestamps = false;
    protected $table = 'zona';
}

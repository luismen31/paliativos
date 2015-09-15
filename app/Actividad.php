<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
	protected $primaryKey = 'ID_ACTIVIDAD';
	public $timestamps = false;
    protected $table = 'actividad';
}
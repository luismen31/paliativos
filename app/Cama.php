<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cama extends Model
{
	protected $primaryKey = 'ID_CAMA';
	public $timestamps = false;
    protected $table = 'cama';
}

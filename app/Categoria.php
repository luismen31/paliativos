<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
	protected $primaryKey = 'ID_CATEGORIA';
	public $timestamps = false;
   	protected $table = 'categoria';
}

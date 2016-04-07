<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medicamento extends Model
{
    public $timestamps = false;
    protected $table = 'medicamentos';
    protected $primaryKey = 'ID_MEDICAMENTO';
}

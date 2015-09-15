<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiaLaborable extends Model
{
    protected $primaryKey = 'ID_DIA';
    public $timestamps = false;
    protected $table = 'dias_laborables';
}

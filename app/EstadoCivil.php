<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoCivil extends Model
{
    protected $primaryKey = 'ID_ESTADO_CIVIL';
    public $timestamps = false;
    protected $table = 'estados_civiles';
}

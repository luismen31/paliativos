<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoAtencion extends Model
{
    protected $primaryKey = 'ID_TIPO_ATENCION';
    public $timestamps = false;
    protected $table = 'tipo_atencion';
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoInstitucion extends Model
{
    protected $primaryKey = 'ID_TIPO_INSTITUCION';
    public $timestamps = false;
    protected $table = 'tipo_institucion';
}

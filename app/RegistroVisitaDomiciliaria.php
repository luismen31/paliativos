<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistroVisitaDomiciliaria extends Model
{
    protected $primaryKey = 'ID_RVD';
    public $timestamps = false;
    protected $table = 'registro_visitas_domiciliarias';
}

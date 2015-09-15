<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleSoap extends Model
{
    protected $primaryKey = 'ID_DETALLE_SOAP';
    public $timestamps = false;
    protected $table = 'detalle_soap';
}

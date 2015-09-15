<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EscalaEdmonton extends Model
{
    protected $primaryKey = 'ID_ESCALA';
    public $timestamps = false;
    protected $table = 'escala_edmonton';
}

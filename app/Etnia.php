<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Etnia extends Model
{
    protected $primaryKey = 'ID_ETNIA';
    public $timestamps = false;
    protected $table = 'etnia';
}

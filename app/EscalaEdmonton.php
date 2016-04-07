<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EscalaEdmonton extends Model
{
    protected $primaryKey = 'ID_ESCALA';
    public $timestamps = false;
    protected $table = 'escala_edmonton';

    public function getTableColumns() {
    	$columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    	$columns = array_only($columns, [5,6,7,8,9,10,11,12,13,14]);
        return $columns;
    }
}

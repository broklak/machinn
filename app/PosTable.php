<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PosTable extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'pos_table';

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'type', 'desc', 'created_by', 'updated_by'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @param $type
     * @return string
     */
    public static function getTypeName($type){
        if($type == 1){
            return 'Resto';
        }

        return 'Banquet';
    }
}

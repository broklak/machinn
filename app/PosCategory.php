<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PosCategory extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'pos_category_item';

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'desc', 'type', 'discount', 'status', 'created_by', 'updated_by'
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
            return 'Food';
        }

        return 'Beverages';
    }

    /**
     * @param $id
     * @return string
     */
    public static function getName($id){
        $data = parent::find($id);

        return isset($data->name) ? $data->name : '';
    }
}

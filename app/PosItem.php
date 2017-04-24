<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PosItem extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'pos_item';

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'fnb_type', 'category_id', 'cost_basic', 'cost_before_tax', 'cost_sales', 'created_by', 'updated_by',
        'stock', 'status'
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

    public static function getName($id){
        $data = parent::find($id);

        return isset($data->name) ? $data->name : '';
    }
}

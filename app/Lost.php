<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lost extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'losts';

    /**
     * @var array
     */
    protected $fillable = [
        'date', 'item_name', 'item_color', 'item_value', 'place', 'guest_id', 'report_name', 'report_address', 'description', 'city', 'country'
        , 'zipcode', 'phone', 'email', 'created_by', 'updated_by', 'status'
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
     * @param $status
     * @param $updated_by
     * @return string
     */
    public static function getStatus($status, $updated_by){
        if($status == 1){
            return __('web.lost');
        }

        return __('web.returned');
    }
}

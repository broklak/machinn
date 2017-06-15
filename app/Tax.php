<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tax extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'taxes';

    /**
     * @var array
     */
    protected $fillable = [
        'tax_name', 'tax_status', 'tax_type', 'tax_percentage'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'tax_id';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public static function setTypeName ($type){
        if($type == 1){
            return __('taxTypeCustomer');
        }
        return __('taxTypeHotel');
    }
}

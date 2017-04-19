<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Damage extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'damages_assets';

    /**
     * @var array
     */
    protected $fillable = [
        'date', 'type', 'room_attribute_id', 'room_number_id', 'asset_name', 'guest_id', 'founder_employee_id', 'description', 'created_by', 'status',
        'created_by', 'updated_by', 'asset_name', 'founder_name'
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
}

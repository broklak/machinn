<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Province extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'provinces';

    /**
     * @var array
     */
    protected $fillable = [
        'province_name', 'country_id'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'province_id';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public static function getCountryName ($groupId) {
        $group = Country::find($groupId);

        return isset($group->country_name) ? $group->country_name : 'DELETED';
    }
}

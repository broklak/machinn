<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
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

    public static function getCountryName ($groupId) {
        $group = Country::find($groupId);

        return $group->country_name;
    }
}

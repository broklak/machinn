<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    /**
     * @var string
     */
    protected $table = 'partners';

    /**
     * @var array
     */
    protected $fillable = [
        'partner_name', 'partner_group_id', 'discount_weekend', 'discount_weekday', 'discount_special'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'partner_id';

    public static function getGroupName ($groupId) {
        $group = PartnerGroup::find($groupId);

        return $group->partner_group_name;
    }
}

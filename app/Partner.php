<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Partner extends Model
{
    use SoftDeletes;
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

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public static function getGroupName ($groupId) {
        $group = PartnerGroup::find($groupId);

        return isset($group->partner_group_name) ? $group->partner_group_name : 'DELETED';
    }

    public static function getName ($id) {
        if($id == 0){
            return 'Walk In';
        }

        $name = parent::find($id);
        return isset($name->partner_name) ? $name->partner_name : 'DELETED';
    }
}

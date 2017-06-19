<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'contacts';

    /**
     * @var array
     */
    protected $fillable = [
        'contact_name', 'contact_group_id', 'contact_phone', 'contact_address'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'contact_id';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public static function getGroupName ($groupId) {
        $group = ContactGroup::find($groupId);

        return isset($group->contact_group_name) ? $group->contact_group_name : __('web.deleted');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
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
     * @param $groupId
     * @return mixed
     */
    public static function getGroupName ($groupId) {
        $group = ContactGroup::find($groupId);

        return $group->contact_group_name;
    }
}

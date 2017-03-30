<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactGroup extends Model
{
    /**
     * @var string
     */
    protected $table = 'contact_groups';

    /**
     * @var array
     */
    protected $fillable = [
        'contact_group_name', 'contact_group_desc'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'contact_group_id';
}

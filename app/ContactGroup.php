<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactGroup extends Model
{
    use SoftDeletes;
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

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}

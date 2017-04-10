<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PartnerGroup extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'partner_groups';

    /**
     * @var array
     */
    protected $fillable = [
        'partner_group_name'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'partner_group_id';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}

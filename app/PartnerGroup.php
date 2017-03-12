<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PartnerGroup extends Model
{
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
}

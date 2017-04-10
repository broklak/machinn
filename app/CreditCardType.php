<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreditCardType extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'cc_types';

    /**
     * @var array
     */
    protected $fillable = [
        'cc_type_name', 'cc_type_status'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'cc_type_id';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}

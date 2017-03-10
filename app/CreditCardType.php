<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreditCardType extends Model
{
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
}

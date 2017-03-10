<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /**
     * @var string
     */
    protected $table = 'countries';

    /**
     * @var array
     */
    protected $fillable = [
        'country_name'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'country_id';
}

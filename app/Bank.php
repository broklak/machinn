<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    /**
     * @var string
     */
    protected $table = 'banks';

    /**
     * @var array
     */
    protected $fillable = [
        'bank_name'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'bank_id';
}

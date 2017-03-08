<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banquet extends Model
{
    /**
     * @var string
     */
    protected $table = 'banquets';

    /**
     * @var array
     */
    protected $fillable = [
        'banquet_name', 'banquet_status', 'banquet_start', 'banquet_end'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'banquet_id';
}

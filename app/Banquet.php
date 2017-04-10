<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banquet extends Model
{
    use SoftDeletes;
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

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BanquetEvent extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'banquet_events';

    /**
     * @var array
     */
    protected $fillable = [
        'event_name', 'event_status'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'event_id';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}

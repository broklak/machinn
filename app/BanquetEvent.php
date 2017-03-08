<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BanquetEvent extends Model
{
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
}

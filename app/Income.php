<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    /**
     * @var string
     */
    protected $table = 'incomes';

    /**
     * @var array
     */
    protected $fillable = [
        'income_name', 'income_date'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'income_id';

}

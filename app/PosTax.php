<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PosTax extends Model
{

    /**
     * @var string
     */
    protected $table = 'pos_tax';

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'percentage', 'updated_by'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'id';
}

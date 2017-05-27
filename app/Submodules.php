<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Submodules extends Model
{
    /**
     * @var string
     */
    protected $table = 'submodules';

    /**
     * @var array
     */
    protected $fillable = [
        'submodule_name'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'submodule_id';
}

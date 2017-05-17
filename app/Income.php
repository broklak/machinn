<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Income extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'incomes';

    /**
     * @var array
     */
    protected $fillable = [
        'income_name', 'income_date', 'income_amount'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'income_id';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @param $id
     * @return string
     */
    public static function getName($id) {
        $data = parent::find($id);

        return isset($data->income_name) ? $data->income_name : 'DELETED';
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Settlement extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'settlements';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'settlement_name', 'settlement_bank_id'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'settlement_id';

    public static function getBankName ($bankId) {
        $group = Bank::find($bankId);

        return isset($group->bank_name) ? $group->bank_name : 'DELETED';
    }
}

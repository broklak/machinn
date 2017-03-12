<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settlement extends Model
{
    /**
     * @var string
     */
    protected $table = 'settlements';

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

        return $group->bank_name;
    }
}

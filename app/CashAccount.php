<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CashAccount extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'cash_accounts';

    /**
     * @var array
     */
    protected $fillable = [
        'cash_account_name', 'cash_account_desc', 'cash_account_amount'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'cash_account_id';

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
    public static function getName ($id){
        $data = parent::find($id);

        return isset($data->cash_account_name) ? $data->cash_account_name : 'DELETED';
    }

}

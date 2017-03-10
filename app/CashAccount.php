<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CashAccount extends Model
{
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
}

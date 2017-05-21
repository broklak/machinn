<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CashTransaction extends Model
{
    /**
     * @var string
     */
    protected $table = 'cash_transaction';

    /**
     * @var array
     */
    protected $fillable = [
        'cash_account_id', 'amount', 'desc', 'type', 'booking_id', 'expense_id', 'pos_id', 'income_id'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @param $data
     * @return bool
     */
    public static function insert ($data){
        $payment_method = $data['payment_method'];

        if($payment_method != 3){
            if($payment_method == 1){
                $dataCash = CashAccount::where('code', 'fo')->first();
                $data['cash_account_id'] = $dataCash->cash_account_id;
            } elseif($payment_method == 2){
                $dataCash = CashAccount::where('code', 'bo')->first();
                $data['cash_account_id'] = $dataCash->cash_account_id;
            }

            // UPDATE NOMINAL
            self::updateMasterAmount($data['cash_account_id'], $data['type'], $data['amount']);

            return parent::create($data);
        }

        return false;
    }

    /**
     * @param $cashId
     * @param $type
     * @param $amount
     * @return mixed
     */
    private static function updateMasterAmount ($cashId, $type, $amount){
        $dataCash = CashAccount::find($cashId);

        if($type == 1){ // DEBIT
            $dataCash->cash_account_amount = $dataCash->cash_account_amount - $amount;
        } else {
            $dataCash->cash_account_amount = $dataCash->cash_account_amount + $amount;
        }

        return $dataCash->save();
    }

    /**
     * @param $start
     * @param $end
     * @param $account
     * @return mixed
     */
    public static function getTransaction ($start, $end, $account){
        $where = [];
        $start = date('Y-m-d 00:00:00', strtotime($start));
        $end = date('Y-m-d 23:59:59', strtotime($end));

        if($account != 0){
            $where[] = ['cash_Account_id', '=', $account];
        }
        $data = parent::whereBetween('created_at', [$start, $end])
            ->where($where)
            ->get();

        return $data;
    }
}

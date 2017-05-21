<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BackIncome extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'back_income';

    /**
     * @var array
     */
    protected $fillable = [
        'type', 'date', 'amount', 'cash_account_recipient', 'status', 'desc', 'created_by', 'updated_by', 'income_id', 'account_receivable_id'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @param $start
     * @param $end
     * @param $type
     * @return mixed
     */
    public function getIncome ($start, $end, $type){
        $where = [];

        if($type != 0){
            $where[] = ['type', '=', $type];
        }
        $data = parent::whereBetween('date', [$start, $end])
            ->where($where)
            ->paginate(config('app.limitPerPage'));

        return $data;
    }


    /**
     * @param $data
     * @return string
     */
    public static function getType ($data){
        $type = $data->type;

        if($type == 1){
            return 'Paid Up Capital';
        }

        if($type == 2){
            return 'Account Receivable Payment <br /> Booking Code '.BookingHeader::getBookingCode($data['account_receivable_id']);
        }

        if($type == 3){
            $income = Income::find($data->income_id);
            $name = (isset($income->income_name)) ? $income->income_name : '';

            return 'Others <br /> '.$name;
        }
    }
}

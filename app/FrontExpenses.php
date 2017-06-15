<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class FrontExpenses extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'front_expenses';

    /**
     * @var array
     */
    protected $fillable = [
        'amount', 'date', 'desc', 'cost_id', 'department_id', 'cash_account_id', 'status', 'created_by', 'updated_by'
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

    public static function getList ($filter, $limit){
        $where[] = ['status', '<>', 3];

        if(isset($filter['status']) && $filter['status'] != 0) {
            $where[] = ['status', '=', $filter['status']];
        }

        if(isset($filter['department_id']) && $filter['department_id'] != 0) {
            $where[] = ['department_id', '=', $filter['department_id']];
        }

        if(isset($filter['cash_account_id']) && $filter['cash_account_id'] != 0) {
            $where[] = ['cash_account_id', '=', $filter['cash_account_id']];
        }

        $list = parent::where($where)->whereBetween('date', [$filter['start'], $filter['end']])->paginate($limit);

        return $list;
    }

    public static function getStatusName ($status) {
        if($status == 1){
            return __('web.approved');
        } elseif($status == 2) {
            return __('web.notApproved');
        } else {
            return __('web.deleted');
        }
    }

    /**
     * @param $start
     * @param $end
     * @return mixed
     */
    public static function getExpensesByCost ($start, $end){
        $data = DB::table('front_expenses')
                    ->select(DB::raw('cost_id, SUM(amount) as total'))
                    ->groupBy('cost_id')
                    ->whereBetween('date', [$start, $end])
                    ->get();

        return $data;
    }

    public static function getTotalExpense($start, $end){
        $data = self::getExpensesByCost($start, $end);
        $total = 0;
        foreach ($data as $key => $item) {
            $total = $total + $item->total;
        }

        return $total;
    }
}

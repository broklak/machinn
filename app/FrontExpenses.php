<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FrontExpenses extends Model
{
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

    public static function getList ($filter, $limit){
        $where[] = ['status', '<>', 3];

        if($filter['status'] != 0) {
            $where[] = ['status', '=', $filter['status']];
        }

        $list = parent::where($where)->whereBetween('date', [$filter['start'], $filter['end']])->paginate($limit);

        return $list;
    }

    public static function getStatusName ($status) {
        if($status == 1){
            return 'Approved';
        } elseif($status == 2) {
            return 'Not Approved';
        } else {
            return 'Deleted';
        }
    }
}

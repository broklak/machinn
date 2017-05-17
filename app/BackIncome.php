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
        'type', 'date', 'amount', 'cash_account_recipient', 'status', 'desc', 'created_by', 'updated_by', 'income_id'
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
     * @param $status
     * @return mixed
     */
    public function getIncome ($start, $end, $status){
        $data = parent::whereBetween('date', [$start, $end])
//            ->where('status', $status)
            ->paginate(config('app.limitPerPage'));

        return $data;
    }
}

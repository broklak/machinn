<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'invoice';

    /**
     * @var array
     */
    protected $fillable = [
        'invoice_number', 'invoice_date', 'due_date', 'amount', 'desc', 'source', 'source_id', 'department_id', 'cost_id', 'status', 'created_by', 'updated_by', 'paid'
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
     * @param $paid
     * @return mixed
     */
    public function getInvoice ($start, $end, $status, $paid){
        $where = [];

        if($paid != -1){
            $where[] = ['paid', '=', $paid];
        }
        $data = parent::whereBetween('invoice_date', [$start, $end])
                        ->where($where)
                        ->paginate(config('app.limitPerPage'));

        return $data;
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class InvoicePayment extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'invoice_payment';

    /**
     * @var array
     */
    protected $fillable = [
        'invoice_id', 'paid_amount', 'desc', 'cash_account_id', 'status', 'created_by', 'updated_by', 'payment_date'
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
    public function getInvoicePayment ($start, $end, $status){
        $start = date('Y-m-d 00:00:00', strtotime($start));
        $end = date('Y-m-d 23:59:59', strtotime($end));
        $data = DB::table('invoice_payment')
            ->select(DB::raw('invoice_payment.id, invoice_payment.created_at, due_date, invoice_number, cost_id,
                            source_id, cash_account_id, invoice_payment.status, paid_amount, payment_date'))
            ->whereBetween('invoice_payment.created_at', [$start, $end])
            ->where('invoice_payment.status', $status)
            ->where('invoice_payment.deleted_at', null)
            ->join('invoice', 'invoice_payment.invoice_id', '=', 'invoice.id')
            ->paginate(config('app.limitPerPage'));

        return $data;
    }
}

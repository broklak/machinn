<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AccountReceivable extends Model
{
    /**
     * @var string
     */
    protected $table = 'account_receivable';

    /**
     * @var array
     */
    protected $fillable = [
        'booking_id', 'date', 'amount', 'desc', 'partner_id', 'paid', 'created_by', 'updated_by'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @param $start
     * @param $end
     * @param $paid
     * @return mixed
     */
    public function getAccReceivable ($start, $end, $paid){
        $where = [];

        if($paid != -1){
            $where[] = ['paid', '=', $paid];
        }
        $data = parent::whereBetween('date', [$start, $end])
            ->where($where)
            ->paginate(config('app.limitPerPage'));

        return $data;
    }

    public static function insert ($data){
        $partner_id = (isset($data['partner_id'])) ? $data['partner_id'] : 0;
        $validate = self::validate($partner_id);

        if($validate){
            parent::create($data);
            return true;
        }

        return false;
    }

    public static function validate($partner_id){
        $partner = Partner::find($partner_id);

        if(!isset($partner->partner_group_id)){
            return false;
        }

        $group = PartnerGroup::find($partner->partner_group_id);

        if(!isset($group->partner_group_name)){
            return false;
        }

        return ($group->booking_paid_first == 1) ? true : false;
    }

    /**
     * @return mixed
     */
    public static function getUnpaidBooking (){
        $data = DB::table('account_receivable')
                        ->select(DB::raw('booking_id, SUM(ANY_VALUE(amount)) as total, ANY_VALUE(partner_id) as partner_id'))
                        ->where('paid', 0)
                        ->groupBy('booking_id')
                        ->get();
        return $data;
    }
}

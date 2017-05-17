<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mutation extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'cash_mutation';

    /**
     * @var array
     */
    protected $fillable = [
        'from', 'to', 'date', 'amount', 'desc', 'status', 'created_by', 'updated_by'
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
    public function getMutation ($start, $end, $status){
        $data = parent::whereBetween('date', [$start, $end])
            ->where('status', $status)
            ->paginate(config('app.limitPerPage'));

        return $data;
    }
}

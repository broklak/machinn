<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Found extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'founds';

    /**
     * @var array
     */
    protected $fillable = [
        'date', 'lost_id', 'founder_employee_id', 'founder_name', 'item_name', 'item_color', 'item_value', 'place', 'description', 'status',
        'created_by', 'updated_by'
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
     * @param $status
     * @param $updated_by
     * @return string
     */
    public static function getStatus($status, $updated_by){
        if($status == 1){
            return __('web.found');
        }
        return __('web.returned');
    }
}

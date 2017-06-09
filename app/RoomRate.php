<?php

namespace App;

use App\Helpers\GlobalHelper;
use Illuminate\Database\Eloquent\Model;

class RoomRate extends Model
{
    /**
     * @var string
     */
    protected $table = 'room_rates';

    /**
     * @var array
     */
    protected $fillable = [
        'room_rate_day_type_id', 'room_rate_type_id', 'room_price'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'room_rate_id';

    public static function getRate ($dayType, $roomType) {
        $data = parent::where('room_rate_day_type_id', $dayType)->where('room_rate_type_id', $roomType)->first();

        return GlobalHelper::moneyFormat($data->room_price);
    }
}

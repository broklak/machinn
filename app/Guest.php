<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guest extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'guests';

    /**
     * @var array
     */
    protected $fillable = [
        'id_type', 'id_number', 'first_name', 'type', 'title', 'last_name', 'birthdate', 'birthplace', 'religion',
        'gender', 'job', 'address', 'country_id', 'province_id', 'email', 'zipcode', 'homephone', 'handphone', 'created_by', 'updated_by'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'guest_id';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @param $idType
     * @return string
     */
    public function getIdTypeName ($idType) {
        switch ($idType) {
            case 1:
                return 'KTP';
                break;
            case 2:
                return "SIM";
                break;
            case 3:
                return "Passport";
                break;
        }
    }

    /**
     * @param $idType
     * @return string
     */
    public static function getIdType ($idType) {
        switch ($idType) {
            case 1:
                return 'KTP';
                break;
            case 2:
                return "SIM";
                break;
            case 3:
                return "Passport";
                break;
        }
    }

    /**
     * @param $title
     * @return string
     */
    public static function getTitleName ($title) {
        switch ($title) {
            case 1:
                return 'Mr.';
                break;
            case 2:
                return "Mrs.";
                break;
            case 3:
                return "Miss.";
                break;
        }
    }

    public static function getFullName ($id){
        $data = parent::find($id);

        return ($data) ? $data->first_name. ' '.$data->last_name : 'DELETED';
    }

    /**
     * @param $input
     * @param null $id
     * @return mixed
     */
    public static function insertGuest($input, $id = null){
        $guestData = [
            'id_type'       => $input['id_type'],
            'id_number'     => $input['id_number'],
            'type'          => isset($input['guest_type']) ? $input['guest_type'] : 1,
            'title'         => $input['guest_title'],
            'first_name'    => $input['first_name'],
            'last_name'    => $input['last_name'],
            'birthdate'    => $input['birthdate'],
            'birthplace'    => $input['birthplace'],
            'religion'    => isset($input['religion']) ? $input['religion'] : null,
            'gender'    => $input['gender'],
            'job'    => $input['job'],
            'address'    => $input['address'],
            'country_id'    => isset($input['country_id']) ? $input['country_id'] : null,
            'province_id'    => isset($input['province_id']) ? $input['province_id'] : null,
            'homephone'    => $input['homephone'],
            'handphone'    => $input['handphone'],
            'email'    => $input['email'],
            'created_by' => Auth::id()
        ];
        $guest = ($id == null) ? parent::create($guestData) : parent::find($id)->update($guestData);
        return $guest;
    }
    /**
     * @param $start
     * @param $end
     * @return mixed
     */
    public static function getTotalCheckInGuest ($start, $end) {
        $totalGuest = DB::table('booking_header')
            ->select(DB::raw('checkin_date, SUM(ANY_VALUE(adult_num)) AS adult_num, SUM(ANY_VALUE(child_num)) as child_num
                            , (SUM(ANY_VALUE(adult_num)) + SUM(ANY_VALUE(child_num))) as total'))
            ->whereBetween('checkin_date', [$start, $end])
            ->where('booking_status', 2)
            ->groupBy('checkin_date')
            ->get();

        return $totalGuest;
    }

    /**
     * @param $start
     * @param $end
     * @param $type
     * @return mixed
     */
    public static function getStatistic ($start, $end, $type = 'gender') {
        if($type == 'gender'){
            $select = "(IF(ANY_VALUE(gender) = 1, 'Male', 'Female'))";
        } elseif($type == 'religion'){
            $select = 'CONCAT(UCASE(LEFT(religion, 1)), SUBSTRING(religion, 2))';
        } elseif($type == 'age') {
            $getAge = "(YEAR(CURRENT_TIMESTAMP) - YEAR(birthdate) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(birthdate, 5)))";
            $select = "CASE
                                WHEN $getAge < 20 THEN '< 20'
                                WHEN $getAge BETWEEN 20 and 30 THEN '20 - 30'
                                WHEN $getAge BETWEEN 31 and 40 THEN '31 - 40'
                                WHEN $getAge BETWEEN 41 and 50 THEN '41 - 50'
                                WHEN $getAge > 50 THEN '> 50'
                            END";
            $type = 'label';
        }
        $totalGuest = DB::table('booking_header')
            ->select(DB::raw("COUNT(*) as data, $select as label"))
            ->whereBetween('checkin_date', [$start, $end])
            ->where('booking_status', 2)
            ->join('guests', 'guests.guest_id', '=', 'booking_header.guest_id')
            ->groupBy($type)
            ->get();

        return $totalGuest;
    }

    /**
     * @param $guest_id
     * @return mixed
     */
    public static function getHistoryCheckin($guest_id) {
        $history = DB::table('booking_header')
                    ->select('checkin_date', 'room_list', 'checkout_date', 'room_list', 'room_plan_name', 'grand_total')
                    ->where('guest_id', $guest_id)
                    ->join('room_plans', 'room_plans.room_plan_id', '=', 'booking_header.room_plan_id')
                    ->orderBy('booking_id', 'desc')
                    ->get();

        return $history;
    }

    /**
     * @param array $filter
     * @return mixed
     */
    public static function getInhouseGuestWithRoom ($filter = null){
        $where = [];

        if($filter != null){
            $room = RoomNumber::where('room_number_code', $filter)->first();
            if(isset($room->room_number_id)){
                $where[] = ['room_numbers.room_number_id', '=', $room->room_number_id];
            } else{
                $where[] = ['first_name', 'LIKE', "%$filter%"];
            }
        }

        $where[] = ['status', '=', 2];
        $where[] = ['checkout', '=', 0];

        $guest = DB::table('booking_room')
                        ->select(DB::raw('distinct(booking_id), first_name, last_name,
                        booking_room.guest_id, room_number_code, booking_room.room_number_id'))
                        ->where($where)
                        ->join('guests', 'guests.guest_id', '=', 'booking_room.guest_id')
                        ->join('room_numbers', 'room_numbers.room_number_id', '=', 'booking_room.room_number_id')
//                        ->groupBy('booking_room.room_number_id')
                        ->get();

        return $guest;
    }

}
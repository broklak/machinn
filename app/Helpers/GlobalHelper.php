<?php

namespace App\Helpers;

use App\WorkerCategory;
use Illuminate\Http\Request;
use App\Libraries\LayoutManager;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class GlobalHelper
{
    /**
     * @param string $messageType
     * @param string $message
     * @return string
     */
    public static function setDisplayMessage($messageType = 'error', $message = 'Error Message')
    {
        $message = '<div style="margin:20px 0" class="alert alert-' . $messageType . '">' . $message . '</div>';
        return $message;
    }

    /**
     * @param $gender
     * @return string
     */
    public static function getGender ($gender) {
        if($gender == 1){
            return 'Male';
        }

        return 'Female';
    }

    /**
     * @param $money
     * @return string
     */
    public static function moneyFormat ($money) {
        $currency = 'Rp. ';
        $money = $currency . number_format($money,0,',',',');

        return $money;
    }

    /**
     * @param $money
     * @return string
     */
    public static function moneyFormatReport ($money) {
        $money = number_format($money,0,',',',');

        return $money;
    }

    /**
     * @param $date
     * @return bool|string
     */
    public static function dateFormat ($date){
        return date('j F Y', strtotime($date));
    }

    /**
     * @param $status
     * @param string $type
     * @return string
     */
    public static function setActivationStatus($status, $type = 'Active'){
        if($status == 0){
            return '<span class="label label-important">Not '.$type.'</span>';
        }

        return '<span class="label label-success">'.$type.'</span>';
    }

    /**
     * @param $status
     * @return string
     */
    public static function setYesOrNo($status){
        if($status == 0){
            return 'No';
        }

        return 'Yes';
    }

    /**
     * @param $guestId
     * @return string
     */
    public static function generateBookingId ($guestId){
        $char = 10;
        $now = substr(time(), -4);
        $len = strlen($guestId.$now);
        $rand = str_random($char - $len);

        return strtoupper($guestId.$rand.$now);
    }

    /**
     * @param $guestId
     * @return string
     */
    public static function generateBillNumber ($guestId){
        if($guestId == null){
            $guestId = 0;
        }
        $prefix = 'OP-';
        $char = 7;
        $now = substr(time(), -3);
        $len = strlen($guestId.$now);
        $rand = str_random($char - $len);

        return $prefix.strtoupper($guestId.$rand.$now);
    }

    /**
     * @param $department_id
     * @param $source_id
     * @return string
     */
    public static function generateInvoiceNumber ($department_id, $source_id) {
        $prefix = 'IP-';
        $char = 8;
        $now = substr(time(), -3);
        $len = strlen($department_id.$now.$source_id);
        $rand = str_random($char - $len);

        return $prefix.strtoupper($department_id.$source_id.$rand.$now);
    }

    /**
     * @param $bookingId
     * @param $deposit
     * @return string
     */
    public static function generateReceipt($bookingId, $deposit = false){
        $prefix = ($deposit) ? 'D' : 'B';
        $length = 5;
        $lenZero = $length - strlen($bookingId);
        $zero = '';
        for($i=0; $i<$lenZero; $i++){
            $zero .= '0';
        }

        return $prefix.$zero.$bookingId;

    }

    /**
     * @param $type
     * @return string
     */
    public static function getBookingTypeName ($type) {
        if($type == 1){
            return 'Guaranteed';
        } else if($type == 2) {
            return 'Tentative';
        } else {
            return 'Checked In';
        }
    }

    /**
     * @param $type
     * @return string
     */
    public static function getBookingTypeLabel ($type) {
        if($type == 1){
            return 'info';
        } else if($type == 2) {
            return 'warning';
        } else {
            return 'success';
        }
    }

    /**
     * @param $status
     * @return string
     */
    public static function getBookingStatus($status){
        switch($status){
            case 1:
                return 'Wait to Checkin';
                break;
            case 2:
                return 'Already Check In';
                break;
            case 3:
                return 'No Showing';
                break;
            case 4:
                return 'Void';
        }
    }

    /**
     * @param $status
     * @return string
     */
    public static function setStatusName($status){
        if($status == 1){
            return 'Ready';
        } elseif($status == 2){
            return 'Dirty';
        } else {
            return 'Not Ready';
        }
    }

    /**
     * @param $status
     * @return string
     */
    public static function setButtonStatus($status){
        if($status == 1){
            return 'success';
        } elseif($status == 2){
            return 'warning';
        } elseif($status == 3){
            return 'important';
        }
    }

    /**
     * @param $status
     * @return string
     */
    public static function getBookingRoomStatusColor($status){
        switch($status){
            case 1:
                return 'vacant';
                break;
            case 2:
                return 'occupied';
                break;
            case 3:
                return 'guaranteed';
                break;
            case 4:
                return 'tentative';
                break;
            case 5:
                return 'ooo';
                break;
        }
    }

    /**
     * @param $data
     * @param null $booking_id
     * @return string
     */
    public static function generateHTMLRoomChoice($data, $booking_id = null){
        $html = '';
        foreach($data as $key => $val){
            $html .= '<tr><td class="room-type-name" colspan="100">'.$key.' (Weekend : '.self::moneyFormat($val['weekends_rate']).', Weekday : '.self::moneyFormat($val['weekdays_rate']).')</td></tr>';
            foreach($val['floor'] as $key_floor => $val_floor){
                $html .= '<tr><td style="width: 20%">Floor '.$key_floor.'</td><td style="width:90%">';
                $room_total = 0;
                foreach($val_floor as $room) {
                    $room_total++;
                    $checkable = '';
                    $checked = '';
                    if($room['room_used'] == 0){
                        $status = 'vacant';
                    } else{
                        if($room['status'] == 2){
                            $status = 'occupied';
                        } elseif($room['status'] == 3){
                            $status = 'guaranteed';
                        } elseif($room['status'] == 4){
                            $status = 'tentative';
                        } else {
                            $status = 'ooo';
                        }
                    }

                    if($room['room_used'] != 0){
                        $checkable = 'disabled';
                    }

                    if($room['booking_id'] == $booking_id){
                        $checkable = '';
                    }

                    if($room['room_used'] > 0 && $room['booking_id'] == $booking_id){
                        $checked = 'checked';
                    }

                    $html .= '<span class="'.$status.' room-opt"><input style="margin-top:-2px" '.$checkable.' '.$checked.' class="chooseRoom" id="room-check-'.$room['room_number_id'].'"
                               data-id="'.$room['room_number_id'].'" data-weekdays="'.$room['room_rate_weekdays'].'"
                               data-weekends="'.$room['room_rate_weekends'].'" data-typename="'.$room['room_type_name'].'" data-type="'.$room['room_type_id'].'"
                               data-code="'.$room['room_number_code'].'" type="checkbox" />
                               <label style="vertical-align:top" for="room-check-'.$room['room_number_id'].'">'.$room['room_number_code'].'</label></span>';
                    if($room_total % 10 == 0){
                        $html .= "<div style='margin-top: 10px'></div>";
                    }
                }
                $html .= '</td></tr>';
            }
        }

        return $html;
    }

    /**
     * @param $data
     * @param null $booking_id
     * @return string
     */
    public static function generateHTMLHouseKeeping($data){
        $html = '';
        foreach($data as $key => $val){
            $html .= '<tr><td class="room-type-name" colspan="100">'.$key.'</td></tr>';
            foreach($val['floor'] as $key_floor => $val_floor){
                $html .= '<tr style="position: relative"><td style="width: 20%;position: relative">Floor '.$key_floor.'</td><td style="width:90%">';
                $room_total = 0;
                foreach($val_floor as $room) {
                    $room_total++;

                    if($room['room_used'] == 0){
                        $status = 'success';
                    } else{
                        if($room['status'] == 2){
                            $status = 'danger';
                        } elseif($room['status'] == 3){
                            $status = 'warning';
                        } elseif($room['status'] == 4){
                            $status = 'info';
                        } else {
                            $status = 'inverse';
                        }
                    }

                    if($room['hk_status'] == 1){
                      $hk = 'check';
                    } elseif($room['hk_status'] == 2){
                        $hk = 'warning-sign';
                    } elseif($room['hk_status'] == 3){
                        $hk = 'wrench';
                    }

                    $html .= '<div class="btn-group">';
                    $html .= '<button data-toggle="dropdown" class="btn btn-'.$status.' dropdown-toggle">'.$room['room_number_code'].'  &nbsp; <i class="icon icon-'.$hk.'"></i></button>';
                    $html .= '<ul class="dropdown-menu">';
                    if($room['hk_status'] == 1){
                        $html .= '<li><a href="'.route('house.set', ['id' => $room['room_number_id'], 'status' => 2]).'"><i class="icon icon-warning-sign"></i> Set Dirty</a></li>';
                        $html .= '<li><a href="'.route('house.set', ['id' => $room['room_number_id'], 'status' => 3]).'"><i class="icon icon-wrench"></i> Set Out of Order</a></li></ul>';
                    } elseif($room['hk_status'] == 2){
                        $html .= '<li><a href="'.route('house.set', ['id' => $room['room_number_id'], 'status' => 1]).'"><i class="icon icon-check"></i> Set Ready</a></li>';
                        $html .= '<li><a href="'.route('house.set', ['id' => $room['room_number_id'], 'status' => 3]).'"><i class="icon icon-wrench"></i> Set Out of Order</a></li></ul>';
                    } else {
                        $html .= '<li><a href="'.route('house.set', ['id' => $room['room_number_id'], 'status' => 1]).'"><i class="icon icon-check"></i> Set Ready</a></li>';
                        $html .= '<li><a href="'.route('house.set', ['id' => $room['room_number_id'], 'status' => 2]).'"><i class="icon icon-warning-sign"></i> Set Dirty</a></li>';
                    }

                    $html .= '</div>';
                    if($room_total % 10 == 0){
                        $html .= "<div style='margin-top: 10px'></div>";
                    }
                }
                $html .= '</td></tr>';
            }
        }

        return $html;
    }
}


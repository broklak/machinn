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
     * @param $date
     * @return bool|string
     */
    public static function dateFormat ($date){
        return date('j F Y', strtotime($date));
    }

    /**
     * @param $status
     * @return string
     */
    public static function setActivationStatus($status){
        if($status == 0){
            return '<span class="label label-important">Not Active</span>';
        }

        return '<span class="label label-success">Active</span>';
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
}


<?php

namespace App\Helpers;

use App\WorkerCategory;
use Illuminate\Http\Request;
use App\Libraries\LayoutManager;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class GlobalHelper
{
    public static function setDisplayMessage($messageType = 'error', $message = 'Error Message')
    {
        $message = '<div style="margin:20px 0" class="alert alert-' . $messageType . '">' . $message . '</div>';
        return $message;
    }

    public static function moneyFormat ($money) {
        $currency = 'Rp ';
        $money = $currency . number_format($money,0,',',',');

        return $money;
    }

    public static function dateFormat ($date){
        return date('j F Y', strtotime($date));
    }

    public static function setActivationStatus($status){
        if($status == 0){
            return '<span class="label label-important">Not Active</span>';
        }

        return '<span class="label label-success">Active</span>';
    }

    public static function setYesOrNo($status){
        if($status == 0){
            return 'No';
        }

        return 'Yes';
    }

    public static function generateBookingId ($guestId){
        $char = 10;
        $now = substr(time(), -4);
        $len = strlen($guestId.$now);
        $rand = str_random($char - $len);

        return strtoupper($guestId.$rand.$now);
    }
}


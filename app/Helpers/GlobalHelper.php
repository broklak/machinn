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
        $message = '<div class="notification ' . $messageType . '">' . $message . '</div>';
        return $message;
    }

    public static function moneyFormat ($money) {
        $currency = 'Rp ';
        $money = $currency . number_format($money,0,',',',');

        return $money;
    }
}


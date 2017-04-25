<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PosTax extends Model
{

    /**
     * @var string
     */
    protected $table = 'pos_tax';

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'percentage', 'updated_by'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @param $total
     * @return mixed
     */
    public static function getTax($total){
        $data = parent::find(1);
        $tax = round(($total * $data->percentage) / 100);
        return $tax;
    }

    /**
     * @return string
     */
    public static function getTaxInfo(){
        $data = parent::find(1);

        return $data->name.' ('.$data->percentage.'%)';
    }

    /**
     * @param $total
     * @return mixed
     */
    public static function getService($total){
        $data = parent::find(2);
        $service = round(($total * $data->percentage) / 100);
        return $service;
    }

    /**
     * @return string
     */
    public static function getServiceInfo(){
        $data = parent::find(2);

        return $data->name.' ('.$data->percentage.'%)';
    }
}

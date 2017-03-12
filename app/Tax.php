<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    /**
     * @var string
     */
    protected $table = 'taxes';

    /**
     * @var array
     */
    protected $fillable = [
        'tax_name', 'tax_status', 'tax_type', 'tax_percentage'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'tax_id';

    public static function setTypeName ($type){
        if($type == 1){
            return 'Charged to Customer';
        }
        return 'Paid by Hotel';
    }
}

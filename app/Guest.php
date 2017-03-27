<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
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
}
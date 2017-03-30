<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    /**
     * @var string
     */
    protected $table = 'logbooks';

    /**
     * @var array
     */
    protected $fillable = [
        'logbook_message', 'to_dept_id', 'to_date', 'created_by', 'updated_by'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'logbook_id';

    public static function getUserName ($userId) {
        $get_user = User::find($userId)->value('username');
        return $get_user;
    }
}

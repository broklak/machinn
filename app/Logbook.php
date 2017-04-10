<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Logbook extends Model
{
    use SoftDeletes;
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

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public static function getUserName ($userId) {
        $get_user = User::find($userId)->value('username');
        return ($get_user) ? $get_user : 'DELETED';
    }
}

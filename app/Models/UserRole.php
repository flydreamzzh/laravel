<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class UserRole
 * @package App\Models
 * @version February 8, 2018, 9:35 am UTC
 *
 * @property \App\Models\AuthRole authRole
 * @property \App\Models\User user
 * @property integer user_id
 * @property string role_id
 */
class UserRole extends Model
{

    public $table = 'user_role';

    public $timestamps = false;


    public $fillable = [
        'user_id',
        'role_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'role_id' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function authRole()
    {
        return $this->belongsTo(\App\Models\AuthRole::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}

<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class AuthRolePermissions
 * @package App\Models
 * @version February 28, 2018, 9:04 am UTC
 *
 * @property \App\Models\AuthPermission authPermission
 * @property \App\Models\AuthRole authRole
 * @property \Illuminate\Database\Eloquent\Collection userRole
 * @property string role_id
 * @property integer permission_id
 */
class AuthRolePermissions extends Model
{

    public $table = 'auth_role_permissions';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';



    public $fillable = [
        'role_id',
        'permission_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'role_id' => 'string',
        'permission_id' => 'integer'
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
    public function authPermission()
    {
        return $this->belongsTo(\App\Models\AuthPermission::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function authRole()
    {
        return $this->belongsTo(\App\Models\AuthRole::class);
    }
}

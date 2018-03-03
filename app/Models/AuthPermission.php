<?php

namespace App\Models;
use App\Models\base\Model;

/**
 * Class AuthPermission
 * @package App\Models
 * @version March 3, 2018, 12:52 pm UTC
 *
 * @property \App\Models\Menu menu
 * @property \Illuminate\Database\Eloquent\Collection AuthRolePermission
 * @property \Illuminate\Database\Eloquent\Collection userRole
 * @property string name
 * @property string route_name
 * @property smallInteger status
 * @property string menu_id
 * @property string description
 */
class AuthPermission extends Model
{

    public $table = 'auth_permissions';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';



    public $fillable = [
        'name',
        'route_name',
        'status',
        'menu_id',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'route_name' => 'string',
        'menu_id' => 'string',
        'description' => 'string'
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
    public function menu()
    {
        return $this->belongsTo(\App\Models\Menu::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function authRolePermissions()
    {
        return $this->hasMany(\App\Models\AuthRolePermissions::class);
    }

    /**
     * 返回路由的名称
     * Example：Route::resource('menus', 'MenuController'); 中的menus
     * return 'menus';
     * @return string
     */
    public function route()
    {
        return 'authPermissions';
        // TODO: Implement route() method.
    }
}

<?php

namespace App\Models;
use App\Models\base\Model;


/**
 * Class User
 * @package App\Models
 * @version January 18, 2018, 9:33 am UTC
 *
 * @property string name
 * @property string email
 * @property string password
 * @property string remember_token
 */
class User extends Model
{

    public $table = 'users';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $appends = ['role_id', 'edit_url', 'show_url', 'store_url', 'update_url', 'delete_url'];

    public $fillable = [
        'name',
        'email',
        'password',
        'remember_token'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'email' => 'string',
        'password' => 'string',
        'remember_token' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];


    /**
     * 返回路由的名称
     * Example：Route::resource('menus', 'MenuController'); 中的menus
     * return 'menus';
     * @return string
     */
    public function route()
    {
        return 'users';
        // TODO: Implement route() method.
    }

    public function getRoleIdAttribute()
    {
        return '';
    }
}

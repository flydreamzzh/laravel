<?php

namespace App\Models;

use App\Models\base\TreeModel;
use Webpatser\Uuid\Uuid;

/**
 * Class AuthRole
 * @package App\Models
 * @version February 2, 2018, 3:48 am UTC
 *
 * @property string id
 * @property string name
 * @property string description
 * @property integer lft
 * @property integer rgt
 */
class AuthRole extends TreeModel
{
    /**
     * Indicates if the IDs are auto-incrementing.
     * @var bool
     */
    public $incrementing = false;

    public $table = 'auth_roles';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $children_name = 'children';

    protected $appends = ['title', 'key', 'value', 'label', 'parent', 'edit_url', 'show_url', 'store_url', 'update_url', 'delete_url'];

    public $fillable = [
        'name',
        'description',
        'lft',
        'rgt'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string',
        'name' => 'string',
        'description' => 'string',
        'lft' => 'integer',
        'rgt' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    /**
     * fancytree 插件
     * @return string
     */
    public function getTitleAttribute()
    {
        return $this->name;
    }

    /**
     * fancytree 插件
     * @return string
     */
    public function getKeyAttribute()
    {
        return $this->id;
    }

    /**
     * fancytree 插件
     * @return string
     */
    public function getLabelAttribute()
    {
        return $this->name;
    }

    /**
     * fancytree 插件
     * @return string
     */
    public function getValueAttribute()
    {
        return $this->id;
    }


    /**
     * 返回路由的名称
     * Example：Route::resource('menus', 'MenuController'); 中的menus
     * return ['menus'];
     * @return string
     */
    public function route()
    {
        // TODO: Implement route() method.
        return 'authRoles';
    }

    /**
     * example：
     * return ["lft", "rgt"];
     * 设置数据表左右值字段名
     *
     * @return array
     */
    public function setLeftAndRightColumn()
    {
        // TODO: Implement setLeftAndRightColumn() method.
        return ["lft", "rgt"];
    }

    /**
     * The "booting" method of the model.
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function($model)
        {
            /** @var \Eloquent $model*/
            $model->{$model->getKeyName()} = (string)self::generateNewId();
        });
    }

    /**
     * @return string Uuid
     */
    public static function generateNewId()
    {
        return Uuid::generate();
    }
}

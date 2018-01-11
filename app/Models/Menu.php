<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use App\Models\base\TreeModel;

/**
 * Class Menu
 * @package App\Models
 * @version January 10, 2018, 3:25 am UTC
 *
 * @property string id
 * @property string name
 * @property smallInteger type
 * @property string description
 * @property string url
 * @property string icon
 * @property integer lft
 * @property integer rgt
 */
class Menu extends TreeModel
{
    /**
     * Indicates if the IDs are auto-incrementing.
     * @var bool
     */
    public $incrementing = false;

    public $table = 'menu';

    public $children_name = 'children';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $appends = ['title', 'key', 'value', 'label', 'parent', 'edit_url', 'show_url', 'store_url', 'update_url', 'delete_url'];

    public $fillable = [
        'name',
        'type',
        'description',
        'url',
        'icon',
        'lft',
        'rgt',
        'type'
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
        'url' => 'string',
        'icon' => 'string',
        'lft' => 'integer',
        'rgt' => 'integer',
        'type' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|max:20',
        'url' => 'required',
        'icon' => 'required',
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
        return 'menus';
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
        return [
            "lft", "rgt"
        ];
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

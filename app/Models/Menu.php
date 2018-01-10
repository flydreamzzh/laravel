<?php

namespace App\Models;

use App\Models\base\Model;
use App\Models\base\TreeModel;

/**
 * Class Menu
 * @package App\Models
 * @version September 8, 2017, 3:49 am UTC
 *
 * @method static Menu find($id=null, $columns = array())
 * @method static Menu|\Illuminate\Database\Eloquent\Collection findOrFail($id, $columns = ['*'])
 * @property string name
 * @property string description
 * @property string url
 * @property string icon
 * @property integer lft
 * @property integer rgt
 * @property integer type
 */
class Menu extends TreeModel
{
    public $table = 'menu';

    public $children_name = 'children';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $appends = ['title', 'key', 'value', 'label', 'edit_url', 'show_url', 'store_url', 'update_url', 'delete_url'];

    public $fillable = [
        'name',
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
        'id' => 'integer',
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
        'name' => 'required|max:255',
        'url' => 'required',
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

}

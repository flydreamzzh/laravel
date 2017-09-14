<?php

namespace App\Models;

use App\Models\base\Model;

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
 */
class Menu extends Model
{

    public $table = 'menu';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';



    public $fillable = [
        'name',
        'description',
        'url',
        'icon',
        'lft',
        'rgt'
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
}
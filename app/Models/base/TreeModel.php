<?php

namespace App\Models\base;

use App\Models\Menu;
use App\Traits\TreeModel as Tree;

/**
 * @property string edit_url
 * @property string show_url
 */
abstract class TreeModel extends Tree
{
    /**
     * @var array
     */
    protected $appends = ['parent', 'edit_url', 'show_url', 'store_url', 'update_url', 'delete_url'];

    /**
     * 返回路由的名称
     * Example：Route::resource('menus', 'MenuController'); 中的menus
     * return ['menus'];
     * @return string
     */
    abstract public function route();

    public function getParentAttribute()
    {
        /** @var Menu $parent */
        $parent = $this->exists ? $this->tree_directlyParent() : null;
        return $parent ? $parent->id : null;
    }

    public function getShowUrlAttribute()
    {
        $route = $this->route();
        return route("$route.show", ['id' => $this->{$this->primaryKey}]);
    }

    public function getEditUrlAttribute()
    {
        $route = $this->route();
        return route("$route.edit", ['id' => $this->{$this->primaryKey}]);
    }

    public function getStoreUrlAttribute()
    {
        $route = $this->route();
        return route("$route.store");
    }

    public function getUpdateUrlAttribute()
    {
        $route = $this->route();
        return route("$route.update", ['id' => $this->{$this->primaryKey}]);
    }

    public function getDeleteUrlAttribute()
    {
        $route = $this->route();
        return route("$route.destroy", ['id' => $this->{$this->primaryKey}]);
    }

}

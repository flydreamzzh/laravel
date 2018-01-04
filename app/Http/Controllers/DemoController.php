<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class DemoController extends Controller
{
    //
    public function index()
    {
//        $menu = Menu::find(4);
//        var_dump($menu->tree()->tree_setTopNode());
        return $this->test2();
    }

    public function test()
    {
        $menu = Menu::find(4);
        $model = new Menu();
        $model->name = 'asd';
        $model->url = 'dsa';
        $model->icon = 'das';
        var_dump($menu->tree_addChild($model));
    }

    public function test1()
    {
        $menu = Menu::find(19);
        $menu1 = Menu::find(18);
        var_dump(Menu::tree_array($menu1->tree_list()));
    }

    public function test2()
    {
        $menu = Menu::find(18);
        $menu1 = Menu::find(18);
//        var_dump($menu->tree_array($menu->tree_list()));
        var_dump($menu->tree_array($menu->tree_children()));
    }
}

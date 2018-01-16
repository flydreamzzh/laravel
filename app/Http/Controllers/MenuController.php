<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use App\Models\Menu;
use App\Repositories\MenuRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class MenuController extends AppBaseController
{
    /** @var  MenuRepository */
    private $menuRepository;

    public function __construct(MenuRepository $menuRepo)
    {
        $this->menuRepository = $menuRepo;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the Menu.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->menuRepository->pushCriteria(new RequestCriteria($request));
        $menus = $this->menuRepository->all();

        return view('menus.index')
            ->with('menus', $menus);
    }

    public function table(Request $request)
    {
        $menus = Menu::tree_array((new Menu())->tree_list());

//        $this->menuRepository->pushCriteria(new RequestCriteria($request));
//
//        $menus = $this->menuRepository->all()->toArray();

        return json_encode($menus, true);
    }

    public function parentList(Request $request)
    {
        $id = $request->get('id');
        $menus = Menu::tree_array((new Menu())->tree_where(function ($query) {
            $query->where(['type' => 0]);
        })->tree_list([$id]));

        return json_encode($menus, true);
    }

    /**
     * Show the form for creating a new Menu.
     *
     * @return Response
     */
    public function create()
    {
        $menu = new Menu();
        return view('menus.create')->with('menu', $menu);
    }

    /**
     * Store a newly created Menu in storage.
     *
     * @param CreateMenuRequest $request
     *
     * @return Response
     */
    public function store(CreateMenuRequest $request)
    {
        $input = $request->all();

        $menu = new Menu();
        $menu->fill($input);
        $parent = $this->menuRepository->findWithoutFail($input['parent']);

        if ($menu->tree_addNode($parent)) {
            return $this->sendResponse($menu->toArray(), '节点添加成功！');
        }
        return $this->sendError('节点添加失败！');
    }

    /**
     * Display the specified Menu.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $menu = $this->menuRepository->findWithoutFail($id);

        if (empty($menu)) {
            Flash::error('Menu not found');

            return redirect(route('menus.index'));
        }

        return view('menus.show')->with('menu', $menu);
    }

    /**
     * Show the form for editing the specified Menu.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $menu = $this->menuRepository->findWithoutFail($id);

        if (empty($menu)) {
            Flash::error('Menu not found');

            return redirect(route('menus.index'));
        }

        return view('menus.edit')->with('menu', $menu);
    }

    /**
     * Update the specified Menu in storage.
     *
     * @param  int              $id
     * @param UpdateMenuRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMenuRequest $request)
    {
        $menu = $this->menuRepository->findWithoutFail($id);

        if (empty($menu)) {
            return response()->json([false, '节点不存在！']);
        }

        /** @var Menu $menu */
        $menu = $this->menuRepository->update($request->all(), $id);

        $parent_id = $request->get('parent');
        /** @var Menu $parent */
        $parent = $menu->tree_directlyParent();
        if ($parent_id !== ($parent ? $parent->id : null)) {
            if ($parent_id) {
                $newParent = Menu::findOrFail($parent_id);
                if ($newParent)
                    $menu->tree_moveNode($newParent);
            } else {
                $menu->tree_setTopNode();
            }
        }

        return $this->sendResponse($menu->toArray(), '节点更新成功！');
    }

    public function moveUp(Request $request)
    {
        $id = $request->get('id');
        $menu = $this->menuRepository->findWithoutFail($id);
        if (! $menu->tree_moveUp()) {
            return $this->sendError('菜单更新失败！');
        }
        return $this->sendResponse($menu, '菜单上移成功！');
    }

    public function moveDown(Request $request)
    {
        $id = $request->get('id');
        $menu = $this->menuRepository->findWithoutFail($id);
        if (! $menu->tree_moveDown()) {
            return $this->sendError('菜单更新失败！');
        }
        return $this->sendResponse($menu, '菜单下移成功！');
    }

    /**
     * Remove the specified Menu from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $menu = $this->menuRepository->findWithoutFail($id);
//        return $this->sendError('菜单删除失败！');
        if (empty($menu)) {
            return $this->sendError('菜单不存在！');
        }

        if (! $menu->tree_remove()) {
            return $this->sendError('菜单删除失败！');
        }
        return $this->sendResponse($menu, '菜单移除成功！');

    }
}

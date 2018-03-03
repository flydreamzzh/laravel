<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAuthPermissionRequest;
use App\Http\Requests\UpdateAuthPermissionRequest;
use App\Models\AuthPermission;
use App\Repositories\AuthPermissionRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class AuthPermissionController extends AppBaseController
{
    /** @var  AuthPermissionRepository */
    private $authPermissionRepository;

    public function __construct(AuthPermissionRepository $authPermissionRepo)
    {
        $this->authPermissionRepository = $authPermissionRepo;
    }

    /**
     * Display a listing of the AuthPermission.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        return view('auth_permissions.index');
    }

    /**
     * 某节点的权限配置界面
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function menuPermissions(Request $request)
    {
        if ($menu_id = $request->get('menu')) {
            return view('auth_permissions.menu_permissions')->with('menu_id', $menu_id);
        } else {
            return view('global.params_lost');
        }
    }

    /**
     * 某节点的所有权限
     * @param Request $request
     * @return string
     */
    public function permissions(Request $request)
    {
        $this->authPermissionRepository->pushCriteria(new RequestCriteria($request));
        $authPermissions = $this->authPermissionRepository->search($request->all())->toArray();
        return json_encode(array_merge($authPermissions, [ 'count' => $authPermissions['total'], 'code' => 0]), true);
    }

    /**
     * Show the form for creating a new AuthPermission.
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        if ($menu_id = $request->get('menu')) {
            $authPermission = new AuthPermission();
            return view('auth_permissions.create')
                ->with('authPermission', $authPermission)
                ->with('menu_id', $menu_id);
        } else {
            return view('global.params_lost');
        }
    }

    /**
     * Store a newly created AuthPermission in storage.
     *
     * @param CreateAuthPermissionRequest $request
     *
     * @return Response
     */
    public function store(CreateAuthPermissionRequest $request)
    {
        $input = $request->all();

        if ( $authPermission = $this->authPermissionRepository->create($input)) {
            return $this->sendResponse($authPermission->toArray(), '权限添加成功！');
        }
        return $this->sendError('权限添加失败！');
    }

    /**
     * Display the specified AuthPermission.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $authPermission = $this->authPermissionRepository->findWithoutFail($id);

        if (empty($authPermission)) {
            Flash::error('Auth Permission not found');

            return redirect(route('authPermissions.index'));
        }

        return view('auth_permissions.show')->with('authPermission', $authPermission);
    }

    /**
     * Show the form for editing the specified AuthPermission.
     *
     * @param  int $id
     * @param Request $request
     * @return Response
     */
    public function edit($id, Request $request)
    {
        if ($menu_id = $request->get('menu')) {
            $authPermission = $this->authPermissionRepository->findWithoutFail($id);
            return view('auth_permissions.edit')
                ->with('authPermission', $authPermission)
                ->with('menu_id', $menu_id);
        } else {
            return view('global.params_lost');
        }
    }

    /**
     * Update the specified AuthPermission in storage.
     *
     * @param  int              $id
     * @param UpdateAuthPermissionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAuthPermissionRequest $request)
    {
        $authPermission = $this->authPermissionRepository->findWithoutFail($id);

        if (empty($authPermission)) {
            return $this->sendError('权限不存在！');
        }

        $authPermission = $this->authPermissionRepository->update($request->all(), $id);

        return $this->sendResponse($authPermission->toArray(), '权限更新成功');
    }

    /**
     * Remove the specified AuthPermission from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $authPermission = $this->authPermissionRepository->findWithoutFail($id);

        if (empty($authPermission)) {
            Flash::error('Auth Permission not found');

            return redirect(route('authPermissions.index'));
        }

        $this->authPermissionRepository->delete($id);

        Flash::success('Auth Permission deleted successfully.');

        return redirect(route('authPermissions.index'));
    }
}

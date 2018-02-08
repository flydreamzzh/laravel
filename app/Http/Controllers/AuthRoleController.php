<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAuthRoleRequest;
use App\Http\Requests\UpdateAuthRoleRequest;
use App\Models\AuthRole;
use App\Repositories\AuthRoleRepository;
use Illuminate\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class AuthRoleController extends AppBaseController
{
    /** @var  AuthRoleRepository */
    private $authRoleRepository;

    public function __construct(AuthRoleRepository $authRoleRepo)
    {
        $this->authRoleRepository = $authRoleRepo;
    }

    /**
     * Display a listing of the AuthRole.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->authRoleRepository->pushCriteria(new RequestCriteria($request));
        $authRoles = $this->authRoleRepository->all();

        return view('auth_roles.index')
            ->with('authRoles', $authRoles);
    }

    public function table(Request $request)
    {
        $roles = AuthRole::tree_array((new AuthRole())->tree_list());

        $roles = array_merge([
            ['id' => 'ALL', 'label' => '全部用户', 'title' => '<span class="text-info">全部用户</span>', 'active' => true],
            ['id' => 'NONE', 'label' => '暂无角色', 'title' => '<span class="text-warning">暂无角色</span>'],
        ], $roles);
        return json_encode($roles, true);
    }

    public function lists()
    {
        $roles = AuthRole::tree_array((new AuthRole())->tree_list());
        return json_encode($roles, true);
    }



    /**
     * Show the form for creating a new AuthRole.
     *
     * @return Response
     */
    public function create()
    {
        return view('auth_roles.create');
    }

    /**
     * Store a newly created AuthRole in storage.
     *
     * @param CreateAuthRoleRequest $request
     *
     * @return Response
     */
    public function store(CreateAuthRoleRequest $request)
    {
        $input = $request->all();

        $authRole = $this->authRoleRepository->create($input);

        return redirect(route('authRoles.index'));
    }

    /**
     * Display the specified AuthRole.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $authRole = $this->authRoleRepository->findWithoutFail($id);

        if (empty($authRole)) {

            return redirect(route('authRoles.index'));
        }

        return view('auth_roles.show')->with('authRole', $authRole);
    }

    /**
     * Show the form for editing the specified AuthRole.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $authRole = $this->authRoleRepository->findWithoutFail($id);

        if (empty($authRole)) {

            return redirect(route('authRoles.index'));
        }

        return view('auth_roles.edit')->with('authRole', $authRole);
    }

    /**
     * Update the specified AuthRole in storage.
     *
     * @param  int              $id
     * @param UpdateAuthRoleRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAuthRoleRequest $request)
    {
        $authRole = $this->authRoleRepository->findWithoutFail($id);

        if (empty($authRole)) {
            return redirect(route('authRoles.index'));
        }

        $authRole = $this->authRoleRepository->update($request->all(), $id);

        return redirect(route('authRoles.index'));
    }

    /**
     * Remove the specified AuthRole from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $authRole = $this->authRoleRepository->findWithoutFail($id);

        if (empty($authRole)) {

            return redirect(route('authRoles.index'));
        }

        $this->authRoleRepository->delete($id);

        return redirect(route('authRoles.index'));
    }
}

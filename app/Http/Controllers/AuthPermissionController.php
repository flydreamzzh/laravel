<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAuthPermissionRequest;
use App\Http\Requests\UpdateAuthPermissionRequest;
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
        $this->authPermissionRepository->pushCriteria(new RequestCriteria($request));
        $authPermissions = $this->authPermissionRepository->all();

        return view('auth_permissions.index')
            ->with('authPermissions', $authPermissions);
    }

    public function menuPermissions(Request $request)
    {
        return view('auth_permissions.menu_permissions');
    }

    public function permissions(Request $request)
    {
        $this->authPermissionRepository->pushCriteria(new RequestCriteria($request));
        $authPermissions = $this->authPermissionRepository->paginate($request->get('limit'))->toArray();
        return json_encode(array_merge($authPermissions, [ 'count' => $authPermissions['total'], 'code' => 0]), true);
    }

    /**
     * Show the form for creating a new AuthPermission.
     *
     * @return Response
     */
    public function create()
    {
        return view('auth_permissions.create');
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

        $authPermission = $this->authPermissionRepository->create($input);

        Flash::success('Auth Permission saved successfully.');

        return redirect(route('authPermissions.index'));
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
     *
     * @return Response
     */
    public function edit($id)
    {
        $authPermission = $this->authPermissionRepository->findWithoutFail($id);

        if (empty($authPermission)) {
            Flash::error('Auth Permission not found');

            return redirect(route('authPermissions.index'));
        }

        return view('auth_permissions.edit')->with('authPermission', $authPermission);
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
            Flash::error('Auth Permission not found');

            return redirect(route('authPermissions.index'));
        }

        $authPermission = $this->authPermissionRepository->update($request->all(), $id);

        Flash::success('Auth Permission updated successfully.');

        return redirect(route('authPermissions.index'));
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

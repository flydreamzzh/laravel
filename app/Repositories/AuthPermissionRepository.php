<?php

namespace App\Repositories;

use App\Models\AuthRolePermission;
use DB;
use App\Models\AuthPermission;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AuthPermissionRepository
 * @package App\Repositories
 * @version March 3, 2018, 12:52 pm UTC
 *
 * @method AuthPermission findWithoutFail($id, $columns = ['*'])
 * @method AuthPermission find($id, $columns = ['*'])
 * @method AuthPermission first($columns = ['*'])
*/
class AuthPermissionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'route_name',
        'status',
        'menu_id',
        'description'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return AuthPermission::class;
    }

    /**
     * 保存角色权限
     * @param string $role_id
     * @param array $permissionIds
     * @return bool
     */
    public function savePermissions($role_id, $permissionIds)
    {
        DB::beginTransaction();
        try {
            if (! AuthRolePermission::where('role_id', $role_id)->count() || AuthRolePermission::where('role_id', $role_id)->delete()) {
                $data = [];
                foreach ($permissionIds  as $permissionId) {
                    $data[] = array_combine(['role_id', 'permission_id'], [$role_id, $permissionId]);
                }
                if ($data) {
                    if (! AuthRolePermission::insert($data)) {
                        DB::rollBack();
                        return false;
                    }
                }
                DB::commit();
                return true;
            }
            DB::rollBack();
            return false;
        } catch (\Exception $e) {
            var_dump($e->getMessage());exit();
            DB::rollBack();
            return false;
        }
    }

    /**
     * @param array $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search($params = [])
    {
        $model = new AuthPermission();
        $model->fill($params);
        $data = $this->model->where('menu_id', $model->menu_id)->paginate($params['limit']);
        return $data;
    }
}

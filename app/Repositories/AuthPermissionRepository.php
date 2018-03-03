<?php

namespace App\Repositories;

use App\Models\AuthPermission;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AuthPermissionRepository
 * @package App\Repositories
 * @version March 1, 2018, 11:07 am UTC
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
        'route',
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
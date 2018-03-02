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
}

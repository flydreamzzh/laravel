<?php

namespace App\Repositories;

use App\Models\AuthRoles;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AuthRolesRepository
 * @package App\Repositories
 * @version February 2, 2018, 3:48 am UTC
 *
 * @method AuthRoles findWithoutFail($id, $columns = ['*'])
 * @method AuthRoles find($id, $columns = ['*'])
 * @method AuthRoles first($columns = ['*'])
*/
class AuthRolesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description',
        'lft',
        'rgt'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return AuthRoles::class;
    }
}

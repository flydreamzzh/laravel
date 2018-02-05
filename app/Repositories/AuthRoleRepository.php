<?php

namespace App\Repositories;

use App\Models\AuthRole;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AuthRoleRepository
 * @package App\Repositories
 * @version February 2, 2018, 7:51 am UTC
 *
 * @method AuthRole findWithoutFail($id, $columns = ['*'])
 * @method AuthRole find($id, $columns = ['*'])
 * @method AuthRole first($columns = ['*'])
*/
class AuthRoleRepository extends BaseRepository
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
        return AuthRole::class;
    }
}

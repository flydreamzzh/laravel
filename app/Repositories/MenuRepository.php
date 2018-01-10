<?php

namespace App\Repositories;

use App\Models\Menu;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class MenuRepository
 * @package App\Repositories
 * @version January 10, 2018, 3:48 am UTC
 *
 * @method Menu findWithoutFail($id, $columns = ['*'])
 * @method Menu find($id, $columns = ['*'])
 * @method Menu first($columns = ['*'])
*/
class MenuRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'type',
        'description',
        'url',
        'icon',
        'lft',
        'rgt'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Menu::class;
    }
}

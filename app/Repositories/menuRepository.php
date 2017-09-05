<?php

namespace App\Repositories;

use App\Models\menu;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class menuRepository
 * @package App\Repositories
 * @version August 29, 2017, 4:12 pm UTC
 *
 * @method menu findWithoutFail($id, $columns = ['*'])
 * @method menu find($id, $columns = ['*'])
 * @method menu first($columns = ['*'])
*/
class menuRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
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
        return menu::class;
    }
}

<?php

namespace App\Repositories;

use App\Models\AuthRole;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class UserRepository
 * @package App\Repositories
 * @version January 18, 2018, 9:33 am UTC
 *
 * @method User findWithoutFail($id, $columns = ['*'])
 * @method User find($id, $columns = ['*'])
 * @method User first($columns = ['*'])
*/
class UserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'email',
        'password',
        'remember_token'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return User::class;
    }

    /**
     * @param array $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search($params = [])
    {
        $model = new User();
        $model->fill($params);
        $query =  $this->model->select(['users.*']);
        if (isset($params['role_id']) && $params['role_id'] !== 'ALL') {
            if ($params['role_id'] == 'NONE') {
                $query = $query->whereNotExists(function (Builder $query) {
                    $query->select(DB::raw(1))
                        ->from('user_role')
                        ->whereRaw('user_role.user_id = users.id');
                });
            } else {
                $query = $query
                    ->leftJoin('user_role', 'user_role.user_id', '=', 'users.id')
                    ->where('user_role.role_id', '=', $params['role_id']);
            }
        }
        $data = $query->where('name', 'like', "%".$model->name.'%')->paginate($params['limit']);
        return $data;
    }
}

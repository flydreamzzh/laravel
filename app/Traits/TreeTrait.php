<?php
namespace App\Traits;

use Closure;
use DB;
use Eloquent;
use Exception;

/**
 * 建立带左右值的无限归类树
 * class company{
 *      use TreeTrait;
 *      public function setLeftAndRightColumn()
 *      {
 *          return ["lft", "rgt"];
 *      }
 *      public function preCondition()
 *      {
 *           //这个只用来区分多套树， 谨记！！！！！！！！！！！！！！！！！！！！！！！！！！！！
 *           return function ($query){};
 *      }
 * }
 *
 * use Example:
 *  $obj->tree()->.....
 * 
 * 重要提示：重要提示：重要提示：重要提示：重要提示：重要提示：重要提示：重要提示：重要提示：重要提示：重要提示：重要提示：
 *
 *      对表进行操作时，建议不要使用tree_where进行筛选，否则可能对表对左右值有影响， 谨记！！！！！！！！！！！！！！！！！！！！！！！！！！！！
 *
 *      建议表中使用一套树，即不存在相同的左右值
 *      若要使用多套树，那么请谨慎使用过滤条件，并需要修改tree_getMinLeftAndMaxRight方法，取注释的内容
 * @author Administrator
 *        
 */
trait TreeTrait
{
    /**
     * 查询条件
     * @var \Illuminate\Database\Query\Builder $query
     */
    private $query;

    /**
     * 前置查询条件(整个过程都要使用)
     * @var \Illuminate\Database\Query\Builder $preQuery
     */
    private $preQuery;

    /**
     * 左值字段名
     * 
     * @var string
     */
    private $left;

    /**
     * 右值字段名
     * 
     * @var string
     */
    private $right;

    /**
     * 前置查询条件
     *
     * @var string
     */
    private $preCondition = '';
    
    /**
     * 默认数据表最小左值
     * @var number 
     */
    private $minLeft = 0;
    
    /**
     * 节点子类对象树
     * @var array
     */
    public $tree_children;

    /**
     * 初始化类数据库字段信息
     * @throws Exception
     * @return $this
     */
    public function tree()
    {
        $this->query = $this->newQuery();
        $this->preQuery = $this->newQuery();
        $lr = $this->setLeftAndRightColumn();
        $this->dealPreCondition();
        if (is_array($lr) && count($lr) == 2) {
            $this->left = min($lr);
            $this->right = max($lr);
        } else {
            throw new Exception("无限分类树左右值字段名称配置失败");
        }
        return $this;
    }

    /**
     * example：
     * return ["lft", "rgt"];
     * 设置数据表左右值字段名
     *
     * @return array
     */
    abstract public function setLeftAndRightColumn();

    private function dealPreCondition()
    {
        call_user_func($this->preCondition(), $query = $this->preQuery);
    }

    /**
     * 无限分类树数据表前置查询条件(建议此内容主要是用于区分多套树的查询条件)
     * @return Closure
     */
    protected function preCondition()
    {
        return function ($query){};
    }

    /**
     * @param Closure $closure
     * @return $this
     */
    public function tree_where(Closure $closure)
    {
        call_user_func($closure, $query = $this->query);
        return $this;
    }

    /**
     * Example：
     * return [0,10];
     * 获取当前对象的左右值数组
     * @param Eloquent $model 需要查询的节点对象(不填就是当前对象)
     * @return array
     * @throws Exception
     */
    public function tree_getLeftAndRight($model = NULL)
    {
        if (! $model) {
            if ($this->exists) {
                $left = $this->{$this->left};
                $right = $this->{$this->right};
            } else {
                throw new Exception("查询对象必须在已存在");
            }
        } else {
            if ($model->exists) {
                $left = $model->{$this->left};
                $right = $model->{$this->right};
            } else {
                throw new Exception("查询对象必须在已存在");
            }
        }
        if (is_numeric($left) && is_numeric($right) && $left != $right) {
            return [$left, $right];
        } else {
            throw new Exception("当前对象左右值数据异常");
        }
    }

    /**
     * Example：
     * return [0,100];
     * 获取当前数据表的最小左值和最大右值
     * @return array|null
     * @throws Exception
     */
    public function tree_getMinLeftAndMaxRight()
    {
        $left = DB::table($this->table)->addNestedWhereQuery($this->preQuery->getQuery())->min($this->left);
        $right = DB::table($this->table)->addNestedWhereQuery($this->preQuery->getQuery())->max($this->right);
//        $left = DB::table($this->table)->min($this->left);
//        $right = DB::table($this->table)->max($this->right);
        if(is_numeric($left) && is_numeric($right)) {
            return [(int)$left, (int)$right];
        } else {
            return [-1, 0];//左右值从1开始
        }
    }

    /**
     * 将当前对象（不论新旧）设置为顶级节点
     *
     * @return boolean
     */
    public function tree_setTopNode()
    {
        $mlr = $this->tree_getMinLeftAndMaxRight();
        $right = ! $mlr ? $this->minLeft : max($mlr) + 1;
        if (! $this->exists) {
            DB::beginTransaction();
            DB::table($this->table)->lockForUpdate()->get();
            try {
                $this->{$this->left} = $right;
                $this->{$this->right} = $right + 1;
                if ($this->save()) {
                    DB::commit();
                    return true;
                }
                DB::rollBack();
                return false;
            } catch (Exception $e) {
                DB::rollBack();
                return false;
            }

        } else {
            if ($this->tree_isTopNode())
                return true;
            DB::beginTransaction();
            DB::table($this->table)->lockForUpdate()->get();
            try {
                $lr = $this->tree_getLeftAndRight();
                $dif = $mlr[1] - $lr[0] + 1;
                $len = DB::table($this->table)
                    ->where($this->left, '>=', min($lr))
                    ->where($this->right, '<=', max($lr))
                    ->addNestedWhereQuery($this->preQuery->getQuery())
                    ->update([
                        $this->left => DB::raw("$this->left + $dif"),
                        $this->right => DB::raw("$this->right + $dif"),
                    ]);
                DB::commit();
                return $len;
            } catch (Exception $e) {
                DB::rollBack();
                return false;
            }
        }
    }

    /**
     * 添加当前节点到某父节点 或 为顶级节点
     * @param Eloquent $parent
     * @return bool
     */
    public function tree_addNode($parent = null)
    {
        DB::beginTransaction();
        DB::table($this->table)->lockForUpdate()->get();
        try {
            if ($parent && $parent->exists) {
                $lr = $parent->tree()->tree_getLeftAndRight();
                $lefts = DB::table($this->table)->where($this->left, '>', max($lr))->addNestedWhereQuery($this->preQuery->getQuery())->increment($this->left, 2);
                $rights = DB::table($this->table)->where($this->right, '>=', max($lr))->addNestedWhereQuery($this->preQuery->getQuery())->increment($this->right, 2);
                if($lefts || $rights) {
                    $this->{$this->left} = max($lr);
                    $this->{$this->right} = max($lr) + 1;
                    if ($this->save()) {
                        DB::commit();
                        return true;
                    }
                }
            } else {
                $lr = $this->tree_getMinLeftAndMaxRight();
                $this->{$this->left} = max($lr) + 1;
                $this->{$this->right} = max($lr) + 2;
                if ($this->save()) {
                    DB::commit();
                    return true;
                }
            }
            DB::rollBack();
            return false;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }

    }

    /**
     * 为当前节点添加子节点
     * @param Eloquent $model
     * @return Eloquent | boolean
     */
    public function tree_addChild($model)
    {
        if (! $model->exists) {
            DB::beginTransaction();
            DB::table($this->table)->lockForUpdate()->get();
            try {
                $lr = $this->tree_getLeftAndRight();
                $lefts = DB::table($this->table)->where($this->left, '>', max($lr))->addNestedWhereQuery($this->preQuery->getQuery())->increment($this->left, 2);
                $rights = DB::table($this->table)->where($this->right, '>=', max($lr))->addNestedWhereQuery($this->preQuery->getQuery())->increment($this->right, 2);

                if($lefts || $rights) {
                    $model->{$this->left} = max($lr);
                    $model->{$this->right} = max($lr) + 1;
                    if ($model->save()) {
                        DB::commit();
                        return $model;
                    }
                }
                DB::rollBack();
                return false;
            } catch (Exception $e) {
                DB::rollBack();
                return false;
            }
        }
        return false;
    }

    /**
     * 移除当前节点以及其子节点
     * @param Eloquent $model 要处理的节点对象(不填就是当前对象)
     * @return integer 返回受影响的行数
     */
    public function tree_remove($model = NULL)
    {
        $lr = $this->tree_getLeftAndRight($model);
        $len = DB::table($this->table)
            ->where($this->left, '>=', min($lr))
            ->where($this->right, '<=', max($lr))
            ->addNestedWhereQuery($this->preQuery->getQuery())
            ->delete();
        return $len;
    }

    /**
     * 移除当前节点的所有子节点点
     * @param Eloquent $model 要处理的节点对象(不填就是当前对象)
     * @return integer 返回受影响的行数
     */
    public function tree_removeChildren($model = NULL)
    {
        $lr = $this->tree_getLeftAndRight($model);
        $len = DB::table($this->table)
            ->where($this->left, '>', min($lr))
            ->where($this->right, '<', max($lr))
            ->addNestedWhereQuery($this->preQuery->getQuery())
            ->delete();
        return $len;
    }

    /**
     * 将当前节点移动的某节点下
     * @param Eloquent $parent 父节点
     * @return boolean
     */
    public function tree_moveNode($parent)
    {
        if ($this->tree_isDirectlyParent($parent))
            return false;
        DB::beginTransaction();
        DB::table($this->table)->lockForUpdate()->get();
        try {
            $lr = $this->tree_getLeftAndRight();
            $plr = $this->tree_getLeftAndRight($parent);
            $dif = max($lr) - min($lr) + 1; //当前对象的 右值 - 左值
            $pdif = min($lr) - max($plr); //当前对象的 左值 - 准父类的 右值
            /** @var array $models 要移动更新的行主键 */
            $models = DB::table($this->table)->select(['id'=>$this->primaryKey])
                ->where($this->left, '>=', min($lr))
                ->where($this->right, '<=', max($lr))
                ->addNestedWhereQuery($this->preQuery->getQuery())
                ->get();
            $ids = array_pluck($models, 'id');

            /** @var array $leftmodels 要更新左值的行主键（未去除要移动的行主键）*/
            $leftmodels = DB::table($this->table)->select(['id'=>$this->primaryKey])
                ->where($this->left, '>', max($plr))
                ->addNestedWhereQuery($this->preQuery->getQuery())
                ->get();
            $leftIds = array_pluck($leftmodels, 'id');

            /** @var array $rightmodels 要更新右值的行主键（未去除要移动的行主键）*/
            $rightmodels = DB::table($this->table)->select(['id'=>$this->primaryKey])
                ->where($this->right, '>=', max($plr))
                ->addNestedWhereQuery($this->preQuery->getQuery())
                ->get();
            $rightIds = array_pluck($rightmodels, 'id');

            $updatelefts = DB::table($this->table)->whereIn($this->primaryKey, array_diff($leftIds, $ids))->increment($this->left, $dif);
            $updaterights = DB::table($this->table)->whereIn($this->primaryKey, array_diff($rightIds, $ids))->increment($this->right, $dif);
            $updatemodels =DB::table($this->table)->whereIn($this->primaryKey, $ids)->update([
                $this->left => DB::raw("$this->left - $pdif"),
                $this->right => DB::raw("$this->right - $pdif"),
            ]);
            if($updatelefts == count(array_diff($leftIds, $ids)) && $updaterights == count(array_diff($rightIds, $ids)) && $updatemodels == count($ids)) {
                DB::commit();
                return true;
            }
            DB::rollBack();
            return false;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }

    }

    /**
     * 同父同级节点进行    上移
     * @param Eloquent $model 被操作的对象（不填就是当前对象）
     * @return boolean
     */
    public function tree_moveUp($model = NULL)
    {
        $lr = $this->tree_getLeftAndRight($model);
        $brother = $this->tree_brother($model);
        $replace = null;
        foreach ($brother as $node) {
            /**  @var $node $this */
            $blr = $node->tree()->tree_getLeftAndRight();
            if (min($lr) <= min($blr))
                break;
            /** @var Eloquent $replace */
            $replace = $node;
        }
        return $this->tree_exchange($replace);
    }

    /**
     * 同父同级节点进行    下移
     * @param Eloquent $model 被操作的对象（不填就是当前对象）
     * @return bool
     */
    public function tree_moveDown($model = NULL)
    {
        $lr = $this->tree_getLeftAndRight($model);
        $brother = $this->tree_brother($model);
        $replace = null;
        foreach ($brother as $node) {
            /**  @var $node $this */
            $blr = $node->tree()->tree_getLeftAndRight();
            if (min($lr) < min($blr)) {
                /** @var Eloquent $replace */
                $replace = $node;
                break;
            }
        }
        return $this->tree_exchange($replace);
    }

    /**
     * 节点之间交换位置
     * @param Eloquent $exchangeModel 将被交换位置的节点
     * @param Eloquent $model 被操作的对象（不填就是当前对象）
     * @return boolean
     */
    public function tree_exchange($exchangeModel,$model = NULL)
    {
        $lr = $this->tree_getLeftAndRight($model);
        if ($exchangeModel) {
            DB::beginTransaction();
            DB::table($this->table)->lockForUpdate()->get();
            try {
                /** @var $exchangeModel $this */
                $rlr = $exchangeModel->tree()->tree_getLeftAndRight();

                /** @var array $models 互换的节点（一） */
                $models = DB::table($this->table)->select(['id'=>$this->primaryKey])
                    ->where($this->left, '>=', min($lr))
                    ->where($this->right, '<=', max($lr))
                    ->get();
                $ids = array_pluck($models, 'id');

                /** @var array $midModels 中间的节点） */
                $midRL = max($lr) < max($rlr) ? [max($lr) + 1, min($rlr) - 1] : [max($rlr) + 1, min($lr) - 1];
                $midModels = DB::table($this->table)->select(['id'=>$this->primaryKey])
                    ->where($this->left, '>=', min($midRL))
                    ->where($this->right, '<=', max($midRL))
                    ->get();
                $midIds = array_pluck($midModels, 'id');

                /** @var array $exModels 互换的节点（二） */
                $exModels = DB::table($this->table)->select(['id'=>$this->primaryKey])
                    ->where($this->left, '>=', min($rlr))
                    ->where($this->right, '<=', max($rlr))
                    ->get();
                $exIds = array_pluck($exModels, 'id');

                $len = max($rlr)-max($lr);
                $updateOne = DB::table($this->table)->whereIn($this->primaryKey, $ids)->update([
                    $this->left => DB::raw("$this->left + $len"),
                    $this->right => DB::raw("$this->right + $len"),
                ]);

                $mlen = (max($rlr)-min($rlr)) - (max($lr)-min($lr));
                $updateMiddle = DB::table($this->table)->whereIn($this->primaryKey, $midIds)->update([
                    $this->left => DB::raw("$this->left + $mlen"),
                    $this->right => DB::raw("$this->right + $mlen"),
                ]);

                $rlen = min($lr) - min($rlr);
                $updateTwo = DB::table($this->table)->whereIn($this->primaryKey, $exIds)->update([
                    $this->left => DB::raw("$this->left + $rlen"),
                    $this->right => DB::raw("$this->right + $rlen"),
                ]);

                if($updateOne == count($ids) && $updateMiddle == count($midIds) && $updateTwo == count($exIds)) {
                    DB::commit();
                    return true;
                }
                DB::rollBack();
                return false;
            } catch (Exception $e) {
                DB::rollBack();
                return false;
            }
        }
        return true;
    }

    /**
     * 获取顶级节点
     * @return Eloquent[]|[]
     */
    public function tree_TopNodes()
    {
        $lr = $this->tree_getMinLeftAndMaxRight();
        if ($lr == null)
            return [];

        $models = $this
            ->where($this->left, '>', min($lr)-1)
            ->where($this->right, '<', max($lr)+1)
            ->addNestedWhereQuery($this->preQuery->getQuery())
            ->addNestedWhereQuery($this->query->getQuery())
            ->orderBy($this->left)
            ->get();

        $directlyChildren = [];
        foreach ($models as $node) {
            /**  @var $node $this */
            if (! $node->tree()->tree_directlyParent()) {
                $node->query = $this->query;
                $node->preQuery = $this->preQuery;
                $directlyChildren[] = $node;
            }
        }
        return $directlyChildren;
    }

    /**
     * 获取当前对象的直系父节点
     * @param Eloquent $model 要查询节点的对象(不填就是当前对象)
     * @return Eloquent|null
     */
    public function tree_directlyParent($model = NULL)
    {
        $lr = $this->tree_getLeftAndRight($model);

        $parent = $this
            ->where($this->left, '<', min($lr))
            ->where($this->right, '>', max($lr))
            ->addNestedWhereQuery($this->preQuery->getQuery())
            ->orderBy($this->left, 'desc')
            ->first();
        return $parent ? $parent : null;
    }

    /**
     * 获取当前对象的同级（兄弟）节点
     * @param Eloquent $model 需要查询的节点对象(不填就是当前对象)
     * @return [Eloquent]
     */
    public function tree_brother($model = NULL)
    {
        $lr = $this->tree_getLeftAndRight($model);
        $parentModel = $this->tree_directlyParent($model);
        if (! $parentModel) {
            $models = $this->tree_TopNodes();
        } else {
            /**  @var $parentModel $this */
            $models = $parentModel->tree()->tree_directlyChildren();
        }
        foreach ($models as $key => $node) {
            $blr = $this->tree_getLeftAndRight($node);
            if(min($lr) == min($blr) && max($lr) == max($blr)) {
                unset($models[$key]);
                break;
            }
        }
        return $models;
    }

    /**
     * 获取当前对象的直系子节点
     * @param Eloquent $model 需要查询的节点对象(不填就是当前对象)
     * @return [Eloquent]
     */
    public function tree_directlyChildren($model = NULL)
    {
        $directlyChildren = [];
        $lr = $this->tree_getLeftAndRight($model);
        $models = $this
            ->where($this->left, '>', min($lr))
            ->where($this->right, '<', max($lr))
            ->addNestedWhereQuery($this->preQuery->getQuery())
            ->addNestedWhereQuery($this->query->getQuery())
            ->orderBy($this->left)
            ->get();
        foreach ($models as $node) {
            /**  @var $node $this */
            if ($node->tree()->tree_isDirectlyParent($this)) {
                $node->query = $this->query;
                $node->preQuery = $this->preQuery;
                $directlyChildren[] = $node;
            }
        }
        return $directlyChildren;
    }

    /**
     * 获取当前节点对象的所有子节点树
     * @param Eloquent $model 需要查询的节点(不填就是当前对象)
     * @param array $except 移除项主键
     * @return Eloquent
     * 返回信息中使用$model->tree_children即可
     */
    public function tree_children($model = NULL, $except = [])
    {
        $model = $model ? $model->tree() : $this;
        $child = $model->tree_directlyChildren();
        foreach ($child as $key => $node) {
            /**  @var $node $this */
            if (! in_array($node->{$model->primaryKey}, $except)) {
                if (! $node->tree()->tree_isLastNode()) {
                    $node->tree()->tree_children();
                }
            } else {
                unset($child[$key]);
            }
        }
        if ($child) {
            $model->tree_children = array_values($child);
        }
        return $model;
    }

    /**
     * 获取整棵树
     * @param array $except 移除项主键
     * @return Eloquent[]
     */
    public function tree_list($except = [])
    {
        $topNodes = $this->tree_TopNodes();
        foreach ($topNodes as $key => $node) {
            /**  @var $node $this */
            if (! in_array($node->{$this->primaryKey}, $except)) {
                $node->tree()->tree_children(null, $except);
            } else {
                unset($topNodes[$key]);
            }
        }
        return array_values($topNodes);
    }

    /**
     * 判断当前对象是否     包含      某个对象
     * @param Eloquent $model
     * @return boolean
     */
    public function tree_isInclude($model)
    {
        $lr = $this->tree_getLeftAndRight();
        $clr = $this->tree_getLeftAndRight($model);
        if (min($lr) < min($clr) && max($lr) > max($clr)) {
            return true;
        }
        return false;
    }

    /**
     * 判断当前对象是否     被包含      某个对象
     * @param Eloquent $parentModel
     * @return boolean
     */
    public function tree_isBeInclude($parentModel)
    {
        $lr = $this->tree_getLeftAndRight();
        $plr = $this->tree_getLeftAndRight($parentModel);
        if (min($lr) > min($plr) && max($lr) < max($plr)) {
            return true;
        }
        return false;
    }

    /**
     * 判断当前节点的父节点是否为选定的节点
     * @param Eloquent $parentModel 父节点对象
     * @param Eloquent $model 需要判断的节点(不填就是当前对象)
     * @return boolean
     */
    public function tree_isDirectlyParent($parentModel, $model = NULL)
    {
        $pModel = $this->tree_directlyParent($model);
        if ($pModel) {
            $id = $pModel->{$this->primaryKey};
            $pid = $parentModel->{$this->primaryKey};
            return $id == $pid;
        }
        return false;
    }


    /**
     *  判断当前节点是否顶级节点
     * @param Eloquent $model 要查询的节点对象(不填就是当前对象)
     * @return boolean
     */
    public function tree_isTopNode($model = NULL)
    {
        $lr = $this->tree_getLeftAndRight($model);
        $len = DB::table($this->table)
            ->where($this->left,'<', min($lr))
            ->where($this->right,'>', max($lr))
            ->addNestedWhereQuery($this->preQuery->getQuery())
            ->count();
        return ! $len ? true : false;
    }

    /**
     * 当前节点的子节点数
     * @param Eloquent $model 要查询的节点对象(不填就是当前对象)
     * @return integer 返回子节点数
     */
    public function tree_num_children($model = NULL)
    {
        $lr = $this->tree_getLeftAndRight($model);
        $len = DB::table($this->table)
            ->where($this->left,'>', min($lr))
            ->where($this->right,'<', max($lr))
            ->addNestedWhereQuery($this->preQuery->getQuery())
            ->addNestedWhereQuery($this->query->getQuery())
            ->count();
        return $len;
    }

    /**
     * 判断当前节点是否最后一个节点
     * @param Eloquent $model 要查询的节点对象(不填就是当前对象)
     * @return boolean
     */
    public function tree_isLastNode($model = NULL)
    {
        return $this->tree_num_children($model) ? false : true;
    }

    /**
     * 将查找的数据换行成数组
     * @param Eloquent[] $models
     * @return array
     */
    public static function tree_array($models)
    {
        if (! $models)
            return $models;
        if (is_array($models)) {
            foreach ($models as $key => $model) {
                $models[$key] = self::tree_array($model);
            }
        } else {
            $children = $models->tree_children ? self::tree_array($models->tree_children) : [];
            $models = $models->toArray();
            if($children)
                $models['tree_children'] = $children;
        }
        return $models;
    }


}
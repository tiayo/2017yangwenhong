<?php

namespace App\Services\Manage;

use App\Repositories\CategoryRepository;
use Exception;
use Illuminate\Support\Facades\Auth;

class CategoryService
{
    protected $category;

    public function __construct(CategoryRepository $category)
    {
        $this->category = $category;
    }

    /**
     * 通过id验证记录是否存在以及是否有操作权限
     * 通过：返回该记录
     * 否则：抛错
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
     */
    public function validata($id)
    {
        $first = $this->category->first($id);

        throw_if(empty($first), Exception::class, '未找到该记录！', 404);

        throw_if(!can('control', $first), Exception::class, '没有权限！', 403);

        return $first;
    }

    /**
     * 获取需要的数据
     *
     * @param int $num
     * @param null $keyword
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function get($num = 10000, $business_id = null)
    {
        if (!empty($business_id)) {
            return $this->category->getSearch($num, $business_id);
        }

        return $this->category->get($num);
    }

    /**
     * 获取需要的数据(顶级栏目)
     *
     * @return mixed
     */
    public function getParent()
    {
        return $this->category->getParent();
    }

    /**
     * 获取需要的数据
     *
     * @param array ...$select
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getSimple(...$select)
    {
        return can('admin') ?
            $this->category->getSimple(...$select) :
            $this->category->getSimpleBusiness(...$select);
    }

    /**
     * 查找指定id的用户
     *
     * @param $id
     * @return mixed
     */
    public function first($id)
    {
        return $this->validata($id);
    }

    /**
     * 更新或编辑
     *
     * @param $post
     * @param null $id
     * @return mixed
     */
    public function updateOrCreate($post, $id = null)
    {
        //统计数据
        $data['name'] = $post['name'];
        $data['parent_id'] = can('admin') ? $post['parent_id'] : Auth::id();

        //执行插入或更新
        return empty($id) ? $this->category->create($data) : $this->category->update($id, $data);
    }

    /**
     * 删除管理员
     *
     * @param $id
     * @return bool|null
     */
    public function destroy($id)
    {
        //验证是否可以操作当前记录
        $this->validata($id)->toArray();

        //执行删除
        return $this->category->destroy($id);
    }
}
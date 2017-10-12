<?php

namespace App\Services\Home;

use App\Commodity;
use App\Repositories\CarRepository;
use Exception;
use Illuminate\Support\Facades\Auth;

class CarService
{
    protected $car;

    public function __construct(CarRepository $car)
    {
        $this->car = $car;
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
        $car = $this->car->first($id);

        throw_if(empty($car), Exception::class, '未找到该记录！', 404);

        throw_if(!can('control', $car), Exception::class, '没有权限！', 403);

        return $car;
    }

    /**
     * 获取需要的数据
     *
     * @param int $num
     * @param null $keyword
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function get()
    {
        return $this->car->get();
    }

    /**
     * 获取状态为1的购物车条目
     *
     * @return mixed
     */
    public function getAvalible()
    {
        return $this->car->getAvalible();
    }

    /**
     * 统计数量
     *
     * @return mixed
     */
    public function count()
    {
        return $this->car->count();
    }

    /**
     * 计算购物车总金额
     *
     * @param $lists
     * @return int
     */
    public function total_price($lists)
    {
        $total_price = 0;

        foreach ($lists as $list) {
            $total_price += $list['price'] * $list['num'];
        }

        return $total_price;
    }

    /**
     * 获取需要的数据
     *
     * @param array ...$select
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getSimple(...$select)
    {
        return $this->car->getSimple(...$select);
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
     * 插入
     *
     * @param $post
     * @param null $id
     * @return mixed
     */
    public function create($post, $commodity_id)
    {
        //构造数组
        $data['user_id'] = Auth::id();
        $data['commodity_id'] = $commodity_id;
        $data['num'] = $post['num'];
        $data['price'] = Commodity::find($commodity_id)->price;
        $data['remark'] = null;

        //写入属性
        foreach ($post['attribute'] as $key => $attribute) {
            $data['remark'] .= $key.':'.$attribute.'|';
        }

        $data['remark'] = rtrim($data['remark'], '|');
        
        //执行插入
        return $this->car->create($data);
    }

    /**
     * 更新记录
     *
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data)
    {
        return $this->car->update($id, $data);
    }

    /**
     * 更新记录
     *
     * @param $where
     * @param $data
     * @return mixed
     */
    public function updateWhere($where, $data)
    {
        return $this->car->updateWhere($where, $data);
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
        $this->validata($id);

        //执行删除
        return $this->car->destroy($id);
    }

    /**
     * 删除指定条件记录
     *
     * @param $where
     * @return mixed
     */
    public function destroyWhere($where)
    {
        //执行删除
        return $this->car->destroyWhere($where);
    }
}

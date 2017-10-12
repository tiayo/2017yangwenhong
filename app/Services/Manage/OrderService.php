<?php

namespace App\Services\Manage;

use App\Repositories\OrderRepository;
use Exception;

class OrderService
{
    protected $order;

    public function __construct(OrderRepository $order)
    {
        $this->order = $order;
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
        $first = $this->order->first($id);

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
    public function get($num = 10000, $order_id = null)
    {
        if (!empty($order_id)) {
            return can('admin') ?
                $this->order->getSearch($num, $order_id) :
                $this->order->getSearchBusiness($num, $order_id);
        }

        return can('admin') ?
            $this->order->get($num) :
            $this->order->getBusiness($num);
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
            $this->order->getSimple(...$select) :
            $this->order->getSimpleBusiness(...$select);
    }

    /**
     * 修改状态
     *
     * @param $order_id
     * @param $status
     * @return mixed
     */
    public function changeStatus($order_id, $status)
    {
        //权限验证
        $order = $this->validata($order_id);

        //订单状态不能往低修改
        throw_if($status <= $order['status'], Exception::class, '您要修改的状态无效', 403);

        //判断订单状态是否可以修改
        throw_if($order['status'] == 4 || $order['status'] == 5 || $order['status'] == 7,
            Exception::class, '该订单不可修改！', 403);

        return $this->order->update($order_id, ['status' => $status]);
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
    public function update($post, $id)
    {
        //统计数据
        $data['name'] = $post['name'];
        $data['address'] = $post['address'];
        $data['phone'] = $post['phone'];
        $data['price'] = $post['price'];
        $data['type'] = $post['type'];

        empty($post['tracking']) ? true : $data['tracking'] = $post['tracking'];
        empty($post['remark']) ? true : $data['remark'] = $post['remark'];

        //执行插入或更新
        return $this->order->update($id, $data);
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
        return $this->order->destroy($id);
    }
}
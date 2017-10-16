<?php

namespace App\Services\Home;

use App\Repositories\CommodityRepository;
use App\Repositories\OrderDetailRepository;
use App\Repositories\OrderRepository;
use Illuminate\Support\Facades\Auth;
use Exception;

class OrderService
{
    protected $order, $car, $orderDetail, $commodity;

    public function __construct(OrderRepository $order,
                                CarService $car,
                                OrderDetailRepository $orderDetail,
                                CommodityRepository $commodity)
    {
        $this->order = $order;
        $this->car = $car;
        $this->orderDetail = $orderDetail;
        $this->commodity = $commodity;
    }

    public function add($post, $business_id)
    {
        //获取商品
        foreach (unserialize($post['commodity']) as $commodity) {
            $commodities[] = $this->getComodity($commodity);
        }

        //构造订单
        $order['user_id'] = Auth::id();
        $order['business_id'] = $business_id;
        $order['name'] = $post['name'];
        $order['address'] = $post['address'];
        $order['phone'] = $post['phone'];
        $order['price'] = $this->totalPrice($commodities);
        $order['type'] = 1;
        $order['status'] = 1; //测试：默认为已付款

        //创建订单
        $id = $this->order->create($order)->id;

        //创建订单详情以及减少库存
        foreach ($commodities as $commodity) {
            //减少库存操作
            $this->commodity->decrement($commodity['num']);

            //订单详情数据
            $order_detail['order_id'] = $id;
            $order_detail['user_id'] = Auth::id();
            $order_detail['commodity_id'] = $commodity['id'];
            $order_detail['num'] = $commodity['num'];
            $order_detail['price'] = $commodity['price'];
            $order_detail['remark'] = $commodity['remark'] ?? '无';
            $order_detail['status'] = $commodity['status'];

            //写入订单详情数据库
            $this->orderDetail->create($order_detail);
        }

        return true;
    }

    /**
     * 获取符合条件的订单
     *
     * @param null $status
     * @return mixed
     */
    public function get($status = null)
    {
        if (empty($status)) {
            return $this->order->getByUserAll();
        }

        return $this->order->getByUser($status);
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
     * 通过id获取单条订单
     *
     * @param $id
     * @return OrderService|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static[]
     */
    public function first($id)
    {
        return $this->validata($id);
    }

    /**
     * 获取单条商品
     *
     * @param $id
     */
    public function getComodity($key)
    {
        //切割获取商品id和数量
        $exploede = explode('_', $key);

        //判断数据合法性
        throw_if(!isset($exploede[0]) || !isset($exploede[1]), Exception::class, '数据格式异常！', 403);

        //获取商品信息
        $commodity = $this->commodity->first($exploede[0]);

        throw_if(!isset($exploede[0]) || !isset($exploede[1]), Exception::class, '数据格式异常！', 403);

        //获取购买数量
        $commodity['num'] = $exploede[1];

        return $commodity;
    }

    /**
     * 根据商品获取价格
     *
     * @param $commodities
     * @return int
     */
    public function totalPrice($commodities)
    {
        $total_price = 0;

        foreach ($commodities as $commodity) {
            $total_price += $commodity['price'] * $commodity['num'];
        }

        return $total_price;
    }
}
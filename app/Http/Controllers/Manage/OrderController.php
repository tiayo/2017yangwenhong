<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Services\Manage\CategoryService;
use App\Services\Manage\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $order;
    protected $request;
    protected $category;

    public function __construct(OrderService $order, Request $request, CategoryService $category)
    {
        $this->order = $order;
        $this->request = $request;
        $this->category = $category;
    }

    /**
     * 管理员列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listView($order_id = null)
    {
        $num = config('site.list_num');

        $orders = $this->order->get($num, $order_id);

        return view('manage.order.list', [
            'lists' => $orders,
        ]);
    }

    /**
     * 修改状态
     *
     * @param $order_id
     * @param $status
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeStatus($order_id, $status)
    {
        try {
            $this->order->changeStatus($order_id, $status);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->route('order_list');
    }

    /**
     * 修改管理员视图
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function updateView($id)
    {
        try {
            $old_input = $this->order->first($id);
        } catch (\Exception $e) {
            return response($e->getMessage(), $e->getCode());
        }

        return view('manage.order.add_or_update', [
            'old_input' => $old_input,
            'url' => Route('order_update', ['id' => $id]),
            'sign' => 'update',
        ]);
    }

    /**
     * 添加提交
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function updatePost($order_id)
    {
        $this->validate($this->request, [
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'price' => 'required|numeric',
            'type' => 'required|integer',
        ]);

        try {
            $this->order->update($this->request->all(), $order_id);
        } catch (\Exception $e) {
            return response($e->getMessage());
        }

        return redirect()->route('order_list');
    }

    /**
     * 删除记录
     *
     * @param $id
     * @return bool|null
     */
    public function destroy($id)
    {
        try {
            $this->order->destroy($id);
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }

        return redirect()->route('order_list');
    }
}
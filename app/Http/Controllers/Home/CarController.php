<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Services\Home\CarService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarController extends Controller
{
    protected $request;
    protected $car;

    public function __construct(Request $request, CarService $car)
    {
        $this->request = $request;
        $this->car = $car;
    }

    public function view()
    {
        //获取购物车列表
        $lists = $this->car->get();

        return view('home.car.view', [
            'lists' => $lists,
        ]);
    }

    /**
     * 购物车结算时修改购物车订单
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update()
    {
        //获取数据
        $post = $this->request->all();

        //删除被删除的购物车条目
        $this->car->destroyWhere([[
            'id', 'whereNotIn', $post['car_avalible']
        ]]);

        //将购物车全部status字段置为0
        $this->car->updateWhere([
            ['user_id', Auth::id()],
        ], ['status' => 0,]);

        //更新购物车条目数量和状态
        foreach ($post['car_id'] as $car_id) {
            $this->car->update($car_id, [
                'num' => $post['num'][$car_id],
                'status' => 1,
            ]);
        }

       return redirect()->route('home.order_add');
    }

    public function add($commodity_id)
    {
        $this->validate($this->request, [
            'num' => 'required|integer',
            'attribute.*' => 'required',
        ]);

        try {
            $this->car->create($this->request->all(), $commodity_id);
        } catch (\Exception $e) {
            return response($e->getMessage());
        }

        return redirect()->route('home.car');
    }

    public function destory($commodity_id)
    {
        try {
            $this->car->destroy($commodity_id);
        }catch (\Exception $e) {
            return response($e->getMessage());
        }

        return redirect()->route('home.car');
    }
}
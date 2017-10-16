<?php

namespace App\Http\Controllers\Home;

use App\Car;
use App\Http\Controllers\Controller;
use App\Services\Home\CarService;
use App\Services\Home\IndexService;
use App\Services\Home\OrderService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected $order, $request, $car, $index;

    public function __construct(OrderService $order,
                                Request $request,
                                CarService $car,
                                IndexService $index)
    {
        $this->order = $order;
        $this->request = $request;
        $this->car = $car;
        $this->index = $index;
    }

    public function view($order_id)
    {
        try{
            $order = $this->order->first($order_id);
        } catch (\Exception $exception) {
            return response($exception->getMessage());
        }

        return view('home.order.view', [
            'order' => $order,
        ]);
    }

    public function addView($business_id)
    {
        $this->validate($this->request, [
            'commodity.*' => 'required'
        ]);

        //获取商品
        foreach ($this->request->get('commodity') as $commodity) {
            $commodities[] = $this->order->getComodity($commodity);
        }

        //获取订单总价
        $total_price = $this->order->totalPrice($commodities);

        return view('home.order.add', [
            'user' => Auth::user(),
            'bussiness' => $this->index->getBusinessFirst($business_id),
            'commodities' => $commodities,
            'total_price' => $total_price,
            'origin_data' => $this->request->get('commodity')
        ]);
    }

    public function addPost($business_id)
    {
        $this->validate($this->request, [
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'commodity' => 'required',
        ]);

        try{
            $this->order->add($this->request->all(), $business_id);
        } catch (\Exception $exception) {
            return response($exception->getMessage());
        }

        return redirect()->route('home.person');
    }

    public function addressView()
    {
        return view('home.order.address', [
            'user' => Auth::user(),
        ]);
    }

    public function addressPost()
    {
        $this->validate($this->request, [
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        User::where('id', Auth::id())->update([
            'name' => $this->request->get('name'),
            'phone' => $this->request->get('phone'),
            'address' => $this->request->get('address'),
        ]);

        return redirect()->route('home.order_add');
    }
}
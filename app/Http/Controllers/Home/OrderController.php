<?php

namespace App\Http\Controllers\Home;

use App\Car;
use App\Http\Controllers\Controller;
use App\Services\Home\CarService;
use App\Services\Home\OrderService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected $order, $request, $car;

    public function __construct(OrderService $order, Request $request, CarService $car)
    {
        $this->order = $order;
        $this->request = $request;
        $this->car = $car;
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

    public function addView()
    {
        $cars = $this->car->getAvalible();

        $user = Auth::user();

        $total_price = $this->car->total_price($cars);

        return view('home.order.add', [
            'cars' => $cars,
            'user' => $user,
            'total_price' => $total_price,
        ]);
    }

    public function addPost()
    {
        try{
            $this->order->add();
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
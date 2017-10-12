<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Services\Manage\OrderService;
use App\Services\Manage\UserService;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index(UserService $user, OrderService $order)
    {
        $users = can('admin') ? $user->get(10) : [Auth::user()];
        $orders = $order->get(10);

        return view('manage.index.index', [
            'lists' => $users,
            'orders' => $orders
        ]);
    }
}
<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Services\Home\CarService;
use App\Services\Home\IndexService;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    protected $index;
    protected $car;

    public function __construct(IndexService $index, CarService $car)
    {
        $this->index = $index;
        $this->car = $car;
    }

    public function index()
    {
        //今日推荐
        $recommend_today = $this->index->getByType(0, 10);

        //购物车数量
        $car_count = $this->car->count();

        return view('home.index.index', [
            'recommend_today' => $recommend_today,
            'car_count' => $car_count,
        ]);
    }

    public function search(Request $request)
    {
        $keyword = $request->get('keyword');

        if (empty($keyword)) {
            return view('home.index.search');
        }

        //记录到session
        $request->session()->push('search_keyword.', $keyword);

        //获取商品
        $commodities = $this->index->getSearch($keyword);

        return view('home.list.list', [
            'commodities' => $commodities,
        ]);
    }
}
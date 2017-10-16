<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;
use App\Repositories\CommodityRepository;
use App\Services\Home\IndexService;
use App\Services\Manage\CategoryService;

class ListController extends Controller
{
    protected $commodity, $category, $index;

    public function __construct(CommodityRepository $commodity,
                                CategoryService $category,
                                IndexService $index)
    {
        $this->commodity = $commodity;
        $this->category = $category;
        $this->index = $index;
    }

    /**
     * 店铺列表
     *
     * @param $group
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function storeList($group)
    {
        $stores = $this->index->getStrores($group);

        return view('home.list.store', [
            'lists' => $stores
        ]);
    }

    /**
     * 店铺列表
     *
     * @param $group
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function storeSearchList($keyword)
    {
        $stores = $this->index->getStrores($keyword, 'search');

        return view('home.list.store', [
            'lists' => $stores
        ]);
    }

    /**
     * 分组目录
     *
     * @param $type
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function group($type)
    {
        $commodities = $this->index->getByType($type, 100);

        return view('home.list.view', [
            'commodities' => $commodities,
        ]);
    }

    public function view($category_id)
    {
        $commodities = $this->commodity->getByCategory($category_id);

        return view('home.list.view', [
            'commodities' => $commodities,
        ]);
    }
}
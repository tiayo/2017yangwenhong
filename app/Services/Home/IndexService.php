<?php

namespace App\Services\Home;

use App\Repositories\CategoryRepository;
use App\Repositories\CommodityRepository;
use App\Repositories\UserRepository;

class IndexService
{
    protected $commodity, $category, $user;

    public function __construct(CommodityRepository $commodity, 
                                CategoryRepository $category,
                                UserRepository $user)
    {
        $this->commodity = $commodity;
        $this->category = $category;
        $this->user = $user;
    }

    /**
     * 获取符合要求的商品
     *
     * @param $type
     * @param $limit
     * @return mixed
     */
    public function getByType($type, $limit)
    {
        return $this->commodity->getByType($type, $limit);
    }

    /**
     * 获取父级栏目
     * 
     * @return mixed
     */
    public function getCategoryParent()
    {
        return $this->category->getParent();
    }

    /**
     * 通过父级id获取下级
     *
     * @param $parent_id
     * @return mixed
     */
    public function getCategoryChildren($parent_id)
    {
        return $this->category->selectGet([
            ['parent_id', $parent_id],
        ], 'name', 'id');
    }

    /**
     * 搜索
     *
     * @param $keyword
     * @return mixed
     */
    public function getSearch($keyword)
    {
        return $this->commodity->selectGet([
            ['name', 'like', "%$keyword%"],
        ], '*');
    }

    /**
     * 获取指定分组的商户
     *
     * @param $value
     * @return mixed
     */
    public function getStrores($value, $type = null)
    {
        return $type == 'search' ? $this->user->getSearchStore($value) :
            $this->user->getStore($value);
    }

    /**
     * 获取单家商户
     *
     * @param $business_id
     * @return mixed
     */
    public function getBusinessFirst($business_id)
    {
        return $this->user->selectFirst([
            ['type', 2],
            ['id', $business_id]
        ], '*');
    }
}
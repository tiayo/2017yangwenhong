<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Services\Manage\CategoryService;
use App\Services\Manage\CommodityService;
use App\Services\Manage\ManagerService;
use Illuminate\Http\Request;

class CommodityController extends Controller
{
    protected $commodity;
    protected $request;
    protected $category;

    public function __construct(CommodityService $commodity, Request $request, CategoryService $category)
    {
        $this->commodity = $commodity;
        $this->request = $request;
        $this->category = $category;
    }

    /**
     * 管理员列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listView($keyword = null)
    {
        $num = config('site.list_num');

        $commoditys = $this->commodity->get($num, $keyword);

        return view('manage.commodity.list', [
            'lists' => $commoditys,
        ]);
    }

    /**
     * 添加管理员视图
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addView()
    {
        //管理员禁用此功能
        if (can('admin')) {
            return response('请使用商户账号登录操作！');
        }

        $categories = $this->category->getSimple('id', 'name');

        return view('manage.commodity.add_or_update', [
            'lists' => $categories,
            'old_input' => $this->request->session()->get('_old_input'),
            'url' => Route('commodity_add'),
            'sign' => 'add',
        ]);
    }

    /**
     * 修改管理员视图
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function updateView($id)
    {
        $categories = $this->category->getSimple('id', 'name');

        try {
            $old_input = $this->request->session()->has('_old_input') ?
                session('_old_input') : $this->commodity->first($id);
        } catch (\Exception $e) {
            return response($e->getMessage(), $e->getCode());
        }

        return view('manage.commodity.add_or_update', [
            'lists' => $categories,
            'old_input' => $old_input,
            'url' => Route('commodity_update', ['id' => $id]),
            'sign' => 'update',
        ]);
    }

    /**
     * 添加/更新提交
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function post($id = null)
    {
        $this->validate($this->request, [
            'category_id' => 'required|integer',
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required',
            'unit' => 'required',
            'description' => 'required',
            'type' => 'required|integer',
            'image' => 'file|image',
        ]);

        //创建动作时验证邮箱是否已经存在
        empty($id) ? $this->validate($this->request, [
            'name' => 'unique:commodities'
        ]) : true;

        try {
            $this->commodity->updateOrCreate($this->request->all(), $id);
        } catch (\Exception $e) {
            return response($e->getMessage());
        }

        return redirect()->route('commodity_list');
    }

    /**
     * 修改商品状态
     *
     * @param $commodity_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeStatus($commodity_id)
    {
        try{
            $this->commodity->changeStatus($commodity_id);
        } catch (\Exception $e) {
            return response($e->getMessage());
        }

        return redirect()->route('commodity_list');
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
            $this->commodity->destroy($id);
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }

        return redirect()->route('commodity_list');
    }
}
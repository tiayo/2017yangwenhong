<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Services\Manage\CategoryService;
use App\Services\Manage\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    protected $category;
    protected $request;
    protected $user;

    public function __construct(CategoryService $category,
                                Request $request,
                                UserService $user)
    {
        $this->category = $category;
        $this->request = $request;
        $this->user = $user;
    }

    /**
     * 记录列表
     *
     * @param null $keyword
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listView($business_id = null)
    {
        $num = config('site.list_num');

        //获取商户
        $businesses = can('admin') ? $this->user->getBusiness() : [Auth::user()];

        //获取指定的分类
        $categories = can('admin') ?
            $this->category->get($num, $business_id) : $this->category->get($num, Auth::id());

        return view('manage.category.list', [
            'lists' => $categories,
            'businesses' => $businesses,
        ]);
    }

    /**
     * 添加视图
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addView()
    {
        $businesses = can('admin') ? $this->user->getBusiness() : [];

        return view('manage.category.add_or_update', [
            'lists' => $businesses,
            'old_input' => $this->request->session()->get('_old_input'),
            'url' => Route('category_add'),
            'sign' => 'add',
        ]);
    }

    /**
     * 修改管理员视图
     *
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function updateView($id)
    {
        $businesses = can('admin') ? $this->user->getBusiness() : [];

        try {
            $old_input = $this->request->session()->has('_old_input') ?
                session('_old_input') : $this->category->first($id);
        } catch (\Exception $e) {
            return response($e->getMessage(), $e->getCode());
        }

        return view('manage.category.add_or_update', [
            'lists' => $businesses,
            'old_input' => $old_input,
            'url' => Route('category_update', ['id' => $id]),
            'sign' => 'update',
        ]);
    }

    /**
     * 添加/更新提交
     *
     * @param null $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function post($id = null)
    {
        $this->validate($this->request, [
            'name' => 'required',
        ]);

        //管理员添加必须指定商户id
        if (can('admin')) {
            $this->validate($this->request, [
                'parent_id' => 'required|integer',
            ]);
        }

        try {
            $this->category->updateOrCreate($this->request->all(), $id);
        } catch (\Exception $e) {
            return response($e->getMessage());
        }

        return redirect()->route('category_list');
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
            $this->category->destroy($id);
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }

        return redirect()->route('category_list');
    }
}
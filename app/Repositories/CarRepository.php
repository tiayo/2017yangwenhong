<?php

namespace App\Repositories;

use App\Car;
use Illuminate\Support\Facades\Auth;

class CarRepository
{
    protected $car;

    public function __construct(Car $car)
    {
        $this->car = $car;
    }

    /**
     * 创建记录
     *
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        return $this->car->create($data);
    }

    /**
     * 获取所有显示记录（带分页）
     *
     * @param $page
     * @param $num
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function get()
    {
        return $this->car
            ->where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->get();
    }

    public function getAvalible()
    {
        return $this->car
            ->where('user_id', Auth::id())
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->get();
    }

    /**
     * 统计数量
     *
     * @return mixed
     */
    public function count()
    {
        return $this->car
            ->where('user_id', Auth::id())
            ->count();
    }

    /**
     * 获取所有显示记录(不带分页)
     *
     * @param array ...$select
     * @return mixed
     */
    public function getSimple(...$select)
    {
        return $this->car
            ->select($select)
            ->orderBy('id', 'desc')
            ->get();
    }

    /**
     * 获取显示的搜索结果
     *
     * @param $num
     * @param $keyword
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getSearch($num, $keyword)
    {
        return $this->car
            ->where(function ($query) use ($keyword) {
                $query->where('categories.name', 'like', "%$keyword%");
            })
            ->orderBy('id', 'desc')
            ->paginate($num);
    }

    /**
     * 获取单条记录
     *
     * @param $id
     * @return mixed
     */
    public function first($id)
    {
        return $this->car->find($id);
    }

    /**
     * 删除记录
     *
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->car
            ->where('id', $id)
            ->delete();
    }

    /**
     * 获取单条记录（带where和select）
     *
     * @param $where
     * @param array ...$select
     * @return mixed
     */
    public function selectFirst($where, ...$select)
    {
        return $this->car
            ->select($select)
            ->where($where)
            ->first();
    }

    /**
     * 更新记录
     *
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data)
    {
        return $this->car
            ->where('id', $id)
            ->update($data);
    }

    /**
     * 更新记录
     *
     * @param $where
     * @param $data
     * @return mixed
     */
    public function updateWhere($where, $data)
    {
        return $this->car
            ->where($where)
            ->update($data);
    }

    public function destroyWhere($where)
    {
        return $this->car
            ->where('user_id', Auth::id())
            ->where($where)
            ->delete();
    }
}

<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Services\Home\CategoryService;
use App\Services\Home\IndexService;

class BusinessController extends Controller
{
    protected $category, $index;

    public function __construct(CategoryService $category, IndexService $index)
    {
        $this->category = $category;
        $this->index = $index;
    }

    public function view($business_id)
    {
        $business = $this->index->getBusinessFirst($business_id);

        $categories = $this->category->get($business_id);

        return view('home.business.view', [
            'lists' => $categories,
            'business' => $business,
        ]);
    }
}
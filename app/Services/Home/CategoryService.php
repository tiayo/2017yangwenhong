<?php

namespace App\Services\Home;

use App\Repositories\CategoryRepository;

class CategoryService
{
    protected $category;

    public function __construct(CategoryRepository $category)
    {
        $this->category = $category;
    }

    public function get($business_id)
    {
        return $this->category->getSimpleBusinessIndex($business_id);
    }

}
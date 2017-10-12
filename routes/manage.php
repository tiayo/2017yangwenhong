<?php

$this->group(['namespace' => 'Manage', 'prefix' => 'manage'], function () {
    $this->get('login', 'Auth\LoginController@showLoginForm')->name('manage.login');
    $this->post('login', 'Auth\LoginController@login')->name('manage.login');
    $this->get('logout', 'Auth\LoginController@logout')->name('manage.logout');

    //登陆后才可以访问
    $this->group(['middleware' => 'manage_auth'], function () {

        $this->get('/', 'IndexController@index')->name('manage');

        //分类相关
        $this->get('/category/list/', 'CategoryController@listView')->name('category_list');
        $this->get('/category/list/{business_id}', 'CategoryController@listView')->name('category_search');
        $this->get('/category/add', 'CategoryController@addView')->name('category_add');
        $this->post('/category/add', 'CategoryController@post');
        $this->get('/category/update/{id}', 'CategoryController@updateView')->name('category_update');
        $this->post('/category/update/{id}', 'CategoryController@post');
        $this->get('/category/destroy/{id}', 'CategoryController@destroy')->name('category_destroy');

        //商品相关
        $this->get('/commodity/list/', 'CommodityController@listView')->name('commodity_list');
        $this->get('/commodity/list/{keyword}', 'CommodityController@listView')->name('commodity_search');
        $this->get('/commodity/add', 'CommodityController@addView')->name('commodity_add');
        $this->post('/commodity/add', 'CommodityController@post');
        $this->get('/commodity/update/{id}', 'CommodityController@updateView')->name('commodity_update');
        $this->post('/commodity/update/{id}', 'CommodityController@post');
        $this->get('/commodity/status/{id}', 'CommodityController@changeStatus')->name('commodity_status');
        $this->get('/commodity/destroy/{id}', 'CommodityController@destroy')->name('commodity_destroy');

        //订单管理
        $this->get('/order/list/', 'OrderController@listView')->name('order_list');
        $this->get('/order/list/{keyword}', 'OrderController@listView')->name('order_search');
        $this->get('/order/update/{order_id}', 'OrderController@updateView')->name('order_update');
        $this->post('/order/update/{order_id}', 'OrderController@updatePost');
        $this->get('/order/destroy/{order_id}', 'OrderController@destroy')->name('order_destroy');
        $this->get('/order/status/{order_id}/{status}', 'OrderController@changeStatus')->name('order_status');

        //管理员才可以操作
        $this->group(['middleware' => 'admin'], function () {
            //会员相关
            $this->get('/user/list/', 'UserController@listView')->name('user_list');
            $this->get('/user/list/{keyword}', 'UserController@listView')->name('user_search');
            $this->get('/user/add', 'UserController@addView')->name('user_add');
            $this->post('/user/add', 'UserController@post');
            $this->get('/user/update/{id}', 'UserController@updateView')->name('user_update');
            $this->post('/user/update/{id}', 'UserController@post');
            $this->get('/user/destroy/{id}', 'UserController@destroy')->name('user_destroy');
        });
    });
});
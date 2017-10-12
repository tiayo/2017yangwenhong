@inject('car', 'App\Services\Home\CarService')

@extends('home.layouts.app')

@section('title', '商品详情')

@section('style')
    <style>
        .show-details img {
            width: 92%;
        }
    </style>
@endsection

@section('body')
<div class="goods-details">
    <div class="swiper-container bigpic clearfix">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img src="{{ $commodity['image'] }}"/>
            </div>
        </div>
        <!-- 分页器 -->
        <div class="swiper-pagination"></div>
    </div>
    <div class="info">
        <div class="title clearfix">
            <span>{{ $commodity['name'] }}</span>
        </div>
        <div class="price clearfix">
            <h1>{{ $commodity['price'] }}</h1>
            <h3>邮费：<em>0</em> 元</h3>
        </div>
    </div>
    <ul class="show-title clearfix">
        <li class="on">图文详情</li>
    </ul>

    <ul class="show-details" style="padding: 1em">
        {!! $commodity['description'] !!}
    </ul>
    <h1 class="join-successful">加入购物车成功</h1>
    <h1 class="collection-successful">收藏成功</h1>
    <h1 class="collection-failure">已取消收藏</h1>
    <div class="nav-bottom">
        <span class="join-collection join-collection1">收藏</span>
        <a href="{{ route('home.car') }}">购物车<em>{{ $car->count() }}</em></a>
        <span class="join-cart">加入购物车</span>
        <a href="#" class="exchange-now">立即购买</a>
    </div>
    <div>
        <form id="car_add_gorm" action="{{ route('home.car_add', ['id' => $commodity['id']]) }}" method="post">
            {{ csrf_field() }}
            <div class="mask">
                <h1 class="join-failure">请选择商品规格</h1>
                <div class="mask-con">
                    <div class="mask-title">
                            <span class="pic">
                                <img src="{{ $commodity['image'] }}"/>
                            </span>
                        <h4>{{ $commodity['name'] }}</h4>
                        <strong class="price clearfix">
                            <h1>{{ $commodity['price'] }}</h1>
                        </strong>
                        <div class="mask-close"></div>
                    </div>
                    <ul class="mask-content">

                    </ul>
                    <div class="mask-num">
                        <p>数量</p>
                        <div class="form">
                            <div>
                                <span class="jian"></span>
                                <input type="text" class="num" name="num" value="1"/>
                                <span class="jia"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nav3">
                    <a href="#" class="confirm" onclick="car_add_gorm()">确定</a>
                </div>
            </div>
        </form>
</div>
<div class="quick-nav">
    <em>快速导航</em>
</div>
<div class="quick-nav-mask">
    <div class="quick-con">
        @include('home.layouts.quick')
    </div>
</div>
<em class="return-top">顶部</em>
<script type="text/javascript">
    var mySwiper = new Swiper ('.swiper-container', {
        direction: 'horizontal',
        loop: true,
        autoplay: 3000,
        autoplayDisableOnInteraction : false,
        // 分页器
        pagination: '.swiper-pagination',
    });
    var len = $(".goods-details .mask .mask-con .mask-content li").length;
    if(len == 0) {
        $(".goods-details .mask .mask-con .mask-content").remove();
        $(".goods-details .mask .mask-con").css({"height" : 101});
        $(".quick-nav").css({"bottom" : 155});
    }

    //提交
    function car_add_gorm() {
        $('#car_add_gorm').submit();
    }
</script>
@endsection
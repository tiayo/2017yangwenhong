@inject('index', 'App\Services\Home\IndexService')
@extends('home.layouts.app')

@section('title', '个人中心')

@section('body')
<div class="pc">
    <div class="info">
        <img src="{{ Auth::user()['avatar'] }}" class="portrait" />
        <span class="name">{{ Auth::user()['name'] }}</span>
        <span class="id">ID:<em>{{ Auth::user()['id'] }}</em></span>
        <span class="member-type">注册会员</span>
        <a href="{{ route('home.person_update') }}" class="more"></a>
    </div>
    <div class="title">我的订单</div>
    <ul class="order-nav">
        <li class="on">全部</li>
        <li>待发货</li>
        <li>待收货</li>
        <li>已完成</li>
    </ul>
    <div class="content" id="content">
        <div class="con" style="display:block" >
            <ul class="all-list">
                @foreach($orders_all as $order)
                <li class="clearfix">
                    <div class="status">{{ config('site.order_status')[$order['status']] }}<a href="#">查看物流</a></div>
                    @foreach($order->orderDetail as $list_detail)
                        <a href="{{ route('home.order_view', ['order_id' => $order['id']]) }}" class="info">
                            <div class="pic"><img src="{{ $list_detail->commodity->image_0 }}"/></div>
                            <h1 class="name">{{ $list_detail->commodity->name }}</h1>
                            <h3 class="pay-for">{{ $list_detail->price * $list_detail->num }}</h3>
                        </a>
                    @endforeach
                    <h4>全国包邮<span>总计:<em class="combined">{{ $order['price'] }}</em></span></h4>
                </li>
                @endforeach
            </ul>
            <!-- <h5>上拉加载更多</h5> -->
        </div>
        <div class="con">
            <ul class="send-list">
                @foreach($orders_1 as $order)
                    <li class="clearfix">
                        <div class="status">{{ config('site.order_status')[$order['status']] }}<a href="#">查看物流</a></div>
                        @foreach($order->orderDetail as $list_detail)
                            <a href="{{ route('home.order_view', ['order_id' => $order['id']]) }}" class="info">
                                <div class="pic"><img src="{{ $list_detail->commodity->image_0 }}"/></div>
                                <h1 class="name">{{ $list_detail->commodity->name }}</h1>
                                <h3 class="pay-for">{{ $list_detail->price * $list_detail->num }}</h3>
                            </a>
                        @endforeach
                        <h4>全国包邮<span>总计:<em class="combined">{{ $order['price'] }}</em></span></h4>
                    </li>
                @endforeach
            </ul>
            <!-- <h5>上拉加载更多</h5> -->
        </div>
        <div class="con">
            <ul class="accept">
                @foreach($orders_2 as $order)
                    <li class="clearfix">
                        <div class="status">{{ config('site.order_status')[$order['status']] }}<a href="#">查看物流</a></div>
                        @foreach($order->orderDetail as $list_detail)
                            <a href="{{ route('home.order_view', ['order_id' => $order['id']]) }}" class="info">
                                <div class="pic"><img src="{{ $list_detail->commodity->image_0 }}"/></div>
                                <h1 class="name">{{ $list_detail->commodity->name }}</h1>
                                <h3 class="pay-for">{{ $list_detail->price * $list_detail->num }}</h3>
                            </a>
                        @endforeach
                        <h4>全国包邮<span>总计:<em class="combined">{{ $order['price'] }}</em></span></h4>
                    </li>
                @endforeach
            </ul>
            <!-- <h5>上拉加载更多</h5> -->
        </div>
        <div class="con">
            <ul class="complete">
                @foreach($orders_4 as $order)
                    <li class="clearfix">
                        <div class="status">{{ config('site.order_status')[$order['status']] }}<a href="#">查看物流</a></div>
                        @foreach($order->orderDetail as $list_detail)
                            <a href="{{ route('home.order_view', ['order_id' => $order['id']]) }}" class="info">
                                <div class="pic"><img src="{{ $list_detail->commodity->image_0 }}"/></div>
                                <h1 class="name">{{ $list_detail->commodity->name }}</h1>
                                <h3 class="pay-for">{{ $list_detail->price * $list_detail->num }}</h3>
                            </a>
                        @endforeach
                        <h4>全国包邮<span>总计:<em class="combined">{{ $order['price'] }}</em></span></h4>
                    </li>
                @endforeach
            </ul>
            <!-- <h5>上拉加载更多</h5> -->
        </div>
    </div>
    <div class="nav clearfix">
       @include('home.layouts.sidebar')
    </div>
</div>
<script type="text/javascript">
    $(".order-nav li").click(function() {
        $(this).addClass('on').siblings().removeClass('on');
        $(".pc .content .con").hide().eq($(".order-nav li").index(this)).show();
    });
</script>
@endsection
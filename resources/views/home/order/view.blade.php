@extends('home.layouts.app')

@section('title', '订单详情')
@section('class', 'my-order')

@section('body')
    <div class="content">
        <a href="{{ route('home.person') }}" class="myOrder-back">返回 -></a>
        <div class="myOrder-state clearfix">
            @foreach($order->orderDetail as $detail)
                <div class="state-left">
                    <h6>配送信息</h6>
                    <h1>商品名称：<em>{{ $detail->commodity->name }}</em></h1>
                    <h2>商品规格：<em>{{ $detail->remark }}</em></h2>
                    <h3>商品数量：<em>{{ $detail['num'] }}</em></h3>
                    <h4>送货方式：<em>{{ config('site.order_type')[$order['type']] }}</em></h4>
                    <h5>订单号：<em>{{ $order['id'] }}</em></h5>
                </div>
                <div class="state-mid">
                    <h6>收货人信息</h6>
                    <h1>收货人：<em>{{ $order->user->name }}</em></h1>
                    <h2>手机号码：<em>{{ $order['phone'] }}</em></h2>
                    <h3>地址：<em>{{ $order['address'] }}</em></h3>
                </div>
                <div class="state-right">
                    <h6>付款信息</h6>
                    <h1>付款方式：<em>微信支付</em></h1>
                    <h2>付款时间：<em>{{ $order['created_at'] }}</em></h2>
                    <h3>商品总额：<span>￥<em>{{ $detail->price * $detail->num }}</em></span></h3>
                    <h4>运费金额：<span>￥<em>0</em></span></h4>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@section('script')
@endsection
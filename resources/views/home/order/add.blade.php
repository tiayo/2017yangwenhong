@inject('index', 'App\Services\Home\IndexService')
@extends('home.layouts.app')

@section('title', '结算页面')

@section('body')
<form action="{{ route('home.order_add_post', ['business_id' => $bussiness['id']]) }}" method="post">
    {{ csrf_field() }}
    <div class="goods-settlement clearfix">
        <div href="add-address.html" class="address">
            <h1>
                <input class="name-input" type="text" name="name" placeholder="点击填写收货人姓名" value="{{ $user['name'] }}"/>
                <input class="tel-input" type="text" name="phone" placeholder="点击填写联系电话" value="{{ $user['phone'] }}"/>
                <input class="address-input" type="text" name="address" placeholder="点击输入收货地址" value="{{ $user['address'] }}"/>
                <input type="hidden" name="commodity" value="{{ serialize($origin_data) }}">
            </h1>
        </div>
        <div class="content">
            <a href="#" class="info">
                <h1 class="name">{{ $bussiness['name'] }}</h1>
                <ul>
                    @foreach($commodities as $commodity)
                        <li>
                            <span>{{ $commodity['name'] }}</span>
                            <em>￥ <b>{{ $commodity['num'] * $commodity['price'] }}</b></em>
                            <strong>x <b>{{ $commodity['num'] }}</b></strong>
                        </li>
                    @endforeach
                </ul>
            </a>
            <div class="courier">配送方式<em>嗨吃专送</em></div>
        </div>
        <div class="nav-bottom">
            <h1>合计:<span>{{ $total_price }}</span></h1>
            <button type="submit" href="payfor-success.html">提交订单</button>
        </div>
    </div>
</form>
@endsection
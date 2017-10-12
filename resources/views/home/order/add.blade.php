@inject('index', 'App\Services\Home\IndexService')
@extends('home.layouts.app')

@section('title', '结算页面')

@section('body')
<div class="goods-settlement clearfix">
    <a href="{{ route('home.address') }}" class="address">
        <h1>收货人:<span>{{ $user['name'] }}</span><em>{{ $user['phone'] }}</em></h1>
        <h2>{{ $user['address'] }}</h2>
        <h3></h3>
    </a>
    <div class="content">
        @foreach($cars as $car)
            @php
                $attributes = explode('|', $car['remark']);
            @endphp
            <a href="{{ route('home.commodity_view', ['id' => $car['commodity_id']]) }}" class="info">
                <div class="pic"><img src="{{ $car->commodity->image_0 }}"/></div>
                <h1 class="name">{{ $car->commodity->name }}</h1>
                <h2 class="num-of">x<span class="number">{{ $car['num'] }}</span></h2>
                <h3 class="pay-for">{{ $car['price'] }}</h3>
                <div class="type">
                    @foreach($attributes as $attribute)
                        @php
                            $attribute = explode(':', $attribute)
                        @endphp
                        <h1>{{ $attribute[0] }}:<em>{{ $attribute[1] }}</em></h1>
                    @endforeach
                </div>
            </a>
        @endforeach
        <div class="courier">配送方式<em>快递免邮</em></div>
    </div>
    <div class="nav-bottom">
        <h1>合计:<span>{{ $total_price }}</span></h1>
        <a href="{{ route('home.order_add_post') }}">提交订单</a>
    </div>
</div>
@endsection
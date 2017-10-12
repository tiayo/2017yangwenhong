@extends('home.layouts.app')

@section('title', '商品列表')

@section('body')
    <div class="classification-list">
        <div class="header">
            <div class="search">
                <a href="{{ route('home.search') }}" class="search-input"><input type="text" placeholder="搜索商品"/></a>
            </div>
            <div class="classification-list-nav">
                @include('home.layouts.sidebar')
            </div>
        </div>
        <div class="content" id="content">
            <ul class="content-con">
                @foreach($commodities as $commodity)
                    <li class="content-list">
                        <a href="{{ route('home.commodity_view', ['id' => $commodity['id']]) }}">
                            <div class="pic">
                                <img src="{{ $commodity['image_0'] }}"/>
                            </div>
                            <h2>{{ $commodity['name'] }}</h2>
                            <strong class="price clearfix">
                                <b>{{ $commodity['price'] }}</b>
                            </strong>
                        </a>
                    </li>
                @endforeach
            </ul>
            <!-- <h4>上拉加载更多</h4> -->
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
    </div>
@endsection
@section('script')
@endsection
@inject('index', 'App\Services\Home\IndexService')
@extends('home.layouts.app')

@section('title', '商品分类')

@section('body')
<body>
<div class="classification clearfix">
    <div class="header">
        <a href="search.html" class="search">
            <input type="text" placeholder="搜索礼品"/>
        </a>
    </div>
    <ul class="tab clearfix">
        @foreach($parents as $key => $parent)
            <li @if($key == 0) class="on" @endif>{{ $parent['name'] }}</li>
        @endforeach
    </ul>
    <ul class="tabcon">
        @foreach($parents as $parent)
            <li>
                @foreach($index->getCategoryChildren($parent['id']) as $children)
                    <a class="tabcon-list" href="{{ route('home.category_view', ['id' => $children['id']]) }}">
                        {{ $children['name'] }}
                    </a>
                @endforeach
            </li>
        @endforeach
    </ul>
</div>
<div class="quick-nav">
    <em>快速导航</em>
</div>
<div class="quick-nav-mask">
    <div class="quick-con">
        @include('home.layouts.quick')
    </div>
</div>
@endsection
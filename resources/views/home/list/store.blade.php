@inject('index', 'App\Services\Home\IndexService')
@extends('home.layouts.app')

@section('title', '商品分类')

@section('body')
<body>
<div class="classification-list">
    <div class="header">
        <div class="search">
            <form id="search_form">
                <a class="search-input"><input id="search" type="text" placeholder="搜索店铺"/></a>
            </form>
        </div>
    </div>
    <div class="content" id="content">
        <ul class="content-con">
            @foreach($lists as $list)
                <li class="content-list">
                    <a href="{{ route('home.business', ['business_id' => $list['id']]) }}">
                        <div class="pic">
                            <img src="{{ $list->avatar }}"/>
                        </div>
                        <h2>{{ $list['name'] }}</h2>
                        <strong class="price clearfix">
                            <span>{{ $list['address'] }}</span>
                            <em>{{ $list['phone'] }}</em>
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

{{--转换搜索链接--}}
<script type="text/javascript">
    $(document).ready(function () {

        $('#search_form').submit(function () {

            var keyword = $('#search').val();

            if (stripscript(keyword) == '') {
                $('#search').val('');
                return false;
            }

            window.location = '{{ route('home.business_search', ['keyword' => '']) }}/' + stripscript(keyword);

            return false;
        });

    });

    function stripscript(s)
    {
        var pattern = new RegExp("[`~!@#$^&*()=|{}':;',\\[\\].<>/?~！@#￥……&*（）——|{}【】‘；：”“'。，、？]");
        var rs = "";
        for (var i = 0; i < s.length; i++) {
            rs = rs+s.substr(i, 1).replace(pattern, '');
        }
        return rs;
    }
</script>
@endsection
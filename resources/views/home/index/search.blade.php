@extends('home.layouts.app')

@section('title', '搜索页')

@section('style')
    <style type="text/css">
        .search {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            margin: auto;
        }
        .search .header {
            position: fixed;
            top: 0;
            width: 100%;
            height: 45px;
            background: #ffda44;
            z-index: 999;
        }
        .search .cancel {
            float: left;
            width: 11%;
            height: 45px;
            background: url(/style/home/icon/back.png) 50% 10px no-repeat;
            background-size: 25px;
            color: #666;
            font-size: 12px;
            text-align: center;
            line-height: 68px;
        }
        .search .search-button {
            position: relative;
            float: right;
            width: 12%;
            height: 45px;
            background: url(/style/home/icon/icon_sousuo.png) 50% 12px no-repeat;
            background-size: 20px;
            color: #666;
            font-size: 12px;
            text-align: center;
            line-height: 68px;
        }
        .search .search-form {
            float: left;
            width: 77%;
            height: 100%;
        }
        .search-input {
            float: left;
            width: 100%;
            height: 100%;
        }
        .search input {
            width: 100%;
            height: 30px;
            margin-top: 7px;
            background-color: #fff;
            border: 0;
            border-radius: 4px;
            outline: none;
            font-size: 14px;
            text-align: center;
            line-height: 30px;
        }
        .search .recent-search {
            position: absolute;
            top: 50px;
            width: 94%;
            padding: 10px 3%;
        }
        .search .recent-search h1 {
            height: 30px;
            color: #333;
            font-size: 16px;
            line-height: 30px;
        }
        .search .recent-search h1 em {
            float: right;
            width: 30px;
            height: 100%;
            background: url(/style/home/icon/delete-address.png) no-repeat center;
            background-size: 75%;
        }
        .search .recent-search h2 {
            padding: 10px 0;
        }
        .search .recent-search h2 a {
            float: left;
            padding: 5px 10px;
            margin: 0 10px 10px 0;
            background-color: #e7e7e7;
            border-radius: 5px;
            color: #666;
            line-height: 1.5em;
        }
        .search .mask {
            display: none;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            margin: auto;
            width: 70%;
            height: 100px;
            background-color: #fff;
            border: 1px solid #e7e7e7;
            border-radius: 10px;
            color: #000;
            font-weight: bold;
            text-align: center;
            line-height: 70px;
        }
        .search .mask .cancel-delete {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50%;
            height: 40px;
            box-shadow: 1px -1px #e7e7e7;
            color: #535353;
            font-weight: normal;
            text-align: center;
            line-height: 40px;
        }
        .search .mask .confirm-delete {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 50%;
            height: 40px;
            box-shadow: 0px -1px #e7e7e7;
            color: #e2302e;
            font-weight: normal;
            text-align: center;
            line-height: 40px;
        }
    </style>
@endsection

@section('body')
<div class="search">
    <div class="header">
        <a href="javascript:history.back(-1)" class="cancel"></a>
        <form action="{{ route('home.search') }}" class="search-form">
            <div class="search-input">
                <input type="text" name="keyword" placeholder="搜索商品"/>
            </div>
        </form>
        <a href="###" class="search-button"></a>
    </div>
    <div class="recent-search">
        <h1>最近热索<em></em></h1>
        <h2 class="clearfix">
            @if (is_array($keywords = session('search_keyword.')))
                @foreach($keywords as $keyword)
                    <a href="{{ route('home.search', ['keyword' => $keyword]) }}">{{ $keyword }}</a>
                @endforeach
            @endif
            <a href="{{ route('home.search', ['keyword' => '红木家具']) }}">红木家具</a>
            <a href="{{ route('home.search', ['keyword' => '移动空调']) }}">移动空调</a>
        </h2>
    </div>
    <div class="mask">
        确定清空历史记录？
        <span class="cancel-delete">取消</span>
        <span class="confirm-delete">确定</span>
    </div>
</div>
<script type="text/javascript">
    $(".search .recent-search h1 em").click(function() {
        $(".search .mask").show();
        $(".search .mask .cancel-delete").click(function() {
            $(".search .mask").hide();
        });
        $(".search .mask .confirm-delete").click(function() {
            $(".search .mask").hide();
            $(".search .recent-search h2 a").remove();
        });
    });
</script>
@endsection
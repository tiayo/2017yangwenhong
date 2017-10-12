@extends('home.layouts.app')

@section('title', '我的购物车')

@section('body')
<div class="shopping-cart">
    <div class="batch-delete">
        <span>您的购物车有 <em></em> 件商品</span>
        <strong>批量删除</strong>
    </div>
    <div class="delete-mask">
        <div class="delete-list">
            确定将这 <em></em> 个宝贝删除？
            <span class="cancel-delete">取消</span>
            <span class="confirm-delete">确定</span>
        </div>
    </div>
    <div class="delete-prompt">您未选中任何商品</div>
    <div class="content">
        <form id="car_post_form" method="post" action="{{ route('home.car_update') }}">
            {{ csrf_field() }}
            @foreach($lists as $list)
                @php
                    $attributes = explode('|', $list['remark']);
                @endphp
                <div class="list">
                    <input type="hidden" name="car_avalible[]" value="{{ $list['id'] }}">
                    <input type="hidden" class="car_id" value="{{ $list['id'] }}">
                    <span class="choose"><em></em></span>
                    <img src="{{ $list->commodity->image_0 }}"/>
                    <h2>{{ $list->commodity->name }}</h2>
                    <h3 style="margin: 1em 0 1em 0">
                        @foreach($attributes as $attribute)
                            @php
                                $attribute = explode(':', $attribute)
                            @endphp
                            <span>{{ $attribute[0] }}:<strong>{{ $attribute[1] }}</strong></span><br/>
                        @endforeach
                    </h3>
                    <h4>
                        <span class="price" data-price="{{ $list['price'] }}">{{ $list['price'] }}</span>
                        <div class="quantity">
                            <span class="jian"></span>
                            <input type="text" class="num" name="num[{{ $list['id'] }}]" value="{{ $list['num'] }}">
                            <span class="jia"></span>
                        </div>
                    </h4>
                </div>
            @endforeach
        </form>
    </div>
    <div class="none-mask">
        <span>你的购物车还没有商品哦</span>
        <a href="/">去商城</a>
    </div>
    <div class="total-price">
        <div class="all-choose"><em></em>全选</div>
        <div class="all-price">
            <span class="total">合计：<em>0</em></span>
        </div>
        <div class="settlement">
            <a href="#">去结算(<em>0</em>)</a>
        </div>
        <div class="nav clearfix">
            @include('home.layouts.sidebar')
        </div>
    </div>
</div>
    <script>
        $(document).ready(function () {
            //点击选择
            $('.choose').click(function () {
                //正向
                if ($(this).find('.sel-red1').length != 0) {
                    return $(this).parent().find('.car_id').attr('name', 'car_id[]');
                }

                //反向
                return $(this).parent().find('.car_id').attr('name', '');
            });

            //全选
            $('.all-choose').click(function () {

                //正向
                if ($(this).find('.sel-red').length != 0) {
                    $('.list').each(function () {
                        return $(this).find('.car_id').attr('name', 'car_id[]');
                    });
                }
                //反向
                else {
                    $('.list').each(function () {
                        return $(this).find('.car_id').attr('name', '');
                    });
                }
            });
        });
    </script>
@endsection
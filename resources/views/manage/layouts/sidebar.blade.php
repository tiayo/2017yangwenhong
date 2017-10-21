<!--sidebar nav start-->
<ul style="margin-top:160px;" class="nav nav-pills nav-stacked custom-nav">
    <li class="menu-list active nav-active" id="nav_0"><a href=""><span>分类管理</span></a>
        <ul class="sub-menu-list">
            <li id="nav_0_1"><a href=" {{ route('category_list') }} ">分类管理</a></li>
            @if(can('business'))
                <li id="nav_0_2"><a href=" {{ route('category_add') }} ">添加分类</a></li>
            @endif
        </ul>
    </li>

    <li class="menu-list active nav-active" id="nav_1"><a href=""><span>商品管理</span></a>
        <ul class="sub-menu-list">
            <li id="nav_1_1"><a href="{{ route('commodity_list') }}">商品管理</a></li>
            @if(can('business'))
                <li id="nav_1_2"><a href="{{ route('commodity_add') }}">添加商品</a></li>
            @endif
        </ul>
    </li>

    <li class="menu-list active nav-active" id="nav_3"><a href=""><span>订单管理</span></a>
        <ul class="sub-menu-list">
            <li id="nav_3_1"><a href="{{ route('order_list') }}">订单管理</a></li>
        </ul>
    </li>

    @if(can('admin'))
        <li class="menu-list active nav-active" id="nav_2"><a href=""><span>商户/会员管理</span></a>
            <ul class="sub-menu-list">
                <li id="nav_2_1"><a href="{{ route('user_list') }}">会员管理</a></li>
                <li id="nav_2_2"><a href="{{ route('user_add') }}">添加商户</a></li>
            </ul>
        </li>
    @endif
</ul>
<!--sidebar nav end-->
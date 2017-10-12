@inject('car', 'App\Services\Home\CarService')
<a href="/">主页</a>
<a href="{{ route('home.category_list') }}">分类</a>
<a href="{{ route('home.car') }}">购物车<em>{{ $car->count() }}</em></a>
<a href="{{ route('home.person') }}">个人中心</a>
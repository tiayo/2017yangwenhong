@extends('manage.layouts.app')

@section('title', '主页')

@section('style')
    <!--dashboard calendar-->
    <link href="{{ asset('/static/adminex/css/clndr.css') }}" rel="stylesheet">
    @parent
@endsection

@section('breadcrumb')

@endsection

@section('body')
    <div class="col-md-12 text-center">
        <p><img style="width:400px;margin-top: 3em" src="{{ asset('style/media/image/logo.png') }}" alt=""></p>
        <h4>欢迎您: {{ Auth::user()->name }}
            登录
            @if(can('admin'))
                管理员后台
            @elseif(can('business'))
                商户后台
            @endif</h4>
        <h4>服务器时间: {{ date('Y-m-d H:i:s') }}</h4>
        <h4>登录ip:{{ Request::getClientIp() }}</h4>
    </div>
@endsection

@section('script')
    @parent
@endsection

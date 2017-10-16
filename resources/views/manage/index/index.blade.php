@extends('manage.layouts.app')

@section('title', '主页')

@section('style')
    @parent
@endsection

@section('body')
    <div class="col-md-12 text-center">
        <h1>@if(can('admin'))
                管理员后台
            @elseif(can('business'))
                商户后台
                @endif
        </h1>
        <h1></h1>
        <h4>欢迎您: {{ Auth::user()->name }}</h4>
        <h4>服务器时间: {{ date('Y-m-d H:i:s') }}</h4>
        <h4>登录ip:{{ Request::getClientIp() }}</h4>
    </div>
@endsection

@section('script')
    @parent
@endsection

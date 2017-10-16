@extends('home.layouts.app')

@section('title', '登录')

@section('style')
    <style type="text/css">
        .login #logo {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
        }
        .login #logo img {
            float: left;
            width: 100%;
            height: 100%;
        }
        .login .title {
            position: fixed;
            top: 50px;
            width: 100%;
            height: 95px;
            color: #000;
            font-size: 16px;
            letter-spacing: 10px;
            text-indent: 10px;
            text-align: center;
            line-height: 95px;
            z-index: 999;
        }
        .login #login-dialog {
            position: fixed;
            bottom: 95px;
            left: 0;
            right: 0;
            margin: 0 auto;
            width: 74%;
            margin: 0 auto 20px;
            z-index: 999;
        }
        .login #user {
            height: 46px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            background-color: rgba(255, 255, 255, 0.5);
        }
        .login #password {
            height: 46px;
            border: 1px solid #ddd;
            background-color: rgba(255, 255, 255, 0.5);
        }
        .login #user input,
        .login #password input {
            float: right;
            width: 95%;
            height: 26px;
            margin-top: 10px;
            line-height: 25px;
            outline: none;
            border: 0;
            background-color: rgba(255, 255, 255, 0);
        }
        .login #user input::-webkit-input-placeholder,
        .login #password input::-webkit-input-placeholder {
            color: #999;
        }
        .login .login-button {
            position: fixed;
            bottom: 50px;
            left: 0;
            right: 0;
            margin: 0 auto;
            width: 74%;
            height: 45px;
        }
        .login .login-button #login-button {
            float: left;
            width: 45%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.5);
            color: #fff;
            font-size: 16px;
            letter-spacing: 10px;
            text-indent: 10px;
            text-align: center;
            line-height: 45px;
            border: 0;
        }
        .login .login-button #registration-button {
            float: right;
            width: 45%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.5);
            color: #fff;
            font-size: 16px;
            letter-spacing: 10px;
            text-indent: 10px;
            text-align: center;
            line-height: 45px;
            border: 0;
        }
    </style>
@endsection

@section('body')
<div class="login">
    <div id="logo">
        <img src="{{ asset('/style/home/picture/login.jpg') }}"/>
    </div>
    <div class="title">
        欢迎登录
    </div>
    <form action="{{ route('home.login') }}" method="post">
        {{ csrf_field() }}
        <div id="login-dialog">
            <div id="user">
                <input type="email" name="email" placeholder="请输入登录邮箱"/>
            </div>
            <div id="password">
                <input type="password" name="password" placeholder="请输入密码"/>
            </div>

            @foreach($errors as $error)
                <div class="error">{{ $error }}</div>
            @endforeach
        </div>
        <div class="login-button">
            <button type="submit" id="login-button">登录</button>
            <button type="button" id="registration-button" onclick="location='{{ route('home.register') }}'">注册</button>
        </div>
    </form>

</div>
@endsection
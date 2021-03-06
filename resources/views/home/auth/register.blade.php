@extends('home.layouts.app')

@section('title', '注册')

@section('style')
    <style type="text/css">
        .registration #logo {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background: url('{{ asset('/style/home/picture/login.jpg') }}') no-repeat center;
            background-size: 100% 100%;
        }
        .registration .title {
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
        .registration #registration-dialog {
            position: fixed;
            bottom: 95px;
            left: 0;
            right: 0;
            margin: 0 auto;
            width: 74%;
            margin: 0 auto 20px;
            z-index: 999;
        }
        .registration #user {
            height: 35px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            background-color: rgba(255, 255, 255, 0.5);
        }
        .registration #password {
            height: 46px;
            border: 1px solid #ddd;
            background-color: rgba(255, 255, 255, 0.5);
        }
        .registration #user input,
        .registration #password input {
            float: right;
            width: 95%;
            height: 21px;
            margin-top: 10px;
            line-height: 21px;
            outline: none;
            border: 0;
            background-color: rgba(255, 255, 255, 0);
        }
        .registration #user input::-webkit-input-placeholder,
        .registration #password input::-webkit-input-placeholder {
            color: #999;
        }
        .registration #registration-button {
            position: fixed;
            bottom: 50px;
            left: 0;
            right: 0;
            width: 74%;
            height: 45px;
            margin: 0 auto;
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
<div class="registration">
    <div id="logo"></div>
    <div class="title">
        用户注册
    </div>
    <form action="{{ route('home.register') }}" method="post">
        {{ csrf_field() }}
        <div id="registration-dialog">
            <div id="user">
                <input type="email" name="email" placeholder="请输入邮箱" required/>
            </div>
            <div id="user">
                <input type="password" name="password" placeholder="密码" required/>
            </div>
            <div id="user">
                <input type="password" name="password_confirmation" placeholder="确认密码" required/>
            </div>
            <div id="user">
                <input type="text" name="name" placeholder="姓名" required/>
            </div>
            <div id="user">
                <input type="text" name="phone" placeholder="电话" />
            </div>
            <div id="password">
                <input type="text" name="address" placeholder="地址" />
            </div>
        </div>
        <button type="submit" id="registration-button">注册</button>
    </form>
</div>
@endsection
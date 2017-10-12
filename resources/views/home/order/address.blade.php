@extends('home.layouts.app')

@section('title', '修改收货信息')

@section('body')
<div class="add-address">
    <form action="{{ route('home.address') }}" method="post" id="address_form">
        {{ csrf_field() }}
        <ul class="address-info">
            <li>
                <label class="form-input-label">收货人</label>
                <div class="form-input">
                    <input type="text" maxlength="20" name="name" value="{{ $user['name'] }}" id="customerName" placeholder="收货人姓名" required/>
                </div>
            </li>
            <li>
                <label class="form-input-label">联系方式</label>
                <div class="form-input">
                    <input type="text" maxlength="11" name="phone" value="{{ $user['phone'] }}" id="psCustomerTel" placeholder="收货人电话号码" required/>
                </div>
            </li>
            <li class="clearfix">
                <div class="form-textarea clearfix">
                    <label class="form-input-label">详细地址</label>
                    <textarea name="address" id="detailed-address" placeholder="请在此处填写详细地址" required>{{ $user['address'] }}</textarea>
                </div>
            </li>
        </ul>
    </form>
    <button type="submit" class="save">保存</button>
    <div class="mask-false">您还未填写完整的地址信息</div>
</div>

@endsection
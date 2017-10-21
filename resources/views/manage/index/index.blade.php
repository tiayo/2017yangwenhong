@extends('manage.layouts.app')

@section('title', '主页')

@section('style')
    @parent
@endsection

@section('body')
    <div class="col-md-12 text-center" style="margin-top: 18%">
        <h1>@if(can('admin'))
                管理员后台
            @elseif(can('business'))
                商户后台
                @endif
        </h1>
    </div>
@endsection

@section('script')
    @parent
@endsection

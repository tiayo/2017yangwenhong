@extends('manage.layouts.app')

@section('title', '分类管理')

@section('style')
    @parent
@endsection

@section('breadcrumb')
    <li navValue="nav_0"><a href="#">管理专区</a></li>
    <li navValue="nav_0_1"><a href="#">分类管理</a></li>
@endsection

@section('body')
<div class="row">
    <div class="col-md-12">
		<section class="panel">
            <div class="panel-body">
                <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-success dropdown-toggle" type="button">根据商户查看 <span class="caret"></span></button>
                    <ul role="menu" class="dropdown-menu">
                        @foreach($businesses as $business)
                            <li><a href="{{ route('category_search', ['business_id' => $business['id']]) }}">{{ $business['name'] }}</a></li>
                        @endforeach
                    </ul>
                </div>
            <header class="panel-heading">
                分类列表
            </header>
            	<table class="table table-striped table-hover">
		            <thead>
		                <tr>
		                    <th>ID</th>
		                    <th>名称</th>
		                    <th>商户</th>
                            <th>添加时间</th>
							<th>操作</th>
		                </tr>
		            </thead>

		            <tbody id="target">
                        @foreach($lists as $list)
                        <tr>
                            <td>{{ $list['id'] }}</td>
                            <td>{{ $list['name'] }}</td>
                            <td>{{ $list->user->name ?? '未找到' }}</td>
                            <td>{{ $list['created_at'] }}</td>
                            <td>
                                <button class="btn btn-info" type="button" onclick="location='{{ route('category_update', ['id' => $list['id'] ]) }}'">编辑</button>
                                <button class="btn btn-danger" type="button" onclick="javascript:if(confirm('确实要删除吗?'))location='{{ route('category_destroy', ['id' => $list['id'] ]) }}'">删除</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
		        </table>

               {{ $lists->links() }}
            </div>
    	</section>
    </div>
</div>
@endsection

@section('script')
    @parent
@endsection

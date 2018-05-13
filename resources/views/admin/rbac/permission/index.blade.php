@extends('admin.layout') 
@section('action-btn')
<button class="layui-btn layui-btn-normal layui-btn-sm ajax-form" data-url="{{route('add-permission')}}" title="添加权限">
    <i class="layui-icon">&#xe61f;</i> 添加权限
</button>
@endsection

@section('content')
<div class="data-list" data-url="">
    <form class="layui-form inline-form"></form>
    <div class="data">
        <p><i class="fa fa-spinner fa-spin"></i> 加载中...</p>
    </div>
</div>
@endsection
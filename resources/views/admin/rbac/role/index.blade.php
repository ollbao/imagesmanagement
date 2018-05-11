@extends('admin.layout') 
@section('action-btn')
<div class="layui-inline">
    <button class="layui-btn layui-btn-normal layui-btn-sm ajax-form" data-url="{{route('add-role')}}" title="添加角色">
        <i class="layui-icon">&#xe61f;</i> 添加角色
    </button>
</div>
@endsection
@section('content')
<div class="data-list" data-url="">
    <form class="layui-form inline-form"></form>
    <div class="data">
        <p><i class="fa fa-spinner fa-spin"></i> 加载中...</p>
    </div>
</div>
@endsection
@extends('admin.layout') 
@section('action-btn')

<a href="{{ route('images-add') }}" class="layui-btn layui-btn-sm layui-btn-normal" title="上传图片">
    <i class="layui-icon">&#xe61f;</i>上传图片
</a>
@endsection

@section('content')
<div class="data-list" data-url="">
    <form class="layui-form inline-form"></form>
    <div class="data">
        <p><i class="fa fa-spinner fa-spin"></i> 加载中...</p>
    </div>
</div>
@endsection
@extends('admin.layout') 
@section('content')
<div class="layui-card-body">
    <form class="layui-form inline-form">
        <div class="layui-inline">
            <input class="layui-input search-input" name="keyword" placeholder="输入标签搜索">
        </div>
        <div class="layui-inline">
            <button class="layui-btn search-btn layui-btn-normal search"><i class="layui-icon">&#xe615;</i></button>
        </div>
    </form>
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;"></fieldset>
    <ul class="flow-default" id="LAY_demo2">
        @if (count($images))
            @foreach ($images as $vo)
                <li><img lay-src="{{ $vo->show_url }}"></li>
            @endforeach
        @endif
    </ul>
</div>
@endsection
@section('script')
<script>
    layui.use(['flow','lea'], function(){
        var flow = layui.flow;
        var firstUrl = "{{ $images->url(1) }}";//第一页url
        flow.load({
            elem: '#LAY_demo2' //流加载容器
            ,isAuto: false
            ,isLazyimg: true
            ,scrollElem: '.layui-card-body'
            ,done: function(page, next){ //加载下一页
                var lis = [];
                var currentUrl = firstUrl.replace(/page=1/, "page="+(page+1))
                //以jQuery的Ajax请求为例，请求下一页数据（注意：page是从2开始返回）
                $.get(currentUrl, function(res){
                    //假设你的列表返回在data集合中
                    layui.each(res.data, function(index, item){
                    lis.push('<li><img lay-src="'+ item.show_url +'"></li>');
                    }); 
                    //执行下一页渲染，第二参数为：满足“加载更多”的条件，即后面仍有分页
                    //pages为Ajax返回的总页数，只有当前页小于总页数的情况下，才会继续出现加载更多
                    next(lis.join(''), page < res.last_page); 
                }, 'json');
            }
        });
    });
</script>
@endsection
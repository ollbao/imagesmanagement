<style type="text/css">
table .html {
    font-family: Arial;
    padding-right: 4px;
}
</style>
<table class="layui-hide" lay-filter="demo">
    <thead>
        <tr>
            <th lay-data="{field:'id'}">#</th>
            <th lay-data="{field:'show_url',align:'center'}">图片</th>
            <th lay-data="{field:'image_source'}">图片来源</th>
            <th lay-data="{field:'description',width:300}">描述</th>
            <th lay-data="{field:'nickname'}">上传用户</th>
            <th lay-data="{field:'created_at'}">上传时间</th>
            <th lay-data="{field:'action'}">操作</th>
        </tr>
    </thead>
    <tbody>
        @if (count($images))
            @foreach ($images as $vo)
            <tr>
                <td>{{ $vo->id }}</td>
                <td><img src="{{ $vo->show_url }}"></td>
                <td>
                    <div class="text-left"> <a href="{{ $vo->source_link }}">{{ $vo->image_source }}</a></div>
                </td>
                <td>{{ $vo->description }}</td>
                <td>{{ $vo->admin->nickname }}</td>
                <td>{{ $vo->created_at }}</td>
                
                <td>
                    <a href="{{ route('images-edit',['id'=>$vo['id']]) }}" class="layui-btn layui-btn-xs layui-btn-normal  ajax-form" title="修改图片">修改</a>
                    <a href="{{ route('images-delete',['id'=>$vo['id']]) }}" title="删除" confirm="1" class="layui-btn layui-btn-xs layui-btn-danger  ajax-post">删除</a>
                </td>
            </tr>
            @endforeach
        @endif
    </tbody>
</table>
<div id="test1"></div>

<script>
layui.use(['table', 'laypage'], function(){
    var table = layui.table;
    var laypage = layui.laypage;
    //转换静态表格
    table.init('demo', {
        //size : 'sm',
        limit : {{ $images->perPage() }}
    });
    
    laypage.render({
        elem : 'test1', 
        limit : {{ $images->perPage() }},
        count : {{ $images->total() }}, 
        layout : ['prev', 'page', 'next', 'count', 'limit', 'skip'],
        curr : {{ $images->currentPage()}}

    });
});
</script>
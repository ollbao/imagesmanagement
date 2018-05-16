<style type="text/css">
table .html {
    font-family: Arial;
    padding-right: 4px;
}
</style>
<table class="layui-table" lay-size="sm">
    <thead>
        <tr>
            <th style="width: 48px">#</th>
            <th>图片</th>
            <th>标签</th>
            <th>图片来源</th>
            <th>描述</th>
            <th>上传用户</th>
            <th>上传时间</th>
            {{-- <th>操作</th> --}}
        </tr>
    </thead>
    <tbody>
        @if (count($images))
            @foreach ($images as $vo)
            <tr>
                <td>{{ $vo->id }}</td>
                <td><a target="_blank" href="{{ $vo->show_url }}"><img height="50px" src="{{ $vo->show_url }}"></a></td>
                <td>
                    <div class="text-left"> {{ $vo->tag }}</div>
                </td>
                <td>
                    <div class="text-left"> <a href="{{ $vo->source_link }}">{{ $vo->image_source }}</a></div>
                </td>
                <td>{{ $vo->description }}</td>
                <td>{{ $vo->admin->nickname }}</td>
                <td>{{ $vo->created_at }}</td>
                
                {{-- <td>
                    <a href="{{ route('edit-permission',['id'=>$vo['id']]) }}" class="layui-btn layui-btn-xs layui-btn-normal  ajax-form" title="修改规则">修改</a>
                    <a href="{{ route('delete-permission',['id'=>$vo['id']]) }}" title="删除" confirm="1" class="layui-btn layui-btn-xs layui-btn-danger  ajax-post">删除</a>
                </td> --}}
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
        limit : {{ $images->perPage() }},
        initSort: {
            field: 'name' //排序字段，对应 cols 设定的各字段名
            ,type: 'desc' //排序方式  asc: 升序、desc: 降序、null: 默认排序
        }
        
    }); 

        //监听工具条
    table.on('tool(demo)', function(obj){ //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
    var data = obj.data; //获得当前行数据
    var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）
    var tr = obj.tr; //获得当前行 tr 的DOM对象
    
    if(layEvent === 'detail'){ //查看
        //do somehing
    } else if(layEvent === 'del'){ //删除
        layer.confirm('真的删除行么', function(index){
        obj.del(); //删除对应行（tr）的DOM结构，并更新缓存
        layer.close(index);
        //向服务端发送删除指令
        });
    } else if(layEvent === 'edit'){ //编辑
        //do something
        
        //同步更新缓存对应的值
        obj.update({
        username: '123'
        ,title: 'xxx'
        });
    }
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
<table class="layui-hide" lay-filter="demo">
    <thead>
        <tr>
            <th lay-data="{type:'checkbox'}"></th>
            <th lay-data="{field:'id',title:'ID'}"></th>
            <th lay-data="{field:'nickname',title:'昵称'}"></th>
            <th lay-data="{field:'mobile',title:'手机号'}"></th>
            <th lay-data="{field:'action',title:'操作'}"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($record as $vo)
        <tr>
            <td></td>
            <td>{{ $vo->id }}</td>
            <td>{{ $vo->nickname }}</td>
            <td>{{ $vo->mobile }}</td>
            <td>
                <a href="" class="layui-btn layui-btn-xs layui-btn-normal  ajax-form" title="修改规则">修改</a>
            </td>
        </tr>
        @endforeach
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
        limit : {{ $record->perPage() }},
        initSort: {
            field: 'nickname' //排序字段，对应 cols 设定的各字段名
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
        limit : {{ $record->perPage() }},
        count : {{ $record->total() }}, 
        layout : ['prev', 'page', 'next', 'count', 'limit', 'skip'],
        curr : {{ $record->currentPage()}}

    });
});
</script>

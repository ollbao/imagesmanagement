<table class="layui-hide" lay-filter="demo">
    <thead>
        <tr>
            <th lay-data="{type:'checkbox'}"></th>
            <th lay-data="{field:'id',title:'ID'}"></th>
            <th lay-data="{field:'name',title:'昵称'}"></th>
            <th lay-data="{field:'email',title:'邮箱'}"></th>
            <th lay-data="{field:'action',title:'操作'}"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($record as $vo)
        <tr>
            <td></td>
            <td>{{ $vo->id }}</td>
            <td>{{ $vo->name }}</td>
            <td>{{ $vo->email }}</td>
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
            field: 'name' //排序字段，对应 cols 设定的各字段名
            ,type: 'desc' //排序方式  asc: 升序、desc: 降序、null: 默认排序
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

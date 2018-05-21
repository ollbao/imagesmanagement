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
                <th lay-data="{field:'show_url'}">图片</th>
                <th lay-data="{field:'scenes'}">使用场景</th>
                <th lay-data="{field:'url'}">线上地址</th>
                <th lay-data="{field:'description'}">描述</th>
                <th lay-data="{field:'admin_name'}">下载用户</th>
                <th lay-data="{field:'created_at'}">下载时间</th>
            </tr>
        </thead>
        <tbody>
            @if (count($downloadHistories))
                @foreach ($downloadHistories as $vo)
                <tr>
                    <td>{{ $vo->id }}</td>
                    <td><img src="{{ $vo->image->show_url }}"></td>
                    <td>
                        <div class="text-left"> {{ $vo->scenes }}</div>
                    </td>
                    <td>
                        <div class="text-left"> {{ $vo->url }}</div>
                    </td>
                    <td>{{ $vo->description }}</td>
                    <td>{{ $vo->admin_name }}</td>
                    <td>{{ $vo->created_at }}</td>
                    
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
            limit : {{ $downloadHistories->perPage() }},
        }); 
        
        laypage.render({
            elem : 'test1', 
            limit : {{ $downloadHistories->perPage() }},
            count : {{ $downloadHistories->total() }}, 
            layout : ['prev', 'page', 'next', 'count', 'limit', 'skip'],
            curr : {{ $downloadHistories->currentPage()}}
    
        });
    });
    </script>
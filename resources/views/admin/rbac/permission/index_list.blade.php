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
            <th>
                <div class="text-left">权限标题</div>
            </th>
            <th>
                <div class="text-left">权限名称</div>
            </th>
            <th>图标</th>
            <td>菜单</td>
            <th style="width: 80px">排序</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($record as $vo)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>
                <div class="text-left"><span class="html">{{ $vo['html'] }}</span> {{ $vo['title'] }}</div>
            </td>
            <td>
                <div class="text-left"> {{ $vo['name'] }}</div>
            </td>
            <td><i class="{{ $vo['icon'] }}"></i></td>
            <td><a href="{{ route('menu-permission',['is_menu'=>abs(1-$vo['is_menu']),'id'=>$vo['id']]) }}" class="ajax-post" title="更改" confirm="1" >@if($vo['is_menu'])<span class="text-red">是</span>@else<span>否</span>@endif</a></td>
            <td>
                <input type="number" name="sort" data-url="{{ route('sort-permission',['id'=>$vo['id']]) }}" class="layui-input layui-input-xs input-sort" value="{{$vo['sort']}}" data-val="{{$vo['sort']}}">
            </td>
            </td>
            <td>
                <a href="{{ route('edit-permission',['id'=>$vo['id']]) }}" class="layui-btn layui-btn-xs layui-btn-normal  ajax-form" title="修改规则">修改</a>
                <a href="{{ route('delete-permission',['id'=>$vo['id']]) }}" title="删除" confirm="1" class="layui-btn layui-btn-xs layui-btn-danger  ajax-post">删除</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
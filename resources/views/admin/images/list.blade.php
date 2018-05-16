@extends('admin.layout') 
@section('content')
<div class="layui-card-body">
    <form class="layui-form inline-form" method="GET">
        <div class="layui-inline">
            <input class="layui-input search-input" name="tag" value="{{ Request::get('tag') }}" placeholder="输入标签搜索,多个标签用空格分隔">
        </div>
        <div class="layui-inline">
            <button class="layui-btn search-btn layui-btn-normal"><i class="layui-icon">&#xe615;</i></button>
        </div>
    </form>
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>点击图片 - 下载原图</legend>
    </fieldset>
    <ul class="flow-default" id="LAY_demo2"></ul>
</div>
@endsection
@section('script')
<script>
    layui.use(['flow','lea', 'layer', 'form'], function(){
        var flow = layui.flow,layer = layui.layer,form = layui.form;
        var firstUrl = "{!! $pageUrl !!}";//第一页url
        var downUrl = "{{ route('images-down',['id'=>1]) }}";
        flow.load({
            elem: '#LAY_demo2' //流加载容器
            ,isAuto: false
            ,isLazyimg: true
            ,scrollElem: '.layui-card-body'
            ,done: function(page, next){ //加载下一页
                var lis = [];
                var currentUrl = firstUrl.replace(/page=1/, "page="+page);
                //以jQuery的Ajax请求为例，请求下一页数据（注意：page是从2开始返回）
                $.get(currentUrl, function(res){
                    //假设你的列表返回在data集合中
                    layui.each(res.data, function(index, item){
                        var currentDownUrl = downUrl.replace(/down\/1/, "down/"+item.id);
                        lis.push('<li><a href="'+ currentDownUrl +'" class="ajax-form-down" title="下载图片"><img lay-src="'+ item.show_url +'"></a></li>');
                    }); 
                    //执行下一页渲染，第二参数为：满足“加载更多”的条件，即后面仍有分页
                    //pages为Ajax返回的总页数，只有当前页小于总页数的情况下，才会继续出现加载更多
                    next(lis.join(''), page < res.last_page); 
                }, 'json');
            }
        });
        
        $(document).on('click', '.ajax-form-down', function(event) {
            event.preventDefault();
            var self = $(this);
            if (self.attr('disabled')) return false;
            var url = self.attr('href') || self.data('url');
            if (!url) return;
            $.get(url, function(html) {
                if (typeof html === 'object') {
                    layer.msg(html.msg);
                    return false;
                }
                layer.open({
                    type: 1,
                    title: self.attr('title'),
                    content: html,
                    scrollbar: true,
                    maxWidth:'90%',
                    btn: ['确定', '取消'],
                    yes: function(index, layero) {
                        var scenes = $("#scenes").val();
                        var url = $("#url").val();
                        if(!scenes){
                            layer.msg('使用场景不能为空', { time: 1200 });
                            return false;
                        }
                        if(!url){
                            layer.msg('线上地址不能为空', { time: 1200 });
                            return false;
                        }
                        if ($(layero).find('.layui-layer-btn0').attr('disabled')) {
                            return false;
                        }
                        $(layero).find('.layui-layer-btn0').attr('disabled', 'disabled');
                        var _form = $(layero).find('form');
                        _form.submit();
                        layer.msg('开始下载', { time: 1200 }, function() {
                            layer.close(index);
                        });
                        
                    },
                    btn2: function(index) {
                        layer.close(index);
                    },
                    success: function() {
                        form.render();
                    }
                }, 'html');
            });
            return false;
        });


    });
</script>
@endsection
@extends('admin.layout') 
@section('style')
<link href="/backend/css/zzsc.css" type="text/css" rel="stylesheet" />    
@endsection
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
    {{-- 瀑布流 --}}
    <div id="waterfall">
        @if (count($images))
            @foreach ($images as $item)
                <div class="cell"><a href="{{ route('images-down',['id'=>$item->id]) }}" class="ajax-form-down"><img src="{{ $item->show_url }}" /></a><p>{{ $item->description }}</p></div>
            @endforeach
        @else
            <p>没有更多数据了</p>
        @endif
    </div>
@endsection
@section('script')
<script src="/backend/js/waterfall.js"></script>
<script>
    layui.use(['flow','lea', 'layer', 'form'], function(){
        var flow = layui.flow,layer = layui.layer,form = layui.form;
        
        // flow.load({
        //     elem: '#LAY_demo2' //流加载容器
        //     ,isAuto: false
        //     ,isLazyimg: true
        //     ,scrollElem: '.layui-card-body'
        //     ,done: function(page, next){ //加载下一页
        //         var lis = [];
        //         var currentUrl = firstUrl.replace(/page=1/, "page="+page);
        //         //以jQuery的Ajax请求为例，请求下一页数据（注意：page是从2开始返回）
        //         $.get(currentUrl, function(res){
        //             //假设你的列表返回在data集合中
        //             layui.each(res.data, function(index, item){
        //                 var currentDownUrl = downUrl.replace(/down\/1/, "down/"+item.id);
        //                 lis.push('<li><a href="'+ currentDownUrl +'" class="ajax-form-down" title="下载图片"><img lay-src="'+ item.show_url +'"></a></li>');
        //             }); 
        //             //执行下一页渲染，第二参数为：满足“加载更多”的条件，即后面仍有分页
        //             //pages为Ajax返回的总页数，只有当前页小于总页数的情况下，才会继续出现加载更多
        //             next(lis.join(''), page < res.last_page); 
        //         }, 'json');
        //     }
        // });
        
        //瀑布流
        function htmlStr(res) {
            var downUrl = "{{ route('images-down',['id'=>1]) }}";
            var str = '';
            for (var i = 0; i < res.length; i++) {
                var currentDownUrl = downUrl.replace(/down\/1/, "down/"+ res[i].id);
                str +='<div class="cell"><a href="'+ currentDownUrl +'" class="ajax-form-down"><img src="'+ res[i].show_url +'" /></a><p><a href="">'+ res[i].description +'</a></p></div>'
            }
            return str;
        }

        var opt={
            getResource:function(index,render){//index为已加载次数,render为渲染接口函数,接受一个dom集合或jquery对象作为参数。通过ajax等异步方法得到的数据可以传入该接口进行渲染，如 render(elem)
                var firstUrl = "{!! $pageUrl !!}";//第一页url
                var currentUrl = firstUrl.replace(/page=1/, "page="+index);
                layer.msg('正在加载..');
                $.get(currentUrl, function(res){
                    if (index <= res.last_page) {
                        var html=htmlStr(res.data);
                        render($(html)) ;
                    }else{
                        layer.msg('没有更多数据了');
                        $.waterfall.load_index = index-1
                        return;
                    }
                }, 'json');
            },
            scroll_body:".main",
            auto_imgHeight:true,
            insert_type:1
        }
        $('#waterfall').waterfall(opt);

        //下载弹框
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
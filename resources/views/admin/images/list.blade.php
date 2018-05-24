@extends('admin.layout') 
@section('style')
<link href="/backend/css/zzsc.css" type="text/css" rel="stylesheet" />    
@endsection
@section('content')
<div class="layui-card-body">
    <form class="layui-form inline-form" method="GET">
        <div class="layui-inline">
            <input class="layui-input search-input" name="tag" value="{{ Request::get('tag') }}" placeholder="输入搜索内容">
        </div>
        <div class="layui-inline">
            <button class="layui-btn search-btn layui-btn-normal"><i class="layui-icon">&#xe615;</i></button>
        </div>
    </form>
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>
            <div class="layui-btn-group">
                <button id="select-all" class="layui-btn layui-btn-primary layui-btn-sm">选择全部</button>
                <button id="cancel-select-all" class="layui-btn layui-btn-primary layui-btn-sm">取消选择</button>
                <button id="down-select" class="layui-btn layui-btn-primary layui-btn-sm">下载原图</button>
            </div>
        </legend>
    </fieldset>
    {{-- 瀑布流 --}}
    <div class="waterfall" id="waterfall">
        @if (count($images))
            @foreach ($images as $item)
                <div class="cell" data-id="{{ $item->id }}"><span class="duigou"></span><a href="javascript:void(0);" ><img src="{{ $item->show_url }}" /></a><p>{{ $item->description }}</p></div>
            @endforeach
        @else
            <p>没有更多数据了</p>
        @endif
    </div>
@endsection
@section('script')
<script src="/backend/js/waterfall.js"></script>
<script>
    layui.use(['lea', 'layer', 'form'], function(){
        var layer = layui.layer,form = layui.form;
        
        //瀑布流
        function htmlStr(res) {
            var downUrl = "{{ route('images-down',['id'=>1]) }}";
            var str = '';
            for (var i = 0; i < res.length; i++) {
                var currentDownUrl = downUrl.replace(/down\/1/, "down/"+ res[i].id);
                str +='<div class="cell" data-id="'+ res[i].id +'"><span class="duigou"></span><a href="javascript:void(0);"><img src="'+ res[i].show_url +'" /></a><p>'+ res[i].description +'</p></div>'
            }
            return str;
        }
        var loading_flag = true;
        var opt={
            getResource:function(index,render){//index为已加载次数,render为渲染接口函数,接受一个dom集合或jquery对象作为参数。通过ajax等异步方法得到的数据可以传入该接口进行渲染，如 render(elem)
                var firstUrl = "{!! $pageUrl !!}";//第一页url
                var currentUrl = firstUrl.replace(/page=1/, "page="+index);
                if(loading_flag){
                    layer.msg('正在加载..');
                    $.get(currentUrl, function(res){
                        if (index <= res.last_page) {
                            var html=htmlStr(res.data);
                            render($(html)) ;
                        }else{
                            layer.msg('没有更多数据了');
                            //$.waterfall.load_index = index-1
                            loading_flag = false;
                            return;
                        }
                    }, 'json');
                }
            },
            scroll_body:".main",
            auto_imgHeight:true,
            insert_type:1
        }
        $('#waterfall').waterfall(opt);

        //选择样式
        $(document).on('click', '.cell', function(){
            if($(this).hasClass("cell-on")){
                $(this).removeClass("cell-on");
                $(this).find(".duigou").hide();
            }else{
                $(this).addClass("cell-on");
                $(this).find(".duigou").show();
            } 
        });
        //全部选择
        $(document).on('click', '#select-all', function(){
            $(".waterfall").find(".cell").addClass("cell-on").find(".duigou").show();
        });
        //取消选择
        $(document).on('click', '#cancel-select-all', function(){
            $(".waterfall").find(".cell-on").removeClass("cell-on").find(".duigou").hide();
        });
        //下载
        function download(name, href) {
            var a = document.createElement("a"), //创建a标签
                e = document.createEvent("MouseEvents"); //创建鼠标事件对象
            e.initEvent("click", false, false); //初始化事件对象
            a.href = href; //设置下载地址
            a.download = name; //设置下载文件名
            a.dispatchEvent(e); //给指定的元素，执行事件click事件
        }

        $(document).on('click', '#down-select', function(event){
            var select_val = $(".waterfall").find(".cell-on");
            if(select_val.length > 0){
                // var id_arr = [];
                // select_val.each(function(i){
                //     id_arr.push($(this).attr("data-id"));
                // });
                event.preventDefault();
                $.get("{{ route('images-down') }}", function(html) {
                    if (typeof html === 'object') {
                        layer.msg(html.msg);
                        return false;
                    }
                    layer.open({
                        type: 1,
                        title: '图片下载',
                        content: html,
                        scrollbar: true,
                        maxWidth:'90%',
                        btn: ['确定', '取消'],
                        yes: function(index, layero) {
                            var scenes = $("#scenes").val();
                            var url = $("#url").val();
                            var description = $("#description").val();
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
                            var down_url = [];
                            select_val.each(function(i){
                                var down_id = $(this).attr("data-id");
                                //alert($("#down-id").val());
                                down_url.push("{{ route('images-down') }}"+ "?id="+ down_id +"&scenes="+ scenes +"&url="+ url +"&description="+ description); 
                            });
                            layer.msg('开始下载', { time: 1200 }, function() {
                                layer.close(index);
                            });
                            for (let index = 0; index < down_url.length; index++) {
                                download('第' + index + '个文件', down_url[index]);
                            }
                            
                        },
                        btn2: function(index) {
                            layer.close(index);
                        },
                        success: function() {
                            form.render();
                        }
                    }, 'html');
                });
            }else{
                layer.msg('请选择要下载的图片');
            }
        });
    });
</script>
@endsection
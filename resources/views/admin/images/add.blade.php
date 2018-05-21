@extends('admin.layout') 
@section('content')
<div class="layui-card-body">
    <div class="layui-upload">
        <button type="button" class="layui-btn layui-btn-normal" id="testList">选择图片</button> 
        <button type="button" class="layui-btn" id="testListAction">开始上传</button>
        <div class="layui-upload-list">
            <table class="layui-table">
            <thead>
                <tr><th>图片</th>
                <th>来源 / 链接</th>
                <th>描述</th>
                <th>状态</th>
                <th>操作</th>
            </tr></thead>
            <tbody id="demoList"></tbody>
            </table>
        </div>
        
    </div> 
    <fieldset class="layui-elem-field">
        <legend>已上传的图片</legend>
        <div class="layui-field-box">
            <ul class="flow-default" id="show-images">
                
            </ul>
        </div>
    </fieldset>
</div>
@endsection
@section('script')
<script>
    layui.use(['upload','lea'], function(){
        var $ = layui.jquery,upload = layui.upload,lea = layui.lea;
        //多文件列表示例
        var demoListView = $('#demoList')
        ,uploadListIns = upload.render({
            elem: '#testList'
            ,url: '{{ route('images-add') }}'
            ,accept: 'images'
            ,multiple: true
            ,auto: false
            ,bindAction: '#testListAction'
            ,field: 'image'
            ,choose: function(obj){
                var len = $('#demoList tr').length;
                // if(len == 1){
                //     layer.msg('最多同时只能上传1张图片', {icon: 5});
                //     return;
                // }
                var files = this.files = obj.pushFile(); //将每次选择的文件追加到文件队列
                //读取本地文件
                obj.preview(function(index, file, result){
                    var tr = $(['<tr id="upload-'+ index +'" data-filename="'+ file.name +'">'
                    ,'<td><img class="layui-upload-img" src="'+ result +'" ></td>'
                    ,'<td>'
                    ,'<input type="text" placeholder="图片来源 (必填)" value="" class="layui-input image_source">'
                    ,'<fieldset class="layui-elem-field layui-field-title" style="margin-bottom:10px;"></fieldset>'
                    ,'<input type="text" name="source_link" placeholder="来源链接 (必填) http://" value="" class="layui-input source_link">'
                    ,'</td>'
                    ,'<td><textarea placeholder="描述 (必填)" name="description" class="layui-textarea description">'+ file.name.substring(0,file.name.lastIndexOf(".")) +'</textarea></td>'
                    ,'<td style="width: 120px;">等待上传</td>'
                    ,'<td style="width: 100px;">'
                        ,'<button class="layui-btn layui-btn-sm demo-reload layui-hide">重传</button>'
                        ,'<button class="layui-btn layui-btn-sm layui-btn-danger demo-delete">删除</button>'
                    ,'</td>'
                    ,'</tr>'].join(''));
                    
                    //单个重传
                    tr.find('.demo-reload').on('click', function(){
                        obj.upload(index, file);
                    });
                    
                    //删除
                    tr.find('.demo-delete').on('click', function(){
                        delete files[index]; //删除对应的文件
                        tr.remove();
                        uploadListIns.config.elem.next()[0].value = ''; //清空 input file 值，以免删除后出现同名文件不可选
                    });
                    
                    demoListView.append(tr);
                    
                });
            }
            ,before: function(obj){
                var tr_dom = document.querySelectorAll("#demoList tr");
                var ids=[];
                var  that=this;
                //that.data.des=[];
                that.data = {};
                [].forEach.call(tr_dom, function(el,index){
                    var id=$(el).attr("data-filename");
                    var image_source=$(el).find(".image_source").val();
                    var source_link=$(el).find(".source_link").val();
                    var description=$(el).find(".description").val();
                    var value = {
                        "image_source":image_source,
                        "source_link":source_link,
                        "description":description
                    };
                    that.data[id]= JSON.stringify(value);
                });
            }
            ,done: function(res, index, upload){
                if(res.code == 0){ //上传成功
                    var tr = demoListView.find('tr#upload-'+ index)
                    ,tds = tr.children();
                    tds.eq(3).html('<span style="color: #5FB878;">上传成功</span>');
                    //tds.eq(4).html(''); //清空操作
                    $("#show-images").append('<li><a target="_blank" href="'+ res.data.show_url +'"><img src="'+ res.data.show_url +'"></a></li>');
                    layer.msg('上传成功', { time: 1000 }, function() {
                        tr.remove();
                    });
                    return delete this.files[index]; //删除文件队列已经上传成功的文件
                }
                //layer.msg(lea.msg(res.msg));
                var err_msg = lea.msg(res.msg);
                this.error(index, upload, err_msg);
            }
            ,error: function(index, upload, msg){
                if(msg == undefined){
                    msg = '上传失败';
                }
                var tr = demoListView.find('tr#upload-'+ index)
                ,tds = tr.children();
                //tds.eq(4).html('<span style="color: #FF5722;">上传失败</span>');
                tds.eq(3).html('<span style="color: #FF5722;">'+ msg +'</span>');
                tds.eq(4).find('.demo-reload').removeClass('layui-hide'); //显示重传
            }
        });
    });
</script>
@endsection
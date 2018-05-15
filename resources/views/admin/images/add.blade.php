@extends('admin.layout') 
@section('content')
<div class="layui-card-body">
    <div class="layui-upload">
        <button type="button" class="layui-btn layui-btn-normal" id="testList">选择图片</button> 
        <button type="button" class="layui-btn" id="testListAction">开始上传</button>
        <div class="layui-upload-list">
            <table class="layui-table">
            <thead>
                <tr><th>文件名</th>
                <th>大小</th>
                <th>标签</th>
                <th>状态</th>
                <th>操作</th>
            </tr></thead>
            <tbody id="demoList"></tbody>
            </table>
        </div>
        
    </div> 
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
            ,multiple: false
            ,auto: false
            ,bindAction: '#testListAction'
            ,field: 'image'
            ,choose: function(obj){
                var len = $('#demoList tr').length;
                if(len == 1){
                    layer.msg('最多同时只能上传1张图片', {icon: 5});
                    return;
                }
                var files = this.files = obj.pushFile(); //将每次选择的文件追加到文件队列
                //读取本地文件
                obj.preview(function(index, file, result){
                    var tr = $(['<tr id="upload-'+ index +'">'
                    ,'<td><img class="layui-upload-img" src="'+ result +'" ></td>'
                    ,'<td>'+ (file.size/1014).toFixed(1) +'kb</td>'
                    ,'<td><textarea placeholder="请输入标签内容,多个标签用逗号分隔" id="tag" class="layui-textarea"></textarea></td>'
                    ,'<td>等待上传</td>'
                    ,'<td>'
                        ,'<button class="layui-btn layui-btn-mini demo-reload layui-hide">重传</button>'
                        ,'<button class="layui-btn layui-btn-mini layui-btn-danger demo-delete">删除</button>'
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
                var tag_val = $("#tag").val();
                this.data.tag = tag_val;
            }
            ,done: function(res, index, upload){
                if(res.code == 0){ //上传成功
                    var tr = demoListView.find('tr#upload-'+ index)
                    ,tds = tr.children();
                    tds.eq(3).html('<span style="color: #5FB878;">上传成功</span>');
                    //tds.eq(4).html(''); //清空操作
                    return delete this.files[index]; //删除文件队列已经上传成功的文件
                }
                layer.msg(lea.msg(res.msg));
                this.error(index, upload);
            }
            ,error: function(index, upload){
                var tr = demoListView.find('tr#upload-'+ index)
                ,tds = tr.children();
                tds.eq(3).html('<span style="color: #FF5722;">上传失败</span>');
                tds.eq(4).find('.demo-reload').removeClass('layui-hide'); //显示重传
            }
        });
    });
</script>
@endsection
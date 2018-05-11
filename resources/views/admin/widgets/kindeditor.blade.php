<div>
    @php
        $id = isset($id)?$id:$field;
        $value = isset($value)?$value:'';
        $width = isset($width)?$width:'100%';
        $height = isset($height)?$height:'240px';
        $resource = isset($resource)?$resource:true;
    @endphp
    @if($resource)
        <link rel="stylesheet" href="/backend/plugins/kindeditor/themes/default/default.css" />
        <script charset="utf-8" src="/backend/plugins/kindeditor/kindeditor-all.js"></script>
    @endif
    <textarea id="{{$id}}" name="{{$field}}" style="width:{{$width}};height:{{$height}};">{!! $value !!}</textarea>
    <script type="text/javascript">
        (function(KindEditor){
            var editor = KindEditor.create('#{{$id}}', {
            allowFileManager : false,
            uploadJson: "{!! App\Service\Qiniu::ins()->uploadUrlWithCallback('image') !!}",
            filePostName:"file",
            formatUploadUrl: false,
            videoHost:"{!! App\Service\Qiniu::ins()->uploadUrlWithCallback('file') !!}",
            filterMode: true,
            afterBlur: function() {
                this.sync();
            }
        });
        })(KindEditor);
    </script>
</div>
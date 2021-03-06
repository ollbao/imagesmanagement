<div class="layui-card-body">
    <form class="layui-form" action="{{ url()->current() }}" style="width: 500px;" method="post">
        <div class="layui-form-item">
            <label class="layui-form-label">图片来源</label>
            <div class="layui-input-block">
                <input type="text" name="image_source" placeholder="图片来源" value="{{ $image->image_source }}" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">来源链接</label>
            <div class="layui-input-block">
                <input type="text" name="source_link" placeholder="来源链接" value="{{ $image->source_link }}" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">描述</label>
            <div class="layui-input-block">
            <textarea name="description" class="layui-textarea" placeholder="描述">{{ $image->description }}</textarea>
            </div>
        </div>
    </form>
</div>
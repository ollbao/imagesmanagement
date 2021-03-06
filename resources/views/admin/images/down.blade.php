<div class="layui-card-body">
    <form class="layui-form" style="width: 500px;">
        <div class="layui-form-item">
            <label class="layui-form-label">使用场景</label>
            <div class="layui-input-block">
                <input type="text" name="scenes" id="scenes" placeholder="使用场景" lay-verify="required" value="" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">线上地址</label>
            <div class="layui-input-block">
                <input type="text" name="url" id="url" lay-verify="required|url" placeholder="线上地址" value="" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">描述</label>
            <div class="layui-input-block">
                <textarea placeholder="使用描述" name="description" id="description" class="layui-textarea"></textarea>
            </div>
        </div>
    </form>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">允许上传的图片类型</label>
    <div class="layui-input-block">
        <input type="text" name="setting[upload_allowext]" title="允许上传的图片类型" placeholder="允许上传的图片类型" value="<?php echo !isset($setting['upload_allowext'])?'gif|jpg|jpeg|png|bmp':$setting['upload_allowext']; ?>" class="layui-input typeahead">
    </div>
</div>
<input value="text" type="hidden" name="setting[fieldtype]" />
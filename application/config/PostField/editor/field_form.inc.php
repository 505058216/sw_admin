<div class="layui-form-item">
    <label class="layui-form-label">默认值</label>
    <div class="layui-input-block">
        <input type="text" name="setting[defaultvalue]" placeholder="默认值" value="<?php echo !isset($setting['defaultvalue'])?'':$setting['defaultvalue']; ?>" autocomplete="off" class="layui-input">
    </div>
</div>

<input value="text" type="hidden" name="setting[fieldtype]" />
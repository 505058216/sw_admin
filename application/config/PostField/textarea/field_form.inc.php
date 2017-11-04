<div class="layui-form-item">
    <label class="layui-form-label">默认值</label>
    <div class="layui-input-block">
        <input type="text" name="setting[defaultvalue]" title="默认值" placeholder="默认值" value="<?php echo !isset($setting['defaultvalue'])?'':$setting['defaultvalue']; ?>" class="layui-input typeahead">
    </div>
</div>
<input value="text" type="hidden" name="setting[fieldtype]" />
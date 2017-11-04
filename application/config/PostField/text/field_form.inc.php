<div class="layui-form-item">
    <label class="layui-form-label">默认值</label>
    <div class="layui-input-block">
        <input type="text" name="setting[defaultvalue]" title="默认值" placeholder="默认值" value="<?php echo !isset($setting['defaultvalue'])?'':$setting['defaultvalue']; ?>" class="layui-input typeahead">
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">是否为密码框</label>
    <div class="layui-input-block">
        <select name='setting[ispassword]' class='layui-select full-width field-select' style='display:block'>
            <option <?php if( !isset($setting['ispassword'])?'':$setting['ispassword'] == 0 ){ echo 'selected'; } ?> value="0">否</option>
            <option <?php if( !isset($setting['ispassword'])?'':$setting['ispassword'] == 1 ){ echo 'selected'; } ?> value="1">是</option>
        </select>
    </div>
</div>
<input value="varchar" type="hidden" name="setting[fieldtype]" />
<input value="255" type="hidden" name="setting[maxlength]" />
<div class="layui-form-item">
  <label class="layui-form-label">菜单ID</label>
  <div class="layui-input-block">
    <input type="number" name="setting[linkageid]" placeholder="输入框大小" value="<?php echo !isset($setting['linkageid'])?'':$setting['linkageid']; ?>" class="layui-input">
  </div>
</div>

<div class="layui-form-item">
  <label class="layui-form-label">是否作为筛选字段</label>
  <div class="layui-input-block">
    <select name='setting[filtertype]' class='layui-select full-width field-select' style='display:block'>
      <option <?php if( !isset($setting['filtertype'])?'':$setting['filtertype'] == 0 ){ echo 'selected'; } ?> value="0">否</option>
      <option <?php if( !isset($setting['filtertype'])?'':$setting['filtertype'] == 1 ){ echo 'selected'; } ?> value="1">是</option>
    </select>
  </div>
</div>
<input value="int" type="hidden" name="setting[fieldtype]" />
<input value="11" type="hidden" name="setting[maxlength]" />
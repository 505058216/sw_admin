<div class="layui-form-item">
	<label class="layui-form-label">时间格式</label>
	<div class="layui-input-inline">
		<select name='setting[outputtype]' class='layui-select full-width field-select' style='display:block'>
			<option <?php if( !isset($setting['fieldtype'])?'':$setting['fieldtype'] == 'datetime' ){ echo 'selected'; } ?> value="datetime" >日期+24小时制时间（<?=date('Y-m-d H:i:s')?>）</option>
			<option <?php if( !isset($setting['fieldtype'])?'':$setting['fieldtype'] == 'date' ){ echo 'selected'; } ?> value="date" >日期（<?=date('Y-m-d')?>）</option>
		</select>
	</div>
	<div class="layui-input-inline">
		<input type="text" name="setting[format]" placeholder="自定义" value="<?php echo !isset($setting['format'])?'':$setting['format']; ?>" class="layui-input">
	</div>
</div>
<input value="varchar" type="hidden" name="setting[fieldtype]" />
<input value="30" type="hidden" name="setting[maxlength]" />
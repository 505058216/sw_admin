<div class="layui-form-item layui-form-text">
	<label class="layui-form-label">选项列表</label>
	<div class="layui-input-block">
		<textarea name="setting[options]" placeholder="选项名称1|选项值1" class="layui-textarea"><?php echo !isset($setting['options'])?'':$setting['options']; ?></textarea>
	</div>
</div>

<div class="layui-form-item">
	<label class="layui-form-label">选项类型</label>
	<div class="layui-input-block">
		<select name='setting[boxtype]' class='layui-select full-width field-select' style='display:block'>
			<option <?php if( !isset($setting['boxtype'])?'':$setting['boxtype'] == 'checkbox' ){ echo 'selected'; } ?> value="checkbox" onclick="$('#setcols').show();$('#setsize').hide();">复选框</option>
			<option <?php if( !isset($setting['boxtype'])?'':$setting['boxtype'] == 'select' ){ echo 'select'; } ?> value="select" onclick="$('#setcols').hide();$('#setsize').show();">下拉框</option>
		</select>
	</div>
</div>

<div class="layui-form-item">
	<label class="layui-form-label">字段类型</label>
	<div class="layui-input-block">
		<select name='setting[fieldtype]' class='layui-select full-width field-select' style='display:block' onchange="javascript:fieldtype_setting(this.value);">
			<option <?php if( !isset($setting['fieldtype'])?'':$setting['fieldtype'] == 'varchar' ){ echo 'selected'; } ?> value="varchar" >字符 VARCHAR</option>

			<option <?php if( !isset($setting['fieldtype'])?'':$setting['fieldtype'] == 'tinyint' ){ echo 'selected'; } ?> value="tinyint" >整数 TINYINT(3)</option>

			<option <?php if( !isset($setting['fieldtype'])?'':$setting['fieldtype'] == 'smallint' ){ echo 'selected'; } ?> value="smallint" >整数 SMALLINT(5)</option>

			<option <?php if( !isset($setting['fieldtype'])?'':$setting['fieldtype'] == 'mediumint' ){ echo 'selected'; } ?> value="mediumint" >整数 MEDIUMINT(8)</option>

			<option <?php if( !isset($setting['fieldtype'])?'':$setting['fieldtype'] == 'int' ){ echo 'selected'; } ?> value="int" >整数 INT(10)</option>

		</select>
	</div>
</div>

<div class="layui-form-item">
	<label class="layui-form-label">字段类型</label>
	<div class="layui-input-block">
		<select name='setting[minnumber]' class='layui-select full-width field-select' style='display:block'>
			<option <?php if( !isset($setting['minnumber'])?'':$setting['minnumber'] == 1 ){ echo 'selected'; } ?> value="1" >正整数</option>
			<option <?php if( !isset($setting['minnumber'])?'':$setting['minnumber'] == -1 ){ echo 'selected'; } ?> value="-1" >整数</option>
		</select>
	</div>
</div>

<div class="layui-form-item">
	<label class="layui-form-label">样式</label>
	<div class="layui-input-inline">
		<input type="number" name="setting[width]" value="<?php echo !isset($setting['width'])?'':$setting['width']; ?>" placeholder="每列宽度" autocomplete="off" class="layui-input">
	</div>
	<div class="layui-input-inline">
		<input type="number" value="<?php echo !isset($setting['size'])?'':$setting['size']; ?>" name="setting[size]" lay-verify="required" placeholder="高度" autocomplete="off" class="layui-input">
	</div>
</div>

<div class="layui-form-item">
	<label class="layui-form-label">默认值</label>
	<div class="layui-input-block">
		<input type="text" name="setting[defaultvalue]"  lay-verify="required" placeholder="默认值" value="<?php echo !isset($setting['defaultvalue'])?'':$setting['defaultvalue']; ?>" autocomplete="off" class="layui-input">
	</div>
</div>

<div class="layui-form-item">
	<label class="layui-form-label">输出格式</label>
	<div class="layui-input-block">
		<select name='setting[outputtype]' class='layui-select full-width field-select' style='display:block'>
			<option <?php if( !isset($setting['outputtype'])?'':$setting['outputtype'] == 1 ){ echo 'selected'; } ?> value="1" >输出选项值</option>
			<option <?php if( !isset($setting['outputtype'])?'':$setting['outputtype'] == 0 ){ echo 'selected'; } ?> value="-1" >输出选项名称</option>
		</select>
	</div>
</div>

<div class="layui-form-item">
	<label class="layui-form-label">是否作为筛选字段</label>
	<div class="layui-input-block">
		<select name='setting[filtertype]' class='layui-select full-width field-select' style='display:block'>
			<option <?php if( !isset($setting['filtertype'])?'':$setting['filtertype'] == 0 ){ echo 'selected'; } ?> value="0" >否</option>
			<option <?php if( !isset($setting['filtertype'])?'':$setting['filtertype'] == 1 ){ echo 'selected'; } ?> value="1" >是</option>
		</select>
	</div>
</div>

<SCRIPT LANGUAGE="JavaScript">
	function fieldtype_setting(obj) {
		if(obj!='varchar') {
			$('#minnumber').css('display','');
		} else {
			$('#minnumber').css('display','none');
		}
	}
</SCRIPT>
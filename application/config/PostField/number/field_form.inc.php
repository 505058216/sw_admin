
<div class="layui-form-item">
	<label class="layui-form-label">取值范围</label>
	<div class="layui-input-inline">
		<input type="number" name="setting[minnumber]" placeholder="最小值" value="<?php echo !isset($setting['minnumber'])?'':$setting['minnumber']; ?>" class="layui-input">
	</div>
	<div class="layui-input-inline">
		<input type="number" name="setting[maxnumber]" placeholder="最大值" value="<?php echo !isset($setting['maxnumber'])?'':$setting['maxnumber']; ?>" class="layui-input">
	</div>
</div>

<div class="layui-form-item">
	<label class="layui-form-label">小数位数</label>
	<div class="layui-input-block">
		<select name='setting[decimaldigits]' class='layui-select full-width field-select' style='display:block'>
			<option <?php if( !isset($setting['decimaldigits'])?'':$setting['decimaldigits'] == -1 ){ echo 'selected'; } ?> value="-1">自动</option>
			<option <?php if( !isset($setting['decimaldigits'])?'':$setting['decimaldigits'] == 0 ){ echo 'selected'; } ?> value="0">0</option>
			<option <?php if( !isset($setting['decimaldigits'])?'':$setting['decimaldigits'] == 1 ){ echo 'selected'; } ?> value="1">1</option>
			<option <?php if( !isset($setting['decimaldigits'])?'':$setting['decimaldigits'] == 2 ){ echo 'selected'; } ?> value="2">2</option>
			<option <?php if( !isset($setting['decimaldigits'])?'':$setting['decimaldigits'] == 3 ){ echo 'selected'; } ?> value="3">3</option>
			<option <?php if( !isset($setting['decimaldigits'])?'':$setting['decimaldigits'] == 4 ){ echo 'selected'; } ?> value="4">4</option>
			<option <?php if( !isset($setting['decimaldigits'])?'':$setting['decimaldigits'] == 5 ){ echo 'selected'; } ?> value="5">5</option>
		</select>
	</div>
</div>

<div class="layui-form-item">
	<label class="layui-form-label">默认值</label>
	<div class="layui-input-block">
		<input type="text" name="setting[defaultvalue]" placeholder="输入框大小" value="<?php echo !isset($setting['defaultvalue'])?'':$setting['defaultvalue']; ?>" class="layui-input">
	</div>
</div>

<div class="layui-form-item">
	<label class="layui-form-label">作为区间字段</label>
	<div class="layui-input-inline">
		<select name='setting[rangetype]' class='layui-select full-width field-select' style='display:block'>
			<option <?php if( !isset($setting['rangetype'])?'':$setting['rangetype'] == 0 ){ echo 'selected'; } ?> value="0">否</option>
			<option <?php if( !isset($setting['rangetype'])?'':$setting['rangetype'] == 1 ){ echo 'selected'; } ?> value="1">是</option>
		</select>
	</div>
	<div class="layui-form-mid layui-word-aux">注：区间字段可以通过filters('字段名称','模型id','自定义数组')调用</div>
</div>

<input value="number" type="hidden" name="setting[fieldtype]" />
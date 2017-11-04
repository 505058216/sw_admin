<div class="layui-form-item {class}">
	<label class="layui-form-label">{fieldName}</label>
	<div class="layui-input-block">
		<div style="position:relative;">
			<div class="input-group">
				<input {regular} type="text" {isbase} class="form-control" value="{$vo.{field}|default=""}" name="{field}" placeholder="请选择文件...">
				<a class="input-group-addon" data-file="one" data-type="{fileType}" data-uptype="local" data-field="{field}">
					<i class="fa fa-file"></i>
				</a>
			</div>
		</div>
	</div>
</div>

<script>
	require(['jquery'], function () {
		$('[name="{field}"]').on('change', function () {
			layer.msg('文件上传成功');
		});
	});
</script>
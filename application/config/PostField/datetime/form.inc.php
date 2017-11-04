<div class="layui-form-item {class}">
	<label class="layui-form-label">{fieldName}</label>
	<div class="layui-input-block">
		<input type="text" name="{field}" {isbase} value='{$vo.{field}|default=""}' title="请输入{fieldName}" placeholder="请输入{fieldName}" {regular} class="layui-input {field}time">
	</div>
</div>
<script>
	require(['jquery'], function () {
		window.laydate.render({
			elem: '.{field}time'
			,format: '{timeType}'
			,type: 'datetime'
		});
	});
</script>
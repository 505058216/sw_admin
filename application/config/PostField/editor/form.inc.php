<div class="layui-form-item {class}">
	<label class="layui-form-label">{fieldName}</label>
	<div class="layui-input-block">
		<textarea {regular} name="{field}" {isbase}  name="content">{$vo.{field}|default=""}</textarea>
	</div>
</div>
<script>
	require(['ckeditor'], function () {
		var editor = window.createEditor('[name="{field}"]');
	});
</script>
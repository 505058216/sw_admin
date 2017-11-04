<div class="layui-form-item {class}">
	<label class="layui-form-label">{fieldName}</label>
	<div class="layui-input-block">
		<div style="position:relative">
			<div class="uploadimage" {if !empty($vo['{field}'])}data-tips-image="{$vo.{field}|default=""}" style="background-image: url({$vo.{field}|default=""});"{/if}>
				<input type="hidden" {isbase} name="{field}" value="{$vo.{field}|default=""}">
			</div>
			<a data-file="one" data-field="{field}" data-type="{fileType}" data-uptype="local" href="javascript:void(0)" class="uploadbutton">上传图片</a>
		</div>
	</div>
</div>
<script>
	require(['jquery'], function () {
		$('[name="{field}"]').on('change', function () {
			$(this).parent().attr('data-tips-image', this.value).css('backgroundImage', 'url(' + this.value + ')');
		});
	});
</script>
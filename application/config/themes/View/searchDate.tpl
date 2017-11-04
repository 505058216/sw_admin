<div class="layui-form-item layui-inline">
    <label class="layui-form-label">开始{fieldName}</label>
    <div class="layui-input-inline">
        <input name="{field}_start" value="{$Think.get.{field}_start|default=''}"
               placeholder="请选择开始{fieldName}" class="layui-input {field}datetime">
    </div>
</div>
<div class="layui-form-item layui-inline">
    <label class="layui-form-label">结束{fieldName}</label>
    <div class="layui-input-inline">
        <input name="{field}_end" value="{$Think.get.{field}_end|default=''}"
               placeholder="请选择结束{fieldName}" class="layui-input {field}datetime">
    </div>
</div>
<script>
    window.laydate.render({range: true, elem: '.{field}datetime', format: 'yyyy/MM/dd'});
    window.laydate.render({range: true, elem: '.{field}datetime', format: 'yyyy/MM/dd'});
</script>
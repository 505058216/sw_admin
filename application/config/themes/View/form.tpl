{top}
<form class="layui-form layui-box" style='padding:25px 30px 20px 0' action="__SELF__" data-auto="true" method="post">

    {content}

    <div class="hr-line-dashed"></div>

    <div class="layui-form-item text-center">
        {if isset($vo['id'])}<input type='hidden' value='{$vo.id}' name='id'/>{/if}
        <button class="layui-btn" type='submit'>保存数据</button>
        <button {topUrl} class="layui-btn layui-btn-danger" type='button' data-confirm="确定要取消编辑吗？" data-close>取消编辑</button>
    </div>
</form>

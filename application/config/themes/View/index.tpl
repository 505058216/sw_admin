{extend name='common/content'}
{block name="button"}
<div class="nowrap pull-right" style="margin-top:10px">
    <button data-{modal}='{:url("$classuri/add")}' data-title="添加{ModelName}" class='layui-btn layui-btn-small'>
        <i class='fa fa-plus'></i> 添加{ModelName}
    </button>
    <button data-update data-field='delete' data-action='{:url("$classuri/del")}' class='layui-btn layui-btn-small layui-btn-danger'>
        <i class='fa fa-remove'></i> 删除{ModelName}
    </button>
</div>
{/block}

{block name="content"}

<!-- 表单搜索 开始 -->
<form class="layui-form layui-form-pane form-search" action="__SELF__" onsubmit="return false" method="get">
    {search}
    <div class="layui-form-item layui-inline">
        <button class="layui-btn layui-btn-primary"><i class="layui-icon">&#xe615;</i> 搜 索</button>
    </div>
</form>
<!-- 表单搜索 结束 -->

<form onsubmit="return false;" data-auto="true" method="post">
    {if empty($list)}
    <p class="help-block text-center well">没 有 记 录 哦！</p>
    {else}
    <input type="hidden" value="resort" name="action"/>
    <table class="layui-table" lay-skin="line" lay-size="sm">
        <thead>
        <tr>
            <th class='list-table-check-td'>
                <input data-none-auto="" data-check-target='.list-check-box' type='checkbox'/>
            </th>
            <th class='list-table-sort-td'>
                <button type="submit" class="layui-btn layui-btn-normal layui-btn-mini">排 序</button>
            </th>
            {listItemTop}
            <th class='list-table-sort-td'>创建时间</th>
            <th class='list-table-sort-td'>状态</th>
            <th class='list-table-sort-td'>操作</th>
        </tr>
        </thead>
        <tbody>
        {foreach $list as $key=>$vo}
        <tr>
            <td class='list-table-check-td'>
                <input class="list-check-box" value='{$vo.id}' type='checkbox'/>
            </td>
            <td class='list-table-sort-td'>
                <input name="_{$vo.id}" value="{$vo.sort}" class="list-sort-input"/>
            </td>
            {listItem}
            <td class='text-left nowrap'>{$vo.inputtime}</td>
            <td class='text-left nowrap'>
                {if $vo.status eq 1}
                    <span class="label label-success radius">已禁用</span>
                {elseif $vo.status eq 0}
                    <span class="label label-danger radius">使用中</span>
                {/if}
            </td>
            <td class='text-left nowrap'>
                {if auth("$classuri/edit")}
                <span class="text-explode">|</span>
                <a data-{modal}='{:url("$classuri/edit")}?id={$vo.id}' href="javascript:void(0)">编辑</a>
                {/if}
                {if $vo.status eq 0 and auth("$classuri/status")}
                    <span class="text-explode">|</span>
                    <a data-update="{$vo.id}" data-field='status' data-value='1' data-action='{:url("$classuri/status")}'
                       href="javascript:void(0)">禁用</a>
                {elseif auth("$classuri/status")}
                    <span class="text-explode">|</span>
                    <a data-update="{$vo.id}" data-field='status' data-value='0' data-action='{:url("$classuri/status")}'
                       href="javascript:void(0)">启用</a>
                {/if}
                {if auth("$classuri/del")}
                    <span class="text-explode">|</span>
                    <a data-update="{$vo.id}" data-field='delete' data-action='{:url("$classuri/del")}'
                       href="javascript:void(0)">删除</a>
                {/if}
            </td>
        </tr>
        {/foreach}
        </tbody>
    </table>
    {if isset($page)}<p>{$page}</p>{/if}
    {/if}
</form>
{/block}
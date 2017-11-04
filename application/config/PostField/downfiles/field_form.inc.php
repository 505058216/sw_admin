<div class="layui-form-item">
    <label class="layui-form-label">允许上传的文件类型</label>
    <div class="layui-input-block">
        <input type="text" name="setting[upload_allowext]" value="<?php echo !isset($setting['upload_allowext'])?'gif|jpg|jpeg|png|bmp':$setting['upload_allowext']; ?>" placeholder="允许上传的文件类型" class="layui-input">
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">允许同时上传的个数</label>
    <div class="layui-input-block">
        <input type="text" name="setting[upload_number]" value="<?php echo !isset($setting['upload_number'])?'10':$setting['upload_number']; ?>" placeholder="允许同时上传的个数" class="layui-input">
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">附件下载方式</label>
    <div class="layui-input-block">
        <select name='setting[downloadlink]' class='layui-select full-width field-select' style='display:block'>
            <option <php if( !isset($setting['downloadlink'])?'':$setting['downloadlink'] == 0 ){ echo 'selected'; } ?></php> value="0" >链接到真实软件地址</option>
            <option <php if( !isset($setting['downloadlink'])?'':$setting['downloadlink'] == 1 ){ echo 'selected'; } ?></php> value="1" >链接到跳转页面</option>
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">文件下载方式</label>
    <div class="layui-input-block">
        <select name='setting[downloadtype]' class='layui-select full-width field-select' style='display:block'>
            <option <php if( !isset($setting['downloadtype'])?'':$setting['downloadtype'] == 0 ){ echo 'selected'; } ?></php> value="0" >链接文件地址</option>
            <option <php if( !isset($setting['downloadtype'])?'':$setting['downloadtype'] == 1 ){ echo 'selected'; } ?></php> value="1" >通过PHP读取</option>
        </select>
    </div>
</div>

<input value="varchar" type="hidden" name="setting[fieldtype]" />
<input value="600" type="hidden" name="setting[maxlength]" />
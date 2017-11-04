<div class="layui-form-item">
    <label class="layui-form-label">地图接口选择</label>
    <div class="layui-input-block">
        <input type="number" name="setting[maptype]" placeholder="百度地图" value="<?php echo !isset($setting['maptype'])?'百度地图':$setting['maptype']; ?>" class="layui-input">
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">地图API Key</label>
    <div class="layui-input-block">
        <input type="text" name="setting[api_key]" placeholder="地图API Key" value="<?php echo !isset($setting['api_key'])?'':$setting['api_key']; ?>" class="layui-input">
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">默认城市</label>
    <div class="layui-input-block">
        <input type="text" name="setting[defaultcity]" placeholder="直接填写中文城市名称" value="<?php echo !isset($setting['defaultcity'])?'':$setting['defaultcity']; ?>" class="layui-input">
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">热门城市</label>
    <div class="layui-input-block">
        <input type="text" name="setting[hotcitys]" placeholder="多个城市请使用半角逗号分隔" value="<?php echo !isset($setting['hotcitys'])?'':$setting['hotcitys']; ?>" class="layui-input">
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">地图尺寸</label>
    <div class="layui-input-inline">
        <input type="text" name="setting[width]" placeholder="宽度" value="<?php echo !isset($setting['width'])?'':$setting['width']; ?>" class="layui-input">
    </div>
    <div class="layui-input-inline">
        <input type="text" name="setting[height]" placeholder="高度" value="<?php echo !isset($setting['height'])?'':$setting['height']; ?>" class="layui-input">
    </div>
</div>
<input value="varchar" type="hidden" name="setting[fieldtype]" />
<input value="30" type="hidden" name="setting[maxlength]" />
<div class="layui-form-item {class}">
    <label class="layui-form-label">{fieldName}</label>
    <div class="layui-input-block">
        <div style="position:relative">
            <style>
                .upload-option-button {
                    float: right;
                    background: rgba(0, 0, 0, 0.5);
                    color: #fff;
                    width: 20px;
                    height: 20px;
                    line-height: 20px;
                    text-align: center;
                    display: none
                }
                .upload-option-button:hover {
                    text-decoration: none;
                    color: #fff
                }
                .uploadimagemtl:hover a {
                    display: inline-block
                }
            </style>
            <input type="hidden" name="{field}" value="{$vo.{field}|default=""}">
            <a data-file="mut" data-field="{field}" data-type="{fileType}" data-uptype="local" href="javascript:void(0)">上传图片</a>
        </div>
    </div>
</div>
<script type="text/javascript">
    require(['jquery'], function () {
        var tpl = '<div class="uploadimage transition uploadimagemtl"><a href="javascript:void(0)" class="layui-icon upload-option-button">ဆ</a></div>';
        $('[name="{field}"]').on('change', function () {
            var input = this, values = [], srcs = this.value.split('|');
            $(this).prevAll('.uploadimage').map(function () {
                values.push($(this).attr('data-tips-image'));
            }), $(this).prevAll('.uploadimage').remove();
            values.reverse();
            for (var i in srcs) {
                values.push(srcs[i]);
            }
            this.value = values.join('|');
            for (var i in values) {
                var $tpl = $(tpl).attr('data-tips-image', values[i]).css('backgroundImage', 'url(' + values[i] + ')');
                $tpl.data('input', input).data('srcs', values).data('index', i);
                $tpl.on('click', 'a', function (e) {
                    e.stopPropagation();
                    var $cur = $(this).parent();
                    $.msg.confirm('确定要移除这张图片吗？', function () {
                        var data = $cur.data('srcs');
                        delete data[$cur.data('index')];
                        $cur.data('input').value = data.join('|');
                        $cur.remove();
                    });
                });
                $(this).before($tpl);
            }
        });
        {if !empty($vo['{field}'])}
        $('[name="{field}"]').on('click', function () {
            var input = this, values = [], srcs = this.value.split('|');
            $(this).prevAll('.uploadimage').map(function () {
                values.push($(this).attr('data-tips-image'));
            }), $(this).prevAll('.uploadimage').remove();
            values.reverse();
            for (var i in srcs) {
                values.push(srcs[i]);
            }
            this.value = values.join('|');
            for (var i in values) {
                var $tpl = $(tpl).attr('data-tips-image', values[i]).css('backgroundImage', 'url(' + values[i] + ')');
                $tpl.data('input', input).data('srcs', values).data('index', i);
                $tpl.on('click', 'a', function (e) {
                    e.stopPropagation();
                    var $cur = $(this).parent();
                    $.msg.confirm('确定要移除这张图片吗？', function () {
                        var data = $cur.data('srcs');
                        delete data[$cur.data('index')];
                        $cur.data('input').value = data.join('|');
                        $cur.remove();
                    });
                });
                $(this).before($tpl);
            }
        }).click();
        {/if}
    });
</script>
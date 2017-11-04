<?php
/**
 * Created by 顺为科技.
 * File: ModelService.php
 * User: 隔壁老吴
 * Author: 505058216@qq.com
 * Date: 2017/10/21
 * Time: 15:58
 */

namespace service;

use think\Db;
use think\Request;
use \think\Exception;

/**
 *
 * Class 模型服务类
 * @package ModelService
 * @author 隔壁老吴 <505058216@qq.com>
 * @date 2017/10/21 15:59
 */
class ModelService{

    /**
     * 模型ID
     * @var string
     */
    private $id;

    /**
     * 模型数据
     * @var string
     */
    private $model;

    /**
     * 字段数据
     * @var string
     */
    private $field;

    /**
     * 初始化
     * @var string
     */
    public function start($id){
        $this->id = $id;
        //查询模型数据
        $this->model = db('SystemModel')->where(array('id'=>$id,'status' => 0))->find();
    }

    /**
     * 模型方法set方法，用于创建模型
     * @var string
     */
    public function setField( $field ){
        $this->field = $field;
    }

    /**
     * 模型方法set方法，用于创建模型
     * @var string
     */
    public function setModel( $model ){
        $this->model = $model;
    }

    /**
     * 生成sql语句
     * @var string
     */
    public function insertModelSql(){
        $table = config('database.prefix').$this->model['tablename'];
        //判断表是否存在
        if( in_array($table,Db::query('SHOW TABLES')) ){
            throw new \think\Exception('数据表已存在', 100006);
            return false;
        }
        if( config('create_table') ){
            $sql = 'DROP TABLE IF EXISTS `'.$this->model['tablename'].'`';
            Db::execute($sql);
        }
        $sql = 'CREATE TABLE `'.$table.'` (`id` mediumint(8) NOT NULL AUTO_INCREMENT,`sort` smallint(5) unsigned NOT NULL DEFAULT 0,`status` tinyint(1) unsigned NOT NULL DEFAULT 0,`inputtime` timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\',`updatetime` timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\',PRIMARY KEY (`id`),KEY `sort` (`sort`))comment=\''.$this->model['name'].'\' ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;';
        //创建表
        Db::execute($sql);
        //新增数据
        db('system_modelfield')
            ->insert(array(
                'modelid' => $this->model['id'],
                'field' => 'updatetime',
                'name' => '更新时间',
                'formtype' => 'datetime',
                'setting' => serialize(array(
                    'dateformat' => 'datetime',
                    'format' => 'yyyy-MM-dd',
                    'defaulttype' => 0,
                    'defaultvalue' => '',
                )),
                'iscore' => 1,
                'issystem' => 1,
                'isunique' => 0,
                'isbase' => 1,
                'sort' => 99,
                'status' => 0
            ));
        db('system_modelfield')
            ->insert(array(
                'modelid' => $this->model['id'],
                'field' => 'inputtime',
                'name' => '发布时间',
                'formtype' => 'datetime',
                'setting' => serialize(array(
                    'fieldtype' => 'datetime',
                    'format' => 'yyyy-MM-dd',
                    'defaulttype' => 0,
                )),
                'issystem' => 1,
                'sort' => 99,
                'status' => 0
            ));
        db('system_modelfield')
            ->insert(array(
                'modelid' => $this->model['id'],
                'field' => 'sort',
                'name' => '排序',
                'maxlength' => 6,
                'formtype' => 'number',
                'iscore' => 1,
                'issystem' => 1,
                'isbase' => 1,
                'sort' => 99,
                'status' => 0
            ));
        return true;
    }

    /**
     * 修改模型
     * @var string
     */
    public function updateModelSql($tableName){
        //判断表名是否存在
        $sql = 'ALTER  TABLE `'.$tableName.'` RENAME TO `'.$this->model['tablename'].'`';
        $update = Db::execute($sql);
        Db::execute('alter table '.$this->model['tablename'].' comment \''.$this->model['name'].'\'');
        return true;
    }

    /**
     * 删除数据表
     * @var string
     */
    public function delModelSql(){
        $sql = 'DROP TABLE IF EXISTS `'.$this->model['tablename'].'`';
        Db::execute($sql);
        return true;
    }

    /**
     * 添加字段
     * @var string
     */
    public function addFieldSql( $fieldId ){
        $sql = $this->getAddFieldSql($fieldId);
        Db::execute($sql);
        return true;
    }

    /**
     * 修改字段
     * @var string
     */
    public function UpdateFieldSql( $oldField ){
        $sql = $this->getUpdateFieldSql($oldField);
        Db::execute($sql);
        return true;
    }

    /**
     * 删除控制器以及视图
     * @var string
     */
    public function delThemes(){
        //删除视图
        $viewDir = config('viewPath').strtolower($this->model['tablename']).DS;
        if( is_file($viewDir.'form.html') ){
            @unlink($viewDir.'form.html');
        }
        if( is_file($viewDir.'index.html') ){
            @unlink($viewDir.'index.html');
        }
        //删除控制器
        $controllerDir = config('controllerPath');
        if( is_file($controllerDir.ucwords($this->model['tablename']).'.php') ){
            @unlink($controllerDir.ucwords($this->model['tablename']).'.php');
        }
        if( is_dir($viewDir) ){
            $this->deldir($viewDir);
        }
    }

    /**
     * 删除字段
     * @var string
     */
    public function delFieldSql( $field ){
        //查询模型名
        $modal = db('system_model')->where(array('id'=>$field['modelid']))->find();
        $sql = 'ALTER TABLE `'.$modal['tablename'].'` DROP `'.$field['field'].'`';
        Db::execute($sql);
        return true;
    }

    /**
     * 获取相应类型修改字段sql语句
     * @var string
     */
    private function getUpdateFieldSql( $oldField ){
        //查询字段
        $model = db('system_model')->where(array('id'=>$oldField['modelid']))->find();
        //附加设置
        $setting = $this->field['setting'];
        //表名
        $tablename = $model['tablename'];
        //旧字段
        $oldfield = $oldField['field'];
        //字段名
        if( isset($this->field['field']) ){
            $fieldName = $this->field['field'];
        }else{
            $fieldName = $oldField['field'];
        }
        //默认值
        @$defaultvalue = $setting['defaultvalue'];
        //最小数值
        @$minnumber = $setting['minnumber'];
        //最大长度
        @$maxlength = intval($setting['maxlength']);
        if( intval($this->field['maxlength']) != 0 ){
            @$maxlength = min(intval($this->field['maxlength']),$maxlength);
        }
        if( empty($this->field) ){
            throw new \think\Exception('字段不存在', 100006);
            return false;
        }
        //字段类型sql对应
        switch ( $setting['fieldtype'] ){
            case 'varchar':
                if($this->field['maxlength'] <= 0) $maxlength = 255;
                $maxlength = min($maxlength, 255);
                $fieldtype = 'VARCHAR';
                $sql = "ALTER TABLE `$tablename` CHANGE `$oldfield` `$fieldName` $fieldtype( $maxlength ) NOT NULL DEFAULT '$defaultvalue'";
                break;
            case 'tinyint':
                $minnumber = intval($minnumber);
                $defaultvalue = intval($defaultvalue);
                $sql = "ALTER TABLE `$tablename` CHANGE `$oldfield` `$fieldName` TINYINT ".($minnumber >= 0 ? 'UNSIGNED' : '')." NOT NULL DEFAULT '$defaultvalue'";
                break;
            case 'number':
                $minnumber = intval($minnumber);
                $decimaldigits = $setting['decimaldigits'];
                $defaultvalue = $decimaldigits == 0 ? intval($defaultvalue) : floatval($defaultvalue);
                $sql = "ALTER TABLE `$tablename` CHANGE `$oldfield` `$fieldName` ".($decimaldigits == 0 ? 'INT' : 'FLOAT')." ".($minnumber >= 0 ? 'UNSIGNED' : '')." NOT NULL DEFAULT '$defaultvalue'";
                break;
            case 'smallint':
                $minnumber = intval($minnumber);
                $defaultvalue = intval($defaultvalue);
                $sql = "ALTER TABLE `$tablename` CHANGE `$oldfield` `$fieldName` SMALLINT ".($minnumber >= 0 ? 'UNSIGNED' : '')." NOT NULL DEFAULT '$defaultvalue'";
                break;
            case 'int':
                $minnumber = intval($minnumber);
                $defaultvalue = intval($defaultvalue);
                $sql = "ALTER TABLE `$tablename` CHANGE `$oldfield` `$fieldName` INT ".($minnumber >= 0 ? 'UNSIGNED' : '')." NOT NULL DEFAULT '$defaultvalue'";
                break;
            case 'mediumint':
                $minnumber = intval($minnumber);
                $defaultvalue = intval($defaultvalue);
                $sql = "ALTER TABLE `$tablename` CHANGE `$oldfield` `$fieldName` MEDIUMINT ".($minnumber >= 0 ? 'UNSIGNED' : '')." NOT NULL DEFAULT '$defaultvalue'";
                break;
            case 'mediumtext':
                $sql = "ALTER TABLE `$tablename` CHANGE `$oldfield` `$fieldName` MEDIUMTEXT NOT NULL";
                break;
            case 'text':
                $sql = "ALTER TABLE `$tablename` CHANGE `$oldfield` `$fieldName` TEXT NOT NULL";
                break;
            case 'date':
                $sql = "ALTER TABLE `$tablename` CHANGE `$oldfield` `$fieldName` DATE NULL";
                break;
            case 'datetime':
                $sql = "ALTER TABLE `$tablename` CHANGE `$oldfield` `$fieldName` DATETIME NULL";
                break;
            case 'timestamp':
                $sql = "ALTER TABLE `$tablename` CHANGE `$oldfield` `$fieldName` TIMESTAMP NOT NULL";
                break;
            case 'decimal':
                $sql = "ALTER TABLE `$tablename` CHANGE `$oldfield` `$fieldName` decimal(10,2) NOT NULL";
                break;
        }
        $sql .= ' COMMENT \''.$this->field['name'].'\'';
        return $sql;
    }

    /**
     * 获取新增字段sql语句
     * @var string
     */
    private function getAddFieldSql( $fieldId ){
        //查询字段
        $field = db('SystemModelfield')
            ->alias('mf')
            ->field('mf.*,m.tablename')
            ->join('system_model m','mf.modelid = m.id')
            ->where(array('mf.id'=>$fieldId))
            ->find();
        //附加设置
        $setting = unserialize($field['setting']);
        //默认值
        @$defaultvalue = $setting['defaultvalue'];
        //最大长度
        @$maxlength = intval($setting['maxlength']);
        if( intval($field['maxlength']) != 0 ){
            @$maxlength = min(intval($field['maxlength']),$maxlength);
        }
        //表名
        $tablename = $field['tablename'];
        //字段名
        $fieldName = $field['field'];
        if( empty($field) ){
            throw new \think\Exception('字段不存在', 100006);
            return false;
        }
        //字段类型sql对应
        switch ( $setting['fieldtype'] ){
            case 'varchar':
                if($maxlength <= 0) $maxlength = 255;
                $maxlength = min($maxlength, 255);
                $sql = 'ALTER TABLE `'.$tablename.'` ADD `'.$fieldName.'` VARCHAR( '.$maxlength.' ) NOT NULL DEFAULT \''.$defaultvalue.'\'';
                break;
            case 'tinyint':
                if(!$setting['maxlength'] <= 0) $maxlength = 3;
                $minnumber = intval($setting['minnumber']);
                $defaultvalue = intval($setting['defaultvalue']);
                $sql = 'ALTER TABLE `'.$tablename.'` ADD `'.$fieldName.'` TINYINT( '.$maxlength.' ) '.($minnumber >= 0 ? 'UNSIGNED' : '').' NOT NULL DEFAULT '.$defaultvalue;
                break;
            case 'number':
                $minnumber = intval($setting['minnumber']);
                $defaultvalue = $setting['decimaldigits'] == 0 ? intval($setting['defaultvalue']) : floatval($setting['defaultvalue']);
                $sql = "ALTER TABLE `".$tablename."` ADD `".$fieldName."` ".($setting['decimaldigits'] == 0 ? 'INT' : 'FLOAT')." ".($minnumber >= 0 ? 'UNSIGNED' : '')." NOT NULL DEFAULT '$defaultvalue'";
                break;
            case 'smallint':
                $minnumber = intval($setting['minnumber']);
                $sql = "ALTER TABLE `".$tablename."` ADD `".$fieldName."` SMALLINT ".($minnumber >= 0 ? 'UNSIGNED' : '')." NOT NULL";
                break;
            case 'int':
                $minnumber = intval($setting['minnumber']);
                $defaultvalue = intval($setting['defaultvalue']);
                $sql = "ALTER TABLE `".$tablename."` ADD `".$fieldName."` INT ".($minnumber >= 0 ? 'UNSIGNED' : '')." NOT NULL DEFAULT '$defaultvalue'";
                break;
            case 'mediumint':
                $minnumber = intval($setting['minnumber']);
                $defaultvalue = intval($setting['defaultvalue']);
                $sql = "ALTER TABLE `".$tablename."` ADD `".$fieldName."` INT ".($minnumber >= 0 ? 'UNSIGNED' : '')." NOT NULL DEFAULT '$defaultvalue'";
                break;
            case 'mediumtext':
                $sql = "ALTER TABLE `".$tablename."` ADD `".$fieldName."` MEDIUMTEXT NOT NULL";
                break;
            case 'text':
                $sql = "ALTER TABLE `$tablename` ADD `".$fieldName."` TEXT NOT NULL";
                break;
            case 'date':
                $sql = "ALTER TABLE `$tablename` ADD `".$fieldName."` DATE NULL";
                break;
            case 'datetime':
                $sql = "ALTER TABLE `$tablename` ADD `".$fieldName."` DATETIME NULL";
                break;
            case 'timestamp':
                $sql = "ALTER TABLE `$tablename` ADD `".$fieldName."` TIMESTAMP NOT NULL";
                break;
            case 'decimal':
                $sql = "ALTER TABLE `$tablename` ADD `".$fieldName."` decimal(10,2) NOT NULL";
                break;
        }
        $sql .= ' COMMENT \''.$field['name'].'\'';
        return $sql;
    }

    /**
     * 删除文件夹及文件
     * @var string
     */
    private function deldir($dir)
    {
        $dh = opendir($dir);
        while ($file = readdir($dh))
        {
            if ($file != "." && $file != "..")
            {
                $fullpath = $dir . "/" . $file;
                if (!is_dir($fullpath))
                {
                    @unlink($fullpath);
                }else{
                    @deldir($fullpath);
                }
            }
        }
        @closedir($dh);
        if (rmdir($dir))
        {
            return true;
        } else
        {
            return false;
        }
    }

    /*控制器生成操作*/


    /**
     * 生成控制器
     * @var string
     */
    public function generateControllrt(){
        //获取模板内容
        $controllrt = getConfig('Controller'.DIRECTORY_SEPARATOR.'Controller.tpl',true,'themes');
        $controllrt = getConfig('Controller'.DIRECTORY_SEPARATOR.'Controller.tpl',true,'themes');
        $tablename = convertUnderline(ucwords($this->model['tablename']));
        //替换预设关键字
        $controllrt = str_replace('{Controller}', $tablename, $controllrt);
        $controllrt = str_replace('{table}', $this->model['tablename'], $controllrt);
        $controllrt = str_replace('{ModelName}', $this->model['name'], $controllrt);
        //查询参与搜索的字段
        $isSearchField = db('SystemModelfield')->where(array('iscore' => 0,'issearch'=>1,'status'=>0))->select();
        //组装搜索条件
        $where = '';
        if ( !empty($isSearchField) ){
            foreach ( $isSearchField as $vo ){
                $field = $vo['field'];
                //判断类型实现不同的搜索方式
                if( $vo['formtype'] == 'datetime' ){
                    $search = getConfig('Controller'.DIRECTORY_SEPARATOR.'SearchDate.tpl',true,'themes');
                    $where .= str_replace('{fieldName}', $field, $search);
                }else{
                    $search = getConfig('Controller'.DIRECTORY_SEPARATOR.'Search.tpl',true,'themes');
                    $where .= str_replace('{fieldName}', $field, $search);
                }
            }
        }
        $controllrt = str_replace('{where}', $where, $controllrt);

        //文件夹不存在则创建
        $dir = config('controllerPath');
        //文件夹不存在则创建
        if (!file_exists($dir)){
            mkdir ($dir,0777,true);
        }
        //写入文件夹地址
        $file = file_put_contents($dir.convertUnderline(ucwords($this->model['tablename'])).'.php', $controllrt);
        unset($where);
        unset($controllrt);
        if( $file ){
            return true;
        }else{
            throw new \think\Exception('控制器创建失败', 100006);
            return false;
        }
    }

    /**
     * 生成视图
     * @var string
     */
    public function generateViewList(){
        //获取视图内容
        $view = getConfig('View'.DIRECTORY_SEPARATOR.'index.tpl',true,'themes');
        //替换预设关键字
        $view = str_replace('{ModelName}', $this->model['name'], $view);
        //查询参与搜索的字段
        $isSearchField = db('SystemModelfield')->order('sort desc')->where(array('iscore' => 0,'modelid'=>$this->model['id'],'issystem'=>0,'status'=>0))->select();
        //搜索
        $search = '';
        //列表页
        $listTop = '';
        $listItem = '';
        $open = false;
        if( !empty($isSearchField) ){
            foreach ( $isSearchField as $field ){
                //过滤系统字段
                if( $field['issystem'] == 1 ){
                    continue;
                }
                if( $field['formtype'] == 'editor' ){
                    $open = true;
                }
                //搜索字段
                if( $field['issearch'] == 1 ){
                    if( $field['formtype'] == 'datetime' ){
                        $formView = getConfig('View'.DIRECTORY_SEPARATOR.'searchDate.tpl',true,'themes');
                        $formView = str_replace('{fieldName}', $field['name'], $formView);
                        $search .= str_replace('{field}', $field['field'], $formView);
                    }else{
                        $formView = getConfig('View'.DIRECTORY_SEPARATOR.'search.tpl',true,'themes');
                        $formView = str_replace('{fieldName}', $field['name'], $formView);
                        $search .= str_replace('{field}', $field['field'], $formView);
                    }
                }
                //显示在列表页
                if( $field['islist'] == 1 ){
                    $listTop .= '<th class=\'text-left nowrap\'>'.$field['name'].'</th>'."\r\n";
                    if( $field['formtype'] == 'image' ){
                        $listItem .= '<td class=\'text-left nowrap\'><img src="{$vo.'.$field['field'].'}" style="width:50px;height:50px;"/></td>'."\r\n";
                    }else if( $field['formtype'] == 'images' ){
                        $listItem .= '{php}if( !empty($field[\'field\']) ){$images = explode(\'|\',$field[\'field\']);}{/php}<td class=\'text-left nowrap\'><img scr="{$images[0]}" style="width:50px;height:50px;"/></td>'."\r\n";
                    }else{
                        $listItem .= '<td class=\'text-left nowrap\'>{:mb_substr($vo.'.$field['field'].',0,10,\'utf-8\')}</td>'."\r\n";
                    }
                    //explode

                }
            }
        }
        $view = str_replace('{search}', $search, $view);
        $view = str_replace('{listItemTop}', $listTop, $view);
        $view = str_replace('{listItem}', $listItem, $view);
        //判断是否为存在富文本编辑器
        if( $open ){
            $view = str_replace('{modal}', 'open', $view);
        }else{
            $view = str_replace('{modal}', 'modal', $view);
        }
        $dir = config('viewPath').strtolower($this->model['tablename']).DS;
        //文件夹不存在则创建
        if (!file_exists($dir)){
            mkdir ($dir,0777,true);
        }
        //写入文件夹地址
        $file = file_put_contents($dir.'index.html', $view);
        unset($view);
        unset($listTop);
        unset($listItem);
        if( $file ){
            return true;
        }else{
            throw new \think\Exception('列表视图创建失败', 100006);
            return false;
        }
    }

    /**
     * 生成表单视图
     * @var string
     */
    public function generateViewForm(){
        //查询所有非系统字段显示字段
        $where = array(
            'iscore' => 0,
            'issystem' => 0,
            'status' => 0,
        );
        $field = db('SystemModelfield')->order('sort desc')->where($where)->select();
        $form = getConfig('View'.DS.'form.tpl',true,'themes');
        $html = '';
        $open = false;
        foreach ( $field as $vo ){
            if( $vo['formtype'] == 'editor' ){
                $open = true;
            }
            if( $vo['isdisabled'] == 1 ){
                $html .= '<input name="'.$vo['field'].'" value="{$vo.'.$vo['field'].'|default=""}" type="hidden" />'."\r\n";
            }else{
                switch ( $vo['formtype'] ){
                    case 'box':
                        $setting = unserialize($vo['setting']);
                        //复选框外层DIV
                        $text = getConfig('View'.DS.'layui_form_block.tpl',true,'themes');
                        $text = str_replace('{fieldName}', $vo['name'], $text);
                        //下拉框外层
                        $select = getConfig('View'.DS.'select.tpl',true,'themes');
                        //内容模板
                        $optionThemes = getConfig('View'.DS.'option.tpl',true,'themes');
                        //选项内容
                        $optionHtmls = '';
                        //获取选项列表
                        $options = $setting['options'];
                        $options = nl2br($options);//将分行符"\r\n"转义成HTML的换行符"<br />"
                        $options = explode("<br />",$options);//"<br />"作为分隔切成数组
                        if( !empty($options) ){
                            foreach ( $options as $option ){
                                $option = trim($option);
                                $option = explode('|',$option);
                                if( count($option) == 2 ){
                                    $optionHtml = str_replace('{field}', $vo['field'], $optionThemes);
                                    $optionHtml = str_replace('{fieldName}', $vo['name'], $optionHtml);
                                    $optionHtml = str_replace('{fieldItemVal}', $option[1], $optionHtml);
                                    $optionHtml = str_replace('{fieldName}', $option[0], $optionHtml);
                                    $optionHtmls .= $optionHtml;
                                }
                            }
                            //组装选项卡
                            $select = str_replace('{field}', $vo['field'], $select);
                            $select = str_replace('{item}', $optionHtmls, $select);
                        }
                        $text = str_replace('{item}', $select, $text);
                        break;
                    case 'image':
                        $setting = unserialize($vo['setting']);
                        $text = $this->public_replace($vo);
                        $text = str_replace('{fileType}', $setting['upload_allowext'], $text);
                        break;
                    case 'images':
                        $setting = unserialize($vo['setting']);
                        $text = $this->public_replace($vo);
                        $text = str_replace('{fileType}', $setting['upload_allowext'], $text);
                        break;
                    case 'text':
                        $setting = unserialize($vo['setting']);
                        $text = $this->public_replace($vo);
                        $setting['ispassword'] = empty($setting['ispassword'])?'0':$setting['ispassword'];
                        if( $setting['ispassword'] == 1 ){
                            $text = str_replace('{ispassword}', 'password', $text);
                        }else{
                            $text = str_replace('{ispassword}', 'text', $text);
                        }
                        break;
                    case 'datetime':
                        $setting = unserialize($vo['setting']);
                        $text = $this->public_replace($vo);
                        //时间格式判断
                        $format = 'yyyy-MM-dd HH:mm:ss';
                        if( !empty($setting['format']) ){
                            $format = $setting['format'];
                        }else{
                            if( $setting['outputtype'] == 'date' ){
                                $format = 'yyyy-MM-dd';
                            }
                        }
                        $text = str_replace('{timeType}', $format, $text);
                        break;
                    default :
                        $text = $this->public_replace($vo);
                        break;
                }
                //判断是否为基本字段
                if( $vo['isbase'] == 1 ){
                    $text = str_replace('{isbase}', 'required  lay-verify="required"', $text);
                }else{
                    $text = str_replace('{isbase}', '', $text);
                }
                //判断是否存在正则验证
                if( !empty($vo['pattern']) ){
                    $text = str_replace('{regular}', 'onkeyup="this.value=this.value.replace('.$vo['pattern'].',\'\');"', $text);
                }else{
                    $text = str_replace('{regular}', '', $text);
                }
                //判断是否存在class
                if( !empty($vo['css']) ){
                    $text = str_replace('{regular}', $vo['css'], $text);
                }else{
                    $text = str_replace('{class}', '', $text);
                }
                $html .= $text."\r\n";
                unset($optionHtmls);
                unset($optionHtml);
                unset($text);
            }
        }
        //判断是否存在富文本编辑器
        if( $open ){
            $form = str_replace('{top}', '<div class="ibox-title notselect"><h5 data-open="{:url(\'index\')}">'.$this->model['name'].'</h5></div>', $form);
            $form = str_replace('{topUrl}', 'data-open="{:url(\'index\')}"', $form);
        }else{
            $form = str_replace('{top}', '', $form);
            $form = str_replace('{topUrl}', '', $form);
        }
        $form = str_replace('{content}', $html, $form);
        $dir = config('viewPath').strtolower($this->model['tablename']).DS;
        //文件夹不存在则创建
        if (!file_exists($dir)){
            mkdir ($dir,0777,true);
        }
        //写入文件夹地址
        $file = file_put_contents($dir.'form.html', $form);
        unset($text);
        unset($form);
        if( $file ){
            return true;
        }else{
            throw new \think\Exception('表单视图创建失败', 100006);
            return false;
        }
    }

    /**
     * 通用表单替换
     * @var string
     */
    private function public_replace($vo){
        $text = getConfig($vo['formtype'].DS.'form.inc.php',true,'PostField');
        $text = str_replace('{fieldName}', $vo['name'], $text);
        $text = str_replace('{field}', $vo['field'], $text);
        return $text;
    }
}
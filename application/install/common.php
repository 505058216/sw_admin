<?php
use think\Db;
// 检测环境是否支持可写
define('IS_WRITE',true);

/**
 * 系统环境检测
 * @return array 系统环境数据
 */
function check_env(){
    $items = array(
        'os'      => array('操作系统', '不限制', '类Unix', PHP_OS, 'yes'),
        'php'     => array('PHP版本', '5.3', '5.3+', PHP_VERSION, 'yes'),
        //'mysql'   => array('MYSQL版本', '5.0', '5.0+', '未知', 'success'), //PHP5.5不支持mysql版本检测
        'upload'  => array('附件上传', '不限制', '2M+', '未知', 'yes'),
        'gd'      => array('GD库', '2.0', '2.0+', '未知', 'yes'),
        'disk'    => array('磁盘空间', '5M', '不限制', '未知', 'yes'),
    );

    //PHP环境检测
    if($items['php'][3] < $items['php'][1]){
        $items['php'][4] = 'no';
    }

    //附件上传检测
    if(@ini_get('file_uploads'))
        $items['upload'][3] = ini_get('upload_max_filesize');

    //GD库检测
    $tmp = function_exists('gd_info') ? gd_info() : array();
    if(empty($tmp['GD Version'])){
        $items['gd'][3] = '未安装';
        $items['gd'][4] = 'no';
    } else {
        $items['gd'][3] = $tmp['GD Version'];
    }
    unset($tmp);

    //磁盘空间检测
    if(function_exists('disk_free_space')) {
        $items['disk'][3] = floor(disk_free_space(INSTALL_APP_PATH) / (1024*1024)).'M';
    }

    return $items;
}

/**
 * 目录，文件读写检测
 * @return array 检测数据
 */
function check_dirfile(){
    $items = array(
        array('dir',  '可写', 'yes', './static/upload'),
        array('dir', '可写', 'yes', './runtime'),
        array('dir', '可写', 'yes', './databak'),
        array('dir', '可写', 'yes', './data'),
        array('dir', '可写', 'yes', './application/admin/controller'),
        array('dir', '可写', 'yes', './themes/admin'),
        array('file', '可写', 'yes', './application/database.php'),
    );

    foreach ($items as &$val) {
        if('dir' == $val[0]){
            if(!is_writable(INSTALL_APP_PATH . $val[3])) {
                if(is_dir($items[1])) {
                    $val[1] = '可读';
                    $val[2] = 'no';
                } else {
                    $val[1] = '不存在';
                    $val[2] = 'no';
                }
            }
        } else {
            if(file_exists(INSTALL_APP_PATH . $val[3])) {
                if(!is_writable(INSTALL_APP_PATH . $val[3])) {
                    $val[1] = '不可写';
                    $val[2] = 'no';
                }
            } else {
                if(!is_writable(dirname(INSTALL_APP_PATH . $val[3]))) {
                    $val[1] = '不存在';
                    $val[2] = 'no';
                }
            }
        }
    }

    return $items;
}

/**
 * 函数检测
 * @return array 检测数据
 */
function check_func(){
    $items = array(
        array('mysql_connect',     '支持', 'yes'),
        array('file_get_contents', '支持', 'yes'),
        array('mb_strlen',		   '支持', 'yes'),
    );

    foreach ($items as &$val) {
        if(!function_exists($val[0])){
            $val[1] = '不支持';
            $val[2] = 'no';
            $val[3] = '开启';
        }
    }

    return $items;
}

/**
 * 写入配置文件
 * @param  array $config 配置信息
 */
function write_config($config){
    if(is_array($config)){
        //读取配置内容
        $conf = file_get_contents(ROOT_PATH . 'data/database.tpl');
        $conf = str_replace("{hostname}", $config['db_host'], $conf);
        $conf = str_replace("{database}", $config['db_name'], $conf);
        $conf = str_replace("{username}", $config['db_user'], $conf);
        $conf = str_replace("{password}", $config['db_pwd'], $conf);
        $conf = str_replace("{prefix}", '', $conf);
        //写入应用配置文件
        if(!IS_WRITE){
            return '由于您的环境不可写，所以，程序挂了，重新来过吧！';
        }else{
            if(file_put_contents(APP_PATH . 'database.php', $conf)){
                show_msg('配置文件写入成功');
            } else {
                show_msg('配置文件写入失败！', 'error');
            }
        }
        //写入安装成功文件
        if( file_put_contents( ROOT_PATH.'data'.DS.'install.lock', 'success' ) ){
            show_msg('安装锁定文件写入成功');
        }else{
            show_msg('安装锁定文件写入失败！', 'error');
            exit;
        }
        return '';
    }
}

/**
 * 创建数据表
 * @param  resource $db 数据库连接资源
 */
function create_tables($dbConfig, $prefix = ''){
    $config = config('database');
    config('database.hostname',$dbConfig['db_host']);
    config('database.database',$dbConfig['db_name']);
    config('database.username',$dbConfig['db_user']);
    config('database.password',$dbConfig['db_pwd']);
    config('database.hostport',$dbConfig['db_port']);
    //数据库链接测试
    try{
        $db_name = Db::query('SELECT * FROM information_schema.SCHEMATA where SCHEMA_NAME=\''.$dbConfig['db_name'].'\';');
    }catch (Exception $e){
        show_msg('数据库不存在');
        exit;
    }
    //读取SQL文件
    $sql = file_get_contents(ROOT_PATH . 'data/install.sql');
    $sql = str_replace("\r", "\n", $sql);
    $sql = explode(";\n", $sql);

    //替换表前缀
    $sql = str_replace("{orginal}", "{$prefix}", $sql);

    //开始安装
    show_msg('开始安装数据库...');
    foreach ($sql as $value) {
        $value = trim($value);
        if(empty($value)) continue;
        if(substr($value, 0, 12) == 'CREATE TABLE') {
            $name = preg_replace("/^CREATE TABLE `(\w+)` .*/s", "\\1", $value);
            $msg  = "创建数据表{$name}";
            if(false !== Db::execute($value)){
                show_msg($msg . '...成功');
            } else {
                show_msg($msg . '...失败！', 'error');
            }
        } else {
            Db::execute($value);
        }
    }
    success();
}

/**
 * 及时显示提示信息
 * @param  string $msg 提示信息
 */
function show_msg($msg, $class = ''){
    echo "<script type=\"text/javascript\">showmsg(\"{$msg}\", \"{$class}\")</script>";
    flush();
    ob_flush();
}

/**
 * 安装完成
 * @var string
 */
function success(){
    echo "<script type=\"text/javascript\">success()</script>";
    flush();
    ob_flush();
}



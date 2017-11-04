<?php

// +----------------------------------------------------------------------
// | SWADMIN后台管理系统
// +----------------------------------------------------------------------
// | 版权所有 2016~2017 顺为科技有限公司
// +----------------------------------------------------------------------
// | 官方网站:http://www.scshunwei.com
// +----------------------------------------------------------------------


use service\DataService;
use service\FileService;
use service\NodeService;
use service\SoapService;
use think\Db;
use wechatSdk\Wechat;
use wechatSdk\Api;
/**
 * 打印输出数据到文件
 * @param mixed $data
 * @param bool $replace
 * @param string|null $pathname
 */
function p($data, $replace = false, $pathname = null)
{
    is_null($pathname) && $pathname = RUNTIME_PATH . date('Ymd') . '.txt';
    $str = (is_string($data) ? $data : (is_array($data) || is_object($data)) ? print_r($data, true) : var_export($data, true)) . "\n";
    $replace ? file_put_contents($pathname, $str) : file_put_contents($pathname, $str, FILE_APPEND);
}

/**
 * 获取mongoDB连接
 * @param string $col 数据库集合
 * @param bool $force 是否强制连接
 * @return \think\db\Query|\think\mongo\Query
 */
function mongo($col, $force = false)
{
    return Db::connect(config('mongo'), $force)->name($col);
}

/**
 * UTF8字符串加密
 * @param string $string
 * @return string
 */
function encode($string)
{
    list($chars, $length) = ['', strlen($string = iconv('utf-8', 'gbk', $string))];
    for ($i = 0; $i < $length; $i++) {
        $chars .= str_pad(base_convert(ord($string[$i]), 10, 36), 2, 0, 0);
    }
    return $chars;
}

/**
 * UTF8字符串解密
 * @param string $string
 * @return string
 */
function decode($string)
{
    $chars = '';
    foreach (str_split($string, 2) as $char) {
        $chars .= chr(intval(base_convert($char, 36, 10)));
    }
    return iconv('gbk', 'utf-8', $chars);
}

/**
 * 网络图片本地化
 * @param string $url
 * @return string
 */
function local_image($url)
{
    if (is_array(($result = FileService::download($url)))) {
        return $result['url'];
    }
    return $url;
}

/**
 * 日期格式化
 * @param string $date 标准日期格式
 * @param string $format 输出格式化date
 * @return false|string
 */
function format_datetime($date, $format = 'Y年m月d日 H:i:s')
{
    return empty($date) ? '' : date($format, strtotime($date));
}

/**
 * 设备或配置系统参数
 * @param string $name 参数名称
 * @param bool $value 默认是null为获取值，否则为更新
 * @return string|bool
 */
function sysconf($name, $value = null)
{
    static $config = [];
    if ($value !== null) {
        list($config, $data) = [[], ['name' => $name, 'value' => $value]];
        return DataService::save('SystemConfig', $data, 'name');
    }
    if (empty($config)) {
        $config = Db::name('SystemConfig')->column('name,value');
    }
    return isset($config[$name]) ? $config[$name] : '';
}

/**
 * RBAC节点权限验证
 * @param string $node
 * @return bool
 */
function auth($node)
{
    return NodeService::checkAuthNode($node);
}

/**
 * array_column 函数兼容
 */
if (!function_exists("array_column")) {

    function array_column(array &$rows, $column_key, $index_key = null)
    {
        $data = [];
        foreach ($rows as $row) {
            if (empty($index_key)) {
                $data[] = $row[$column_key];
            } else {
                $data[$row[$index_key]] = $row[$column_key];
            }
        }
        return $data;
    }

}

/**
 * 导入自定义配置
 * @access public
 * @param mixed $file
 * @return mixed
 */
function getConfig($fileName,$file = false,$folder = 'PostField'){
    $path = APP_PATH.'config'.DIRECTORY_SEPARATOR.$folder.DIRECTORY_SEPARATOR.$fileName;
    if($file){
        return file_get_contents($path);
    }else{
        return require_once $path;
    }
}

/*
 * 下划线转驼峰
 */
function convertUnderline($str)
{
    $str = preg_replace_callback('/([-_]+([a-z]{1}))/i',function($matches){
        return strtoupper($matches[2]);
    },$str);
    return $str;
}

/*
 * 驼峰转下划线
 */
function humpToLine($str){
    $str = preg_replace_callback('/([A-Z]{1})/',function($matches){
        return '_'.strtolower($matches[0]);
    },$str);
    return $str;
}

function convertHump(array $data){
    $result = [];
    foreach ($data as $key => $item) {
        if (is_array($item) || is_object($item)) {
            $result[$this->humpToLine($key)] = $this->convertHump((array)$item);
        } else {
            $result[$this->humpToLine($key)] = $item;
        }
    }
    return $result;
}

/**
 *  获取微信实例
 * @var string
 */
function getWechat(){
    // wechat模块 - 处理用户发送的消息和回复消息
    $wechat = new Wechat(array(
        'appId' => config('appId'),
        'token' => 	config('token'),
        'encodingAESKey' =>	config('encodingAESKey') //可选
    ));
    return $wechat;
}

/**
 * 获取微信实例API
 * @var string
 */
function getWechatApi(){
    // api模块 - 包含各种系统主动发起的功能
    $api = new Api(
        array(
            'appId' => config('appId'),
            'appSecret'	=> config('appSecret'),
            'mchId' => config('mchId'),
            'key' => config('wechatKey'),
            'get_access_token' => function(){
                return cache('wechat_token');
            },
            'save_access_token' => function($token) {
                cache('wechat_token', $token);
            },
            'get_jsapi_ticket' => function() {
                return cache('jsapi_ticket');
            },
            'save_jsapi_ticket' => function($jsapi_ticket) {
                cache('jsapi_ticket', $jsapi_ticket);
            }
        )
    );
    return $api;
}
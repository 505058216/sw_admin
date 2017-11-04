<?php

// +----------------------------------------------------------------------
// | SWADMIN后台管理系统
// +----------------------------------------------------------------------
// | 版权所有 2016~2017 顺为科技有限公司
// +----------------------------------------------------------------------
// | 官方网站:http://www.scshunwei.com
// +----------------------------------------------------------------------

namespace app\index\controller;

use think\Controller;
use wechatSdk\Wechat;
/**
 * 网站入口控制器
 * Class Index
 * @package app\index\controller
 * @author 隔壁老吴 <505058216@qq.com>
 * @date 2017/04/05 10:38
 */
class Index extends Controller
{

    /**
     * 网站入口
     */
    public function index()
    {
        $this->redirect('@admin');
    }

}

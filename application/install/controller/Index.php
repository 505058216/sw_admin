<?php

/**
 * Created by 顺为科技.
 * File: Index.php
 * User: 隔壁老吴
 * Author: 505058216@qq.com
 * Date: 2017/10/26
 * Time: 13:49
 */
namespace app\install\controller;

use think\Controller;
use think\Exception;

/**
 * 安装程序
 * Class Index
 * @package Index
 * @author 隔壁老吴 <505058216@qq.com>
 * @date 2017/10/26 13:51
 */
class Index extends Controller{

    /**
     * 安装向导
     * @var string
     */
    public function index(){
        // 检测是否安装过
        if (file_exists(ROOT_PATH.'data'.DS.'install.lock')) {
            echo '你已经安装过该系统，重新安装需要先删除/data/install.lock 文件';
            die;
        }
        return view();
    }

    /**
     * 第一步
     * @var string
     */
    public function step1(){
        header('Content-type:text/html;charset=utf-8');
        //环境监测
        $this->assign('check_env',check_env());
        //目录权限
        $this->assign('check_dirfile',check_dirfile());
        //函数监测
        $this->assign('check_func',check_func());
        return view();
    }

    /**
     * 第三步
     * @var string
     */
    public function step2(){
        return view();
    }

    /**
     * 第三步
     * @var string
     */
    public function step3(){
        $db_config = array(
            'db_host' => input('db_host'),
            'db_name' => input('db_name'),
            'db_user' => input('db_user'),
            'db_pwd' => input('db_pwd'),
            'db_port' => input('db_port')
        );

        if( empty($db_config['db_host']) ){
            $this->error('请填写数据库服务器');
        }
        if( empty($db_config['db_name']) ){
            $this->error('请填写数据库名');
        }
        if( empty($db_config['db_user']) ){
            $this->error('请填写数据库用户名');
        }
        if( empty($db_config['db_pwd']) ){
            $this->error('请填写数据库密码');
        }
        if( empty($db_config['db_port']) ){
            $this->error('请填写数据库端口');
        }
        //数据库链接测试
        try{
            mysqli_connect($db_config['db_host'], $db_config['db_user'], $db_config['db_pwd']);
        }catch ( Exception $e ){
            $this->error('数据库链接失败');
        }
        $this->assign('db_config',$db_config);
        echo $this->fetch();
        flush();
        ob_flush();
        //创建数据表
        create_tables($db_config);

        //创建配置文件
        write_config($db_config);

    }

}
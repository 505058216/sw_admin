<?php
/**
 * Created by 顺为科技.
 * File: Baksql.php
 * User: 隔壁老吴
 * Author: 505058216@qq.com
 * Date: 2017/10/26
 * Time: 9:25
 */

namespace app\admin\controller;

use controller\BasicAdmin;
use service\BaksqlService;

/**
 * 数据库备份
 * Class Baksql
 * @package Baksql
 * @author 隔壁老吴 <505058216@qq.com>
 * @date 2017/10/26 9:28
 */
class Baksql extends BasicAdmin
{
    protected $baksql;

    protected function _initialize()
    {
        parent::_initialize();
        $this->baksql        = new BaksqlService(config('database'));
    }

    /**
     * 导出数据库
     * @var string
     */
    public function backsql(){
        $this->baksql->backup();
    }

    /**
     * 数据库备份列表
     * @var string
     */
    public function index(){
        $this->assign('title','数据库备份');
        $type=input("tp");
        $name=input("name");
        $sql= $this->baksql;
        switch ($type)
        {
            case "backup": //备份
                return $sql->backup();
                break;
            case "dowonload": //下载
                $sql->downloadFile($name);
                break;
            case "restore": //还原
                return $sql->restore($name);
                break;
            case "del": //删除
                return $sql->delfilename($name);
                break;
            default: //获取备份文件列表
                return $this->fetch("db_bak",["list"=>$sql->get_filelist()]);

        }
    }
}
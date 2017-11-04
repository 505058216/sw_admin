<?php

/**
 * Created by 顺为科技.
 * File: Controller.php
 * User: 隔壁老吴
 * Author: 505058216@qq.com
 * Date: 2017/10/21
 * Time: 16:41
 */
namespace app\admin\controller;

use controller\BasicAdmin;
use service\DataService;
use service\NodeService;
use service\ToolsService;

class {Controller} extends BasicAdmin{

    /**
     * 默认数据模型
     * @var string
     */
    public $table = '{table}';

    /**
     * 列表
     * @var string
     */
    public function index(){
        //页面标题
        $this->title = '{ModelName}';
        $where = array();
        $whereDate = '1=1';
        //搜索条件
        {where}
        $db = db($this->table)->where($where)->where($whereDate);
        return parent::_list($db);
    }

    /**
     * 新增{ModelName}
     * @var string
     */
    public function add(){

        return $this->_form($this->table, 'form');

    }

    /**
     * 修改{ModelName}
     * @var string
     */
    public function edit(){
        return $this->_form($this->table, 'form');
    }

    /**
     * 删除{ModelName}
     * @var string
     */
    public function del(){
        if (DataService::update($this->table)) {
            $this->success("{ModelName}删除成功!", '');
        }
        $this->error("{ModelName}删除失败, 请稍候再试!");
    }

    /**
     * 状态更改
     * @var string
     */
    public function status(){
        if (DataService::update($this->table)) {
            $this->success("状态更改成功!", '');
        }
        $this->error("状态更改失败, 请稍候再试!");
    }

}
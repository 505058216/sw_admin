<?php
/**
 * Created by 顺为科技.
 * File: Field.php
 * User: 隔壁老吴
 * Author: 505058216@qq.com
 * Date: 2017/10/20
 * Time: 18:42
 */

namespace app\admin\controller;


use controller\BasicAdmin;
use service\DataService;
use service\NodeService;
use service\ToolsService;
use service\ModelService;
use think\Db;
/**
 * 
 * Class 字段管理
 * @package Field
 * @author 隔壁老吴 <505058216@qq.com>
 * @date 2017/10/20 18:42
 */
class Field extends BasicAdmin{

    public $table = 'SystemModelfield';
    /**
     * 字段列表
     * @var string
     */
    public function index(){
        $modelid = input("modelid","0","int");
        $this->assign('title','字段管理');
        if($modelid != 0){
            $db = db($this->table)->where(array('modelid'=>$modelid));
            return parent::_list($db);
        }else{
            $this->error('参数错误! 001');
        }
    }
    /**
     * 添加字段
     * @var string
     */
    public function add(){
        if( $this->request->isPost() ){
            $data = $this->request->post();
            //判断是否为系统模型
            $model = db('system_model')->where(array('id'=>$data['modelid'],'issys'=>1))->find();
            if( !empty($model) ){
                $this->error('系统模型，禁止编辑');
            }
            //判断字段是否已经存在
            $isfield = db($this->table)->where(array('modelid'=>$data['modelid'],'field'=>$data['field']))->find();
            if( !empty($isfield) ){
                $this->error('字段已存在');
            }
            //判断是否存在数组，如果是则序列化
            foreach ( $data as $key=>$vo ){
                if( is_array($vo) ){
                    $data[$key] = serialize($vo);
                }
            }
            // 启动事务
            Db::startTrans();
            try{
                //新增数据
                $result = DataService::saveGetId($this->table, $data);
                $model = new ModelService();
                //开始新增模型
                $model->addFieldSql($result);
                Db::commit();
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
                $this->error($e->getFile().','.$e->getLine().','.$e->getMessage());
            }
            $this->success('添加成功','');
        }else{
            $this->assign('fields',getConfig('fields.inc.php'));
            $this->assign('pattern',getConfig('fields.pattern.php'));
            return $this->_form($this->table,'form');
        }
    }

    /**
     * 修改字段
     * @var string
     */
    public function edit(){
        if( $this->request->isPost() ){
            $data = $this->request->post();
            //判断是否为系统模型
            $model = db('system_model')->where(array('id'=>$data['modelid'],'issys'=>1))->find();
            if( !empty($model) ){
                $this->error('系统模型，禁止编辑');
            }

            //判断是否存在该字段名
            $field = db($this->table)->where(array('id'=>$data['id']))->find();
            if( empty($field) ){
                $this->error('字段已删除');
            }
            if( $field['issystem'] == 1 ){
                $this->error('系统字段，禁止编辑');
            }
            //如果未发生变化，则不修改
            if( $field['field'] == $data['field'] ){
                unset($data['field']);
            }else{
                $isfield = db($this->table)->where(array('field'=>$data['field']))->find();
                if( !empty($isfield) ){
                    $this->error('字段名已存在');
                }
            }
            /*开始进行修改*/
            // 启动事务
            Db::startTrans();
            try{
                //新增数据
                $result = DataService::saveGetId($this->table, $data);
                $model = new ModelService();
                $model->setField($data);
                //开始新增模型
                $model->updateFieldSql($field['id'],$field);
                Db::commit();
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
                $this->error($e->getMessage());
            }
            $this->success("修改成功", '');
        }else{
            $this->assign('fields',getConfig('fields.inc.php'));
            $this->assign('pattern',getConfig('fields.pattern.php'));
            return $this->_form($this->table,'form');
        }
    }

    /**
     * 更改状态
     * @var string
     */
    public function status(){
        if (DataService::update($this->table)) {
            $this->success("状态更改成功！", '');
        }
        $this->error("状态更改失败，请稍候再试！");
    }

    /**
     * 删除字段
     */
    public function del()
    {
        $id = input('id');
        //查询字段
        $field = db('system_modelfield')->where(array('id'=>$id))->find();
        if( empty($field) ){
            $this->error('字段不存在或已删除');
        }
        if( $field['issystem'] == 1 ){
            $this->error('系统字段，禁止删除');
        }
        //判断是否为系统模型
        $model = db('system_model')->where(array('id'=>$field['modelid'],'issys'=>1))->find();
        if( !empty($model) ){
            $this->error('系统模型，禁止编辑');
        }
        /*开始进行删除*/
        // 启动事务
        Db::startTrans();
        try{
            $model = new ModelService();
            //开始删除模型
            $model->delFieldSql($field);
            $result = DataService::update($this->table);
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            $this->error($e->getMessage());
        }
        $this->success("字段删除成功!", '');
    }

    /**
     * 获取字段附加表单
     * @var string
     */
    public function getFieldPost( $field = '',$id = '' ){
        if( empty($field) ){
            $this->error('参数错误');
        }
        if( !empty($id) ){
            $data = db('SystemModelfield')->where(array('id'=>$id))->find();
            $setting = empty($data['setting'])?[]:unserialize($data['setting']);
        }
        $data = getConfig($field.DIRECTORY_SEPARATOR.'config.inc.php');
        require_once APP_PATH.'config'.DIRECTORY_SEPARATOR.'PostField'.DIRECTORY_SEPARATOR.$field.DIRECTORY_SEPARATOR.'field_form.inc.php';
        $data_setting = ob_get_contents();
        ob_end_clean();
        $data['form'] = $data_setting;
        $this->success($data);
    }



}
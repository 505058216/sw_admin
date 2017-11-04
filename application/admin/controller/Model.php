<?php
/**
 * Created by 顺为科技.
 * File: Model.php
 * User: 隔壁老吴
 * Author: 505058216@qq.com
 * Date: 2017/10/20
 * Time: 17:26
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
 * Class 模型管理
 * @package Model
 * @author 隔壁老吴 <505058216@qq.com>
 * @date 2017/10/20 17:34
 */
class Model extends BasicAdmin{

    public $table = 'SystemModel';
    /**
     * 模型管理
     * @var function
     */
    public function model(){
        $this->assign('title','模型管理');
        $db = db($this->table);
        return parent::_list($db);
    }

    /**
     * 添加模型
     * @var string
     */
    public function add(){
        if( $this->request->isPost() ){
            $data = $this->request->post();
            $data['tablename'] = strtolower($data['tablename']);
            //查询表名是否重复
            $table = db('system_model')->where(array('tablename'=>$data['tablename']))->find();
            if( !empty($table) ){
                $this->error('表名已存在');
            }
            Db::startTrans();
            try{
                //新增菜单
                $menuData = array(
                    'pid' => $data['menuid'],
                    'title' => $data['menuname'],
                    'url' => 'admin/'.$data['tablename'].'/index',
                    'target' => '_self',
                    'sort' => 999,
                    'status' => 1
                );
                $addMenu = db('system_menu')->insertGetId($menuData);
                $data['menuid'] = $addMenu;
                //新增数据
                $result = DataService::saveGetId($this->table, $data);
                $data['id'] = $result;
                $model = new ModelService();
                //初始化
                $model->start($result);
                //初始化模型
                $model->setModel($data);
                //开始新增模型
                $model->insertModelSql();
                Db::commit();
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
                $this->error($e->getMessage());
            }
            $this->success("添加成功", '');
        }else{
            return $this->_form($this->table,'form');
        }
    }

    /**
     * 修改模型
     * @var string
     */
    public function edit(){
        if( $this->request->isPost() ){
            $data = $this->request->post();
            //查询原表名
            $table = db($this->table)->where(array('id'=>$data['id']))->find();
            // 启动事务
            Db::startTrans();
            try{
                $modalData = db('system_model')->where(array('id'=>$data['id']))->find();
                if( empty($modalData) ){
                    throw new \think\Exception('模型已删除或不存在', 100006);
                }
                //修改菜单
                $data['menuid'] = $modalData['menuid'];
                db('system_menu')->where(array('id'=>$modalData['menuid']))->update(array('url'=>'admin/'.$data['tablename'].'/index','title'=>$data['menuname']));
                //修改数据
                $result = DataService::saveGetId($this->table, $data);
                $model = new ModelService();
                //初始化
                $model->setModel($data);
                //开始修改模型
                $status = $model->updateModelSql($table['tablename']);
                // 提交事务
                Db::commit();
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
                $this->error($e->getMessage());
            }
            $this->success('修改成功','');
        }else{
            //查询菜单上级ID
            $modalData = db('system_model')->where(array('id'=>input('id')))->find();
            if( empty($modalData) ){
                $this->error('模型不存在');
            }
            $menu = db('system_menu')->where(array('id'=>$modalData['menuid']))->find();
            $this->assign('cmenu',$menu);
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
     * 删除模型
     */
    public function del()
    {
        //删除数据库
        $table = db($this->table)->where(array('id'=>input('id')))->find();
        // 启动事务
        Db::startTrans();
        try{
            $model = new ModelService();
            //初始化
            $model->start($table['id']);
            //删除相关字段数据
            Db::name('SystemModelfield')->where(array('modelid'=>$table['id']))->delete();
            //删除相关菜单
            db('system_menu')->where(array('id'=>$table['menuid']))->delete();
            //删除控模板
            $model->delThemes();
            //开始删除数据库模型
            $status = $model->delModelSql();
            //开始删除
            DataService::update($this->table);
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            $this->error($e->getMessage());
        }
        $this->success("模型删除成功!", '');
    }

    /**
     * 生成模型
     * @var string
     */
    public function generate( $id = '' ){
        if( empty($id) ){
            $this->error('参数错误，请刷新后重试');
        }
        //查询模型
        $model = db($this->table)->where(array('id'=>$id))->find();
        if( empty($model) ){
            $this->error('模型不存在或已删除');
        }
        if( $model['issys'] == 1 ){
            $this->error('系统模型，禁止生成');
        }
        try{
            $model = new ModelService;
            //执行生成
            $model->start($id);
            //生成模型
            $model->generateControllrt();
            //生成视图
            $model->generateViewList();
            //生成编辑修改视图
            $model->generateViewForm();
        } catch (\Exception $e) {
            // 回滚事务
            $this->error($e->getMessage());
        }
        $this->success('生成成功','');
    }

    /**
     * 表单数据前缀方法
     * @param array $vo
     */
    protected function _form_filter(&$vo)
    {
        if ($this->request->isGet()) {
            // 上级菜单处理
            $_menus = Db::name('system_menu')->where(['status' => '1'])->order('sort asc,id asc')->select();
            $_menus[] = ['title' => '顶级菜单', 'id' => '0', 'pid' => '-1'];
            $menus = ToolsService::arr2table($_menus);
            foreach ($menus as $key => &$menu) {
                if (substr_count($menu['path'], '-') > 3) {
                    unset($menus[$key]);
                    continue;
                }
                if (isset($vo['pid'])) {
                    $current_path = "-{$vo['pid']}-{$vo['id']}";
                    if ($vo['pid'] !== '' && (stripos("{$menu['path']}-", "{$current_path}-") !== false || $menu['path'] === $current_path)) {
                        unset($menus[$key]);
                        continue;
                    }
                }
            }
            // 读取系统功能节点
            $nodes = NodeService::get();
            foreach ($nodes as $key => $node) {
                if (empty($node['is_menu'])) {
                    unset($nodes[$key]);
                }
            }
            $this->assign('nodes', array_column($nodes, 'node'));
            $this->assign('menus', $menus);
        }
    }
}
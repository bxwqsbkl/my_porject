<?php
/**
 * Created by PhpStorm.
 * User: Lin
 * Date: 2016/11/13 0013
 * Time: 11:28
 */

namespace Admin\Controller;


use Think\Controller;

class RoleController extends Controller{
    protected $_model=null;
    protected function _initialize() {
        $this->_model = D('Role');
    }
    /**
     * 角色列表
     * @param $id
     */
    public function index(){
        $keyword=trim(I('get.keyword'));
        $cond=[];
        if($keyword){
            $cond['name']=['like','%'.$keyword.'%'];
        }
        $rows=$this->_model->getList($cond);
        $this->assign('rows',$rows);
        $this->display('index');
    }

    /**
     * 新增角色
     * @param $id
     */
    public function add(){
        if(IS_POST){
            if($this->_model->create()==false){
                $this->error(get_error($this->_model));
            }
            if($this->_model->addRole()==false){
                $this->error($this->_model->getError());
            }else{
                $this->success('添加成功!',U('index'));
            }
        }else{
            $this->_before_view();
            $this->display('add');
        }
    }
    public function _before_view(){
        $permission_model=D('Permission');
        $permissions=$permission_model->select();
        $this->assign('permissions',json_encode($permissions));
    }

    /**
     * 修改角色
     * @param $id
     */
    public function edit($id){
        if(IS_POST){
            if($this->_model->create()==false){
                $this->error(get_error($this->_model));
            }
            if($this->_model->saveRole()==false){
                $this->error($this->_model->getError());
            }else{
                $this->success('修改成功!',U('index'));
            }
        }else{
            $row=$this->_model->getEditMsg($id);
            $this->_before_view();
            $this->assign('row',$row);
            $this->display('add');
        }
    }

    /**
     * 删除角色
     * @param $id
     */
    public function remove($id){
        $result=$this->_model->deleteRole($id);
        if($result==false){
            $this->error('删除失败!');
        }else{
            $this->success('删除成功!');
        }
    }
}
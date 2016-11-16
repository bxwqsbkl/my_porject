<?php
/**
 * Created by PhpStorm.
 * User: Lin
 * Date: 2016/11/13 0013
 * Time: 11:47
 */

namespace Admin\Controller;


use Think\Controller;

class PermissionController extends Controller
{
    protected $_model=null;
    protected function _initialize(){
        $this->_model=D('Permission');
    }
    /**
     * 权限列表
     */
    public function index(){
        $rows=$this->_model->getList();
        $this->assign('rows',$rows);
        $this->display('index');
    }
    /**
     * 新增权限
     */
    public function add(){
        if(IS_POST){
            if($this->_model->create()==false){
                $this->get_error($this->_model);
            }
            if($this->_model->addPermission()==false){
                $this->error($this->_model->getError());
            }else{
                $this->success('添加成功!',U('index'));
            }

        }else{
            $this->_before_view();
            $this->display('add');
        }
    }
    /**
     * 修改权限
     */
    public function edit($id){
        if(IS_POST){
            if($this->_model->create()==false){
                $this->get_error($this->_model);
            }
            if($this->_model->savePermission()==false){
                $this->error($this->_model->getError());
            }else{
                $this->success('修改成功!',U('index'));
            }
        }else{
            $this->_before_view();
            $row=$this->_model->find($id);
            $this->assign('row',$row);
            $this->display('add');
        }
    }
    /**
     * 删除权限
     */
    public function remove($id){
        if($this->_model->deletePermission($id)==false){
            $this->error($this->_model->getError());
        }
        $this->success('删除成功!',U('index'));
    }
    public function _before_view(){
        $rows=$this->_model->getList();
        array_unshift($rows,['id'=>0,'name'=>'顶级权限']);
        $this->assign('permissions',json_encode($rows));
    }
}
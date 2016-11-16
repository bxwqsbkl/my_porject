<?php
/**
 * Created by PhpStorm.
 * User: Lin
 * Date: 2016/11/15 0015
 * Time: 15:01
 */

namespace Admin\Controller;


use Think\Controller;

class MenuController extends Controller
{
    /**
     * @var \Admin\Model\MenuModel
     */
    private $_model = null;
    protected function _initialize() {
        $this->_model = D('Menu');
    }
    public function index(){
        $rows=$this->_model->getList();
        $this->assign('rows',$rows);
        $this->display('index');
    }
    public function add(){
        if(IS_POST){
            if($this->_model->create()==false){
                $this->error(get_error($this->_model));
            }
            if($this->_model->addMenu()==false){
                $this->error(get_error($this->_model));
            }
            $this->success('添加成功!',U('index'));
        }else{
            $this->_before_view();
            $this->display('add');
        }
    }
    public function edit($id){
        if(IS_POST){
            if($this->_model->create()==false){
                $this->error(get_error($this->_model));
            }
            if($this->_model->saveMenu($id)==false){
                $this->error(get_error($this->_model));
            }
            $this->success('修改成功!',U('index'));
        }else{
            $row=$this->_model->getMenuInfo($id);
            $this->assign('row',$row);
            $this->_before_view();
            $this->display('add');
        }
    }
    public function remove($id){
        if($this->_model->deleteMenu($id)==false){
            $this->error('删除失败',U('index'));
        }else{
            $this->success('删除成功!',U('index'));
        }
    }
    public function _before_view(){
        $permission_model=D('Permission');
        $permissions=$permission_model->getList();
        $menus=$this->_model->getList();
        $menus[]=[
            'id'=>0,
            'name'=>'顶级菜单'
        ];
        $this->assign('permissions',json_encode($permissions));
        $this->assign('menus',json_encode($menus));
    }

}
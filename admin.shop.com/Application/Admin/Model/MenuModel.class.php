<?php
/**
 * Created by PhpStorm.
 * User: Lin
 * Date: 2016/11/15 0015
 * Time: 15:11
 */

namespace Admin\Model;


use Admin\Logic\MySQLORM;
use Admin\Logic\NestedSets;
use Think\Model;

class MenuModel extends Model
{
    /**
     * 获取所有已有菜单信息
     * @return mixed
     */
    public function getList(){
        $rows=$this->order('lft')->select();
        return $rows;
    }

    /**
     * 天价菜单数据
     * @return bool
     */
    public function addMenu(){
        $this->startTrans();
        $data=$this->data;
        unset($data['id']);
        $orm=new MySQLORM();
        $nestedSets=new NestedSets($orm, $this->getTableName(), 'lft', 'rght','parent_id', 'id', 'level');
        $menu_id=$nestedSets->insert($data['parent_id'], $data,'bottom');
        if($menu_id==false){
            $this->rollback();
            return false;
        }
        $permission_ids=I('post.permission_id');
        $data=[];
        foreach($permission_ids as $permission_id){
            $data[]=[
                'menu_id'=>$menu_id,
                'permission_id'=>$permission_id
            ];
        }
        if((M('MenuPermission')->addAll($data))==false){
            $this->rollback();
            return false;
        }
        $this->commit();
        return true;
    }

    /**
     * 根据ID查询菜单信息
     * @param $id
     * @return mixed
     */
    public function getMenuInfo($id){
        $row=$this->find($id);
        $row['permission_ids']=json_encode(M('MenuPermission')->where(['menu_id'=>$id])->getField('permission_id',true));
        return $row;
    }

    /**
     * 保存修改后的数据
     * @param $id
     * @return bool
     */
    public function saveMenu($id){
        $this->startTrans();
        $old_parent_id = $this->where(['id' => $id])->getField('parent_id');
        if ($old_parent_id != $this->data['parent_id']) {
            //需要计算左右节点和层级，那么我们还是要使用nestedsets
            $orm        = new \Admin\Logic\MySQLORM();
            $nestedSets = new \Admin\Logic\NestedSets($orm, $this->getTableName(), 'lft', 'rght', 'parent_id', 'id', 'level');
            if ($nestedSets->moveUnder($this->data['id'], $this->data['parent_id'], 'bottom') === false) {
                $this->rollback();
                $this->error = '不能将分类移动到后代分类中';
                return false;
            }
        }
        //保存菜单和权限关联关系
        $menu_permission_model = M('MenuPermission');
        //删除历史关联
        if ($menu_permission_model->where(['menu_id' => $id])->delete() === false) {
            $this->rollback();
            return false;
        }
        //收集数据
        $permission_ids = I('post.permission_id');
        if (empty($permission_ids)) {
            $this->commit();
            return true;
        }
        $data = [];
        foreach ($permission_ids as $permission_id) {
            $data[] = [
                'menu_id'       => $id,
                'permission_id' => $permission_id,
            ];
        }
        if ($menu_permission_model->addAll($data) === false) {
            $this->error = '保存菜单和权限关联关系失败';
            $this->rollback();
            return false;
        }
        $this->commit();
        return true;
    }

    /**
     * 删除菜单列表
     * @param $id
     * @return bool
     */
    public function deleteMenu($id){
        $this->startTrans();
        $orm        = new \Admin\Logic\MySQLORM();
        $nestedSets = new \Admin\Logic\NestedSets($orm, $this->getTableName(), 'lft', 'rght', 'parent_id', 'id', 'level');
        if ($nestedSets->delete($id) === false) {
            $this->error = '删除失败';
            $this->rollback();
            return false;
        }
        $re=M('MenuPermission')->where(['menu_id'=>$id])->select();
        if(empty($re)){
            $this->commit();
            return true;
        }
        $res=M('MenuPermission')->where(['menu_id'=>$id])->delete();
        if ($res==false) {
            $this->rollback();
            return false;
        }
        $this->commit();
        return true;
    }
    /**
     * 获取对应权限的菜单列表
     */
    public function getVisableMenu() {
        //SELECT DISTINCT m.id,m.`name`,m.`path`,m.`parent_id` FROM shop_menu_permission AS mp JOIN shop_menu AS m ON m.`id`=mp.`menu_id` WHERE permission_id IN(1,2,3,4,5,6)
        $admin_info = session('ADMIN_INFO');
        if($admin_info['username'] != 'admin'){
            //获取权限列表
            $pids = session('ADMIN_PIDS');
            return $this->distinct(true)->field('m.id,m.name,m.path,m.parent_id')->alias('m')->join('__MENU_PERMISSION__ as mp ON m.`id`=mp.`menu_id`')->where(['permission_id'=>['in',$pids]])->select();
        }else{
            $rows=$this->distinct(true)->field('m.id,m.name,m.path,m.parent_id')->alias('m')->select();
            return $rows;
        }

    }
}
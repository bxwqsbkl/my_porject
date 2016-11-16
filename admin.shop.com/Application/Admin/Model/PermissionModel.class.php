<?php
/**
 * Created by PhpStorm.
 * User: Lin
 * Date: 2016/11/13 0013
 * Time: 12:30
 */

namespace Admin\Model;


use Think\Model;

class PermissionModel extends Model
{
    public function getList(){
        $result=$this->order('lft')->select();
        return $result;
    }
    public function addPermission(){
        $data=$this->data;
        unset($data['id']);
        $orm        = new \Admin\Logic\MySQLORM();
        $NestedSets = new \Admin\Logic\NestedSets($orm, $this->getTableName(), 'lft', 'rght', 'parent_id','id', 'level');
        return $NestedSets->insert($this->data['parent_id'], $data, 'bottom');
    }
    public function savePermission(){
        //判断是否修改了父级分类
        //获取原来的父级分类
        $old_parent_id = $this->where(['id' => $this->data['id']])->getField('parent_id');
        if ($old_parent_id != $this->data['parent_id']) {
            //需要计算左右节点和层级，那么我们还是要使用nestedsets
            $orm        = new \Admin\Logic\MySQLORM();
            $nestedSets = new \Admin\Logic\NestedSets($orm, $this->getTableName(), 'lft', 'rght', 'parent_id', 'id', 'level');
            if ($nestedSets->moveUnder($this->data['id'], $this->data['parent_id'], 'bottom') === false) {
                $this->error = '不能将分类移动到后代分类中';
                return false;
            }
        }
        return $this->save();
    }
    public function deletePermission($id){
        $orm        = new \Admin\Logic\MySQLORM();
        $nestedSets = new \Admin\Logic\NestedSets($orm, $this->getTableName(), 'lft', 'rght', 'parent_id', 'id', 'level');
        if ($nestedSets->delete($id) === false) {
            $this->error = '删除失败';
            return false;
        }
        return true;
    }

}
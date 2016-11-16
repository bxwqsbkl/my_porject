<?php
/**
 * Created by PhpStorm.
 * User: Lin
 * Date: 2016/11/8 0008
 * Time: 15:16
 */

namespace Admin\Model;
use Think\Model;

class GoodsCategoryModel extends Model
{
    public function getList() {
        return $this->order('lft')->select();
    }
    public function addCategory() {
        $data=$this->data;
        unset($data['id']);
        $orm        = new \Admin\Logic\MySQLORM();
        $NestedSets = new \Admin\Logic\NestedSets($orm, $this->getTableName(), 'lft', 'rght', 'parent_id','id', 'level');
        return $NestedSets->insert($this->data['parent_id'], $data, 'bottom');
    }

    public function saveCategory() {
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

    /**
     * 删除分类及其后代分类
     * @param integer $id
     * @return boolean 成功或者失败。
     */
    public function deleteCategory($id) {
        //需要计算左右节点和层级，那么我们还是要使用nestedsets
        $orm        = new \Admin\Logic\MySQLORM();
        $nestedSets = new \Admin\Logic\NestedSets($orm, $this->getTableName(), 'lft', 'rght', 'parent_id', 'id', 'level');
        if ($nestedSets->delete($id) === false) {
            $this->error = '删除失败';
            return false;
        }
        return true;
    }
}
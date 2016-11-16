<?php
/**
 * Created by PhpStorm.
 * User: Lin
 * Date: 2016/11/13 0013
 * Time: 11:33
 */

namespace Admin\Model;


use Think\Model;

class RoleModel extends Model
{
    /**
     * 获取所有角色列表
     * @param array $cond
     * @return mixed
     */
    public function getList(array $cond=[]){
        $result=$this->where($cond)->order('sort')->select();
        return $result;
    }

    /**
     * 储存新添加的角色信息
     * @return bool
     */
    public function addRole(){
        $this->startTrans();
        $role_id=$this->add();
        if($role_id==false){
            $this->rollback();
            return false;
        }
        $permission_ids=I('post.permission_id');
        $data=[];
        foreach($permission_ids as $permission_id){
            $data[]=[
                'role_id'=>$role_id,
                'permission_id'=>$permission_id
            ];
        }
        $res=M('RolePermission')->addAll($data);
        if($res==false){
            $this->rollback();
            return false;
        }
        $this->commit();
        return true;
    }

    /**
     * 获取修改角色的信息
     * @param $id
     * @return mixed
     */
    public function getEditMsg($id){
        $data=$this->find($id);
        $permission_ids=D('RolePermission')->where('permission_id!=0')->where(['role_id'=>$id])->getField('permission_id',true);
        $data['permission_ids']=json_encode($permission_ids);
        return $data;
    }

    /**
     * 储存修改后的角色信息
     */
    public function saveRole(){
        $this->startTrans();
        $role_id=$this->data['id'];
        if($this->save()===false){
            $this->rollback();
            return false;
        }
        $role_permission_model=M('RolePermission');
        $role_permission_model->where(['role_id'=>$role_id])->delete();
        $permission_ids=I('post.permission_id');
        if(empty($permission_ids)){
            $this->commit();
            return true;
        }
        $data=[];
        foreach($permission_ids as $permission_id){
            $data[]=[
                'role_id'=>$role_id,
                'permission_id'=>$permission_id
            ];
        }
        $res=$role_permission_model->addAll($data);
        if($res==false){
            $this->rollback();
            return false;
        }
        $this->commit();
        return true;
    }
    public function deleteRole($id){
        $this->startTrans();
        $re=$this->delete($id);
        if($re===false){
            $this->rollback();
            return false;
        }
        $res=M('RolePermission')->where(['role_id'=>$id])->delete();
        if($res===false){
            $this->rollback();
            return false;
        }
        $this->commit();
        return true;
    }
}
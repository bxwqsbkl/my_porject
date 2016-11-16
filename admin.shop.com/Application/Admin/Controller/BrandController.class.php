<?php
namespace Admin\Controller;
use Think\Controller;
class BrandController extends Controller {
    /**
     * 品牌列表
     */
    public function index(){
        $keywords=trim(I('get.brand_name'))?trim(I('get.brand_name')):'';
        $cond=[];
        if($keywords){
            $cond['name']=['like', '%' . $keywords . '%'];
        }
        $goods_list=D('Brand');
        $data=$goods_list->getList($cond);
        $this->assign('rows',$data['rows']);
        $this->assign('page_msg',$data['page_msg']);
        $this->display('index');
    }

    /**
     * 新添加品牌
     */
    public function add(){
        if(IS_POST){
            $brand_model=D('Brand');
            if($brand_model->create()!==false){
                if($brand_model->add()!==false){
                    $this->success('添加成功!',U('index')) ;
                }
            }else{
                $this->error($brand_model->getError(),U('add')) ;
            }
        }else{
            $this->assign('act','添加品牌');
            $this->assign('url',U('add'));
            $this->display('add');
        }
    }
    /**
     * 修改品牌信息
     */
    public function edit($id){
        $brand_model=D('Brand');
        if(IS_POST){
            if ($brand_model->create()!==false) {
               $res=$brand_model->where(['id'=>$id])->save();
                if ($res!==false) {
                    $this->success('修改成功!',U('index'));
                }else{
                    $this->error($brand_model->getError(),U('edit',['id'=>$id]));
                }
            }else{
                echo 4;
                $this->error('修改失败!',U('edit',['id'=>$id]));
            }
        }else{
            $id=I('get.id');
            $row=$brand_model->find($id);
            $this->assign('act','编辑品牌');
            $this->assign('url',U('edit'));
            $this->assign('row',$row);
            $this->display('add');
        }
    }
    /**
     * 移除品牌
     */
    public function remove($id){
        $brand_model=D('Brand');
        $result=$brand_model->where(['id'=>$id])->setField(['status'=>'-1']);
        if($result!==false){
            $this->success('移除成功!',U('index'));
        }else{
            $this->error('移除失败!',U('index'));
        }
    }
}
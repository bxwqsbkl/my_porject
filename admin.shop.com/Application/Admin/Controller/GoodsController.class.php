<?php
/**
 * Created by PhpStorm.
 * User: Lin
 * Date: 2016/11/9 0009
 * Time: 9:02
 */

namespace Admin\Controller;
use Think\Controller;

class GoodsController extends Controller
{
    /**
     * 商品列表展示
     */
    public function index($p=1){
        $keywords=trim(I('get.goods_name'))?trim(I('get.goods_name')):'';
        $cond=[];
        if($keywords){
            $cond['g.name']=['like', '%' . $keywords . '%'];
        }
        $goods_model=D('Goods');
        $data=$goods_model->getList($cond);
        $this->assign($data);
        $this->display('index');
    }

    /**
     * 商品新增
     */
    public function add(){
        $goods_model=D('Goods');
        if(IS_POST){
            $goods_gallery_img=I('post.gallery_img');
            $goods_gallery_img=json_encode($goods_gallery_img);
            $content=I('post.content','',false);
            if ($goods_model->create()==false) {
                $this->error($goods_model->getError());
            }
            if ($goods_model->addData($content,$goods_gallery_img)==false) {
                $this->error($goods_model->getError());
            }
            else{
               $this->success('添加成功',U('index'));
            }
        }else{
            $result=$goods_model->getMsg();
            $gcs=json_encode($result['goods_cate']);
            $this->assign('gcs',$gcs);
            $this->assign($result);
            $this->assign('act','添加商品');
            $this->display('add');
        }
    }
    /**
     * 删除商品,逻辑删除
     */
    public function remove($id){
        $goods_model=D('Goods');
        $result=$goods_model->where(['id'=>$id])->setField(['status'=>0]);
        if($result!==false){
            $this->success('删除成功',U('index'));
        }else{
            $this->error($goods_model->getError(),U('index'));
        }
    }
    /**
     * 修改商品信息
     */
    public function edit($id){
        $goods_model=D('Goods');

        if(IS_POST){
//            dump($_POST);exit;
            $gallery_img=json_encode(I('post.gallery_img'));
            $content=I('post.content','',false);
            if($goods_model->create()!==false){
                if($goods_model->editSave($gallery_img,$content)==false) {
                    $this->error($goods_model->getError(), U('add'));
                }else{
                    $this->success('修改成功!',U('index'));
                }
            }else{
                $this->error('修改失败!',U('add'));
            }
        }else{
            $row=$goods_model->table('shop_goods as g')->join('shop_goods_gallery as gg on g.id=gg.goods_id ')->join('shop_goods_intro as intro on g.id=intro.goods_id')->where(['g.id'=>
                $id])->find();
            $row['id']=$id;
            switch($row['goods_status']){
                case 1:
                    //精品1,新品2,热销4
                    $row['goods_status']=[1];
                    break;
                case 2:
                    $row['goods_status']=[2];
                    break;
                case 3:
                    $row['goods_status']=[1,2];
                    break;
                case 4:
                    $row['goods_status']=[4];
                    break;
                case 5:
                    $row['goods_status']=[1,4];
                    break;
                case 6:
                    $row['goods_status']=[2,4];
                    break;
                case 7:
                    $row['goods_status']=[1,2,4];
                    break;
            }
            $row['goods_status']=json_encode($row['goods_status']);
            $result=$goods_model->getMsg();
            $gcs=json_encode($result['goods_cate']);
            $this->assign('gcs',$gcs);
            $this->assign('row',$row);
            $this->assign($result);
            $this->assign('act','修改商品');
            $this->display('add');
        }
    }

    public function recover(){
        $goods_model=D('Goods');
        $result=$goods_model->where(['status'=>0])->select();
        dump($result);
    }
}
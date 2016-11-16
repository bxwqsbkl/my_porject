<?php
/**
 * Created by PhpStorm.
 * User: Lin
 * Date: 2016/11/9 0009
 * Time: 9:04
 */

namespace Admin\Model;
use Think\Model;
use Think\Page;

class GoodsModel extends Model
{
    public function getList(array $cond = []){
        $cond=array_merge(['g.status'=>['neq',0]],$cond);
        $total=$this->table('shop_goods as g')->where($cond)->count();
        $page=new Page($total,C('PAGE.SIZE'));
        $page->setConfig('theme',C('PAGE.THEME'));
        $page_html=$page->show();
        $result=$this->table('shop_goods_category as gc')->join('shop_goods as g on gc.id=g.goods_category_id')->join('shop_brand as b on g.brand_id=b.id')->join('shop_supplier as s on g.supplier_id=s.id')->field('gc.name as gcname,g.*,b.name as bname,s.supplier_name as sname')->page(I('get.p'),C('PAGE.SIZE'))->where($cond)->order('sort')->select();
        foreach($result as $key=>$val){
            switch($val['goods_status']){
                case 1:
                    //精品1,新品2,热销4
                    $result[$key]['goodsstatus']='精品';
                    break;
                case 2:
                    $result[$key]['goodsstatus']='新品';
                    break;
                case 3:
                    $result[$key]['goodsstatus']='精品,新品';
                    break;
                case 4:
                    $result[$key]['goodsstatus']='热销';
                    break;
                case 5:
                    $result[$key]['goodsstatus']='精品,热销';
                    break;
                case 6:
                    $result[$key]['goodsstatus']='新品,热销';
                    break;
                case 7:
                    $result[$key]['goodsstatus']='精品,新品,热销';
                    break;
            }
        }
        $data=['rows'=>$result,'page_html'=>$page_html];
        return $data;
    }

    public function addData($content,$goods_gallery_img){
        /**
         * 接收并处理数据
         */
        $data=$this->data;
        $arr=range(1,9);
        shuffle($arr);
        $str='';
        for($i=0;$i<5;$i++){
            $str.=$arr[$i];
        }
        $sn='SN'.date('Ymd').$str;
        $data['sn']=$sn;
        $data['goods_status']=array_sum($data['goods_status']);
        $data['inputtime']=NOW_TIME;
        $this->startTrans();
        $id=$this->add($data);
        if($id==false){
            $this->rollback();
            return;
        }
        $goods_gallery=M('GoodsGallery');
        $goods_gallery_data=['goods_id'=>$id,'path'=>$goods_gallery_img];
        $res=$goods_gallery->add($goods_gallery_data);
        if($res==false){
            $this->rollback();
            return;
        }
        $goods_intro=M('GoodsIntro');
        $goods_intro_data=['goods_id'=>$id,'content'=>$content];
        $res=$goods_intro->add($goods_intro_data);
        if($res==false){
            $this->rollback();
            return;
        }
        $count=M('GoodsDayCount');
        $today=date('Y-m-d');
        $day_count=$count->where(['day'=>$today])->find();
        if(count($day_count)!==0){
            $ress=$count->where(['day'=>$today])->setInc('count');
            if($ress==false){
                $this->rollback();
                return;
            }
        }else{
            $day_count_data=['day'=>$today,'count'=>1];
            $ress=$count->where(['day'=>$today])->add($day_count_data);
            if($ress==false){
                $this->rollback();
                return;
            }
        }
        $this->commit();
        return true;

    }

    /**
     * 为添加数据做准备(查询所有商品分类和所有品牌)
     */
    public function getMsg(){
        $gc=$this->table('shop_goods_category')->select();
        $brand=$this->table('shop_brand')->field('id,name')->select();
        $supplier=$this->table('shop_supplier')->select();
        $data['suppliers']=$supplier;
        $data['goods_cate']=$gc;
        $data['brands']=$brand;
        return $data;
    }

    public function editSave($gallery_img,$content){
        $data=$this->data;
        $id=$data['id'];
//        dump($gallery_img);exit;
        $this->startTrans();
        $res=$this->where(['id'=>$id])->save($data);
        if($res===false){
            $this->rollback();
            return;
        }
        $goods_gallery=M('GoodsGallery');
        $res=$goods_gallery->where(['goods_id'=>$id])->setField(['path'=>$gallery_img]);
        if($res===false){
            $this->rollback();
            return;
        }
        $goods_intro=M('GoodsIntro');
        $res=$goods_intro->where(['goods_id'=>$id])->setField(['content'=>$content]);
        if($res===false){
            $this->rollback();
            return;
        }
        $this->commit();
        return true;
    }
}
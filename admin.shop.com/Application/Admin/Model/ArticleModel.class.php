<?php
/**
 * Created by PhpStorm.
 * User: Lin
 * Date: 2016/11/6 0006
 * Time: 13:08
 */

namespace Admin\Model;
use Think\Model;

class ArticleModel extends Model
{
    public function add($content){
        $this->startTrans();
        $data=$this->data;
        $data['inputtime']=NOW_TIME;
        $id=parent::add($data);
        if($id==false){
            $this->rollback();
            return false;
        }else{
            $data['article_id']=$id;
            $data['content']=$content;
            $content_model=M('ArticleContent');
            $res=$content_model->add($data);
            if($res==false){
                $this->rollback();
                return false;
            }else{
                $this->commit();
                return true;
            }
        }
    }

    public function save($content){
        $this->startTrans();
        $data=$this->data;
        $res=parent::save($data);
        if($res==false){
            $this->rollback();
            return false;
        }else{
            $article_id=$data['id'];
            $content_model=M('ArticleContent');
            $res=$content_model->where(['article_id'=>$article_id])->setField(['content'=>$content]);
            if($res==false){
                $this->rollback();
                return false;
            }else{
                $this->commit();
                return true;
            }
        }
    }
}
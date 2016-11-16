<?php
/**
 * Created by PhpStorm.
 * User: Lin
 * Date: 2016/11/6 0006
 * Time: 11:32
 */

namespace Admin\Controller;
use Think\Controller;

class ArticleCategoryController extends Controller
{
    /**
     * 分类列表
     */
    public function index(){
        $category=D('ArticleCategory');
        $rows=$category->where(['status'=>['neq',-1]])->order('sort')->select();
        $this->assign('rows',$rows);
        $this->display('index');
    }

    /**
     * 添加新分类
     */
    public function add(){
        if(IS_POST){
            $category=D('ArticleCategory');
            if($category->create()!==false){
                if ($category->add()!==false) {
                    $this->success('添加成功',U('index'));
                }else{
                    $this->error($category->getError(),U('add'));
                }
            }else{
                $this->error($category->getError(),U('add'));
            }
        }else{
            $this->assign('act','添加文章分类');
            $this->display('add');
        }
    }

    /**
     * 修改分类信息
     * @param $id
     */
    public function edit($id){
        $category=D('ArticleCategory');
        if(IS_POST){
            if($category->create()!==false){
                $res=$category->where(['id'=>$id])->save();
                if($res!==false){
                    $this->success('修改成功',U('index'));
                }else{
                    $this->error($category->getError(),U('edit'));
                }
            }else{
                $this->error('修改失败!',U('edit'));
            }
        }else{
            $id=I('get.id');
            $row=$category->find($id);
            $this->assign('act','修改文章分类');
            $this->assign('row',$row);
            $this->display('add');
        }
    }

    /**
     * 移除分类
     * @param $id
     */
    public function remove($id){
        $category=D('ArticleCategory');
        $id=I('get.id');
        $res=$category->where(['id'=>$id])->setField(['status'=>'-1']);
        if($res){
            $this->success('删除成功!',U('index'));
        }else{
            $this->error($category->getError(),U('index'));
        }
    }
}
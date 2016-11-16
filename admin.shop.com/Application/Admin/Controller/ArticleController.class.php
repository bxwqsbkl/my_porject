<?php
/**
 * Created by PhpStorm.
 * User: Lin
 * Date: 2016/11/6 0006
 * Time: 13:07
 */
namespace Admin\Controller;
use Think\Controller;
use Think\Page;

class ArticleController extends Controller
{
    public function index($p=1){
        $article=D('Article');
        $total=$article->where(['status'=>['neq',-1]])->count();
        $page=new Page($total,C('PAGE.SIZE'));
        $page->setConfig('theme',C('PAGE.THEME'));
        $page_html=$page->show();
        $rows=$article->table('shop_article as A')->join('shop_article_category as C on A.article_category_id=C.id')->field('a.*,C.name as cname')->page(I('get.p'),C('PAGE.SIZE'))->where(['A.status'=>['neq','-1']])->select();
        foreach($rows as $key=>$row){
            $rows[$key]['inputtime']=date('Y-m-d H:i:s',$row['inputtime']);
        }
        $this->assign('page_html',$page_html);
        $this->assign('rows',$rows);
        $this->display('index');
    }
    public function edit($id){
        if(IS_POST){
            $article=D('Article');
            $content=I('post.content','',false);
            if($article->create() !== false){
                if($article->save($content)){
                    $this->success('修改成功!',U('index'));
                }else{
                    $this->error('修改失败',U('add'));
                }
            }else{
                $this->error('修改失败',U('add'));
            }
        }else{
            $id=I('get.id');
            $category=D('ArticleCategory');
            $cates=$category->field('name,id')->select();
            $article=D('Article');
            $row=$article->table('shop_article as A')->join('shop_article_content as C on A.id=C.article_id')->field('a.*,C.content')->find($id);
            $this->assign('act','修改文章');
            $this->assign('row',$row);
            $this->assign('cates',$cates);
            $this->display('add');
        }
    }
    public function add(){
        if(IS_POST){
            $article=D('Article');
            $content=I('post.content');
            if($article->create() !== false){
                if($article->add($content)){
                    $this->success('添加成功!',U('index'));
                }else{
                    $this->error('添加失败',U('add'));
                }
            }else{
                $this->error('添加失败',U('add'));
            }
        }else{
            $category=D('ArticleCategory');
            $cates=$category->field('name,id')->select();
            $this->assign('cates',$cates);
            $this->assign('act','发表文章');
            $this->display('add');
        }
    }
    public function remove($id){
        $id=I('get.id');
        $article=D('Article');
        $res=$article->where(['id'=>$id])->setField(['status'=>-1]);
        if($res!==false){
            $this->success('移除成功!',U('index'));
        }else{
            $this->error($article->getError(),U('index'));
        }
    }
}
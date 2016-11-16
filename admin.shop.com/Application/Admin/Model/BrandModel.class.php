<?php
/**
 * Created by PhpStorm.
 * User: Lin
 * Date: 2016/11/5 0005
 * Time: 13:52
 */

namespace Admin\Model;
use Think\Crypt\Driver\Think;
use Think\Model;

class BrandModel extends Model
{
    protected $_validate=[
        array('name','require','品牌名不能为空'),
    ];
    public function getList(array $cond = []){
        $cond=array_merge(['status'=>['neq',-1]],$cond);
        $count=$this->where($cond)->count();
        $page=new \Think\Page($count,C('PAGE.SIZE'));
        $page->setConfig('theme', C('PAGE.THEME'));
        $page_msg=$page->show();
        $rows=$this->where($cond)->PAGE(I('get.p'),C('PAGE.SIZE'))->order('sort')->select();
        return $data=[
            'page_msg'=>$page_msg,
            'rows'=>$rows
        ];
    }
}
<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $this->display();
    }
    public function top(){
        $this->display('top');
    }
    public function menu(){
        $menus=D('Menu')->getVisableMenu();
        $this->assign('menus',$menus);
        $this->display('menu');
    }
    public function main(){
        $this->display('main');
    }

}
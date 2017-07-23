<?php
/**
 * 前台话题
 */
namespace Home\Controller;
use Think\Controller;

class TopController extends Controller{

    function __construct()
    {
        parent::__construct();
        protected $pagesize = 10;
    }


	/*活跃用户*/
	public function users()
	{
        $map = array();
        $count = M('User')->where($map)->count('id');
        $Page = new \Think\Page($count,$this->pagesize);
        $show = $Page->show();
        $orderby = array('experience'=>'desc','coin'=>'desc','answer'=>'desc');
        $items = M('User')->where($map)->order($orderby)->limit($Page->firstRow.','.$Page->listRows)->select();
        if($items) {
            foreach($items as $k=>$v) {
                $items[$k] = filter_fields('id,username,phone,email,avatar,experience,coin,status,watch,fans,question,answer,invite,adopt,article,last_login_time',$v);
                $items[$k]['tag'] = D('User')->hotTags($v['id']);
            }
        }
        $this->assign('page',$show);
        $this->assign('list',$items);
        $this->display();
	}


    /*财富榜*/
	public function coins()
    {
        $items = D('User')->top('coin',20);
        if($items) {
            foreach($items as $k=>$v) {
                $items[$k]['professor_status'] = M('Professor')->where(array('user_id'=>$v['id']))->getField('status');
            }
        }
        $this->assign('list',$items);
        $this->display();
    }


    /*热门作者*/
    public function articles()
    {
        $items = D('User')->top('article',20);
        if($items) {
            foreach($items as $k=>$v) {
                $items[$k]['professor_status'] = M('Professor')->where(array('user_id'=>$v['id']))->getField('status');
            }
        }
        $this->assign('list',$items);
        $this->display();
    }


    /*推荐专家*/
    public function experts()
    {
        $list = D('User')->tjUsers();
        $this->assign('list',$list);
        $this->display();
    }
}
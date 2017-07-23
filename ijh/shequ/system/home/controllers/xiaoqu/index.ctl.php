<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Xiaoqu_Index extends Ctl_Xiaoqu
{

    /**
     * 小区首页，商户列表只显示10条
     */
    public function index()
    {
        $filter = array('audit' => 1, 'closed' => 0);
        $squares = K::M('helper/round')->returnSquarePoint($this->xiaoqu['lng'], $this->xiaoqu['lat'], 5); //使用此函数计算得到结果
        $filter['lat'] = $squares['left-bottom']['lat'] . '~' . $squares['right-top']['lat'];
        $filter['lng'] = $squares['left-bottom']['lng'] . '~' . $squares['right-top']['lng'];

        $items = K::M('waimai/waimai')->items($filter, null, 1, 10, $count);
        foreach($items as $k => $val){
            $items[$k]['avg_score'] = ($val['score'] / $val['comments']) ? round($val['score'] / $val['comments'], 2) : 0;
        }
        //查询当前小区banner
        $banner = K::M('xiaoqu/banner')->items(array('xiaoqu_id' => $this->xiaoqu_id, 'audit' => 1), null, 1, 5);
        $this->pagedata['banner'] = $banner;
        //查询小区广告
        if($adv = K::M('adv/adv')->adv_by_name('小区首页格子广告')){
            if($adv_items = K::M('adv/item')->items_by_adv($adv['adv_id'])){
                $index = 0;
                foreach($adv_items as $k => $v){
                    $adv_list[] = $this->filter_fields('item_id,adv_id,title,thumb,link', $v);
                    if(++$index >= 2){
                        break;
                    }
                }
            }
        }
        //查询一条通知
        $notice = K::M('xiaoqu/news')->find(array('xiaoqu_id' => $this->xiaoqu_id, 'from' => 'notice', 'closed' => 0), array('dateline' => 'desc'));

        //检测此号是否有业主信息，没有的话，跳转到入驻页面
        if($is_yezhu = K::M('xiaoqu/yezhu')->items(array('uid' => $this->uid, 'audit' => 1, 'closed' => 0))){
            $this->pagedata['is_yezhu'] = 1;
        }
        else{
            $this->pagedata['is_yezhu'] = 0;
        }

        $this->pagedata['adv_items'] = $adv_items;
        $this->pagedata['notice'] = $notice;
        $this->pagedata['items'] = $items;
        $this->pagedata['index'] = 1;
        $this->tmpl = 'xiaoqu/index/index.html';
    }

    /**
     * 系统收录的小区列表以及搜索页面
     * @param type $from 跳转来源,选择地址后跳转回去
     */
    public function items($from)
    {
        if($from){
            $this->pagedata['from'] = $from;
        }
        $address = K::M('xiaoqu/xiaoqu')->items(array('city_id' => $this->city_id));
        $this->pagedata['address'] = $address;
        $this->tmpl = 'xiaoqu/xiaoqu/index.html';
    }

    /**
     * 搜索
     */
    public function search()
    {
        $keyword = $this->GP('keyword');
        $page = (int) $this->GP('page');
        $filter = array();
        $filter['title'] = "LIKE:%" . $keyword . "%";
        $limit = 10;
        $list = K::M('xiaoqu/xiaoqu')->items($filter, null, $page, $limit, $count);
        $this->pagedata['list'] = $list;
        $this->tmpl = 'xiaoqu/xiaoqu/search.html';
    }

    /**
     * 检测从搜索结果选择的小区ID，自己是否已入驻，如果没有入驻则跳转到入驻表单提交页面并选择，如果已入驻则返回小区首页并保存所选小区ID。
     */
    public function ajax_check_search_xiaoqu()
    {
        $xiaoqu_id = (int) $this->GP('xiaoquid');
        if(!$xiaoqu = K::M('xiaoqu/xiaoqu')->detail($xiaoqu_id)){
            $this->msgbox->add('小区不存在', 211);
        }
        else{
            $my = K::M('xiaoqu/yezhu')->items(array('uid' => $this->uid));
            $flag = 0;
            foreach($my as $k => $v){
                if($xiaoqu_id == $v['xiaoqu_id']){
                    $flag +=1;
                }
            }
            if($flag > 0){
                $this->msgbox->add('已入驻');
            }
            else{
                $this->msgbox->add('还未入驻', 212);
            }
        }
    }

    /**
     * 提交新小区
     */
    public function xiaoqu_create()
    {
        $this->check_login();
        $this->tmpl = 'xiaoqu/xiaoqu/create.html';
    }

    /**
     * 提交新小区表单
     */
    public function xiaoqu_create_handel()
    {
        $this->check_login();
        $data = $this->checksubmit('data');
        if(!$data['city_id']){
            $this->msgbox->add('城市没有选择', 211);
        }
        else if(!$data['title']){
            $this->msgbox->add('小区名称没有填写', 212);
        }
        else if(!$data['contact']){
            $this->msgbox->add('联系人没有填写', 213);
        }
        else if(!$data['mobile']){
            $this->msgbox->add('联系人电话没有填写', 213);
        }
        else{
            if(!$apply = K::M('xiaoqu/apply')->create($data)){
                $this->msgbox->add('提交失败', 300);
            }
            else{
                $this->msgbox->add('提交成功,请等待审核!');
            }
        }
    }

}

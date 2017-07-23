<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Mall extends Ctl
{

    public function index(){
        //幻灯片
        if($adv = K::M('adv/item')->items(array('adv_id'=>2,'audit'=>1,'closed'=>0),array('item_id'=>'asc'), $page,$limit,$count)) {
            foreach($adv as $k=>$v) {
                $advs[] = $this->filter_fields('adv_id,title,link,thumb', $v);
            }
        }else {
            $advs= array();
        }
        
        $cate = K::M('mall/cate')->items(null,array('cate_id'=>'desc'),1,7);
        $cate[] = array(
            'cate_id'=>0,
            'title'=>'更多',
            'icon'=>'photo/201607/jifenIco8.png',
            'orderby'=>0
        );
        $product = K::M('mall/product')->items(null,array('product_id'=>'desc'),1,10);
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('advs'=>array_values($advs),'cate'=>array_values($cate),'product'=>array_values($product)));
    }
    
    // 积分商城商品分类列表
    public function cate()
    {
        if(!$items = K::M('mall/cate')->fetch_all()) {
            $items = array();
        }
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('items'=>array_values($items)));
    }

    // 积分商城商品列表
    public function product($params)
    {
        $filter = $items = array();
        if($cate_id = (int)$params['cate_id']){
            $filter['cate_id'] = $cate_id;
        }
        $filter['closed'] = 0;        
        $page = max((int)$params['page'], 1);
        if($items = K::M('mall/product')->items($filter, null, $page, 10)){
            foreach($items as $k=>$v){
                $items[$k] = $this->filter_fields('product_id,cate_id,title,photo,jifen,views,sales,sku,info,price,freight', $v);
            }
        }else{
            $items = array();
        }
        $this->msgbox->set_data('data', array('items'=>array_values($items)));        
        $this->msgbox->add('success');
    }


    public function detail($params)
    {
        if(!$product_id = (int)$params['product_id']){
            $this->msgbox->add(L('商品不存在'),211);
        }else if(!$detail = K::M('mall/product')->detail($product_id)){
            $this->msgbox->add(L('商品不存在'),212);
        }else{
            //分享数组
            $cfg = $this->system->config->get('attach');
            $share = array(
                'share_url'=>$this->mklink('mall/product/detail', array($product_id), null, 'www'),
                'share_title'=> $detail['title'],
                'share_photo'=>$cfg['attachurl'].'/'. $detail['photo'],
                'share_content'=>$detail['title']
            );
            $this->msgbox->add('success');
            $this->msgbox->set_data('data', array('detail'=>$detail,'share'=>$share));
        }
    }
    
    

}

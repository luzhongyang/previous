<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Shop_Album extends Ctl_Biz
{

    public function items($params)
    {
        //0 全部 1环境 2商品
        $limit = 10;
		$limit = 500; //先改为一次返回取500个
        $page = max((int)$params['page'], 1);
        $filter = array('shop_id'=>$this->shop_id);
        if(in_array($params['type'], array(1, 2))){
            $filter['type'] = $params['type'];
        }      
        if(!$items = K::M('shop/albumphoto')->items($filter, array('photo_id'=>'DESC'), $page, $limit, $count)){
            $items = array();
        }
        $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_count'=>$count));
    }

    public function upload($params)
    {
        if(!in_array($params['type'], array(1, 2))){
            $this->msgbox->add('未制定相册类型', 211);
        }else{
            if($attachs = $_FILES){
                $pids = array();
                $data = array('shop_id'=>$this->shop_id, 'type'=>$params['type'], 'album_id'=>$params['type']);
                foreach($attachs as $attach){
                    if($attach['error'] == UPLOAD_ERR_OK){
                        if($a = K::M('magic/upload')->upload($attach, 'shop')){
                            $data['photo'] = $a['photo'];
                            if($pid = K::M('shop/albumphoto')->create($data)){
                                $pids[] = $pid;
                            }
                        }
                    }
                }
                $this->msgbox->set_data('data', array('photo_ids'=>$pids));
            }else{
                $this->msgbox->add('没有上传图片', 211);
            }
        }
    }

    public function delete($params)
    {
        if(!$ids = K::M('verify/check')->ids($params['photo_id'])){
            $this->msgbox->add('未指定要删除的图片', 211);
        }else if(!$items = K::M('shop/albumphoto')->items_by_ids($ids)){
            $this->msgbox->add('未指定要删除的图片', 212);
        }else{
            $del_ids = array();
            foreach($items as $k=>$v){
                if($v['shop_id'] == $this->shop_id){
                    $del_ids[$v['photo_id']] = $v['photo_id'];
                } 
            }
            if($del_ids){
                K::M('shop/albumphoto')->delete($del_ids);
            }
            K::M('system/logs')->log('biz.album.delete', array('photo_ids'=>$del_ids,'SQL'=>$this->system->db->SQLLOG()));
            $this->msgbox->add('success');
        }        
    }
}
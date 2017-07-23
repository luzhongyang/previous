<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Client_Xiaoqu_News extends Ctl
{

    public function items($params)
    {
        if(!$xiaoqu_id = (int)$params['xiaoqu_id']){
            $this->msgbox->add('参数不正确', 211);
        }else if(!$xiaoqu = K::M('xiaoqu/xiaoqu')->detail($xiaoqu_id)){
            $this->msgbox->add('小区不存在或已经删除', 214);
        }else{
            $limit = 10;
            $page = max((int)$params['page'], 1);
            if($items = K::M('xiaoqu/news')->items(array('xiaoqu_id'=>$xiaoqu_id,'closed'=>0), array('news_id'=>'DESC'), $page, $limit, $count)){
                foreach($items as $k=>$v){
                    $v['dateline_label'] = K::M('content/html')->text(K::M('helper/format')->time($v['dateline']));
                    $v['link'] = K::M('helper/link')->mklink('xiaoqu/news:detail', array($v['xiaoqu_id']), null, 'www');
                    $items[$k] = $v;
                }
            }
            $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_count'=>$count));
        }
    }
}

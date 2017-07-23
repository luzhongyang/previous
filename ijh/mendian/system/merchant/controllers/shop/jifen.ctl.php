<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Shop_Jifen extends Ctl
{
    protected $_allow_fields = 'log_id,card_id,order_id,type,number,intro,day,clientip,dateline';

    public function so()
    {
        $this->tmpl = 'merchant:shop/jifen/so.html';
    }

    public function index($card_id=0,$page=1)
    {
        if($card_id != (int)$card_id) {
            $this->msgbox->add('未指定要查看的内容ID',210);
        }else if(!$detail = K::M('card/card')->find(array('shop_id'=>$this->shop_id, 'card_id'=>$card_id))){
            $this->msgbox->add('要查看的内容不存在或已经删除', 211);
        }else{
            $filter = $pager = array();
            $pager['page'] = $page = max((int)$page, 1);
            $pager['limit'] = $limit = 10;
            if($SO = $this->GP('SO')){
                $pager['SO'] = $SO;
                if($SO['number']){$filter['number'] = $SO['number'];}
                if($SO['intro']){$filter['intro'] = "LIKE:%".$SO['intro']."%";}
                if(is_array($SO['dateline'])){if($SO['dateline'][0] && $SO['dateline'][1]){$a = strtotime($SO['dateline'][0]); $b = strtotime($SO['dateline'][1])+86400;$filter['dateline'] = $a."~".$b;}}
            }
            $filter['card_id'] = $detail['card_id'];
            $filter['type'] = 'jifen';
            if($items = K::M('card/log')->items($filter, array('log_id'=>'DESC'), $page, $limit, $count)){
                foreach ($items as $k => $v) {
                    $v = $this->filter_fields($this->_allow_fields, $v);
                    $items[$k] = $v;
                }
                $pager['count'] = $count;
                $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array($card_id,'{page}')), array('SO'=>$SO));
            }
            $this->pagedata['detail'] = $detail;
            $this->pagedata['items'] = $items;
            $this->pagedata['pager'] = $pager;
            $this->tmpl = 'merchant:shop/jifen/index.html';
        }
    }

}
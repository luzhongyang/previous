<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
Import::C('cashier');
class Ctl_Cashier_Product extends Ctl_Cashier
{

     public function so()
    {
        $this->pagedata['cates'] = K::M('cashier/product/cate')->items(array('shop_id'=>$this->shop_id));
        $this->pagedata['cates'] = K::M('cashier/product')->items(array('shop_id'=>$this->shop_id));
        $this->tmpl = 'merchant:cashier/product/so.html';
    }

    public function index($page=1)
    {
        $filter = $pager = array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['cate_id']){$filter['cate_id'] = $SO['cate_id'];}
            if($SO['product_id']){$filter['product_id'] = $SO['product_id'];}
            if($SO['title']){$filter['title'] = "LIKE:%".$SO['title']."%";}
            if(is_array($SO['dateline'])){if($SO['dateline'][0] && $SO['dateline'][1]){$a = strtotime($SO['dateline'][0]); $b = strtotime($SO['dateline'][1])+86400;$filter['dateline'] = $a."~".$b;}}
        }
        $filter['shop_id'] = $this->shop_id;
        $filter['closed'] = 0;
        if($items = K::M('cashier/product')->items($filter, array('product_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $this->pagedata['cates'] = K::M('cashier/product/cate')->items(array('shop_id'=>$this->shop_id));
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'merchant:cashier/product/index.html';
    }
    public function create()
    {
        if($data = $this->checksubmit('data')){
            $data['dateline'] =time(); 
            $data['shop_id'] = $this->shop_id;
            if($product_id = K::M('cashier/product')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward',  $this->mklink('merchant/cashier/product:index'));
            }
        }else{
            $this->pagedata['cates'] = K::M('cashier/product/cate')->items(array('shop_id'=>$this->shop_id));
            $this->pagedata['shop_id'] = $this->shop_id;
           	$this->tmpl = 'merchant:cashier/product/create.html';
        }   
    }

    public function edit($product_id=null)
    {
        if(!($product_id = (int)$product_id) && !($product_id = $this->GP('product_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('cashier/product')->detail($product_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作', 213);
        }else if($data = $this->checksubmit('data')){
            $data['dateline'] =time();  
            if(K::M('cashier/product')->update($product_id, $data)){
                $this->msgbox->add('修改内容成功');
                $this->msgbox->set_data('forward',  $this->mklink('merchant/cashier/product/edit',array('args'=>$product_id)));
            }  
        }else{
            $this->pagedata['detail'] = $detail;
           $this->pagedata['cates'] = K::M('cashier/product/cate')->items(array('shop_id'=>$this->shop_id));
            $this->tmpl = 'merchant:cashier/product/edit.html';
        }       
    }
    public function delete($product_id=null)
    {
        if($product_id = (int)$product_id){
            if(!$detail = K::M('cashier/product')->detail($product_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else if($detail['shop_id'] != $this->shop_id){
                $this->msgbox->add('非法操作', 213);
            }else{
                if(K::M('cashier/product')->update($product_id,array('closed'=>1,'dateline'=>time()))){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else{
            if($product_ids = $this->GP('product_ids')){
                foreach ($product_ids as $k => $v) {
                   K::M('cashier/product')->update($v,array('closed'=>1,'dateline'=>time()));
                }
                $this->msgbox->add('删除成功');
            }else{
                $this->msgbox->add('未指定要删除的内容ID', 401);
            }
            
        }
    }

}
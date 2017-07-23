<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Cashier_Payee extends Ctl
{
    
   public function alipay($shop_id)
   {
       if($shop = K::M('cashier/cashier')->detail($shop_id)){
           if(!$payee_alipay = K::M('alipay/alipay')->detail($shop_id)){
               $this->tmpl = 'cashier/payee/openalipay.html';
           }else{
               $this->pagedata['payee_alipay'] = $payee_alipay;
               $this->tmpl = 'cashier/payee/alipay.html';
           }
       }else{
           $this->msgbox->add('收银商户不存在', 211);
       }
   }

   public function wxpay($shop_id)
   {
       if($shop = K::M('cashier/cashier')->detail($shop_id)){
           $this->pagedata['payee_wxpay'] = K::M('weixin/wxpay')->detail($shop_id);
           $this->tmpl = 'cashier/payee/wxpay.html';
       }else{
           $this->msgbox->add('收银商户不存在', 211);
       }

   }
}
<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Wuye_Bill_Index extends Ctl_Wuye
{

    /**
     * 缴费单列表
     */
    public function index($page,$yezhu_id)
    {
        $this->check_wuye_bind_xiaoqu();
        $filter = $pager = array();
        $pager['page'] = $page = max((int) $page, 1);
        $pager['limit'] = $limit = 10;
        $filter['xiaoqu_id'] = $this->xiaoqu_id;
        $filter['closed'] = 0;
        //如果有业主ID，则筛选出该业主的帐单
        if((int)$yezhu_id){
           $filter['yezhu_id'] = $yezhu_id; 
        }
        $bill_ids = $uids = $yezhu_ids = array();
        $count = K::M('xiaoqu/bill')->count($filter);
        if($items = K::M('xiaoqu/bill')->items($filter, array('bill_id' => 'desc'), $page, $limit, $count)){
            foreach($items as $k => $v){
                $bill_ids[$v['bill_id']] = $v['bill_id'];
                $uids[$v['uid']] = $v['uid'];
                $yezhu_ids[$v['yezhu_id']] = $v['yezhu_id'];
            }
            if($members = K::M('member/member')->items_by_ids($uids)){
                foreach($items as $k => $v){
                    if($members[$v['uid']]){
                        $items[$k]['face'] = $members[$v['uid']]['face'];
                        $items[$k]['nickname'] = $members[$v['uid']]['nickname'];
                    }
                }
            }
            if($yezhus = K::M('xiaoqu/yezhu')->items_by_ids($yezhu_ids)){
                foreach($items as $k => $v){
                    if($yezhus[$v['yezhu_id']]){
                        $items[$k]['yezhu_contact'] = $yezhus[$v['yezhu_id']]['contact'];
                    }
                }
            }
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'wuye/bill/index.html';
    }

    /*     * 下载模板xls
     * 
     */

    public function download()
    {
        $download = './attachs/xls/wuye_example_bill.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="wuye_example_bill.xls"');
        header('Cache-Control: max-age=0');
        $size = readfile($download);
        echo $size;
        exit();
    }

    /**
     * 导入
     */
    public function import($bill_id)
    {
        $this->check_wuye_bind_xiaoqu();
        if($_FILES){

            if($attachs = $_FILES['xls']){
                if(UPLOAD_ERR_OK == $attachs['error']){
                    if($a = K::M('magic/upload')->file($attachs)){
                        $inputFileName = $a['file'];
                    }
                }
            } 

                require "./system/libs/phpexcel/PHPExcel/IOFactory.php";

                $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
                $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                /*
                 * foreach 处理 $sheetData
                 * excel,我只设置了 业主编号, 根据业主编号获取用户id, 
                 */
                header("Content-type: text/html; charset=utf-8");
                //$sheetData 为EXCEL最终导入的数据转化的数组
                unset($sheetData[1]);
                $success = $error = $repeat = 0;
                foreach($sheetData as $k => $v){
                    //首先查找该单是否已存在数据库中
 
                    if(!K::M('xiaoqu/bill')->find(array('yezhu_id'=>$v['B'],'bill_sn'=>$v['C']))){
                        //如果没有找到则插入数据库
                        $xls_yezhu = K::M('xiaoqu/yezhu')->detail($v['B']);

                        $data = array(
                            'xiaoqu_id'=>$this->xiaoqu_id,
                            'yezhu_id'=>$v['B'],
                            'uid'=>$xls_yezhu['uid'],
                            'bill_sn'=>$v['C'],
                            'total_price'=>$v['D'],
                            'wuye_price'=>$v['E'],
                            'chewei_price'=>$v['F'],
                            'shui_price'=>$v['G'],
                            'dian_price'=>$v['H'],
                            'ranqi_price'=>$v['I'],
                            'pay_status'=>$v['J']
                        );
                        //总价,等于其他价总和
                        $data['total_price'] = $data['wuye_price'] + $data['chewei_price'] +$data['shui_price'] + $data['dian_price']+ $data['ranqi_price'];
                        if(K::M('xiaoqu/bill')->create($data)){
                            $success +=1;
                        }else{
                            $error +=1;
                        }
                    }else{
                        $repeat += 1;
                    }
                }
                $this->msgbox->add('成功导入'.$success.'条'.'失败'.$error.'条'.$repeat.'条已存在');
        //excel end
        }else{
            $this->tmpl = 'wuye/bill/import.html';
        }

    }

   /**
    * 创建单个业主缴费单
    */
    
    public function create($yezhu_id){
        $this->check_wuye_bind_xiaoqu();
        if(!$detail = K::M('xiaoqu/yezhu')->detail($yezhu_id)){
            $this->msgbox->add('业主不存在!')->response();
        }else{
            $detail['member'] = K::M('member/member')->detail($detail['uid']);
            $this->pagedata['detail'] = $detail;
            if($data = $this->checksubmit('data')){
                $data['total_price'] = $data['wuye_price'] + $data['chewei_price'] + $data['shui_price'] + $data['dian_price'] + $data['ranqi_price'];
                if($bill_id = K::M('xiaoqu/bill')->create($data)){
                    $this->msgbox->add('添加成功');
                    $this->msgbox->set_data('forward',  $this->mklink('wuye/bill/index:index'));
                } 
            }else{
               //计算出上个月的时间,作为帐单默认值
                $date = strtotime(date('Y-m'));
                $first_date = $date-1;
                $bill_sn = date('Y-m',$first_date);
                $this->pagedata['bill_sn'] = $bill_sn;
                $this->tmpl = 'wuye/bill/create.html';
            }
        }
        
    }
    
    /**
     * 编辑缴费单
     */
    public function edit($bill_id){
        $this->check_wuye_bind_xiaoqu();
        if(!$detail = K::M('xiaoqu/bill')->detail($bill_id)){
            $this->msgbox->add('不存在的缴费单',211);
        }else if($detail['pay_status'] == 1){
            $this->msgbox->add('该缴费单不可修改',212);
        }else if($data = $this->checksubmit('data')){
            $data['total_price'] = $data['wuye_price'] + $data['chewei_price'] + $data['shui_price'] + $data['dian_price'] + $data['ranqi_price'];
            if(K::M('xiaoqu/bill')->update($bill_id, $data)){
                $this->msgbox->add('修改内容成功');
            }
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'wuye/bill/edit.html';
        }
    }
    
    
    /**
     * 删除缴费单
     */
    public function delete($bill_id){
        $this->check_wuye_bind_xiaoqu();
        if(!$detail = K::M('xiaoqu/bill')->detail($bill_id)){
            $this->msgbox->add('不存在的缴费单',211);
        }else if($detail['pay_status'] == 1){
            $this->msgbox->add('该缴费单不可删除',212);
        }else{
            if(K::M('xiaoqu/bill')->delete($bill_id)){
                $this->msgbox->add('删除成功');
            }
        }
    }
}

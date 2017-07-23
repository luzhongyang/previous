<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.baocms.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class GoodsshopformatAction extends CommonAction {

    private $create_fields = array( 'name', 'content', 'shop_id');

    public function index() {
        $this->check_weidian();
        $formats = D('Format')->where(array('shop_id' => $this->shop_id))->select();
        $this->assign('formats',$formats);
        $this->display();
    }
    
    private function check_weidian(){
        
        $wd = D('WeidianDetails');
        $wd_res = $wd->where('shop_id ='.($this->shop_id)) -> find();
        if(!$wd_res){
            $this->error('请先完善微店资料！',U('goods/weidian'));
        }elseif($wd_res['audit'] == 0){
            $this->error('您的微店正在审核中，请耐心等待！',U('index/index'));
        }elseif($wd_res['audit'] == 2){
            $this->error('您的微店未通过审核！',U('index/index'));
        }
        
    }
    public function create() {
        if ($this->isPost()) {
            $obj = D('Format');
            $data = $_POST['data'];
            if(!$name = $data['name']){
                $this->baoError('未指定规定名称');
            }
            if($format_id = $obj->add(array('shop_id'=>$this->shop_id, 'name'=>$name))){
                $values = array();
                foreach($data['contents'] as $v){
                    if($v){
                        $values[] = $v;
                        D('FormatValue')->add(array('format_id'=>$format_id, 'name'=>$v));
                    }
                }
                $obj->update_contents($format_id);
                $this->baoSuccess('添加成功', U('goodsshopformat/index'));           
            }else{
                $this->baoError('操作失败！');
            }
        } else {
            $this->display();
        }
    }

    public function edit($id=0) {
        if ($id = (int) $id) {
            if (!$detail = D('Format')->find($id)) {
                $this->baoError('请选择要编辑的规格分组');
            }else if($detail['shop_id'] != $this->shop_id){
                $this->baoError('不可以修改别人的内容');
            }
            $format_values = array();
            if($values = D('FormatValue')->where(array('format_id'=>$id))->select()){
                foreach($values as $v){
                    $format_values[$v['id']] = $v;
                }
            }

            
            if ($this->isPost()) {
                $data = $_POST['data'];
           /// print_r($format_values);
           // print_r($data['values']);echo 'File:',__FILE__,',Line:',__LINE__;exit;

                if(($name = $data['name']) && ($detail['name'] != $name)){
                    D('Format')->save(array('id'=>$id, 'name'=>$name));
                }
                $contents = array();
                foreach($data['values'] as $k=>$v){
                    if($format_values[$k]){
                        if($format_values[$k]['name'] != $v){                            
                            D('FormatValue')->save(array('id'=>$k, 'name'=>$v));
                        }
                    }
                }
                foreach($data['new'] as $v){
                    if($v){
                        D('FormatValue')->add(array('format_id'=>$id, 'shop_id'=>$this->shop_id, 'name'=>$v));
                    }
                }
                D('Format')->update_contents($id);
                
                $this->baoSuccess('更新规格属性成功', U('goodsshopformat/index'));  
            } else {
                $this->assign('format_values', $format_values);
                $this->assign('detail', $detail);
                $this->display();
            }
        } else {
            $this->baoError('请选择要编辑的商家配置');
        }
    }

    public function delete($id=0){
        if (is_numeric($id) && ($id = (int) $id)) {
            $obj = D('Format');
            if (!$detail = $obj->find($id)) {
                $this->baoError('该配置信息不存在');
            }
            if($detail['shop_id'] != $this->shop_id){
                $this->baoError('不能操作其他人的内容');
            }
            
            $obj->delete($id);
            $this->success('删除成功！', U('goodsshopformat/index'));
        }
    }
    
    public function delvalue($id=0)
    {
        if (is_numeric($id) && ($id = (int) $id)) {
            $obj = D('FormatValue');
            if (!$detail = $obj->find($id)) {
                $this->baoError('删除的内容不存在');
            }else if(!$format = D('Format')->find($detail['format_id'])){
                $this->baoError('删除的内容不存在');
            }else if($format['shop_id'] != $this->shop_id){
                $this->baoError('不能操作其他人的内容');
            } 
            if($obj->delete($id)){
                D('Format')->update_contents($detail['format_id']);
            } 
            $this->baoSuccess('删除属性成功！', U('goodsshopformat/edit', array('id'=>$detail['format_id'])));
        }        
    }
    

}

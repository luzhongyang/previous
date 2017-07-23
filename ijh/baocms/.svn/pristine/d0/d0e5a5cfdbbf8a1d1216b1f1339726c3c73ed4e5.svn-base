<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.baocms.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class CrowdAction extends CommonAction
{

    public function _initialize()
    {
        parent::_initialize();
        $this->autocates = D('Goodsshopcate')->where(array('shop_id' => $this->shop_id))->select();
        $this->assign('autocates', $this->autocates);
    }

    public function index()
    {
        $Goods = D('Goods');
        $Crowd = D('Goodscrowd');
        import('ORG.Util.Page'); // 导入分页类    
        $map = array('closed' => 0, 'shop_id' => $this->shop_id, 'type' => 'crowd', 'ltime' => array('GT', time()));
        if($keyword = $this->_param('keyword', 'htmlspecialchars')){
            $map['title'] = array('LIKE', '%' . $keyword . '%');
            $this->assign('keyword', $keyword);
        }
        $count = $Goods->where($map)->count(); // 查询满足要求的总记录数 
        $Page = new Page($count, 25); // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show(); // 分页显示输出
        $list = $Goods->where($map)->order(array('audit'=>'asc' ,'goods_id' => 'desc'))->limit($Page->firstRow . ',' . $Page->listRows)->select();
        foreach($list as $k => $val){
            $goods_ids[] = $val['goods_id'];
            $val = $Goods->_format($val);
            $list[$k] = $val;
        }
        if($goods_ids){
            $f['goods_id'] = array('IN', implode(',', $goods_ids));
            $Crowd_list = $Crowd->where($f)->select();
            foreach($Crowd_list as $k => $v){
                if ($v['ltime'] <= time() && $v['have_price'] < $v['all_price']) {// 失败
                    $v['status'] = 2;
                }elseif($v['ltime'] > time() && $v['have_price'] < $v['all_price']){ // 众筹中
                    $v['status'] = 0;
                }else{
                    $v['status'] = 1;// 成功
                }
                $Crowd_lists[$v['goods_id']] = $v;
            }
            $this->assign('crowd', $Crowd_lists);
        }
        $this->assign('list', $list); // 赋值数据集
        $this->assign('page', $show); // 赋值分页输出
        $this->display(); // 输出模板
    }

    public function history()
    {
        $Goods = D('Goods');
        $Crowd = D('Goodscrowd');
        import('ORG.Util.Page'); // 导入分页类
        $map = array('closed' => 0, 'shop_id' => $this->shop_id, 'type' => 'crowd', 'ltime' => array('LT', time()));
        $count = $Goods->where($map)->count(); // 查询满足要求的总记录数 
        $Page = new Page($count, 25); // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show(); // 分页显示输出
        $list = $Goods->where($map)->order(array('goods_id' => 'desc'))->limit($Page->firstRow . ',' . $Page->listRows)->select();
        foreach($list as $k => $val){
            $goods_ids[] = $val['goods_id'];
            $val = $Goods->_format($val);
            $list[$k] = $val;
        }
        if($goods_ids){
            $f['goods_id'] = array('IN', implode(',', $goods_ids));
            $Crowd_list = $Crowd->where($f)->select();
            foreach($Crowd_list as $k => $v){
                if ($v['ltime'] <= time() && $v['have_price'] < $v['all_price']) {// 失败
                    $v['status'] = 2;
                }elseif($v['ltime'] > time() && $v['have_price'] < $v['all_price']){ // 众筹中
                    $v['status'] = 0;
                }else{
                    $v['status'] = 1;// 成功
                }
                $Crowd_lists[$v['goods_id']] = $v;
            }
            $this->assign('crowd', $Crowd_lists);
        }
        $this->assign('list', $list); // 赋值数据集
        $this->assign('page', $show); // 赋值分页输出
        $this->display(); // 输出模板
    }

    public function create()
    {
        if($this->isPost()){
            $data = $this->createCheck();
            $details = $this->_post('details', 'SecurityEditorHtml');
            if(empty($details)){
                $this->baoError('众筹详情不能为空');
            }
            if($words = D('Sensitive')->checkWords($details)){
                $this->baoError('详细内容含有敏感词：' . $words);
            }
            $instructions = $this->_post('instructions', 'SecurityEditorHtml');
            if(empty($instructions)){
                $this->baoError('购买须知不能为空');
            }
            if($words = D('Sensitive')->checkWords($instructions)){
                $this->baoError('购买须知含有敏感词：' . $words);
            }
            $thumb = $this->_param('thumb', false);
            foreach($thumb as $k => $val){
                if(empty($val)){
                    unset($thumb[$k]);
                }
                if(!isImage($val)){
                    unset($thumb[$k]);
                }
            }
            $data['thumb'] = serialize($thumb);
            $Goods = D('Goods');
            $data['type'] = 'crowd';
            $data['shop_id'] = $this->shop_id;
            $data['city_id'] = $this->shop['city_id'];
            $data['area_id'] = $this->shop['area_id'];

            if($goods_id = $Goods->add($data)){
                D('Goodscrowd')->add(array('goods_id' => $goods_id, 'details' => $details, 'instructions' => $instructions, 'title' => $data['title'], 'all_price' => $data['price'], 'img' => $data['photo'], 'ltime' => $data['ltime'], 'dateline' => time()));
                $this->baoSuccess('添加成功', U('crowd/index'));
            }
            $this->baoError('操作失败！');
        }
        else{
            $this->display();
        }
    }

    public function edit($goods_id = 0)
    {
        if($goods_id = (int) $goods_id){

            $obj = D('Goods');
            $Crowd = D('Goodscrowd');
            if(!$detail = $obj->where(array('goods_id'=>$goods_id, 'closed'=>0))->find()){
                $this->baoError('您要修改的内容不存在或已被删除');
            }
            if ($detail['audit'] == 1) {
                $this->error('该众筹已审核，无法编辑');
            }
            if($detail['type'] != 'crowd'){
                $this->baoError('该众筹不存在');
            }
            if($detail['shop_id'] != $this->shop_id){
                $this->baoError('请不要操作别人的众筹');
            }
            if($detail['closed'] != 0){
                $this->baoError('该众筹已被删除');
            }

            $Crowd_list = $Crowd->find($goods_id);
            if($this->isPost()){
                $data = $this->editCheck();
                $details = $this->_post('details', 'SecurityEditorHtml');
                if(empty($details)){
                    $this->baoError('众筹详情不能为空');
                }
                if($words = D('Sensitive')->checkWords($details)){
                    $this->baoError('详细内容含有敏感词：' . $words);
                }
                $instructions = $this->_post('instructions', 'SecurityEditorHtml');
                if(empty($instructions)){
                    $this->baoError('购买须知不能为空');
                }
                if($words = D('Sensitive')->checkWords($instructions)){
                    $this->baoError('购买须知含有敏感词：' . $words);
                }

                if(false !== $obj->where(array('goods_id' => $goods_id))->save($data)){
                    $Crowd->where(array('goods_id' => $goods_id))->save(array('details' => $details, 'instructions' => $instructions, 'title' => $data['title'], 'all_price' => $data['price'], 'img' => $data['photo'], 'ltime' => $data['ltime']));
                    $this->baoSuccess('操作成功', U('crowd/index'));
                }

                $this->baoError('操作失败');
            }
            else{
                $this->assign('detail', $detail);
                $this->assign('crowd', $Crowd_list);
                $this->assign('shop', D('Shop')->find($detail['shop_id']));
                $this->display();
            }
        }
        else{
            $this->baoError('请选择要编辑的众筹');
        }
    }

    public function setting($goods_id = 0)
    {
        if($goods_id = (int) $goods_id){
            $Goods = D('Goods');
            $Goodstype = D('Goodstype');
            $Crowd = D('Goodscrowd');
            $detail = D('Goods')->find($goods_id);
            $this->assign('detail', $detail);
            $this->assign('meals', $Goodstype->where(array('goods_id' => $goods_id))->select());
            $this->display();
        }
        else{
            $this->baoError('请选择要查看的众筹ID');
        }
    }

    public function type_create($goods_id)
    {
        if($goods_id = (int) $goods_id){
            $Goods = D('Goods');
            $Goodstype = D('Goodstype');
            $Crowd = D('Goodscrowd');

            if(!$detail = D('Goods')->find($goods_id)){
                $this->baoError('请选择要设置的众筹');
            }
            if($detail['audit'] == 1){
                $this->error('该众筹已审核，无法创建');
            }
            if($detail['type'] != 'crowd'){
                $this->baoError('该众筹不存在');
            }
            if($detail['shop_id'] != $this->shop_id){
                $this->baoError('请不要操作别人的众筹');
            }
            if($detail['closed'] != 0){
                $this->baoError('该众筹已被删除');
            }
            $Crowd_list = $Crowd->find($goods_id);


            if($data = $this->_post('data', false)){
                if(!empty($data['price']) && !empty($data['content']) && !empty($data['fahuo'])){
                    $data['max_num'] = (int) $data['max_num'];
                    $data['price'] = (int) ($data['price'] * 100);
                    $data['yunfei'] = (int) ($data['yunfei'] * 100);
                    if ($data['max_num'] < 0) {
                        $this->baoError('限购内容不能是负数');
                    }elseif ($data['price'] <= 0) {
                        $this->baoError('金额不能小于等于0');
                    }elseif ($data['yunfei'] < 0) {
                        $this->baoError('运费不能是负数');
                    }
                    $Goodstype->add(array(
                        'goods_id'  => $goods_id,
                        'price'     => $data['price'],
                        'content'   => $data['content'],
                        'max_num'   => $data['max_num'],
                        'yunfei'    => $data['yunfei'],
                        'fahuo'     => $data['fahuo'],
                        'choujiang' => $data['choujiang'],
                        'img'       => $data['img'],
                        'dateline'  => time(),
                    ));
                    $this->baoSuccess('操作成功', U('crowd/setting', array('goods_id' => $detail['goods_id'])));
                }
                else{
                    $this->baoError('内容不能为空');
                }
            }
            else{
                $this->assign('detail', $detail);
                $this->display();
            }
        }
        else{
            $this->baoError('请选择要设置的众筹');
        }
    }

    public function type_edit($type_id)
    {
        if($type_id = (int) $type_id){
            $Goods = D('Goods');
            $Goodstype = D('Goodstype');
            $Crowd = D('Goodscrowd');
            if(!$type = $Goodstype->find($type_id)){
                $this->baoError('修改的内容不存在');
            }
            $goods_id = $type['goods_id'];
            if(!$detail = D('Goods')->find($goods_id)){
                $this->baoError('请选择要编辑的众筹');
            }
            if($detail['audit'] == 1){
                $this->error('该众筹已审核，无法编辑');
            }
            if($detail['type'] != 'crowd'){
                $this->baoError('该众筹不存在');
            }
            if($detail['shop_id'] != $this->shop_id){
                $this->baoError('请不要操作别人的众筹');
            }
            if($detail['closed'] != 0){
                $this->baoError('该众筹已被删除');
            }
            $Crowd_list = $Crowd->find($goods_id);



            if($data = $this->_post('data', false)){
                if(!empty($data['price']) && !empty($data['content']) && !empty($data['fahuo'])){
                    $data['max_num'] = (int) $data['max_num'];
                    $data['price'] = (int) ($data['price'] * 100);
                    $data['yunfei'] = (int) ($data['yunfei'] * 100);
                    if ($data['max_num'] < 0) {
                        $this->baoError('限购内容不能是负数');
                    }elseif ($data['price'] <= 0) {
                        $this->baoError('金额不能小于等于0');
                    }elseif ($data['yunfei'] < 0) {
                        $this->baoError('运费不能是负数');
                    }
                    $data = array(
                        'goods_id'  => $goods_id,
                        'price'     => $data['price'],
                        'content'   => $data['content'],
                        'max_num'   => $data['max_num'],
                        'yunfei'    => $data['yunfei'],
                        'fahuo'     => $data['fahuo'],
                        'choujiang' => $data['choujiang'],
                        'img'       => $data['img'],
                    );

                    if(false !== $Goodstype->where(array('type_id' => $type_id))->save($data)){
                        $this->baoSuccess('操作成功', U('crowd/setting', array('goods_id' => $detail['goods_id'])));
                    }
                }
                else{
                    $this->baoError('内容不能为空');
                }
            }
            else{
                $this->assign('type', $type);
                $this->assign('detail', $detail);
                $this->display();
            }
        }
        else{
            $this->baoError('修改的内容不存在');
        }
    }

    public function type_delete($type_id=0)
    {
        if(!$type_id = (int) $type_id){
            $this->baoError('未指定要删除的内容ID');
        }elseif((!$detail = D('Goodstype')->find($type_id)) || (!$goods = D('Goods')->where(array('goods_id'=>$detail['goods_id'], 'type'=>'crowd', 'shop_id'=>$this->shop_id, 'closed'=>0))->find())){
            $this->baoError('删除的内容不存在');
        }elseif($goods['audit'] == 1){// 已审核
            $this->baoError('该众筹已审核，无法删除');
        }else{
            if(D('Goodstype')->where(array('type_id' => $type_id))->delete()){
                $this->baoSuccess('操作成功', U('crowd/setting', array('goods_id' => $detail['goods_id'])));
            }
        }
    }

    public function project($goods_id)
    {
        if($goods_id = (int) $goods_id){
            $Goods = D('Goods');
            $Goodsproject = D('Goodsproject');
            $Crowd = D('Goodscrowd');
            $detail = D('Goods')->find($goods_id);
            $this->assign('detail', $detail);
            $this->assign('meals', $Goodsproject->where(array('goods_id' => $goods_id))->select());
            $this->display();
        }
        else{
            $this->baoError('请选择要设置的众筹');
        }
    }

    public function project_create($goods_id)
    {
        if($goods_id = (int) $goods_id){
            $Goods = D('Goods');
            $Goodsproject = D('Goodsproject');
            $Crowd = D('Goodscrowd');

            if(!$detail = D('Goods')->find($goods_id)){
                $this->baoError('请选择要设置的众筹');
            }
            if($detail['type'] != 'crowd'){
                $this->baoError('该众筹不存在');
            }
            if($detail['shop_id'] != $this->shop_id){
                $this->baoError('请不要操作别人的众筹');
            }
            if($detail['closed'] != 0){
                $this->baoError('该众筹已被删除');
            }
            $Crowd_list = $Crowd->find($goods_id);


            if($data = $this->_post('data', false)){
                if(!empty($data['content'])){
                    $Goodsproject->add(array(
                        'goods_id' => $goods_id,
                        'content'  => $data['content'],
                        'dateline' => time(),
                    ));
                    $this->baoSuccess('操作成功', U('crowd/project', array('goods_id' => $detail['goods_id'])));
                }
                else{
                    $this->baoError('内容不能为空');
                }
            }
            else{
                $this->assign('detail', $detail);
                $this->display();
            }
        }
        else{
            $this->baoError('请选择要设置的众筹');
        }
    }

    public function project_delete($project_id)
    {
        if($project_id = (int) $project_id){
            $Goods = D('Goods');
            $Goodsproject = D('Goodsproject');
            $Crowd = D('Goodscrowd');
            if(!$type = $Goodsproject->find($project_id)){
                $this->baoError('删除的内容不存在');
            }
            $goods_id = $type['goods_id'];
            if(!$detail = D('Goods')->find($goods_id)){
                $this->baoError('请选择要设置的众筹');
            }
            if($detail['type'] != 'crowd'){
                $this->baoError('该众筹不存在');
            }
            if($detail['shop_id'] != $this->shop_id){
                $this->baoError('请不要操作别人的众筹');
            }
            if($detail['closed'] != 0){
                $this->baoError('该众筹已被删除');
            }
            $Crowd_list = $Crowd->find($goods_id);

            if(false !== $Goodsproject->where(array('project_id' => $project_id))->delete()){
                $this->baoSuccess('操作成功', U('crowd/project', array('goods_id' => $detail['goods_id'])));
            }
        }
        else{
            $this->baoError('删除的内容不存在');
        }
    }

    public function ask($goods_id)
    {
        if($goods_id = (int) $goods_id){
            $Goods = D('Goods');
            $Goodsask = D('Goodsask');
            $Crowd = D('Goodscrowd');
            $detail = D('Goods')->find($goods_id);
            $this->assign('detail', $detail);
            $ask = $Goodsask->where(array('goods_id' => $goods_id))->select();
            $this->assign('meals', $ask);

            foreach($ask as $k => $v){
                $user_ids[$v['uid']] = $v['uid'];
            }
            if(!empty($user_ids)){
                $this->assign('users', D('Users')->itemsByIds($user_ids));
            }
            $this->display();
        }
        else{
            $this->baoError('请选择众筹');
        }
    }

    public function ask_answer($ask_id)
    {
        if($ask_id = (int) $ask_id){
            $Goods = D('Goods');
            $Goodsask = D('Goodsask');
            $Crowd = D('Goodscrowd');
            if(!$ask = $Goodsask->find($ask_id)){
                $this->baoError('该问题不存在');
            }
            if(!$detail = D('Goods')->find($ask['goods_id'])){
                $this->baoError('请选择要设置的众筹');
            }
            if($detail['type'] != 'crowd'){
                $this->baoError('该众筹不存在');
            }
            if($detail['shop_id'] != $this->shop_id){
                $this->baoError('请不要操作别人的众筹');
            }
            if($detail['closed'] != 0){
                $this->baoError('该众筹已被删除');
            }
            $Crowd_list = $Crowd->find($goods_id);


            if($data = $this->_post('data', false)){
                if(!empty($data['answer_c'])){
                    $Goodsask->where(array('ask_id' => $ask_id))->save(array(
                        'answer_c'    => $data['answer_c'],
                        'answer_time' => time(),
                    ));
                    $this->baoSuccess('操作成功', U('crowd/ask', array('goods_id' => $ask['goods_id'])));
                }
                else{
                    $this->baoError('内容不能为空');
                }
            }
            else{
                $this->assign('detail', $detail);
                $this->assign('ask', $ask);
                $this->display();
            }
        }
        else{
            $this->baoError('请选择要设置的众筹');
        }
    }

    public function follow($goods_id)
    {
        if($goods_id = (int) $goods_id){
            $Goods = D('Goods');
            $Goodsfollow = D('Goodsfollow');
            $Crowd = D('Goodscrowd');
            $detail = D('Goods')->find($goods_id);
            $this->assign('detail', $detail);
            $follow = $Goodsfollow->where(array('goods_id' => $goods_id))->select();
            $this->assign('meals', $follow);

            foreach($follow as $k => $v){
                $user_ids[$v['uid']] = $v['uid'];
            }
            if(!empty($user_ids)){
                $this->assign('users', D('Users')->itemsByIds($user_ids));
            }
            $this->display();
        }
        else{
            $this->baoError('请选择众筹');
        }
    }

    /*public function lists($goods_id)
    {
        if($goods_id = (int) $goods_id){
            $Goods = D('Goods');
            $Goodslist = D('Goodslist');
            $Crowd = D('Goodscrowd');
            $detail = D('Goods')->find($goods_id);
            $this->assign('detail', $detail);
            $list = $Goodslist->where(array('goods_id' => $goods_id))->select();
            $this->assign('meals', $list);

            foreach($list as $k => $v){
                $user_ids[$v['uid']] = $v['uid'];
                $type_ids[$v['type_id']] = $v['type_id'];
            }
            if(!empty($type_ids)){
                $this->assign('type', D('Goodstype')->itemsByIds($type_ids));
            }
            if(!empty($user_ids)){
                $this->assign('users', D('Users')->itemsByIds($user_ids));
            }
            $this->display();
        }
        else{
            $this->baoError('请选择众筹');
        }
    }*/

    public function lists($type_id=0)
    {
        if(!$type_id = (int) $type_id){
            $this->baoError('未选择要查看的内容ID');
        }elseif ((!$detail = D('Goodstype')->find($type_id)) || (!$goods = D('Goods')->where(array('closed'=>0, 'goods_id'=>$detail['goods_id']))->find())) {
            $this->baoError('您要查看的内容不存在或已被删除');
        }else{
            import('ORG.Util.Page'); // 导入分页类
            $count = D('Goodslist')->where(array('type_id'=>$type_id))->count(); // 查询满足要求的总记录数 
            $Page = new Page($count, 10); // 实例化分页类 传入总记录数和每页显示的记录数
            $show = $Page->show(); // 分页显示输出
            if ($list = D('Goodslist')->where(array('type_id'=>$type_id))->order(array('list_id' => 'desc'))->limit($Page->firstRow . ',' . $Page->listRows)->select()) {
                $user_ids = array();
                foreach ($list as $k => $v) {
                    $user_ids[$v['uid']] = $v['uid'];
                }
                if (!empty($user_ids)) {
                    $this->assign('users', D('Users')->itemsByIds($user_ids));
                }
                $this->assign('detail', $detail);
                $this->assign('list', $list);
                $this->assign('page', $show); // 赋值分页输出
            }
            $this->assign('goods', $goods);
            $this->display();
        }
    }

    public function zhong($list_id=0)
    {
        if (!$list_id = (int) $list_id) {
            $this->baoError('未选择要设置的内容ID');
        }elseif ((!$detail = D('Goodslist')->where(array('list_id' => $list_id))->find()) || (!$goodstype = D('Goodstype')->find($detail['type_id']))) {
            $this->baoError('您要设置的内容不存在或已被删除');
        }elseif ($goodstype['choujiang'] != 1) {
            $this->baoError('非抽奖类不可以中奖操作');
        }else{
            $data['is_zhong'] = '1';
            if(D('Goodslist')->where(array('list_id' => $list_id))->save($data)){
                $this->baoMsg('设为中奖成功', U('crowd/lists', array('goods_id' => $detail['goods_id'])));
            }
        }
    }

    public function order()
    {
        $Goodsorder = D('Tuanorder');
        import('ORG.Util.Page'); // 导入分页类
        $map = array('shop_id' => $this->shop_id);
        if(($bg_date = $this->_param('bg_date', 'htmlspecialchars') ) && ($end_date = $this->_param('end_date', 'htmlspecialchars'))){
            $bg_time = strtotime($bg_date);
            $end_time = strtotime($end_date);
            $map['create_time'] = array(array('ELT', $end_time), array('EGT', $bg_time));
            $this->assign('bg_date', $bg_date);
            $this->assign('end_date', $end_date);
        }
        else{
            if($bg_date = $this->_param('bg_date', 'htmlspecialchars')){
                $bg_time = strtotime($bg_date);
                $this->assign('bg_date', $bg_date);
                $map['create_time'] = array('EGT', $bg_time);
            }
            if($end_date = $this->_param('end_date', 'htmlspecialchars')){
                $end_time = strtotime($end_date);
                $this->assign('end_date', $end_date);
                $map['create_time'] = array('ELT', $end_time);
            }
        }

        if($keyword = $this->_param('keyword', 'htmlspecialchars')){
            $map['order_id'] = array('LIKE', '%' . $keyword . '%');
            $this->assign('keyword', $keyword);
        }

        if(isset($_GET['st']) || isset($_POST['st'])){
            $st = (int) $this->_param('st');
            if($st != 999){
                $map['status'] = $st;
            }
            $this->assign('st', $st);
        }
        else{
            $this->assign('st', 999);
        }
        $count = $Goodsorder->where($map)->count(); // 查询满足要求的总记录数 
        $Page = new Page($count, 25); // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show(); // 分页显示输出
        $list = $Goodsorder->where($map)->order(array('order_id' => 'desc'))->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $shop_ids = $user_ids = $goods_ids = array();
        foreach($list as $k => $val){
            if(!empty($val['shop_id'])){
                $shop_ids[$val['shop_id']] = $val['shop_id'];
            }
            $user_ids[$val['user_id']] = $val['user_id'];
            $goods_ids[$val['goods_id']] = $val['goods_id'];
        }
        $this->assign('users', D('Users')->itemsByIds($user_ids));
        $this->assign('shops', D('Shop')->itemsByIds($shop_ids));
        $this->assign('tuan', D('Tuan')->itemsByIds($goods_ids));
        $this->assign('list', $list); // 赋值数据集
        $this->assign('page', $show); // 赋值分页输出
        $this->display(); // 输出模板
    }

    public function used()
    {
        if($this->isPost()){
            $code = $this->_post('code', false);
            if(empty($code)){
                $this->baoError('请输入众筹券！');
            }

            $obj = D('Tuancode');
            $shopmoney = D('Shopmoney');
            $return = array();
            $ip = get_client_ip();
            if(count($code) > 10){
                $this->baoError('一次最多验证10条众筹券！');
            }
            $userobj = D('Users');
            foreach($code as $key => $var){
                $var = trim(htmlspecialchars($var));

                if(!empty($var)){
                    $data = $obj->find(array('where' => array('code' => $var)));

                    if(!empty($data) && $data['shop_id'] == $this->shop_id && (int) $data['is_used'] == 0 && (int) $data['status'] == 0){
                        if($obj->save(array('code_id' => $data['code_id'], 'is_used' => 1))){ //这次更新保证了更新的结果集              
                            //增加MONEY 的过程 稍后补充
                            if(!empty($data['price'])){
                                $data['intro'] = '众筹消费' . $data['order_id'];

                                $data['settlement_price'] = D('Quanming')->quanming($data['user_id'], $data['settlement_price'], 'tuan'); //扣去全民营销

                                $shopmoney->add(array(
                                    'shop_id'     => $data['shop_id'],
                                    'money'       => $data['settlement_price'],
                                    'create_ip'   => $ip,
                                    'create_time' => NOW_TIME,
                                    'order_id'    => $data['order_id'],
                                    'intro'       => $data['intro'],
                                ));
                                $shop = D('Shop')->find($data['shop_id']);
                                D('Users')->addMoney($shop['user_id'], $data['settlement_price'], $data['intro']);
                                $return[$var] = $var;
                                D('Users')->gouwu($data['user_id'], $data['price'], '众筹券消费成功');
                                $obj->save(array('code_id' => array('used_time' => NOW_TIME, 'used_ip' => $ip))); //拆分2次更新是保障并发情况下安全问题
                                echo '<script>parent.used(' . $key . ',"√验证成功",1);</script>';
                            }
                            else{
                                echo '<script>parent.used(' . $key . ',"√到店付众筹券验证成功，需要现金付款",2);</script>';
                            }
                        }
                    }
                    else{
                        echo '<script>parent.used(' . $key . ',"X该众筹券无效",3);</script>';
                    }
                }
            }
        }
        else{
            $this->display();
        }
    }

    private function createCheck()
    {
        $data = $this->_post('data', false);
        $data['title'] = trim(htmlspecialchars($data['title']));
        if(empty($data['title'])){
            $this->baoError('众筹名称不能为空');
        }
        $data['photo'] = trim(htmlspecialchars($data['photo']));
        if(empty($data['photo'])){
            $this->baoError('请上传图片');
        }
        if(!isImage($data['photo'])){
            $this->baoError('图片格式不正确');
        } $data['price'] = (int) ($data['price'] * 100);
        if(empty($data['price']) || $data['price'] < 0){
            $this->baoError('众筹金额不能小于等于0');
        }
        $data['ltime'] = strtotime($data['ltime'])+86399;
        if ($data['ltime'] <= NOW_TIME) {
            $this->baoError('众筹过期时间不能小于等于当前时间');
        }
        $data['create_time'] = NOW_TIME;
        $data['create_ip'] = get_client_ip();
        return $data;
    }

    private function editCheck()
    {
        $data = $this->_post('data', false);
        $data['title'] = trim(htmlspecialchars($data['title']));
        if(empty($data['title'])){
            $this->baoError('众筹名称不能为空');
        }
        $data['photo'] = trim(htmlspecialchars($data['photo']));
        if(empty($data['photo'])){
            $this->baoError('请上传图片');
        }
        if(!isImage($data['photo'])){
            $this->baoError('图片格式不正确');
        } $data['price'] = (int) ($data['price'] * 100);
        if(empty($data['price']) || $data['price'] < 0){
            $this->baoError('众筹金额不能小于等于0');
        }
        $data['ltime'] = strtotime($data['ltime'])+86399;
        if ($data['ltime'] <= NOW_TIME) {
            $this->baoError('众筹过期时间不能小于等于当前时间');
        }
        $data['create_time'] = NOW_TIME;
        $data['create_ip'] = get_client_ip();
        return $data;
    }
    
    
    public function detail($goods_id){ //展示详情及参与记录
        if(!$goods_id = (int) $goods_id){
            $this->baoError('没有选择众筹项目！');
        }
        if(!$goods_crowd = D('Goodscrowd')->find($goods_id)){
            $this->baoError('众筹项目不存在！');
        }
        if(!$goods = D('Goods')->find($goods_id)){
            $this->baoError('众筹项目不存在！');
        }
        if($goods['shop_id'] != $this->shop_id){
            $this->baoError('非法操作！');
        }

        if ($goods_crowd['ltime'] <= time() && $goods_crowd['have_price'] < $goods_crowd['all_price']) {// 失败
            $goods_crowd['status'] = 2;
        }elseif($goods_crowd['ltime'] > time() && $goods_crowd['have_price'] < $goods_crowd['all_price']){ // 众筹中
            $goods_crowd['status'] = 0;
        }else{
            $goods_crowd['status'] = 1;// 成功
        }
        $goods_crowd['audit'] = $goods['audit'];
        //参与记录
        $g = D('Goodslist');
        import('ORG.Util.Page');// 导入分页类
        $where = array(
            'goods_id'=>$goods_id,
            'pay_status'=>1
        );
        $count      = $g->where($where)->count();// 查询满足要求的总记录数
        $Page       = new Page($count,25);// 实例化分页类 传入总记录数和每页显示的记录数
        $show       = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $list = $g->where($where)->order('list_id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        $uids = $type_ids = $order_ids = $payment_list = array();
        foreach($list as $k => $v){
            $uids[$v['uid']] = $v['uid'];
            $type_ids[$v['type_id']] = $v['type_id'];
            $order_ids[] = $v['list_id'];
        }
        $users = D('Users')->itemsByIds($uids);
        $types = D('Goodstype')->itemsByIds($type_ids);
        foreach($list as $k => $v){
            $list[$k]['user'] = $users[$v['uid']];
            $list[$k]['type'] = $types[$v['type_id']];
        }
        if (!empty($order_ids)) {
            $map['order_id'] = array('IN',implode(',',$order_ids));
            $map['type'] = 'crowd';
            $map['pay_status'] = 1;
            if ($payment_logs = D('Paymentlogs')->where($map)->select()) {
                foreach ($payment_logs as $k => $v) {
                    $payment_list[$v['order_id']] = $v;
                }
            }
        }
        $typelist = D('Goodstype')->where(array('goods_id'=>$goods_id))->select();
        $this->assign('typelist',$typelist);// 赋值数据集
        $this->assign('goods_crowd',$goods_crowd);
        $this->assign('list',$list);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出
        $this->assign('payment_list',$payment_list);// 赋值分页输出
        $this->display();
    }
    
    /*public function set_status($goods_id,$status){ //设置众筹项目状态
        if(!$goods_id = (int) $goods_id){
            $this->baoError('没有选择众筹项目！');
        }
        if(!$goods_crowd = D('GoodsCrowd')->find($goods_id)){
            $this->baoError('众筹项目不存在！');
        }
        if(!$goods = D('Goods')->find($goods_id)){
            $this->baoError('众筹项目不存在！');
        }
        if($goods['shop_id'] != $this->shop_id){
            $this->baoError('非法操作！');
        }
        if(!in_array($status,array(1,2))){
            $this->baoError('状态错误！');
        }
        if($goods_crowd['status'] !=0){
            $this->baoError('非进行中的状态不可以设置！');
        }
        if(!D('GoodsCrowd')->where('goods_id ='.$goods_id)->save(array('status'=>$status))){
            $this->baoError('设置失败！');
        }else{
            $this->baoSuccess('设置成功！');
        }
    }*/
    
    /**
     * 设置众筹参与记录的状态
     * $params 1、设置为中奖  2、发货  3、退款
     */
    public function set_goodslist($list_id=0, $params=0){
        if (!($params = (int) $params) && ($params != 1 || $params != 2 || $params != 3)) {
            $this->baoError('参数错误！');
        }elseif (!$list_id = (int) $list_id) {
            $this->baoError('未选择要操作的内容ID');
        }elseif (!$detail = D('Goodslist')->find($list_id)) {
            $this->baoError('众筹项目不存在或已被删除');
        }elseif ($detail['pay_status'] != 1) {
            $this->baoError('没有支付的记录不可操作！');
        }elseif ($detail['order_status'] != 0) {// 非待发货状态
            $this->baoError('订单当前状态不可进行操作！');
        }elseif (!$goods = D('Goods')->where(array('goods_id'=>$detail['goods_id'], 'closed'=>0))->find()) {
            $this->baoError('众筹项目不存在或已被删除');
        }elseif ($goods['shop_id'] != $this->shop_id) {
            $this->baoError('不可越权操作！');
        }elseif (!$goodscrowd = D('Goodscrowd')->find($detail['goods_id'])) {
            $this->baoError('众筹项目不存在或已被删除');
        }elseif (!$goodstype = D('Goodstype')->find($detail['type_id'])) {
            $this->baoError('众筹项目不存在或已被删除');
        }elseif ($goodscrowd['ltime'] > time() && $goodscrowd['have_price'] < $goodscrowd['all_price']) {// 众筹中(没过期，钱没达标)
            $this->baoError('众筹中，不能提前操作');
        }else{
            if ($goodscrowd['ltime'] <= time() && $goodscrowd['have_price'] < $goodscrowd['all_price']) {// 众筹失败(过期，钱没达标) , 退款
                if ($params != 3) {
                    $this->baoError('众筹已失败，不可操作！');
                }else{
                    if($goodstype['choujiang'] == 1){
                        $this->baoError('抽奖类不可以进行退款操作！');
                    }
                    //设置状态为退款
                    if (D('Goodslist')->where(array('list_id'=>$list_id))->save(array('order_status'=>-1))) {// 先更新，避免并发
                        //把钱退还给用户
                        D('Users')->where(array('uid'=>$detail['uid']))->setInc('money',$detail['total_price']);
                        D('Usermoneylogs')->add(array(
                            'user_id' => $detail['uid'],
                            'money' => $detail['total_price'],
                            'create_time' => time(),
                            'create_ip' => get_client_ip(),
                            'intro' => '众筹项目失败(ID:'.$detail['list_id'].')，退款金额'.$detail['total_price'].'元',
                        ));
                    }
                }
            }else{// 众筹成功(没过期，钱达标)  发货||设置中奖
                if ($params == 1) {
                    if($goodstype['choujiang'] == 0){
                        $this->baoError('非抽奖类不可以中奖操作！');
                    }else{
                        D('Goodslist')->where(array('list_id'=>$list_id))->save(array('is_zhong'=>1));
                    }
                }elseif ($params == 2) {
                    D('Goodslist')->where(array('list_id'=>$list_id))->save(array('order_status'=>1));
                }else{
                    $this->baoError('众筹已成功，不可操作！');
                }
            }
        }
        $this->baoSuccess('操作成功！',U('crowd/detail', array('goods_id' => $detail['goods_id'])));
    }

    /**
     * 一键发货
     */
    public function batch_delivery($goods_id=0){
        if (!$goods_id = (int) $goods_id) {
            $this->baoError('未选择要操作的内容ID');
        }elseif (!$goods = D('Goods')->where(array('goods_id'=>$goods_id, 'closed'=>0))->find()) {
            $this->baoError('您要操作的内容不存在或已被删除');
        }elseif ($goods['shop_id'] != $this->shop_id) {
            $this->baoError('不可越权操作！');
        }elseif (!$goodscrowd = D('Goodscrowd')->find($goods_id)) {
            $this->baoError('您要操作的内容不存在或已被删除');
        }elseif ($goodscrowd['ltime'] <= time() && $goodscrowd['have_price'] < $goodscrowd['all_price']) {// 众筹失败(过期，钱没达标)
            $this->baoError('众筹已失败，非法操作！');
        }elseif ($goodscrowd['ltime'] > time() && $goodscrowd['have_price'] < $goodscrowd['all_price']) {// 众筹中，不能提前发货(没过期，钱没达标)
            $this->baoError('众筹中不能提前发货');
        }elseif (!$list = D('Goodslist')->where(array('goods_id'=>$goods_id, 'pay_status'=>1, 'order_status'=>0))->select()) {
            $this->baoError('没有要发货的众筹订单');
        }else{
            // TO DO 
            $ids = array();
            foreach ($list as $k => $v) {
                $ids[] = $v['list_id'];
            }
            if (!empty($ids)) {
                $where = "list_id in (".implode(',', $ids).")";
                D('Goodslist')->where($where)->setField('order_status', 1);
            }
            $this->baoSuccess('批量发货成功！',U('crowd/detail', array('goods_id' => $goods_id)));
        }
    }

    /**
     * 失败众筹
     */
    public function fail(){
        $Goods = D('Goods');
        $Crowd = D('Goodscrowd');
        import('ORG.Util.Page'); // 导入分页类
        $filter = array('closed' => 0, 'shop_id' => $this->shop_id, 'type' => 'crowd', 'ltime' => array('ELT', time()));
        $goods_ids = $goods_list = $crowd_list = array();
        if ($list = D('Goods')->where($filter)->select()) {
            foreach($list as $k => $v){
                $goods_ids[] = $v['goods_id'];
                $v = $Goods->_format($v);
                $goods_list[$v['goods_id']] = $v;
            }
            if (!empty($goods_ids) && !empty($goods_list)) {
                $map['goods_id'] = array('IN', implode(',', $goods_ids));
                $map['_string'] = 'have_price < all_price';
                $count = D('Goodscrowd')->where($map)->count(); // 查询满足要求的总记录数 
                $Page = new Page($count, 25); // 实例化分页类 传入总记录数和每页显示的记录数
                $show = $Page->show(); // 分页显示输出
                if ($crowd_list = D('Goodscrowd')->where($map)->order(array('goods_id' => 'desc'))->limit($Page->firstRow . ',' . $Page->listRows)->select()) {
                    foreach ($crowd_list as $k => $v) {
                        $crowd_list[$k]['goods_list'] = $goods_list[$v['goods_id']];
                    }
                }
            }
        }
        $this->assign('list', $crowd_list); // 赋值数据集
        $this->assign('page', $show); // 赋值分页输出
        $this->display(); // 输出模板
    }

}

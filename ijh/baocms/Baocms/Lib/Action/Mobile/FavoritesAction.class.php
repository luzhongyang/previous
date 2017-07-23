<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.baocms.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class FavoritesAction extends CommonAction {

    public function index() {
        if(empty($this->uid)){
            AppJump();
        }
        $like = I('like', '', 'trim,htmlspecialchars');
        $this->assign('like', $like);
        $this->mobile_title = '我的关注';
        $this->display();
    }

    public function favoritesloading() {
        $like = I('like', '', 'trim,htmlspecialchars');
        $Shopfavorites = D('Shopfavorites');
        import('ORG.Util.Page');
        $map = array('user_id' => $this->uid);

        $count = $Shopfavorites->where($map)->count();
        $Page = new Page($count, 25);
        $show = $Page->show();
        $var = C('VAR_PAGE') ? C('VAR_PAGE') : 'p';
        $p = $_GET[$var];
        if ($Page->totalPages < $p) {
            die('0');
        }

        $list = $Shopfavorites->where($map)->order('last_news_id desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $shop_ids = array();
        $last_news_ids= $read_ids = array();
        foreach ($list as $k => $val) {
            $shop_ids[$val['shop_id']] = $val['shop_id'];
            if(!empty($val['last_news_id'])){
                $last_news_ids[$val['last_news_id']] = $val['last_news_id'];
                $read_ids[$val['read_id']] = $val['read_id'];
            }
        }
        $shops = array();
        if(!empty($shop_ids)){
            if ($like) {
                $shops = D('Shop')->where(array('shop_id'=>array('IN',$shop_ids),'shop_name'=>array('like','%'.$like.'%')))->select();
            } else {
                $shops = D('Shop')->itemsByIds($shop_ids);
            }
        }
        
        if(!empty($last_news_ids)){
            $news = D('Shopnews')->itemsByIds($last_news_ids);
            $newsdata = array();
            foreach($news as $val){
                $newsdata[$val['shop_id']] = $val;
            }
            $this->assign('news',$newsdata);
        }
        $this->assign('read_ids',$read_ids);
        $this->assign('shops', $shops);
        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->display();
    }
    
    public function listsloading(){
        
        $like = I('like', '', 'trim,htmlspecialchars');
        $shopObj = D('Shop');
        import('ORG.Util.Page');
        $map = array('audit'=>1,'closed'=>0);
        if($like){
            $map['shop_name|tags'] = array('like','%'.$like.'%');
            $this->assign('like',$like);
        }else{
            $map['city_id'] = $this->city_id;//搜索的时候 不限制城市
        }
        
        
        $count = $shopObj->where($map)->count();
        $Page = new Page($count, 25);
        $show = $Page->show();
        $var = C('VAR_PAGE') ? C('VAR_PAGE') : 'p';
        $p = $_GET[$var];
        if ($Page->totalPages < $p) {
            die('0');
        }
        $lat = addslashes(cookie('lat'));
        $lng = addslashes(cookie('lng'));
        if (empty($lat) || empty($lng)) {
            $lat = $this->city['lat'];
            $lng = $this->city['lng'];
        }
        $list = $shopObj->where($map)->order('orderby asc,fans_num desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
       // print_r($shopObj->getLastSql());die;
        $shop_ids = array();
        foreach ($list as $k => $val) {
            $shop_ids[$val['shop_id']] = $val['shop_id'];
            $list[$k]['d'] = getDistance($lat, $lng, $val['lat'], $val['lng']);
        }
        $datas = D('Shopfavorites')->where(array('user_id'=>$this->uid,'shop_id'=>array('IN',$shop_ids)))->select();
        $guanzhu = array();
        foreach($datas as $val){
            $guanzhu[$val['shop_id']] = $val;
        }
        $this->assign('guanzhu',$guanzhu);
        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->display();
    }
    
    public function add(){
        if(empty($this->uid)){
            AppJump();
        }
        $shop_id = (int) $this->_get('shop_id');
        if (!$detail = D('Shop')->find($shop_id)) {
            $this->error('没有该商家');
        }
        if ($detail['closed']) {
            $this->error('该商家已经被删除');
        }
        if (D('Shopfavorites')->check($shop_id, $this->uid)) {
            $this->error('您已经关注过该商家了！');
        }
        $data = array(
            'shop_id' => $shop_id,
            'user_id' => $this->uid,
            'create_time' => NOW_TIME,
            'create_ip' => get_client_ip()
        );
        if (D('Shopfavorites')->add($data)) {
            D('Shop')->updateCount($shop_id,'fans_num');
            $this->success('恭喜您关注成功！',U('favorites/index'));
        }
        $this->error('关注失败！');
        
    }

    public function cancle(){
        if(empty($this->uid)){
            AppJump();
        }
        $shop_id = (int) $this->_get('shop_id');
        if (!$detail = D('Shop')->find($shop_id)) {
            $this->error('没有该商家');
        }
        if ($detail['closed']) {
            $this->error('该商家已经被删除');
        }
        if (!$favor = D('Shopfavorites')->where(array('shop_id'=>$shop_id,'user_id'=>$this->uid))->find()) {
            $this->error('参数错误！');
        }
        // $data = array(
        //     'shop_id' => $shop_id,
        //     'user_id' => $this->uid,
        //     'create_time' => NOW_TIME,
        //     'create_ip' => get_client_ip()
        // );
        if (D('Shopfavorites')->delete($favor['favorites_id'])) {
            $this->success('取消关注成功！',U('favorites/index'));
        }
        $this->error('取消关注失败！');
        
    }
    
    //搜索要关注的商家
    public function lists(){
        if(empty($this->uid)){
            AppJump();
        }
        $like = I('like', '', 'trim,htmlspecialchars,remove_xss');
        $this->assign('like', $like);
        $this->display();
    }
    
    //
    public function detail(){
        if(empty($this->uid)){
            AppJump();
        }
        $shop_id = (int)$this->_get('shop_id');
        if(!$detail = D('Shop')->find($shop_id)){
            $this->error('商家不存在');
        }
        if($detail['audit']!=1 || $detail['closed']!=0){
            $this->error('该商家不存在 ');
        }
        if(!$fans = D('Shopfavorites')->check($shop_id,$this->uid)){
            $this->error('您还未关注该商家');
        }
        if($detail['user_id']==$this->uid){
            $this->error('不能给自己发消息!');
        }
        $news = D('Shopnews')->where(array(
            'shop_id' => $shop_id,
            'audit' => 1,
            'news_id' => array(
                'EGT',$fans['read_id']
            )
        ))->order(array('news_id'=>'desc'))->limit(0,1)->select();
        $this->assign('news',$news);
        $this->assign('detail',$detail);
        $details = D('Shopdetails')->find($shop_id);
        $datas =  unserialize($details['menus']);
       // print_r($datas);
        $this->assign('weixin',  $datas);
        $this->mobile_title = $detail['shop_name'];
        $this->display();
    }
    
    public function reply(){
        $error = 0;
        if (empty($this->uid)) {
           $error+=1;
        }
        $shop_id = (int) $this->_param('shop_id');
        if(empty($shop_id)){
           $error+=1;
        }
        if(!$detail = D('Shop')->find($shop_id)){
           $error+=1;
        }
        if($detail['closed'] != 0||$detail['audit'] != 1){
            $error+=1;
        }
        $map = array('user_id'=>$this->uid,'from_id'=>$detail['user_id']);
        $map['is_read'] = 0;
        $list = D('Usermessage')->where($map)->select();
        if($error == 0 && !empty($list)){
            echo json_encode(array('status'=>'success','res'=>$list,'logo'=>$detail['logo']));
            D('Usermessage')->where(array('user_id'=>$this->uid,'from_id'=>$detail['user_id']))->save(array('is_read'=>1));
            die;
        }else{
            $this->ajaxReturn(array('status'=>'error'));
        }
    }

    

    //读文章
    public function read($news_id){
        if(!$detail = D('Shopnews')->find($new_id)){
            $this->error('您所查看的内容不存在');
        }
        if($detail['audit'] != 1){
            $this->error('您所查看的内容暂未通过审核');
        }
        if($this->uid){
            $fans = D('Shopfavorites')->check($detail['shop_id'],$this->uid);
            if($fans && $fans['read_id']< $new_id){
                $fans['read_id'] = $new_id;
                D('Shopfavorites')->save($fans);
            }
        }
        D('Shopnews')->updateCount($new_id,'views');
        $this->assign('shop',D('Shop')->find($detail['shop_id']));
        $this->assign('detail',$detail);
        $this->mobile_title = '文章详情';
        $this->display();
    }
    
    // 发送记录 关键字响应
    public function send(){
        if(empty($this->uid)){
            AppJump();
        }
        $shop_id = (int)$this->_get('shop_id');
        if(!$detail = D('Shop')->find($shop_id)){
            $this->error('商家不存在');
        }
        if($detail['audit']!=1 || $detail['closed']!=0){
            $this->error('该商家不存在 ');
        }
        if(!$fans = D('Shopfavorites')->check($shop_id,$this->uid)){
            $this->error('您还未关注该商家');
        }
        $word = htmlspecialchars($_POST['word']);
        $user_id = $detail['user_id'];
        if(!empty($user_id)){
            if($user_id == $this->uid){
                $this->error('不能给自己发消息');
            }
        }else{
            $this->error('商家还未设置管理员');
        }
        D('Usermessage')->add(array('from_id'=>$this->uid,'user_id'=>$user_id,'content'=>$word,'create_time'=>NOW_TIME,'create_ip'=>get_client_ip()));
        $keyword = D('Shopweixinkeyword')->checkKeyword($shop_id,$word);
        if($keyword){
             switch ($keyword['type']) {
                 case 'text':
                     $data = array(
                         'ret' => 1,
                         'type' => 'text',
                         'contents' => $keyword['contents'],
                         'face' => __ROOT__.'/attachs/' .$detail['logo'],
                     );
                     die(json_encode($data));
                     break;
                 case 'news':
                     $data = array(
                         'ret'   => 1,
                         'type'  => 'news',
                         'title' =>$keyword['title'],
                         'intro' => msubstr($keyword['contents'],0,60),
                         'photo' => __ROOT__.'/attachs/' .$keyword['photo'],
                         'url'   => $keyword['url'],
                         'face' => __ROOT__.'/attachs/' .$detail['logo'],
                     );
                     die(json_encode($data));
                     break;
             }
            
        }else{
            die(json_encode(array('ret'=>0)));
        }       
    }
    
    
    
}

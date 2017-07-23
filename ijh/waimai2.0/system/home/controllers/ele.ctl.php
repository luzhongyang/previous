<?php


set_time_limit(0);
ini_set('memory_limit','128M');
ini_set('allow_url_fopen', 'On');

class Ctl_Ele extends Ctl
{

    public function index($page)
    {
        $geohash = 'wtemh47qdek';
        $limit = '30';
        $page = intval($page);
        $offset = $page*$limit;
        //http://www.ele.me/restapi/v4/restaurants/549388/mutimenu
        $api = 'http://www.ele.me/restapi/v3/restaurants?geohash=%s&limit=%d&offset=%d&type=geohash';
        if($ret = file_get_contents(sprintf($api, $geohash, $limit, $offset))){
            if($data = json_decode($ret, true)){
                $count = 0;
                foreach($data as $v){
                    if(!$shop = K::M('shop/shop')->detail($v['id'])){
                        $a = array('shop_id'=>$v['id'], 'title'=>$v['name'], 'lat'=>$v['latitude'], 'lng'=>$v['longitude']);
                        $vp = explode(' ', $v['phone']);
                        $a['phone'] = $a['mobile'] = $vp[0];
                        $a['info'] = $v['description'];
                        $a['addr'] = $v['address'];
                        $a['freight'] = $v['delivery_fee'];
                        $a['is_new'] = $v['is_new'];
                        $a['online_pay'] = $v['is_online_payment'];
                        $a['is_new'] = $v['is_new'];
                        $a['min_amount'] = $v['minimum_order_amount'];
                        if($v['image_path']){
                            $a['logo'] = $this->download($v['image_path']);
                        }
                        $a['clientip'] = __IP;
                        $a['dateline'] = __TIME;
                        $a['passwd'] = md5('123456');
                        if(K::M('shop/shop')->create($a, true)){
                            $count ++;
                        }
                    }
                }
                echo "page:{$page}<br />\n";
                echo "add shop {$count}<br />\n";
                $page = $page + 1;
                echo "<script>setTimeout(function(){location.href='/ele/index-{$page}.html';}, 2000)</script>";

                exit;
            }echo 'FILE:',__FILE__,'LINE:',__LINE__;exit();
        }echo 'FILE:',__FILE__,'LINE:',__LINE__;exit();
    }

    public function food($page)
    {
        $page = max(intval($page), 1);
        $limit = 5;
        $api = 'http://www.ele.me/restapi/v4/restaurants/%s/mutimenu';
        if($items = K::M('shop/shop')->items(array('shop_id'=>'>:100'), array('shop_id'=>'ASC'), $page, $limit, $count)){
            $shop_count = $cate_count = $product_count = 0;
            foreach($items as $k=>$v){
                if($ret = file_get_contents(sprintf($api, $v['shop_id']))){
                    if($data = json_decode($ret, true)){
                        //print_r($data);echo 'FILE:',__FILE__,'LINE:',__LINE__;exit();
                        $shop_count ++;
                        foreach($data as $vv){
                            if($vv['id']){
                                $a = array('shop_id'=>$v['shop_id'], 'title'=>$vv['name'], 'cate_id'=>$vv['id']);
                                K::M('product/cate')->create($a, true);
                                $cate_count ++;
                                foreach($vv['foods'] as $vvv){
                                    $b = array('title'=>$vvv['name'], 'shop_id'=>$v['shop_id'], 'cate_id'=>$vv['id']);

                                    $b['sales'] = $vvv['month_sales'];
                                    $b['photo'] = $this->download($vvv['image_path']);
                                    $b['clientip'] = __IP;
                                    $b['dateline'] = __TIME;
                                    foreach($vvv['specfoods'] as $vvvv){
                                        $b['title'] = $vvvv['name'];
                                        $b['intro'] = $vvvv['name'];
                                        $b['product_id'] = $vvvv['food_id'];
                                        $b['price'] = $vvvv['price'];
                                        $b['package_price'] = $vvvv['package_price'];
                                        K::M('product/product')->create($b, true);
                                        $product_count ++;
                                    }
                                }
                            }
                        }
                    }
                }
            }
            echo "page:{$page}, shop:{$shop_count}, cate:{$cate_count}, product:{$product_count}<br />\n";
            $page ++;
            echo "<script>setTimeout(function(){location.href='/ele/food-{$page}.html';}, 2000)</script>";
        }echo 'FILE:',__FILE__,'LINE:',__LINE__;exit();
    }

    protected function download($photo)
    {
        $cfg = K::$system->config->get('attach');
        if(preg_match('/^http:\/\/.+\.(jpg|png|jpeg|gif)$/i', $photo, $match)){
            if($ch = curl_init($photo)){
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                $content = curl_exec($ch);
                if(curl_getinfo($ch, CURLINFO_HTTP_CODE) === 200){
                    $B = realpath($cfg['attachdir']).DIRECTORY_SEPARATOR;
                    $file = 'photo/'.date('Ym/').DIRECTORY_SEPARATOR.date('Ymd_').strtoupper(md5(microtime().PRI_KEY.rand())).".{$match[1]}";
                    $F = $B.$file;
                    K::M('io/dir')->create(dirname($F), 0777, true);
                    file_put_contents($F, $content);
                }
                return $file;
            }
            return '';
        }
        return '';

    }
}

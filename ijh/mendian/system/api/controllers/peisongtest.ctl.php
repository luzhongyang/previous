<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if (!defined('__CORE_DIR')) {
    exit("Access Denied");
}

/**
 * ---------------------------测试专用---------------------------
 *  "message": "empty"  表示没有任务执行
 *      空对象, 用大括号
 * 请求方法:
 * http://mendian.weizx.cn/api.php?API=paotui/api_main
 * 无需参数;
 *
 * 结果提交:
 * http://mendian.weizx.cn/api.php?API=paotui/api_log
 * 提交参数:  post 方式
 * api_id: 之前返回的
 * platform: 之前返回的
 * head: 请求饿了么获取的
 * body: 请求饿了么获取的
 *
 * 发送数据类型:
 * url_type: 表示提交方式  有3种格式
 *  get, url_param 参数以 get方式提交
 *  post, url_param 参数以post方式提交
 *  json, url_param 参数以json体方式提交
 *
 */
class Ctl_Peisongtest extends Ctl
{

    public $shop_id = 1;//test


    function __api_login($params)
    {
//        $params['name'] = 'login';//默认登陆方法
//        //测试数据,shop_id  =  1
//        $params['shop_id'] = 1;
        //3端固定api

        if (!$platform = $params['platform']) {
            $this->msgbox->add('平台不存在,测试平台 platform=eleme', 212);
        } else {
            $filter = array(
                'group_name' => $params['group_name'],
                'platform' => $platform,
            );

            if ($detail = K::M('peisong/sysapigroup')->find($filter)) {

                $api_list = implode(',', array_filter(explode(',', $detail['api_list'])));
                $where = 'api_id in (' . $api_list . ')';
                if ($api_arr = K::M('peisong/sysapi')->items($where)) {
                    foreach ($api_arr as $k => $v) {
                        unset($v['content']);//去除不需要返回的字段
                        $api_arr[$k] = $v;
                    }
                    $filter = array('shop_id' => $this->shop_id, 'platform' => $detail['platform']);
                    $login_info = K::M('peisong/sysaccount')->find($filter);
                    $arr_eleme = $arr_meituan = $arr_baidu = array('list' => array(), 'header' => '');
                    switch ($detail['platform']) {
                        case 'eleme':
                            if ('login_2' == $params['group_name']) {
                                $login_info['login_info'] = $login_info['login_info'];//request_header 需要转换
                                //替换用户名和密码
                                $arr_s = array('##id##', '##username##', '##password##');
                                $arr_i = array($login_info['bak1'], $login_info['user_name'], $login_info['password']);
                                $api_arr[2] = str_replace($arr_s, $arr_i, $api_arr[2]);
                            }
                            $api_arr = array_values($api_arr);


                            $arr_eleme = array(
                                'list' => $api_arr,
                            );
                            if ('login_1' == $params['group_name']) {
                                $arr_eleme['header'] = $login_info['login_header'];
                            } else if ('login_2' == $params['group_name']) {
                                $arr_eleme['header'] = $login_info['request_header'];
                            }
                            break;
                        case 'meituan':
                            if ('login_2' == $params['group_name']) {
//                                $login_info['login_info'] = $login_info['login_info'];//request_header 需要转换
                                //替换用户名和密码
                                $arr_s = array('##username##', '##password##');
                                $arr_i = array($login_info['user_name'], $login_info['password']);

                                $api_arr[5] = str_replace($arr_s, $arr_i, $api_arr[5]);
                            }

                            $api_arr = array_values($api_arr);


                            $arr_meituan = array(
                                'list' => $api_arr,
                            );
                            if ('login_1' == $params['group_name']) {
                                $arr_meituan['header'] = $login_info['login_header'];
                            } else if ('login_2' == $params['group_name']) {
                                $arr_meituan['header'] = $login_info['request_header'];
                            }
                            break;
                        case 'baidu':
                            if ('login_2' == $params['group_name']) {
//                                $login_info['login_info'] = $login_info['login_info'];//request_header 需要转换
                                //替换用户名和密码
                                $arr_s = array('##username##', '##password##');
                                $arr_i = array($login_info['user_name'], $login_info['password']);
                                $api_arr[8] = str_replace($arr_s, $arr_i, $api_arr[8]);
                            }

                            $api_arr = array_values($api_arr);


                            $arr_meituan = array(
                                'list' => $api_arr,
                            );
                            if ('login_1' == $params['group_name']) {
                                $arr_meituan['header'] = $login_info['login_header'];
                            } else if ('login_2' == $params['group_name']) {
                                $arr_meituan['header'] = $login_info['request_header'];
                            }
                            break;
                    }


                    $items = array('eleme' => $arr_eleme, 'meituan' => $arr_meituan, 'baidu' => $arr_baidu);
                    header("Content-type: text/html; charset=utf-8");
                    echo '<pre>------<hr />    ';
                    print_r($items);
                    die('</pre>');

                    $this->msgbox->add('success');
                    $this->msgbox->set_data('data', $items);
                } else {
                    $this->msgbox->add('登陆api不存在', 212);
                }

            } else {
                $this->msgbox->add('登陆平台不存在,测试平台 platform=eleme', 215);
            }

        }
    }

    /**
     * 获取主要请求参数
     * @param $params
     */
    public function __get_list($params)
    {
        $filter = array('shop_id' => $this->shop_id);
        if (!$account = K::M('peisong/sysaccount')->items($filter)) {
            $this->msgbox->add('没有设置第三方账号', 211);
        } else {
            //获取每个平台抓单的请求,
            $filter = array(
                'group_name' => $params['group_name'],
            );

            if ($arr_platform = K::M('peisong/sysapigroup')->items($filter)) {
                $platform_all = array('eleme', 'meituan', 'baidu');
                $arr_eleme = $arr_meituan = $arr_baidu = array('list' => array(), 'header' => '');
                if (!$arr_platform) {
                    $this->msgbox->add('empty');
                } else {
                    foreach ($arr_platform as $k => $detail) {
                        if (in_array($detail['platform'], $platform_all)) {
                            $api_list = implode(',', array_filter(explode(',', $detail['api_list'])));
                            $where = 'api_id in (' . $api_list . ')';
                            switch ($detail['platform']) {
                                case 'eleme':

                                    if ($api_arr = K::M('peisong/sysapi')->items($where)) {

                                        //------------eleme order start------------------
                                        $filter = array('shop_id' => $this->shop_id, 'platform' => $detail['platform']);
                                        $login_info = K::M('peisong/sysaccount')->find($filter);
                                        $id_ksid = json_decode($login_info['login_main_params']);

                                        //其他接口,看是否也需要 id 和 ksid, 如果需要其他参数,要修改代码.
                                        foreach ($api_arr as $k => $v) {
                                            $arr_s = array('##id##', '##ksid##');
                                            $arr_i = array($id_ksid->id, $id_ksid->ksid);
                                            $v['url_param'] = str_replace($arr_s, $arr_i, $v['url_param']);;
                                            $api_arr[$k] = $v;

                                        }
                                        $api_arr = array_values($api_arr);
                                        $arr_eleme = array(
                                            'list' => $api_arr,
                                            'header' => $login_info['login_info'],
                                            'params' => $login_info['login_main_params'],
                                        );
                                        //------------eleme order finish------------------


                                    } else {
                                        $this->msgbox->add('eleme没有指定任务详情', 216);
                                    }

                                    break;
                                case 'meituan':

                                    if ($api_arr = K::M('peisong/sysapi')->items($where)) {

                                        //------------eleme order start------------------
                                        $filter = array('shop_id' => $this->shop_id, 'platform' => $detail['platform']);
                                        $login_info = K::M('peisong/sysaccount')->find($filter);

                                        //其他接口,看是否也需要 id 和 ksid, 如果需要其他参数,要修改代码.
                                        foreach ($api_arr as $k => $v) {
                                            //抓单,自定义时间
                                            if (6 == $v['api_id']) {
                                                $_today = date('Y-m-d');
                                                $_yesterday = date('Y-m-d', strtotime(date('Y-m-d')) - 86400);

                                                $arr_s = array('##today##', '##yesterday##');
                                                $arr_i = array($_today, $_yesterday);
                                                $v['url'] = str_replace($arr_s, $arr_i, $v['url']);
                                            }
                                            //其他参数,待定..
                                            $api_arr[$k] = $v;
                                        }
                                        $api_arr = array_values($api_arr);
                                        $arr_meituan = array(
                                            'list' => $api_arr,
                                            'header' => $login_info['login_info'],
                                            'params' => $login_info['login_main_params'],
                                        );
                                        //------------eleme order finish------------------


                                    } else {
                                        $this->msgbox->add('meituan没有指定任务详情', 216);
                                    }


                                    break;
                                case 'baidu':
                                    break;
                            }
                        }
                    }
                    $this->msgbox->add('success');
                }


                $items = array('eleme' => $arr_eleme, 'meituan' => $arr_meituan, 'baidu' => $arr_baidu);
//                header("Content-type: text/html; charset=utf-8");
//                echo '<pre>------<hr />    ';
//                print_r($items);
//                die('</pre>');
                $this->msgbox->set_data('data', $items);


            } else {
                $this->msgbox->add('系统没有指定抓单日常任务', 215);
            }
        }
    }

    /**
     *  饿了么, 对接功能和流程,
     *      设计一个递归请求,用于登陆
     * 请求连接->
     *              是否登陆->
     *                              登陆接口 1,2,3, 判断流,
     *                                      进行到 3 结束, 不返回回传连接,
     *              常规接口->
     *                              http请求,get/post
     */

    /**
     * 主方法, 所有请求统一调用
     */
    public function api_main($params)
    {
        //登陆return url: type=login1
        $return = $this->__params($params);
        $platform = $return['platform'];
        $group_name = $return['group_name'];

        //$group_name 参数不同可能存在差异化,方便以后维护,特分开
        switch ($group_name) {
            case 'login_1':
                switch ($platform) {
                    case 'eleme':
                        $login_params = array(
                            'platform' => $platform,
                            'group_name' => 'login_1',
                            'shop_id' => $this->shop_id,
                        );
                        $this->__api_login($login_params);
                        break;
                    case 'meituan':
                        $login_params = array(
                            'platform' => $platform,
                            'group_name' => 'login_1',
                            'shop_id' => $this->shop_id,
                        );
                        $this->__api_login($login_params);
                        break;
                    case 'baidu':
                        $login_params = array(
                            'platform' => $platform,
                            'group_name' => 'login_1',
                            'shop_id' => $this->shop_id,
                        );
                        $this->__api_login($login_params);
                        break;
                }

                break;
            case 'login_2':
                switch ($platform) {
                    case 'eleme':
                        $login_params = array(
                            'platform' => $platform,
                            'group_name' => 'login_2',
                            'shop_id' => $this->shop_id,
                        );
                        $this->__api_login($login_params);
                        break;
                    case 'meituan':
                        $login_params = array(
                            'platform' => $platform,
                            'group_name' => 'login_2',
                            'shop_id' => $this->shop_id,
                        );
                        $this->__api_login($login_params);
                        break;
                    case 'baidu':
                        $login_params = array(
                            'platform' => $platform,
                            'group_name' => 'login_2',
                            'shop_id' => $this->shop_id,
                        );
                        $this->__api_login($login_params);
                        break;
                }

                break;
            case 'login_yzm':
                switch ($platform) {
                    case 'eleme':
                        break;
                    case 'meituan':
                        break;
                    case 'baidu':
                        //百度有验证码,单独走这里.
                        //代码待定...
                        break;
                }

                break;
            case 'orderxxx':

                break;
            default:

                //-------------eleme order start----------------
                $login_params = array(
                    'group_name' => 'order',
                );
                $this->__get_list($login_params);
                //-------------eleme order finish----------------


                break;
        }

    }

    public function __params($params)
    {
        $_POST['platform'] = isset($_POST['platform']) ? $_POST['platform'] : '';
        $platform = isset($params['platform']) ? $params['platform'] : $_POST['platform'];//platform
        $_POST['group_name'] = isset($_POST['group_name']) ? $_POST['group_name'] : '';
        $group_name = isset($params['group_name']) ? $params['group_name'] : $_POST['group_name'];//group_name: login, order ...
        $_POST['api_id'] = isset($_POST['api_id']) ? $_POST['api_id'] : '';
        $api_id = isset($params['api_id']) ? $params['api_id'] : $_POST['api_id'];//api_id
        return array('platform' => $platform, 'group_name' => $group_name, 'api_id' => $api_id);
    }

    /**
     * write data
     * @param $params
     * platform,    group_name
     */
    public function api_log($params)
    {
        //write data
        $return = $this->__params($params);
        $platform = $return['platform'];
        $group_name = $return['group_name'];
        $api_id = $return['api_id'];

        //K::M('system/logs')->log('___data_paotui', array($_POST, $_GET, $params));

        $request_head = trim($_POST['head']);
        $request_body = trim($_POST['body']);
        K::M('system/logs')->log('___paotui_head', array($request_head, $request_body, $api_id));
//        $request_body = '{"ncp":"2.0.0","id":"19a8435f-22d2-453c-8da3-001826d13002","result":null,"error":{"code":"VALIDATION_FAILED","message":"错误的会话ID"}}';
//        $request_body = file_get_contents('D:/data_test/eleme.txt');//饿了么返回数据
        $condition = array(
            'shop_id' => $this->shop_id,
            'platform' => $platform,
        );
        $account = K::M('peisong/sysaccount')->find($condition);

        switch ($platform) {
            case 'eleme':
                //``````````````````````eleme start``````````````````````````
                //check whether is login
                /**
                 * eleme  第一次登陆 login_1:  api_id = 1,  主登陆  login_2:  api_id = 2
                 */
                switch ($api_id) {
                    case 1: //eleme 第一次访问, 从头部获取 id
//                        $detail = K::M('peisong/sysapilog')->detail(13);//test正式运行,改为传递至
//                        $request_head = $detail['request_head'];//test正式运行,改为传递至

                        //write_log test
                        $data = array(
                            'shop_id' => $this->shop_id,
                            'api_id' => $api_id,
                            'request_head' => $request_head,
                            'request_body' => $request_body,
                            'platform' => $platform,
                            'dateline' => __TIME
                        );

                        if ($new_log_id = K::M('peisong/sysapilog')->create($data)) {
                            $detail = K::M('peisong/sysapilog')->detail($new_log_id);//test正式运行,改为传递至
                            $request_head = $detail['request_head'];//test正式运行,改为传递至
                        }

                        $request_head_array = (array)json_decode($request_head);

                        //bak1 存储 X-NWS-LOG-UUID, 登陆时,转换 ##id## 用
                        $update = array(
                            'bak1' => $request_head_array['X-NWS-LOG-UUID'],
                            'login_return' => $request_head, //test 正式运行,改为传递至
                        );


                        $is_update = K::M('peisong/sysaccount')->update($account['account_id'], $update);
//                        header("Content-type: text/html; charset=utf-8");
//                        echo '<pre>------<hr />    ';
//                        print_r($is_update);
//                        die('</pre>');

//                        $this->msgbox->set_data('data', array($update, $is_update, $new_log_id, $request_head));
                        K::M('system/logs')->log('___paotui_head_new', array($update, $is_update, $new_log_id, $request_head));

                        $login_params = array(
                            'platform' => $platform,
                            'group_name' => 'login_2',
                            'shop_id' => $this->shop_id,
                        );
                        $this->__api_login($login_params);

                        break;
                    case 2: //登陆住方法,    获取ksid,并组成登陆串存储到数据库
//                        $detail = K::M('peisong/sysapilog')->detail(852);//test正式运行,改为传递至
//                        $request_head = $detail['request_head'];//test正式运行,改为传递至//
                        $result = json_decode($request_body);
                        $login = array();
                        $login['ksid'] = $result->result->successData->ksid;
                        $login['id'] = $result->id;
                        $login_main_params = json_encode($login);
                        $update = array(
                            'login_info' => $request_head,
                            'login_main_params' => $login_main_params,
                            'bak3' => $request_body,     //bak3 存储登陆返回body
                            'login_time' => __TIME
                        );
                        //update  id,
                        $is_update = K::M('peisong/sysaccount')->update($account['account_id'], $update);

                        //update ksid to url_params


//                        die('log test');
                        break;
                }
                $log_api_id = array(1, 2);
                if (!in_array($api_id, $log_api_id)) {
                    //check whether is login from app return
                    $result = json_decode($request_body);
                    if (empty($result->result) || isset($result->error->code)) {
//                    die($result->error->message);
                        //返回登陆接口,执行回调,
                        $login_params = array(
                            'platform' => $platform,
                            'group_name' => 'login_1',
                            'shop_id' => $this->shop_id,
                        );
                        $this->__api_login($login_params);

                    } else {

                        //直接放回日志.晚些加入数据库
                        K::M('system/logs')->log('____crontab_1_staff', array($_POST, $_GET, $params));
                        $data = array(
                            'shop_id' => $this->shop_id,
                            'api_id' => $api_id,
                            'request_head' => $request_head,
                            'request_body' => $request_body,
                            'platform' => $platform,
                            'dateline' => __TIME
                        );
                        if ($card_id = K::M('peisong/sysapilog')->create($data)) {
                            $this->msgbox->add('success');
                        } else {
                            $this->msgbox->add('记录日志失败', 211);
                        }
                        //接收回传值参数
//                        foreach ($result->result->orders as $k => $v) {
//                            print_r($v);
//                            die;
//                        }

                        $this->msgbox->add('success');
                        //if need get mobile and order fee, go on return api list
                    }
                }
                //``````````````````````eleme finish``````````````````````````
                break;
            case 'meituan':
                //``````````````````````meituan start``````````````````````````
                /**
                 * meituan  第一次登陆 login_1:  api_id = 4,  主登陆  login_2:  api_id = 5
                 */
                switch ($api_id) {
                    case 4: //eleme 第一次访问, 从头部获取 id
//                        $detail = K::M('peisong/sysapilog')->detail(852);//test正式运行,改为传递至
//                        $request_head = $detail['request_head'];//test正式运行,改为传递至
                        $update = array(
                            'login_return' => $request_head, //test 正式运行,改为传递至
                        );

                        //update  id,
                        $is_update = K::M('peisong/sysaccount')->update($account['account_id'], $update);

                        $login_params = array(
                            'platform' => $platform,
                            'group_name' => 'login_2',
                            'shop_id' => $this->shop_id,
                        );

                        $this->__api_login($login_params);

                        break;
                    case 5: //登陆住方法,    获取ksid,并组成登陆串存储到数据库
                        $result = json_decode($request_body);
                        $update = array(
                            'login_info' => $request_head,
                            'bak3' => $request_body,     //bak3 存储登陆返回body
                            'login_time' => __TIME
                        );
                        //update  id,
                        $is_update = K::M('peisong/sysaccount')->update($account['account_id'], $update);

                        //update ksid to url_params
                        $this->msgbox->add('success');


//                        die('log test');
                        break;
                }
                $log_api_id = array(4, 5);
                if (!in_array($api_id, $log_api_id)) {
                    //check whether is login from app return
                    $result = trim($request_body);//meituan没有值 是 空
                    if (strlen($result) < 3) {
//                    die($result->error->message);
                        //返回登陆接口,执行回调,
                        $login_params = array(
                            'platform' => $platform,
                            'group_name' => 'login_1',
                            'shop_id' => $this->shop_id,
                        );
                        $this->__api_login($login_params);

                    } else {

                        //直接放回日志.晚些加入数据库
                        K::M('system/logs')->log('____crontab_1_staff', array($_POST, $_GET, $params));
                        $data = array(
                            'shop_id' => $this->shop_id,
                            'api_id' => $api_id,
                            'request_head' => $request_head,
                            'request_body' => $request_body,
                            'platform' => $platform,
                            'dateline' => __TIME
                        );
                        if ($card_id = K::M('peisong/sysapilog')->create($data)) {
                            $this->msgbox->add('success');
                        } else {
                            $this->msgbox->add('记录日志失败', 211);
                        }
                        //接收回传值参数
//                        foreach ($result->result->orders as $k => $v) {
//                            print_r($v);
//                            die;
//                        }


                        //if need get mobile and order fee, go on return api list
                    }
                }

                //``````````````````````meituan start``````````````````````````
                break;
            case 'baidu':
                //``````````````````````baidu start``````````````````````````
                //check whether is login
                /**
                 * eleme  第一次登陆 login_1:  api_id = 1,  主登陆  login_2:  api_id = 2
                 */

                switch ($api_id) {
                    case 7: //eleme 第一次访问, 从头部获取 id
//                        $detail = K::M('peisong/sysapilog')->detail(13);//test正式运行,改为传递至
//                        $request_head = $detail['request_head'];//test正式运行,改为传递至

                        //write_log test
                        $data = array(
                            'shop_id' => $this->shop_id,
                            'api_id' => $api_id,
                            'request_head' => $request_head,
                            'request_body' => $request_body,
                            'platform' => $platform,
                            'dateline' => __TIME
                        );

                        if ($new_log_id = K::M('peisong/sysapilog')->create($data)) {
                            $detail = K::M('peisong/sysapilog')->detail($new_log_id);//test正式运行,改为传递至
                            $request_head = $detail['request_head'];//test正式运行,改为传递至
                        }

                        $request_head_array = (array)json_decode($request_head);

                        //bak1 存储 X-NWS-LOG-UUID, 登陆时,转换 ##id## 用
                        $update = array(
                            'bak1' => $request_head_array['X-NWS-LOG-UUID'],
                            'login_return' => $request_head, //test 正式运行,改为传递至
                        );


                        $is_update = K::M('peisong/sysaccount')->update($account['account_id'], $update);
//                        header("Content-type: text/html; charset=utf-8");
//                        echo '<pre>------<hr />    ';
//                        print_r($is_update);
//                        die('</pre>');

//                        $this->msgbox->set_data('data', array($update, $is_update, $new_log_id, $request_head));
                        K::M('system/logs')->log('___paotui_head_new', array($update, $is_update, $new_log_id, $request_head));

                        $login_params = array(
                            'platform' => $platform,
                            'group_name' => 'login_2',
                            'shop_id' => $this->shop_id,
                        );
                        $this->__api_login($login_params);

                        break;
                    case 8: //登陆住方法,    获取ksid,并组成登陆串存储到数据库
//                        $detail = K::M('peisong/sysapilog')->detail(852);//test正式运行,改为传递至
//                        $request_head = $detail['request_head'];//test正式运行,改为传递至//
                        $result = json_decode($request_body);
                        $login = array();
                        $login['ksid'] = $result->result->successData->ksid;
                        $login['id'] = $result->id;
                        $login_main_params = json_encode($login);
                        $update = array(
                            'login_info' => $request_head,
                            'login_main_params' => $login_main_params,
                            'bak3' => $request_body,     //bak3 存储登陆返回body
                            'login_time' => __TIME
                        );
                        //update  id,
                        $is_update = K::M('peisong/sysaccount')->update($account['account_id'], $update);

                        //update ksid to url_params


//                        die('log test');
                        break;
                }
                $log_api_id = array(7, 8);
                if (!in_array($api_id, $log_api_id)) {
                    //check whether is login from app return
                    $result = json_decode($request_body);
                    if (empty($result->result) || isset($result->error->code)) {
//                    die($result->error->message);
                        //返回登陆接口,执行回调,
                        $login_params = array(
                            'platform' => $platform,
                            'group_name' => 'login_1',
                            'shop_id' => $this->shop_id,
                        );
                        $this->__api_login($login_params);

                    } else {

                        //直接放回日志.晚些加入数据库
                        K::M('system/logs')->log('____crontab_1_staff', array($_POST, $_GET, $params));
                        $data = array(
                            'shop_id' => $this->shop_id,
                            'api_id' => $api_id,
                            'request_head' => $request_head,
                            'request_body' => $request_body,
                            'platform' => $platform,
                            'dateline' => __TIME
                        );
                        if ($card_id = K::M('peisong/sysapilog')->create($data)) {
                            $this->msgbox->add('success');
                        } else {
                            $this->msgbox->add('记录日志失败', 211);
                        }
                        //接收回传值参数
//                        foreach ($result->result->orders as $k => $v) {
//                            print_r($v);
//                            die;
//                        }

                        $this->msgbox->add('success');
                        //if need get mobile and order fee, go on return api list
                    }
                }
                //``````````````````````baidu start``````````````````````````
                break;
            default:
                $this->msgbox->add('平台不存在,无法回传数据', 233);
                break;
        }

    }

    /**
     *  text 接口,    body=idbody&head=ishead
     * 返回值,
     */
    public function log($params)
    {
        K::M('system/logs')->log('____crontab_1_staff', array($_POST, $_GET, $params));
        $head = $_POST['head'];
        $body = $_POST['body'];
        $data = array(
            'shop_id' => $this->shop_id,
            'api_id' => (int)$params['api_id'],
            'request_head' => $head,
            'request_body' => $body,
            'platform' => empty($params['platform']) ? 'eleme' : 'baidu',
            'dateline' => __TIME
        );

        if ($card_id = K::M('peisong/sysapilog')->create($data)) {
            $this->msgbox->add('success');
        } else {
            $this->msgbox->add('记录日志失败', 211);
        }
    }


    /**
     * test 方法
     */
    public function test($params)
    {

        $headers = array(
            'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.19 Safari/537.36',
            'Content-type:application/json;charset=UTF-8'
        );
        $headers = array_values($headers);
        $this->msgbox->set_data('data', array('header' => $headers));
    }


}

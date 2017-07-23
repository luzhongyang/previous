<?php exit("Access denied");?>
+-----------------------------------------------------+
Time:2016-11-03 09:58:36
Log:PushPayload::__set_state(array(
   'client' => 
  JPush::__set_state(array(
     'appKey' => '',
     'masterSecret' => '',
     'retryTimes' => 3,
     'logFile' => './jpush.log',
  )),
   'platform' => 'all',
   'audience' => NULL,
   'tags' => NULL,
   'tagAnds' => NULL,
   'alias' => 
  array (
    0 => '10006',
  ),
   'registrationIds' => NULL,
   'notificationAlert' => NULL,
   'iosNotification' => 
  array (
    'alert' => '[夏玉峰]下了团购了3份[测试团购商品](单号：10113)',
    'sound' => 'newOrder.mp3',
    'badge' => '+1',
    'content-available' => true,
    'extras' => 
    array (
      'type' => 'order',
      'order_id' => 10113,
      'sound' => 'newOrder.mp3',
    ),
  ),
   'androidNotification' => 
  array (
    'alert' => '[夏玉峰]下了团购了3份[测试团购商品](单号：10113)',
    'title' => '新的团购订单(单号：10113)',
    'builder_id' => 1,
    'extras' => 
    array (
      'type' => 'order',
      'order_id' => 10113,
      'sound' => 'newOrder.mp3',
    ),
  ),
   'winPhoneNotification' => NULL,
   'smsMessage' => NULL,
   'message' => NULL,
   'options' => 
  array (
    'sendno' => 69528,
    'apns_production' => true,
  ),
))

<?php exit("Access denied");?>
+-----------------------------------------------------+
Time:2016-11-03 09:58:36
Log:Send POST https://api.jpush.cn/v3/push, body:{"platform":"all","audience":{"alias":["10006"]},"notification":{"android":{"alert":"[\u590f\u7389\u5cf0]\u4e0b\u4e86\u56e2\u8d2d\u4e863\u4efd[\u6d4b\u8bd5\u56e2\u8d2d\u5546\u54c1](\u5355\u53f7\uff1a10113)","title":"\u65b0\u7684\u56e2\u8d2d\u8ba2\u5355(\u5355\u53f7\uff1a10113)","builder_id":1,"extras":{"type":"order","order_id":10113,"sound":"newOrder.mp3"}},"ios":{"alert":"[\u590f\u7389\u5cf0]\u4e0b\u4e86\u56e2\u8d2d\u4e863\u4efd[\u6d4b\u8bd5\u56e2\u8d2d\u5546\u54c1](\u5355\u53f7\uff1a10113)","sound":"newOrder.mp3","badge":"+1","content-available":true,"extras":{"type":"order","order_id":10113,"sound":"newOrder.mp3"}}},"options":{"sendno":69528,"apns_production":true}}, times:1

<?php exit("Access denied");?>
+-----------------------------------------------------+
Time:2016-11-03 09:58:36
Log:array (
  0 => 'HTTP/1.1 401 Unauthorized
Server: nginx
Date: Thu, 03 Nov 2016 01:58:36 GMT
Content-Type: application/json
Transfer-Encoding: chunked
Connection: keep-alive

{"error": {"message": "Authen failed", "code": 1004}}
',
  1 => 0,
)

<?php exit("Access denied");?>
+-----------------------------------------------------+
Time:2016-11-03 10:01:09
Log:PushPayload::__set_state(array(
   'client' => 
  JPush::__set_state(array(
     'appKey' => '',
     'masterSecret' => '',
     'retryTimes' => 3,
     'logFile' => './jpush.log',
  )),
   'platform' => 'all',
   'audience' => NULL,
   'tags' => NULL,
   'tagAnds' => NULL,
   'alias' => 
  array (
    0 => '10006',
  ),
   'registrationIds' => NULL,
   'notificationAlert' => NULL,
   'iosNotification' => 
  array (
    'alert' => '优惠买单成功(单号：10114)，买单金额￥10.00，优惠后支付￥10.00',
    'sound' => 'newMsg.mp3',
    'badge' => '+1',
    'content-available' => true,
    'extras' => 
    array (
      'type' => 'order',
      'order_id' => 10114,
      'sound' => 'newMsg.mp3',
    ),
  ),
   'androidNotification' => 
  array (
    'alert' => '优惠买单成功(单号：10114)，买单金额￥10.00，优惠后支付￥10.00',
    'title' => '优惠买单成功通知(单号：10114)',
    'builder_id' => 1,
    'extras' => 
    array (
      'type' => 'order',
      'order_id' => 10114,
      'sound' => 'newMsg.mp3',
    ),
  ),
   'winPhoneNotification' => NULL,
   'smsMessage' => NULL,
   'message' => NULL,
   'options' => 
  array (
    'sendno' => 16977,
    'apns_production' => true,
  ),
))

<?php exit("Access denied");?>
+-----------------------------------------------------+
Time:2016-11-03 10:01:09
Log:Send POST https://api.jpush.cn/v3/push, body:{"platform":"all","audience":{"alias":["10006"]},"notification":{"android":{"alert":"\u4f18\u60e0\u4e70\u5355\u6210\u529f(\u5355\u53f7\uff1a10114)\uff0c\u4e70\u5355\u91d1\u989d\uffe510.00\uff0c\u4f18\u60e0\u540e\u652f\u4ed8\uffe510.00","title":"\u4f18\u60e0\u4e70\u5355\u6210\u529f\u901a\u77e5(\u5355\u53f7\uff1a10114)","builder_id":1,"extras":{"type":"order","order_id":10114,"sound":"newMsg.mp3"}},"ios":{"alert":"\u4f18\u60e0\u4e70\u5355\u6210\u529f(\u5355\u53f7\uff1a10114)\uff0c\u4e70\u5355\u91d1\u989d\uffe510.00\uff0c\u4f18\u60e0\u540e\u652f\u4ed8\uffe510.00","sound":"newMsg.mp3","badge":"+1","content-available":true,"extras":{"type":"order","order_id":10114,"sound":"newMsg.mp3"}}},"options":{"sendno":16977,"apns_production":true}}, times:1

<?php exit("Access denied");?>
+-----------------------------------------------------+
Time:2016-11-03 10:01:09
Log:array (
  0 => 'HTTP/1.1 401 Unauthorized
Server: nginx
Date: Thu, 03 Nov 2016 02:01:09 GMT
Content-Type: application/json
Transfer-Encoding: chunked
Connection: keep-alive

{"error": {"message": "Authen failed", "code": 1004}}
',
  1 => 0,
)

<?php exit("Access denied");?>
+-----------------------------------------------------+
Time:2016-11-07 11:16:14
Log:PushPayload::__set_state(array(
   'client' => 
  JPush::__set_state(array(
     'appKey' => '8fc869e2d7dc7370161098a2',
     'masterSecret' => '2155da5dd74b4ff18856e79d',
     'retryTimes' => 3,
     'logFile' => './jpush.log',
  )),
   'platform' => 'all',
   'audience' => NULL,
   'tags' => NULL,
   'tagAnds' => NULL,
   'alias' => 
  array (
    0 => '171',
  ),
   'registrationIds' => NULL,
   'notificationAlert' => NULL,
   'iosNotification' => 
  array (
    'alert' => '订单(10115)商家已经开始配送',
    'sound' => 'default',
    'badge' => '+1',
    'content-available' => true,
    'extras' => 
    array (
      'type' => 'order',
      'order_id' => 10115,
    ),
  ),
   'androidNotification' => 
  array (
    'alert' => '订单(10115)商家已经开始配送',
    'title' => '订单开始配送',
    'builder_id' => 1,
    'extras' => 
    array (
      'type' => 'order',
      'order_id' => 10115,
    ),
  ),
   'winPhoneNotification' => NULL,
   'smsMessage' => NULL,
   'message' => NULL,
   'options' => 
  array (
    'sendno' => 74484,
    'apns_production' => true,
  ),
))

<?php exit("Access denied");?>
+-----------------------------------------------------+
Time:2016-11-07 11:16:14
Log:Send POST https://api.jpush.cn/v3/push, body:{"platform":"all","audience":{"alias":["171"]},"notification":{"android":{"alert":"\u8ba2\u5355(10115)\u5546\u5bb6\u5df2\u7ecf\u5f00\u59cb\u914d\u9001","title":"\u8ba2\u5355\u5f00\u59cb\u914d\u9001","builder_id":1,"extras":{"type":"order","order_id":10115}},"ios":{"alert":"\u8ba2\u5355(10115)\u5546\u5bb6\u5df2\u7ecf\u5f00\u59cb\u914d\u9001","sound":"default","badge":"+1","content-available":true,"extras":{"type":"order","order_id":10115}}},"options":{"sendno":74484,"apns_production":true}}, times:1

<?php exit("Access denied");?>
+-----------------------------------------------------+
Time:2016-11-07 11:16:15
Log:array (
  0 => 'HTTP/1.1 400 BAD REQUEST
Server: nginx
Date: Mon, 07 Nov 2016 03:16:15 GMT
Content-Type: application/json
Transfer-Encoding: chunked
Connection: keep-alive
X-Rate-Limit-Limit: 600
X-Rate-Limit-Remaining: 599
X-Rate-Limit-Reset: 60
X-JPush-MsgId: 3316595082

{"msg_id": 3316595082, "error": {"message": "cannot find user by this audience", "code": 1011}}',
  1 => 0,
)

<?php exit("Access denied");?>
+-----------------------------------------------------+
Time:2016-11-07 11:17:37
Log:PushPayload::__set_state(array(
   'client' => 
  JPush::__set_state(array(
     'appKey' => '8fc869e2d7dc7370161098a2',
     'masterSecret' => '2155da5dd74b4ff18856e79d',
     'retryTimes' => 3,
     'logFile' => './jpush.log',
  )),
   'platform' => 'all',
   'audience' => NULL,
   'tags' => NULL,
   'tagAnds' => NULL,
   'alias' => 
  array (
    0 => '171',
  ),
   'registrationIds' => NULL,
   'notificationAlert' => NULL,
   'iosNotification' => 
  array (
    'alert' => '订单(10115)商家已经开始配送',
    'sound' => 'default',
    'badge' => '+1',
    'content-available' => true,
    'extras' => 
    array (
      'type' => 'order',
      'order_id' => 10115,
    ),
  ),
   'androidNotification' => 
  array (
    'alert' => '订单(10115)商家已经开始配送',
    'title' => '订单开始配送',
    'builder_id' => 1,
    'extras' => 
    array (
      'type' => 'order',
      'order_id' => 10115,
    ),
  ),
   'winPhoneNotification' => NULL,
   'smsMessage' => NULL,
   'message' => NULL,
   'options' => 
  array (
    'sendno' => 50647,
    'apns_production' => true,
  ),
))

<?php exit("Access denied");?>
+-----------------------------------------------------+
Time:2016-11-07 11:17:37
Log:Send POST https://api.jpush.cn/v3/push, body:{"platform":"all","audience":{"alias":["171"]},"notification":{"android":{"alert":"\u8ba2\u5355(10115)\u5546\u5bb6\u5df2\u7ecf\u5f00\u59cb\u914d\u9001","title":"\u8ba2\u5355\u5f00\u59cb\u914d\u9001","builder_id":1,"extras":{"type":"order","order_id":10115}},"ios":{"alert":"\u8ba2\u5355(10115)\u5546\u5bb6\u5df2\u7ecf\u5f00\u59cb\u914d\u9001","sound":"default","badge":"+1","content-available":true,"extras":{"type":"order","order_id":10115}}},"options":{"sendno":50647,"apns_production":true}}, times:1

<?php exit("Access denied");?>
+-----------------------------------------------------+
Time:2016-11-07 11:17:37
Log:array (
  0 => 'HTTP/1.1 400 BAD REQUEST
Server: nginx
Date: Mon, 07 Nov 2016 03:17:37 GMT
Content-Type: application/json
Transfer-Encoding: chunked
Connection: keep-alive
X-Rate-Limit-Limit: 600
X-Rate-Limit-Remaining: 599
X-Rate-Limit-Reset: 60
X-JPush-MsgId: 3985949292

{"msg_id": 3985949292, "error": {"message": "cannot find user by this audience", "code": 1011}}',
  1 => 0,
)

<?php exit("Access denied");?>
+-----------------------------------------------------+
Time:2016-11-07 11:18:53
Log:PushPayload::__set_state(array(
   'client' => 
  JPush::__set_state(array(
     'appKey' => '8fc869e2d7dc7370161098a2',
     'masterSecret' => '2155da5dd74b4ff18856e79d',
     'retryTimes' => 3,
     'logFile' => './jpush.log',
  )),
   'platform' => 'all',
   'audience' => NULL,
   'tags' => NULL,
   'tagAnds' => NULL,
   'alias' => 
  array (
    0 => '171',
  ),
   'registrationIds' => NULL,
   'notificationAlert' => NULL,
   'iosNotification' => 
  array (
    'alert' => '订单(10115)商家已经开始配送',
    'sound' => 'default',
    'badge' => '+1',
    'content-available' => true,
    'extras' => 
    array (
      'type' => 'order',
      'order_id' => 10115,
    ),
  ),
   'androidNotification' => 
  array (
    'alert' => '订单(10115)商家已经开始配送',
    'title' => '订单开始配送',
    'builder_id' => 1,
    'extras' => 
    array (
      'type' => 'order',
      'order_id' => 10115,
    ),
  ),
   'winPhoneNotification' => NULL,
   'smsMessage' => NULL,
   'message' => NULL,
   'options' => 
  array (
    'sendno' => 88272,
    'apns_production' => true,
  ),
))

<?php exit("Access denied");?>
+-----------------------------------------------------+
Time:2016-11-07 11:18:53
Log:Send POST https://api.jpush.cn/v3/push, body:{"platform":"all","audience":{"alias":["171"]},"notification":{"android":{"alert":"\u8ba2\u5355(10115)\u5546\u5bb6\u5df2\u7ecf\u5f00\u59cb\u914d\u9001","title":"\u8ba2\u5355\u5f00\u59cb\u914d\u9001","builder_id":1,"extras":{"type":"order","order_id":10115}},"ios":{"alert":"\u8ba2\u5355(10115)\u5546\u5bb6\u5df2\u7ecf\u5f00\u59cb\u914d\u9001","sound":"default","badge":"+1","content-available":true,"extras":{"type":"order","order_id":10115}}},"options":{"sendno":88272,"apns_production":true}}, times:1

<?php exit("Access denied");?>
+-----------------------------------------------------+
Time:2016-11-07 11:18:54
Log:array (
  0 => 'HTTP/1.1 400 BAD REQUEST
Server: nginx
Date: Mon, 07 Nov 2016 03:18:54 GMT
Content-Type: application/json
Transfer-Encoding: chunked
Connection: keep-alive
X-Rate-Limit-Limit: 600
X-Rate-Limit-Remaining: 599
X-Rate-Limit-Reset: 60
X-JPush-MsgId: 3986125295

{"msg_id": 3986125295, "error": {"message": "cannot find user by this audience", "code": 1011}}',
  1 => 0,
)

<?php exit("Access denied");?>
+-----------------------------------------------------+
Time:2016-11-11 11:59:09
Log:PushPayload::__set_state(array(
   'client' => 
  JPush::__set_state(array(
     'appKey' => '',
     'masterSecret' => '',
     'retryTimes' => 3,
     'logFile' => './jpush.log',
  )),
   'platform' => 'all',
   'audience' => NULL,
   'tags' => NULL,
   'tagAnds' => NULL,
   'alias' => 
  array (
    0 => '10006',
  ),
   'registrationIds' => NULL,
   'notificationAlert' => NULL,
   'iosNotification' => 
  array (
    'alert' => '用户(13888888888)下了团购订单(单号：10123)',
    'sound' => 'newOrder.mp3',
    'badge' => '+1',
    'content-available' => true,
    'extras' => 
    array (
      'type' => 'order',
      'order_id' => 10123,
      'sound' => 'newOrder.mp3',
      'money' => '0',
      'name' => '',
    ),
  ),
   'androidNotification' => 
  array (
    'alert' => '用户(13888888888)下了团购订单(单号：10123)',
    'title' => '新的团购订单(单号：10123)',
    'builder_id' => 1,
    'extras' => 
    array (
      'type' => 'order',
      'order_id' => 10123,
      'sound' => 'newOrder.mp3',
      'money' => '0',
      'name' => '',
    ),
  ),
   'winPhoneNotification' => NULL,
   'smsMessage' => NULL,
   'message' => NULL,
   'options' => 
  array (
    'sendno' => 60968,
    'apns_production' => true,
  ),
))

<?php exit("Access denied");?>
+-----------------------------------------------------+
Time:2016-11-11 11:59:09
Log:Send POST https://api.jpush.cn/v3/push, body:{"platform":"all","audience":{"alias":["10006"]},"notification":{"android":{"alert":"\u7528\u6237(13888888888)\u4e0b\u4e86\u56e2\u8d2d\u8ba2\u5355(\u5355\u53f7\uff1a10123)","title":"\u65b0\u7684\u56e2\u8d2d\u8ba2\u5355(\u5355\u53f7\uff1a10123)","builder_id":1,"extras":{"type":"order","order_id":10123,"sound":"newOrder.mp3","money":"0","name":""}},"ios":{"alert":"\u7528\u6237(13888888888)\u4e0b\u4e86\u56e2\u8d2d\u8ba2\u5355(\u5355\u53f7\uff1a10123)","sound":"newOrder.mp3","badge":"+1","content-available":true,"extras":{"type":"order","order_id":10123,"sound":"newOrder.mp3","money":"0","name":""}}},"options":{"sendno":60968,"apns_production":true}}, times:1

<?php exit("Access denied");?>
+-----------------------------------------------------+
Time:2016-11-11 11:59:10
Log:array (
  0 => 'HTTP/1.1 401 Unauthorized
Server: nginx
Date: Fri, 11 Nov 2016 03:59:10 GMT
Content-Type: application/json
Transfer-Encoding: chunked
Connection: keep-alive

{"error": {"message": "Authen failed", "code": 1004}}
',
  1 => 0,
)

<?php exit("Access denied");?>
+-----------------------------------------------------+
Time:2016-11-16 17:30:39
Log:PushPayload::__set_state(array(
   'client' => 
  JPush::__set_state(array(
     'appKey' => '8fc869e2d7dc7370161098a2',
     'masterSecret' => '2155da5dd74b4ff18856e79d',
     'retryTimes' => 3,
     'logFile' => './jpush.log',
  )),
   'platform' => 'all',
   'audience' => NULL,
   'tags' => NULL,
   'tagAnds' => NULL,
   'alias' => 
  array (
    0 => '171',
  ),
   'registrationIds' => NULL,
   'notificationAlert' => NULL,
   'iosNotification' => 
  array (
    'alert' => '恭喜你获得一个5元红包,订单满20可用',
    'sound' => 'default',
    'badge' => '+1',
    'content-available' => true,
    'extras' => 
    array (
      'type' => 'hongbao',
      'order_id' => 0,
    ),
  ),
   'androidNotification' => 
  array (
    'alert' => '恭喜你获得一个5元红包,订单满20可用',
    'title' => '恭喜你获得一个5元红包',
    'builder_id' => 1,
    'extras' => 
    array (
      'type' => 'hongbao',
      'order_id' => 0,
    ),
  ),
   'winPhoneNotification' => NULL,
   'smsMessage' => NULL,
   'message' => NULL,
   'options' => 
  array (
    'sendno' => 89768,
    'apns_production' => true,
  ),
))

<?php exit("Access denied");?>
+-----------------------------------------------------+
Time:2016-11-16 17:30:39
Log:Send POST https://api.jpush.cn/v3/push, body:{"platform":"all","audience":{"alias":["171"]},"notification":{"android":{"alert":"\u606d\u559c\u4f60\u83b7\u5f97\u4e00\u4e2a5\u5143\u7ea2\u5305,\u8ba2\u5355\u6ee120\u53ef\u7528","title":"\u606d\u559c\u4f60\u83b7\u5f97\u4e00\u4e2a5\u5143\u7ea2\u5305","builder_id":1,"extras":{"type":"hongbao","order_id":0}},"ios":{"alert":"\u606d\u559c\u4f60\u83b7\u5f97\u4e00\u4e2a5\u5143\u7ea2\u5305,\u8ba2\u5355\u6ee120\u53ef\u7528","sound":"default","badge":"+1","content-available":true,"extras":{"type":"hongbao","order_id":0}}},"options":{"sendno":89768,"apns_production":true}}, times:1

<?php exit("Access denied");?>
+-----------------------------------------------------+
Time:2016-11-16 17:30:41
Log:array (
  0 => 'HTTP/1.1 400 BAD REQUEST
Server: nginx
Date: Wed, 16 Nov 2016 09:30:39 GMT
Content-Type: application/json
Transfer-Encoding: chunked
Connection: keep-alive
X-Rate-Limit-Limit: 600
X-Rate-Limit-Remaining: 599
X-Rate-Limit-Reset: 60
X-JPush-MsgId: 7540219491

{"msg_id": 7540219491, "error": {"message": "cannot find user by this audience", "code": 1011}}',
  1 => 0,
)


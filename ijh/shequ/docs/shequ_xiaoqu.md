商户端API接口文档
==============

| 分组 | 接口 | API |登录权限 |
|:-----------:|------------------|------------------ |:--------------:|
|   首页    | 首页接口	| [client/xiaoqu/index](#client/xiaoqu/index)	|  否  |
|   小区    | 申请开通	| [client/xiaoqu/apply](#client/xiaoqu/apply)	|  是  |
|   小区    | 小区列表	| [client/xiaoqu/items](#client/xiaoqu/items)	|  是  |
|   通知    | 通知列表	| [client/xiaoqu/news/items](#client/xiaoqu/news/items)	|  是  |
|   业主    | 已入住小区 | [client/xiaoqu/yezhu/items](#client/xiaoqu/yezhu/items)| 是  |
|   业主    | 申请入住 | [client/xiaoqu/yezhu/create](#client/xiaoqu/yezhu/create)| 是  |
|   业主    | 修改入住资料 | [client/xiaoqu/yezhu/edit](#client/xiaoqu/yezhu/edit)| 是  |
|   业主    | 删除已入住 | [client/xiaoqu/yezhu/delete](#client/xiaoqu/yezhu/delete)| 是  |
|   便民    | 便民列表 | [client/xiaoqu/bianmin/items](#client/xiaoqu/bianmin/items)| 是  |
|   便民    | 增加使用 | [client/xiaoqu/bianmin/detail](#client/xiaoqu/bianmin/detail)| 是  |
|   便民    | 投诉类型 | [client/xiaoqu/bianmin/reportType](#client/xiaoqu/bianmin/reportType)| 是  |
|   便民    | 投诉商户 | [client/xiaoqu/bianmin/report](#client/xiaoqu/bianmin/report)| 是  |
|   报修    | 报修记录 | [client/xiaoqu/baoxiu/items](#client/xiaoqu/bianmin/items)| 是  |
|   报修    | 添加报修 | [client/xiaoqu/baoxiu/create](#client/xiaoqu/bianmin/create)| 是  |
|   报修    | 报修提醒 | [client/xiaoqu/baoxiu/tixing](#client/xiaoqu/bianmin/tixing)| 是  |
|   报修    | 撤销报修 | [client/xiaoqu/baoxiu/cancel](#client/xiaoqu/bianmin/cancel)| 是  |
|   报修    | 删除报修 | [client/xiaoqu/baoxiu/delete](#client/xiaoqu/bianmin/delete)| 是  |
|   投诉    | 投诉建议 | [client/xiaoqu/report/items](#client/xiaoqu/report/items)| 是  |
|   投诉    | 添加投诉 | [client/xiaoqu/report/create](#client/xiaoqu/report/create)| 是  |
|   投诉    | 投诉提醒 | [client/xiaoqu/report/tixing](#client/xiaoqu/report/tixing)| 是  |
|   投诉    | 撤销投诉 | [client/xiaoqu/report/cancel](#client/xiaoqu/report/cancel)| 是  |
|   投诉    | 删除投诉 | [client/xiaoqu/report/delete](#client/xiaoqu/report/delete)| 是  |
|   邻里    | 话题列表 | [client/xiaoqu/tieba/items](#client/xiaoqu/tieba/items)| 否  |
|   邻里    | 话题详情 | [client/xiaoqu/tieba/detail](#client/xiaoqu/tieba/detail)| 否  |
|   邻里    | 回复列表 | [client/xiaoqu/tieba/replyItems](#client/xiaoqu/tieba/replyItems)| 否  |
|   邻里    | 发表话题 | [client/xiaoqu/tieba/create](#client/xiaoqu/tieba/create)| 是  |
|   邻里    | 回复话题 | [client/xiaoqu/tieba/reply](#client/xiaoqu/tieba/reply)| 是  |
|   邻里    | 话题点赞 | [client/xiaoqu/tieba/like](#client/xiaoqu/tieba/like)| 是  |
|   缴费    | 账单记录 | [client/xiaoqu/bill/items](#client/xiaoqu/bill/items)| 是  |
|   缴费    | 账单详情 | [client/xiaoqu/bill/detail](#client/xiaoqu/bill/detail)| 是  |
|   缴费    | 账单支付 | [client/payment/yzbill](#client/payment/yzbill)| 是  |



<br />
************
######<a name="client/xiaoqu/index">社区首页(client/xiaoqu/index)</a>
>>请求参数
>>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| xiaoqu_id | 是 | int |  小区ID  |
>>请求示例
>
```javascript
{
	"xiaoqu_id" : "1",
}
```
>>返回数据
>>
| 参数名称 | 类型 |描述 |
|--------|:---------:|------|
| xiaoqu | object |  小区  |
| yezhu | object |  业主  |
| items | array |  推荐商户   [订单商品字典](#table.shop_waimai) |
| banner_list | array |  轮播图片  |
| nav_list | array |  导航图标  |
| banner_list | array |  轮播图片  |
| news_list | array |  小区公告  |
>

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
    	'items':
        [
            {
                "shop_id": "506272",
                "title": "苏果超市",
                "logo": "photo/demo/20151216_4056263163FC9F573FDE5BCC527E781E.jpeg",
                "addr": "合肥市蜀山区望江西路218号港汇广场B区商业D幢306室",
                "orders": "15",
                "comments": "14",
                "score": "60",
                "first_amount": "12.00",
                "freight": "4",
                "pei_time": "25",
                "online_pay": "1",
                "lat": "31.822311",
                "lng": "117.226577",
                "youhui_title": "",
                "avg_score": "4.29",
                "first_amount_title": "新用户首单立减￥12.00",
                "online_pay_title": "商户支持在线支付",
                "juli_label": "3.32km"
            },
            {
                "shop_id": "1",
                "title": "江湖",
                "logo": "photo/201602/20160203_13E697B669327267679F1CE152ADE9AE.jpg",
                "addr": "望江西路合作化南路交口五彩国际908室",
                "orders": "2",
                "comments": "0",
                "score": "0",
                "first_amount": "5.00",
                "freight": "2",
                "pei_time": "35",
                "online_pay": "1",
                "lat": "31.836360",
                "lng": "117.256634",
                "youhui_title": "满50减5,满40减4,满30减3,满20减2",
                "first_amount_title": "新用户首单立减￥5.00",
                "online_pay_title": "商户支持在线支付",
                "juli_label": "100.52m"
            }
        ]
		"banner_list" :
        [
        	{
            	"banner_id" : "1",
                "title" : "广告标题",
                "photo" : "photo/201608/20160810_1111.png",
                "url" : "http://www.ijh.cc"
            },
        	{
            	"banner_id" : "2",
                "title" : "广告标题",
                "photo" : "photo/201608/20160810_1111.png",
                "url" : "http://www.ijh.cc"
            }
        ]
        "adv_list" :
        [
          {
            "item_id": "2",
            "title": "广告标题",
            "link": "http://www.ijh.cc",
            "thumb": "photo\\/201603\\/20160307_4281486953C08BA9AA8637D3057F1225.png"
          },
          {
            "item_id": "2",
            "title": "广告标题",
            "link": "http://www.ijh.cc",
            "thumb": "photo\\/201512\\/20151204_885969EE8E9E55825AD69819F2F8207E.png"
          },
          {
            "item_id": "2",
            "title": "广告标题",
            "link": "http://www.ijh.cc",
            "thumb": "photo/201602/20160201_1ADCEA05FB72426B3F1D9B2456C0A151.png"
          }
        ],
        "nav_list" :
        [
            {
                "item_id": "438",
                "title": "外卖",
                "link": "waimai",
                "thumb": "photo/201603/20160324_541830033C995AD8D1DE9418405AD853.png"
            },
            {
                "item_id": "445",
                "title": "缴费",
                "link": "xiaoqu/tieba",
                "thumb": "photo/201607/20160707_2889D2BE8D3052BB03856F7957494EB1.png"
            },
            {
                "item_id": "441",
                "title": "跑腿",
                "link": "paotui",
                "thumb": "photo/201603/20160307_6D77E880788BF559F9D30F793BA8CB19.png"
            }
        ]
    }
}
```

<br />
************
######<a name="client/xiaoqu/apply">申请开通小区(client/xiaoqu/apply)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| city_id | 是 | int |  城市ID  |
| title | 是 | string |  小区名称  |
| contact | 是 | string |  联系人  |
| mobile | 是 | string |  联系电话  |
>>请求示例
>
```javascript
{
	"city_id" : "1",
    "title" : "华润五彩国际",
    "contact" : "游医",
    "mobile" : "13888888888"
}
```
>>返回示例
>
| 参数名称 | 类型 |描述 |
|--------|:-------:|------|
| apply_id | int |  申请ID  |
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
          "apply_id" : 1
    }
}
```


<br />
************
######<a name="client/xiaoqu/items">小区列表(client/xiaoqu/items)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| city_id | 是 | int |  城市ID  |
| key | 否 | string |  搜索关键字  |
>>请求示例
>
```javascript
{
	"city_id" : "1",
    "key" : "华润"
}
```
>>返回示例
>
| 参数名称 | 类型 |描述 |
|--------|:-------:|------|
| xiaoqu_id | int |  小区ID  |
| title | string | 小区 |
| city_id | int |  城市ID  |
| city_name | string | 城市名称  |
| area_id | int |  区县ID  |
| area_name | string |  区县  |
| addr | string |  地址  |
| lng | string | 经度 |
| lat | string | 纬度 |
| phone | string | 物业电话 |
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
          "items":
          [
            {
                "xiaoqu_id" : "1",
                "title" : "华润五彩国际",
                "city_id" : "1",
                "city_name" : "合肥",
                "area_id" : "33",
				"area_name" : "蜀山区",
				"addr" : "望江路888",
				"lng" : "117.123456",
				"lat" : "31.123456"
                "phone" : "0551-64278115"
            },
            {
                "xiaoqu_id" : "2",
                "title" : "华润幸福里",
                "city_id" : "1",
                "city_name" : "合肥",
                "area_id" : "33",
				"area_name" : "蜀山区",
				"addr" : "望江路888",
				"lng" : "117.123456",
				"lat" : "31.123456"
                "phone" : "0551-64278115"
            }
          ],
		  "total_count" : "120"
    }
}
```


<br />
************
######<a name="client/xiaoqu/news/items">小区通知资讯(client/xiaoqu/news/items)</a>
>>请求参数
>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| xiaoqu_id | 是 | int | 小区ID  |
| page | 否 | int |  页码  |
>>请求示例
>
```javascript
{
	"xiaoqu_id" : "1",
    "page" : "1"
}
```
>>返回示例
>
| 参数名称 | 类型 |描述 |
|--------|:-------:|------|
| news_id | int |  商户ID  |
| from | string |  类型 `news:小区资讯,notice:通知` |
| xiaoqu_id | int |  小区ID  |
| title | string |  标题  |
| intro | string |  描述  |
| photo | string |  封面  |
| views | int |  浏览量  |
| contact | string |  业主联系人  |
| mobile | string |  联系手机号  |
| audit | int |  状态 `0:待审, 1:已审核`  |
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
          "items":
          [
            {
                "news_id" : "1",
                "xiaoqu_id" : "notice",
                "xiaoqu_id" : "1",
                "title" : "停电通知",
                "intro" : "停电通知停电通知",
                "photo" : "photo/201608/20160815_11222.jpg",
                "views" : 512,
                "link" : "http://www.ijh.cc/xiaoqu/news/detail-1.html"
            },
            {
                "news_id" : "2",
                "xiaoqu_id" : "news",
                "xiaoqu_id" : "1",
                "title" : "停电通知",
                "intro" : "停电通知停电通知",
                "photo" : "photo/201608/20160815_11222.jpg",
                "views" : 512,
                "link" : "http://www.ijh.cc/xiaoqu/news/detail-1.html"
            }
          ]
    }
}
```

<br />
************
######<a name="client/xiaoqu/yezhu/items">已入住小区(client/xiaoqu/yezhu/items)</a>
>>请求参数(无)
>>
>>返回示例
>
| 参数名称 | 类型 |描述 |
|--------|:-------:|------|
| yezhu_id | int |  商户ID  |
| xiaoqu_id | int |  小区ID  |
| xiaoqu_title | string |  小区名称  |
| house_louhao | string |  楼号  |
| house_danyuan | string |  单元  |
| house_huhao | string |  户号  |
| contact | string |  业主联系人  |
| mobile | string |  联系手机号  |
| audit | int |  状态 `0:待审, 1:已审核`  |
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
          "items":
          [
            {
                "yezhu_id" : "1",
                "xiaoqu_id" : "1",
                "xiaoqu_title" : "华润五彩国际",
                "house_louhao" : "1号楼",
                "house_danyuan" : "A座",
                "house_huhao" : "904",
                "contact" : "游医",
                "mobile" : "13888888888",
                "audit" : "1",
				"lng" : "117.123456",
				"lat" : "31.123456",
                "city_id" : 1,
                "city_name" : "合肥"
            },
            {
                "yezhu_id" : "2",
                "xiaoqu_id" : "1",
                "xiaoqu_title" : "华润五彩国际",
                "house_louhao" : "1号楼",
                "house_danyuan" : "A座",
                "house_huhao" : "905",
                "contact" : "游医",
                "mobile" : "13888888888",
                "audit" : "1",
				"lng" : "117.123456",
				"lat" : "31.123456",
                "city_id" : 1,
                "city_name" : "合肥"
            }
          ]
    }
}
```

<br />
************
######<a name="client/xiaoqu/yezhu/create">申请入住小区(client/xiaoqu/yezhu/create)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| xiaoqu_id | 是 | string |  手机号码  |
| house_louhao | 是 | string |  楼号  |
| house_danyuan | 是 | string |  单元  |
| house_huhao | 是 | string |  户号  |
| contact | 否 | string |  联系人  |
| mobile | 否 | string |  手机号  |
>>请求示例
>
```javascript
{
	"xiaoqu_id" : "1",
    "house_louhao" : "1号楼",
    "house_danyuan" : "A座",
    "house_huhao" : "904",
    "contact" : "游医",
    "mobile" : "13888888888"
}
```
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
          "yezhu_id":"1"
    }
}
```

<br />
************
######<a name="client/xiaoqu/yezhu/edit">修改入住信息(client/xiaoqu/yezhu/edit)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| house_louhao | 是 | string |  楼号  |
| house_danyuan | 是 | string |  单元  |
| house_huhao | 是 | string |  户号  |
| contact | 否 | string |  联系人  |
| mobile | 否 | string |  手机号  |
>>请求示例
>
```javascript
{
    "house_louhao" : "1号楼",
    "house_danyuan" : "A座",
    "house_huhao" : "904",
    "contact" : "游医",
    "mobile" : "13888888888"
}
```
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
          "yezhu_id":"1"
    }
}
```


<br />
************
######<a name="client/xiaoqu/yezhu/delete">删除入住信息(client/xiaoqu/yezhu/delete)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| yezhu_id | 是 | int |  业主ID  |
>>请求示例
>
```javascript
{
    "yezhu_id" : "１",
}
```
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
          "yezhu_id":"1"
    }
}
```


<br />
************
######<a name="client/xiaoqu/bianmin/items">便民信息(client/xiaoqu/bianmin/items)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| xiaoqu_id | 是 | int |  小区ID  |
| page | 否 | int |  分页  |
>>请求示例
>
```javascript
{
    "xiaoqu_id":"1",
    "page": "1",
}
```
>>返回数据
>
|  字段  | 类型 | 描述 |
|--------|:-------:|------|
| bianmin_id | int | 便民ID |
| cate_id | int | 分类ID |
| cate_title | int | 分类名 |
| xiaoqu_id | int | 小区ID |
| title | string | 商户名称 |
| intro | string | 商户介绍 |
| addr | string | 地址 |
| lat | string | 纬度 |
| lng | string | 经度 |
| phone | string | 电话 |
| views | string | 使用次数 |
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data' : {
    	"items" :
        [
            {
                "bianmin_id" : "1",
                "cate_id" : "1",
                "cate_title" : "开锁",
                "title" : "豁牙子开锁",
                "intro" : "豁牙子开锁，用牙齿开锁，用生命服务",
                "addr" : "华润五彩国际904",
                "lng" : "117.123456",
                "lat" : "31.123456",
                "phone" : "400-800-8888"
                "views" : "30"
            },
            {
                "bianmin_id" : "2",
                "cate_id" : "1",
                "cate_title" : "开锁",
                "title" : "豁牙子开锁",
                "intro" : "豁牙子开锁，用牙齿开锁，用生命服务",
                "addr" : "华润五彩国际904",
                "lng" : "117.123456",
                "lat" : "31.123456",
                "phone" : "400-800-8888"
                "views" : "30"
            }
        ]
    }
}
```

<br />
************
######<a name="client/xiaoqu/bianmin/detail">便民商户详情(client/xiaoqu/bianmin/detail)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| bianmin_id | 是 |int |  便民ID  |
>>请求示例
>
```javascript
{
    "bianmin_id":"1",
}
```
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data' : {
        "bianmin_id" : "1",
        "cate_id" : "1",
        "cate_title" : "开锁",
        "title" : "豁牙子开锁",
        "intro" : "豁牙子开锁，用牙齿开锁，用生命服务",
        "addr" : "华润五彩国际904",
        "lng" : "117.123456",
        "lat" : "31.123456",
        "phone" : "400-800-8888"
        "views" : "30"
    }
}
```

<br />
************
######<a name="client/xiaoqu/bianmin/reportType">投诉便民类型(client/xiaoqu/bianmin/reportType)</a>
>>请求参数
>>无请求参数
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data' : {
        "items": [
            "资料做假",
            "恶意骚扰，不文明用语",
            "服务态度差",
            "漫天要价",
            "随便填吧"
        ]
    }
}
```

<br />
************
######<a name="client/xiaoqu/bianmin/report">投诉便民商户(client/xiaoqu/bianmin/report)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| bianmin_id | 是 |int |  便民ID  |
| yezhu_id | 是 |int |  业主ID  |
| title | 是 |string |  标题  |
| content | 是 |string |  投诉内容  |
>>请求示例
>
```javascript
{
    "bianmin_id":"1",
    "yezhu_id" : "1",
    "title" : "服务态度差",
    "cotent" : "服务态度极差，刁蛮无理"
}
```
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data' : {
    	'report_id' : 1
    }
}
```

<br />
************
######<a name="client/xiaoqu/baoxiu/items">配送设置(client/xiaoqu/baoxiu/items)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| yezhu_id | 是 | int |  业主ID  |
| page | 否 | int |  页码  |
>>请求示例
>
```javascript
{
    "yezhu_id":"1",
    "page" : "1",
}
```
>>返回数据
>
| 字段 |  类型 |描述 |
|--------|:-------:|------|
| baoxiu_id | int | 报修ID |
| uid | int | 用户ID |
| xiaoqu_id | int | 小区ID |
| yezhu_id | int | 业主ID |,
| contact | string | 联系人 |
| mobile | string | 联系电话 |
| yuyue_time | int | 预约时间 UNIXTIME |
| content| string | 报修内容 |
| reply | string | 报修回复内容 |
| reply_time | int | 回复时间 UNIXTIME |
| tx_time | int | 最后提醒时间 UNIXTIME |
| status | int | 状态 `-1:撤销，0:待处理,1:已处理` |
| dateline| int | 上报时间 UNIXTIME |
| photos | array | 图片 |
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data' : {
    	"items" :
        [
            {
                "baoxiu_id" : 1,
                "uid" : 1,
                "xiaoqu_id" : 1,
                "yezhu_id" : 1,
                "contact" : "游医",
                "mobile" : "13888888888",
                "yuyue_time" : "1400000000"
                "content" : "电梯门打不开",
                "reply" : "",
                "reply_time" : 0,
                "tx_time" : 0
                "status" : "1"
                "dateline" : "1400000000",
                "photos" :
                [
                    "photo/201608/20160815_111.png",
                    "photo/201608/20160815_222.png",
                    "photo/201608/20160815_333.png",
                ]
            },
            {
                "baoxiu_id" : 1,
                "uid" : 1,
                "xiaoqu_id" : 1,
                "yezhu_id" : 1,
                "contact" : "游医",
                "mobile" : "13888888888",
                "yuyue_time" : "1400000000"
                "content" : "电梯门打不开",
                "reply" : "已派师傅维修",
                "reply_time" : "1410000000",
                "tx_time" : 0,
                "status" : "1"
                "dateline" : "1400000000",
                "photos" :
                [
                    "photo/201608/20160815_111.png",
                    "photo/201608/20160815_222.png",
                    "photo/201608/20160815_333.png",
                ]
            }
        ]
    }
}
```

<br />
************
######<a name="client/xiaoqu/baoxiu/create">上报维修(client/xiaoqu/baoxiu/create)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| yezhu_id | 是 | int | 业主ID |
| yuyue_date | 是 | date |  预约时间  |
| contact | 是 | string |  联系人  |
| mobile | 是 | string |  联系电话  |
| content | 是 | string |  保修内容  |
| photo1 | 否 | 文件流 |  图片  支持多张 字段为 photo1~photo5 |
>>请求示例
>
```javascript
{
    "yezhu_id" : 1,
    "yuyue_date" : "2016-08-15 12:30:00",
    "contact" : "游医",
    "mobile" : "1388888888",
    "content" : "电梯门打不开",
    "photo1" : "文件流"
}
```
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data' : {
    	'baoxiu_id' : 1
    }
}
```

<br />
************
######<a name="client/xiaoqu/baoxiu/tixing">提醒报修(client/xiaoqu/baoxiu/tixing)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| baoxiu_id | 是 | int | 报修ID |
>>请求示例
>
```javascript
{
    "baoxiu_id" : "1"
}
```
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data' : {
    	"baoxiu_id" : "1"
    }
}
```

<br />
************
######<a name="client/xiaoqu/baoxiu/cancel">撤销报修(client/xiaoqu/baoxiu/cancel)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| baoxiu_id | 是 | int | 报修ID |
>>请求示例
>
```javascript
{
    "baoxiu_id" : "1"
}
```
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data' : {
    	"baoxiu_id" : "1"
    }
}
```

<br />
************
######<a name="client/xiaoqu/baoxiu/delete">删除报修(client/xiaoqu/baoxiu/delete)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| baoxiu_id | 是 | int |  业主ID  |
>>请求示例
>
```javascript
{
    "baoxiu_id" : "１",
}
```
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
          "baoxiu_id":"1"
    }
}
```


<br />
************
######<a name="client/xiaoqu/report/items">建议投诉列表(client/xiaoqu/report/items)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| yezhu_id | 是 | int |  业主ID  |
| page | 否 | int |  页码  |
>>请求示例
>
```javascript
{
    "yezhu_id":"1",
    "page" : "1",
}
```
>>返回数据
>
| 字段 |  类型 |描述 |
|--------|:-------:|------|
| report | int | 报修ID |
| uid | int | 用户ID |
| xiaoqu_id | int | 小区ID |
| yezhu_id | int | 业主ID |,
| contact | string | 联系人 |
| mobile | string | 联系电话 |
| content| string | 投诉内容 |
| reply | string | 报修回复内容 |
| reply_time | int | 回复时间 UNIXTIME |
| tx_time | int | 最后提醒时间 UNIXTIME |
| status | int | 状态 `-1:撤销，0:待处理,1:已处理` |
| dateline| int | 上报时间 UNIXTIME |
| photos | array | 图片 |
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data' : {
    	"items" :
        [
            {
                "report_id" : 1,
                "uid" : 1,
                "xiaoqu_id" : 1,
                "yezhu_id" : 1,
                "contact" : "游医",
                "mobile" : "13888888888",
                "content" : "加强小区夜间管理，经常有外来人员在小区内晃悠",
                "reply" : "",
                "reply_time" : 0,
                "tx_time" : 0
                "status" : "1"
                "dateline" : "1400000000",
                "photos" :
                [
                    "photo/201608/20160815_111.png",
                    "photo/201608/20160815_222.png",
                    "photo/201608/20160815_333.png",
                ]
            },
            {
                "report_id" : 1,
                "uid" : 1,
                "xiaoqu_id" : 1,
                "yezhu_id" : 1,
                "contact" : "游医",
                "mobile" : "13888888888",
                "content" : "加强小区夜间管理，经常有外来人员在小区内晃悠",
                "reply" : "已增加夜间保安",
                "reply_time" : "1410000000",
                "tx_time" : 0,
                "status" : "1"
                "dateline" : "1400000000",
                "photos" :
                [
                    "photo/201608/20160815_111.png",
                    "photo/201608/20160815_222.png",
                    "photo/201608/20160815_333.png",
                ]
            }
        ]
    }
}
```

<br />
************
######<a name="client/xiaoqu/report/create">添加建议投诉(client/xiaoqu/report/create)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| yezhu_id | 是 | int | 业主ID |
| yuyue_date | 是 | date |  预约时间  |
| contact | 是 | string |  联系人  |
| mobile | 是 | string |  联系电话  |
| content | 是 | string |  保修内容  |
| photo1 | 否 | 文件流 |  图片  支持多张 字段为 photo1~photo5 |
>>请求示例
>
```javascript
{
    "yezhu_id" : 1,
    "yuyue_date" : "2016-08-15 12:30:00",
    "contact" : "游医",
    "mobile" : "1388888888",
    "content" : "楼上太吵了，请尽快处理",
    "photo1" : "文件流"
}
```
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data' : {
    	'report_id' : 1
    }
}
```

<br />
************
######<a name="client/xiaoqu/report/tixing">提醒建议投诉(client/xiaoqu/report/tixing)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| report_id | 是 | int | 报修ID |
>>请求示例
>
```javascript
{
    "report_id" : "1"
}
```
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data' : {
    	"report_id" : "1"
    }
}
```

<br />
************
######<a name="client/xiaoqu/report/cancel">撤销投诉建议(client/xiaoqu/report/cancel)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| report_id | 是 | int | 报修ID |
>>请求示例
>
```javascript
{
    "report_id" : "1"
}
```
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data' : {
    	"report_id" : "1"
    }
}
```

<br />
************
######<a name="client/xiaoqu/report/delete">删除投诉建议(client/xiaoqu/report/delete)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
|report_id | 是 | int |  反馈ID  |
>>请求示例
>
```javascript
{
    "report_id" : "１",
}
```
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
          "report_id":"1"
    }
}
```



<br />
######<a name="client/xiaoqu/tieba/items">接单(client/xiaoqu/tieba/items)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| from | 否 | string | 类型 `trade:交易, topic:话题` |
| page | 否 | int | 页码 |
>>请求示例
>
```javascript
{
    "page":"1"
}
```
>>返回数据
>
| 字段 | 类型 | 描述 |
|--------|:-------:|------|
| tieba_id | int | 话题ID |
| uid | int | UID |
| city_id | int | 城市ID |
| city_name | string | 城市 |
| xiaoqu_id | int | 小区ID |
| xiaoqu_title | string | 城市 |
| from | string | 话题类型 `topic:话题, trade:交易` |
| title | string | 标题 |
| content | string | 内容 |
| contact | string | 联系人 |
| mobile | string | 联系电话 |
| price | float | 价格 `二手交易用` |
| likes | int | 点赞数 |
| views | int | 浏览数 |
| replys | int | 回复数 |
| lng | string | 经度 |
| lat | string | 纬度 |
| lasttime | int | 最后回复时间 UNXITIME |
| dateline | int | 发表时间 UNXITIME |
| member | object | 会员 |
| photos | array | 图片 |
>
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data":{
    	"items" :
        [
            {
                "tieba_id" : 1,
                "city_id" : 1,
                "uid" : 1,
                "city_name" : "合肥",
                "xiaoqu_id" : 1,
                "xiaoqu_title" : "华润五彩国际",
                "from" : "trade",
                "title" : "9.9成新Iphone6s",
                "content" : "吐血割爱，才到手3天，全新土豪金",
                "contact" : "游医",
                "mobile" : "13888888888",
                "price" : "4500.00",
                "likes" : 180,
                "views" : 10000,
                "replys" : 20,
                "lng" : "117.123456",
                "lat" : "31.111111",
                "lasttime" : "1400000000",
                "dateline" : "1400000000",
                "member":{
                	"uid" : 1,
                    "nickname" : "游医",
                    "face" : "default/face.png"
                }
                "photos":
                [
                	"photo/201608/20160810_111.jpg",
                    "photo/201608/20160810_222.jpg"
                ]
            },
            {
                "tieba_id" : 1,
                "city_id" : 1,
                "uid" : 1,
                "city_name" : "合肥",
                "xiaoqu_id" : 1,
                "xiaoqu_title" : "华润五彩国际",
                "from" : "trade",
                "title" : "9.9成新Iphone6s",
                "content" : "吐血割爱，才到手3天，全新土豪金",
                "contact" : "游医",
                "mobile" : "13888888888",
                "price" : "4500.00",
                "likes" : 180,
                "views" : 10000,
                "replys" : 20,
                "lng" : "117.123456",
                "lat" : "31.111111",
                "lasttime" : "1400000000",
                "dateline" : "1400000000",
                "member":{
                	"uid" : 1,
                    "nickname" : "游医",
                    "face" : "default/face.png"
                }
                "photos":
                [
                	"photo/201608/20160810_111.jpg",
                    "photo/201608/20160810_222.jpg"
                ]
            }
        ]
    }
}
```

<br />
************
######<a name="client/xiaoqu/tieba/detail">开始配送(client/xiaoqu/tieba/detail)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| tieba_id | 是 | int |  话题ID  |
>>请求示例
>
```javascript
{
    "tieba_id":"11"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| tieba_id | int | 话题ID |
| city_id | int | 城市ID |
| city_name | string | 城市 |
| xiaoqu_id | int | 小区ID |
| xiaoqu_title | string | 城市 |
| from | string | 话题类型 `topic:话题, trade:交易` |
| title | string | 标题 |
| content | string | 内容 |
| contact | string | 联系人 |
| mobile | string | 联系电话 |
| price | float | 价格 `二手交易用` |
| likes | int | 点赞数 |
| views | int | 浏览数 |
| replys | int | 回复数 |
| lng | string | 经度 |
| lat | string | 纬度 |
| lasttime | int | 最后回复时间 UNXITIME |
| dateline | int | 发表时间 UNXITIME |
| photos | array | 图片 |
| reply | object | 回复评论 |
>
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data":{
    	"tieba" :{
            "tieba_id" : 1,
            "city_id" : 1,
            "city_name" : "合肥",
            "xiaoqu_id" : 1,
            "xiaoqu_title" : "华润五彩国际",
            "from" : "trade",
            "title" : "9.9成新Iphone6s",
            "content" : "吐血割爱，才到手3天，全新土豪金",
            "contact" : "游医",
            "mobile" : "13888888888",
            "price" : "4500.00",
            "likes" : 180,
            "views" : 10000,
            "replys" : 20,
            "lng" : "117.123456",
            "lat" : "31.111111",
            "lasttime" : "1400000000",
            "dateline" : "1400000000",
            "photos":
            [
                "photo/201608/20160810_111.jpg",
                "photo/201608/20160810_222.jpg"
            ]
        },
        "items" : [
            {
                "reply_id" : 10,
                "tieba_id" : 1,
                "uid" : 1,
                "member" : {
                    "uid" : 1,
                    "nickname" : "游医",
                    "face" : "default/face.png"
                },
                "at_reply_id" : 2,
                "at_uid" : 2,
                "at_member" : {
                    "uid" : 2,
                    "nickname" : "张三",
                    "face" : "default/face.png"	
                },
                "content" : "不错哦!!",
                "dateline" : "140000000"
            },
            {
                "reply_id" : 10,
                "tieba_id" : 1,
                "uid" : 1,
                "member" : {
                    "uid" : 1,
                    "nickname" : "游医",
                    "face" : "default/face.png"
                },
                "at_reply_id" : 2,
                "at_uid" : 2,
                "at_member" : {
                    "uid" : 2,
                    "nickname" : "张三",
                    "face" : "default/face.png"	
                },
                "content" : "不错哦!!",
                "dateline" : "140000000"
            }
        ]
    }
}
```

<br />
************
######<a name="client/xiaoqu/tieba/replyItems">自己配送(client/xiaoqu/tieba/replyItems)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| tieba_id | 是 | int |  话题ID  |
| page | 是 | int |  页码  |
>>请求示例
>
```javascript
{
	"tieba_id" : 1,
    "page":"2"
}
```
>>返回数据
>
| 字段 | 类型 | 描述 |
|--------|:-------:|------|
| reply_id | int | 回复ID |
| tieba_id | int | 话题ID |
| uid | int | 作者ID |
| member | object | 作者 |
| at_uid | int | 被评论的UID |
| at_member | object | 被评论用户 |
| at_reply_id | int | 回复的评论ID |
| content | string | 回复内容 |
| dateline |  int | 创建时间 UNIXTIME |
>
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data":{
        "items" : [
            {
                "reply_id" : 10,
                "tieba_id" : 1,
                "uid" : 1,
                "member" : {
                    "uid" : 1,
                    "nickname" : "游医",
                    "face" : "default/face.png"
                },
                "at_reply_id" : 2,
                "at_uid" : 2,
                "at_member" : {
                    "uid" : 2,
                    "nickname" : "张三",
                    "face" : "default/face.png"	
                },
                "content" : "不错哦!!",
                "dateline" : "140000000"
            },
            {
                "reply_id" : 10,
                "tieba_id" : 1,
                "uid" : 1,
                "member" : {
                    "uid" : 1,
                    "nickname" : "游医",
                    "face" : "default/face.png"
                },
                "at_reply_id" : 2,
                "at_uid" : 2,
                "at_member" : {
                    "uid" : 2,
                    "nickname" : "张三",
                    "face" : "default/face.png"	
                },
                "content" : "不错哦!!",
                "dateline" : "140000000"
            }
        ],
        "total_count" : 200
    }
}
```

<br />
************
######<a name="client/xiaoqu/tieba/create">发表话题(client/xiaoqu/tieba/create)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| city_id | 否 | int |  城市ID  |
| xiaoqu_id | 否 | int |  小区ID  |
| from | 是 | string |  类型 `topic:话题, trade:交易`  |
| title | 否 | string |  标题  |
| content | 是 | string |  内容  |
| contact | 否 | string |  联系人  |
| mobile | 否 | string |  联系电话  |
| price | 否 | float |  价格  |
| lng | 否 | string |  经度  |
| lat | 否 | string |  纬度  |
>>请求示例
>
```javascript
{
    "xiaoqu_id" : "11",
    "from" : "trade",
    "title" : "9.9成新Iphone吐血转让",
    "content" : "成色好，价格便宜",
    "contact" : "游医",
    "mobile" : "联系电话",
    "price" : "价格",
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| reply_id | int | 回复ID |
>
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data":{
    	"reply_id" : "33"
    }
}
```

<br />
************
######<a name="client/xiaoqu/tieba/reply">回复话题(client/xiaoqu/tieba/reply)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| tieba_id | 是 | int |  话题ID  |
| content | 是 | string |  内容  |
| at_reply_id | 否 | int |  被评论的ID  |
>>请求示例
>
```javascript
{
    "tieba_id" : "11",
    "content" : "不错哦!!",
    "at_reply_id" : "21"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| reply_id | int | 回复ID |
>
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data":{
    	"reply_id" : "33"
    }
}
```

<br />
************
######<a name="client/xiaoqu/tieba/like">话题点赞(client/xiaoqu/tieba/like)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| tieba_id | 是 | int |  话题ID  |
>>请求示例
>
```javascript
{
    "tieba_id" : "1"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| tieba_id | int | 话题ID |
>
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data":{
    	"tieba_id" : "33",
        "likes" : 120
    }
}
```


<br />
************
######<a name="client/xiaoqu/bill/items">账单列表(client/xiaoqu/bill/items)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| yezhu_id | 是 | int |  业主ID  |
| page | 是 | int |  页码  |
>>请求示例
>
```javascript
{
	"yezhu_id" : 1,
    "page":"2"
}
```
>>返回数据
>
| 字段 | 类型 | 描述 |
|--------|:-------:|------|
| bill_id | int | 账单ID |
| yezhu_id | int | 业主ID |
| uid | int | UID |
| total_price | float | 账单金额 `总金额，即实际要支持的金额` |
| wuye_price | float | 物业费 |
| chewei_price | float | 停车费 |
| shui_price | float | 水费 |
| dian_price | float | 电费 |
| ranqi_price | float | 燃气费 |
| pay_status | int | 支付状态 `0:未支付, 1:已支付` |
| pay_code | string | 支付方式 `money,wxpay,alipay` |
| pay_time | int | 支付时间 |
| dateline | int | 账单创建时间 |
| xiaoqu_title | string | 小区名 |
| yezhu_name | string | 业主名 |
| yezhu_house | string | 业主住址 |
| wuye_title | string | 物业名称 |
>
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data":{
        "items" : [
            {
                "bill_id" : 10,
                "yezhu_id" : 1,
                "uid" : 1,
                "bill_sn" : "201608",
                "total_price" : "500.00",
                "wuye_price" : "100.00",
                "chewei_price" : "100.00",
                "shui_price" : "100.00",
                "dian_price" : "100.00",
                "ranqi_price" : "100.00",
                "pay_status" : 0,
                "pay_code" : "",
                "pay_time" : 0,
                "dateline" : "140000000",
                "xiaoqu_title" : "华润五彩国际",
                "yezhu_name" : "游医",
                "yezhu_house" : "A座904室",
                "wuye_title" : "华润置地",
                "bill_title" : "2016年8月账单"
            },
            {
                "bill_id" : 11,
                "yezhu_id" : 1,
                "uid" : 1,
                "bill_sn" : "201607",
                "total_price" : "500.00",
                "wuye_price" : "100.00",
                "chewei_price" : "100.00",
                "shui_price" : "100.00",
                "dian_price" : "100.00",
                "ranqi_price" : "100.00",
                "pay_status" : 1,
                "pay_code" : "weixin",
                "pay_time" : 1400000000,
                "dateline" : "140000000",
                "xiaoqu_title" : "华润五彩国际",
                "yezhu_name" : "游医",
                "yezhu_house" : "A座904室",
                "wuye_title" : "华润置地",
                "bill_title" : "2016年8月账单"
            }
        ],
        "total_count" : 200
    }
}
```

<br />
************
######<a name="client/xiaoqu/bill/detail">账单详情(client/xiaoqu/bill/detail)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| bill_id | 是 | int |  账单ID  |
>>请求示例
>
```javascript
{
	"bill_id" : 1,
}
```
>>返回数据
>
| 字段 | 类型 | 描述 |
|--------|:-------:|------|
| bill_id | int | 账单ID |
| yezhu_id | int | 业主ID |
| uid | int | UID |
| total_price | float | 账单金额 `总金额，即实际要支持的金额` |
| wuye_price | float | 物业费 |
| chewei_price | float | 停车费 |
| shui_price | float | 水费 |
| dian_price | float | 电费 |
| ranqi_price | float | 燃气费 |
| pay_status | int | 支付状态 `0:未支付, 1:已支付` |
| pay_code | string | 支付方式 `money,wxpay,alipay` |
| pay_time | int | 支付时间 |
| dateline | int | 账单创建时间 |
| xiaoqu_title | string | 小区名 |
| yezhu_name | string | 业主名 |
| yezhu_house | string | 业主住址 |
| wuye_title | string | 物业名称 |
| bill_title | string | 账单标题 |
>
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data":{
        "bill_id" : 11,
        "yezhu_id" : 1,
        "uid" : 1,
        "bill_sn" : "201607",
        "total_price" : "500.00",
        "wuye_price" : "100.00",
        "chewei_price" : "100.00",
        "shui_price" : "100.00",
        "dian_price" : "100.00",
        "ranqi_price" : "100.00",
        "pay_status" : 1,
        "pay_code" : "weixin",
        "pay_time" : 1400000000,
        "dateline" : "140000000",
        "xiaoqu_title" : "华润五彩国际",
        "yezhu_name" : "游医",
        "yezhu_house" : "A座904室",
        "wuye_title" : "华润置地",
        "bill_title" : "2016年8月账单"
    }
}
```


<br />
######<a name="client/payment/yzbill">物业账单订单(client/payment/yzbill)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| order_id | 是 | int |  订单ID 同账单ID(bill_id) |
| code | 是 | string |  支付接口 `alipay, wxpay, money` |

>>请求示例
>
```javascript
{
    "order_id" : "123",
    "code" : "wxpay"
}
```
>>支付宝支付返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| partner	| string | 签约的支付宝账号对应的支付宝唯一用户号|
| seller_id | string | 卖家支付宝账号 |
| service	| string | 接口名称，固定值	`mobile.securitypay.pay`|
| out_trade_no | string | 商户网站唯一订单号 |
| payment_type | string | 支付类型。默认值为：1（商品购买）|
| total_fee | float | 该笔订单的资金总额|
| subject | string | 商品名称 商品的标题/交易标题/订单标题/订单关键字等 |
| body | string | 商品详情 |
| notify_url | url |服务器异步通知页面路径 |
| _input_charset | string | 商户网站使用的编码格式，固定为utf-8|
| sign_type | string | 签名类型，目前仅支持RSA|
| sign | string | 支付宝签名|

>>返回示例
>
```javascript
{
	'error':'0',
	'message':'success',
    "data":{
        "partner" : "8888888888",
        "seller_id" : "ijianghu@qq.com",
        "out_trade_no" : "1511118888",
        "subject" : "游医江湖外卖订单",
        "body" : "游医江湖外卖订单(游医:13888888888,华润五彩国际904)",
        "total_fee":"38.00",
        "notify_url":"http://shequ.o2o.ijh.cc/trade/payment/notify-alipay.html",
        "service" : "mobile.securitypay.pay",
        "payment_type": "1",
        "_input_charset" : "utf-8",
        "sign_type" : "RSA",
        "sign" : "lBBK%2F0w5LOajrMrjiksLdw%2Ba3JnfHXoXuet6XNNHtn7VE%2BeCoRO1O%2BR1KugLrQEZMtG5jmJI"
    }
}
```
>>微信支付返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| appid | string | 微信分配的公众账号ID |
| partnerid | string| 微信支付分配的商户号 |
| prepayid | string| 微信返回的支付交易会话ID |
| package| string | 固定值Sign=WXPay |
| noncestr | string| 随机字符串，不长于32位。推荐随机数生成算法 |
| timestamp | string| 时间戳，请见接口规则-参数规定 |
| sign | string | 签名 |
>
>>微信支付返回示例
>
```javascript
{
	"error" : "0",
    "message" : "success",
    "data" : {
        "appid" : "wx8888888888888888"，
        "partnerid" : "1900000109",
        "prepayid" : "WX1217752501201407033233368018",
        "package" : "Sign=WXPay",
        "noncestr" : "5K8264ILTKCH16CQ2502SI8ZNMTM67VS",
        "timestamp" : "1412000000",
        "sign" : "C380BEC2BFD727A4B6845133519F3AD6"
    }
}
```
>
>>余额支付返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| order_id | int | 订单ID |
| trade_no | int| 支付订单号 |
| amount | float| 支付金额 |
>>余额支付返回示例
>
```javascript
{
	"error" : "0",
    "message" : "success",
    "data" : {
        "order_id" : "11"，
        "trade_no" : "201511111234",
        "amount" : "28.00"
    }
}
```


<br /><br /><br /><br /><br /><br />
*************************************
###数据字典对照表

<br>
><a name="table.shop_waimai">外卖商户字典</a>
>
| 字段 |  类型 |描述 |
|--------|:-------:|------|
| shop_id | int |  商户ID  |
| city_id | int |  城市ID  |
| city_name | string |  城市  |
| cate_id | int |  分类ID  |
| cate_name | string |  分类  |
| title | string |  商户名称  |
| logo | string |  商户LOGO  |
| banner | string |  商户Banner  |
| declare | string |  商家公告  |
| addr | string |  商户地址  |
| lat | string |  坐标纬度  |
| lng | string |  坐标经度  |
| addr | string |  地址  |
| views | int |  浏览量   |
| orders | int |  订单量   |
| comments | int |  评论数   |
| praise_num | int |  好评数   |
| score | int |  综合总评分，星星可以除以评论数  |
| score_fuwu | int |  服务评分，星星可以除以评论数  |
| score_kouwei | int |  口味评分，星星可以除以评论数  |
| pei_time | int |  平均配送时间   |
| min_amount | float |  起送价  |
| first_amount | float |  首单优惠  |
| youhui | array |  满减优惠  |
| youhui_title | string |  满减优惠格式化后的字符串  |
| pei_distance | float |  配送距离 单位KM  |
| freight | float |  配送费  |
| freight_stage | array |  配送费配置  |
| freight_price | float |  配送费根据距离算出的结果，如果没有给坐标直接返回最低的运费  |
| pei_type | int |  默认配送方式 `0:商户送,1:平台送,2:三方代购`  |
| pei_amount | float |  付给配送员的费用  |
| yy_status | int |  营业状态 `0:打烊，1：营业中,2：繁忙 ` |
| yy_stime | time |  开始营业时间 |
| yy_ltime | time |  结束营业时间 |
| is_new | int |  是否新点 `0:否, 1:是` |
| online_pay | time |  结束营业时间 |
| verify_name | int |  店铺认证 `0:未认证, 1:已认证` |
| tmpl_type | string |  店铺模板 `waimai:外卖店铺, market:商超` |
| info | string |  店铺简介 |
| is_daofu | int |  是否可以货到付款 0:不支持, 1:支持` |
| is_ziti | int |  是否可以自提 0:不支持, 1:支持` |
| is_ziti | int |  是否可以自提 0:不支持, 1:支持` |



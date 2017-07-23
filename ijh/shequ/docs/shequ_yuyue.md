商户端API接口文档
==============

| 分组 | 接口 | API |登录权限 |
|:-----------:|------------------|------------------ |:--------------:|
|   订座    | 订座下单 | [client/yuyue/dingzuo/create](#client/yuyue/dingzuo/create)	|  否  |
|   订座    | 订座列表 | [client/yuyue/dingzuo/items](#client/yuyue/dingzuo/items)	|  是  |
|   订座    | 订做详情 | [client/yuyue/dingzuo/detail](#client/yuyue/dingzuo/detail)	|  是  |
|   订座    | 取消订座 | [client/yuyue/dingzuo/cancel](#client/yuyue/dingzuo/cancel)	|  是  |
|   订座    | 删除订座 | [client/yuyue/dingzuo/delete](#client/yuyue/dingzuo/delete)	|  是  |
|   订座    | 检测订座 | [client/yuyue/dingzuo/checkdingzuo](#client/yuyue/dingzuo/checkdingzuo)	|  是  |
|   排队    | 取消理由 | [client/yuyue/dingzuo/cancelreason](#client/yuyue/dingzuo/cancelreason)	|  否  |
|   排队    | 排队下单 | [client/yuyue/paidui/create](#client/yuyue/paidui/create)	|  否  |
|   排队    | 排队列表 | [client/yuyue/paidui/items](#client/yuyue/paidui/items)	    |  是  |
|   排队    | 排队详情 | [client/yuyue/paidui/detail](#client/yuyue/paidui/detail)	|  是  |
|   排队    | 排队订座 | [client/yuyue/paidui/cancel](#client/yuyue/paidui/cancel)	|  是  |
|   排队    | 删除订座 | [client/yuyue/paidui/delete](#client/yuyue/paidui/delete)	|  是  |
|   排队    | 检测订座 | [client/yuyue/paidui/checkpaidui](#client/yuyue/paidui/checkpaidui)	|  是  |
|   排队    | 取消理由 | [client/yuyue/paidui/cancelreason](#client/yuyue/paidui/cancelreason)	|  否  |
<br />
************
######<a name="client/yuyue/dingzuo/create">订座下单(client/yuyue/dingzuo/create)</a>
>>请求参数
>>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| shop_id | 是 | int |  商户ID  |
| yuyue_time | 是 | datetime |  预定来店时间  |
| dingzuo_number | 是 | int |  就餐人数  |
| is_baoxiang | 否 | int |  是否需要包厢  |
| contact | 是 | string |  联系人  |
| mobile | 是 | string |  手机号  |
| notice | 否 | string |  预定备注  |
>>请求示例
>
```javascript
{
	"shop_id" : "1",
    "yuyue_time" : "2016-10-08 18:00",
    "dingzuo_number" : "10",
    "is_baoxiang" : "1",
    "contact" : "游医",
    "mobile" : "1388888888",
    "notice" : "订单备注"
}
```
>>返回数据
>>
| 参数名称 | 类型 |描述 |
|--------|:---------:|------|
| dingzuo_id | int |  订座ID  |
>

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
		"dingzuo_id" : "1"
    }
}
```


<br />
************
######<a name="client/yuyue/dingzuo/items">订座列表(client/yuyue/dingzuo/items)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| page | 否 | int |  页码  |
>>请求示例
>
```javascript
{
	"page" : "1"
}
```
>>返回示例
>
| 参数名称 | 类型 |描述 |
|--------|:-------:|------|
| dingzuo_id | int |  订座ID  |
| city_id | int |  城市ID  |
| shop_id | int |  商户ID  |
| uid     | int |  用户ID  |
| order_status | int |  订单状态 `0:待处理, 1:已经完成，-1:已取消`  |
| contact | string |  联系人  |
| mobile | string |  手机号  |
| notice | string |  订单备注  |
| yuyue_time | datetime |  预约时间 UNIXTIME时间  |
| yuyue_number | int |  就餐人数  |
| is_baoxiang | string |  是否包厢 `0:不定，1：包厢` |
| dateline | int |  下单时间 UNIXTIME时间 |
| order_status_label | string | 状态label `待接单, 已取消, 已完成` |
| shop_detail | object | 商户信息 |
| zhuohao_detail | object | 桌号信息 |
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
          "items":
          [
            {
                "dingzuo_id": 1,
                "city_id" : 1,
                "shop_id" : 1,
                "uid" : 1,
                "order_status": 0,
                "contact" : '游医',
                "mobile" : '1388888888',
                "zhuohao_id" : 1,
                "yuyue_time" : '1400000000',
                "yuyue_number" : 10,
                "is_baoxiang" : 1,
                "notice" : "备注",
                "dateline" : 1400000000,
                "order_status_label" : "待接单",
                "shop_detail" : {
                    "shop_id" : 1,
                    "title" : "江湖餐厅",
                    "addr" : "华润五彩国际904",
                    "lng" : "177.123456",
                    "lat" : "31.123456",
                    "phone" : "0551-64278115"
                },
                "zhuohao_detail" : {
                    "zhuohao_id" : 1,
                    "title" : "至尊VIP888"
                }
            },
            {
                "dingzuo_id": 1,
                "city_id" : 1,
                "shop_id" : 1,
                "uid" : 1,
                "order_status": 0,
                "contact" : '游医',
                "mobile" : '1388888888',
                "zhuohao_id" : 1,
                "yuyue_time" : '1400000000',
                "yuyue_number" : 10,
                "is_baoxiang" : 1,
                "notice" : "备注",
                "dateline" : 1400000000,
                "order_status_label" : "待接单",
                "shop_detail" : {
                    "shop_id" : 1,
                    "title" : "江湖餐厅",
                    "addr" : "华润五彩国际904",
                    "lng" : "177.123456",
                    "lat" : "31.123456",
                    "phone" : "0551-64278115"
                },
                "zhuohao_detail" : {
                    "zhuohao_id" : 1,
                    "title" : "至尊VIP888"
                }
            }
          ],
		  "total_count" : "120"
    }
}
```

<br />
************
######<a name="client/yuyue/dingzuo/detail">订座详情(client/yuyue/dingzuo/detail)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| dingzuo_id | 是 | int |  订座ID  |
>>请求示例
>
```javascript
{
	"dingzuo_id" : "1"
}
```
>>返回示例
>
| 参数名称 | 类型 |描述 |
|--------|:-------:|------|
| dingzuo_id | int |  订座ID  |
| city_id | int |  城市ID  |
| shop_id | int |  商户ID  |
| uid     | int |  用户ID  |
| order_status | int |  订单状态 `0:待处理, 1:已经完成，-1:已取消`  |
| contact | string |  联系人  |
| mobile | string |  手机号  |
| notice | string |  订单备注  |
| yuyue_time | datetime |  预约时间 UNIXTIME时间  |
| yuyue_number | int |  就餐人数  |
| is_baoxiang | string |  是否包厢 `0:不定，1：包厢` |
| dateline | int |  下单时间 UNIXTIME时间 |
| order_status_label | string | 状态label `待接单, 已取消, 已完成` |
| shop_detail | object | 商户信息 |
| zhuohao_detail | object | 桌号信息 |
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
            "dingzuo_id": 1,
            "city_id" : 1,
            "shop_id" : 1,
            "uid" : 1,
            "order_status": 0,
            "contact" : '游医',
            "mobile" : '1388888888',
            "zhuohao_id" : 1,
            "yuyue_time" : '1400000000',
            "yuyue_number" : 10,
            "is_baoxiang" : 1,
            "notice" : "备注",
            "dateline" : 1400000000,
            "order_status_label" : "待接单",
            "shop_detail" : {
                "shop_id" : 1,
                "title" : "江湖餐厅",
                "addr" : "华润五彩国际904",
                "lng" : "177.123456",
                "lat" : "31.123456",
                "phone" : "0551-64278115"
            },
            "zhuohao_detail" : {
                "zhuohao_id" : 1,
                "title" : "至尊VIP888"
            }
    }
}
```

<br />
************
######<a name="client/yuyue/dingzuo/cancel">取消订座(client/yuyue/dingzuo/create)</a>
>>请求参数
>>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| dignzuo_id | 是 | int | 排队ID  |
| reason | 是 | string | 取消理由  |
>>请求示例
>
```javascript
{
	"dignzuo_id" : "1",
    "reason" : "需要理由吗"
}
>>返回数据
>>
| 参数名称 | 类型 |描述 |
|--------|:---------:|------|
| dingzuo_id | int |  订座ID  |
>

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
		"dingzuo_id" : "1"
    }
}
```

<br />
************
######<a name="client/yuyue/dingzuo/delete">删除订座(client/yuyue/dingzuo/delete)</a>
>>请求参数
>>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| dignzuo_id | 是 | int | 订座ID  |
>>请求示例
>
```javascript
{
	"dingzuo_id" : "1"
}
```
>>返回数据
>>
| 参数名称 | 类型 |描述 |
|--------|:---------:|------|
| dingzuo_id | int |  订座ID  |
>

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
		"dingzuo_id" : "1"
    }
}
```

<br />
************
######<a name="client/yuyue/dingzuo/checkdingzuo">检测订座(client/yuyue/dingzuo/checkdingzuo)</a>
>>请求参数
>>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| shop_id | 是 | int | 订座ID  |
>>请求示例
>
```javascript
{
	"shop_id" : "1"
}
```
>>返回数据
>>
| 参数名称 | 类型 |描述 |
|--------|:---------:|------|
| dingzuo_id | int |  订座ID  `0:表示没有处理中的订座,大于0即处理中订座的ID` |
>

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
		"dingzuo_id" : "1"
    }
}
```

<br />
************
######<a name="client/yuyue/dingzuo/cancelreason">取消理由(client/yuyue/dingzuo/cancelreason)</a>
>>请求参数(无)
>
>>返回数据
>>
| 参数名称 | 类型 |描述 |
|--------|:---------:|------|
| items | array | 理由数组 |
>

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
		"items" : ["改时间了", "不需要了", "订错了", "临时有事", "任性取消"]
    }
}
```


<br />
************
######<a name="client/yuyue/paidui/create">排队取号(client/yuyue/paidui/create)</a>
>>请求参数
>>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| shop_id | 是 | int |  商户ID  |
| paidui_number | 是 | int |  就餐人数  |
| contact | 是 | string |  联系人  |
| mobile | 是 | string |  手机号  |
>>请求示例
>
```javascript
{
	"shop_id" : "1",
    "paitui_number" : "10",
    "contact" : "游医",
    "mobile" : "1388888888"
}
```
>>返回数据
>>
| 参数名称 | 类型 |描述 |
|--------|:---------:|------|
| paidui_id | int |  排队ID  |
>

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
		"paidui_id" : "1"
    }
}
```


<br />
************
######<a name="client/yuyue/paidui/items">排队列表(client/yuyue/paidui/items)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| page | 否 | int |  页码  |
>>请求示例
>
```javascript
{
	"page" : "1"
}
```
>>返回示例
>
| 参数名称 | 类型 |描述 |
|--------|:-------:|------|
| paidui_id | int |  排队ID  |
| city_id | int |  城市ID  |
| shop_id | int |  商户ID  |
| uid     | int |  用户ID  |
| order_status | int |  订单状态 `0:待处理, 1:已经完成，-1:已取消`  |
| contact | string |  联系人  |
| mobile | string |  手机号  |
| wait_time | datetime |  预计时间  |
| paidui_number | int |  就餐人数  |
| dateline | int |  下单时间 UNIXTIME时间 |
| order_status_label | string | 状态label `排队中, 已取消, 已完成` |
| shop_detail | object | 商户信息 |
| zhuohao_detail | object | 桌号信息 |
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
          "items":
          [
            {
                "paidui_id": 1,
                "city_id" : 1,
                "shop_id" : 1,
                "uid" : 1,
                "order_status": 0,
                "contact" : '游医',
                "mobile" : '1388888888',
                "zhuohao_id" : 1,
                "wait_time" : '1400000000',
                "paidui_number" : 10,
                "dateline" : 1400000000,
                "order_status_label" : "排队中",
                "shop_detail" : {
                    "shop_id" : 1,
                    "title" : "江湖餐厅",
                    "addr" : "华润五彩国际904",
                    "lng" : "177.123456",
                    "lat" : "31.123456",
                    "phone" : "0551-64278115"
                },
                "zhuohao_detail" : {
                    "zhuohao_id" : 1,
                    "title" : "至尊VIP888"
                }
            },
            {
                "paidui_id": 2,
                "city_id" : 1,
                "shop_id" : 1,
                "uid" : 1,
                "order_status": 0,
                "contact" : '游医',
                "mobile" : '1388888888',
                "zhuohao_id" : 1,
                "wait_time" : '1400000000',
                "paidui_number" : 10,
                "dateline" : 1400000000,
                "order_status_label" : "排队中",
                "shop_detail" : {
                    "shop_id" : 1,
                    "title" : "江湖餐厅",
                    "addr" : "华润五彩国际904",
                    "lng" : "177.123456",
                    "lat" : "31.123456",
                    "phone" : "0551-64278115"
                },
                "zhuohao_detail" : {
                    "zhuohao_id" : 1,
                    "title" : "至尊VIP888"
                }
            }
          ],
		  "total_count" : "120"
    }
}
```

<br />
************
######<a name="client/yuyue/paidui/detail">排队详情(client/yuyue/paidui/detail)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| paidui_id | 是 | int |  排队ID  |
>>请求示例
>
```javascript
{
	"paidui_id" : "1"
}
```
>>返回示例
>
| 参数名称 | 类型 |描述 |
|--------|:-------:|------|
| paidui_id | int |  排队ID  |
| city_id | int |  城市ID  |
| shop_id | int |  商户ID  |
| uid     | int |  用户ID  |
| order_status | int |  订单状态 `0:待处理, 1:已经完成，-1:已取消`  |
| contact | string |  联系人  |
| mobile | string |  手机号  |
| wait_time | datetime |  预计时间  |
| paidui_number | int |  就餐人数  |
| dateline | int |  下单时间 UNIXTIME时间 |
| order_status_label | string | 状态label `排队中, 已取消, 已完成` |
| shop_detail | object | 商户信息 |
| zhuohao_detail | object | 桌号信息 |
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
			"paidui_id": 1,
			"city_id" : 1,
			"shop_id" : 1,
			"uid" : 1,
			"order_status": 0,
			"contact" : '游医',
			"mobile" : '1388888888',
			"zhuohao_id" : 1,
			"wait_time" : '1400000000',
			"paidui_number" : 10,
			"dateline" : 1400000000,
            "order_status_label" : "排队中",
			"shop_detail" : {
				"shop_id" : 1,
				"title" : "江湖餐厅",
				"addr" : "华润五彩国际904",
				"lng" : "177.123456",
				"lat" : "31.123456",
				"phone" : "0551-64278115"
			},
			"zhuohao_detail" : {
				"zhuohao_id" : 1,
				"title" : "至尊VIP888"
			}
    }
}
```

<br />
************
######<a name="client/yuyue/paidui/cancel">取消排队(client/yuyue/paidui/create)</a>
>>请求参数
>>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| paidui_id | 是 | int | 排队ID  |
| reason | 是 | string | 取消理由  |
>>请求示例
>
```javascript
{
	"paidui_id" : "1",
    "reason" : "需要理由吗"
}
```
>>返回数据
>>
| 参数名称 | 类型 |描述 |
|--------|:---------:|------|
| paidui_id | int |  排队ID  |
>

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
		"paidui_id" : "1"
    }
}
```


<br />
************
######<a name="client/yuyue/paidui/delete">删除订座(client/yuyue/paidui/delete)</a>
>>请求参数
>>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| paidui_id | 是 | int | 排队ID  |
>>请求示例
>
```javascript
{
	"paidui_id" : "1"
}
```
>>返回数据
>>
| 参数名称 | 类型 |描述 |
|--------|:---------:|------|
| paidui_id | int |  排队ID  |
>

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
		"paidui_id" : "1"
    }
}
```

<br />
************
######<a name="client/yuyue/paidui/checkdingzuo">检测订座(client/yuyue/paidui/checkdingzuo)</a>
>>请求参数
>>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| shop_id | 是 | int | 订座ID  |
>>请求示例
>
```javascript
{
	"shop_id" : "1"
}
```
>>返回数据
>>
| 参数名称 | 类型 |描述 |
|--------|:---------:|------|
| paidui_id | int |  订座ID  `0:表示没有处理中的排队,大于0即处理中排队的ID` |
>

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
		"paidui_id" : "1"
    }
}
```

<br />
************
######<a name="client/yuyue/paidui/cancelreason">取消理由(client/yuyue/paidui/cancelreason)</a>
>>请求参数(无)
>
>>返回数据
>>
| 参数名称 | 类型 |描述 |
|--------|:---------:|------|
| items | array | 理由数组 |
>

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
		"items" : ["改时间了", "不需要了", "订错了", "临时有事", "任性取消"]
    }
}
```

<br /><br /><br /><br />
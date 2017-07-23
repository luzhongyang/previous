商户端API接口文档
==============

| 分组 | 接口 | API |登录权限 |
|:-----------:|------------------|------------------ |:--------------:|
|   订座    | 订座列表 | [biz/yuyue/dingzuo/items](#biz/yuyue/dingzuo/items)	|  是  |
|   订座    | 订做详情 | [biz/yuyue/dingzuo/detail](#biz/yuyue/dingzuo/detail)	|  是  |
|   订座    | 取消订座 | [biz/yuyue/dingzuo/jiedan](#biz/yuyue/dingzuo/jiedan)	|  是  |
|   订座    | 订座完成 | [biz/yuyue/dingzuo/complate](#biz/yuyue/dingzuo/complate)	|  是  |
|   订座    | 取消订座 | [biz/yuyue/dingzuo/cancel](#biz/yuyue/dingzuo/cancel)	|  是  |
|   排队    | 排队列表 | [biz/yuyue/paidui/items](#biz/yuyue/paidui/items)	    |  是  |
|   排队    | 排队详情 | [biz/yuyue/paidui/detail](#biz/yuyue/paidui/detail)	|  是  |
|   排队    | 排队接单 | [biz/yuyue/paidui/jiedan](#biz/yuyue/paidui/jiedan)	|  是  |
|   排队    | 排队完成 | [biz/yuyue/paidui/complate](#biz/yuyue/paidui/complate)	|  是  |
|   排队    | 排队订座 | [biz/yuyue/paidui/cancel](#biz/yuyue/paidui/cancel)	|  是  |
|   桌号    | 桌号列表 | [biz/yuyue/zhuohao/items](#biz/yuyue/zhuohao/items)	    |  是  |
|   桌号    | 桌号详情 | [biz/yuyue/zhuohao/detail](#biz/yuyue/zhuohao/detail)	    |  是  |
|   桌号    | 添加桌号 | [biz/yuyue/zhuohao/create](#biz/yuyue/zhuohao/create)	|  是  |
|   桌号    | 修改桌号 | [biz/yuyue/zhuohao/edit](#biz/yuyue/zhuohao/edit)	|  是  |
|   桌号    | 删除桌号 | [biz/yuyue/zhuohao/delete](#biz/yuyue/zhuohao/delete)	|  是  |
|   桌号    | 分类列表 | [biz/yuyue/zhuohao/cateItems](#biz/yuyue/zhuohao/cateItems)	    |  是  |
|   桌号    | 添加分类 | [biz/yuyue/zhuohao/createCate](#biz/yuyue/zhuohao/createCate)	|  是  |
|   桌号    | 修改分类 | [biz/yuyue/zhuohao/editCate](#biz/yuyue/zhuohao/editCate)	|  是  |
|   桌号    | 删除分类 | [biz/yuyue/zhuohao/deleteCate](#biz/yuyue/zhuohao/deleteCate)	|  是  |
|   桌号    | 分类详情 | [biz/yuyue/zhuohao/cateDetail](#biz/yuyue/zhuohao/cateDetail)	|  是  |


<br />
************
######<a name="biz/yuyue/dingzuo/items">订座列表(biz/yuyue/dingzuo/items)</a>
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
######<a name="biz/yuyue/dingzuo/detail">订座详情(biz/yuyue/dingzuo/detail)</a>
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
            "zhuohao_detail" : {
                "zhuohao_id" : 1,
                "title" : "至尊VIP888"
            }
    }
}
```

<br />
************
######<a name="biz/yuyue/dingzuo/jiedan">确认接单(biz/yuyue/dingzuo/jiedan)</a>
>>请求参数
>>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| dingzuo_id | 是 | int | 订座ID  |
| zhuohao_id | 是 | int | 桌号ID  |
>>请求示例
>
```javascript
{
	"dingzuo_id" : "1",
    "zhuohao_id" : "2"
}
```
>>返回数据
>>
| 参数名称 | 类型 |描述 |
|--------|:---------:|------|
| dingzuo_id | int |  排队ID  |
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
######<a name="biz/yuyue/dingzuo/complate">确认完成(biz/yuyue/dingzuo/complate)</a>
>>请求参数
>>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| dingzuo_id | 是 | int | 订座ID  |
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
| dingzuo_id | int |  排队ID  |
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
######<a name="biz/yuyue/dingzuo/cancel">取消订座(biz/yuyue/dingzuo/create)</a>
>>请求参数
>>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| dignzuo_id | 是 | int | 排队ID  |
>>请求示例
>
```javascript
{
	"dignzuo_id" : "1",
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
######<a name="biz/yuyue/dingzuo/delete">删除订座(biz/yuyue/dingzuo/delete)</a>
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
######<a name="biz/yuyue/paidui/items">排队列表(biz/yuyue/paidui/items)</a>
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
######<a name="biz/yuyue/paidui/detail">排队详情(biz/yuyue/paidui/detail)</a>
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
			"zhuohao_detail" : {
				"zhuohao_id" : 1,
				"title" : "至尊VIP888"
			}
    }
}
```

<br />
************
######<a name="biz/yuyue/paidui/jiedan">确认接单(biz/yuyue/paidui/jiedan)</a>
>>请求参数
>>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| paidui_id | 是 | int | 排队ID  |
| zhuohao_id | 是 | int | 桌号ID  |
| wait_time | 是 | int | 预计等待时间  |
>>请求示例
>
```javascript
{
	"paidui_id" : "1",
    "zhuohao_id" : "2",
    "wait_time" : "30"
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
######<a name="biz/yuyue/paidui/complate">确认完成(biz/yuyue/paidui/complate)</a>
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
######<a name="biz/yuyue/paidui/cancel">取消排队(biz/yuyue/paidui/create)</a>
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
######<a name="biz/yuyue/paidui/delete">删除排队(biz/yuyue/paidui/delete)</a>
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
######<a name="biz/yuyue/zhuohao/create">添加桌号(biz/yuyue/zhuohao/create)</a>
>>请求参数
>>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| cate_id | 是 | int |  分类ID  |
| title | 是 | string |  桌号名称  |
| number | 是 | int |  最多可座人数  |
>>请求示例
>
```javascript
{
	"cate_id" : "1",
    "title" : "VIP888",
    "number" : "16"
}
```
>>返回数据
>>
| 参数名称 | 类型 |描述 |
|--------|:---------:|------|
| zhuohao_id | int |  桌号ID  |
>

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
		"zhuohao_id" : "1"
    }
}
```

<br />
************
######<a name="biz/yuyue/zhuohao/edit">修改桌号(biz/yuyue/zhuohao/edit)</a>
>>请求参数
>>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| zhuohao_id | 是 | int |  桌号ID  |
| cate_id | 是 | int |  分类ID  |
| title | 是 | string |  桌号名称  |
| number | 是 | int |  最多可座人数  |
>>请求示例
>
```javascript
{
	"zhuohao_id" : "1",
	"cate_id" : "1",
    "title" : "VIP888",
    "number" : "16"
}
```
>>返回数据
>>
| 参数名称 | 类型 |描述 |
|--------|:---------:|------|
| zhuohao_id | int |  桌号ID  |
>

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
		"zhuohao_id" : "1"
    }
}
```

<br />
************
######<a name="biz/yuyue/zhuohao/edit">删除桌号(biz/yuyue/zhuohao/edit)</a>
>>请求参数
>>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| zhuohao_id | 是 | int |  桌号ID  |
>>请求示例
>
```javascript
{
	"zhuohao_id" : "1"
}
```
>>返回数据
>>
| 参数名称 | 类型 |描述 |
|--------|:---------:|------|
| zhuohao_id | int |  桌号ID  |
>

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
		"zhuohao_id" : "1"
    }
}
```

<br />
************
######<a name="biz/yuyue/zhuohao/items">桌号列表(biz/yuyue/zhuohao/items)</a>
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
| zhuohao_id | int |  ID  |
| cate_id | int |  分类ID  |
| title | int |  城市ID  |
| number | object | 最多可座人数 |
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
          "items":
          [
            {
                "zhuohao_id" : 11,
                "cate_id" : "1",
                "title" : "VIP666",
                "number" : "12"
            },
            {
                "zhuohao_id" : 22,
                "cate_id" : "1",
                "title" : "VIP888",
                "number" : "16"
            },
            {
                "zhuohao_id" : 32,
                "cate_id" : "1",
                "title" : "VIP999",
                "number" : "20"
            }
          ]
    }
}
```

<br />
************
######<a name="biz/yuyue/zhuohao/detail">桌号详情(biz/yuyue/zhuohao/detail)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| zhuohao_id | 是 | int |  桌号ID  |
>>请求示例
>
```javascript
{
	"zhuohao_id" : "1"
}
```
>>返回示例
>
| 参数名称 | 类型 |描述 |
|--------|:-------:|------|
| zhuohao_id | int |  ID  |
| cate_id | int |  分类ID  |
| cate_title | string |  分类名  |
| title | string |  桌名  |
| number | int |  最多可座人数  |
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
          "zhuohao_detail":
            {
                "zhuohao_id" : 32,
                "cate_id" : "1",
                "cate_title" : "VIP",
                "title" : "VIP999",
                "number" : "20"
            }
    }
}
```

<br />
************
######<a name="biz/yuyue/zhuohao/createCate">添加分类(biz/yuyue/zhuohao/createCate)</a>
>>请求参数
>>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| title | 是 | string |  分类名称  |
>>请求示例
>
```javascript
{
    "title" : "VIP区"
}
```
>>返回数据
>>
| 参数名称 | 类型 |描述 |
|--------|:---------:|------|
| cate_id | int |  分类ID  |
>

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
		"cate_id" : "1"
    }
}
```

<br />
************
######<a name="biz/yuyue/zhuohao/editCate">修改分类(biz/yuyue/zhuohao/editCate)</a>
>>请求参数
>>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| cate_id | 是 | int |  分类ID  |
| title | 是 | string |  分类名称  |
>>请求示例
>
```javascript
{
	"cate_id" : "1",
    "title" : "VIP",
}
```
>>返回数据
>>
| 参数名称 | 类型 |描述 |
|--------|:---------:|------|
| cate_id | int |  分类ID  |
>

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
		"cate_id" : "1"
    }
}
```

<br />
************
######<a name="biz/yuyue/zhuohao/deleteCate">删除分类(biz/yuyue/zhuohao/deleteCate)</a>
>>请求参数
>>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| cate_id | 是 | int | 分类ID  |
>>请求示例
>
```javascript
{
	"cate_id" : "1"
}
```
>>返回数据
>>
| 参数名称 | 类型 |描述 |
|--------|:---------:|------|
| cate_id | int |  分类ID  |
>

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
		"cate_id" : "1"
    }
}
```

<br />
************
######<a name="biz/yuyue/zhuohao/cateItems">分类列表(biz/yuyue/zhuohao/cateItems)</a>
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
| cate_id | int |  排队ID  |
| title_id | int |  城市ID  |
| childrens | object | 桌号信息 |
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
          "items":
          [
            {
                "cate_id": 1,
                "title" : "A区",
                "childrens":[
                	{
                    	"zhuohao_id" : 1,
                        "cate_id" : "1",
                        "title" : "A68",
                        "number" : "4"
                    },
                    {
                    	"zhuohao_id" : 2,
                        "cate_id" : "1",
                        "title" : "A88",
                        "number" : "10"
                    },
                    {
                    	"zhuohao_id" : 3,
                        "cate_id" : "1",
                        "title" : "A67",
                        "number" : "4"
                    }
                ]
            },
           {
                "cate_id": 2,
                "title" : "VIP",
                "childrens":[
                	{
                    	"zhuohao_id" : 11,
                        "cate_id" : "1",
                        "title" : "VIP666",
                        "number" : "12"
                    },
                    {
                    	"zhuohao_id" : 22,
                        "cate_id" : "1",
                        "title" : "VIP888",
                        "number" : "16"
                    },
                    {
                    	"zhuohao_id" : 32,
                        "cate_id" : "1",
                        "title" : "VIP999",
                        "number" : "20"
                    }
                ]
            }
          ]
    }
}
```


<br />
************
######<a name="biz/yuyue/zhuohao/cateDetail">分类详情(biz/yuyue/zhuohao/cateDetail)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| cate_id | 是 | int |  分类ID  |
>>请求示例
>
```javascript
{
	"cate_id" : "1"
}
```
>>返回示例
>
| 参数名称 | 类型 |描述 |
|--------|:-------:|------|
| cate_id | int |  分类ID  |
| title | string |  分类名  |
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
          "cate_detail":
          {
                "cate_id": 1,
                "title" : "A区"
            }
    }
}
```

<br /><br /><br /><br />
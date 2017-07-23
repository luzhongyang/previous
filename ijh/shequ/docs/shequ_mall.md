商户端API接口文档
==============

| 分组 | 接口 | API |登录权限 |
|:-----------:|------------------|------------------ |:--------------:|
|   商城    | 商城首页 | [client/mall/product/index](#client/mall/product/index)	|  否  |
|   商城    | 商城分类 | [client/mall/product/cate](#client/mall/product/cate)	|  否  |
|   商城    | 商品列表 | [client/mall/product/items](#client/mall/product/items)	|  否  |
|   商城    | 创建订单 | [client/mall/order/create](#client/mall/order/create)	|  是  |
|   商城    | 订单列表 | [client/mall/order/items](#client/mall/order/items)| 是  |
|   商城    | 订单详情 | [client/mall/order/detail](#client/mall/order/detail)| 是  |
|   商城    | 确认订单 | [client/mall/order/confirm](#client/mall/order/confirm)| 是  |
|   商城    | 取消订单 | [client/mall/order/cancel](#client/mall/order/cancel)| 是
<br />
************
######<a name="client/mall/product/index">商城首页(client/mall/product/index)</a>
>>请求参数(无)
>
>>返回数据
>>
| 参数名称 | 类型 |描述 |
|--------|:---------:|------|
| items | array |  商品列表   [订单商品字典](#table.mall_product) |
| banner_list | array |  轮播图片  |
| nav_list | array |  分类导航  |
| banner_list | array |  轮播图片  |
>

>>返回示例
>
```javascript
{
 	error: "0",
	message: "success",
	items:
	[
		{
			product_id: "12",
			cate_id: "2",
			title: "iwatch",
			photo: "photo/201512/20151202_CC56FAA8DE5A618FABA0D20BC0CC68B0.jpg",
			jifen: "100",
			price: "10.00",
			freight: "5.00",
			info: "iwatch原价3500，现在100积分，赶紧吧",
			views: "100",
			sales: "235",
			sku: "500",
			orderby: "50",
			cate_title: "食品饮料"
		},
		{
			product_id: "13",
			cate_id: "3",
			title: "宝马",
			photo: "photo/201512/20151202_48B35DD5CEF4C18C8E633CD809ADB176.jpg",
			jifen: "100",
			price: "10.00",
			freight: "5.00",
			info: "哈哈，这个更叼，赶紧兑换吧",
			views: "2",
			sales: "155",
			sku: "987",
			orderby: "50",
			cate_title: "数码家电"
		},
		{
			product_id: "14",
			cate_id: "3",
			title: "吉列剃须刀",
			photo: "photo/201512/20151202_F6404BF5C1544C56EBC99EBC6E2079B4.jpg",
			jifen: "500",
			price: "10.00",
			freight: "5.00",
			info: "吉列剃须刀没啥多说的",
			views: "100",
			sales: "121",
			sku: "991",
			orderby: "50",
			cate_title: "数码家电"
		}
	],
	banner_list:
	[
		{
			item_id: "444",
			adv_id: "5",
			title: "广告位3",
			link: "",
			thumb: "photo/201602/20160201_1ADCEA05FB72426B3F1D9B2456C0A151.png"
		},
		{
			item_id: "443",
			adv_id: "5",
			title: "广告位2",
			link: "",
			thumb: "/photo/201602/20160201_D28744BE316093E98126602C61E720E8.png"
		},
		{
			item_id: "442",
			adv_id: "5",
			title: "广告位1",
			link: "",
			thumb: "photo/201604/20160413_2B22F55D543D712B2E1B5B45592B9FF5.png"
		}
	],
	nav_list:
		[
			{
				cate_id: "1",
				parent_id: "0",
				title: "个护美妆",
				icon: "photo/201512/20151204_7ADFF6775E81D8454FDA634238D70D32.png",
				orderby: "50"
			},
			{
				cate_id: "2",
				parent_id: "0",
				title: "食品饮料",
				icon: "photo/201512/20151204_1DAB661DF0D9B087859277D087E5441F.png",
				orderby: "50"
			},
			{
				cate_id: "3",
				parent_id: "0",
				title: "数码家电",
				icon: "photo/201512/20151204_88642A8EECC94B0B4F779A4E719AE3D2.png",
				orderby: "50"
			}
		]
	}
}
```

<br />
************
######<a name="client/mall/product/cate">商品列表(client/mall/product/cate)</a>
>>请求参数无
>
>>返回示例
>
| 参数名称 | 类型 |描述 |
|--------|:-------:|------|
| cate_id | int |  分类ID  |
| parent_id | int |  父分类ID  |
| title | string |  分类名称  |
| icon | string |  分类图标  |
| orderby | int |  排序  |
>
```javascript
{
 	error: "0",
	message: "success",
	items:
	[
        {
            cate_id: "1",
            parent_id: "0",
            title: "个护美妆",
            icon: "photo/201512/20151204_7ADFF6775E81D8454FDA634238D70D32.png",
            orderby: "50"
        },
        {
            cate_id: "2",
            parent_id: "0",
            title: "食品饮料",
            icon: "photo/201512/20151204_1DAB661DF0D9B087859277D087E5441F.png",
            orderby: "50"
        },
        {
            cate_id: "3",
            parent_id: "0",
            title: "数码家电",
            icon: "photo/201512/20151204_88642A8EECC94B0B4F779A4E719AE3D2.png",
            orderby: "50"
        }
      ]
}
```


<br />
************
######<a name="client/mall/product/items">商品列表(client/mall/product/item)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| page | 否 | int |  页码  |
| cate_id | 否 | int |  分类  |
>>请求示例
>
```javascript
{
	"page" : "1",
    "cate_id" : "2"
}
```
>>返回示例
>
| 参数名称 | 类型 |描述 |
|--------|:-------:|------|
| product_id | int |  商品ID  |
| cate_id | int |  分类ID  |
| cate_title | string |  分类名称  |
| title | string |  商品名称  |
| photo | string |  商品图片  |
| jifen | int |  商品积分  |
| price | float |  商品价格  |
| freight | float |  运费  |
| info | string |  商品介绍  |
| views | int |  浏览量  |
| sales | int |  销量  |
| sku   | int |  库存  |
| orderby | int |  排序  |
>
```javascript
{
 	error: "0",
	message: "success",
	items: 
	[
		{
			product_id: "12",
			cate_id: "2",
			title: "iwatch",
			photo: "photo/201512/20151202_CC56FAA8DE5A618FABA0D20BC0CC68B0.jpg",
			jifen: "100",
			price: "10.00",
			freight: "5.00",
			info: "iwatch原价3500，现在100积分，赶紧吧",
			views: "100",
			sales: "235",
			sku: "500",
			orderby: "50",
			cate_title: "食品饮料"
		},
		{
			product_id: "13",
			cate_id: "3",
			title: "宝马",
			photo: "photo/201512/20151202_48B35DD5CEF4C18C8E633CD809ADB176.jpg",
			jifen: "100",
			price: "10.00",
			freight: "5.00",
			info: "哈哈，这个更叼，赶紧兑换吧",
			views: "2",
			sales: "155",
			sku: "987",
			orderby: "50",
			cate_title: "数码家电"
		},
		{
			product_id: "14",
			cate_id: "3",
			title: "吉列剃须刀",
			photo: "photo/201512/20151202_F6404BF5C1544C56EBC99EBC6E2079B4.jpg",
			jifen: "500",
			price: "10.00",
			freight: "5.00",
			info: "吉列剃须刀没啥多说的",
			views: "100",
			sales: "121",
			sku: "991",
			orderby: "50",
			cate_title: "数码家电"
		}
	],
	"total_count" : 300
}
```


<br />
************
######<a name="client/mall/order/create">创建订单(client/mall/order/create)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| addr_id | 是 | int |  收获地址ID  |
| mcart | 是 | string |  购物车 `1:2,2:1, 商品ID:数量,商户ID,数量`  |
>>请求示例
>
```javascript
{
	"addr_id" : "1",
    "mcart" : "1:2,2:1"
}
```
>>返回示例
>
| 参数名称 | 类型 |描述 |
|--------|:-------:|------|
| order_id | int |  订单ID  |
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
		"order_id" :11
    }
}
```

<br />
************
######<a name="client/mall/order/items">订单列表(client/mall/order/items)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| status | 否 | int |  状态 `0:进行中， 1：已经完成`  |
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
| order_id | int | 订单号 |
| city_id | int | 城市ID |
| uid | int | 用户ID |
| from | string | 订单类型 `tuan:团购,waimai:外卖,paotui:跑腿,weixiu:维修,maidan:买单,house:家政,mall:商城` |
| order_status | int | 订单状态 `0:未处理, 3:已发货, 8:已完成` |
| pay_status | int | 支付状态 `0:未支付, 1:已支付` |
| trade_no | int | 订单编号 |
| total_price | float | 总价 |
| amount | float | 支付金额 |
| lng | string | 经度 |
| lat | string | 纬度 |
| contact | string | 联系人 |
| mobile | string | 联系电话 |
| addr | string | 地址 |
| house | string | 门牌号 |
| day | int | 下单日期 |
| intro | sting | 订单备注 |
| order_from | string | 订单来源 `ios,android,weixin` |
| wx_openid | string | 微信ID，如果是微信下单会有值 |
| pay_code |   string | 支付方式 `wxpay,alipay,money` |
| pay_time | int | 支付时间 |
| dateline | int | 下单时间 |
| lasttime | int | 订单更新时间 |
| from_name |  "商城",
| order_status_label | string | 订单状态文字 |
| order_status_warning |  string | 订单状态说明 |
| product_jifen | int | 商品总积分 |
| product_price | float | 商品总价 |
| freight | float | 运费 |
>
```javascript
{
  "error": "0",
  "message": "success",
  "data": {
    "items":
    [
        {
          "order_id": "1714",
          "city_id": "1",
          "uid": "3",
          "from": "mall",
          "order_status": "0",
          "online_pay": "1",
          "pay_status": "0",
          "trade_no": "0",
          "total_price": "34.00",
          "amount": "34.00",
          "contact": "游医",
          "mobile": "18949841200",
          "addr": "望江西路与合作化南路交叉口华润五彩城(合作化路口)",
          "house": "五彩国际904",
          "lng": "117.249223",
          "lat": "31.829986",
          "day": "20160902",
          "intro": "",
          "order_from": "ios",
          "wx_openid": "",
          "pay_code": "",
          "pay_time": "0",
          "dateline": "1472821984",
          "lasttime": "0",
          "from_name": "商城",
          "order_status_label": "已取消",
          "order_status_warning": "订单已取消",
          "product_jifen": "200",
          "product_price" : "34.00",
          "freight" : "5.00",
          "product_list": [
            {
              "pid": "1105",
              "order_id": "1714",
              "product_id": "62541911",
              "product_name": "耳机",
              "product_photo": "photo/201608/201608_xxx.jpg",
              "product_price": "12.00",
              "product_jifen": "100",
              "product_number": "1"
            },
            {
              "pid": "1106",
              "order_id": "1714",
              "product_id": "62541911",
              "product_name": "手机套",
              "product_photo": "photo/201608/201608_xxx.jpg",
              "product_price": "22.00",
              "product_jifen": "100",
              "product_number": "1"
            },
          ]
        },
        {
          "order_id": "1715",
          "city_id": "1",
          "uid": "3",
          "from": "mall",
          "order_status": "0",
          "online_pay": "1",
          "pay_status": "0",
          "trade_no": "0",
          "total_price": "34.00",
          "amount": "34.00",
          "contact": "游医",
          "mobile": "18949841200",
          "addr": "望江西路与合作化南路交叉口华润五彩城(合作化路口)",
          "house": "五彩国际904",
          "lng": "117.249223",
          "lat": "31.829986",
          "day": "20160902",
          "intro": "",
          "order_from": "ios",
          "wx_openid": "",
          "pay_code": "",
          "pay_time": "0",
          "dateline": "1472821984",
          "lasttime": "0",
          "from_name": "商城",
          "order_status_label": "已取消",
          "order_status_warning": "订单已取消",
          "product_jifen": "200",
          "product_price" : "34.00",
          "freight" : "5.00",
          "product_list": [
            {
              "pid": "1105",
              "order_id": "1714",
              "product_id": "62541911",
              "product_name": "耳机",
              "product_photo": "photo/201608/201608_xxx.jpg",
              "product_price": "12.00",
              "product_jifen": "100",
              "product_number": "1"
            },
            {
              "pid": "1106",
              "order_id": "1714",
              "product_id": "62541911",
              "product_name": "手机套",
              "product_photo": "photo/201608/201608_xxx.jpg",
              "product_price": "22.00",
              "product_jifen": "100",
              "product_number": "1"
            },
          ]
        }
    ]
  }
}
```


<br />
************
######<a name="client/mall/order/detail">订单详情(client/mall/order/detail)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| order_id | 是 | int |  订单ID  |
>>请求示例
>
```javascript
{
	"order_id" : "11"
}
```
>>返回示例
>
| 参数名称 | 类型 |描述 |
|--------|:-------:|------|
| order_id | int | 订单号 |
| city_id | int | 城市ID |
| uid | int | 用户ID |
| from | string | 订单类型 `tuan:团购,waimai:外卖,paotui:跑腿,weixiu:维修,maidan:买单,house:家政,mall:商城` |
| order_status | int | 订单状态 `0:未处理, 3:已发货, 8:已完成` |
| pay_status | int | 支付状态 `0:未支付, 1:已支付` |
| trade_no | int | 订单编号 |
| total_price | float | 总价 |
| amount | float | 支付金额 |
| lng | string | 经度 |
| lat | string | 纬度 |
| contact | string | 联系人 |
| mobile | string | 联系电话 |
| addr | string | 地址 |
| house | string | 门牌号 |
| day | int | 下单日期 |
| intro | sting | 订单备注 |
| order_from | string | 订单来源 `ios,android,weixin` |
| wx_openid | string | 微信ID，如果是微信下单会有值 |
| pay_code |   string | 支付方式 `wxpay,alipay,money` |
| pay_time | int | 支付时间 |
| dateline | int | 下单时间 |
| lasttime | int | 订单更新时间 |
| from_name |  "商城",
| order_status_label | string | 订单状态文字 |
| order_status_warning |  string | 订单状态说明 |
| product_jifen | int | 商品总积分 |
| product_price | float | 商品总价 |
| freight | float | 运费 |
>
```javascript
{
  "error": "0",
  "message": "success",
  "data": {
    "order": {
      "order_id": "1714",
      "city_id": "1",
      "uid": "3",
      "from": "mall",
      "order_status": "0",
      "online_pay": "1",
      "pay_status": "0",
      "trade_no": "0",
      "total_price": "34.00",
      "amount": "34.00",
      "contact": "游医",
      "mobile": "18949841200",
      "addr": "望江西路与合作化南路交叉口华润五彩城(合作化路口)",
      "house": "五彩国际904",
      "lng": "117.249223",
      "lat": "31.829986",
      "day": "20160902",
      "intro": "",
      "order_from": "ios",
      "wx_openid": "",
      "pay_code": "",
      "pay_time": "0",
      "dateline": "1472821984",
      "lasttime": "0",
      "from_name": "商城",
      "order_status_label": "已取消",
      "order_status_warning": "订单已取消",
      "product_jifen": "200",
	  "product_price" : "34.00",
	  "freight" : "5.00",
      "product_list": [
        {
          "pid": "1105",
          "order_id": "1714",
          "product_id": "62541911",
          "product_name": "耳机",
          "product_photo": "photo/201608/201608_xxx.jpg",
          "product_price": "12.00",
          "product_jifen": "100",
          "product_number": "1"
        },
        {
          "pid": "1106",
          "order_id": "1714",
          "product_id": "62541911",
          "product_name": "手机套",
          "product_photo": "photo/201608/201608_xxx.jpg",
          "product_price": "22.00",
          "product_jifen": "100",
          "product_number": "1"
        },
      ]
    }
  }
}
```

<br />
************
######<a name="client/mall/order/confirm">确认订单(client/mall/order/confirm)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| addr_id | 是 | int |  收获地址ID  |
>>请求示例
>
```javascript
{
	"addr_id" : "1",
}
```
>>返回示例
>
| 参数名称 | 类型 |描述 |
|--------|:-------:|------|
| order_id | 是 | int |  订单ID  |
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
		"order_id" :11
    }
}
```


<br />
************
######<a name="client/mall/order/cancel">取消订单(client/mall/order/cancel)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| order_id | 是 | int |  订单ID  |
>>请求示例
>
```javascript
{
	"addr_id" : "1",
}
```
>>返回示例
>
| 参数名称 | 类型 |描述 |
|--------|:-------:|------|
| order_id | int |  订单ID  |
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
		"order_id" :11
    }
}
```

<br /><br /><br /><br /><br /><br />
*************************************
###数据字典对照表

<br>
><a name="table.mall_product">商城商品字典</a>
>
| 参数名称 | 类型 |描述 |
|--------|:-------:|------|
| product_id | int |  商品ID  |
| cate_id | int |  分类ID  |
| cate_title | string |  分类名称  |
| title | string |  商品名称  |
| photo | string |  商品图片  |
| jifen | int |  商品积分  |
| price | float |  商品价格  |
| freight | float |  运费  |
| info | string |  商品介绍  |
| views | int |  浏览量  |
| sales | int |  销量  |
| sku   | int |  库存  |
| orderby | int |  排序  |




**江湖外卖APP API文档**
====================
接口地址: http://shequ.o2o.ijh.cc/Api.php


系统参数
参数名	= 参数值

API = 接口（如:order/detail , shop/cate 等，参见接口文档）

CLIENT_API = CUSTOM/BIZ/STAFF
接口类型：用户端/商家端/配送端

CLIENT_OS = IOS/ANDROID
接口系统 IOS/ANDROID

CLIENT_VER = "版本号" (版本号为主版本号.小版本号,如:1.01)

TOKEN = token (登录接口返回的值，如果已经登录了每次必值，未登录传空即可)
CITY_ID = 城市ID（APP启动会传城市名称 通过API得到城市ID或切换城市时获得）

业务参数
业务参数放入一个data数据组传递

**请求接口参数示列**
```javascript
{
	'API'		:'order/detail',
	'CLIENT_API': 'CUSTOM',
    'CLIENT_OS'	: 'IOS',
	'CLIENT_VAR': '1.0.0',
    'TOKEN'		: '95-A2D28B1CA20DC547425343D2ACAFE540',
    'CITY_ID'	: '7',
    'data'		: {'order_id': 33}
}
```


>**返回数据全部为JSON**
```javascript
{
    'error'=>'0',//{0:表示成功，大于0:失败，101:未登录且当前接口需要登录才有权限访问，}
    'message'=>'错误描述',
    'data'=>{业务数据}
}
```

| 参数名 |  类型          | 示例       | 说明  				  |
|-------|:--------------|:----------|:----------------------|
| error  | number   	|  0        | 0：表示成功，其它表示失败 |
| message| string       | success   | 返回错误描述   			|
| data 	 | json		    | --        | 返回的业务数据     	   |

<br /><br /><br /><br />

用户端API接口文档
==============

| <span class="w-100">分组</span> | <span class="w-200">接口</span> | <span class="w-200">API</span> |<span class="w-100">登录权限</span>|<span class="w-100">负责人</span>|
|--------|:-------:|------|
|   基础    | 短信验证码  | [magic/sendsms](#magic/sendsms) |  否  | 不限 |
|   用户端    | 城市列表  | [client/data/city](#client/data/city) |  否  | 不限 |
|   用户端/订单    | 订单列表	| [client/order/items](#client/order/items)	|  是  |
|   用户端/订单    | 订单详情	| [client/order/detail](#client/order/detail)	|  是  |
|   用户端/订单    | 取消订单	| [client/order/cancel](#client/order/cancel)	|  是  |
|   用户端/订单    | 确认送达	| [client/order/confirm](#client/order/confirm)	|  是  |
|   用户端/订单    | 订单投诉	| [client/order/complaint](#client/order/complaint)	|  是  |
|   用户端/订单    | 订单催单	| [client/order/cuidan](#client/order/cuidan)	|  是  |
|   用户端/订单    | 订单进度	| [client/order/log](#client/order/log)	|  是  |
|   用户端/会员    | 注册帐号	| [client/passport/signup](#client/passport/signup)|  否  | 吴权要 |
|   用户端/会员    | 会员登录	| [client/passport/login](#client/passport/login)|  否  | 吴权要 |
|   用户端/会员    | 找回密码	| [client/passport/forgot](#client/passport/forgot)|  否  | 吴权要 |
|   用户端/会员    | 微信登录	| [client/passport/wxlogin](#client/passport/wxlogin)  |  是  | 吴权要 |
|   用户端/会员    | 登录绑定	| [client/passport/wxbind](#client/passport/wxbind)  |  是  | 吴权要 |
|   用户端/首页    | 首页幻灯片   | [client/adv/index](#client/adv/index)|  否  | 任杰 |
|   用户端/首页    | 分类列表  | [client/data/cate](#client/data/cate)|  否  | 任杰 |
|   用户端/首页    | 广告位  | [client/adv/adv](#client/adv/adv)|  否  | 任杰 |
|   用户端/首页    | 推荐商户	| [client/shop/shopsuggest](#client/shop/shopsuggest)	 |  否  |
|   用户端/商家    | 商户分类	| [client/shop/cate](#client/shop/cate)|  否  |
|   用户端/商家    | 商户详情	| [client/shop/detail](#client/shop/detail) |  否  |
|   用户端/商家    | 评论列表 | [client/shop/comment/items](#client/shop/comment/items)|  否  |
|   用户端/商家    | 评论提交 | [client/shop/comment/commit](#client/shop/comment/commit)|  否  |
|   用户端/团购    | 团购列表	| [client/tuan/items](#client/tuan/items)	|  是  | 吴权要-夏玉峰 |
|   用户端/团购    | 团购商品列表	| [client/tuan/goods](#client/tuan/goods)	|  是  | 吴权要-夏玉峰 |
|   用户端/团购    | 团购商品详情-全部评价	| [client/tuan/comment](#client/tuan/comment)	|  是  | 吴权要-夏玉峰 |
|   用户端/团购    | 团购详情	| [client/tuan/detail](#client/tuan/detail)	|  是  | 吴权要-夏玉峰 |
|   用户端/团购    | 创建订单	| [client/tuan/order/create](#client/tuan/order/create)	|  是  | 吴权要-夏玉峰 |
|   用户端/外卖    | 外卖商户分类	| [client/waimai/shop/cate](#client/waimai/shop/cate) |  否  | 吴权要 |
|   用户端/外卖    | 外卖商户列表	| [client/waimai/shop/items](#client/waimai/shop/items) |  否  | 吴权要 |
|   用户端/外卖    | 外卖商品分类	| [client/waimai/product/cate](#client/waimai/product/cate) |  否  | 吴权要 |
|   用户端/外卖    | 外卖商品列表	| [client/waimai/product/items](#client/waimai/product/items) |  否  | 吴权要 |
|   用户端/外卖    | 评论列表 | [client/waimai/comment/items](#client/waimai/comment/items)|  否  | 吴权要 |
|   用户端/外卖    | 评论提交 | [client/waimai/comment/commit](#client/waimai/comment/commit)|  否  | 吴权要 |
|   用户端/外卖    | 创建订单	| [client/waimai/order/create](#client/waimai/order/create)	|  是  | 吴权要 |
|   用户端/家政    | 家政分类	| [client/house/cate](#client/house/cate) |  否  | 任杰 |
|   用户端/家政    | 家政地图	| [client/house/map](#client/house/map) |  否  | 任杰 |
|   用户端/家政    | 阿姨列表	| [client/house/items](#client/house/items) |  否  | 任杰 |
|   用户端/家政    | 阿姨评论	| [client/house/staffcomment](#client/house/staffcomment) |  否  | 任杰 |
|   用户端/家政    | 阿姨详情	| [client/house/staffdetail](#client/house/staffdetail) |  否  | 任杰 |
|   用户端/家政    | 分类详情  |   [client/house/detail](#client/house/detail)|  否  | 任杰 |
|   用户端/家政    | 创建订单  |   [client/house/order/create](#client/house/order/create)|  否  | 任杰 |
|   用户端/家政    | 评价订单  |   [client/house/order/commenthandle](#client/house/order/handle)|  否  | 任杰 |
|   用户端/维修    | 维修分类	| [client/weixiu/cate](#client/weixiu/cate) |  否  | 任杰 |
|   用户端/维修    | 维修地图	| [client/weixiu/map](#client/weixiu/map) |  否  | 任杰 |
|   用户端/维修    | 师傅列表	| [client/weixiu/items](#client/weixiu/items) |  否  | 任杰 |
|   用户端/家政    | 师傅评论	| [client/weixiu/staffcomment](#client/weixiu/staffcomment) |  否  | 任杰 |
|   用户端/维修    | 师傅详情	| [client/weixiu/staffdetail](#client/weixiu/staffdetail) |  否  | 任杰 |
|   用户端/维修    | 分类详情  |   [client/weixiu/detail](#client/weixiu/detail)|  否  | 任杰 |
|   用户端/维修    | 创建订单  |   [client/weixiu/order/create](#client/weixiu/order/create)|  否  | 任杰 |
|   用户端/维修    | 评价订单  |   [client/weixiu/order/commenthandle](#client/weixiu/order/handle)|  否  | 任杰 |
|   用户端/跑腿    | 跑腿地图  | [client/paotui/map](#client/paotui/map)|  否  | 任杰 |
|   用户端/跑腿    | 帮我送下单  | [client/paotui/song](#client/paotui/song)|  否  | 任杰 |
|   用户端/跑腿    | 帮我买下单  | [client/paotui/buy](#client/paotui/buy)|  否  | 任杰 |
|   用户端/跑腿    | 帮我排队  | [client/paotui/queue](#client/paotui/queue)|  否  | 任杰 |
|   用户端/跑腿    | 帮我陪护  | [client/paotui/care](#client/paotui/care)|  否  | 任杰 |
|   用户端/跑腿    | 帮我占座  | [client/paotui/seat](#client/paotui/seat)|  否  | 任杰 |
|   用户端/跑腿    | 帮我买和送的公式  | [client/paotui/price](#client/paotui/price)|  否  | 任杰 |
|   用户端/跑腿    | 代排队公式  | [client/paotui/pricequeue](#client/paotui/pricequeue)|  否  | 任杰 |
|   用户端/跑腿    | 陪护公式  | [client/paotui/pricecare](#client/paotui/pricecare)|  否  | 任杰 |
|   用户端/跑腿    | 占座公式  | [client/paotui/priceseat](#client/paotui/priceseat)|  否  | 任杰 |
|   用户端/服务    | 评论提交 | [client/staff/comment/commit](#client/staff/comment/commit)|  否  |
|   用户端/会员    | 订单列表(分类) | [client/member/order/items](#client/member/order/items)|  是  | 任杰 |
|   用户端/会员    | 订单详情 | [client/member/order/detail](#client/member/order/detail)|  是  | 任杰 |
|   用户端/会员    | 更换手机	| [client/member/updatemobile](#client/member/updatemobile)|  是  | 吴权要-夏玉峰 |
|   用户端/会员    | 上传头像	| [client/member/uploadface](#client/member/uploadface)|  是  | 吴权要-夏玉峰 |
|   用户端/会员    | 修改昵称	| [client/member/updatename](#client/member/updatename)|  是  | 吴权要-夏玉峰 |
|   用户端/会员    | 修改密码	| [client/member/passwd](#client/member/passwd) |  是  | 吴权要-夏玉峰 |
|   用户端/会员    | 会员信息	| [client/member/info](#client/member/info)	|  是  | 吴权要-夏玉峰 |
|   用户端/会员    | 绑定微信	| [client/member/bindweixin](#client/member/bindweixin)  |  是  | 吴权要-夏玉峰 |
|   用户端/会员    | 解绑微信	| [client/member/nobindweixin](#client/member/nobindweixin)  |  是  | 吴权要-夏玉峰 |
|   用户端/会员    | 会员消息	| [client/member/msg](#client/member/msg)    |  是  | 吴权要-夏玉峰 |
|   用户端/会员    | 阅读消息	| [client/member/readmsg](#client/member/readmsg)|  是  | 吴权要-夏玉峰 |
|   用户端/会员    | 我的收藏	| [client/member/collect](#client/member/collect)|  是  | 吴权要-夏玉峰 |
|   用户端/会员    | 添加收藏	| [client/member/collect/add](#client/member/collect/add)   |  是  | 吴权要-夏玉峰 |
|   用户端/会员    | 取消收藏	| [client/member/collect/cancel](#client/member/collect/cancel)|  是  | 吴权要-夏玉峰 |
|   用户端/会员    | 积分日志	| [client/member/jifen/log](#client/member/jifen/log)|  是  | 吴权要-夏玉峰 |
|   用户端/会员    | 积分规则	| [client/member/jifen/rule](#client/member/jifen/rule)|  是  | 吴权要-夏玉峰 |
|   用户端/会员    | 地址列表	| [client/member/addr](#client/member/addr)|  是  | 吴权要-夏玉峰 |
|   用户端/会员    | 添加地址	| [client/member/addr/create](#client/member/addr/create)|  是  | 吴权要-夏玉峰 |
|   用户端/会员    | 修改地址	| [client/member/addr/update](#client/member/addr/update)|  是  | 吴权要-夏玉峰 |
|   用户端/会员    | 地址详情	| [client/member/addr/detail](#client/member/addr/detail)|  是  | 吴权要-夏玉峰 |
|   用户端/会员    | 删除地址	| [client/member/addr/delete](#client/member/addr/delete)|  是  | 吴权要-夏玉峰 |
|   用户端/会员    | 默认地址	| [client/member/addr/moren](#client/member/addr/moren)|  是  | 吴权要-夏玉峰 |
|   用户端/会员    | 红包列表	| [client/member/hongbao](#client/member/hongbao)	|  是  | 吴权要-夏玉峰 |
|   用户端/会员    | 红包兑换	| [client/member/hongbao/exchange](#client/member/hongbao/exchange)|  是  | 吴权要-夏玉峰 |
|   用户端/会员    | 红包规则	| [client/member/hongbao/rule](#client/member/hongbao/rule)	|  是  | 吴权要-夏玉峰 |
|   用户端/会员    | 金额日志	| [client/member/money/log](#client/member/money/log)|  是  | 吴权要-夏玉峰 |
|   用户端/会员    | 意见反馈	| [client/member/feedback](#client/member/feedback)|  是  | 吴权要-夏玉峰 |
|   用户端/商城    | 商城分类	| [client/mall/cate](#client/mall/cate)	|  否  | 任杰 |
|   用户端/商城    | 商城商品	| [client/mall/product](#client/mall/product)	|  否  | 任杰 |
|   用户端/商城    | 商品详情	| [client/mall/product/detail](#client/mall/product/detail)	|  否  | 任杰 |
|   用户端/商城    | 兑换商品	| [client/mall/order/create](#client/mall/order/create)|  是  | 任杰 |
|   用户端/商城    | 兑换记录	| [client/mall/order/items](#client/mall/order/items) |  是  | 任杰 |
|   用户端/订单    | 订单支付	| [client/payment/order](#client/payment/order)	|  是  |
|   用户端/订单    | 余额支付	| [client/payment/paymoney](#client/payment/paymoney)	|  是  |
<br /><br /><br />


<br />
************
######<a name="magic/sendsms">发送短信(magic/sendsms)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
|   mobile  | 是 | string |  要发送的手机号码  |
>>请求示例
>
```javascript
{
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
          "sms_code":"1234"
    }
}
```

<br />
************
######<a name="client/data/city">城市数据(client/data/city)</a>
>>请求示例（无业务参数）
>
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| city_id | int |  城市ID  |
| city_name | string |  城市  |
| city_code | int |  城市区号 |
| province_id | int |  省份ID  |
| province_name | int |  省份  |
| pinyin | string |  城市拼音  |
| py | string |  城市拼音首字目  |
| phone | string |  客服电话  |
| kfqq | string |  客服QQ  |
>
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
    	"items" :[
        	{
            	"city_id" : "7",
                "city_name" : "合肥",
                "province_id" : "1",
                "province_name" : "安徽",
                "pinyin" : "hf",
                "py" : "H",
                "phone" : "0551-64278115",
                "kfqq" : "800070067"
            },
        	{
            	"city_id" : "8",
                "city_name" : "芜湖",
                "province_id" : "1",
                "province_name" : "安徽",
                "pinyin" : "wh",
                "py" : "W",
                "phone" : "0551-64278115",
                "kfqq" : "800070067"
            }
        ],
        "version" : "201511111111"
    }
}
```



<br />
************
######<a name="client/order/items">订单列表(client/order/items)</a>
>>请求参数
>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| type | 是 | string |  订单类型：'tuan','waimai','paotui','house','weixiu' |
| status | 否 | int |  状态 0:全部,1:进行中的,2:已完成的  |
| pay_status | 否 | int | 支付状态 0:未支付 1:已支付 |
| page | 否 | int |  分页码  |
>>请求示例
>
```javascript
{
    'type':'tuan',
    'status':0,
    'pay_status':1,
    'page' : 1
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| order_id | int | 订单ID |
| city_id | int | 城市ID |
| shop_id | int | 商户ID |
| uid | int | 用户ID |
| product_number | int | 商品数量 |
| product_price | float | 商品总价  |
| freight | float | 运费 |
| amount | float |订单实际金额 |  |
| order_youyi | float | 订单优惠（满减优惠） |
| first_youhui | float | 首单优惠 |
| hongbao | float | 红包金额 |
| hongbao_id | int | 红包ID |
| contact | string | 联系人 |
| mobile | string | 联系电话 |
| addr | string | 地址 |
| house | string | 小区门牌号 |
| lat | string | 纬度 |
| lng | string | 经度 |
| note | string | 订单备注 |
| order_status | int | 订单状态 |
| pay_status | int | 支付状态  `0:未支付, 1:已支付` |
| online_pay | int | 付款方式 `0:货到付款, 1:在线支付` |
| pay_code | string | 支付类型 `wxpay:微信, alipay:支付宝, money:余额` |
| pay_time | int | 支付时间UNIXTIME `当pay_status=1时有值` |
| staff_id | int | 配送员ID  |
| pei_type | string | 配送类型 `0:商家自己送, 1:第三方配送, 2:配送员代购` |
| comment_status | int | 评价状态 `0:未评价, 1:已经评价` |
| dateline | int | 下单时间UNIXTIME |
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
          "uid":"888",
          "nickname":"江湖游医"，
          "face":"face/default.png",
          "mobile":"13888888888"，
          "token":"888-A2D28B1CA20DC547425343D2ACAFE540"
    }
}
```


<br />
************
######<a name="client/order/detail">订单详情(client/order/detail)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| order_id | 是 | int |  订单ID |
>
>>请求示例
>
```javascript
{
    "order_id" : "1"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| order_id | int | 订单ID |
| city_id | int | 城市ID |
| shop_id | int | 商户ID |
| staff_id | int | 服务人员ID |
| uid | int | 用户ID |
| from | string | 订单类型： tuan:团购,waimai:外卖,paotui:跑腿,weixiu:维修,maidan:买单,house:家政 |
| order_status | int | 订单状态 |
| online_pay | int | 付款方式 `0:货到付款, 1:在线支付` |
| pay_status | int | 支付状态  `0:未支付, 1:已支付` |
| trade_no | int | 支付流水号 |
| total_price | int | 订单总金额 |
| hongbao_id | int | 红包ID |
| hongbao | float | 红包金额 |
| order_youyi | float | 订单优惠（满减优惠） |
| first_youhui | float | 首单优惠 |
| money | int | 余额抵扣 |
| amount | int | 需支付金额 |
| o_lng | int | 接单起点经度坐标 |
| o_lat | int | 接单起点纬度坐标 |
| contact | string | 联系人 |
| mobile | string | 联系电话 |
| addr | string | 地址 |
| house | string | 小区门牌号 |
| lat | string | 纬度 |
| lng | string | 经度 |
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
        "order_id" : "1",
        "city_id" : "7",
        "shop_id" : "111",
        "uid" : "888",
        "product_number" : "10",
        "product_price" : "100",
        "freight" : "0",
        "amount" : "70",
        ........
    }
}
```



<br />
######<a name="client/order/cancel">取消订单(client/order/cancel)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| order_id | 是 | int |  订单ID |

>>请求示例
>
```javascript
{
    "order_id" : "1"
}
```

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success'
}
```


<br />
######<a name="client/order/confrim">确认送达(client/order/confrim)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| order_id | 是 | int |  订单ID |

>>请求示例
>
```javascript
{
    "order_id" : "1"
}
```

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success'
}
```


<br />
######<a name="client/order/complaint">订单投诉(client/order/complaint)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| order_id | 是 | int |  订单ID |
| title | 是 | int |  投诉类型 |
| content | 是 | int |  投诉内容 |
>>请求示例
>
```javascript
{
    "order_id" : "123",
    "title" : "商家已接单，但未送货",
    "content" : "11点商家就接单了，现在快13点了还没有送到"
}
```

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    ｛
    	"complaint_id" : "1"
    ｝
}
```

<br />
######<a name="client/order/cuidan">订单催单(client/order/cuidan)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| order_id | 是 | int |  订单ID |
>>请求示例
>
```javascript
{
    "order_id" : "123"
}
```

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success'
}
```

<br />
######<a name="client/order/log">订单进度(client/order/log)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| order_id | 是 | int |  订单ID |
>>请求示例
>
```javascript
{
    "order_id" : "123"
}
```

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
            "log_id" : "1",
            "order_id" : "1",
            "status" : "1",
            "log" : "订单已提交",
            "from" : "member",
            "dateline" : "1234567890",
            },
            {
            "log_id" : "2",
            "order_id" : "1",
            "status" : "1",
            "log" : "订单已提交",
            "from" : "member",
            "dateline" : "1234567890",
            },
            {
            "log_id" : "3",
            "order_id" : "1",
            "status" : "1",
            "log" : "订单已提交",
            "from" : "member",
            "dateline" : "1234567890",
            },
    }
}
```



<br />
************
######<a name="client/passport/signup">注册帐号(client/passport/signup)</a>
>>请求参数
>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| mobile | 是 | string |  要发送的手机号码  |
| passwd | 是 | string |  登录密码  |
| sms_code | 是 | string |  短信验证码  |
| pmid | 否 | string |  邀请码  |
>>请求示例
>
```javascript
{
    'mobile':'1388888888',
    'passwd':'123456',
    'sms_code':'1234',
    'pmid' : 'M0089'
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| uid | int |  用户UID  |
| nickname | string | 会员昵称  |
| face | string |  会员头像  |
| mobile | string |  手机号  |
| token | string |  TOKEN  |
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
          "uid":"888",
          "nickname":"江湖游医"，
          "face":"face/default.png",
          "mobile":"13888888888"，
          "token":"888-A2D28B1CA20DC547425343D2ACAFE540"
    }
}
```

<br />
************
######<a name="client/passport/login">会员登录(client/passport/login)</a>
>>请求参数
>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
|   mobile  | 是 | string |  要发送的手机号码  |
|   passwd  | 是 | string |  密码与验证必传一个  |
|   sms_code  | 否 | string |  密码与验证必传一个  |
>>请求示例
>
```javascript
{
    'mobile':'1388888888',
    'passwd':'123456',
    'sms_code':'1234'
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| uid | int |  用户UID  |
| nickname | string | 会员昵称  |
| face | string |  会员头像  |
| mobile | string |  手机号  |
| token | string |  TOKEN  |
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
          "uid":"888",
          "nickname":"江湖游医"，
          "face":"face/default.png",
          "mobile":"13888888888"，
          "token":"888-A2D28B1CA20DC547425343D2ACAFE540"
    }
}
```



<br />
************
######<a name="client/passport/forgot">找回密码(client/passport/forgot)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| mobile | 是 | string |  手机号码  |
| sms_code | 是 | string |  验证码  |
| new_passwd | 是 | string |  登录密码  |
>>请求示例
>
```javascript
{
	"mobile" : "13888888888",
    "sms_code" : "1234",
    "new_passwd" : "123456"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| uid | int |  用户UID  |
| nickname | string | 会员昵称  |
| face | string |  会员头像  |
| mobile | string |  手机号  |
| token | string |  TOKEN  |
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
          "member_id":"888"
    }
}
```

<br />
************
######<a name="client/passport/wxlogin">微信登录(client/passport/wxlogin)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| wx_openid | 是 | string |  微信openId  |
| wx_unionid | 是 | string |  微信unionid  |
>>请求示例
>
```javascript
{
    "wx_openid" : "dddddddddddddddddddddd"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| wxtype | sting |  微信绑定状态 `wxlogin:已经绑定登录成功, wxbind:未绑定需要绑定`  |
| uid | int |  用户UID  |
| nickname | string | 会员昵称  |
| face | string |  会员头像  |
| mobile | string |  手机号  |
| token | string |  TOKEN  |
>>绑定过帐号返回
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
    	  "wxtype" : "wxlogin",
          "uid":"888",
          "nickname":"江湖游医"，
          "face":"face/default.png",
          "mobile":"13888888888"，
          "token":"888-A2D28B1CA20DC547425343D2ACAFE540"
    }
}
```
>>未绑定过帐号返回
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
    	  "wxtype" : "wxbind",
          "uid":"0",
          "nickname":""，
          "face":"",
          "mobile":""，
          "token":""
    }
}
```



<br />
************
######<a name="client/passport/wxbind">微信绑定(client/passport/wxbind)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| mobile | 是 | string |  绑定的手机号码  |
| sms_code | 是 | string |  验证码  |
| wx_openid | 是 | string |  微信openId  |
| wx_unionid | 是 | string |  微信unionid  |
| wx_nickname | 是 | string |  微信昵称  |
| wx_headimgurl | 是 | string |  微信头像  |
>>请求示例
>
```javascript
{
	"mobile" : "13888888888",
    "sms_code" : "1234",
    "wx_openid" : "dddddddddddddddddddddd"
}
```
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
          "uid":"888",
          "nickname":"江湖游医"，
          "face":"face/default.png",
          "mobile":"13888888888"，
          "token":"888-A2D28B1CA20DC547425343D2ACAFE540"
    }
}
```






<br />
************
######<a name="client/adv/index">首页幻灯片(client/adv/index)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
|   无  | 否 |  --	|  否  |
>返回数据
>
```javascript
{
	"data":{
		"items":[{
				"adv_id":"1",
				"title":"1",
				"link":"http:\/\/baidu.com",
				"thumb":"photo\/201512\/20151202_4DCB8F351CCA0A75B8E7C6FDDE54EADE.png"
			},{
				"adv_id":"1",
				"title":"2",
				"link":"#",
				"thumb":"photo\/201512\/20151202_8A6778B3C2216A8027122F9F5444CE3F.png"
			},...]
	},
	"error":"0",
	"message":"success"
}
```
<br />
************
######<a name="client/data/cate">首页-分类列表(client/data/cate)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
|   无  | 否 |  --	|  否  |
>返回数据
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
         'waimai':'icon/waimai.png',//外卖
         'shangchao':'icon/shangchao.png',//商超
         'shengxian':'icon/shengxian.png',//生鲜
         'tuan':'icon/tuan.png',//团购
         'weixiu':'icon/weixiu.png',//维修
         'maidan':'icon/maidan.png',//买单
         'paotui':'icon/paotui.png',//跑腿
         'xiyi':'icon/xiyi.png',//洗衣
         'jiazheng':'icon/jiazheng.png',//家政
         'quan':'icon/quan.png',//代金券
    }
}
```
<br />
************
######<a name="client/adv/adv">首页-广告位(client/adv/adv)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
|   无  | 否 |  --	|  否  |
>返回数据
>
```javascript
{
	"data":{
		"items":[{
			"adv_id":"2",
			"title":"1",
			"link":"#",
			"thumb":"photo\/201512\/20151204_885969EE8E9E55825AD69819F2F8207E.png"
		},{
			"adv_id":"2",
			"title":"安卓下载",
			"link":"http:\/\/a.app.qq.com\/o\/simple.jsp?pkgname=com.jianghu.waimai",
			"thumb":"photo\/201601\/20160127_92F74493C8205D0BDFAE3DE002046118.png"
		},{
			"adv_id":"2",
			"title":"积分商城2",
			"link":"#",
			"thumb":"photo\/201602\/20160201_D28744BE316093E98126602C61E720E8.png"
		},{
			"adv_id":"2",
			"title":"积分商城2",
			"link":"#",
			"thumb":"photo\/201602\/20160201_1ADCEA05FB72426B3F1D9B2456C0A151.png"
		}]
	},
	"error":"0",
	"message":"success"
}
```



************
######<a name="client/shop/cate">商户分类(client/shop/cate)</a>
>>请求参数无
>
>
>>返回示例
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| cate_id | int | 分类ID |
| title | string | 分类名称 |
| icon | string | 分类ICON图标 |

>>请求示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
    	"items" : [
        	{
            	"cate_id" : "1",
                "title" : "快餐",
                "icon" : "photo/201511/20151111_xxxx.png",
                "orderby" : 50,
            },
            {
            	"cate_id" : "2",
                "title" : "小吃",
                "icon" : "photo/201511/20151111_xxxx.png",
                "orderby" : 50,
            }
        ]
        "total_count" : "30"
    }
}
```

<br />
************
######<a name="client/shop/shopsuggest">推荐商户(client/shop/shopsuggest)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| lat | 是 | string |  纬度  |
| lng | 是 | string |  经度  |
| cate_id | 否 | int |  分类ID  |
| page | 否 | int |  当前分页 |
| type | 否 | string | 店铺类型： 团'tuan','券'quan',买单'maidan' |

>>请求示例
>
```javascript
{
	"lat":"111.123456",
    "lng" : "111.123456",
    "cate_id" : "7",
	"type" : "tuan",
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| shop_id | int |  商户ID  |
| cate_id | int |  分类ID  |
| contact | string |  联系人  |
| mobile | string |  手机号  |
| phone | string |  商户电话  |
| title | string |  商户名称  |
| money | int |  余额  |
| total_money | int |  总收益  |
| tixian_money | int |  总收益  |
| tixian_percent | int |  提现比例  |
| have_waimai | int |  外卖  0:关闭 1:开通 2:拒绝 3:开通申请 4:关闭申请  |
| have_tuan | int |  团购  |
| have_quan | int |  代金券  |
| have_maidan | int |  优惠买单  |
| audit | int |  审核状态 0:待审核，1:审核通过, 2:审核失败  |
| lat | string |  坐标纬度  |
| lng | string |  坐标经度  |

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success'
    "data":{
        "items":[
            {
                "shop_id":"1",
                "cate_id":"7",
                "contact":"张三"
                "mobile":"13699665511",
                "phone":"0551-3366552",
                "title":"xxxxxxxxxx店",
                "money":"0",
                "total_money":"0",
                "tixian_money":"0",
                "tixian_percent":"100",
                "have_waimai" : "1",
                "have_tuan":"0",
                "have_quan":"0",
                "have_maidan":"0",
                "audit":"0",
                "lat":"31.11223",
                "lng":"116.332221"
            },
            {
                "shop_id":"1",
                "cate_id":"7",
                "contact":"张三"
                "mobile":"13699665511",
                "phone":"0551-3366552",
                "title":"xxxxxxxxxx店",
                "money":"0",
                "total_money":"0",
                "tixian_money":"0",
                "tixian_percent":"100",
                "have_waimai" : "1",
                "have_tuan":"0",
                "have_quan":"0",
                "have_maidan":"0",
                "audit":"0",
                "lat":"31.11223",
                "lng":"116.332221"
            },
            ]
        },
        "total_count":"30"
    }
}
```

<br />
************
######<a name="client/shop/detail">商户详情(client/shop/detail)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| shop_id | 是 | int |  商户ID  |
>
>>返回示例
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| shop_id | int |  商户ID  |
| city_id | int |  城市ID  |
| cate_id | int |  分类ID  |
| title  | string |  商户名称  |
| banner | string |  banner图片  |
| logo | string |  logo图片  |
| lat | string |  经度  |
| lng | string |  纬度  |
| addr | string |  商家地址  |
| views | int |  浏览量  |
| orders | int |  订单量  |
| comments | int |  评论量  |
| praise_num | int |  好评数  |
| score | int |  综合总评分，星星可以除以 评论数  |
| score_fuwu | int |  服务评分  |
| score_kouwei | int |  口味评分  |
| first_amount | decimal |  首单优惠  |
| freight | decimal |  运费  |
| pei_amount | decimal |  配送费用 0:免配送费  |
| pei_time | smallint |  平均等待分钟  |
| pei_distance | decimal |  配送距离  |
| pei_type | tinyint |  配送类型  0:自己送,1:第三方送，2:第三方代购及配送  |
| yy_status | tinyint | 营业状态  0:打烊，1：营业中 |
| yy_stime | char |  开始营业时间  |
| yy_ltime | char |   结束营业时间  |
| yy_xiuxi | varchar |  中间休息时间 |
| is_new | tinyint |  是否新店铺  1:表示新店 |
| online_pay | tinyint |  是否支持在线支付 0:不支持在线支付，1：支持在线支付 |
| youhui | varchar |  优惠信息冗余 |
| info | varchar |  商家介绍 |
| pmid | char |  pmid |
| verify_name | tinyint |  0:未验证,1:已验证 |
| audit | tinyint |  商户是否审核 0:未审核，1:已审核 |
| closed | tinyint |  删除标识 |
| clientip | varchar |  商户IP |
| dateline | int |  创建时间 |
>>请求示例
>
```javascript
{
	"data":{
		"detail":{
		"shop_id":"1",
		"city_id":"1",
		"cate_id":"5",
		"title":"江湖外卖",
		"banner":"photo\/201602\/20160202_61D81B0E1342C24BF035FA022EA5C694.png",
		"logo":"photo\/201602\/20160203_13E697B669327267679F1CE152ADE9AE.jpg",
		"lat":"31.830034",
		"lng":"117.249365",
		"addr":"望江西路合作化南路交口五彩国际908室",
		"views":"100",
		"orders":"613",
		"comments":"139",
		"praise_num":"118",
		"score":"634",
		"score_fuwu":"580",
		"score_kouwei":"567",
		"first_amount":"0.00",
		"min_amount":"20.00",
		"freight":"5.00",
		"pei_amount":"3.00",
		"pei_time":"35",
		"pei_distance":"2",
		"pei_type":"0",
		"yy_status":"0",
		"yy_stime":"08:00",
		"yy_ltime":"21:00",
		"yy_xiuxi":"",
		"is_new":"0",
		"online_pay":"1",
		"youhui":"100:50,200:100",
		"info":"1好吃",
		"pmid":"",
		"verify_name":"0",
		"audit":"1",
		"closed":"0",
		"clientip":"127.0.0.1",
		"dateline":"1448418535"
	}
	},"error":"0","message":"success"}
```



<br>
************
######<a name="client/shop/comment/items">商家评论列表(client/shop/comment/items)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
|   shop_id  | 是 |  int	|

```javascript
{
	"data":{
		"uname":"用户昵称",
		"score":"1",
		"score_fuwu":"1",
		"score_kouwei":"1",
		"content":"评价内容",
		"pei_time":"30",
		"reply":"回复内容",
		"reply_time":"1448705847",
		"dateline":"1448705847",
		"gallery":[
			"attachs/qw_2313782137812.png",
			"attachs/qw_2313782137812.png",
			"attachs/qw_2313782137812.png",
			"attachs/qw_2313782137812.png"
		]
	}
	"error":"0",
	"message":"success"
}
```
>参数id为服务[staff_id]时返回数据
>
```javascript
{
	"data":{
		"uname":"用户昵称",
		"score":"1",
		"content":"评价内容",
		"reply":"回复内容",
		"reply_time":"1448705847",
		"dateline":"1448705847",
		"gallery":[
			"attachs/qw_2313782137812.png",
			"attachs/qw_2313782137812.png",
			"attachs/qw_2313782137812.png",
			"attachs/qw_2313782137812.png"
		]
	},
	"error":"0",
	"message":"success"
}
```
<br/>
************
######<a name="client/shop/comment/commit">商家评论提交(client/shop/comment/commit)</a>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| score | int |  总评分  |
| score_fuwu | int |  服务评分  |
| score_kouwei | int |  口味评分  |
| content | string |  评价内容  |
>>请求示例
>
```javascript
{
    "score":"1",
    "score_fuwu":"1",
    "score_kouwei":"1",
    "content":"评价内容",
}
```
>>返回数据
>
```javascript
{
    'error':'0',
    'message':'success'
}
```


<br />
######<a name="client/tuan/items">团购列表(client/tuan/items)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| page | 是 | int |  页码 |
>>请求示例
>
```javascript
{
    "page" : "1"
}
```

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
    	'tuan_id':1
        'shop_id': 12121,
		'city_id':1,
		'type':'tuan',
		'title':'',
		'desc':'',
		'price':'',
		'market_price':'',
		'photo':'',
		'views':'',
		'stime':'',
		'ltime':'',
		'sale_type':'',
		'sale_sku':'',
		'sale_count':'',
		'sales':'',
		'virtual_sales':'',
		'info':'',
		'orderby':'',
		'audit':'',
    }
}
```


<br />
######<a name="client/tuan/detail">团购详情(client/tuan/detail)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| tuan_id | 是 | int |  团购ID |
>>请求示例
>
```javascript
{
    "tuan_id" : "1"
}
```

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
    	'tuan_id':1,
        'shop_id': 12121,
		'city_id':1,
		'type':'tuan',
		'title':'',
		'desc':'',
		'price':'',
		'market_price':'',
		'photo':'',
		'views':'',
		'stime':'',
		'ltime':'',
		'sale_type':'',
		'sale_sku':'',
		'sale_count':'',
		'sales':'',
		'virtual_sales':'',
		'info':'',
		'orderby':'',
		'audit':'',
    }
}
```



<br />
######<a name="client/tuan/goods">团购商品列表(client/tuan/goods)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| shop_id | 是 | int |  商户ID |
| page | 是 | int |  页码 |
>>请求示例
>
```javascript
{
    "tuan_id" : "1",
    "page":"1"
}
```

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
    "items": [
      {
        "tuan_id": "1",
        "shop_id": "10000",
        "city_id": "1",
        "type": "tuan",
        "title": "天天海滋味",
        "desc": "【天鹅湖银泰城】天天海滋味",
        "price": "79.90",
        "market_price": "100.00",
        "photo": "photo/201602/tiantianhaixian.png",
        "views": "0",
        "stime": "20160301",
        "ltime": "20160401",
        "sale_type": "0",
        "sale_sku": "0",
        "sale_count": "0",
        "sales": "6",
        "virtual_sales": "0",
        "info": "仅售79.9元！价值100元的代金券1张，全场通用，可叠加使用，提供免费WiFi。",
        "orderby": "0",
        "audit": "1",
        "closed": "0",
        "clientip": "",
        "dateline": "0"
      },
    ],
    "shop_detail": {
      "shop_id": "10003",
      "title": "阳光花坊",
      "contact": "阳光花坊",
      "mobile": "18605652066",
      "phone": "0556-5652066",
      "tixian_percent": "100",
      "have_waimai": "0",
      "have_tuan": "1",
      "have_quan": "1",
      "have_maidan": "0",
      "lat": "31.83596",
      "lng": "117.255225",
      "logo": "photo/201603/20160325_69B3ADBCF494C5F4BDDB75BA35FA01C7.jpg",
      "score": "124",
      "comments": "30",
      "avg_amount": "95",
      "business_id": "9",
      "area_id": "2",
      "city_name": "合肥",
      "cate_title": "鲜花"
    },
    "total_count": "15"
  }
}
```



<br />
######<a name="client/tuan/comment">团购商品详情页---全部评价(client/tuan/comment)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| shop_id | 是 | int |  商户ID |
| page | 是 | int |  页码 |
>>请求示例
>
```javascript
{
    "tuan_id" : "1",
    "page":"1"
}
```

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
    "items": [
      {
        "comment_id": "6",
        "shop_id": "10003",
        "uid": "17",
        "order_id": "100268",
        "score": "5",
        "score_fuwu": "3",
        "score_kouwei": "3",
        "content": "用户评价内容",
        "pei_time": "30",
        "have_photo": "1",
        "reply": "商家回复内容",
        "reply_ip": "",
        "reply_time": "1459130219",
        "closed": "0",
        "clientip": "",
        "dateline": "1459130201",
        "u_mobile": "13777777777",
        "photos": [
          "photo/201512/20151202_9A88EBC2E407BCCBBB1DE6BD18F36803.jpg",
          "photo/201512/20151224_7DB7DEADC2367E6819EB6E794263B192.jpg",
          "photo/201512/20151224_0208DD896BC30C59285D215BEBCEEB4A.jpeg"
        ]
      }
    ]
  }
}
```



<br />
######<a name="client/tuan/order/create">创建团购订单(client/tuan/order/create)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| tuan_id | 是 | int |  团购ID |
>>请求示例
>
```javascript
{
    "tuan_id" : "1"
}
```

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success'
}
```


<br />
************
######<a name="client/waimai/shop/cate">外卖商户分类(client/waimai/shop/cate)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| shop_id | 是 | int |  商户ID |

>>请求示例
>
```javascript
{
    "waimai_id" : "123",
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| cate_id | int | 评论ID |
| shop_id | int | 商户ID |
| title | string | 分类名称 |
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
		"items" : [
        	{
            	"cate_id" : "1",
                "shop_id" : "123",
                "title" : "盖浇饭"
            },
        	{
            	"cate_id" : "2",
                "shop_id" : "123",
                "title" : "套餐系列"
            }
        ]
    }
}
```

<br />
************
######<a name="client/waimai/shop/items">外卖商户列表(client/waimai/shop/items)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| lat | 是 | string |  纬度  |
| lng | 是 | string |  经度  |
| cate_id | 否 | int |  分类ID  |


>>请求示例
>
```javascript
{
	"lat":"111.123456",
    "lng" : "111.123456",
    "cate_id" : "7",
	"type" : "tuan",
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| shop_id | int |  商户ID  |
| city_id | int |  城市ID  |
| cate_id | int |  分类ID  |
| title | string |  商户名称  |
| banner | string |  横幅  |
| logo | string |  商户LOGO  |
| addr | string |  地址  |
| views | int |  浏览次数  |
| orders | int |  订单数  |
| comments | int |  评论数  |
| praise_num | int |  好评数  |
| score | int |  综合总评分  |
| score_fuwu | int |  服务评分  |
| score_kouwei| int |  口味评分  |
| first_amount| int |  首单优惠  |
| min_amount| int |  起送价  |
| freight| int |  运费  |
| pei_amount| int |  配送费用 0:免配送费，支付第三方运费  |
| pei_time| int |  分钟，平均等待时间,从商家接单开始到订单结束  |
| pei_distance | int |  配送距离  |
| pei_type | int |  配送类型  0:自己送,1:第三方送，2:第三方代购及配送  |
| yy_status | int |  营业状态  0:打烊，1：营业中 |
| yy_stime | string | 开始营业时间 |
| yy_ltime | string | 打烊时间 |
| yy_xiuxi | string | 中午休息时间 |
| is_new | int | 是否新店铺  1:表示新店 |
| online_pay | int | 是否支持在线支付 0:不支持在线支付，1：支持在线支付 |
| youhui | string | 优惠 |
| info | string | 介绍 |
| pmid | string | 格式为(M|P|D|S)+ID M:会员，D:地推，S:商家，P:配送员 |
| verify_name | int | 0:未验证,1:已验证 |
| audit | int | 0:未验证,1:已验证 |
| lat | string |  坐标纬度  |
| lng | string |  坐标经度  |

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success'
    "data":{
        "items":[
            {
                "shop_id":"1",
                "city_id":"7",
                "cate_id":"7",
                "title":"xxx商户",
                "banner":"xxx.jpg",
                "logo":"xxx.jpg",
                "addr":"地址哦哦"
                "lat":"31.11223",
                "lng":"116.332221"
                .........
            },
            {
                "shop_id":"1",
                "city_id":"7",
                "cate_id":"7",
                "title":"xxx商户",
                "banner":"xxx.jpg",
                "logo":"xxx.jpg",
                "addr":"地址哦哦"
                "lat":"31.11223",
                "lng":"116.332221"
                .........
            },
            ]
        },
        "total_count":"30"
    }
}
```
<br />
************
######<a name="client/waimai/product/cate">外卖商品分类(client/waimai/product/cate)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| shop_id | 是 | int |  商户ID |

>>请求示例
>
```javascript
{
    "shop_id" : "123",
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| cate_id | int | 评论ID |
| shop_id | int | 商户ID |
| title | string | 分类名称 |
| icon | string | 图标 |
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
		"items" : [
        	{
            	"cate_id" : "1",
                "shop_id" : "123",
                "title" : "盖浇饭",
                "icon" : "图标"
            },
        	{
            	"cate_id" : "1",
                "shop_id" : "123",
                "title" : "盖浇饭",
                "icon" : "图标"
            }
        ]
    }
}
```


<br />
************
######<a name="client/waimai/product/items">外卖商品列表(client/waimai/product/items)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| shop_id | 是 | int |  商户ID |

>>请求示例
>
```javascript
{
    "shop_id" : "123",
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| product_id | int | 商品ID |
| cate_id | int | 分类ID |
| shop_id | int | 商户ID |
| title | string | 商品名称 |
| photo | string | 商品图片 |
| price | float | 商品价格 |
| package_price | float | 打包费 `每份商品计算一次的,如该商品订够了3份需要收到3份打包费, 0:免打包费` |
| sales | int | 商品销量 |
| sale_type | int | 销售类型  `0:普通, 1:抢购商品（有数量限制）` |
| sale_sku | int | 抢购库存 `当sale_type=1时有效` |
| sale_count | int | 已抢购数量 `当sale_type=1时有效，库存以 sale_sku-sale_count` |
| intro | string | 商品描述 |
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
		"items" : [
        	{
                "product_id" : "1",
            	"cate_id" : "1",
                "shop_id" : "123",
                "title" : "回锅肉盖浇饭",
                "photo" : "photo/201511/20151111_xxxx.jpg",
                "price" : "15.00",
                "package_price" : "0",
                "sales" : "2000",
                "sale_type" : "1",
                "sale_sku" : "20",
                "sale_count" : "12",
                "intro" : "上等五花肉配有机大米饭"
            },
        	{
                "product_id" : "2",
            	"cate_id" : "1",
                "shop_id" : "123",
                "title" : "红烧牛肉商务套餐",
                "photo" : "photo/201511/20151111_xxxx.jpg",
                "price" : "15.00",
                "package_price" : "0",
                "sales" : "2000",
                "sale_type" : "0",
                "sale_sku" : "0",
                "sale_count" : "0",
                "intro" : "红烧牛肉+卤蛋+可乐"
            }
        ]
    }
}
```





<br>
************
######<a name="client/waimai/comment/items">外卖评论列表(client/waimai/comment/items)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
|   shop_id  | 是 |  int	|

```javascript
{
	"data":{
		"uname":"用户昵称",
		"score":"1",
		"score_fuwu":"1",
		"score_kouwei":"1",
		"content":"评价内容",
		"pei_time":"30",
		"reply":"回复内容",
		"reply_time":"1448705847",
		"dateline":"1448705847",
		"gallery":[
			"attachs/qw_2313782137812.png",
			"attachs/qw_2313782137812.png",
			"attachs/qw_2313782137812.png",
			"attachs/qw_2313782137812.png"
		]
	}
	"error":"0",
	"message":"success"
}
```
>参数id为服务[staff_id]时返回数据
>
```javascript
{
	"data":{
		"uname":"用户昵称",
		"score":"1",
		"content":"评价内容",
		"reply":"回复内容",
		"reply_time":"1448705847",
		"dateline":"1448705847",
		"gallery":[
			"attachs/qw_2313782137812.png",
			"attachs/qw_2313782137812.png",
			"attachs/qw_2313782137812.png",
			"attachs/qw_2313782137812.png"
		]
	},
	"error":"0",
	"message":"success"
}
```
<br/>
************
######<a name="client/waimai/comment/commit">外卖评论提交(client/waimai/comment/commit)</a>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| score | int |  总评分  |
| score_fuwu | int |  服务评分  |
| score_kouwei | int |  口味评分  |
| content | string |  评价内容  |
>>请求示例
>
```javascript
{
    "score":"1",
    "score_fuwu":"1",
    "score_kouwei":"1",
    "content":"评价内容",
}
```
>>返回数据
>
```javascript
{
    'error':'0',
    'message':'success'
}
```


<br/>
************
######<a name="client/waimai/order/create">外卖创建订单(client/waimai/order/create)</a>
| 参数名称 |是否必须 | 类型 | 描述 |
|--------|:-------:|------|
|shop_id|	是|	int	|商户ID|
|addr_id	|是|	int	|地址ID|
|products|	是|	string	|是一个格式化的字符 商品1ID:数量1,商品2ID:数量2...|
|pei_time|	否|	time	|要求配送时间 0:尽快送达, 其它时间为商家营业范围内|
|online_pay|	是|	int	|付款方式 0:货到付款, 1:在线支付|
|passwd|	否|	int	|支付密码同登录密码，当会员有余额时优先用帐户余额支付|
|hongbao_id|	否|	int	|红包ID|
|note|	否|string|订单备注要求|
>>请求示例
>
```javascript
{
     "shop_id" : "123",
    "addr_id" : "111",
    "products" : "1:2,2:3",
    "pei_time" : "0",
    "hongbao_id" : "111",
    "note" : "少放辣、米饭多点"
}
```
>>返回数据
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
        "order_id" : "11",
        "amount" : "18.00"
    }
}
```



<br>
************
######<a name="client/house/cate">家政服务分类(client/house/cate)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
|   ----  | 是 |  int	| ------ |
>参数id为商家[shop_id]时返回数据
>
```javascript
{
	"data":{
		"1":{
			"cate_id":"1",
			"parent_id":"1",
			"title":"test1",
			"icon":"photo\/201602\/20160225_D7D90FA539D0BD547D821F00F01E29BA.png",
			"photo":"photo\/201602\/20160225_F57DAD280D6E241CBB53C7AEC2E42274.png",
			"price":"105.00",
			"orders":"31",
			"info":"简介",
			"orderby":"2",
			"dateline":"1456388208"
		},
		"2":{
			"cate_id":"1",
			"parent_id":"1",
			"title":"test1",
			"icon":"photo\/201602\/20160225_D7D90FA539D0BD547D821F00F01E29BA.png",
			"photo":"photo\/201602\/20160225_F57DAD280D6E241CBB53C7AEC2E42274.png",
			"price":"105.00",
			"orders":"31",
			"info":"简介",
			"orderby":"2",
			"dateline":"1456388208"
		},
	},
	"error":"0",
	"message":"success"
}
```



<br>
><a name="client/house/map">家政地图(client/house/map)</a>

| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| leftbottomlng | string | 左下经度 |
| leftbottomlat | string | 左下纬度 |
| righttoplng | string | 右上经度 |
| righttoplat | string | 右上纬度 |
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
		"items" :[
        	{
            	"staff_id" : "1",
                "lat" : "31.835939",
                "lng" : "117.257534",
            },
        	{
            	"staff_id" : "2",
                "lat" : "31.835939",
                "lng" : "117.257534",
            },
        ]
    }
}
```


<br>
><a name="client/house/items">阿姨列表(client/house/items)</a>

| 参数名称 | 类型 | 是否必须 | 描述 |
|--------|:-------:|------|
| lat | string | 是 | 纬度 |
| lng | string | 是 | 经度 |
| cate_id | int | 否 | 分类ID |
| orderby | string | 否 | 排序 's'=>按评价排 'd'=>按距离排 |
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
		"items" :[
        	{
            	"staff_id" : "1",
                "city_id" : "1";
                "name" : "张三",
                "mobile" : "13866552211",
                "face" : "1.jpg",
                "orders": "5",
                "score": "5",
                "comments":"5",
                "lat":"123.456",
                "lng":"456.321"
            },
        	{
            	"staff_id" : "1",
                "city_id" : "1";
                "name" : "张三",
                "mobile" : "13866552211",
                "face" : "1.jpg",
                "orders": "5",
                "score": "5",
                "comments":"5",
                "lat":"123.456",
                "lng":"456.321"
            },
        ]
    }
}
```


<br>
><a name="client/house/staffcomment">阿姨评价(client/house/staffcomment)</a>

| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| staff_id | int | 阿姨ID |
| type | int | '1':好评,'2':中评,'3':差评|
| page | int | 分页|

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
    	"detail":{
        	"comment_id" : "1",
            "order_d" : "1";
            "staff_id" : "张三",
            "uid" : "1",
            "score" : "1",
            "content": "该阿姨工作很到位，谢谢",
        }
    }
}
```



<br>
><a name="client/house/staffdetail">阿姨详情(client/house/staffdetail)</a>

| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| staff_id | int | 阿姨ID |

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
    	"detail":{
        	"staff_id" : "1",
            "city_id" : "1";
            "name" : "张三",
            "mobile" : "13866552211",
            "face" : "1.jpg",
            "orders": "5",
            "score": "5",
            "comments":"5",
            "lat":"123.456",
            "lng":"456.321"
        }
    }
}
```



<br>
><a name="client/house/detail">分类详情(client/house/detail)</a>

| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| cate_id | int | 分类ID |

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
    	"detail":{
        	"cate_id" : "2",
            "parent_id" : "1";
            "title" : "家庭保洁",
            "icon" : "photo\/201603\/20160321_9B0CF293AFBA35DC2D05AE03F6634FE7.png",
            "photo" : "2",
            "price": "20.00",
            "unit": "3",
            "start":"30",
            "orders":"1",
            "info":"家庭保洁家庭保洁家庭保洁家庭保洁家庭保洁家庭保洁家庭保洁家庭保洁"
        }
    }
}
```



<br>
><a name="client/house/create">创建订单(client/house/order/create)</a>

| 参数名称 | 类型 | 是否必须 | 描述 |
|--------|:-------:|------|
| city_id | 'int' | 是 | 城市ID |
| cate_id | 'int' | 否 | 分类ID |
| addr_id | 'int' | 是 | 地址ID |
| fuwu_time | 'int' | 是 | 服务时间 |
| intro | 'int' | 是 | 填写需求 |
| danbao_amount | 'int' | 是 | 定金 |
| staff_id | 'int' | 否 | 指定服务人员ID |
| photo1 | 'string' | 否 | 图片1 |
| photo2 | 'string' | 否 | 图片2 |
| photo3 | 'string' | 否 | 图片3 |
| photo4 | 'string' | 否 | 图片4 |
| voice | 'string' | 否 | 语音 |

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
        	"order_id" : "2",
    }
}
```


<br>
><a name="client/house/commenthandle">评价阿姨(client/house/commenthandle)</a>

| 参数名称 | 类型 | 是否必须 | 描述 |
|--------|:-------:|------|
| score | 'int' | 是 | 评分 |
| content | 'string' | 是 | 评价内容 |
| order_id | 'int' | 是 | 订单ID |
| fuwu_time | 'int' | 是 | 服务时间 |
| intro | 'int' | 是 | 填写需求 |
| danbao_amount | 'int' | 是 | 定金 |
| staff_id | 'int' | 否 | 指定服务人员ID |
| photo1 | 'string' | 否 | 图片1 |
| photo2 | 'string' | 否 | 图片2 |
| photo3 | 'string' | 否 | 图片3 |
| photo4 | 'string' | 否 | 图片4 |
| voice | 'string' | 否 | 语音 |

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
        	"order_id" : "2",
    }
}
```












<br>
************
######<a name="client/weixiu/cate">维修服务分类(client/weixiu/cate)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
|   ----  | 是 |  int	| ------ |
>参数id为商家[shop_id]时返回数据
>
```javascript
{
	"data":{
		"1":{
			"cate_id":"1",
			"parent_id":"1",
			"title":"test1",
			"icon":"photo\/201602\/20160225_D7D90FA539D0BD547D821F00F01E29BA.png",
			"photo":"photo\/201602\/20160225_F57DAD280D6E241CBB53C7AEC2E42274.png",
			"price":"105.00",
			"orders":"31",
			"info":"简介",
			"orderby":"2",
			"dateline":"1456388208"
		},
		"2":{
			"cate_id":"1",
			"parent_id":"1",
			"title":"test1",
			"icon":"photo\/201602\/20160225_D7D90FA539D0BD547D821F00F01E29BA.png",
			"photo":"photo\/201602\/20160225_F57DAD280D6E241CBB53C7AEC2E42274.png",
			"price":"105.00",
			"orders":"31",
			"info":"简介",
			"orderby":"2",
			"dateline":"1456388208"
		},
	},
	"error":"0",
	"message":"success"
}
```



<br>
><a name="client/weixiu/map">维修地图(client/weixiu/map)</a>

| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| leftbottomlng | string | 左下经度 |
| leftbottomlat | string | 左下纬度 |
| righttoplng | string | 右上经度 |
| righttoplat | string | 右上纬度 |
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
		"items" :[
        	{
            	"staff_id" : "1",
                "lat" : "31.835939",
                "lng" : "117.257534",
            },
        	{
            	"staff_id" : "2",
                "lat" : "31.835939",
                "lng" : "117.257534",
            },
        ]
    }
}
```


<br>
><a name="client/weixiu/items">师傅列表(client/weixiu/items)</a>

| 参数名称 | 类型 | 是否必须 | 描述 |
|--------|:-------:|------|
| lat | string | 是 | 纬度 |
| lng | string | 是 | 经度 |
| cate_id | int | 否 | 分类ID |
| orderby | string | 否 | 排序 's'=>按评价排 'd'=>按距离排 |
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
		"items" :[
        	{
            	"staff_id" : "1",
                "city_id" : "1";
                "name" : "张三",
                "mobile" : "13866552211",
                "face" : "1.jpg",
                "orders": "5",
                "score": "5",
                "comments":"5",
                "lat":"123.456",
                "lng":"456.321"
            },
        	{
            	"staff_id" : "1",
                "city_id" : "1";
                "name" : "张三",
                "mobile" : "13866552211",
                "face" : "1.jpg",
                "orders": "5",
                "score": "5",
                "comments":"5",
                "lat":"123.456",
                "lng":"456.321"
            },
        ]
    }
}
```


<br>
><a name="client/weixiu/staffcomment">师傅评价(client/weixiu/staffcomment)</a>

| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| staff_id | int | 阿姨ID |
| type | int | '1':好评,'2':中评,'3':差评|
| page | int | 分页|

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
    	"detail":{
        	"comment_id" : "1",
            "order_d" : "1";
            "staff_id" : "张三",
            "uid" : "1",
            "score" : "1",
            "content": "该阿姨工作很到位，谢谢",
        }
    }
}
```


<br>
><a name="client/weixiu/staffdetail">师傅详情(client/weixiu/staffdetail)</a>

| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| staff_id | int | 阿姨ID |

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
    	"detail":{
        	"staff_id" : "1",
            "city_id" : "1";
            "name" : "张三",
            "mobile" : "13866552211",
            "face" : "1.jpg",
            "orders": "5",
            "score": "5",
            "comments":"5",
            "lat":"123.456",
            "lng":"456.321"
        }
    }
}
```



<br>
><a name="client/weixiu/detail">分类详情(client/weixiu/detail)</a>

| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| cate_id | int | 分类ID |

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
    	"detail":{
        	"cate_id" : "2",
            "parent_id" : "1";
            "title" : "修手机",
            "icon" : "photo\/201603\/20160321_9B0CF293AFBA35DC2D05AE03F6634FE7.png",
            "photo" : "2",
            "price": "20.00",
            "unit": "3",
            "start":"30",
            "orders":"1",
            "info":"修手机修手机修手机"
        }
    }
}
```



<br>
><a name="client/weixiu/create">创建订单(client/weixiu/create)</a>

| 参数名称 | 类型 | 是否必须 | 描述 |
|--------|:-------:|------|
| city_id | 'int' | 是 | 城市ID |
| cate_id | 'int' | 否 | 分类ID |
| addr_id | 'int' | 是 | 地址ID |
| fuwu_time | 'int' | 是 | 服务时间 |
| intro | 'int' | 是 | 填写需求 |
| danbao_amount | 'int' | 是 | 定金 |
| staff_id | 'int' | 否 | 指定服务人员ID |
| photo1 | 'string' | 否 | 图片1 |
| photo2 | 'string' | 否 | 图片2 |
| photo3 | 'string' | 否 | 图片3 |
| photo4 | 'string' | 否 | 图片4 |
| voice | 'string' | 否 | 语音 |

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
        	"order_id" : "2",
    }
}
```


<br>
><a name="client/weixiu/commenthandle">评价阿姨(client/weixiu/commenthandle)</a>

| 参数名称 | 类型 | 是否必须 | 描述 |
|--------|:-------:|------|
| score | 'int' | 是 | 评分 |
| content | 'string' | 是 | 评价内容 |
| order_id | 'int' | 是 | 订单ID |
| fuwu_time | 'int' | 是 | 服务时间 |
| intro | 'int' | 是 | 填写需求 |
| danbao_amount | 'int' | 是 | 定金 |
| staff_id | 'int' | 否 | 指定服务人员ID |
| photo1 | 'string' | 否 | 图片1 |
| photo2 | 'string' | 否 | 图片2 |
| photo3 | 'string' | 否 | 图片3 |
| photo4 | 'string' | 否 | 图片4 |
| voice | 'string' | 否 | 语音 |

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
        	"order_id" : "2",
    }
}
```
















<br>
><a name="client/paotui/map">跑腿地图(client/paotui/map)</a>

| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| lat | string | 纬度 |
| lng | string | 经度 |
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
		"items" :[
        	{
            	"staff_id" : "1",
                "lat" : "31.835939",
                "lng" : "117.257534",
            },
        	{
            	"staff_id" : "2",
                "lat" : "31.835939",
                "lng" : "117.257534",
            },
        ]
    }
}
```





<br>
><a name="client/paotui/song">帮我送下单(paotui/song)</a>

| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|
| o_time | 是 | int | 取件时间 |
| time | 是 | int | 送件时间 |
| o_addr | 是 | string | 取件地 |
| o_house | 是 | string | 取件门牌号 |
| o_contact | 是 | string | 取件联系人 |
| o_mobile | 是 | string | 取件联系人手机号 |
| o_lng | 是 | string | 取件地址经度 |
| o_lat | 是 | string | 取件地址纬度 |
| addr | 是 | string | 送件地 |
| house | 是 | string | 送件门牌号 |
| contact | 是 | string | 送件联系人 |
| mobile | 是 | string | 送件联系人手机号 |
| lng | 是 | string | 送件地址经度 |
| lat | 是 | string | 送件地址纬度 |
| intro | 是 | string | 要求，描述 |
| photo | 是 | string | 图片 |
| voice | 是 | string | 语音 |
| paotui_amount | 是 | string | 跑腿费用 |
| danbao_amount | 否 | string | 担保托管金额 |

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
    	"paotui_id" : "1"
    }
}
```
<br>
><a name="client/paotui/buy">帮我买下单(paotui/buy)</a>

| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|
| time | 是 | int | 送件时间 |
| o_addr | 否 | string | 取件地 |
| o_house | 否 | string | 取件门牌号 |
| o_contact | 否 | string | 取件联系人 |
| o_mobile | 否 | string | 取件联系人手机号 |
| o_lng | 否 | string | 取件地址经度 |
| o_lat | 否 | string | 取件地址纬度 |
| addr | 是 | string | 送件地 |
| house | 是 | string | 送件门牌号 |
| contact | 是 | string | 送件联系人 |
| mobile | 是 | string | 送件联系人手机号 |
| lng | 是 | string | 送件地址经度 |
| lat | 是 | string | 送件地址纬度 |
| intro | 是 | string | 要求，描述 |
| photo | 是 | string | 图片 |
| voice | 是 | string | 语音 |
| paotui_amount | 是 | string | 跑腿费用 |
| danbao_amount | 否 | string | 担保托管金额 |

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
    	"paotui_id" : "1"
    }
}
```
<br>
><a name="client/paotui/queue">排队下单(client/paotui/queue)</a>

| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|
| time | 是 | int | 服务时间 |
| addr | 是 | string | 服务地址 |
| house | 是 | string | 地址备注 |
| contact | 是 | string | 联系人 |
| mobile | 是 | string | 联系人手机号 |
| lng | 是 | string | 经度 |
| lat | 是 | string | 纬度 |
| intro | 是 | string | 要求，描述 |
| photo | 是 | string | 图片 |
| voice | 是 | string | 语音 |
| paotui_amount | 是 | string | 跑腿费用 |
| danbao_amount | 否 | string | 担保托管金额 |

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
    	"paotui_id" : "1"
    }
}
```

<br>
><a name="client/paotui/care">陪护下单(client/paotui/care)</a>

| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|
| time | 是 | int | 服务时间 |
| addr | 是 | string | 服务地址 |
| house | 是 | string | 地址备注 |
| contact | 是 | string | 联系人 |
| mobile | 是 | string | 联系人手机号 |
| lng | 是 | string | 经度 |
| lat | 是 | string | 纬度 |
| intro | 是 | string | 要求，描述 |
| photo | 是 | string | 图片 |
| voice | 是 | string | 语音 |
| paotui_amount | 是 | string | 跑腿费用 |
| danbao_amount | 否 | string | 担保托管金额 |

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
    	"paotui_id" : "1"
    }
}
```


<br>
><a name="client/paotui/seat">占座下单(client/paotui/seat)</a>

| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|
| time | 是 | int | 服务时间 |
| addr | 是 | string | 服务地址 |
| house | 是 | string | 地址备注 |
| contact | 是 | string | 联系人 |
| mobile | 是 | string | 联系人手机号 |
| lng | 是 | string | 经度 |
| lat | 是 | string | 纬度 |
| intro | 是 | string | 要求，描述 |
| photo | 是 | string | 图片 |
| voice | 是 | string | 语音 |
| paotui_amount | 是 | string | 跑腿费用 |
| danbao_amount | 否 | string | 担保托管金额 |

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
    	"paotui_id" : "1"
    }
}
```



<br />
************
######<a name="client/paotui/price">帮我买和帮我送的公式 (client/paotui/price)</a>

| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| km 	 | 是 	| int |  距离 |
| kg 	 | 是	| int |  重量 |
>>请求参数
>```javascript
{
    "km":321,
	"kg":120
}```
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
		"price":258
	}
}```


<br />
************
######<a name="client/paotui/pricequeue">代排队公式 (client/paotui/pricequeue)</a>

| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| km 	 | 是 	| int |  距离 |
| kg 	 | 是	| int |  重量 |
>>请求参数
>```javascript
{
    "km":321,
	"kg":120
}```
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
		"price":258
	}
}```


<br />
************
######<a name="client/paotui/pricecare">陪护公式 (client/paotui/pricecare)</a>

| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| km 	 | 是 	| int |  距离 |
| kg 	 | 是	| int |  重量 |
>>请求参数
>```javascript
{
    "km":321,
	"kg":120
}```
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
		"price":258
	}
}```


<br />
************
######<a name="client/paotui/priceseat">占座公式 (client/paotui/priceseat)</a>

| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| km 	 | 是 	| int |  距离 |
| kg 	 | 是	| int |  重量 |
>>请求参数
>```javascript
{
    "km":321,
	"kg":120
}```
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
		"price":258
	}
}```


<br />
************
######<a name="client/member/order/items">订单列表(client/member/order/items)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| from | 是 | string |  类型：'tuan','waimai','paotui','maidan','weixiu','house','other'  |
| type | 是 | string |  0：进行中的订单 1：已完成的订单  |
>>请求示例
>
```javascript
{
    "from":"tuan",
    "type":"1"
}
```
>>返回示例
>
```javascript
{
    "data": {
        "items": {
            "100324": {
                "order_id": "100324",
                "city_id": "1",
                "shop_id": "10003",
                "staff_id": "0",
                "uid": "47",
                "from": "tuan",
                "order_status": "0",
                "online_pay": "0",
                "pay_status": "0",
                "trade_no": "0",
                "total_price": "0.00",
                "hongbao_id": "0",
                "hongbao": "0.00",
                "order_youhui": "0.00",
                "first_youhui": "0.00",
                "money": "0",
                "amount": "49",
                "o_lng": "0",
                "o_lat": "0",
                "contact": "186****9507",
                "mobile": "18605529507",
                "addr": "四联大楼",
                "house": "四联大楼",
                "lng": "117",
                "lat": "31",
                "day": "20160405",
                "clientip": "127.0.0.1",
                "intro": "",
                "order_from": "wap",
                "pay_code": "",
                "pay_time": "0",
                "dateline": "1459827536",
                "jd_time": "",
                "comment_status": "0",
                "order_status_label": "待支付",
                "order_status_warning": "订单等待支付"
            }
        }
    },
    "error": "0",
    "message": "success"
}
```

<br />
************
######<a name="client/member/order/detail">订单详情(client/member/order/detail)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| order_id | 是 | int |  订单ID |
| lat | 是 | string |  纬度  |
| lng | 是 | string |  经度  |
>>请求示例
>
```javascript
{
    "order_id":100324,
    "lat":"31",
    "lng":"117"
}
```
>>返回示例
>
```javascript
{
    "data": {
        "order": {
            "order_id": "100324",
            "city_id": "1",
            "shop_id": "10003",
            "staff_id": "0",
            "uid": "47",
            "from": "tuan",
            "order_status": "0",
            "online_pay": "0",
            "pay_status": "0",
            "trade_no": "0",
            "total_price": "0.00",
            "hongbao_id": "0",
            "hongbao": "0.00",
            "order_youhui": "0.00",
            "first_youhui": "0.00",
            "money": "0",
            "amount": "49",
            "o_lng": "0",
            "o_lat": "0",
            "contact": "186****9507",
            "mobile": "18605529507",
            "addr": "四联大楼",
            "house": "四联大楼",
            "lng": "117",
            "lat": "31",
            "day": "20160405",
            "clientip": "127.0.0.1",
            "intro": "",
            "order_from": "wap",
            "pay_code": "",
            "pay_time": "0",
            "dateline": "1459827536",
            "jd_time": "",
            "comment_status": "0",
            "order_status_label": "待支付",
            "order_status_warning": "订单等待支付",
            "shop": {
                "shop_id": "10003",
                "cate_id": "6",
                "city_id": "1",
                "title": "阳光花坊",
                "contact": "阳光花坊",
                "mobile": "18605652067",
                "phone": "0556-5652066",
                "passwd": "e10adc3949ba59abbe56e057f20f883e",
                "money": "195.00",
                "thumb": "photo/201603/20160321_751B7D72A008538DF3BD8E00953DFD5F.jpg",
                "total_money": "240.00",
                "tixian_money": "0.00",
                "tixian_percent": "100",
                "have_waimai": "1",
                "have_tuan": "1",
                "have_quan": "1",
                "have_maidan": "1",
                "lat": "31.840347",
                "lng": "117.239487",
                "logo": "photo/201603/20160325_69B3ADBCF494C5F4BDDB75BA35FA01C7.jpg",
                "banner": "photo/201603/20160307_B5351AE279C80BBACCB8389CFB887C5E.png",
                "score": "124",
                "comments": "30",
                "addr": "蜀山区望江西路与潜山路交口向东200米路北",
                "avg_amount": "95",
                "business_id": "9",
                "area_id": "2",
                "audit": "1",
                "clientip": "60.168.3.202",
                "dateline": "1459477410",
                "closed": "0",
                "city_name": "合肥",
                "cate_name": "鲜花",
                "cate_title": "鲜花"
            },
            "detail": {
                "order_id": "100324",
                "tuan_id": "10007",
                "tuan_title": "【望潜交口】11枝玫瑰花束1束，提供免费WiFi",
                "tuan_price": "49.00",
                "tuan_number": "1",
                "use_time": "0",
                "tuan_photo": ""
            },
            "photo": "photo/201603/20160326_B23187DCEB749F68797DEDD77B8898D4.jpg",
            "quan": [
                {
                    "ticket_id": "17",
                    "uid": "47",
                    "shop_id": "10003",
                    "tuan_id": "10007",
                    "order_id": "100324",
                    "number": "971517",
                    "count": "1",
                    "ltime": "1461641690",
                    "use_time": "0",
                    "status": "0",
                    "dateline": "1459827536"
                }
            ]
        }
    },
    "error": "0",
    "message": "success"
}
```

<br />
************
######<a name="client/member/updatemobile">更换手机(client/member/updatemobile)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| sms_code | 是 | string |  手机验证码  |
| new_mobile | 是 | string |  会员新手机  |
>>请求示例
>
```javascript
{
    "sms_code":"1234",
    "new_mobile":"13888888888"
}
```
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success'
}
```


<br />
************
######<a name="client/member/uploadface">上传头像(client/member/uploadface)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| face | 是 | string |  头像文件的二进制转base64字符串  |
>>请求示例
>
```javascript
{
    "face":"AAAAAAAAAAAAAAAAAAAA"
}
```
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success'
}
```


<br />
************
######<a name="client/member/updatename">修改昵称(client/member/updatename)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| nickname | 是 | string |  新昵称  |
>>请求示例
>
```javascript
{
    "nickname":"江湖游医"
}
```
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success'
}
```

<br />
************
######<a name="client/member/passwd">修改密码(client/member/passwd)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| sms_code | 是 | string |  手机验证码  |
| new_passwd | 是 | string |  会员新密码  |
>>请求示例
>
```javascript
{
    "sms_code":"1234",
    "new_passwd":"123456"
}
```

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success'
}
```


<br />
************
######<a name="client/member/info">会员信息(client/member/info)</a>
>>请求参数（无业务参数）
>
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| uid | int |  用户UID  |
| nickname | string |  会员昵称  |
| face | string |  会员头像  |
| mobile | string |  手机号  |
| money | float |  账户余额  |
| jifen | int |  账户积分  |
| wx_openid | string |  微信OPENID，绑定过微信的用户会有该值，空则表示未绑定微信帐号  |
| loginip | string |  最后登录IP  |
| lastlogin | int |  最后登录时间  |
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
          "uid":"888",
          "nickname":"江湖游医"，
          "face":"face/default.png",
          "mobile":"13888888888",
          "money":"10000",
          "jifen":"8000",
          "wx_openid":"oNk4bty65hyRufxmobUpND8H6iaE",
          "loginip":"127.0.0.1",
          "lastlogin":"1448442014",
          "hongbao_count" : "10",
          "msg_new_count" : "10",
          "order_comment_count" : "10"
	}
}
```



<br />
************
######<a name="client/member/bindweixin">绑定微信(client/member/bindweixin)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| wx_openid | 是 | string |  微信OPENID  |
| wx_nickname | 否 | string |  微信昵称  |
| wx_face | 否 | string |  微信会员头像  |
>>请求示例
>
```javascript
{
    "wx_openid":"oNk4bty65hyRufxmobUpND8H6iaE",
    "wx_nickname":"江湖游医",
    "wx_face":"http://wx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFq"
}
```
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success'
}
```

<br />
************
######<a name="client/member/nobibindweixin">解绑微信(client/member/nobindweixin)</a>
>>无请求参数
>

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success'
}
```

<br />
************
######<a name="client/member/msg">会员消息(client/member/msg)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| type | 否 | int | 0:所有消息 1:红包消息, 2:订单消息,3:其它消息  |
| is_read | 否 | int |  0:新消息,1:已读,2:所有  |
| page | 否 | int |  页码 默认第1页  |
>>请求示例
>
```javascript
{
    "type":"0",
    "is_read":"0",
    "page":"1"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| message_id | int |  消息ID  |
| uid | int |  用户UID  |
| title | string |  消息标题  |
| content | string |  消息内容  |
| type | int |  消息类型  `0:所有消息 1:红包消息, 2:订单消息,3:其它消息` |
| is_read | int |  是否已读 `0:未读 1:已读`  |
| dateline | int |  收到消息的UNIXTIME  |
>
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success'
    'data':{
        "items":[
            {
                "message_id":"1",
                "uid":"888",
                "title":"恭喜你获得一个10元",
                "content":"红包金额10元,可用于支付时抵扣相应的金额",
                "type":"1",
                "is_read":"0",
                "dateline":"1445405891"
            },
            {
                "message_id":"2",
                "uid":"888",
                "title":"恭喜你获得一个10元",
                "content":"红包金额10元,可用于支付时抵扣相应的金额",
                "type":"1",
                "is_read":"0",
                "dateline":"1445405891"
            }
            ]
        },
        "total_count":"300"
    }
}
```


<br />
************
######<a name="client/member/readmsg">阅读消息(client/member/readmsg)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| message_id | 是 | int |  消息ID  |
>>请求示例
>
```javascript
{
	"message_id":"1"
}
```
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
        "message_id":"1",
        "uid":"888",
        "title":"恭喜你获得一个10元",
        "content":"红包金额10元,可用于支付时抵扣相应的金额",
        "type":"1",
        "is_read":"0",
        "dateline":"1445405891"
    }
}
```


<br />
************
######<a name="client/member/collect">我的收藏(client/member/collect)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| page | 否 | int |  页码  |
>>请求示例
>
```javascript
{
	"page":"1"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| shop_id | int |  商户ID  |
| city_id | int |  城市ID  |
| city_name | string |  城市  |
| cate_id | int |  分类ID  |
| cate_name | string |  分类  |
| title | string |  商户名称  |
| phone | string |  商户电话  |
| logo | string |  商户LOGO  |
| lat | string |  坐标纬度  |
| lng | string |  坐标经度  |
| addr | string |  地址  |
| score | int |  综合总评分，星星可以除以 评论数  |
| comments | int |  评论数   |
| min_amount | float |  起送价  |
| first_amount | float |  首单优惠  |
| pei_amount | float |  配送费用`0:免配送费`  |
| pei_type | int |  配送类型 `0:商家自己送,1:第三方配送,2:配送员代购`|
| yy_status | int |  营业状态 `0:打烊, 1:营业`  |
| yy_stime | time |  开始营业时间  |
| yy_ltime | time | 结束营业时间  |
| online_pay | int |  是否支持在线支付 `0:不支持, 1:支持在线支付`  |
| info | string |  商户描述  |

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success'
    "data":{
        "items":[
            {
                "shop_id":"1",
                "city_id":"7",
                "city_name":"合肥"
                "cate_id":"2",
                "cate_title":"快餐",
                "title":"江湖客栈",
                "phone":"0551-64278115",
                "logo":"photo/20151111/1111.jpg",
                "lat":"111.123456",
                "lng":"111.123456",
                "addr":"望江西路华润五彩国际904",
                "score":"88888",
                "comments":"50000",
                "orders":"100000",
                "min_amount":"10",
                "first_amount":"10",
                "pei_amount":"0",
                "pei_type":"1",
                "yy_status":"1",
                "yy_stime":"9:00",
                "yy_ltime":"20:00",
                "online_pay":"1",
                "info":"店铺介绍店铺介绍店铺介绍店铺介绍"
            },
            {
                "shop_id":"2",
                "city_id":"7",
                "cate_name":"合肥"
                "cate_id":"2",
                "cate_title":"快餐",
                "title":"江湖酒馆",
                "phone":"0551-64278115",
                "logo":"photo/20151111/1111.jpg",
                "lat":"111.123456",
                "lng":"111.123456",
                "addr":"望江西路华润五彩国际904",
                "score":"88888",
                "comments":"50000",
                "orders":"100000",
                "first_amount":"30",
                "pei_amount":"0",
                "pei_type":"1",
                "yy_status":"1",
                "yy_stime":"9:00",
                "yy_ltime":"20:00",
                "online_pay":"1",
                "info":"店铺介绍店铺介绍店铺介绍店铺介绍"
            }
            ]
        },
        "total_count":"30"
    }
}
```


<br />
************
######<a name="client/member/collect/add">添加收藏(client/member/collect/add)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| shop_id | 是 | int |  商户ID  |
>>请求示例
>
```javascript
{
    "shop_id":"1"
}
```
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success'
}
```

<br />
************
######<a name="client/member/collect/cancel">取消收藏(client/member/collect/cancel)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| shop_id | 是 | int |  商户ID  |
>>请求示例
>
```javascript
{
	"shop_id":"1"
}
```
>>返回示例
>
```javascript
{
'error':'0',
'message':'success'
}
```



<br />
************
######<a name="client/member/jifen/log">积分日志(client/member/jifen/log)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| page | 否 | int |  分页码  |
>>请求示例
>
```javascript
{
	"page":"1"
}
```
>>返回示例
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| log_id | int | 日志ID |
| uid | int| 会员ID |
| type | string| 类型 `money:余额, jifen:积分` |
| number | int | 变动数值 |
| intro | string | 变动原因 |
| dateline | int| 变动时间 UNIXTIME |
| jifen | int | 当前帐户积分 |
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
    	"items" : [
        	{
            	"log_id" : "1",
                "uid" : "888",
                "type" : "jifen",
                "number" : "-3000",
                "intro" : "兑换商品野餐包（单号：111）",
                "dateline" : "140000000"
            },
            {
            	"log_id" : "2",
                "uid" : "888",
                "type" : "jifen",
                "number" : "300",
                "intro" : "在线支付赠送积分(单号:1234)",
                "dateline" : "140000001"
            }
        ],
        "jifen" : "200",
        "total_count" : "30"
    }
}
```



<br />
************
######<a name="client/member/jifen/rule">积分规则(client/member/log/jifen)</a>
>>无请求参数
>

>>返回示例
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| url | string | 规则地址 |
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
        "url" : "http://snsjdskjdfsndfknksf.com"
    }
}
```



<br />
************
######<a name="client/member/addr">地址列表(client/member/addr)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| page | 否 | int |  分页码  |
>>请求示例
>
```javascript
{
	"page":"1"
}
```
>>返回示例
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| addr_id | int | 地址ID |
| uid | int| 会员ID |
| contact | string| 联系人 |
| mobile | string | 联系电话 |
| addr | string | 地址 |
| house | string | 小区门牌 |
| is_default | int | 是否为默认地址 `1：默认地址` |
| lat | string| 坐标纬度 |
| lng | string | 坐标经度 |
>
```javascript
{
    'error':'0',
    'message':'success'
    "data":{
    	"items":[
        	{
            	"addr_id":"1",
                "uid" : "888",
                "contact":"游医",
                "mobile":"13812345678",
                "addr" : "安徽省合肥市蜀山区望江西路",
                "house" : "华润五彩国际",
                "is_default" : "1",
                "lat" : "111.123456",
                "lng" : "111.123456"
            },
        	{
            	"addr_id":"2",
                "uid" : "888",
                "contact":"游医",
                "mobile":"13812345678",
                "addr" : "安徽省合肥市蜀山区望江西路",
                "house" : "华润五彩国际",
                "is_default" : "1",
                "lat" : "111.123456",
                "lng" : "111.123456"
            }
        ],
        "total_count" : "30"
    }
}
```

<br />
************
######<a name="client/member/addr/create">创建地址(client/member/addr/create)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| contact | 是 | string| 联系人 |
| mobile | 是 | string | 联系电话 |
| addr | 是 | string | 地址 |
| house | 是 | string | 小区门牌 |
| is_default | 否 | int | 是否为默认地址 `1：默认地址` |
| lat | 是 | string| 坐标纬度 |
| lng | 是 | string | 坐标经度 |
>>请求示例
>
```javascript
{
    "contact":"游医",
    "mobile":"13812345678",
    "addr" : "安徽省合肥市蜀山区望江西路",
    "house" : "华润五彩国际",
    "is_default" : "1",
    "lat" : "111.123456",
    "lng" : "111.123456"
}
```
>>返回示例
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| addr_id | int | 地址ID |
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
    	"addr_id" : "1"
    }
}
```

<br />
************
######<a name="client/member/addr/update">修改地址(client/member/addr/update)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| addr_id | 是 | int| 地址ID |
| contact | 是 | string| 联系人 |
| mobile | 是 | string | 联系电话 |
| addr | 是 | string | 地址 |
| house | 是 | string | 小区门牌 |
| is_default | 否 | int | 是否为默认地址 `1：默认地址` |
| lat | 是 | string| 坐标纬度 |
| lng | 是 | string | 坐标经度 |
>>请求示例
>
```javascript
{
    "addr_id":"1",
    "contact":"游医",
    "mobile":"13812345678",
    "addr" : "安徽省合肥市蜀山区望江西路",
    "house" : "华润五彩国际",
    "is_default" : "1",
    "lat" : "111.123456",
    "lng" : "111.123456"
}
```
>>返回示例
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| addr_id | int | 地址ID |
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
    	"addr_id" : "1"
    }
}
```

<br />
************
######<a name="client/member/addr/detail">地址详情(client/member/addr/detail)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| addr_id | 是 | int |  地址ID  |
>>请求示例
>
```javascript
{
	"addr_id":"1"
}
```
>>返回示例
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| addr_id | int | 地址ID |
| uid | int| 会员ID |
| contact | string| 联系人 |
| mobile | string | 联系电话 |
| addr | string | 地址 |
| house | string | 小区门牌 |
| is_default | int | 是否为默认地址 `1：默认地址` |
| lat | string| 坐标纬度 |
| lng | string | 坐标经度 |
>
```javascript
{
    'error':'0',
    'message':'success',
    "data":{
            "addr_id":"1",
            "uid" : "888",
            "contact":"游医",
            "mobile":"13812345678",
            "addr" : "安徽省合肥市蜀山区望江西路",
            "house" : "华润五彩国际",
            "is_default" : "1",
            "lat" : "111.123456",
            "lng" : "111.123456"
    	}
    }
}
```

<br />
************
######<a name="client/member/addr/delete">删除地址(client/member/addr/delete)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| addr_id | 是 | int |  地址ID  |
>>请求示例
>
```javascript
{
	"addr_id":"1"
}
```
>>返回示例

>
```javascript
{
    'error':'0',
    'message':'success'
}
```

<br />
************
######<a name="client/member/addr/default">默认地址(client/member/addr/default)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| addr_id | 是 | int |  地址ID  |
>>请求示例
>
```javascript
{
	"addr_id":"1"
}
```
>>返回示例

>
```javascript
{
    'error':'0',
    'message':'success'
}
```

<br />
************
######<a name="client/member/hongbao">红包列表(client/member/hongbao)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| type | 否 | int |  红包类型 `0:全部, 其它数值保留扩展用`  |
| status | 否 | int |  有效果的 `0:所有的，1:有效的（未使用，未过期的）, 2:无效的(过期的，已使用的)` |
| page | 否 | int |  分页码  |
>>请求示例
>
```javascript
{
	"type" : "0",
    "status" : "1",
	"page":"1"
}
```
>>返回示例
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| hongbao_id | int | 日志ID |
| title | string | 红包名称 |
| min_amount | float | 订单可用最小金额 |
| amount | float | 面值 |
| type | int | 类型  |
| uid | int| 会员ID |
| stime | int | 开始使用时间UNIXTIME |
| ltime | int | 结束使用时间UNIXTIME |
| order_id | int | 使用的订单号 `0:未使用` |
| used_time | int | 使用时间UNIXTIME |

>>请求示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
    	"items" : [
        	{
            	"hongbao_id" : "1",
                "title" : "新手红包",
                "min_amount" : "20",
                "amount" : "5",
                "type" : "1",
                "uid" : "888",
                "stime" : "140000000",
                "ltime" : "140000011"
                "order_id" : "0",
                "used_time" : "0",
                "dateline" : "140000000"
            },
            {
            	"hongbao_id" : "1",
                "title" : "新手红包",
                "min_amount" : "20",
                "amount" : "5",
                "type" : "1",
                "uid" : "888",
                "stime" : "140000000",
                "ltime" : "140000011"
                "order_id" : "111",
                "used_time" : "140000000",
                "dateline" : "140000000"
            }
        ]
        "total_count" : "30"
    }
}
```

<br />
************
######<a name="client/member/hongbao/exchange">红包兑换(client/member/hongbao/exchange)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| sn | 是 | string |  红包兑换码  |
>>请求示例
>
```javascript
{
	"sn":"JH88888888"
}
```
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" {
    	"hongbao_id" : "11"
    }
}
```

<br />
************
######<a name="client/member/hongbao/rule">红包规则(client/member/hongbao/rule)</a>
>>无请求参数
>
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" {
    	"url" : "http://dfnklsnfsdf.com"
    }
}
```




<br />
************
######<a name="client/member/log/money">资金日志(client/member/log/money)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| page | 否 | int |  分页码  |
>>请求示例
>
```javascript
{
	"page":"1"
}
```
>>返回示例
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| log_id | int | 日志ID |
| uid | int| 会员ID |
| type | string| 类型 `money:余额, jifen:积分` |
| number | float | 变动数值 |
| intro | string | 变动原因 |
| dateline | int| 变动时间 UNIXTIME |
| money | int | 当前帐户余额 |
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
    	"items" : [
        	{
            	"log_id" : "1",
                "uid" : "888",
                "type" : "-money",
                "number" : "30",
                "intro" : "订单余额支付（单号：111）",
                "dateline" : "140000000"
            },
            {
            	"log_id" : "2",
                "uid" : "888",
                "type" : "money",
                "number" : "100",
                "intro" : "在线充值（alipay:201511111234）",
                "dateline" : "140000001"
            }
        ],
        "money" : "200",
        "total_count" : "30"
    }
}
```




<br />
************
######<a name="client/member/feedback">意见反馈(client/member/feedback)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| str | 是 | string |  反馈的意见  |
>>请求示例
>
```javascript
{
	"str":"我对你们的这个建议很大，我要提交。"
}
```
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success'
}
```


<br />
************
######<a name="client/mall/cate">商城分类(client/mall/cate)</a>
>>请求参数无
>
>
>>返回示例
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| cate_id | int | 分类ID |
| title | string | 分类名称 |
| icon | string | 分类ICON图标 |

>>请求示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
    	"items" : [
        	{
            	"cate_id" : "1",
                "title" : "分类1",
                "icon" : "photo/201511/20151111_xxxx.png",
            },
            {
            	"cate_id" : "2",
                "title" : "分类2",
                "icon" : "photo/201511/20151111_xxxx.png",
            }
        ]
        "version" : "201511111"
    }
}
```

<br />
************
######<a name="client/mall/product">商城商品(client/mall/product)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| cate_id | 否 | int |  订单状态 `0:全部` |
| page | 否 | int | 分页码 |

>>请求示例
>
```javascript
{
    "cate_id" : "1",
    "page" : "1"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| product_id | int | 商品ID |
| cate_id | int | 分类ID |
| title | string | 商品名称 |
| photo | string | 商品图片 |
| jifen | int | 需要积分 |
| info | string | 商品描述 |
| views | int | 浏览数 |
| sales | int | 销量（兑换数） |
>
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
    	"items" : [
        	{
            	"product_id" : "1",
                "cate_id" : "11",
                "title" : "分类1",
                "icon" : "photo/201511/20151111_xxxx.png",
                "jifen" : "100",
                "info" : "这是商品的描述",
                "views" : "120",
                "sales" : "11",
            },
        	{
            	"product_id" : "1",
                "cate_id" : "11",
                "title" : "分类1",
                "icon" : "photo/201511/20151111_xxxx.png",
                "jifen" : "100",
                "info" : "这是商品的描述",
                "views" : "120",
                "sales" : "11",
            }
        ]
        "total_count" : "30"
    }
}
```

<br />
************
######<a name="client/mall/product/detail">商品详情(client/mall/product/detail)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| product_id | 是 | int | 商品ID |
| page | 否 | int | 分页码 |

>>请求示例
>
```javascript
{
    "product_id" : "1"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| product_id | int | 商品ID |
| cate_id | int | 分类ID |
| title | string | 商品名称 |
| photo | string | 商品图片 |
| jifen | int | 需要积分 |
| info | string | 商品描述 |
| views | int | 浏览数 |
| sales | int | 销量（兑换数） |
>
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
        "product_id" : "1",
        "cate_id" : "11",
        "title" : "分类1",
        "icon" : "photo/201511/20151111_xxxx.png",
        "jifen" : "100",
        "info" : "这是商品的描述",
        "views" : "120",
        "sales" : "11"
    }
}
```

<br />
************
######<a name="client/mall/order/create">商品兑换(client/mall/order/create)</a>
>>请求参数无
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| product_id | 是 | int | 商品ID |
| product_number | 是 | int | 兑换数量 |
| addr_id | 是 | int | 地址ID |

>>请求示例
>
```javascript
{
    "product_id" : "1",
    "product_number" : "1",
    "addr_id" : "1"
}
```
>
>>返回示例
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| order_id | int | 订单ID |

>>请求示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
		"order_id" : "1"
    }
}
```

<br />
************
######<a name="client/mall/order/items">兑换记录(client/mall/order/items)</a>
>>请求参数无
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| page | 否 | int | 分页码 |
>>请求示例
>
```javascript
{
    "page" : "1"
}
```
>
>>返回示例
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| order_id | int | 订单ID |
| uid | int | 会员ID |
| product_id | int | 商品ID |
| product_number | int | 商品数量 |
| product_name | string | 商品名称 |
| contact | string | 联系人 |
| mobile | string | 联系电话 |
| addr | string | 配送地址 |
| dateline | int | 下单时间 |

>>请求示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
		"items" :[
        	{
            	"order_id" : "1",
                "uid" : "888",
                "product_id" : "1",
                "product_name" : "野餐垫",
                "product_jifen" : "100",
                "product_number" : "10",
                "contact" : "游医",
                "mobile" : "13812345678",
                "addr" : "华润五彩国际904",
                "dateline" : "1400000000"
            },
        	{
            	"order_id" : "2",
                "uid" : "888",
                "product_id" : "1",
                "product_name" : "野餐垫",
                "product_jifen" : "100",
                "product_number" : "10",
                "contact" : "游医",
                "mobile" : "13812345678",
                "addr" : "华润五彩国际904",
                "dateline" : "1400000000"
            }
        ],
        "total_count" : "30"
    }
}
```

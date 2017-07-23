商户端API接口文档
==============

| 分组 | 接口 | API |登录权限 |
|:-----------:|------------------|------------------ |:--------------:|
|   基础    | 测试接口	| [biz/app/test](#bzi/app/test)	|  否  |
|   基础    | 基础信息	| [biz/app/info](#biz/app/info)	|  否  |
|   帐号    | 商户登录    | [biz/account/login](#biz/account/login)| 是  |
|   帐号    | 申请入住    | [biz/account/signup](#biz/account/signup)|  是  |
|   帐号    | 找回密码    | [biz/account/forgot](#biz/account/forgot)|  是  |
|   帐号    | 修改密码    | [biz/shop/updatepasswd](#biz/shop/updatepasswd)|  是  |
|   帐号    | 更换手机    | [biz/shop/updatemobile](#biz/shop/updatemobile)|  是  |
|   帐号    | 商户信息    | [biz/info](#biz/info)|  是  |
|   设置    | 基本资料    | [biz/shop/base](#biz/shop/base)|  是  |
|   设置    | 营业设置    | [biz/shop/yingye](#biz/shop/yingye)|  是  |
|   设置    | 公告优惠    | [biz/shop/info](#biz/shop/info)|  是  |
|   设置    | 起配设置    | [biz/shop/pei](#biz/shop/pei)|  是  |
|   设置    | 优惠设置    | [biz/shop/youhui](#biz/shop/youhui)|  是  |
|   设置    | 账户设置    | [biz/shop/account](#biz/shop/account)|  是  |
|   认证    | 店主认证  | [biz/verify/dianzhu](#biz/verify/dianzhu) |  是  |
|   认证    | 商户认证  | [biz/verify/yyzz](#biz/verify/yyzz) |  是  |
|   认证    | 餐饮认证 | [biz/verify/canyin](#biz/verify/canyin) |  是  |
|   认证    | 认证信息 | [biz/verify/canyin](#biz/verify) |  是  |
|   订单    | 订单列表  | [biz/order/items](#biz/order/items) |  是  |
|   订单    | 订单接单  | [biz/order/detail](#biz/order/detail) |  是  |
|   订单    | 订单接单  | [biz/order/jiedan](#biz/order/jiedan) |  是  |
|   订单    | 订单取消  | [biz/order/cancel](#biz/order/cancel) |  是  |
|   订单    | 订单配送  | [biz/order/pei](#biz/order/pei) |  是  |
|   订单    | 自己配送  | [biz/order/qiang](#biz/order/qiang) |  是  |
|   订单    | 订单送达  | [biz/order/delivered](#biz/order/delivered) |  是  |
|   订单    | 批量更新  | [biz/order/batch](#biz/order/batch) |  是  |
|   订单    | 订单提醒  | [biz/order/tixing](#biz/order/tixing) |  是  |
|   商品    | 分类管理  | [biz/cate/items](#biz/cate/items) |  是  |
|   商品    | 添加分类  | [biz/cate/create](#biz/cate/create) |  是  |
|   商品    | 修改分类  | [biz/cate/update](#biz/cate/update) |  是  |
|   商品    | 删除分类  | [biz/cate/delete](#biz/cate/delete) |  是  |
|   商品    | 商品管理  | [biz/product/items](#biz/product/items) |  是  |
|   商品    | 添加商品  | [biz/product/create](#biz/product/create) |  是  |
|   商品    | 修改商品  | [biz/product/update](#biz/product/update) |  是  |
|   商品    | 删除商品 | [biz/product/delete](#biz/product/delete) |  是  |
|   客户    | 我的粉丝 | [biz/member/fans](#biz/member/fans) |  是  |
|   客户    | 我的客户 | [biz/member/order](#biz/member/order) |  是  |
|   客户    | 客户详情 | [biz/member/detail](#biz/member/detail) |  是  |
|   资金    | 资金日志 | [biz/money/log](#biz/money/log) |  是  |
|   资金    | 提现日志 | [biz/money/txlog](#biz/money/tixian) |  是  |
|   资金    | 资金提现 | [biz/money/tixian](#biz/money/tixian) |  是  |
|   统计    | 资金统计 | [biz/tongji/money](#biz/tongji/money) |  是  |
|   统计    | 订单统计 | [biz/tongji/order](#biz/tongji/order) |  是  |
|   统计    | 来源统计 | [biz/tongji/source](#biz/tongji/source) |  是  |
|   统计    | 资金统计 | [biz/tongji/product](#biz/tongji/product) |  是  |
|   消息    | 消息管理 | [biz/msg/items](#biz/msg/items) |  是  |
|   消息    | 阅读消息 | [biz/msg/read](#biz/msg/read) |  是  |
|   评价    | 评价管理 | [biz/comment/items](#biz/comment/items) |  是  |
|   评价    | 评价详情 | [biz/comment/detail](#biz/comment/detail) |  是  |
|   评价    | 回复评价 | [biz/comment/reply](#biz/comment/reply) |  是  |
|   系统    | 系统通知 | [biz/shop/notice](#biz/shop/notice) |  是  |

<br />
************
######<a name="biz/app/test/">数据版本(data/version)</a>
>>请求示例
>
>>返回数据
>
```javascript
{
    'error':'0',
    'message':'success',
}
```


<br />
************
######<a name="biz/account/login">帐号登录(biz/account/login)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| mobile | 是 | string |  手机号码  |
| passwd | 是 | string |  登录密码  |
>>请求示例
>
```javascript
{
	"mobile" : "13888888888",
    "passwd" : "123456"
}
```
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
          "shop_id":"888",
          "title":"商铺名称"，
          "logo":"photo/default.png",
          "mobile":"13888888888"，
          "token":"888-A2D28B1CA20DC547425343D2ACAFE540"
    }
}
```

<br />
************
######<a name="biz/account/signup">申请入住(biz/account/signup)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| contact | 是 | string |  手机号码  |
| mobile | 是 | string |  手机号码  |
| sms_code | 是 | string |  验证码  |
| title | 是 | string |  店铺名称  |
| phone | 是 | string |  服务电话  |
| cate_id | 是 | int |  店铺分类  |
| addr | 是 | string |  店铺地址  |
| lng | 是 | string |  经度  |
| lat | 是 | string |  纬度  |
| intro | 是 | string |  店铺介绍  |
>>请求示例
>
```javascript
{
	"contact" : "游医",
	"mobile" : "13888888888",
    "sms_code" : "1234",
    "title" : "店铺名称",
    "phone" : "0551-64278115",
    "addr" : "合作化路望江路",
    "lng" : "111.1213456",
    "lat" : "111.123456",
    "intro" : "店铺介绍"
}
```
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
          "shop_id":"888"
    }
}
```

<br />
************
######<a name="biz/account/forgot">找回密码(biz/account/forgot)</a>
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
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
          "shop_id":"888"
    }
}
```

<br />
************
######<a name="biz/info">商户信息(biz/info)</a>
>>请求参数
>无
>>返回参数
>
| 参数名称 | 类型 |描述 |
|--------|:-------:|------|
| shop_id | int |  商户ID  |
| city_id | int |  城市ID  |
| city_name | string |  城市  |
| cate_id | int |  分类ID  |
| cate_name | string |  分类  |
| title | string |  商户名称  |
| mobile | string |  登录手机号  |
| phone | string |  商户电话  |
| money | float |  帐户余额 |
| total_money | float |  总收益  |
| logo | string |  商户LOGO  |
| lat | string |  坐标纬度  |
| lng | string |  坐标经度  |
| addr | string |  地址  |
| praise_num | int |  好评数   |
| score | int |  综合总评分，星星可以除以 评论数  |
| score_kouwei | int |  口味总评分 ，星星可以除以 评论数 |
| comments | int |  评论数   |
| pei_time | int |  平均配送时间   |
| min_amount | float |  起送价  |
| first_amount | float |  首单优惠  |
| youhui | array |  优惠  |
| pei_amount | float |  配送费用`0:免配送费`  |
| pei_type | int |  配送类型 `0:商家自己送,1:第三方配送,2:配送员代购`|
| yy_status | int |  营业状态 `0:打烊, 1:营业`  |
| yy_stime | time |  开始营业时间  |
| yy_ltime | time | 结束营业时间  |
| is_new | int |  新店  |
| online_pay | int |  是否支持在线支付 `0:不支持, 1:支持在线支付`  |
| info | string |  商户描述  |
| pmid | string |  邀请人推广码 |
| pid | string |  推广码， 自己推广时用  |
| audit | int |  审核 `0:待审, 1:通过`  |
| account | object | 体现账户信息 |
| order_jie_count | int |  待接订单  |
| order_pei_count | int |  待配送订单  |
| order_end_count | int |  完成订单  |
| msg_new_count | int |  新消息数  |
>
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data":{
        "shop_id"	 : "1",
        "city_id"	 : "1",
        "city_name"	 : "合肥",
        "cate_id"	 : "1",
        "cate_name"  : "快餐",
        "mobile"	 : "1388888888",
        "phone"		 : "64278115",
        "title"		 : "江湖外卖旗舰店",
        "money"		 : "888.88",
        "total_money": "198888.88",
        "logo"		 : "photo/201512/logo.png",
        "lat"		 : "123.111111",
        "lng"		 : "123.111111",
        "addr"		 : "合作化路望江路华润五彩国际904",
        "views"		 : "98000",
        "orders"	 : "3000",
        "comments"	 : "1000",
        "praise_num" : "500",
        "score"		 : "8000",
        "score_kouwei" : "2000",
        "first_amount" : "5",
        "min_amount"   : "20",
        "freight"	 : "0",
        "pei_amount" : "5",
        "pei_time"	 : "30",
        "pei_type"	 : "1",
        "pei_distance" : "5",
        "yy_stime"	 : "9:00",
        "yy_ltime"	 : "21:30",
        "is_new"	 : "1",
        "youhui"	 : [],
        "online_pay" : "1",
        "info"	 : "店铺介绍",
        "pmid"	 : "",
        "audit"	 : "0",
        "pid"	 : "S00001",
        "account" : {
        	"account_type":"支付宝",
            "account_number" : "ijianghu@qq.com",
            "account_name" : "江湖信息科技"
        }
        "order_jie_count" : "10",
        "order_pei_count" : "50",
        "order_end_count" : "2000",
        "msg_new_count"	  : "10"
    }
}
```


<br />
************
######<a name="biz/shop/passwd">修改密码(biz/shop/passwd)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| sms_code | 是 | string |  手机验证码  |
| new_passwd | 是 | string |  新密码  |
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
######<a name="biz/shop/updatemobile">更换手机(biz/shop/updatemobile)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| passwd | 是 | string |  登录密码  |
| sms_code | 是 | string |  新手机验证码  |
| new_mobile | 是 | string |  会员新手机  |
>>请求示例
>
```javascript
{
    "passwd":"1234",
    "sms_code": "4321",
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
######<a name="biz/shop/base">基本设置(biz/shop/base)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| title | 否 | string |  商铺名称  |
| cate_id | 否 | int |  商铺分类  |
| logo | 否 | string |  商铺LOGO(base64)  |
| phone | 否 | string |  客服电话  |
| addr | 否 | string |  商铺地址  |
| lng | 否 | string |  经度  |
| lat | 否 | string |  纬度  |
>>请求示例
>
```javascript
{
    "title":"商铺名称",
    "intro": "商铺介绍",
    "logo":"base64/image",
    "addr": "华润五彩国际",
    "lng" : "经度",
    "lat" : "纬度"
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
######<a name="biz/shop/yingye">营业设置(biz/shop/yingye)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| yy_status | 否 | int |  营业状态 `0:打烊, 1:营业`  |
| stime | 否 | time |  营业开始时间  |
| ltime | 否 | time |  营业结束时间  |
>>请求示例
>
```javascript
{
    "yy_status":"1",
    "stime": "09:00",
    "ltime":"21:30"
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
######<a name="biz/shop/info">营业设置(biz/shop/info)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| info | 否 | string |  公告优惠  |
>>请求示例
>
```javascript
{
    "info":"公告优惠"
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
######<a name="biz/shop/pei">配送设置(biz/shop/pei)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| min_amount | 否 | float |  启送金额  |
| pei_distance | 否 | float | 配送范围,公里 |
| freight | 否 | float |  配送费用 `0:免配送费` |
| pei_type | 否 | int |  配送方式 `0:自己送, 1:平台送, 2:配送员代购` |
| pei_amount | 否 | float |  平台送时出的配送费  |
>>请求示例
>
```javascript
{
    "min_amount":"20",
    "pei_distance" : "5",
    "freight" : "0",
    "pei_type" : "1",
    "pei_amount" : "5"
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
######<a name="biz/shop/youhui">配送设置(biz/shop/youhui)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| online_pay | 否 | int |  是否支持在线支付 `0:不支持 1：支持` |
| first_amount | 否 | float | 首单优惠 |
| order_youhui | 否 | string |  满减优惠 `满:减,满:减`  |
>>请求示例
>
```javascript
{
    "online_pay":"1",
    "first_amount" : "10",
    "order_youhui" : "20:5,30:10,50:20"
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
######<a name="biz/shop/account">提现帐号(biz/shop/account)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| account_type | 是 | string |  开户行  |
| account_name | 是 | string |  开户人  |
| account_number | 是 | string |  帐号  |
>>请求示例
>
```javascript
{
    "account_type":"支付宝",
    "account_name" : "江湖信息科技",
    "account_number": "ijianghu@qq.com"
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
######<a name="biz/verify">认证信息(biz/verify)</a>
>>请求参数
>
>>返回参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| shop_id | string |  开户行  |
| id_name | string |  姓名  |
| id_photo | string |  身份证图  |
| id_number | string |  身份证号  |
| shop_photo | string |  店铺图片（实景图片）  |
| verify_dianzhua | int | 店主认证状态 `0:待审核，1:审核通过, 2:审核失败` |
| yz_number | string |  营业执照号  |
| yz_photo | string |  营业执照图片 |
| verify_yyzz | int |  营业执照审核状态 `0:待审核，1:审核通过, 2:审核失败` |
| cy_number | string |  餐饮证件照号  |
| cy_photo | string |  餐饮执照图片 |
| verify_cy | int |  餐饮执照审核状态 `0:待审核，1:审核通过, 2:审核失败` |
| verify | int |  店铺验证状态 `0:待审核，1:审核通过, 2:审核失败` |
| refuse | string |  验证退回原因 |
| verify_time | int |  验证通过时间 |
| updatetime | int |  申请验证时间 |

>
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
        "shop_id": "88",
        "id_name" : "张三",
        "id_photo": "photo/xxx.png",
        "id_number" : "123456789",
        "verify_dianzhu" : "2",
        "yz_number" : "",
        "yz_photo" : "",
        "verify_yyzz" : "0",
        "cy_number" : "",
        "cy_photo" : "",
        "verify_cy":"0",
        "verify" : "2",
        "refuse": "照片不清楚",
        "verify_time" : "0",
        "updatetime" : ""
    }
}
```


<br />
************
######<a name="biz/order/items">订单列表(biz/order/items)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| status | 否 | int |  订单状态 `0:全部, 1:待接单, 2:进行中的, 3:已完成的` |
| page | 否 | int | 分页码 |

>>请求示例
>
```javascript
{
    "status" : "1",
    "page" : "1"
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
| money | float | 余额抵扣 |
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
| order_status | int | 订单状态 `-1:已取消，0：未处理，1：已接单，2：已配货，3：配送开始，4：配送完成，8：订单完成` |
| order_status_label | string | 订单状态描述 |
| pay_status | int | 支付状态  `0:未支付, 1:已支付` |
| online_pay | int | 付款方式 `0:货到付款, 1:在线支付` |
| pay_code | string | 支付类型 `wxpay:微信, alipay:支付宝, money:余额` |
| pay_time | int | 支付时间UNIXTIME `当pay_status=1时有值` |
| staff_id | int | 配送员ID  |
| pei_type | string | 配送类型 `0:商家自己送, 1:第三方配送, 2:配送员代购` |
| comment_status | int | 评价状态 `0:未评价, 1:已经评价` |
| dateline | int | 下单时间UNIXTIME |
| staff | array | 商户信息 [查看字典](#table.staff)|
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
		"items" : [
        	{
                "order_id" : "1",
                "city_id" : "7",
                "shop_id" : "111",
                "uid" : "888",
                "product_number" : "10",
                "product_price" : "100",
                "freight" : "0",
                "money" : "0",
                "amount" : "70",
                "order_youyi" : "10"
                "first_youhui" : "10",
                "hongbao" : "10",
                "hongbao_id" : "22",
                "contact" : "游医",
                "mobile" : "138121345678",
                "addr" : "安徽省合肥市蜀山区望江西路",
                "house" : "华润五彩国际",
                "lat" : "111.123456",
                "lng" : "111.123456",
                "note" : "少放辣椒，多加米饭",
                "order_status" : "2",
                "pay_status" : "1",
                'online_pay' : "1",
                "pay_code" : "wxpay"
                "pay_time" : "1400000011"
                "staff_id" : "111"
                "pei_type" : "1"
                "dateline" : "1400000000",
                "staff" : {
                    "staff_id" : "111"，
                    "name" : "游医",
                    "mobile" : "1388888888",
                    "lng" : "11.123456",
                    "lat" : "123.1213456"
                }
            },
        	{
                "order_id" : "2",
                "city_id" : "7",
                "shop_id" : "111",
                "uid" : "888",
                "product_number" : "10",
                "product_price" : "100",
                "freight" : "0",
                "money" : "0",
                "amount" : "70",
                "order_youyi" : "10"
                "first_youhui" : "10",
                "hongbao" : "10",
                "hongbao_id" : "22",
                "contact" : "游医",
                "mobile" : "138121345678",
                "addr" : "安徽省合肥市蜀山区望江西路",
                "house" : "华润五彩国际",
                "lat" : "111.123456",
                "lng" : "111.123456",
                "note" : "少放辣椒，多加米饭",
                "order_status" : "1",
                'online_pay' : "1",
                "pay_status" : "0"
                "pay_code" : ""
                "pay_time" : "0"
                "staff_id" : "0"
                "pei_type" : "0"
                "dateline" : "1400000000",
                "staff" : {
                    "staff_id" : "111"，
                    "name" : "游医",
                    "mobile" : "1388888888",
                    "lng" : "11.123456",
                    "lat" : "123.1213456"
                }
            }
        ],
        "total_count" : "30"
    }
}
```

<br />
************
######<a name="biz/order/jiedan">接单(biz/order/jiedan)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| order_id | 是 | int |  订单ID, 支持批量接单, 多个ID用 , 分割 |
| pei_type | 否 | int |  配送类型 `0:自己送, 1:平台送` |
>>请求示例
>
```javascript
{
    "order_id":"11",
    "pei_type" : "1"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| order_id | int | 订单ID |
>
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data":{
    	"order_id" : "11"
    }
}
```
<br />
######<a name="biz/order/cancel">接单(biz/order/cancel)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| order_id | 是 | int |  订单ID|
>>请求示例
>
```javascript
{
    "order_id":"11"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| order_id | int | 订单ID |
>
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data":{
    	"order_id" : "11"
    }
}
```

<br />
************
######<a name="biz/order/pei">开始配送(biz/order/pei)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| order_id | 是 | int |  订单ID  |
>>请求示例
>
```javascript
{
    "order_id":"11"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| order_id | int | 订单ID |
>
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data":{
    	"order_id" : "11"
    }
}
```

<br />
************
######<a name="biz/order/qiang">自己配送(biz/order/qiang)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| order_id | 是 | int |  订单ID  |
>>请求示例
>
```javascript
{
    "order_id":"11"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| order_id | int | 订单ID |
>
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data":{
    	"order_id" : "11"
    }
}
```

<br />
************
######<a name="biz/order/delivered">订单送达(biz/order/delivered)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| order_id | 是 | int |  订单ID  |
>>请求示例
>
```javascript
{
    "order_id":"11"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| order_id | int | 订单ID |
>
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data":{
    	"order_id" : "11"
    }
}
```

<br />
************
######<a name="biz/order/detail">订单详情(biz/order/detail)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| order_id | 是 | int |  订单ID  |
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
| order_status | int | 订单状态 `-1:已取消，0：未处理，1：已接单，2：已配货，3：配送开始，4：配送完成，8：订单完成` |
| pay_status | int | 支付状态  `0:未支付, 1:已支付` |
| online_pay | int | 付款方式 `0:货到付款, 1:在线支付` |
| pay_code | string | 支付类型 `wxpay:微信, alipay:支付宝, money:余额` |
| pay_time | int | 支付时间UNIXTIME `当pay_status=1时有值` |
| staff_id | int | 配送员ID  |
| pei_type | string | 配送类型 `0:商家自己送, 1:第三方配送, 2:配送员代购` |
| comment_status | int | 评价状态 `0:未评价, 1:已经评价` |
| staff | array | 配送员信息 [配送员字典](#table.staff)|
| products | array | 订单商品 [订单商品字典](#table.order_product)|
| logs | array | 订单日志 |
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
        "order_youyi" : "10"
        "first_youhui" : "10",
        "hongbao" : "10",
        "hongbao_id" : "22",
        "contact" : "游医",
        "mobile" : "138121345678",
        "addr" : "安徽省合肥市蜀山区望江西路",
        "house" : "华润五彩国际",
        "lat" : "111.123456",
        "lng" : "111.123456",
        "note" : "少放辣椒，多加米饭",
        "order_status" : "2",
        "pay_status" : "1",
        "online_pay" : "1",
        "pay_code" : "wxpay"
        "pay_time" : "1400000011"
        "staff_id" : "0"
        "pei_type" : "0"
        "dateline" : "1400000000",
        "staff" : {
            "staff_id" : "111"，
            "name" : "游医",
            "mobile" : "1388888888",
            "lng" : "11.123456",
            "lat" : "123.1213456"
        },
		"logs" : [
        	{
            	"log_id" : "1",
                "order_id" : "1",
                "log" : "下单成功",
                "dateline" : "1400000000"
            },
            {
            	"log_id" : "2",
                "order_id" : "1",
                "log" : "商家已经接单",
                "dateline" : "1400000011"
            },
            {
            	"log_id" : "3",
                "order_id" : "1",
                "log" : "订单已经配送",
                "dateline" : "1400001111"
            }
        ],
		"products" : [
        	{
                "pid" : "1",
            	"product_id" : "1",
                "shop_id" : "111",
                "product_name" : "红烧牛肉商务套餐",
                "product_price" : "20",
                "package_price" : "0",
                "product_number" : "2",
                "amount" : "40"
            },
        	{
                "pid" : "2",
            	"product_id" : "1",
                "shop_id" : "111",
                "product_name" : "回锅肉盖浇饭",
                "product_price" : "15",
                "package_price" : "0",
                "product_number" : "2",
                "amount" : "30"
            }
        ]
    }
}
```

<br />
************
######<a name="biz/order/tixing">订单提醒(biz/order/tixing)</a>
>>请求参数(无业务参数)
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| dateline | 是 | int |  上次请求的时间戳  |
>>请求示例
>
```javascript
{
    "dateline" : "1400000001"
}
```
>
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| new_order | int | 新订单数 |
| cui_order | int | 催单数 |
| new_msg | int | 新消息 |
| dateline | int | 时间戳，下一次请求时参数用 |
>
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data":{
    	"new_order" : "11",
        "cui_order" : "0",
        "new_msg" ："1",
        "dateline" : "1400000002"
    }
}
```

<br />
************
######<a name="biz/cate/items">分类列表(biz/cate/items)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| page | 否 | int |  分页  |
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
| cate_id | int | 分类ID |
| title | string | 分类名 |
| orderby | int | 排序 |
>
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data":{
    	"items":[
        	{
            	"cate_id" : "1",
                "title" : "盖浇饭",
                "orderby" : "50"
            },
        	{
            	"cate_id" : "2",
                "title" : "商务套餐",
                "orderby" : "50"
            }
        ]
    }
}
```

<br />
************
######<a name="biz/cate/create">添加分类(biz/cate/create)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| title | 是 | string | 分类名称 |
| orderby | 否 | int | 排序 |
>>请求示例
>
```javascript
{
    "title":"盖浇饭",
    "orderby" : "50"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| cate_id | int | 分类ID |
>
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data":{
    	"cate_id" : "1"
    }
}
```

<br />
************
######<a name="biz/cate/update">添加分类(biz/cate/update)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| title | 是 | string | 分类名称 |
| orderby | 否 | int | 排序 |
>>请求示例
>
```javascript
{
	"cate_id":"1",
    "title":"盖浇饭",
    "orderby" : "50"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| cate_id | int | 分类ID |
>
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data":{
    	"cate_id" : "1"
    }
}
```

<br />
************
######<a name="biz/cate/delete">删除分类(biz/cate/delete)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| cate_id | 是 | int | 分类ID, 支持批量删除，ID以分号隔开 |
>>请求示例
>
```javascript
{
	"cate_id":"1"
}
```
>>返回数据
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
######<a name="biz/product/items">商品列表(biz/product/items)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
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
| 参数名称 | 类型 |描述 |
|--------|:-------:|:-------:|------|
| product_id | int | 分类ID |
| title | string | 商品名称 |
| cate_id | int | 商品分类ID |
| photo | string | 商品图片 base64/image |
| price | float | 商品价格 |
| package_price | float | 打包费 |
| sale_type | int | 销售类型 `0:普通, 1:限量` |
| sale_sku | int | 限量库存 |
| sale_count | int | 抢购已购买数量 |
| intro | string | 商品描述 |
| orderby | int | 商品排序 |
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
            	"product_id" : "1",
                "title":"番茄炒蛋盖浇饭",
                "cate_id" : "1",
                "photo" : "base64/image",
                "price" : "18",
                "package_price" : "0",
                "sale_type" : "1",
                "sale_sku" : "100",
                "sale_count" : "20",
                "intro" : "商品描述"
                "orderby" : "50"
            },
            {
            	"product_id" : "2",
                "title":"番茄炒蛋盖浇饭",
                "cate_id" : "1",
                "photo" : "base64/image",
                "price" : "18",
                "package_price" : "0",
                "sale_type" : "1",
                "sale_sku" : "100",
                "sale_count" : "20",
                "intro" : "商品描述"
                "orderby" : "50"
            }
        ]
    }
}
```

<br />
************
######<a name="biz/product/create">添加分类(biz/product/create)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| title | 是 | string | 商品名称 |
| cate_id | 是 | int | 商品分类ID |
| photo | 是 | string | 商品图片 base64/image |
| price | 是 | float | 商品价格 |
| package_price | 否 | float | 打包费 |
| sale_type | 否 | int | 销售类型 `0:普通, 1:限量` |
| sale_sku | 否 | int | 限量库存 |
| sale_count | 否 | int | 抢购已购买数量 |
| intro | 否 | string | 商品描述 |
| orderby | 否 | int | 商品排序 |
>>请求示例
>
```javascript
{
    "title":"番茄炒蛋盖浇饭",
    "cate_id" : "1",
    "photo" : "base64/image",
    "price" : "18",
    "package_price" : "0",
    "sale_type" : "1",
    "sale_sku" : "100",
    "sale_count" : "20",
    "intro" : "商品描述"
    "orderby" : "50"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| product_id | int | 商品ID |
>
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data":{
    	"product_id" : "1"
    }
}
```


<br />
************
######<a name="biz/product/update">添加分类(biz/product/update)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| product_id | 是 | int | 分类ID |
| title | 否 | string | 商品名称 |
| cate_id | 否 | int | 商品分类ID |
| photo | 否 | string | 商品图片 base64/image |
| price | 否 | float | 商品价格 |
| package_price | 否 | float | 打包费 |
| sale_type | 否 | int | 销售类型 `0:普通, 1:限量` |
| sale_sku | 否 | int | 限量库存 |
| sale_count | 否 | int | 抢购已购买数量 |
| intro | 否 | string | 商品描述 |
| orderby | 否 | int | 商品排序 |
>>请求示例
>
```javascript
{
	"product_id":"1",
    "title":"番茄炒蛋盖浇饭",
    "cate_id" : "1",
    "photo" : "base64/image",
    "price" : "18",
    "package_price" : "0",
    "sale_type" : "1",
    "sale_sku" : "100",
    "sale_count" : "20",
    "intro" : "商品描述"
    "orderby" : "50"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| cate_id | int | 分类ID |
>
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data":{
    	"product_id" : "1"
    }
}
```

<br />
************
######<a name="biz/product/delete">删除商品(biz/product/delete)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| product_id | 是 | int | 商品ID, 支持批量删除，ID以分号隔开 |
>>请求示例
>
```javascript
{
	"product_id":"1"
}
```
>>返回数据
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
######<a name="biz/member/fans">我的粉丝(biz/member/fans)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| page | 否 | int | 分页码 |
>>请求示例
>
```javascript
{
	"page":"1"
}
```
>>返回数据
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
            	"uid" : "1",
                "nickname" : "游医",
                "face" : "default/face.png"
            },
        	{
            	"uid" : "2",
                "nickname" : "游医",
                "face" : "default/face.png"
            }
        ]
    }
}
```

<br />
************
######<a name="biz/member/order">我的客户(biz/member/order)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| page | 否 | int | 分页码 |
>>请求示例
>
```javascript
{
	"page":"1"
}
```
>>返回数据
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
            	"uid" : "1",
                "nickname" : "游医",
                "face" : "default/face.png"
            },
        	{
            	"uid" : "2",
                "nickname" : "游医",
                "face" : "default/face.png"
            }
        ]
    }
}
```

<br />
************
######<a name="biz/member/detail">客户详情(biz/member/detail)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| uid | 是 | int | 客户ID |
| page | 否 | int | 订单分页 |
>>请求示例
>
```javascript
{
	"uid":"1",
    "page" : "1"
}
```
>>返回数据
>
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
    	"member" : {
        	"uid" : "1",
            "nickname" : "游医",
            "face" : "default/face.png"
        },
        "total_order" : "66",
        "total_amount" : "65200",
        "items":[
        	{
            	"order_id" : "1",
                "amount" : "50",
                "money" : "0",
                "hongbao" : "0",
                "dateline" : "1400000000"
            },
        	{
            	"order_id" : "2",
                "amount" : "50",
                "money" : "0",
                "hongbao" : "0",
                "dateline" : "1400000000"
            }
        ]
    }
}
```

<br />
************
######<a name="biz/money/log">资金日志(member/money/log)</a>
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
| shop_id | int| 商户ID |
| money | float | 变动资金 |
| intro | string | 变动原因 |
| dateline | int| 变动时间 UNIXTIME |
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
    	"items" : [
        	{
            	"log_id" : "1",
                "shop_id" : "888",
                "money" : "30",
                "intro" : "订单结算（ID：111）",
                "dateline" : "140000000"
            },
            {
            	"log_id" : "2",
                "shop_id" : "888",
                "money" : "100",
                "intro" : "订单结算(ID:11111)",
                "dateline" : "140000001"
            }
        ],
        "money" : "200", //当前用户余额
        "total_count" : "30"
    }
}
```

<br />
************
######<a name="biz/money/txlog">体现日志(member/money/txlog)</a>
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
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| tixian_id | int | 提现ID |
| shop_id | int| 商户ID |
| money | float | 提现资金 |
| intro | string | 提现说明 |
| account_info | string | 提现帐号 |
| status | int | 状态 `0:待处理,1:通过,2:拒绝` |
| reason | string | 拒绝原因 |
| updatetime | int | 更新时间 UNIXTIME |
| dateline | int | 变动时间 UNIXTIME |
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
            	"tixian_id" : "1",
                "shop_id" : "888",
                "money" : "30",
                "intro" : "提现结算",
                "account_info" : "支付宝(游医:shzhrui@126.com)",
                "status" : "1",
                "reason" : "",
                "updatetime" : "140000002",
                "dateline" : "140000000"
            },
            {
            	"tixian_id" : "2",
                "shop_id" : "888",
                "money" : "100",
                "intro" : "提现结算",
                "account_info" : "支付宝(游医:shzhrui@126.com)",
                "status" : "2",
                "reason" : "最少提现100元",
                "updatetime" : "140000002",
                "dateline" : "140000001"
            }
        ],
        "money" : "200", //当前用户余额
        "total_count" : "30"
    }
}
```

<br />
************
######<a name="biz/money/tixian">资金提现(biz/money/tixian)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| money | 是 | float |  体现金额  |
| passwd | 是 | string |  支付密码即登录密码  |
>>请求示例
>
```javascript
{
    "money":"1000",
    "passwd" : "123456"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| tixian_id | int | 提现ID |
| money | int | 当前帐户余额 |
>
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
    	"tixian_id" : "12",
        "money" : "200";
    }
}
```

<br />
************
######<a name="biz/tongji/order">订单统计(biz/tongji/order)</a>
>>请求参数(无业务参数)
>
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| today_count | int |今日新订单数 |
| week_count | int |一周新订单数 |
| month_count | int | 最近一月单数 |
| total_count | int | 总订单 |
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
            	"date" : "2015-11-11",
                "count" : "20"
            },
        	{
            	"date" : "2015-11-12",
                "count" : "20"
            },
        	{
            	"date" : "2015-11-13",
                "count" : "20"
            },
        	{
            	"date" : "2015-11-14",
                "count" : "20"
            },
        	{
            	"date" : "2015-11-15",
                "count" : "20"
            },
        	{
            	"date" : "2015-11-16",
                "count" : "20"
            }
        ],
    	"today_count" : "11",
        "week_count" : "11",
        "month_count" : "11",
        "total_count" : "11",
    }
}
```

<br />
************
######<a name="biz/tongji/money">资金统计(biz/tongji/money)</a>
>>请求参数(无业务参数)
>
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| today_money | float |今日资金 |
| week_money | float |一周资金 |
| month_money | float | 最近一月资金 |
| total_money | float | 总资金 |
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
            	"date" : "2015-11-11",
                "money" : "20"
            },
        	{
            	"date" : "2015-11-12",
                "money" : "20"
            },
        	{
            	"date" : "2015-11-13",
                "money" : "20"
            },
        	{
            	"date" : "2015-11-14",
                "money" : "20"
            },
        	{
            	"date" : "2015-11-15",
                "money" : "20"
            },
        	{
            	"date" : "2015-11-16",
                "money" : "20"
            }
        ],
    	"today_money" : "11",
        "week_money" : "11",
        "month_money" : "11",
        "total_money" : "11",
    }
}
```

<br />
************
######<a name="biz/tongji/source">来源统计(biz/tongji/source)</a>
>>请求参数(无业务参数)
>
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| android_count | float | 安卓订单数 |
| ios_count | float | IOS订单数 |
| weixin_count | float | 微信端订单数 |
| wap_count | float | WAP端订单数 |
>
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data":{
    	"android_count" : "11",
        "ios_count" : "11",
        "weixin_count" : "11",
        "wap_count" : "11",
    }
}
```

<br />
************
######<a name="biz/msg/items">消息列表(biz/msg/items)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| type | 否 | int | 消息类型 `0:所有消息 1:订单消息, 2:评价消息,3:投诉消息,4:系统消息`  |
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
| msg_id | int |  消息ID  |
| uid | int |  用户UID  |
| title | string |  消息标题  |
| content | string |  消息内容  |
| type | int |  消息类型  `1:订单消息, 2:评价消息,3:投诉消息,4:系统消息` |
| is_read | int |  是否已读 `1:未读 2:已读`  |
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
                "msg_id":"1",
                "shop_id":"888",
                "title":"恭喜你获得一个10元",
                "content":"红包金额10元,可用于支付时抵扣相应的金额",
                "type":"1",
                "is_read":"0",
                "dateline":"1445405891",
                "order_id" : "0"
            },
            {
                "msg_id":"2",
                "shop_id":"888",
                "title":"恭喜你获得一个10元",
                "content":"红包金额10元,可用于支付时抵扣相应的金额",
                "type":"1",
                "is_read":"0",
                "dateline":"1445405891",
                "order_id" : "0"
            }
            ]
        },
        "total_count":"300"
    }
}
```


<br />
************
######<a name="biz/msg/read">阅读消息(biz/msg/read)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| msg_id | 是 | int |  消息ID  |
>>请求示例
>
```javascript
{
	"msg_id":"1"
}
```
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
        "msg_id":"1",
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
######<a name="biz/comment/items">评论列表(biz/comment/items)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| replay_type | 否 | int |  `0:全部,1:已回复,2:未回复`  |
| page | 否 | int |  页码 默认第1页  |
>>请求示例
>
```javascript
{
    "reply_type":"0",
    "page":"1"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| comment_id | int |  评论ID  |
| shop_d | int |  商户ID  |
| uid | int |  用户UID  |
| order_id | int |  订单ID  |
| score | int |  评分  |
| score_fuwu | int |  服务评分  |
| score_kouwei | int |  口味评分  |
| pei_time | int |  配送时间分钟  |
| content | string | 评论内容 |
| have_photo | int |  是否有图片  |
| photo_list | array |  评论图片数组  |
| member | array |  会员信息数组 `uid,nickname,face`  |
| reply | string |  回复内容  |
| reply_time | int |  回复时间 UNIXTIME  |
| dateline | int |  评价时间 UNIXTIME  |
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
                "comment_id":"1",
                "shop_id":"888",
                "uid" : "1",
                "order_id" : "888",
                "score":"5",
                "score_fuwu":"5",
                "score_kouwei":"5",
                "pei_time":"50",
                "content":"口味不错，送餐速度快",
                "photo_list" : [
                	"photo/1.jpg",
                    "photo/2.jpg",
                    "photo/3.jpg"
                    ],
                "member" : {
                	"uid" : "1",
                    "nickname" : "游医",
                    "face" : "default/face.png"
                },
                "reply":"感谢您的支持",
                "reply_time":"1451111111",
                "dateline":"1445405891"
            },
            {
                "comment_id":"1",
                "shop_id":"888",
                "uid" : "1",
                "order_id" : "888",
                "score":"5",
                "score_fuwu":"5",
                "score_kouwei":"5",
                "pei_time":"50",
                "content":"口味不错，送餐速度快",
                "photo_list" : [
                	"photo/1.jpg",
                    "photo/2.jpg",
                    "photo/3.jpg"
                    ],
                "member" : {
                	"uid" : "1",
                    "nickname" : "游医",
                    "face" : "default/face.png"
                },
                "reply":"",
                "reply_time":"0",
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
######<a name="biz/comment/detail">评论详情(biz/comment/detail)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| order_id | 否 | int |  订单ID  |
>>请求示例
>
```javascript
{
    "reply_type":"0",
    "page":"1"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| comment_id | int |  评论ID  |
| shop_d | int |  商户ID  |
| uid | int |  用户UID  |
| order_id | int |  订单ID  |
| score | int |  评分  |
| score_fuwu | int |  服务评分  |
| score_kouwei | int |  口味评分  |
| pei_time | int |  配送时间分钟  |
| content | string | 评论内容 |
| have_photo | int |  是否有图片  |
| photo_list | array |  评论图片数组  |
| member | array |  会员信息数组 `uid,nickname,face`  |
| reply | string |  回复内容  |
| reply_time | int |  回复时间 UNIXTIME  |
| dateline | int |  评价时间 UNIXTIME  |
>
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success'
    'data':{
        "comment_id":"1",
        "shop_id":"888",
        "uid" : "1",
        "order_id" : "888",
        "score":"5",
        "score_fuwu":"5",
        "score_kouwei":"5",
        "pei_time":"50",
        "content":"口味不错，送餐速度快",
        "photo_list" : [
            "photo/1.jpg",
            "photo/2.jpg",
            "photo/3.jpg"
            ],
        "member" : {
            "uid" : "1",
            "nickname" : "游医",
            "face" : "default/face.png"
        },
        "reply":"感谢您的支持",
        "reply_time":"1451111111",
        "dateline":"1445405891"
    }
}
```


<br />
************
######<a name="biz/comment/reply">阅读消息(biz/comment/reply)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| comment_id | 是 | int |  评论ID  |
| reply | 是 | string |  评论内容  |
>>请求示例
>
```javascript
{
	"comment_id":"1",
    "reply" : "感谢您对我们的支持，我们会更加努力的"
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


<br /><br /><br /><br /><br /><br />
*************************************
###数据字典对照表

>会员字典
<br>
><a name="table.shop">商户字典</a>
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
| pei_amount | float |  配送费用`0:免配送费` |
| pei_type | int |  配送类型 `0:商家自己送,1:第三方配送,2:配送员代购` |
| yy_status | int |  营业状态 `0:打烊, 1:营业`  |
| yy_stime | time |  开始营业时间  |
| yy_ltime | time | 结束营业时间  |
| is_new | int | 是否新店铺 `1:新店`  |
| online_pay | int | 是否支持在线支付 `0:不支持, 1:支持在线支付` |
| info | string | 商户描述 |
| dateline | int | 创建时间 |


<br>
><a name="table.staff">配送员字典</a>
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| staff_id | int | 主键ID |
| city_id | int | 城市ID |
| name | int | 姓名 |
| mobile | string | 手机号 同时用作登录用户名 |
| passwd | string | 登录密码 |
| face | string | 头像,保留字段扩展用 |
| money | float | 帐户余额 |
| orders | int | 已接单数量 |

<br>
>商品字典
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

<br />
><a name="table.order">订单字典</a>
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
| lat | string | 纬度 |
| lng | string | 经度 |
| note | string | 订单备注 |
| order_status | int | 订单状态  `-1:已取消，0：未处理，1：已接单，2：已配货，3：配送开始，4：配送完成，8：订单完成`|
| online_pay | int | 付款方式 `0:货到付款, 1:在线支付` |
| pay_status | int | 支付状态 `0:未支付, 1：已经支付` |
| pay_code | string | 支付类型 `wxpay:微信, alipay:支付宝, money:余额` |
| pay_time | int | 支付时间UNIXTIME `当pay_status=1时有值` |
| staff_id | int | 配送员ID  |
| pei_type | string | 配送类型 `0:商家自己送, 1:第三方配送, 2:配送员代购` |
| comment_status | int | 评价状态 `0:未评价, 1:已经评价` |
| dateline | int | 下单时间UNIXTIME |


<br>
><a name="table.order_product">订单商品字典</a>

| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| pid | int | 主键ID |
| order_id | int | 订单ID |
| product_id | int | 商品ID |
| product_name | string | 商品乐称 |
| product_price | float | 商品价格 |
| package_price | float | 打包费用 |
| product_number | int | 商品数量 |
| amount | float | 总价 = (product_price+package_price)*product_number |

配送端API接口文档
==============

| 分组 |  接口 |  API |登录权限 |
|:-----------:|------------------|------------------ |:--------------:|
|   基础    | 测试接口  | [staff/app/test](#staff/app/test)	|  否  |
|   基础    | 基础信息  | [staff/app/info](#staff/app/info)	|  否  |
|   数据    | 城市列表  | [data/city](#data/city)	|  否  |
|   数据    | 银行列表  | [data/bank](#data/bank)	|  否  |
|   数据    | 数据版本  | [data/version](#data/version)	|  否  |
|   帐号    | 登录接口  | [staff/login](#staff/login)| 否  |
|   帐号    | 申请入住  | [staff/signup](#staff/signup)|  否  |
|   帐号    | 找回密码  | [staff/forgot](#staff/forgot)|  否  |
|   帐号    | 配送员信息  | [staff/info](#staff/info) |  是  |
|   帐号    | 修改密码  | [staff/passwd](#staff/passwd) |  是  |
|   帐号    | 更换手机  | [staff/updatemobile](#staff/updatemobile) |  是  |
|   帐号    | 身份认证  | [staff/verify](#staff/verify) |  是  |
|   帐号    | 提现帐号  | [staff/account](#staff/account) |  是  |
|   帐号    | 上报位置  | [staff/location](#staff/location) |  是  |
|   消息    | 通知消息  | [staff/msg](#staff/msg) |  是  |
|   消息    | 阅读消息  | [staff/msg/read](#staff/msg/read) |  是  |
|   资金    | 资金日志  | [staff/money/log](#staff/money/log) |  是  |
|   资金    | 提现日志  | [staff/money/txlog](#staff/money/txlog) |  是  |
|   资金    | 提现申请  | [staff/money/tixian](#staff/money/tixian) |  是  |
|   订单    | 订单列表  | [staff/order](#staff/order) |  是  |
|   订单    | 订单接单  | [staff/order/qiang](#staff/order/qiang) |  是  |
|   订单    | 订单配送  | [staff/order/pei](#staff/order/pei) |  是  |
|   订单    | 订单送达  | [staff/order/delivered](#staff/order/delivered) |  是  |
|   订单    | 订单详情  | [staff/order/detail](#staff/order/detail) |  是  |
|   订单    | 订单提醒  | [staff/order/tixing](#staff/order/tixing) |  是  |
|   统计    | 订单统计  | [staff/tongji/order](#staff/tongji/order) |  是  |
|   统计    | 资金统计  | [staff/tongji/money](#staff/tongji/money) |  是  |
|   跑腿    | 跑腿订单  | [staff/paotui/index](#staff/paotui/index) |  是  |
|   跑腿    | 跑腿订单详情  | [staff/paotui/detail](#staff/paotui/detail) |  是  |
|   跑腿    | 设置订单状态  | [staff/paotui/set](#staff/paotui/set) |  是  |
|   跑腿    | 设置结算价  | [staff/paotui/setprice](#staff/paotui/setprice) |  是  |

<br /><br /><br />
************
######测试接口<a name="staff/app/test">(app/test)</a>

| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
|   无  | 否 |  --	|  否  |

<br />
************
######<a name="staff/app/info">基础信息(app/info)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
|   无  | 否 |  --	|  否  |

<br />
************
######<a name="data/version">数据版本(data/version)</a>
>>请求示例
>
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| datacity | string |  城市接口数据版本  |
| shopcate | string | 商户分类接口数据版本  |
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
          "datacity":"20151111",
          "shopcate":"20151111"
    }
}
```

<br />
************
######<a name="data/city">城市数据(data/city)</a>
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
######<a name="data/bank">数据版本(data/bank)</a>
>>请求示例
>
>>返回数据
>
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
          "items":[
          	"工商银行",
            "建设银行",
            "招商银行",
            "交通银行",
            "支付宝"
          ]
    }
}
```

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
######<a name="staff/login">帐号登录(staff/login)</a>
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
          "staff_id":"888",
          "name":"游医"，
          "face":"face/staff/default.png",
          "mobile":"13888888888"，
          "token":"888-A2D28B1CA20DC547425343D2ACAFE540"
    }
}
```

<br />
************
######<a name="staff/signup">注册帐号(staff/signup)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| mobile | 是 | string |  手机号码  |
| sms_code | 是 | string |  验证码  |
| passwd | 是 | string |  登录密码  |
>>请求示例
>
```javascript
{
	"mobile" : "13888888888",
    "sms_code" : "1234",
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
          "staff_id":"888",
          "name":"游医"，
          "face":"face/staff/default.png",
          "mobile":"13888888888"，
          "token":"888-A2D28B1CA20DC547425343D2ACAFE540"
    }
}
```

<br />
************
######<a name="staff/forgot">找回密码(staff/forgot)</a>
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
          "staff_id":"888"
    }
}
```

<br />
************
######<a name="staff/info">配送员信息(staff/info)</a>
>>请求参数
>无
>>返回参数
>
| 参数名称 | 类型 |描述 |
|--------|:-------:|------|
| staff_id | int | 主键ID |
| city_id | int | 城市ID |
| city_name | int | 城市 |
| name | int | 姓名 |
| mobile | string | 手机号 同时用作登录用户名 |
| face | string | 头像 |
| money | float | 帐户余额 |
| total_money | float | 总收益 |
| orders | int | 已接单数量 |
| lat | string |  坐标纬度  |
| lng | string |  坐标经度  |
| account_type | string | 提现帐号类型 |
| account_name | string | 提现帐号开户人 |
| account_number | string | 提现帐号 |
| pmid | string |  邀请人推广码 |
| pid | string |  推广码， 自己推广时用  |
| audit | int |  审核 `0:待审, 1:通过`  |
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
        "staff_id"	 : "1",
        "city_id"	 : "1",
        "city_name"	 : "合肥",
        "mobile"	 : "1388888888",
        "title"		 : "江湖外卖旗舰店",
        "money"		 : "888.88",
        "total_money": "198888.88",
        "face"		 : "photo/201512/logo.png",
        "lat"		 : "123.111111",
        "lng"		 : "123.111111",
        "account_type":"支付宝",
        "account_name" : "江湖信息科技",
        "account_number": "ijianghu@qq.com",
        "orders"	 : "3000",
        "pmid"	 : "",
        "audit"	 : "0",
        "pid"	 : "S00001",
        "order_jie_count" : "10",
        "order_pei_count" : "50",
        "order_end_count" : "2000",
        "msg_new_count"	  : "10"
    }
}
```



<br />
************
######<a name="staff/passwd">修改密码(staff/passwd)</a>
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
######<a name="staff/updatemobile">更换手机(staff/updatemobile)</a>
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
######<a name="staff/verify">身份认证(staff/verify)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| id_name | 是 | string |  真实姓名  |
| id_number | 是 | string |  身份证号  |
| id_photo | 是 | string |  身份证照片(base64数据)  |
>>请求示例
>
```javascript
{
    "id_name":"游医",
    "id_number": "341111111111111111",
    "id_photo":"XZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZ"
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
######<a name="staff/account">体现帐号(staff/account)</a>
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
######<a name="staff/location">上报位置(staff/location)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| lat | 是 | string |  纬度  |
| lng | 是 | string |  经度  |
>>请求示例
>
```javascript
{
    "lat":"123.111111",
    "lng": "123.11111",
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
######<a name="staff/msg">上报位置(staff/msg)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| page | 否 | int |  分页码  |
| is_read | 否 | int |  是否新消息 `0:已读消息, 1:新消息` |
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
| msg_id | int |  消息ID  |
| title | string |  城市  |
| content | int |  城市区号 |
| is_read | int |  省份ID  |
| dateline | int |  消息时间  |
>
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success'，
    "data" : {
    	"items" : [
        	{
            	"msg_id" : "1",
                "staff_id" : "888",
                "title" : "消息标题",
                "content" : "消息内容",
                "is_read" : "1",
                "dateline" : "1400000000"
            },
        	{
            	"msg_id" : "2",
                "staff_id" : "888",
                "title" : "消息标题",
                "content" : "消息内容",
                "is_read" : "1",
                "dateline" : "1400000000"
            },
        	{
            	"msg_id" : "1",
                "staff_id" : "888",
                "title" : "消息标题",
                "content" : "消息内容",
                "is_read" : "1",
                "dateline" : "1400000000"
            }
        ]
    }
}
```

<br />
************
######<a name="staff/msg/read">消息阅读(staff/msg/read)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| msg_ids | 是 | string |  阅读消息ID结合 格式 1,2,3  |
>>请求示例
>
```javascript
{
    "msg_ids":"1,23,45"
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
######<a name="staff/money/log">资金日志(member/money/log)</a>
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
| staff_id | int| 配送员ID |
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
                "staff_id" : "888",
                "money" : "30",
                "intro" : "订单结算（ID：111）",
                "dateline" : "140000000"
            },
            {
            	"log_id" : "2",
                "staff_id" : "888",
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
######<a name="staff/money/txlog">体现日志(staff/money/txlog)</a>
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
| staff_id | int| 配送员ID |
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
                "staff_id" : "888",
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
                "staff_id" : "888",
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
######<a name="staff/money/tixian">资金提现(staff/money/tixian)</a>
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
######<a name="staff/order">订单列表(staff/order)</a>
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
| pei_time | string | 要求送达时间  |
| pei_type | string | 配送类型 `0:商家自己送, 1:第三方配送, 2:配送员代购` |
| comment_status | int | 评价状态 `0:未评价, 1:已经评价` |
| dateline | int | 下单时间UNIXTIME |
| shop | array | 商户信息 [查看字典](#table.shop)|
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
                "shop" : {
                    "shop_id" : "111"，
                    "title" : "江湖客栈",
                    "phone" : "0551-64278115",
                    "logo" : "photo/201511/20151111_111111.jpg",
                    "addr" : "华润五彩国际",
                    "lng" : "111.111",
                    "lat" : "111.111"
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
                "shop" : {
                    "shop_id" : "111"，
                    "title" : "江湖客栈",
                    "phone" : "0551-64278115",
                    "logo" : "photo/201511/20151111_111111.jpg",
                    "addr" : "华润五彩国际",
                    "lng" : "111.111",
                    "lat" : "111.111"
                }
            }
        ],
        "total_count" : "30"
    }
}
```

<br />
************
######<a name="staff/order/jiedan">接单(staff/order/jiedan)</a>
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
######<a name="staff/order/pei">开始配送(staff/order/pei)</a>
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
######<a name="staff/order/delivered">订单送达(staff/order/delivered)</a>
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
######<a name="staff/order/detail">订单详情(staff/order/detail)</a>
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
| pei_time | string | 要求送达时间  |
| pei_type | string | 配送类型 `0:商家自己送, 1:第三方配送, 2:配送员代购` |
| comment_status | int | 评价状态 `0:未评价, 1:已经评价` |
| shop | array | 商户信息 [商户字典](#table.shop)|
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
        "shop" : {
        	"shop_id" : "111"，
            "title" : "江湖客栈",
            "phone" : "0551-64278115",
            "logo" : "photo/201511/20151111_111111.jpg",
            "addr" : "华润五彩国际",
            "lng" : "111.111",
            "lat" : "111.111"
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
######<a name="staff/order/tixing">订单提醒(staff/order/tixing)</a>
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
        "dateline" : "1400000002"
    }
}
```

<br />
************
######<a name="staff/tongji/order">订单统计(staff/tongji/order)</a>
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
######<a name="staff/tongji/money">资金统计(staff/tongji/money)</a>
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





<br />
************
######<a name="paotui/index">跑腿订单列表(paotui/index)</a>
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
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
		"items" : [
        	{
                "paotui_id" : "1",
                "uid" : "7",
                "addr" : "蜀山区合作化南路与望江西路交口",
                "house" : "华润五彩国际904室",
                "contact" : "张四海",
                "mobile" : "13969798899",
                "lat" : "123.456",
                "lng" : "89.123"
                "time" : "1234567890",
                "o_addr" : "经济开发区繁华大道与金寨路交口",
                "o_house" : "丰大国际1栋101室",
                "o_contact" : "任杰",
                "o_mobile" : "13977558866",
                "o_lat" : "123.456",
                "o_lng" : "321.456",
                "o_time" : "1234567890",
                "intor" : "帮我买一个蓝色的羽绒服，GXG品牌的，XXL号的",
                "photo" : "abcdefg.jpg",
                "voice" : "1.mp3",
                "paotui_amount" : "20.00"
                "danbao_amount" : "80.00"
                "jiesuan_amount" : "0.00"
                "type" : "song"
                "staff_id" : "0",
                "order_status" : "0",
            },
        	{
                "paotui_id" : "2",
                "uid" : "7",
                "addr" : "蜀山区合作化南路与望江西路交口",
                "house" : "华润五彩国际904室",
                "contact" : "张四海",
                "mobile" : "13969798899",
                "lat" : "123.456",
                "lng" : "89.123"
                "time" : "1234567890",
                "o_addr" : "经济开发区繁华大道与金寨路交口",
                "o_house" : "丰大国际1栋101室",
                "o_contact" : "任杰",
                "o_mobile" : "13977558866",
                "o_lat" : "123.456",
                "o_lng" : "321.456",
                "o_time" : "1234567890",
                "intor" : "帮我买一个蓝色的羽绒服，GXG品牌的，XXL号的",
                "photo" : "abcdefg.jpg",
                "voice" : "1.mp3",
                "paotui_amount" : "20.00"
                "danbao_amount" : "80.00"
                "jiesuan_amount" : "0.00"
                "type" : "song"
                "staff_id" : "0",
                "order_status" : "0",
            }
        ]
    }
}
```



<br />
************
######<a name="paotui/detail">订单详情(paotui/detail)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| paotui_id | 是 | int |  订单ID |
>

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
        "paotui_id" : "1",
        "uid" : "7",
        "addr" : "蜀山区合作化南路与望江西路交口",
        "house" : "华润五彩国际904室",
        "contact" : "张四海",
        "mobile" : "13969798899",
        "lat" : "123.456",
        "lng" : "89.123"
        "time" : "1234567890",
        "o_addr" : "经济开发区繁华大道与金寨路交口",
        "o_house" : "丰大国际1栋101室",
        "o_contact" : "任杰",
        "o_mobile" : "13977558866",
        "o_lat" : "123.456",
        "o_lng" : "321.456",
        "o_time" : "1234567890",
        "intor" : "帮我买一个蓝色的羽绒服，GXG品牌的，XXL号的",
        "photo" : "abcdefg.jpg",
        "voice" : "1.mp3",
        "paotui_amount" : "20.00"
        "danbao_amount" : "80.00"
        "jiesuan_amount" : "0.00"
        "type" : "song"
        "staff_id" : "0",
        "order_status" : "0",
		"logs" : [
        	{
            	"log_id" : "1",
                "paotui_id" : "1",
                "log" : "下单成功",
                "dateline" : "1400000000"
            },
            {
            	"log_id" : "2",
                "paotui_id" : "1",
                "log" : "已经接单",
                "dateline" : "1400000011"
            },
            {
            	"log_id" : "3",
                "paotui_id" : "1",
                "log" : "订单已经配送",
                "dateline" : "1400001111"
            }
        ],
    }
}
```



<br />
************
######<a name="paotui/set">设置订单状态(paotui/jiedan)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| paotui_id | 是 | int |  订单ID |
| status | 是 | int |  设置订单状态 (1：设为接单,3：设为已取货/已购买，4：设为已收货) |
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
######<a name="paotui/setprice">设置最终价格(paotui/setprice)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| paotui_id | 是 | int |  订单ID |
| jiesuan_amount | 是 | int |  结算价格 |
>

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success'
}
```

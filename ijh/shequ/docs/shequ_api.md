**江湖外卖APP API文档**
====================
接口地址: http://waimai.o2o.ijh.cc/Api.php


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

| <span class="w-100">分组</span> | <span class="w-200">接口</span> | <span class="w-200">API</span> |<span class="w-100">登录权限</span>|
|:-----------:|------------------|------------------ |:--------------:|
|   基础    | 测试接口	| [app/test](#app/test)	|  否  |
|   基础    | 基础信息	| [app/info](#app/info)	|  否  |
|   基础    | 城市列表    | [data/city](#data/city)|  否  |
|   基础    | 数据缓存版  | [data/version](#data/version)|  否  |
|   基础    | 短信验证码  | [magic/sendsms](#magic/sendsms) |  否  |
|   会员    | 会员登录	| [passport/login](#passport/login)|  否  |
|   会员    | 注册帐号	| [passport/signup](#passport/signup)|  否  |
|   会员    | 找回密码  | [passport/forgot](#passport/forgot)|  否  |
|   会员    | 微信登录	| [member/wxlogin](#passport/wxlogin)  |  是  |
|   会员    | 登录绑定	| [member/wxbind](#passport/wxbind)  |  是  |
|   会员    | 会员信息	| [member/info](#member/info)	|  是  |
|   会员    | 修改密码	| [member/passwd](#member/passwd) |  是  |
|   会员    | 更换手机	| [member/updatemobile](#member/updatemobile)|  是  |
|   会员    | 修改昵称	| [member/updatename](#member/updatename)|  是  |
|   会员    | 上传头像	| [member/uploadface](#member/uploadface)|  是  |
|   会员    | 绑定微信	| [member/bindweixin](#member/bindweixin)  |  是  |
|   订单    | 邀请好友	| [member/invite](#member/invite)	|  是  |
|   会员    | 会员消息	| [member/msg](#member/msg)    |  是  |
|   会员    | 消息已读	| [member/readmsg](#member/readmsg)|  是  |
|   会员    | 我的收藏	| [member/collect](#member/collect)|  是  |
|   会员    | 添加收藏	| [member/collect/add](#member/collect/add)   |  是  |
|   会员    | 取消收藏	| [member/collect/cancel](#member/collect/cancel)|  是  |
|   订单    | 充值套餐	| [payment/money](#payment/package)	|  否  |
|   订单    | 账户充值	| [payment/money](#payment/money)	|  是  |
|   会员    | 地址列表	| [member/addr](#member/addr)|  是  |
|   会员    | 添加地址	| [member/addr/create](#member/addr/create)|  是  |
|   会员    | 修改地址	| [member/addr/update](#member/addr/update)|  是  |
|   会员    | 地址详情	| [member/addr/detail](#member/addr/detail)|  是  |
|   会员    | 删除地址	| [member/addr/delete](#member/addr/delete)|  是  |
|   会员    | 金额日志	| [member/log/money](#member/log/money)|  是  |
|   会员    | 积分日志	| [member/log/jifen](#member/log/jifen)|  是  |
|   红包    | 红包列表	| [member/hongbao](#member/hongbao)	|  是  |
|   红包    | 红包兑换	| [member/hongbao/exchange](#hongbao/exchange)|  是  |
|   商家    | 分类列表	| [shop/cate](#shop/cate)|  否  |
|   商家    | 商家列表	| [shop/items](#shop/items)	 |  否  |
|   商家    | 商家详情	| [shop/detail](#shop/detail) |  否  |
|   商家    | 评论详情	| [shop/comment](#shop/comment)|  否  |
|   商家    | 发布评论	| [shop/comment/create](#shop/comment/create)|  是  |
|   商品    | 商品列表	| [product/cate](#product/cate) |  否  |
|   商品    | 商品列表	| [product/items](#product/items)|  否  |
|   订单    | 创建订单	| [order/create](#order/create)	|  是  |
|   红包    | 下单信息	| [order/preinfo](#order/preinfo)	|  是  |
|   订单    | 订单列表	| [order/items](#order/items)	|  是  |
|   订单    | 订单详情	| [order/detail](#order/detail)	|  是  |
|   订单    | 订单支付	| [payment/order](#payment/order)	|  是  |
|   订单    | 余额支付	| [payment/paymoney](#payment/paymoney)	|  是  |
|   订单    | 取消订单	| [order/cancel](#order/cancel)	|  是  |
|   订单    | 确认送达	| [order/confirm](#order/confirm)	|  是  |
|   订单    | 订单投诉	| [order/confirm](#order/complaint)	|  是  |
|   商城    | 商城分类	| [mall/cate](#mall/cate)	|  否  |
|   商城    | 商城商品	| [mall/product](#mall/product)	|  否  |
|   商城    | 积分商品	| [mall/product/detail](#mall/product/detail)	|  否  |
|   商城    | 兑换商品	| [mall/order/create](#mall/order/create)|  是  |
|   商城    | 兑换记录	| [mall/order/items](#mall/order/items) |  是  |
|   跑腿    | 首页地图	| [paotui/map](#paotui/map) |  是  |
|   跑腿    | 帮我送下单  | [paotui/song](#paotui/song) |  是  |
|   跑腿    | 帮我买下单  | [paotui/buy](#paotui/buy) |  是  |
|   跑腿    | 订单详情	| [paotui/detail](##paotui/detail)	|  是  |
|   跑腿    | 取消订单	| [paotui/cancel](##paotui/cancel)	|  是  |
|   跑腿    | 订单列表	| [paotui/items](##paotui/items)	|  是  |

<br /><br /><br />
************
######测试接口<a name="app/test">(app/test)</a>

| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
|   无  | 否 |  --	|  否  |


<br />
************
######<a name="app/info">基础信息(app/info)</a>
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
######<a name="passport/login">会员登录(passport/login)</a>
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
######<a name="passport/signup">注册帐号(passport/signup)</a>
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
######<a name="passport/forgot">找回密码(passport/forgot)</a>
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
######<a name="passport/wxlogin">找回密码(passport/wxlogin)</a>
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
######<a name="passport/wxbind">找回密码(passport/wxbind)</a>
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
######<a name="member/info">会员信息(member/info)</a>
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
######<a name="member/passwd">修改密码(member/passwd)</a>
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
######<a name="member/updatemobile">更换手机(member/updatemobile)</a>
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
######<a name="member/updatename">修改昵称(member/updatename)</a>
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
######<a name="member/uploadface">上传头像(member/uploadface)</a>
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
######<a name="member/bindweixin">绑定微信(member/bindweixin)</a>
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
######<a name="member/invite">邀请好友(member/invite)</a>
>>请求参数(无业务参数)
>
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| invite_count | int |  邀请成功数  |
| invite_money | float |  邀请奖励总金额  |
| share_title | string |  分享标题  |
| share_photo | string |  分享图片  |
| share_url | string |  分享链接  |
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
    	"invite_count" : "20",
        "invite_money" : "200",
        "share_title" : "分享标题",
        "share_photo" : "photo/201512/20151212_xxx.jpg",
        "share_url" : "http://waimai.weizx.cn/market/invite-888.html"
    }
}
```

<br />
************
######<a name="member/msg">会员消息(member/msg)</a>
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
######<a name="member/readmsg">阅读消息(member/readmsg)</a>
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
######<a name="member/collect">我的收藏(member/collect)</a>
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
######<a name="member/collect/add">添加关注(member/collect/add)</a>
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
######<a name="member/collect/cancel">取消关注(member/collect/cancel)</a>
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
######<a name="payment/package">充值套餐(payment/package)</a>
>>请求参数(无业务参数)
>
>>请求示例
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| chong	| float | 充值金额 |
| song | float | 赠送金额 |
>
>>返回示例
>
```javascript
{
	'error':'0',
	'message':'success',
    "items"[
    	{"chong":"50", "song":"5"},
        {"chong":"500", "song":"50"},
    ]
}
```

<br />
************
######<a name="payment/money">账户充值(payment/money)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| amount | 是 | float |  充值金额  |
| code | 是 | string |  支付接口 `alipay, wxpay`  |
>>请求示例
>
```javascript
{
	"amount":"100",
	"code":"alipay"
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
| notify_url |	服务器异步通知页面路径 |
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
        "notify_url":"http://waimai.o2o.ijh.cc/trade/payment/notify-alipay.html",
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
>>微信支付返回示例
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

<br />
************
######<a name="member/addr">我的地址(member/addr)</a>
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
######<a name="member/addr/create">创建地址(member/addr/create)</a>
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
######<a name="member/addr/update">修改地址(member/addr/update)</a>
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
######<a name="member/addr/detail">地址详情(member/addr/detail)</a>
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
######<a name="member/addr/delete">删除地址(member/addr/delete)</a>
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
######<a name="member/log/money">资金日志(member/log/money)</a>
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
######<a name="member/log/jifen">积分日志(member/log/jifen)</a>
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
######<a name="member/hongbao">我的红包(member/hongbao)</a>
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
######<a name="member/hongbao/exchange">兑换红包(member/hongbao/exchange)</a>
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
######<a name="shop/cate">商户分类(shop/cate)</a>
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
            },
            {
            	"cate_id" : "2",
                "title" : "小吃",
                "icon" : "photo/201511/20151111_xxxx.png",
            }
        ]
        "total_count" : "30"
    }
}
```

<br />
************
######<a name="shop/items">商户列表(shop/items)</a>
>>请求参数无
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| lat | 是 | string |  纬度  |
| lng | 是 | string |  经度  |
| cate_id | 否 | int |  分类ID  |
| is_new | 否 | int | 是否新店 |
| online_pay | 否 | int | 是否支持在线支付 |
| youhui_first | 否 | int | 首单优惠 |
| youhui_order | 否 | int | 下单立减 |
| pei_type | 否 | int | 配送类型 `0:商户自己送, 1:第三方配送, 2:配送员代购` |
| order | 否 | string |  排序 `空:默认排序,time:送餐时间,juli:距离, sales:销量, score:评价, price:起送价`  |

>>请求示例
>
```javascript
{
	"lat":"111.123456",
    "lng" : "111.123456",
    "cate_id" : "7",
    "is_new" : "1",
    "online_pay" : "1",
    "youhui_first" : "1",
    "youhui_order" : "1",
    "pei_type" : "1";
    "order" : "juli"
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
| freight | float |  配送费用`0:免配送费`  |
| pei_amount | float |  配送费用`第三方配送时，配送员结算价格`  |
| pei_type | int |  配送类型 `0:商家自己送,1:第三方配送,2:配送员代购`|
| yy_status | int |  营业状态 `0:打烊, 1:营业`  |
| yy_stime | time |  开始营业时间  |
| yy_ltime | time | 结束营业时间  |
| is_new | int |  是否新店铺 `1:新店`  |
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
                "freight" : "5",
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
                "is_new":"1",
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
                "freight" : "5",
                "score":"88888",
                "comments":"50000",
                "orders":"100000",
                "first_amount":"30",
                "pei_amount":"0",
                "pei_type":"1",
                "yy_status":"1",
                "yy_stime":"9:00",
                "yy_ltime":"20:00",
                "is_new":"1",
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
######<a name="shop/detail">商户详情(shop/detail)</a>
>>请求参数无
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
| orders | int |  订单数   |
| min_amount | float |  起送价  |
| first_amount | float |  首单优惠  |
| freight | float |  配送费用`0:免配送费`  |
| pei_amount | float |  配送费用`第三方配送给配送员结算的价格`  |
| pei_type | int |  配送类型 `0:商家自己送,1:第三方配送,2:配送员代购`|
| yy_status | int |  营业状态 `0:打烊, 1:营业`  |
| yy_stime | time |  开始营业时间  |
| yy_ltime | time | 结束营业时间  |
| is_new | int |  是否新店铺 `1:新店`  |
| online_pay | int |  是否支持在线支付 `0:不支持, 1:支持在线支付`  |
| info | string |  商户描述  |
| dateline | int |  创建时间UNIXTIME  |
>>请求示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
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
        "freight" : "5",
        "score":"88888",
        "comments":"50000",
        "orders":"100000",
        "first_amount":"30",
        "pei_amount":"0",
        "pei_type":"1",
        "yy_status":"1",
        "yy_stime":"9:00",
        "yy_ltime":"20:00",
        "is_new":"1",
        "online_pay":"1",
        "info":"店铺介绍店铺介绍店铺介绍店铺介绍",
        "dateline" : "140000000"
    }
}
```

<br />
************
######<a name="shop/comment">商户评论(shop/comment)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| shop_id | 是 | int |  商户ID |
| page | 否 | int |  分页码  |
>>请求示例
>
```javascript
{
    "status" : "1",
	"page":"1"
}
```
>>返回示例
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| comment_id | int | 评论ID |
| shop_id | int | 商户ID |
| uid | int | 会员UID |
| order_id	| int | 订单号 |
| score | int | 评分  |
| content | string | 评论内容 |
| reply | string | 回复内容 |
| reply_time | int | 回复时间UNIXTIME, `0:未回复` |
| dateline | int | 评论时间UNIXTIME |
| photos | array | 评论图片 |
>>请求示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
    	"items" : [
        	{
            	"comment" : "1",
                "shop_id" : "11",
                "uid" : "20",
                "order_id" : "5",
                "score" : "5",
                "content" : "送餐数度度，味道正点",
                "reply" : "感谢您的支持",
                "reply_time" : "140000011"
                "dateline" : "140000000",
                "photos" : [
                	{
                        "photo_id" : "22",
                        "photo" : "photo/201511/201511_1111.jpg"
                	},
                	{
                        "photo_id" : "23",
                        "photo" : "photo/201511/201511_1111.jpg"
                	}
            	]
            },
        	{
            	"comment" : "1",
                "shop_id" : "11",
                "uid" : "20",
                "order_id" : "5",
                "score" : "5",
                "content" : "送餐数度度，味道正点",
                "reply" : "",
                "reply_time" : "0"
                "dateline" : "140000000",
                "photos" : []
            },
        ]
        "total_count" : "30"
    }
}
```

<br />
************
######<a name="shop/comment/create">商户评论(shop/comment/create)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| shop_id | 是 | int |  商户ID |
| order_id | 是 | int |  订单ID  |
| score_fuwu | 是 | int |  服务评分  |
| score_kouwei | 是 | int |  口味评分  |
| pei_time | 是 | int |  配送时间，分钟  |
| content | 是 | string |  评论内容  |
| photo | 是 | string |  评论图片 base64图片，多个图用 , 分割  |
>>请求示例
>
```javascript
{
    "order_id" : "123",
	"score_fuwu":"5",
    "score_kouwei":"5",
    "content" : "送餐数度度，味道正点",
    "pei_time" : "30",
    "photo" : "base64string"
}
```
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
		"comment_id" : "33"
    }
}
```

<br />
************
######<a name="product/cate">商品分类(product/cate)</a>
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
######<a name="product/items">商品分类(product/items)</a>
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

<br />
************
######<a name="order/create">创建订单(order/create)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| shop_id | 是 | int |  商户ID |
| addr_id | 是 | int |  地址ID |
| products | 是 | string | 是一个格式化的字符 `商品1ID:数量1,商品2ID:数量2...` |
| pei_time | 否 | time | 要求配送时间 `0:尽快送达, 其它时间为商家营业范围内`|
| online_pay | 是 | int | 付款方式 `0:货到付款, 1:在线支付` |
| passwd | 否 | int |  支付密码同登录密码，当会员有余额时优先用帐户余额支付 |
| hongbao_id | 否 | int |  红包ID |
| note | 否 | string |  订单备注要求 |

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
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| order_id | int | 订单ID |
| amount | float | 订单还需要支付金额 |
>>返回示例
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

<br />
************
######<a name="order/items">我的订单(order/items)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| status | 否 | int |  订单状态 `0:全部, 1:进行中的, 2:已完成的` |
| pay_status | 否 | int | 支付状态  `0:未支付, 1:已经支付` |
| comment_status | 否 | int | 评论状态 `0:未评价， 1:已经评价, 需要与status=2配合使用 ` |
| page | 否 | int | 分页码 |

>>请求示例
>
```javascript
{
    "status" : "1",
    "pay_status" : "1",
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
| dateline | int | 下单时间UNIXTIME |
| shop | array | 商户信息 [查看字典](#table.shop)|
| staff | array | 配送员信息 [查看字典](#table.staff) |
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
                },
                "staff" : {
                    "staff_id" : "111",
                    "name" : "游医",
                    "mobile" : "13812345678",
                    "lat" : "111.123456",
                    "lat" : "111.123456"
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
                },
                "staff" : {}
            }
        ],
        "total_count" : "30"
    }
}
```

<br />
************
######<a name="order/detail">订单详情(order/detail)</a>
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
| shop | array | 商户信息 [商户字典](#table.shop)|
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
        "shop" : {
        	"shop_id" : "111"，
            "title" : "江湖客栈",
            "phone" : "0551-64278115",
            "logo" : "photo/201511/20151111_111111.jpg",
        },
        "staff" : {
        	"staff_id" : "111",
            "name" : "游医",
            "mobile" : "13812345678",
            "lat" : "111.123456",
            "lat" : "111.123456"
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
######<a name="order/preinfo">下单信息(order/preinfo)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| shop_id | 是 | int |  商户ID |
| amount | 是 | float |  商品金额 |
| addr_id | 否 | int |  地址ID |

>>请求示例
>
```javascript
{
    "shop_id" : "1",
    "amount" : "100",
    "addr_id" : "1"
}
```

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
    	"addr_id" : "2",
        "addr" : {
            "addr_id":"2",
            "uid" : "888",
            "contact":"游医",
            "mobile":"13812345678",
            "addr" : "安徽省合肥市蜀山区望江西路",
            "house" : "华润五彩国际",
            "is_default" : "1",
            "lat" : "111.123456",
            "lng" : "111.123456"
        },
        "hongbao_id" : "1",
        "hongbao":{
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
        }
    }
}
```


<br />
######<a name="order/cancel">取消订单(order/cancel)</a>
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
######<a name="order/confrim">确认送达(order/confrim)</a>
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
######<a name="order/complaint">订单投诉(order/complaint)</a>
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
######<a name="order/cuidan">订单催单(order/cuidan)</a>
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
######<a name="payment/order">支付订单(payment/order)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| order_id | 是 | int |  订单ID |
| code | 是 | string |  支付接口 `alipay, wxpay, money` |

>>请求示例
>
```javascript
{
    "order_" : "123",
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
        "notify_url":"http://waimai.o2o.ijh.cc/trade/payment/notify-alipay.html",
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

<br />
######<a name="payment/paymoney">余额支付(payment/paymoney)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| trade_no | 是 | int |  支付订单号 |
| passwd | 是 | string |  登录密码 |
>>请求示例
>
```javascript
{
    "trade_no" : "201511111234",
    "passwd" : "123456"
}
```

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data' : {
    	"order_id" : "11",
        "trade_no" : "201511111234",
        "pay_trade_no" : "201511111234",
        "amount" : "28.00",
        "code" : "money"
    }
}
```

<br />
************
######<a name="mall/cate">积分商城分类(mall/cate)</a>
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
######<a name="mall/product">积分商城商品(mall/product)</a>
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
######<a name="mall/product/detail">积分商品(mall/product/detail)</a>
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
######<a name="mall/order/create">积分商城分类(mall/order/create)</a>
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
######<a name="mall/order/items">积分商城分类(mall/order/items)</a>
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


<br>
><a name="paotui/map">跑腿首页地图</a>

| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| alat | string | a点纬度 |
| alng | string | a点经度 |
| blat | string | b点纬度 |
| blng | string | b点经度 |

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
><a name="paotui/song">帮我送下单</a>

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
><a name="paotui/buy">帮我买下单</a>

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
######<a name="paotui/cancel">取消订单(paotui/cancel)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| paotui_id | 是 | int |  订单ID |



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
######<a name="paotui/items">订单列表(paotui/items)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| status | 否 | int |  订单状态 `0:全部, 1:进行中的, 2:已完成的` |
| pay_status | 否 | int | 支付状态  `0:未支付, 1:已经支付` |
| page | 否 | int | 分页码 |

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
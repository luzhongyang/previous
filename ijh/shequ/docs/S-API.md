
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
|  
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
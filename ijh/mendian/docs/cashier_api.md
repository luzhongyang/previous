收银API接口文档
==============

| 分组 | 接口 | API |登录权限 |
|:-----------:|------------------|------------------ |:--------------:|
|  基础    | 测试接口  | [cashier/app/test](#cashier/app/test)   |  否  |
|  基础    | 基础信息  | [cashier/app/info](#cashier/app/info)   |  否  |
|  数据    | 银行列表  | [data/bank](#data/bank) |  否  |
|  数据    | 发送短信  | [magic/sendsms](#cashier/sendsms) |  否  |
|  帐号    | 收银员登录 | [cashier/login](#cashier/login)	|  否  |
|  帐号    | 帐号注册	 | [cashier/login/signup](#cashier/login/signup)	|  否  |
|  帐号    | 找回密码 | [cashier/login/forgot](#cashier/login/forgot)	|  否  |
|  商户    | 商户信息 | [cashier/info](#cashier/info)	|  是  |
|  商户    | 认证信息 | [cashier/info/verify](#cashier/info/verify)	|  是  |
|  商户    | 云打印机 | [cashier/info/printer](#cashier/info/printer)	|  是  |
|  设置    | 下单立减 | [cashier/set/youhui](#cashier/set/youhui)	|  是  |
|  设置    | 充值套餐 | [cashier/set/package](#cashier/set/package)	|  是  |
|  设置    | 抹零设置 | [cashier/set/moling](#cashier/set/moling)	|  是  |
|  设置    | 积分设置 | [cashier/set/jifen](#cashier/set/jifen)	|  是  |
|  设置    | 下单立减 | [cashier/set/youhui](#cashier/set/youhui)	|  是  |
|  设置    | 店铺设置 | [cashier/set/info](#cashier/set/info)	|  是  |
|  设置    | 提交认证 | [cashier/set/verify](#cashier/set/verify)	|  是  |
|  设置    | 提现账号 | [cashier/set/account](#cashier/set/account)	|  是  |
|  收银员  | 收银员列表 | [cashier/staff/items](#cashier/staff/items)	|  是  |
|  收银员  | 收银员详情 | [cashier/staff/detail](#cashier/staff/detail)	|  是  |
|  收银员  | 收银交接班 | [cashier/staff/jiaoban](#cashier/staff/jiaoban)	|  是  |
|  收银员  | 添加收银员 | [cashier/staff/create](#cashier/staff/create)	|  是  |
|  收银员  | 修改收银员 | [cashier/staff/edit](#cashier/staff/edit)	|  是  |
|  收银员  | 审核收银员 | [cashier/staff/doaudit](#cashier/staff/doaudit)	|  是  |
|  收银员  | 删除收银员 | [cashier/staff/delete](#cashier/staff/delete)	|  是  |
|  收银员  | 邀请收银员 | [cashier/staff/invite](#cashier/staff/invite)	|  是  |
|  收银员  | 修改密码 | [cashier/staff/setpasswd](#cashier/staff/setpasswd)	|  是  |
|  收银员  | 设置昵称 | [cashier/staff/setinfo](#cashier/staff/setinfo)	|  是  |
|  收银员  | 交班记录 | [cashier/staff/log/items](#cashier/staff/log/items)	|  是  |
|  收银员  | 记录详情 | [cashier/staff/log/detail](#cashier/staff/log/detail)	|  是  |
|  商品    | 商品列表 | [cashier/product/items](#cashier/product/items)	|  是  |
|  商品    | 添加商品 | [cashier/product/create](#cashier/product/create)	|  是  |
|  商品    | 修改商品 | [cashier/product/edit](#cashier/product/edit)	|  是  |
|  商品    | 删除商品 | [cashier/product/delete](#cashier/product/delete)	|  是  |
|  分类    | 商品分类 | [cashier/product/cate/items](#cashier/product/cate/items)	|  是  |
|  分类    | 修改分类 | [cashier/product/cate/create](#cashier/product/cate/create)	|  是  |
|  分类    | 修改分类 | [cashier/product/cate/edit](#cashier/product/cate/edit)	|  是  |
|  分类    | 删除分类 | [cashier/product/cate/delete](#cashier/product/cate/delete)	|  是  |
|  订单    | 订单列表 | [cashier/order/items](#cashier/order/items)	|  是  |
|  订单    | 订单详情 | [cashier/order/detail](#cashier/order/detail)	|  是  |
|  订单    | 创建/挂单 | [cashier/order/create](#cashier/order/create)	|  是  |
|  订单    | 更新订单 | [cashier/order/edit](#cashier/order/edit)	|  是  |
|  订单    | 订单退款 | [cashier/order/refund](#cashier/order/refund)	|  是  |
|  订单    | 取消订单 | [cashier/order/cancel](#cashier/order/cancel)	|  是  |
|  订单    | 打印订单 | [cashier/order/printer](#cashier/order/printer)	|  是  |
|  支付    | 资金流水 | [cashier/order/log](#cashier/order/log)	|  是  |
|  支付    | 订单统计 | [cashier/order/tongji](#cashier/order/tongji)	|  是  |
|  支付    | 现金支付 | [cashier/payment/cashpay](#cashier/payment/cashpay)	|  是  |
|  支付    | 扫码支付 | [cashier/payment/codepay](#cashier/payment/codepay)	|  是  |
|  支付    | 条码支付 | [cashier/payment/qrcodepay](#cashier/payment/qrcodepay)	|  是  |
|  支付    | 资金流水 | [cashier/order/log](#cashier/order/log)	|  是  |
|  资金   | 资金日志 | [cashier/money/log](#cashier/money/log)	|  是  |
|  资金   | 体现日志 | [cashier/money/tixian](#cashier/money/tixian)	|  是  |
|  资金   | 申请体现 | [cashier/money/txlog](#cashier/money/txlog)	|  是  |
|  资金   | 账户信息 | [cashier/money/info](#cashier/money/info)	|  是  |
|  会员卡   | 会员卡列表 | [cashier/card/items](#cashier/card/items)	|  是  |
|  会员卡   | 会员卡详情 | [cashier/card/detail](#cashier/card/detail)	|  是  |
|  会员卡   | 添加会员卡 | [cashier/card/create](#cashier/order/create)	|  是  |
|  会员卡   | 修改会员卡 | [cashier/card/edit](#cashier/card/edit)	|  是  |
|  会员卡   | 积分/资金日志 | [cashier/card/log](#cashier/card/log)	|  是  |
|  会员卡   | 充值套餐 | [cashier/card/package](#cashier/card/package)	|  是  |
|  会员卡   | 积分/资金日志 | [cashier/card/chongzhi](#cashier/card/chongzhi)	|  是  |
|  会员卡   | 会员等级 | [cashier/card/grade/items](#cashier/card/grade/items)	|  是  |
|  会员卡   | 添加等级 | [cashier/card/grade/create](#cashier/card/grade/create)	|  是  |
|  会员卡   | 修改等级 | [cashier/card/grade/edit](#cashier/card/grade/edit)	|  是  |
|  会员卡   | 删除等级 | [cashier/card/grade/delete](#cashier/card/grade/edit)	|  是  |
|  积分   | 商品列表 | [cashier/jifen/product/items](#cashier/jifen/product/items)	|  是  |
|  积分   | 添加商品 | [cashier/jifen/product/create](#cashier/jifen/product/create)	|  是  |
|  积分   | 修改商品 | [cashier/jfien/product/edit](#cashier/jifen/product/edit)	|  是  |
|  积分   | 删除商品 | [cashier/jfien/product/delete](#cashier/jifen/product/delete)	|  是  |
|  积分   | 订单列表 | [cashier/jfien/order/items](#cashier/jifen/order/items)	|  是  |
|  积分   | 确认兑换 | [cashier/jfien/order/confirm](#cashier/jifen/order/confirm)	|  是  |
|  积分   | 取消兑换 | [cashier/jfien/order/cancel](#cashier/jifen/order/cancel)	|  是  |
|  卡券   | 卡券列表 | [cashier/coupon/items](#cashier/coupon/items)	|  是  |
|  卡券   | 卡券详情 | [cashier/coupon/detail](#cashier/coupon/detail)	|  是  |
|  卡券   | 添加卡券 | [cashier/coupon/create](#cashier/coupon/create)	|  是  |
|  卡券   | 修改卡券 | [cashier/coupon/edit](#cashier/coupon/edit)	|  是  |
|  卡券   | 使卡券失效（过期） | [cashier/coupon/closecoupon](#cashier/coupon/closecoupon)	|  是  |
|  卡券   | 定向发放卡券 | [cashier/coupon/sendcoupon](#cashier/coupon/sendcoupon)	|  是  |
|  卡券   | 会员优惠券列表 | [cashier/coupon/coupon/items](#cashier/coupon/coupon/items)	|  是  |
|  卡券   | 搜索会员优惠券 | [cashier/coupon/coupon/search](#cashier/coupon/coupon/search)	|  是  |
|  商品   | 条码查询 | [cashier/product/barcode](#cashier/product/barcode)	|  是  |
|  商品   | APP广告 | [data/cashieradv](#data/cashieradv)	|  是  |
<br />


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
######<a name="cashier/login">帐号登录(cashier/login)</a>
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
| 参数名称 | 类型 |描述 |
|--------|:-------:|------|
| staff_id | int |  收银员ＩＤ  |
| name | string | 收银员名 |
| mobile | string |  手机号  |
| is_owner | int |  是否为店主 `0:店员, 1:店主`  |
| shop_id | int |  商户ID  |
| token | string |  会话token  |
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
          "staff_id":"888",
          "shop_id" : "1"
		  "is_owner" : "1",
          "name":"游医"，
          "mobile":"13888888888"，
          "token":"888-A2D28B1CA20DC547425343D2ACAFE540",
          "shop" : {
          	"title" : "测试店铺1",
            "logo" : "http://o2o.ijh.cc/xxxx.png",
            "phone" : "1388888888",
            "verify_name" : "1"
          }
    }
}
```

<br />
************
######<a name="cashier/login/signup">注册帐号(cashier/login/signup)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| mobile | 是 | string |  手机号码  |
| mobile | 是 | string |  手机号码  |
| sms_code | 是 | string |  验证码  |
| passwd | 是 | string |  登录密码  |
| title | 否 | string |  店铺名称  |
| cate_id | 否 | int |  店铺分类  |
| contact | 否 | string |  联系人  |
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
| 参数名称 | 类型 |描述 |
|--------|:-------:|------|
| id_name | string |  真实姓名 |
| id_number | string |  身份证号 |
| id_photo1 | string |  身份证正面 |
| id_photo2 | string |  身份证反面 |
| id_photo3 | string |  手持身份证 |
| mentou_photo | string |  门头照片 |
| shop_photo1 | string |  店铺内景1 |
| shop_photo2 | string |  店铺内景2 |
| shop_photo2 | string |  店铺内景3 |
| verify | int | 认证状态 `0:审核中, 1:通过审核, -1:拒绝审核` |
>
```javascript
{
    'error':'0',
    'message':'success'
}
```

<br />
************
######<a name="cashier/login/forgot">找回密码(cashier/login/forgot)</a>
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
######<a name="cashier/info">商户信息(cashier/info)</a>
>>请求参数（无）
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
        "shop_detail": {
          "shop_id": "1",
          "title": "江湖小栈",
          "contact": "游医",
          "phone": "13888888888",
          "total_money": "0.02",
          "money": "0.02",
          "logo": "",
          "verify_name": "0",
          "dateline": "1477971336",
          "orders": "0",
          "is_youhui": "1",
          "discount": "9.8,9,8.8,8",
          "youhui": "10,20,50,100",
          "is_moling": "1",
          "moling": "4",
          "xf_jifen" : "1:1",
    	  "qr_invite_staff" : "http://shop1.weizx.cn/card/invite",
          "qr_paycode" : "http://shop1.weizx.cn/trade/paycode",
          "package": "100:10:100,200:20:200,500:50:600,1000:120:1200",
          "youhui_data": [
            "10",
            "20",
            "50",
            "100"
          ],
          "discount_data": [
            "9.8",
            "9",
            "8.8",
            "8"
          ],
          "moling_label": "四舍五入角",
          "package_data": [
            {
              "money": "100",
              "give": "10",
              "jifen": "100"
            },
            {
              "money": "200",
              "give": "20",
              "jifen": "200"
            },
            {
              "money": "500",
              "give": "50",
              "jifen": "600"
            },
            {
              "money": "1000",
              "give": "120",
              "jifen": "1200"
            }
          ]
        },
        "staff_detail": {
          "staff_id": "1",
          "shop_id": "1",
          "is_owner": "1",
          "name": "游医",
          "mobile": "13888888888",
          "day_orders": "0",
          "day_cash": "0.00",
          "day_money": "0.00",
          "day_alipay": "0.00",
          "day_wxpay": "0.00",
          "day_refund": "0.00",
          "day_chongzhi": "0.00",
          "audit": "0",
        },
  		"verify_detail": {
          "shop_id": "1",
          "id_name": "3333****4444",
          "id_number": "张三",
          "verify": "0"
        }
    }
}
```



<br />
************
######<a name="cashier/info/verify">认证资料(cashier/info/verify)</a>
>>请求参数（无）
>>返回示例
>
| 参数名称 | 类型 | 描述 |
|--------|------|------|
| id_name  | string |  真实姓名 |
| id_number | string |  身份证号 |
| id_photo1  | string |  身份证正面 |
| id_photo2  | string |  身份证反面 |
| id_photo3  | string |  手持身份证 |
| mentou_photo  | string |  门头照片 |
| shop_photo1  | string |  店铺内景1 |
| shop_photo2  | string |  店铺内景2 |
| shop_photo2  | string |  店铺内景3 |
| verify  | int |  状态 `0:待审, 1:通过, 2:拒绝` |
>
```javascript
{
    'error':'0',
    'message':'success',
  	"data": {
        "verify_detail": {
          "shop_id": "1",
          "id_name": "江湖游医",
          "id_number": "333111222444654321",
          "id_photo1": "photo/photo.png",
          "id_photo2": "photo/photo.png",
          "id_photo3": "photo/photo.png",
          "mentou_photo": "photo/photo.png",
          "shop_photo1": "photo/photo.png",
          "shop_photo2": "photo/photo.png",
          "shop_photo3": "photo/photo.png",
          "verify": "1"
        }
    }
}
```

<br />
************
######<a name="cashier/info/print">云打印机(cashier/info/printer)</a>
>>请求参数（无）
>>返回示例
>
| 参数名称 | 类型 | 描述 |
|--------|------|------|
| printer_id  | int |  打印机ID |
| shop_id  | int |  商户ID |
| title | string |  设备名称 |
| type  | string |  设备类型 |
>
```javascript
{
    'error':'0',
    'message':'success',
  	"data": {
        "items": [
        	"printer_id" : "1",
            "shop_id" : "1",
            "title" : "一号打印机",
            "type" : "ylyun"
        ],
        "items": [
        	"printer_id" : "2",
            "shop_id" : "1",
            "title" : "二号打印机",
            "type" : "ylyun"
        ]
    }
}
```

<br />
************
######<a name="cashier/set/info">优惠设置(cashier/set/info)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| title  | 否 | string | 店铺标题  |
| logo  | 否 | 文件流 |  店铺LOGO文件流  |
>>请求示例
>
```javascript
{
	"title" : "测试店铺1",
    "logo" : "文件流"
}
```
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
    	"shop_id" : "1",
        "title" : "测试店铺1",
        "logo" : "photo/111.jpg"
    }
}
```

<br />
************
######<a name="cashier/set/verify">提交认证(cashier/set/verify)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| id_name  | 是 | string |  真实姓名 |
| id_number | 是 | string |  身份证号 |
| id_photo1  | 是 | 文件流 |  身份证正面 |
| id_photo2  | 是 | 文件流 |  身份证反面 |
| id_photo3  | 是 | 文件流 |  手持身份证 |
| mentou_photo  | 是 | 文件流 |  门头照片 |
| shop_photo1  | 是 | 文件流 |  店铺内景1 |
| shop_photo2  | 是 | 文件流 |  店铺内景2 |
| shop_photo2  | 是 | 文件流 |  店铺内景3 |
>>请求示例
>
```javascript
{
    "id_name" : "江湖游医",
    "id_number" : "333111444555123456",
    "id_photo1" : "文件流",
    "id_photo2" : "文件流",
    "id_photo3" : "文件流",
    "mentou_photo" : "文件流",
    "shop_photo1" : "文件流",
    "shop_photo2" : "文件流",
    "shop_photo3" : "文件流"
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
######<a name="cashier/set/account">提交认证(cashier/set/account)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| account_type  | 是 | string |  开户行 |
| account_name | 是 | string |  开户人 |
| account_number  | 是 | string |  账号 |
>>请求示例
>
```javascript
{
    "account_type" : "工商银行",
    "account_name" : "游医",
    "account_number" : "123456789"
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
######<a name="cashier/set/youhui">优惠设置(cashier/set/youhui)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| is_youhui  | 是 | string |  优惠状态, `1:开启, 0:关闭`  |
| discount  | 是 | string |  以逗号分隔的折扣, `10进制，如9.5表示9.5折`  |
| youhui  | 是 | string |  以逗号分隔的优惠金额  |
>>请求示例
>
```javascript
{
	"is_youhui" : "1",
    "youhui" : "10,20,50,100",
    discount" : "9.8,9,8.8"
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
######<a name="cashier/set/package">充值套餐(cashier/set/package)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| package  | 是 | string |  以逗号分隔的套餐, `充值金额:赠送金额:赠送积分,100:10:100` |
>>请求示例
>
```javascript
{
    "package" : "100:10:100,200:20,200"
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
######<a name="cashier/set/jifen">积分设置(cashier/set/jifen)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| xf_jifen  | 是 | string |  每消费赠送的积分 `金额:积分` |
>>请求示例
>
```javascript
{
    "xf_jifen" : "10:1"
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
######<a name="cashier/set/moling">抹零设置(cashier/set/moling)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| is_moling  | 是 | int |   是否开启抹零 |
| moling  | 是 | int | 抹零 `1:抹分,2:抹角,3:四舍五入分,4:四舍五入角` |
>>请求示例
>
```javascript
{
    "is_moling" : "1",
    "moling" : "4"
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
######<a name="cashier/staff/items">收银员列表(cashier/staff/items)</a>
>>请求示例(无)

>>返回示例
>
| 参数名称 | 类型 |描述 |
|--------|:-------:|------|
| staff_id | int |  收银员ID  |
| shop_id | int | 商户ID |
| is_owner | int |  是否店主 `1:店主, 0：电员`  |
| name | string |  昵称  |
| mobile | string | 手机号 |
| day_orders | int | 当班订单数量 |
| day_cash | float | 现金首款 |
| day_money | float | 会员卡余额收款 |
| day_alipay | float | 支付宝收款 |
| day_wxpay | float | 微信收款 |
| day_refund | float | 退款 |
| day_chongzhi | float | 充值 |
| audit | int | 审核状态 `1:通过审核, 0:待审` |
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
        "items": [
          {
            "staff_id": "1",
            "shop_id": "1",
            "is_owner": "1",
            "name": "",
            "mobile": "13888888888",
            "day_orders": "0",
            "day_cash": "0.00",
            "day_money": "0.00",
            "day_alipay": "0.00",
            "day_wxpay": "0.00",
            "day_refund": "0.00",
            "audit": "0"
          },
          {
            "staff_id": "2",
            "shop_id": "1",
            "is_owner": "1",
            "name": "",
            "mobile": "13888888889",
            "day_orders": "0",
            "day_cash": "0.00",
            "day_money": "0.00",
            "day_alipay": "0.00",
            "day_wxpay": "0.00",
            "day_refund": "0.00",
            "day_chongzhi" : "0.00",
            "audit": "0"
          }
        ]
    }
}
```

<br />
************
######<a name="cashier/staff/detail">收银员列表(cashier/staff/detail)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| staff_id | 是 | int | 收银员ID |
>>请求示例
>
```javascript
{
	"staff_id":"1"
}
```

>>返回示例
>
| 参数名称 | 类型 |描述 |
|--------|:-------:|------|
| staff_id | int |  收银员ID  |
| shop_id | int | 商户ID |
| is_owner | int |  是否店主 `1:店主, 0：电员`  |
| name | string |  昵称  |
| mobile | string | 手机号 |
| day_orders | int | 当班订单数量 |
| day_cash | float | 现金首款 |
| day_money | float | 会员卡余额收款 |
| day_alipay | float | 支付宝收款 |
| day_wxpay | float | 微信收款 |
| audit | int | 审核状态 `1:通过审核, 0:待审` |
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
        "staff_detail": {
            "staff_id": "1",
            "shop_id": "1",
            "is_owner": "1",
            "name": "",
            "mobile": "13888888888",
            "day_orders": "0",
            "day_cash": "0.00",
            "day_money": "0.00",
            "day_alipay": "0.00",
            "day_wxpay": "0.00",
            "day_refund": "0.00",
            "audit": "0"
       	}
    }
}
```

<br />
************
######<a name="cashier/staff/jiaoban">收银交接班(cashier/staff/jiaoban)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| staff_id | 是 | int | 收银员ID |
>>请求示例
>
```javascript
{
	"staff_id":"1"
}
```

>>返回示例
>
| 参数名称 | 类型 |描述 |
|--------|:-------:|------|
| staff_id | int |  收银员ID  |
| shop_id | int | 商户ID |
| is_owner | int |  是否店主 `1:店主, 0：电员`  |
| name | string |  昵称  |
| mobile | string | 手机号 |
| day_orders | int | 当班订单数量 |
| day_cash | float | 现金首款 |
| day_money | float | 会员卡余额收款 |
| day_alipay | float | 支付宝收款 |
| day_wxpay | float | 微信收款 |
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
        "staff_detail": {
            "staff_id": "1",
            "shop_id": "1",
            "is_owner": "1",
            "name": "",
            "mobile": "13888888888",
            "day_orders": "10",
            "day_cash": "10.00",
            "day_money": "10.00",
            "day_alipay": "10.00",
            "day_wxpay": "20.00",
            "day_refund": "30.00",
            "audit": "0"
       	}
    }
}
```

<br />
************
######<a name="cashier/staff/create">添加收银员(cashier/staff/create)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| mobile | 是 | string | 手机号 |
| name | 是 | string | 昵称 |
>>请求示例
>
```javascript
{
	"mobile":"1388888888",
    "name" : "张三"
}
```

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
        "staff_id": "1"
    }
}
```

<br />
************
######<a name="cashier/staff/edit">修改收银员(cashier/staff/edit)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| staff_id | 是 | int | 收银员ID |
| name | 是 | string | 昵称 |
>>请求示例
>
```javascript
{
	"staff_id":"1",
    "name" : "张三"
}
```

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
        "staff_id": "1"
    }
}
```

<br />
************
######<a name="cashier/staff/doaudit">审核收银员(cashier/staff/doaudit)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| staff_id | 是 | int | 收银员ID |
>>请求示例
>
```javascript
{
	"staff_id":"1"
}
```

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
        "staff_id": "1"
    }
}
```

<br />
************
######<a name="cashier/staff/delete">删除收银员(cashier/staff/delete)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| staff_id | 是 | int | 收银员ID |
>>请求示例
>
```javascript
{
	"staff_id":"1"
}
```

>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
        "staff_id": "1"
    }
}
```

<br />
************
######<a name="cashier/staff/invite">邀请收银员(cashier/staff/invite)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| mobile | 是 | string | 手机号 |
>>请求示例
>
```javascript
{
	"mobile":"13888888888"
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
######<a name="cashier/staff/setpasswd">修改密码(cashier/staff/setpasswd)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| old_passwd | 是 | string | 旧密码 |
| new_passwd | 是 | string | 新密码 |
>>请求示例
>
```javascript
{
	"old_passwd":"123456",
    "new_passwd" : "654321"
}
```
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
        "staff_id": "1"
    }
}
```

<br />
************
######<a name="cashier/staff/setinfo">修改密码(cashier/staff/setinfo)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| name | 是 | string | 昵称 |
>>请求示例
>
```javascript
{
    "name" : "张三"
}
```
>>返回示例
>
| 参数名称 | 类型 |描述 |
|--------|:-------:|------|
| staff_id | int |  收银员ＩＤ  |
| name | string | 收银员名 |
| mobile | string |  手机号  |
| is_owner | int |  是否为店主 `0:店员, 1:店主`  |
| shop_id | int |  商户ID  |
| token | string |  会话token  |
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
          "staff_id":"888",
          "shop_id" : "1"
          "is_owner" : "1",
          "name":"游医"，
          "mobile":"13888888888"，
          "token":"888-A2D28B1CA20DC547425343D2ACAFE540",
    }
}
```

<br />
************
######<a name="cashier/staff/log/items">交班记录(cashier/staff/log/items)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| page | 否 | int | 页码 |
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
| log_id | int |  ID  |
| staff_id | int |  收银员ID  |
| shop_id | int | 商户ID |
| day_orders | int | 当班订单数量 |
| day_cash | float | 现金首款 |
| day_money | float | 会员卡余额收款 |
| day_alipay | float | 支付宝收款 |
| day_wxpay | float | 微信收款 |
| day_refund | float | 退款 |
| day | int | 日期 |
| dateline | int | 交班时间UNIXTIME |
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
        "items": [
          {
          	"log_id": "1",
            "staff_id": "1",
            "shop_id": "1",
            "day_orders": "1",
            "day_cash": "10.00",
            "day_money": "0.00",
            "day_alipay": "0.00",
            "day_wxpay": "0.00",
            "day_refund": "0.00",
            "day": "20161111",
            "dateline" : "1400000000"
          },
          {
          	"log_id": "2",
            "staff_id": "1",
            "shop_id": "1",
            "day_orders": "1",
            "day_cash": "10.00",
            "day_money": "0.00",
            "day_alipay": "0.00",
            "day_wxpay": "0.00",
            "day_refund": "0.00",
            "day": "20161111",
            "dateline" : "1400000000"
          }
        ]
    }
}
```

<br />
************
######<a name="cashier/staff/log/detail">交班记录详情(cashier/staff/log/detail)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| log_id | 是 | int | 记录ID |
>>请求示例
>
```javascript
{
    "log_id" : "1"
}
```
>>返回示例
>
| 参数名称 | 类型 |描述 |
|--------|:-------:|------|
| log_id | int |  ID  |
| staff_id | int |  收银员ID  |
| shop_id | int | 商户ID |
| day_orders | int | 当班订单数量 |
| day_cash | float | 现金首款 |
| day_money | float | 会员卡余额收款 |
| day_alipay | float | 支付宝收款 |
| day_wxpay | float | 微信收款 |
| day_refund | float | 退款 |
| day | int | 日期 |
| dateline | int | 交班时间UNIXTIME |
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
        "log_detail": {
          	"log_id": "1",
            "staff_id": "1",
            "shop_id": "1",
            "day_orders": "1",
            "day_cash": "10.00",
            "day_money": "0.00",
            "day_alipay": "0.00",
            "day_wxpay": "0.00",
            "day_refund": "0.00",
            "day": "20161111",
            "dateline" : "1400000000"
      },
      "staff_detail" : {
      	"staff_id" : "1",
        "name" : "张三",
        "mobile" : "13888888888"
      }
    }
}
```


<br />
************
######<a name="cashier/product/items">商品列表(cashier/product/items)</a>
>>请求示例(无)

>>返回示例
>
| 参数名称 | 类型 |描述 |
|--------|:-------:|------|
| cate_id | int |  商品分类  |
| title | string | 分类名 |
| shop_id | int |  商户ID  |
| orderby | int |  排序  |
| product_list | object | 商品 [商品字典](#table.cashier_product)  |
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
          "items":
          [
            {
                "cate_id" : "1",
                "shop_id" : "1",
                "title" : "测试分类1",
                "orderby" : "1",
                "product_list" : [
                    {
                        "product_id":"1",
                        "title" : "测试商品标题1",
                        "price" : "100",
                        "photo" : "http://yun.ijh.cc/attachs/photo/124.png",
                        "code" : "12345678",
                        "stock" : "100",
                        "sales" : "10",
                        "orderby" : "10"
                    },
                    {
                        "product_id":"2",
                        "title" : "测试商品标题2",
                        "price" : "100",
                        "photo" : "http://yun.ijh.cc/attachs/photo/124.png",
                        "code" : "123456780",
                        "stock" : "100",
                        "sales" : "10",
                        "orderby" : "10"
                    }
                ]
            },
            {
                "cate_id" : "2",
                "shop_id" : "1",
                "title" : "测试分类2",
                "orderby" : "2",
                "product_list" : [
                    {
                        "product_id":"1",
                        "title" : "测试商品标题1",
                        "price" : "100",
                        "photo" : "http://yun.ijh.cc/attachs/photo/124.png",
                        "code" : "12345678",
                        "stock" : "100",
                        "sales" : "10",
                        "orderby" : "10"
                    },
                    {
                        "product_id":"2",
                        "title" : "测试商品标题2",
                        "price" : "100",
                        "photo" : "http://yun.ijh.cc/attachs/photo/124.png",
                        "code" : "123456780",
                        "stock" : "100",
                        "sales" : "10",
                        "orderby" : "10"
                    }
                ]
            }
          ]
    }
}
```

<br />
************
######<a name="cashier/product/create">添加商品(cashier/product/create)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| cate_id | 是 | int |  分类ID  |
| title | 是 | string |  商品标题  |
| price | 是 | float |  商品价格  |
| stock | 是 | int |  商品库存  |
| orderby | 否 | int |  商品排序  |
| code | 否 | string |  商品条码 |
| photo | 是 | file |  商品图片文件流 |
>>请求示例
>
```javascript
{
    "cate_id" : "1",
    "title" : "测试商品1",
    "price" : "100",
    "stock" : "100",
    "orderby" : "10",
    "code" : "1234i494944",
}
```
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
          "product_id":"888"
    }
}
```


<br />
************
######<a name="cashier/product/edit">添加商品(cashier/product/edit)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| product_id | 是 | int |  商品ID  |
| cate_id | 是 | int |  分类ID  |
| title | 是 | string |  商品标题  |
| price | 是 | float |  商品价格  |
| stock | 是 | int |  商品库存  |
| orderby | 否 | int |  商品排序  |
| code | 否 | string |  商品条码 |
| photo | 是 | file |  商品图片文件流 |
>>请求示例
>
```javascript
{
	"product_id" : "1",
    "cate_id" : "1",
    "title" : "测试商品1",
    "price" : "100",
    "stock" : "100",
    "orderby" : "10",
    "code" : "1234i494944",
}
```
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
          "product_id":"888"
    }
}
```

<br />
************
######<a name="cashier/product/delete">删除商品(cashier/product/delete)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| product_id | 是 | int | 商品ID, 支持批量删除，ID以逗号隔开 |
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
######<a name="cashier/product/cate/items">分类列表(cashier/product/cate/items)</a>
>>请求示例(无)

>>返回示例
>
| 参数名称 | 类型 |描述 |
|--------|:-------:|------|
| cate_id | int |  商品分类  |
| title | string | 分类名 |
| shop_id | int |  商户ID  |
| orderby | int |  排序  |
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
          "items":
          [
            {
                "cate_id" : "1",
                "shop_id" : "1",
                "title" : "测试分类1",
                "orderby" : "1"
            },
            {
                "cate_id" : "2",
                "shop_id" : "1",
                "title" : "测试分类2",
                "orderby" : "2"
            }
          ]
    }
}
```

<br />
************
######<a name="cashier/product/cate/create">添加商品(cashier/product/cate/create)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| title | 是 | string |  商品标题  |
| orderby | 否 | int |  商品排序  |
>>请求示例
>
```javascript
{
    "title" : "测试分类1",
    "orderby" : "10"
}
```
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
          "cate_id":"1"
    }
}
```


<br />
************
######<a name="cashier/product/cate/edit">添加商品(cashier/product/cate/edit)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| cate_id | 是 | int |  分类ID  |
| title | 是 | string |  商品标题  |
| orderby | 否 | int |  商品排序  |
>>请求示例
>
```javascript
{
    "cate_id" : "1",
    "title" : "测试分类1",
    "orderby" : "10"
}
```
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
          "cate_id":"1"
    }
}
```

<br />
************
######<a name="cashier/product/cate/delete">删除分类(cashier/product/cate/delete)</a>
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
######<a name="cashier/order/items">订单列表(cashier/order/items)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| type | 否 | int | 类型 `cashier:收银订单, refund:退款订单, chongzhi:会员卡充值订单` |
| page | 否 | int | 分页码 |
>>请求示例
>
```javascript
{
	"type" : "cashier",
	"page":"1"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| order_id | int | 订单ID |
| city_id | int | 城市ID |
| shop_id | int | 商户ID |
| staff_id | int | 收银员ID |
| uid | int | 用户ID |
| money | float | 余额抵扣 |
| amount | float |订单实际金额 |  |
| order_youyi | float | 订单优惠 `youhui_amount+moling_amount` |
| order_status | int | 订单状态 `-1:已取消，0：未处理，8：订单完成` |
| order_status_label | string | 订单状态描述 |
| pay_status | int | 支付状态  `0:未支付, 1:已支付` |
| online_pay | int | 付款方式 `0:货到付款, 1:在线支付` |
| pay_code | string | 支付类型 `wxpay:微信, alipay:支付宝, money:余额,cash:现金` |
| pay_time | int | 支付时间UNIXTIME `当pay_status=1时有值` |
| trade_no | string | 支付流水号  |
| lasttime | int | 订单最后更新时间UNIXTIME |
| type | string | 订单类型 `cashier:收银, chongzhi:会员卡充值, refund:退款订单` |
| product_number | int | 商品数量 |
| product_price | float | 商品总价  |
| youhui_title | string | 优惠方案标题 |
| youhui_amount | float | 优惠金额  |
| moling_amount | float | 抹零金额  |
| staff | array | 收银员信息 [查看字典](#table.cashier_staff)|
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
                "shop_id" : "111",
                "uid" : "888",
				"staff_id" : "111",
				"from" : "cashier",
				"total_price" : "100",
				"order_youhui" : "10",
                "money" : "0",
                "amount" : "90",
                "order_status" : "8",
                "pay_status" : "1",
                'online_pay' : "1",
                "pay_code" : "wxpay",
				"trade_no" : "20193837737449",
                "pay_time" : "1400000011",
				"lasttime" : "1400000011",
				"dateline" : "1400000000",
				"type" : "cashier",
				"product_number" : "6",
                "product_price" : "100",
				"youhui_title" : "下单立减10元",
				"youhui_amount" : "10",
				"moling_amount" : "0",
				"shishou_amount" : "0",
				"zhaoling_amount" : "0",
                "staff" : {
                    "staff_id" : "111"，
                    "name" : "游医",
                    "mobile" : "1388888888",
                },
				"product_list" : [
					{
						"pid" : "11",
						"product_id" : "1",
						"product_title" : "测试商品1",
						"product_price" : "10",
						"product_number" : "5",
						"amount" : "50"
					},
					{
						"pid" : "12",
						"product_id" : "2",
						"product_title" : "测试商品2",
						"product_price" : "50",
						"product_number" : "1",
						"amount" : "50"
					},
				]
            },
        	{
                "order_id" : "2",
                "shop_id" : "111",
                "uid" : "888",
				"staff_id" : "111",
				"from" : "cashier",
				"total_price" : "100",
				"order_youhui" : "10",
                "money" : "0",
                "amount" : "90",
                "order_status" : "8",
                "pay_status" : "1",
                'online_pay' : "1",
                "pay_code" : "wxpay",
				"trade_no" : "20193837737449",
                "pay_time" : "1400000011",
				"lasttime" : "1400000011",
				"dateline" : "1400000000",
				"type" : "cashier",
				"product_number" : "6",
                "product_price" : "100",
				"youhui_title" : "下单立减10元",
				"youhui_amount" : "10",
				"moling_amount" : "0",
				"shishou_amount" : "0",
				"zhaoling_amount" : "0",
                "staff" : {
                    "staff_id" : "111"，
                    "name" : "游医",
                    "mobile" : "1388888888",
                },
				"product_list" : [
					{
						"pid" : "11",
						"product_id" : "1",
						"product_title" : "测试商品1",
						"product_price" : "10",
						"product_number" : "5",
						"amount" : "50"
					},
					{
						"pid" : "12",
						"product_id" : "2",
						"product_title" : "测试商品2",
						"product_price" : "50",
						"product_number" : "1",
						"amount" : "50"
					},
				]
            }
        ],
        "total_count" : "30"
    }
}
```

<br />
************
######<a name="cashier/order/detail">订单详情(cashier/order/detail)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| order_id | 是 | int | 订单号 |
>>请求示例
>
```javascript
{
	"order_id":"1"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| order_id | int | 订单ID |
| city_id | int | 城市ID |
| shop_id | int | 商户ID |
| staff_id | int | 收银员ID |
| uid | int | 用户ID |
| money | float | 余额抵扣 |
| amount | float |订单实际金额 |  |
| order_youyi | float | 订单优惠 `youhui_amount+moling_amount` |
| order_status | int | 订单状态 `-1:已取消，0：未处理，8：订单完成` |
| order_status_label | string | 订单状态描述 |
| pay_status | int | 支付状态  `0:未支付, 1:已支付` |
| online_pay | int | 付款方式 `0:货到付款, 1:在线支付` |
| pay_code | string | 支付类型 `wxpay:微信, alipay:支付宝, money:余额,cash:现金` |
| pay_time | int | 支付时间UNIXTIME `当pay_status=1时有值` |
| trade_no | string | 支付流水号  |
| lasttime | int | 订单最后更新时间UNIXTIME |
| type | string | 订单类型 `cashier:收银, chongzhi:会员卡充值, refund:退款订单` |
| product_number | int | 商品数量 |
| product_price | float | 商品总价  |
| youhui_title | string | 优惠方案标题 |
| youhui_amount | float | 优惠金额  |
| moling_amount | float | 抹零金额  |
| staff | array | 收银员信息 [查看字典](#table.cashier_staff)|
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    "data" : {
		"order_detail" : {
			"order_id" : "1",
			"shop_id" : "111",
			"uid" : "888",
			"staff_id" : "111",
			"from" : "cashier",
			"total_price" : "100",
			"order_youhui" : "10",
			"money" : "0",
			"amount" : "90",
			"order_status" : "8",
			"pay_status" : "1",
			'online_pay' : "1",
			"pay_code" : "wxpay",
			"trade_no" : "20193837737449",
			"pay_time" : "1400000011",
			"lasttime" : "1400000011",
			"dateline" : "1400000000",
			"type" : "cashier",
			"product_number" : "6",
			"product_price" : "100",
			"youhui_title" : "下单立减10元",
			"youhui_amount" : "10",
			"moling_amount" : "0",
			"shishou_amount" : "0",
			"zhaoling_amount" : "0",
			"staff" : {
				"staff_id" : "111"，
				"name" : "游医",
				"mobile" : "1388888888",
			},
			"product_list" : [
				{
					"pid" : "11",
					"product_id" : "1",
					"product_title" : "测试商品1",
					"product_price" : "10",
					"product_number" : "5",
					"amount" : "50"
				},
				{
					"pid" : "12",
					"product_id" : "2",
					"product_title" : "测试商品2",
					"product_price" : "50",
					"product_number" : "1",
					"amount" : "50"
				},
			]
		}
    }
}
```

<br />
************
######<a name="cashier/order/create">创建订单(cashier/order/create)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| cart | 是 | string |  订单商品 `商品ID:价格:数量,无码商品1:100:1`  |
| youhui | 否 | int |  整单立减  |
| discount | 否 | float | 整单折扣 |
| card_id | 否 | int |  会员卡ID  |
| is_card_discount | 否 | int |  使用会员卡折扣，当选了会员卡时可以勾选该项  |
| is_money | 否 | int |  使用余额，当选了会员卡时可以勾选该项  |
| order_id | 否 | int |  当传入了order_id 并且订单状态是未取消和未完成状态刚用新的信息更新订单信息 |
| coupon_number | 否 | string | 卡券15位密码 |
>>请求示例
>
```javascript
{
    "cart" : "1:100:3,无码商品101:800:1",
    "card_id" : "1",
	"youhui_id" : "1",
	"is_money" : "1",
    "order_id" : "2",
    "coupon_number" : "216120622960473"
}
```
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
          "order_id":"2",
		  "amount" : "720"
    }
}
```

<br />
************
######<a name="cashier/order/refund">订单退款(cashier/order/refund)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| order_id | 是 | int |  当传入了order_id |
| money | 是 | float |  退款金额 |
| is_refund_card | 是 | int |  1:退到会员卡余额，需要该订单card_id大于0时有效果, 0：原路退回 |
>>请求示例
>
```javascript
{
    "order_id" : "2",
    "money" : "100",
    "is_refund_card" : "1"
}
```
>>返回示例
>
| 参数名称 | 类型 |描述 |
|--------|:-------:|------|
| order_id | int |  订单ID  |
| log_id | int | 流水ID |
| refund_amount | int |  退回金额(现金、支付宝、微信)  |
| refund_card_money | int |  退回会员卡余额  |
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
          "order_id":"2",
          "log_id" : "22",
          "refund_amount" : "10",
          "refund_card_money" : "90"
    }
}
```

<br />
************
######<a name="cashier/order/printer">打印订单(cashier/order/printer)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| printer_id | 是 | int |  设备ID |
| order_id | 是 | int |  订单ID |
| num | 是 | int |  打印份数量, 1~9 |
>>请求示例
>
```javascript
{
	"printer_id" : "1",
    "order_id" : "2",
    "num" : "2"
}
```
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
          "order_id":"2"
     }
}
```

<br />
************
######<a name="cashier/order/cancel">订单取消(cashier/order/cancel)</a>
| 参数名称 | 是否必须 | 类型 | 描述 |
|--------|:-------:|------|------|
| order_id | 是 | int |  当传入了order_id |
>>请求示例
>
```javascript
{
    "order_id" : "2"
}
```
>>返回示例
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
          "order_id":"2"
    }
}
```


<br />
************
######<a name="cashier/order/log">资金流水(cashier/order/log)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| code | 否 | strinf | 付款 `money:会员卡余额, wxpay:微信支付, alipay:支付宝, cash:现金, refund:退款` |
| type | 否 | strinf | 类型 `order:订单, chongzhi:充值, refund:退款` |
| page | 否 | int | 页码 |
>>请求示例
>
```javascript
{
	"code":"cash",
    "page" : 1
}
```
>>返回示例
>
| 参数名称 | 类型 |描述 |
|--------|:-------:|------|
| log_id | int |  商品分类  |
| shop_id | int | 商户ID |
| staff_id | int |  收银员ID  |
| order_id | int |  订单ID  |
| card_id | int |  会员卡ID  |
| pay_code | string |  付款 `money:会员卡余额, wxpay:微信支付, alipay:支付宝, cash:现金, refund:退款`  |
| type | string |  类型 `order:订单, chongzhi:充值, refund:退款`  |
| amount | float |  金额  |
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
          "items":
          [
            {
                "log_id" : "1",
                "shop_id" : "1",
                "staff_id" : "1",
                "order_id" : "1",
                "card_id" : "1",
                "pay_code" : "cash",
                "type" : "order",
                "amount" : "100"
            },
            {
                "log_id" : "2",
                "shop_id" : "1",
                "staff_id" : "1",
                "order_id" : "1",
                "card_id" : "1",
                "pay_code" : "cash",
                "type" : "order",
                "amount" : "100"
            },
            {
                "log_id" : "3",
                "shop_id" : "1",
                "staff_id" : "1",
                "order_id" : "1",
                "card_id" : "1",
                "pay_code" : "cash",
                "type" : "order",
                "amount" : "100"
            }
          ]
    }
}
```

<br />
************
######<a name="cashier/order/tongji">订单统计(cashier/order/tongji)</a>
>>请求参数(无)
>>返回示例
>
| 参数名称 | 类型 |描述 |
|--------|:-------:|------|
| total_count | int |  总订单 (包括全部收款方式, 不包括退款） |
| today_count | int |  今天订单量，不包括退款|
| week_count | int |  最近7天订单量 ，不包括退款 |
| month_count | int | 最近30天订单量，不包括退款 |
| total_amount | float |  总订单收益(包括全部收款方式, 不包括退款)  |
| today_amount | float |  今天订单量，不包括退款  |
| week_amount | float |  最近7天订单量，不包括退款  |
| month_amount | float | 最近30天订单量，不包括退款 |
| items | array | 30天的记录 |
>
```javascript
{
  "error": "0",
  "message": "success",
  "data": {
    "items": [
      {
        "day": "20161008",
        "date": "2016-10-08",
        "count": "0"
      },
      {
        "day": "20161009",
        "date": "2016-10-09",
        "count": "0"
      }
    ],
    "total_count": "12",
    "today_count": "0",
    "week_count": "0",
    "total_amount": "568.05",
    "today_amount": "0",
    "month_count": "0"
  }
}
```



<br />
************
######<a name="cashier/payment/order">订单支付(cashier/payment/order)</a>
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

<br />
************
######<a name="cashier/payment/codepay">刷卡支付(cashier/payment/codepay)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| order_id | 是 | int |  订单ID |
| auth_code | 是 | int |  支付宝或微信支付码 |
| code | 是 | string |  支付接口 `alipay, wxpay |

>>请求示例
>
```javascript
{
    "order_id" : "123",
	"auth_code" : "289934848478448949904",
    "code" : "alipay"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| order_id | int | 订单号 |
| trade_no | int | 流水号 |
| amount | float | 支付金额 |
>
>>微信支付返回示例
>
```javascript
{
	"error" : "0",
    "message" : "success",
    "data" : {
		"trade_detail":{
			"order_id" : "1",
			"trade_no" : "2061111834848",
			"amount" : "100"
		}
    }
}
```

<br />
************
######<a name="cashier/payment/qrcodepay">扫码支付(cashier/payment/qrcodepay)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| order_id | 是 | int |  订单ID |
| code | 是 | string |  支付接口 `alipay, wxpay |

>>请求示例
>
```javascript
{
    "order_id" : "123",
    "code" : "wxpay"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| order_id | int | 订单号 |
| qrcode | string | 二维码 |
| trade_no | int | 流水号 |
| amount | float | 支付金额 |
>
>>微信支付返回示例
>
```javascript
{
	"error" : "0",
    "message" : "success",
    "data" : {
		"trade_detail":{
			"order_id" : "1",
			"qrcode" : "weixin://wxpay/bizpayurl?pr=kp1tGcG"
			"trade_no" : "2061111834848",
			"amount" : "100"
		}
    }
}
```

<br />
************
######<a name="cashier/payment/cashpay">扫码支付(cashier/payment/cashpay)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| order_id | 是 | int |  订单ID |
| shishou_amount | 是 | float |  实收金额 |

>>请求示例
>
```javascript
{
    "order_id" : "123",
	"shishou_amount" : "100"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| order_id | int | 订单号 |
| trade_no | int | 流水号 |
| amount | float | 支付金额 |
>
>>微信支付返回示例
>
```javascript
{
	"error" : "0",
    "message" : "success",
    "data" : {
		"trade_detail":{
			"order_id" : "1",
			"trade_no" : "2061111834848",
			"amount" : "100"
		}
    }
}
```

<br />
************
######<a name="cashier/card/items">会员卡管理(cashier/card/items)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| kw | 否 | int | 搜索：手机号/卡号/姓名(mobile/number/name) |
| month | 否 | int | 搜索：月份 |
| grade_id | 否 | int | 搜索：会员等级 |
| page | 否 | int | 页码 |

>>请求示例
>
```javascript
{
	"kw" : "111",
    "month" : "4",
    "grade_id" : "24",
    "page" : 1
}
```
>>返回示例
>
| 参数名称 | 类型 |描述 |
|--------|:-------:|------|
| card_id | int |  会员卡ID  |
| shop_id | int | 商户ID |
| uid_id | int |  用户ID  |
| grade_id | int |  等级ID  |
| mobile | string | 手机号  |
| name | string | 姓名 |
| sex | string | 性别 `0:未知, 1:男，2:女` |
| Y,M,D | int | 生日 `Y:年、M:月、D:日` |
| total_money | float |  消费金额  |
| money | float |  会员余额  |
| total_jifen | int |  总积分  |
| jifen | int |  会员积分  |
| grade_name | string |  等级  |
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
          "items":
          [
            {
                "card_id" : "1",
                "shop_id" : "1",
                "uid" : "1",
                "grade_id" : "1",
                "mobile" : "13888888888",
                "name" : "游医",
                "sex" : "1",
                "Y" : "2008",
                "M" : "8",
                "D" : "8",
				"total_money" : "19800",
				"money" : "10",
				"total_jifen" : "10000",
				"jifen" : "10000",
				"grade_name" : "钻石会员",
                "grade_detail" : {
                	"grade_id" : "1",
                    "title" : "钻石会员",
                    "icon" : "http://xxxx/1.png"
                    "discount" : "9.5"
                }
            },
            {
                "card_id" : "2",
                "shop_id" : "1",
                "uid" : "2",
                "grade_id" : "1",
                "mobile" : "13888888888",
                "name" : "游医",
                "sex" : "1",
                "Y" : "2008",
                "M" : "8",
                "D" : "8",
				"total_money" : "19800",
				"money" : "10",
				"total_jifen" : "10000",
				"jifen" : "10000",
				"grade_name" : "钻石会员",
                "grade_detail" : {
                	"grade_id" : "1",
                    "title" : "钻石会员",
                    "icon" : "http://xxxx/1.png"
                    "discount" : "9.5"
                }
            },
            {
                "card_id" : "3",
                "shop_id" : "1",
                "uid" : "3",
                "grade_id" : "1",
                "mobile" : "13888888888",
                "name" : "游医",
                "sex" : "1",
                "Y" : "2008",
                "M" : "8",
                "D" : "8",
				"total_money" : "19800",
				"money" : "10",
				"total_jifen" : "10000",
				"jifen" : "10000",
				"grade_name" : "钻石会员",
                "grade_detail" : {
                	"grade_id" : "1",
                    "title" : "钻石会员",
                    "icon" : "http://xxxx/1.png"
                    "discount" : "9.5"
                }
            }
		]
    }
}
```

<br />
************
######<a name="cashier/card/detail">会员卡管理(cashier/card/detail)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| card_id | 否 | int | 会员卡ID  `四选一参数` |
| number | 否 | int | 会员卡号 `四选一参数` |
| uid | 否 | int | 会员ID `四选一参数` |
| mobile | 否 | int | 手机号 `四选一参数` |
>>请求示例
>
```javascript
{
    "uid" : "1"
}
```
>>返回示例
>
| 参数名称 | 类型 |描述 |
|--------|:-------:|------|
| card_id | int |  会员卡ID  |
| shop_id | int | 商户ID |
| uid_id | int |  用户ID  |
| grade_id | int |  等级ID  |
| mobile | string | 手机号  |
| name | string | 姓名 |
| sex | string | 性别 `0:未知, 1:男，2:女` |
| Y,M,D | int | 生日 `Y:年、M:月、D:日` |
| total_money | float |  消费金额  |
| money | float |  会员余额  |
| total_jifen | int |  总积分  |
| jifen | int |  会员积分  |
| grade_name | string |  等级  |
| jifen_log | array | 积分日志 |
| money_log | array | 资金日志 |
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
          "card_detail": {
            "card_id" : "1",
            "shop_id" : "1",
            "uid" : "1",
            "grade_id" : "1",
            "mobile" : "13888888888",
            "name" : "游医",
            "sex" : "1",
            "Y" : "2008",
            "M" : "8",
            "D" : "8",
            "total_money" : "19800",
            "money" : "10",
            "total_jifen" : "10000",
            "jifen" : "10000",
            "grade_name" : "钻石会员",
            "grade_detail" : {
                "grade_id" : "1",
                "title" : "钻石会员",
                "icon" : "http://xxxx/1.png"
                "discount" : "9.5"
            }
            "jifen_log" : [
                {
                    "log_id" : "1",
                    "card_id" : "1",
                    "type" : "jifen",
                    "number" : "100",
                    "intro" : "赠送积分"
                },
                {
                    "log_id" : "2",
                    "card_id" : "1",
                    "type" : "jifen",
                    "number" : "100",
                    "intro" : "赠送积分"
                }
            ],
            "meney_log" : [
                {
                    "log_id" : "11",
                    "card_id" : "1",
                    "type" : "money",
                    "number" : "100",
                    "intro" : "充值金额"
                },
                {
                    "log_id" : "22",
                    "card_id" : "1",
                    "type" : "money",
                    "number" : "100",
                    "intro" : "充值金额"
                }
            ],
            "meney_log" : [
                {
                    "log_id" : "11",
                    "card_id" : "1",
                    "type" : "money",
                    "number" : "100",
                    "intro" : "充值金额"
                },
                {
                    "log_id" : "22",
                    "card_id" : "1",
                    "type" : "money",
                    "number" : "100",
                    "intro" : "充值金额"
                }
            ]
		}
    }
}
```


<br />
************
######<a name="cashier/card/create">扫码支付(cashier/card/create)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| name | 是 | string |  名字 |
| mobile | 是 | string |  手机号 |
| M | 是 | int |  生日 月 |
| D | 是 | int |  生日 日 |
| number | 否 | string |  卡号 不传该参数则系统自动生成，不可与已经存在的卡号重复|
>>请求示例
>
```javascript
{
    "name" : "张三",
	"mobile" : "13888888888",
    "M" : "8",
    "D" :"8",
    "number" : "112223344443333"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| card_id | int | 会员卡ID |
>
>>返回示例
>
```javascript
{
	"error" : "0",
    "message" : "success",
    "data" : {
    	"card_id" : "1"
    }
}
```

<br />
************
######<a name="cashier/card/edit">修改会员卡(cashier/card/edit)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| card_id | 是 | int | 会员卡ID |
| name | 否 | string |  名字 |
| mobile | 否 | string |  手机号 |
| M | 否 | int |  生日 月 |
| D | 否 | int |  生日 日 |
| number | 否 | string |  卡号 |
>>请求示例
>
```javascript
{
	"card_id" : "1",
    "name" : "张三",
	"mobile" : "13888888888",
    "M" : "8",
    "D" :"8",
    "number" : "112223344443333"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| card_id | int | 会员卡ID |
>
>>返回示例
>
```javascript
{
	"error" : "0",
    "message" : "success",
    "data" : {
    	"card_id" : "1"
    }
}
```

<br />
************
######<a name="cashier/money/log">资金日志(cashier/money/log)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| page | 否 | int |  页码 |
>>请求示例
>
```javascript
{
    "page" : "1"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| log_id | int | ID |
| shop_id | int | 商户ID |
| money | float | 变动金额 |
| intro | int | 描述 |
| dateline | int | UNIXTIME时间 |
>
>>返回示例
>
```javascript
{
	"error" : "0",
    "message" : "success",
    "data" : {
    	"items" : [
        	{
            	"log_id" : "1",
                "shop_id" : "1",
                "money" : "100",
                "intro" : "收款订单",
                "dateline" : "1400000000"
            },
        	{
            	"log_id" : "2",
                "shop_id" : "1",
                "money" : "-100",
                "intro" : "资金体现",
                "dateline" : "1400000000"
            }
        ]
    }
}
```

<br />
************
######<a name="cashier/money/txlog">提现日志(cashier/money/txlog)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| page | 否 | int |  页码 |
>>请求示例
>
```javascript
{
    "page" : "1"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| tixian_id | int | ID |
| shop_id | int | 商户ID |
| money | float | 申请提现金额 |
| end_money | float | 实际结算金额 |
| intro | int | 描述 |
| status | int | 申请状态 `0:待处理,1:通过,2:拒绝` |
| reason | string | 拒绝原因 |
| dateline | int | UNIXTIME时间 |
>
>>返回示例
>
```javascript
{
	"error" : "0",
    "message" : "success",
    "data" : {
    	"items" : [
        	{
            	"tixian_id" : "1",
                "shop_id" : "1",
                "money" : "100",
                "end_money" : "90",
                "intro" : "提现申请",
                "account_info" : "支付宝(游医,shzhrui@126.com)",
                "reason" : "",
                "status" : "0"
                "dateline" : "1400000000"
            },
        	{
            	"tixian_id" : "1",
                "shop_id" : "1",
                "money" : "100",
                "end_money" : "90",
                "intro" : "提现申请",
                "account_info" : "支付宝(游医,shzhrui@126.com)",
                "reason" : "",
                "status" : "0"
                "dateline" : "1400000000"
            }
        ]
    }
}
```

<br />
************
######<a name="cashier/money/info">账户信息(cashier/money/info)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| money | 是 | float |  提现金额 |
| passwd | 是 | float |  帐户密码 |
>>请求示例
>
```javascript
{
    "money" : "100",
    "passwd" : "123456"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| money | float | 余额 |
| tixian_percent | int | 提现比例 `百进制,1~100` |
>
>>返回示例
>
```javascript
{
	"error" : "0",
    "message" : "success",
    "data" : {
        "money" : "100",
        "tixian_percent" : "98",
        "bank" : {
        	"shop_id" : "1",
            "account_type" : "支付宝",
            "account_name" : "游医",
            "acount_number" : "shzhrui@126.com"
        }
    }
}
```

<br />
************
######<a name="cashier/money/tixian">提现申请(cashier/money/tixian)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| money | 是 | float |  提现金额 |
| passwd | 是 | float |  帐户密码 |
>>请求示例
>
```javascript
{
    "money" : "100",
    "passwd" : "123456"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| tixian_id | int | ID |
>
>>返回示例
>
```javascript
{
	"error" : "0",
    "message" : "success",
    "data" : {
        "tixian_id" : "1"
    }
}
```





<br />
************
######<a name="cashier/card/log">会员卡日志(cashier/card/log)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| card_id | int | 会员卡ID |
| type | 是 | string |  类型 `chongzhi:充值, order:消费, jifen:积分` |
| page | 否 | int |  页码 |
>>请求示例
>
```javascript
{
	"card_id" : "1"
	"type" : "money",
    "page" : "1"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| log_id | int | ID |
| card_id | int | 会员卡ID |
| type | int | 类型 `moeny:充值, order:消费, jifen:积分` |
| number | int | 变动值  |
| intro | int | 描述 |
| dateline | int | UNIXTIME时间 |
>
>>返回示例
>
```javascript
{
	"error" : "0",
    "message" : "success",
    "data" : {
    	"items" : [
        	{
            	"log_id" : "1",
                "card_id" : "1",
                "type" : "money",
                "number" : "100",
                "intro" : "会员充值",
                "dateline" : "1400000000"
            },
        	{
            	"log_id" : "1",
                "card_id" : "1",
                "type" : "money",
                "number" : "100",
                "intro" : "会员充值",
                "dateline" : "1400000000"
            }
        ]
    }
}
```

<br />
************
######<a name="cashier/card/czlog">会员卡充值记录(cashier/card/czlog)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| code | 否 | string |  支付方式 `cash:现金, wxpay:微信, alipay:支付宝, 不传表示全部` |
| page | 否 | int |  页码 |
>>请求示例
>
```javascript
{
	"type" : "cash",
    "page" : "1"
}
```
>>返回示例
>
| 参数名称 | 类型 |描述 |
|--------|:-------:|------|
| log_id | int |  商品分类  |
| shop_id | int | 商户ID |
| staff_id | int |  收银员ID  |
| order_id | int |  订单ID  |
| card_id | int |  会员卡ID  |
| pay_code | string |  付款 `money:会员卡余额, wxpay:微信支付, alipay:支付宝, cash:现金, refund:退款`  |
| type | string |  类型 `order:订单, chongzhi:充值, refund:退款`  |
| amount | float |  金额  |
| staff_detail | object | 收银员 |
| card_detail | object |  会员卡  |
>
```javascript
{
    'error':'0',
    'message':'success',
    'data':{
          "items":
          [
            {
                "log_id" : "1",
                "shop_id" : "1",
                "staff_id" : "1",
                "order_id" : "1",
                "card_id" : "1",
                "pay_code" : "cash",
                "type" : "order",
                "amount" : "100",
                "staff_detail" : {
                	"staff_id" : "1",
                    "name" : "张三",
                    "mobile" : "1388888888"
                },
                "card_detail" : {
                	"card_id" : "1",
                    "name" : "哎呀",
                    "number" : "12345678",
                    "mobile" : "139999999"
                }
            },
            {
                "log_id" : "2",
                "shop_id" : "1",
                "staff_id" : "1",
                "order_id" : "1",
                "card_id" : "1",
                "pay_code" : "cash",
                "type" : "order",
                "amount" : "100",
                "staff_detail" : {
                	"staff_id" : "1",
                    "name" : "张三",
                    "mobile" : "1388888888"
                },
                "card_detail" : {
                	"card_id" : "1",
                    "name" : "哎呀",
                    "number" : "12345678",
                    "mobile" : "139999999"
                }
            },
            {
                "log_id" : "3",
                "shop_id" : "1",
                "staff_id" : "1",
                "order_id" : "1",
                "card_id" : "1",
                "pay_code" : "cash",
                "type" : "order",
                "amount" : "100",
                "staff_detail" : {
                	"staff_id" : "1",
                    "name" : "张三",
                    "mobile" : "1388888888"
                },
                "card_detail" : {
                	"card_id" : "1",
                    "name" : "哎呀",
                    "number" : "12345678",
                    "mobile" : "139999999"
                }
            }
          ]
    }
}
```


<br />
************
######<a name="cashier/card/package">充值套餐(cashier/card/package)</a>
>>请求参数(无)
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| order_id | int | 充值的订单号 |
>
>>返回示例
>
```javascript
{
	"error" : "0",
    "message" : "success",
    "data" : {
        "package_data": [
          {
            "money": "100",
            "give": "10",
            "jifen": "100"
          },
          {
            "money": "200",
            "give": "20",
            "jifen": "200"
          },
          {
            "money": "500",
            "give": "50",
            "jifen": "600"
          },
          {
            "money": "1000",
            "give": "120",
            "jifen": "1200"
          }
        ]
    }
}
```

<br />
************
######<a name="cashier/card/chongzhi">充值会员卡(cashier/card/chongzhi)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| card_id | 是 | int | 会员卡ID |
| money | 是 | float | 充值金额 |
>>请求示例
>
```javascript
{
	"card_id" : "1",
    "money" : "100"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| order_id | int | 充值的订单号 |
>
>>返回示例
>
```javascript
{
	"error" : "0",
    "message" : "success",
    "data" : {
    	"order_id" : "11"
    }
}
```

<br />
************
######<a name="cashier/card/grade/items">会员卡等级(cashier/card/grade/items)</a>
>>请求参数(无)
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| grade_id | int | 会员等级ID |
| shop_id | int | 商户ID |
| title | int | 会员卡名称 |
| need_money | int | 需要消费金额 |
| discount | float | 会员卡折扣 |
>
>>返回示例
>
```javascript
{
	"error" : "0",
    "message" : "success",
    "data" : {
    	"items" : [
        	{
            	"grade_id" : "1",
                "title" : "普通会员",
                "need_money" : "0",
                "discount" : "9.8",
                "icon" : "http://xxx/photo/1.jpg",
            },
        	{
            	"grade_id" : "2",
                "title" : "钻石会员",
                "need_money" : "10000",
                "discount" : "9.8",
                "icon" : "http://xxx/photo/1.jpg",
            },
        	{
            	"grade_id" : "3",
                "title" : "皇冠会员",
                "need_money" : "20000",
                "discount" : "9.8",
                "icon" : "http://xxx/photo/1.jpg",
            }
        ]
    }
}
```

<br />
************
######<a name="cashier/card/grade/create">添加会员卡等级(cashier/card/grade/create)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| title | 是 | string | 名称 |
| need_money | 是 | int | 消费金额 |
| discount | 是 | float | 会员卡折扣 |
>>请求示例
>
```javascript
{
	"title" : "普通会员",
    "need_money" : "100",
    "discount" : "9.8"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| grade_id | int | 会员等级ID |
>
>>返回示例
>
```javascript
{
	"error" : "0",
    "message" : "success",
    "data" : {
    	"grade_id" : "11"
    }
}
```

<br />
************
######<a name="cashier/card/grade/edit">修改会员卡等级(cashier/card/grade/edit)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| grade_id | 是 | int | 等级ID |
| title | 是 | string | 名称 |
| need_money | 是 | int | 消费金额 |
| discount | 是 | float | 会员卡折扣 |
>>请求示例
>
```javascript
{
	"grade_id" : "1",
	"title" : "普通会员",
    "need_money" : "100"，
    "discount" : "9.8"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| grade_id | int | 会员等级ID |
>
>>返回示例
>
```javascript
{
	"error" : "0",
    "message" : "success",
    "data" : {
    	"grade_id" : "11"
    }
}
```

<br />
************
######<a name="cashier/card/grade/delete">删除会员卡等级(cashier/card/grade/delete)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| grade_id | 是 | int | 等级ID |
>>请求示例
>
```javascript
{
	"grade_id" : "1"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| grade_id | int | 会员等级ID |
>
>>返回示例
>
```javascript
{
	"error" : "0",
    "message" : "success",
    "data" : {
    	"grade_id" : "11"
    }
}
```



<br />
************
######<a name="cashier/jifen/product/items">积分商城商品(cashier/jifen/product/items)</a>
>>请求参数(无)
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| product_id | int | 商品ID |
| shop_id | int | 商品ID |
| title | string | 标题 |
| stock | int | 库存 |
| sales | int | 销量 |
| photo | string | 图片 |
>
>>返回示例
>
```javascript
{
	"error" : "0",
    "message" : "success",
    "data" : {
    	"items" : [
        	{
            	"product_id" : "1",
                "shop_id" : "1",
                "title" : "测试商品1",
                "jifen" : "10",
                "stock" : "100",
                "sales" : "10",
                "photo" : "http://xxx/photo/1.jpg",
            },
        	{
            	"product_id" : "2",
                "shop_id" : "1",
                "title" : "测试商品1",
                "jifen" : "10",
                "stock" : "100",
                "sales" : "10",
                "photo" : "http://xxx/photo/1.jpg",
            }
        ]
    }
}
```

<br />
************
######<a name="cashier/jifen/product/create">添加兑换记录(cashier/jifen/product/create)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| title | 是 | string | 名称 |
| jifen | 是 | int | 需要积分 |
| stock | 是 | int | 库存 |
| orderby | 是 | int | 排序 |
| photo | 是 | int | 图片 |
>>请求示例
>
```javascript
{
	"card_id" : "1",
	"title" : "普通会员",
    "jifen" : "100",
    "stock" : "100",
    "orderby" : "10",
    "photo" : "文件流"
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
	"error" : "0",
    "message" : "success",
    "data" : {
    	"product_id" : "11"
    }
}
```

<br />
************
######<a name="cashier/jifen/product/edit">修改积分商品(cashier/jifen/product/edit)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| product_id | 是 | int | 商品ID |
| title | 是 | string | 名称 |
| jifen | 是 | int | 需要积分 |
| stock | 是 | int | 库存 |
| orderby | 是 | int | 排序 |
| photo | 是 | int | 图片 |
>>请求示例
>
```javascript
{
	"card_id" : "1",
	"title" : "普通会员",
    "jifen" : "100",
    "stock" : "100",
    "orderby" : "10",
    "photo" : "文件流"
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
	"error" : "0",
    "message" : "success",
    "data" : {
    	"product_id" : "11"
    }
}
```

<br />
************
######<a name="cashier/jifen/product/delete">删除会员卡等级(cashier/jifen/product/delete)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| product_id | 是 | int | 商品ID |
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
>
>>返回示例
>
```javascript
{
	"error" : "0",
    "message" : "success",
    "data" : {
    	"product_id" : "11"
    }
}
```


<br />
************
######<a name="cashier/jifen/order/items">积分兑换订单(cashier/jifen/order/items)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| card_id | 是 | int |会员卡ID |
>>请求示例
>
```javascript
{
	"card_id" : "1"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| order_id | int | 订单ID |
| product_id | int | 商品ID |
| shop_id | int | 商户ID |
| card_id | int | 会员卡ID |
| product_title | string | 商品标题 |
| product_photo | int | 总消耗积分 |
| product_number | string | 商品图片 |
| product_jifen | int | 商品积分 |
| total_jifen | int | 总消耗积分 |
| order_status | int | 订单状态 `0:待领取,1:已经领取，-1:已取消` |
| dateline | int | 兑换时间 UNIXTIME |
>
>>返回示例
>
```javascript
{
	"error" : "0",
    "message" : "success",
    "data" : {
    	"items" : [
        	{
            	"order_id" : "1",
            	"product_id" : "1",
                "shop_id" : "1",
                "card_id" : "1",
                "product_title" : "测试商品1",
                "product_jifen" : "10",
                "product_number" : "1",
                "total_jifen" : "10",
                "order_status" : "0",
                "order_status_label" : "待领取"
            },
        	{
            	"order_id" : "1",
            	"product_id" : "1",
                "shop_id" : "1",
                "card_id" : "1",
                "product_title" : "测试商品1",
                "product_jifen" : "10",
                "product_number" : "1",
                "total_jifen" : "10",
                "order_status" : "0",
                "order_status_label" : "待领取"
            }
        ]
    }
}
```

<br />
************
######<a name="cashier/jifen/order/create">添加兑换记录(cashier/jifen/order/create)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| product_id | 是 | int | 商品ID |
| card_id | 是 | int | 会员卡ID |
| num | 是 | int | 兑换数量 |
| orderby | 是 | int | 排序 |
| photo | 是 | int | 图片 |
>>请求示例
>
```javascript
{
	"card_id" : "1",
	"product_id" : "1",
    "num" : "1"
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
	"error" : "0",
    "message" : "success",
    "data" : {
    	"order_id" : "11"
    }
}
```

<br />
************
######<a name="cashier/jifen/order/confirm">领取积分商品(cashier/jifen/order/confirm)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| order_id | 是 | int | 订单ID |
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
>
>>返回示例
>
```javascript
{
	"error" : "0",
    "message" : "success",
    "data" : {
    	"order_id" : "11"
    }
}
```

<br />
************
######<a name="cashier/jifen/order/cancel">取消积分订单(cashier/jifen/order/cancel)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| order_id | 是 | int | 订单ID |
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
>
>>返回示例
>
```javascript
{
	"error" : "0",
    "message" : "success",
    "data" : {
    	"order_id" : "11"
    }
}
```

<br />
************
######<a name="cashier/coupon/items">卡券列表(cashier/coupon/items)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| page | 否 | int | 页码 |
| coupon_status | 否 | int | 卡券状态（1:失效） |
>>请求示例
>
```javascript
{
	"page" : "1",
    "coupon_status" : "1"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| coupon_id | int | 卡券ID |
| shop_id | int | 关联商户ID |
| title | string | 名称 |
| amount | double | 面值 |
| min_price | double | 最低消费 |
| stime | int | 开始时间 |
| ltime | int | 结束时间 |
| stock | int | 卡券库存 |
| send_count | int | 已经发放数量 |
| used_count | int | 已经核销数量 |
| one_limit | int | 最多领取数量 0:不限制|
| intro | string | 使用说明 |
| dateline | int | 创建UNIXTIME |
| share_title | string | 分享标题 |
| share_photo | string | 分享显示图片 |
| share_url | string | 分享连接 |
| share_content | string | 分享的说明语 |
>
>>返回示例
>
```javascript
{暂无}
```

<br />
************
######<a name="cashier/coupon/detail">卡券详情(cashier/coupon/detail)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| coupon_id | 是 | int | 卡券ID |
>>请求示例
>
```javascript
{
    "coupon_id" : "1"
}
```
>>返回数据
>
| 参数名称 | 类型 |描述 |
|--------|:-------:|------|
| coupon_id | int | 卡券ID |
| shop_id | int | 关联商户ID |
| title | string | 名称 |
| amount | double | 面值 |
| min_price | double | 最低消费 |
| stime | int | 开始时间 |
| ltime | int | 结束时间 |
| stock | int | 卡券库存 |
| send_count | int | 已经发放数量 |
| used_count | int | 已经核销数量 |
| receive_count | int | 领取人数 |
| one_limit | int | 最多领取数量 0:不限制|
| intro | string | 使用说明 |
| dateline | int | 创建UNIXTIME |
| coupon_status | int | 0:可发放 1:已失效 |
| share_title | string | 分享标题 |
| share_photo | string | 分享显示图片 |
| share_url | string | 分享连接 |
| share_content | string | 分享的说明语 |
>
>>返回示例
>
```javascript
{暂无}
```

<br />
************
######<a name="cashier/coupon/create">添加卡券(cashier/coupon/create)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| title | 是 | string | 名称 |
| amount | 是 | double | 面值 |
| min_price | 否 | double | 最低消费 |
| stime | 是 | int | 开始时间 |
| ltime | 是 | int | 结束时间 |
| stock | 是 | int | 卡券库存 |
| one_limit | 否 | int | 最多领取数量 0:不限制 |
| intro | 否 | string | 使用说明 |
>>请求示例
>
```javascript
{
    "title" : "圣诞狂欢季",
    "amount" : "20",
    "min_price" : "500",
    "stime" : "1480645916",
    "ltime" : "1482681599",
    "stock" : "1225",
    "one_limit" : "3",
    "intro" : "每个用户最多可以领取5张"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| coupon_id | int | 卡券ID |
>
>>返回示例
>
```javascript
{
	"error" : "0",
    "message" : "success",
    "data" : {
    	"coupon_id" : "11"
    }
}
```

<br />
************
######<a name="cashier/coupon/edit">修改卡券(cashier/coupon/edit)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| coupon_id | 是 | int | 卡券ID |
| title | 是 | string | 名称 |
| amount | 是 | double | 面值 |
| min_price | 否 | double | 最低消费 |
| stime | 是 | int | 开始时间 |
| ltime | 是 | int | 结束时间 |
| stock | 是 | int | 卡券库存 |
| one_limit | 否 | int | 最多领取数量 0:不限制 |
| intro | 否 | string | 使用说明 |
>>请求示例
>
```javascript
{
	"coupon_id" : "11",
    "title" : "圣诞狂欢季",
    "amount" : "20",
    "min_price" : "500",
    "stime" : "1480645916",
    "ltime" : "1482681599",
    "stock" : "1225",
    "one_limit" : "3",
    "intro" : "每个用户最多可以领取5张"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| coupon_id | int | 卡券ID |
>
>>返回示例
>
```javascript
{
	"error" : "0",
    "message" : "success",
    "data" : {
    	"coupon_id" : "11"
    }
}
```

<br />
************
######<a name="cashier/coupon/closecoupon">使卡券失效（过期）(cashier/coupon/closecoupon)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| coupon_id | 是 | int | 卡券ID |
>>请求示例
>
```javascript
{
	"coupon_id" : "11"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| coupon_id | int | 卡券ID |
>
>>返回示例
>
```javascript
{
	"error" : "0",
    "message" : "success",
    "data" : {
    	"coupon_id" : "11"
    }
}
```

<br />
************
######<a name="cashier/coupon/sendcoupon">定向发放卡券(cashier/coupon/sendcoupon)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| coupon_id | 是 | int | 卡券ID |
| card_id | 否 | string | 会员卡ID (0/""/不传:全选发放；定向多选以逗号拼接ID，逗号不能结尾)|
| kw | 否 | string | 筛选条件：关键词（手机/卡号/会员名） |
| month | 否 | string | 筛选条件：月份 |
| grade_id | 否 | int | 筛选条件：会员等级 |
| filter_id | 否 | string | 反选会员卡ID（需要排除不发的会员卡ID，以逗号不能结尾的ID拼接） |
>>请求示例
>
```javascript
{
	"coupon_id" : 11,
    "card_id" : "",
    "kw" : "13888888888",
    "month" : "4",
    "grade_id" : 1,
    "filter_id" : "22,33",
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| send_count | string | 成功发放的卡券数（""表示没有发放成功） |
| receive_count | string | 成功领取卡券的人数（""表示没有发放成功） |
>
>>返回示例
>
```javascript
{
	"error" : "0",
    "message" : "success",
    "data" : {
    	"send_data" : {
        	"send_count" : "1",
            "receive_count" : "1"
        }
    }
}
```

<br />
************
######<a name="cashier/coupon/coupon/items">会员优惠券列表(cashier/coupon/coupon/items)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| card_id | 是 | int | 会员卡ID |
| page | 否 | int | 页码 |
| coupon_status | 否 | int | 卡券状态(1:失效) |
>>请求示例
>
```javascript
{
    "card_id" : "11",
    "page" : "1"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| shop_id | int | 关联商户ID |
| coupon_id | int | 卡券ID |
| number | string | 卡券密码 |
| wx_openid | int | 微信OPENID |
| card_id | int | 会员卡ID |
| dateline | int | 创建UNIXTIME |
| title | string | 名称 |
| amount | double | 面值 |
| min_price | double | 最低消费 |
| stime | int | 开始时间 |
| ltime | int | 结束时间 |
| intro | string | 使用说明 |
| title_count | int | 卡券张数 |
>
>>返回示例
>
```javascript
{暂无}
```

<br />
************
######<a name="cashier/coupon/coupon/search">会员优惠券列表(cashier/coupon/coupon/search)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| number | 是 | string | 卡券密码 |
>>请求示例
>
```javascript
{
    "number" : "216120622960473"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| shop_id | int | 关联商户ID |
| coupon_id | int | 卡券ID |
| number | string | 卡券密码 |
| wx_openid | int | 微信OPENID |
| card_id | int | 会员卡ID |
| dateline | int | 创建UNIXTIME |
| title | string | 名称 |
| amount | double | 面值 |
| min_price | double | 最低消费 |
| stime | int | 开始时间 |
| ltime | int | 结束时间 |
| intro | string | 使用说明 |
>
>>返回示例
>
```javascript
{暂无}
```

<br />
************
######<a name="cashier/product/barcode">商品条码查询(cashier/product/barcode)</a>
>>请求参数
>
| 参数名称 | 必须 |  类型 |描述 |
|--------|:-------:|:-------:|------|
| code | 是 | int | 商品条码 |
>>请求示例
>
```javascript
{
	"code" : "69019388"
}
```
>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| code | int | 商品条码 |
| price | varcgar | 商品价格 |
| goods_name | varchar | 商品名 |
| company_name | varchar | 生产厂商 |
| photo | varchar | 缩略图 |
>
>>返回示例
>
```javascript
{
	"error" : "0",
    "message" : "success",
    "data" : {
    	"code" : "69019388"
        "price":"3.00"
        "goods_names":"绿箭"
        "company_name":"绿箭集团"
        "photo":"brcode/201612/69019388.jpg"
    }
}
```
************
######<a name="data/cashieradv">APP广告(data/cashieradv)</a>
>
>
>
>

>>返回数据
>
| 参数名称 | 类型 | 描述 |
|--------|:-------:|------|
| banner | array |APP欢迎页广告|
| adv | array |	APP页面广告|
| title | varchar | 标题|
| link | varchar |链接 |
| thumb | varchar | 缩略图 |
>
>
>返回实例
```javascript
{
	"error" : "0",
    "message" : "success",
    "data" : {
    	   "banner":{
                        {	"items_id" :"519" 
              	         	"adv_id":"8"
                 	       "title":"app启动广告"
                	       "link":"http:www.baudu.com"
                	       "thumb":"photo/201612/20161208_2CB8805DA52521C50BE0F5211FC1795F.jpg"
                        }
      			   }
            "adv":{
                       {
                         "item_id": "517",
                         "adv_id": "9",
                         "title": "标题",
                         "link": "http://www.baidu.com",
                         "thumb": "photo/201612/20161208_0F3BF59CB3AE6147B6836B478C52798F.jpg"
                        },
                        {
                       "item_id": "516",
                       "adv_id": "9",
                       "title": "biaoti",
                       "link": "http://www.baidu.com",
                       "thumb": "photo/201612/20161208_EA5AC6A9E8A4A15AC8161A5AD1C4652B.jpg"
                       }
                   }
              }
}
```
*********


<br />




























<br /><br /><br /><br /><br /><br />
*************************************
###数据字典对照表

<br>
><a name="table.cashier_staff">收银员字典</a>
>
| 参数名称 | 类型 |描述 |
|--------|:-------:|------|
| staff_id | int |  收银员ID  |
| shop_id | int | 商户ID |
| is_owner | int |  是否店主 `1:店主, 0：电员`  |
| name | string |  昵称  |
| mobile | string | 手机号 |
| day_orders | int | 当班订单数量 |
| day_cash | float | 现金首款 |
| day_money | float | 会员卡余额收款 |
| day_alipay | float | 支付宝收款 |
| day_wxpay | float | 微信收款 |
| audit | int | 审核状态 `1:通过审核, 0:待审` |


<br>
><a name="table.shop">商户字典</a>
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



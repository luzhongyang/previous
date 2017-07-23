/* 微店js购物车*/

window.WDCart = function(shop_id){
    this.shop_id = shop_id;
    this.init();
}

//初始化购物车
WDCart.prototype.init = function(){
    this.cart_list = JSON.parse(localStorage["WDCart"] || '{}') || {};
    this.shop_cart = this.cart_list[this.shop_id] || {};   
}

//保存购物车信息
WDCart.prototype.save = function(){
    this.cart_list[this.shop_id] = this.shop_cart;
    localStorage['WDCart'] = JSON.stringify(this.cart_list);
    var cookie_cart = {};
    for(var sid in this.cart_list){
        var sp = [];
        if(typeof(this.cart_list[sid]) == 'object'){            
            for(var pid in this.cart_list[sid]){
                sp.push(pid+":"+this.cart_list[sid][pid]['num']+":"+this.cart_list[sid][pid]['status']);
            }
        }
        cookie_cart[sid] = sp.join(",");        
    }
    Cookie.set('WDCart', JSON.stringify(cookie_cart));
},

/* 增加
 * product,产品id及product_id
 * spec,规格id及spec_id,选填
 * info,要存放的数据,对象格式{'title':'','price':'',...}
 * 注意:请将商品数量自行更新
 */
WDCart.prototype.add = function(sku_id, num, info){
    if(this.shop_cart[sku_id]){
        this.shop_cart[sku_id]['num'] = parseInt(this.shop_cart[sku_id]['num'],  10) +   parseInt(num, 10);
    }else{
        this.shop_cart[sku_id] = info;
        this.shop_cart[sku_id]['sku_id'] = sku_id;
        this.shop_cart[sku_id]['num'] = parseInt(num, 10);
    }
    if(this.shop_cart[sku_id]['num'] > 99){
        this.shop_cart[sku_id]['num'] = 99;
    }else if(parseInt(this.shop_cart[sku_id]['sale_type'], 10) > 0){
        if(this.shop_cart[sku_id]['num'] > this.shop_cart[sku_id]['sale_sku']){
            setTimeout(function(){Widget.MsgBox.error('商品库存不足');},1500);
            this.shop_cart[sku_id]['num'] = this.shop_cart[sku_id]['sale_sku'];
        }
    }
    var product_list = {};
    for(var k in this.shop_cart){
        this.shop_cart[k]['num'] = parseInt(this.shop_cart[k]['num'], 10)
        if(this.shop_cart[k]['num'] > 0){
            product_list[k] = this.shop_cart[k];
        }
    }
    this.shop_cart = product_list;
    this.save();
}

// 根据sku_id移除单个商品
WDCart.prototype.remove = function (sku_id){
    var product_list = {};
    for(var k in this.shop_cart){
        this.shop_cart[k]['num'] = parseInt(this.shop_cart[k]['num'], 10)
        if(this.shop_cart[k]['num'] > 0 && k != sku_id){
            product_list[k] = this.shop_cart[k];
        }
    }
    this.shop_cart = product_list;
    this.save();      
}

// 清空购物车
WDCart.prototype.clear = function(){
    this.shop_cart = {};
    this.save();
}

/* 商品
 * sku_id
 */
WDCart.prototype.product = function(sku_id){
    return this.shop_cart[sku_id] || {};
}

/* 商品数量
 * sku_id
 */
WDCart.prototype.product_num = function(sku_id){
    if(typeof(this.shop_cart[sku_id]) == 'undefined'){
        return 0;
    }else{
        return this.shop_cart[sku_id]['num'] || 0;
    }
}

// 购物车商品列表
     
WDCart.prototype.product_list = function(){
    return this.shop_cart;
}

// 商品总数量
WDCart.prototype.total_count = function(){
    var count = 0;
    for(var i in this.shop_cart){
        count += parseInt(this.shop_cart[i]['num'] || 0, 10);
    }
    return count;
}

// 商品价格
WDCart.prototype.product_price = function(sku_id){
    if(typeof(this.shop_cart[sku_id]) == 'undefined'){
        return 0;
    }else{
        var num = parseInt(this.shop_cart[sku_id]['num'] || 0, 10);
        var price = parseFloat(this.shop_cart[sku_id]['price'], 10) * num;
        return price;
    }
}

// 商品总价
WDCart.prototype.total_price = function(){
    var price = 0;
    for(var i in this.shop_cart){
        var num = parseInt(this.shop_cart[i]['num'] || 0, 10);
        price += parseFloat(this.shop_cart[i]['price'], 10) * num;
    }
    return price;
}

// 改变商品结算状态
WDCart.prototype.set_status = function(sku_id,status) {
    if(typeof(this.shop_cart[sku_id]) == 'undefined'){
        return 0;
    }else{
        this.shop_cart[sku_id]['status'] = parseInt(status);
        this.save(); 
    }  
}


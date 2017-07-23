/* WEBCart PC网页端js购物车*/

window.WEBCart = function(shop_id){
    this.shop_id = shop_id;
    this.init();
}

//初始化购物车
WEBCart.prototype.init = function(){
    this.cart_list = JSON.parse(localStorage["WEBCart"] || '{}') || {};
    this.shop_cart = this.cart_list[this.shop_id] || {};   
}

//保存购物车信息
WEBCart.prototype.save = function(){
    this.cart_list[this.shop_id] = this.shop_cart;
    localStorage['WEBCart'] = JSON.stringify(this.cart_list);
    var cookie_cart = {};
    for(var sid in this.cart_list){
        var sp = [];
        if(typeof(this.cart_list[sid]) == 'object'){            
            for(var pid in this.cart_list[sid]){
                sp.push(pid+":"+this.cart_list[sid][pid]['num']);
            }
        }
        cookie_cart[sid] = sp.join(",");        
    }
    Cookie.set('WEBCart', JSON.stringify(cookie_cart));
},

/* 增加
 * product,产品id及product_id
 * spec,规格id及spec_id,选填
 * info,要存放的数据,对象格式{'title':'','price':'',...}
 * 注意:请将商品数量自行更新
 */
WEBCart.prototype.add = function(sku_id, num, info){
    if(this.shop_cart[sku_id]){
        this.shop_cart[sku_id]['num'] = parseInt(this.shop_cart[sku_id]['num'],  10) +   parseInt(num, 10);
    }else{
        this.shop_cart[sku_id] = info;
        this.shop_cart[sku_id]['sku_id'] = sku_id;
        this.shop_cart[sku_id]['num'] = parseInt(num, 10);
    }
    if(this.shop_cart[sku_id]['num'] > this.shop_cart[sku_id]['sale_sku']){
        this.shop_cart[sku_id]['num'] = this.shop_cart[sku_id]['sale_sku'];
        layer.msg('商品库存不足',{time: 1000});
        return false;
    }else {
        if(this.shop_cart[sku_id]['num'] > 99){
            this.shop_cart[sku_id]['num'] = 99;
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
}

WEBCart.prototype.remove = function (sku_id){
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

WEBCart.prototype.clear = function(){
    this.shop_cart = {};
    this.save();
}

/* 商品
 * sku_id
 */
WEBCart.prototype.product = function(sku_id){
    return this.shop_cart[sku_id] || {};
}

/* 商品数量
 * sku_id
 */
WEBCart.prototype.product_num = function(sku_id){
    if(typeof(this.shop_cart[sku_id]) == 'undefined'){
        return 0;
    }else{
        return this.shop_cart[sku_id]['num'] || 0;
    }
}

/** 
 * 购物车所有商品
 * shop_id，可选
 */    
WEBCart.prototype.product_list = function(){
    return this.shop_cart;
}

WEBCart.prototype.total_count = function(){
    var count = 0;
    for(var i in this.shop_cart){
        count += parseInt(this.shop_cart[i]['num'] || 0, 10);
    }
    return count;
}


WEBCart.prototype.total_price = function(){
    var price = 0;
    for(var i in this.shop_cart){
        var num = parseInt(this.shop_cart[i]['num'] || 0, 10);
        price += parseFloat(this.shop_cart[i]['price'], 10) * num;
    }
    return price;
}

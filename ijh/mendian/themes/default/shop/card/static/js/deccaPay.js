!
    function(t) {
        function e(i) {
            if (n[i]) return n[i].exports;
            var r = n[i] = {
                exports: {},
                id: i,
                loaded: !1
            };
            return t[i].call(r.exports, r, r.exports, e),
                r.loaded = !0,
                r.exports
        }
        var n = {};
        return e.m = t,
            e.c = n,
            e.p = "//b.yzcdn.cn/store/",
            e(0)
    } (function(t) {
        for (var e in t) if (Object.prototype.hasOwnProperty.call(t, e)) switch (typeof t[e]) {
            case "function":
                break;
            case "object":
                t[e] = function(e) {
                    var n = e.slice(1),
                        i = t[e[0]];
                    return function(t, e, r) {
                        i.apply(this, [t, e, r].concat(n))
                    }
                } (t[e]);
                break;
            default:
                t[e] = t[t[e]]
        }
        return t
    } ([function(t, e, n) {
        "use strict";
        function i(t) {
            return t && t.__esModule ? t: {
                "default": t
            }
        }
        n(1);
        var r = n(4),
            o = i(r);
        n(11),
            n(12);
        var a = n(13),
            s = i(a),
            c = n(15),
            u = {
                appId: "",
                timeStamp: "",
                nonceStr: "",
                "package": "",
                signType: "MD5",
                paySign: ""
            },
            l = window._global || {},
            f = l.business || {},
            h = f.payInfo || {},
            p = {
                wxpay: 12,
                alipay: 22
            },
            d = {
                wxpay: 13,
                alipay: 23
            },
            m = {
                wxpay: "WX",
                alipay: "ZFB"
            },
            y = 0,
            v = !1,
            g = "",
            b = orderInfo.roundedTo,
            w = {
                init: function() {
                    var t = this;
                    if (!b) {
                        var e = this.priceKeyboard = new o["default"]({
                            className: m[payType],
                            $trigger: $("#cashier-price"),
                            $container: $(".ui-keyboard"),
                            callbacks: {
                                ok: function() {
                                    t.checkPayVal()
                                },
                                preChange: function(t, e) {
                                    var n = e.toString().split("."),
                                        i = n[1] || "";
                                    var res = ! (i.length > 2) && (e > 19999999.99 ? (s["default"].show("支付金额不能超过199999.99"), !1) : void 0)
                                    if(typeof(res) == 'undefined'){
                                        var callback = window.deccaPay_callback_preChange || function(e){};
                                        callback(e);
                                    }
                                    return res;
                                },
                                show: function() {
                                    $("#js-cashier-cursor").css("display", "inline-block")
                                },
                                hide: function() {
                                    t.checkPayVal() ? $("#js-cashier-cursor").css("display", "none") : e.show()
                                }
                            }
                        });
                        e.show()
                    }
                    this.bindEvents()
                },
                btnPay: function(t) {
                    if (t = t || "loading", b) {
                        var e = $("#btn_pay");
                        switch (e.data("html") || e.data("html", e.html()), t) {
                            case "loading":
                                e.html("支付中...").prop("disabled", !0);
                                break;
                            case "reset":
                                e.html(e.data("html")).prop("disabled", !1)
                        }
                    } else switch (t) {
                        case "loading":
                            this.priceKeyboard.setPayStatus(2);
                            break;
                        case "reset":
                            this.priceKeyboard.setPayStatus(1)
                    }
                },
                getChannel: function(t, e) {
                    return e ? d[t] : p[t]
                },
                WXPay: function() {
                    var t = function() {
                        WeixinJSBridge.invoke("getBrandWCPayRequest", u,
                            function(t) {
                                "get_brand_wcpay_request:ok" === t.err_msg ? (s["default"].show("支付成功,正在跳转..."), window.location.href = "/wap/trade/payOk?bid=" + shopInfo.bid + "&shopId=" + shopInfo.shopId + "&orderNo=" + g) : s["default"].show(t.err._msg)
                            })
                    };
                    "undefined" == typeof WeixinJSBridge ? document.addEventListener ? document.addEventListener("WeixinJSBridgeReady", t, !1) : document.attachEvent && (document.attachEvent("WeixinJSBridgeReady", t), document.attachEvent("onWeixinJSBridgeReady", t)) : t()
                },
                prePay: function() {
                    if (v) return ! 1;
                    var t = this,
                        e = {
                            channel: t.getChannel(payType, b),
                            code: h.c,
                            type: 1
                        };
                    "wxpay" === payType && (e.openId = h.openid),
                        b ? (e.seq = h.seq, e.type = 2) : e.money = y;
                    var n = {
                        json: JSON.stringify([e])
                    };
                    v = !0
                    var total_price = e.money/100;
                    var callback = window.pay_callback || function(a){};
                    callback(payType);
                    return false;
                        t.btnPay("loading")
                       /* $.ajax({
                            url: $('#link').attr('data'),
                            type: "post",
                            data: params,
                            dataType: "json",
                            complete: function() {
                                v = !1,
                                    t.btnPay("reset")
                            },
                            success: function(ret) {
                                if(ret.error>0){
                                    Widget.MsgBox.error(ret.message);
                                }else{
                                    if(ret.data.amount>0){
                                        window.location.href = ret.data.payurl;
                                    } else {
                                        Widget.MsgBox.success('付款成功');
                                        window.location.href = ret.data.rebackurl
                                    }

                                }
                               
                            }
                        })*/
                },
                alipayFormSubmit: function(t) {
                    var e = t.submitUrl || t.submit_url,
                        n = t.submitData || t.submit_data;
                    if (!t || !e || !n) return s["default"].show("请求繁忙,请稍后"),
                        void this.priceKeyboard.setPayStatus(1);
                    e = e.replace(/\"/g, ""),
                        n = JSON.parse(n);
                    var i = $("#alipay_form");
                    i.attr("action", e);
                    for (var r in n) i.find("input[name=" + r + "]").val(n[r]);
                    document.forms.alipay_form.submit()
                },
                bindEvents: function() {
                    var t = this;
                    $(".cashier-field").click(function() {
                        t.priceKeyboard.show()
                    })
                },
                checkPayVal: function() {
                    var t = this;
                    if (b) return void t.prePay();
                    var e = $("#cashier-price").text();
                    return e ? e < .01 ? (s["default"].show("支付金额不能小于0.01元"), !1) : (y = (0, c.mul)(e, 100), t.prePay(), !0) : (s["default"].show("请输入正确金额"), !1)
                }
            };
        window.onload = function() {
            w.init();
        }
    },
        function(t, e) {},
        , ,
        function(t, e, n) {
            "use strict";
            Object.defineProperty(e, "__esModule", {
                value: !0
            }),
                n(5),
                n(11);
            var i = function(t) {
                t = t || {};
                var e = {
                    options: {
                        $trigger: null,
                        $container: null,
                        className: "WX",
                        payStatus: 1,
                        callbacks: {
                            show: null,
                            hide: null,
                            ok: null,
                            preChange: null
                        }
                    },
                    init: function() {
                        this.options = $.extend({},
                            this.options, t),
                            this.$trigger = this.options.$trigger,
                            this.$container = this.options.$container,
                            this.callbacks = this.options.callbacks,
                            this.rules = this.options.rules || /^\d*\.?\d*$/,
                            this.cacheValue = this.options.defaultValue || "",
                            this.payStatus = this.options.payStatus,
                            this.className = this.options.className,
                            this.$container.addClass(this.className || "WX"),
                            this.bindEvents()
                    },
                    setPayStatus: function(t) {
                        var e = this.$container.find(".js-ok");
                        this.payStatus = t,
                            2 == t ? e.removeClass("status-1").addClass("status-2") : e.removeClass("status-2").addClass("status-1")
                    },
                    bindEvents: function() {
                        var t = this;
                        this.$trigger.click(function() {
                            t.show()
                        }),
                            this.$container[0].addEventListener("touchstart",
                                function(t) {
                                    t.preventDefault(),
                                        t.stopPropagation()
                                }),
                            this.$container.delegate(".js-num", "touchstart", this.numberHandler.bind(this)),
                            this.$container.delegate(".js-ok", "touchstart", this.okHandler.bind(this)),
                            this.$container.delegate(".js-del", "touchstart", this.deleteHandler.bind(this)),
                            this.$container.delegate(".js-money", "touchstart", this.moneyHandler.bind(this))
                    },
                    numberHandler: function(t) {
                        if (1 == this.payStatus) {
                            var e = $(t.target).html(),
                                n = this;
                            if (this.rules.test(this.cacheValue + e)) {
                                if ("0" === this.cacheValue && "." !== e ? this.cacheValue = "": "" === this.cacheValue && "." === e && (this.cacheValue = "0"), this.callbacks.preChange && 0 == this.callbacks.preChange(this.cacheValue, this.cacheValue + e)) return;
                                this.cacheValue = this.cacheValue + e;
                                var i = n.isFormElements(n.$trigger[0]) ? "val": "html";

                                n.$trigger[i](n.cacheValue)
                            }
                        }
                    },
                    deleteHandler: function() {
                        if (1 == this.payStatus) {
                            var t = this.cacheValue.length - 1,
                                e = this;
                            this.cacheValue = this.cacheValue.substring(0, t);
                            var n = e.isFormElements(e.$trigger[0]) ? "val": "html";
                            e.$trigger[n](e.cacheValue);
                            var callback = window.deccaPay_callback_preChange || function(a){};
                            callback(e.cacheValue);
                        }
                    },
                    moneyHandler: function() {
                        if (1 == this.payStatus) {
                            var callback = window.pay_callback || function(a){};
                            callback('money');
                        }
                    },
                    isFormElements: function(t) {
                        if (!t) return ! 1;
                        var e = t.tagName.toLowerCase();
                        return ["input", "textarea", "select"].indexOf(e) > -1
                    },
                    okHandler: function() {
                        1 == this.payStatus && this.callbacks.ok && this.callbacks.ok()
                    },
                    show: function() {
                        this.$container.hasClass("on") || (this.$container.addClass("on"), this.callbacks.show && this.callbacks.show())
                    },
                    hide: function() {
                        this.$container.hasClass("on") && (this.$container.removeClass("on"), this.callbacks.show && this.callbacks.hide())
                    },
                    render: function() {}
                };
                return e.init(),
                    e
            };
            e["default"] = i
        },
        1, , , , , ,
        function(t, e) {
            var n = function() {
                function t(t) {
                    return null == t ? String(t) : B[W.call(t)] || "object"
                }
                function e(e) {
                    return "function" == t(e)
                }
                function n(t) {
                    return null != t && t == t.window
                }
                function i(t) {
                    return null != t && t.nodeType == t.DOCUMENT_NODE
                }
                function r(e) {
                    return "object" == t(e)
                }
                function o(t) {
                    return r(t) && !n(t) && Object.getPrototypeOf(t) == Object.prototype
                }
                function a(t) {
                    var e = !!t && "length" in t && t.length,
                        i = T.type(t);
                    return "function" != i && !n(t) && ("array" == i || 0 === e || "number" == typeof e && e > 0 && e - 1 in t)
                }
                function s(t) {
                    return _.call(t,
                        function(t) {
                            return null != t
                        })
                }
                function c(t) {
                    return t.length > 0 ? T.fn.concat.apply([], t) : t
                }
                function u(t) {
                    return t.replace(/::/g, "/").replace(/([A-Z]+)([A-Z][a-z])/g, "$1_$2").replace(/([a-z\d])([A-Z])/g, "$1_$2").replace(/_/g, "-").toLowerCase()
                }
                function l(t) {
                    return t in O ? O[t] : O[t] = new RegExp("(^|\\s)" + t + "(\\s|$)")
                }
                function f(t, e) {
                    return "number" != typeof e || M[u(t)] ? e: e + "px"
                }
                function h(t) {
                    var e, n;
                    return N[t] || (e = k.createElement(t), k.body.appendChild(e), n = getComputedStyle(e, "").getPropertyValue("display"), e.parentNode.removeChild(e), "none" == n && (n = "block"), N[t] = n),
                        N[t]
                }
                function p(t) {
                    return "children" in t ? $.call(t.children) : T.map(t.childNodes,
                        function(t) {
                            if (1 == t.nodeType) return t
                        })
                }
                function d(t, e, n) {
                    for (E in e) n && (o(e[E]) || G(e[E])) ? (o(e[E]) && !o(t[E]) && (t[E] = {}), G(e[E]) && !G(t[E]) && (t[E] = []), d(t[E], e[E], n)) : e[E] !== x && (t[E] = e[E])
                }
                function m(t, e) {
                    return null == e ? T(t) : T(t).filter(e)
                }
                function y(t, n, i, r) {
                    return e(n) ? n.call(t, i, r) : n
                }
                function v(t, e, n) {
                    null == n ? t.removeAttribute(e) : t.setAttribute(e, n)
                }
                function g(t, e) {
                    var n = t.className || "",
                        i = n && n.baseVal !== x;
                    return e === x ? i ? n.baseVal: n: void(i ? n.baseVal = e: t.className = e)
                }
                function b(t) {
                    try {
                        return t ? "true" == t || "false" != t && ("null" == t ? null: +t + "" == t ? +t: /^[\[\{]/.test(t) ? T.parseJSON(t) : t) : t
                    } catch(e) {
                        return t
                    }
                }
                function w(t, e) {
                    e(t);
                    for (var n = 0,
                             i = t.childNodes.length; n < i; n++) w(t.childNodes[n], e)
                }
                var x, E, T, S, P, j, C = [],
                    $ = C.slice,
                    _ = C.filter,
                    k = window.document,
                    N = {},
                    O = {},
                    M = {
                        "column-count": 1,
                        columns: 1,
                        "font-weight": 1,
                        "line-height": 1,
                        opacity: 1,
                        "z-index": 1,
                        zoom: 1
                    },
                    L = /^\s*<(\w+|!)[^>]*>/,
                    D = /^<(\w+)\s*\/?>(?:<\/\1>|)$/,
                    A = /<(?!area|br|col|embed|hr|img|input|link|meta|param)(([\w:]+)[^>]*)\/>/gi,
                    V = /^(?:body|html)$/i,
                    R = /([A-Z])/g,
                    z = ["val", "css", "html", "text", "data", "width", "height", "offset"],
                    I = ["after", "prepend", "before", "append"],
                    F = k.createElement("table"),
                    H = k.createElement("tr"),
                    Z = {
                        tr: k.createElement("tbody"),
                        tbody: F,
                        thead: F,
                        tfoot: F,
                        td: H,
                        th: H,
                        "*": k.createElement("div")
                    },
                    q = /complete|loaded|interactive/,
                    X = /^[\w-]*$/,
                    B = {},
                    W = B.toString,
                    J = {},
                    U = k.createElement("div"),
                    Y = {
                        tabindex: "tabIndex",
                        readonly: "readOnly",
                        "for": "htmlFor",
                        "class": "className",
                        maxlength: "maxLength",
                        cellspacing: "cellSpacing",
                        cellpadding: "cellPadding",
                        rowspan: "rowSpan",
                        colspan: "colSpan",
                        usemap: "useMap",
                        frameborder: "frameBorder",
                        contenteditable: "contentEditable"
                    },
                    G = Array.isArray ||
                        function(t) {
                            return t instanceof Array
                        };
                return J.matches = function(t, e) {
                    if (!e || !t || 1 !== t.nodeType) return ! 1;
                    var n = t.matches || t.webkitMatchesSelector || t.mozMatchesSelector || t.oMatchesSelector || t.matchesSelector;
                    if (n) return n.call(t, e);
                    var i, r = t.parentNode,
                        o = !r;
                    return o && (r = U).appendChild(t),
                        i = ~J.qsa(r, e).indexOf(t),
                    o && U.removeChild(t),
                        i
                },
                    P = function(t) {
                        return t.replace(/-+(.)?/g,
                            function(t, e) {
                                return e ? e.toUpperCase() : ""
                            })
                    },
                    j = function(t) {
                        return _.call(t,
                            function(e, n) {
                                return t.indexOf(e) == n
                            })
                    },
                    J.fragment = function(t, e, n) {
                        var i, r, a;
                        return D.test(t) && (i = T(k.createElement(RegExp.$1))),
                        i || (t.replace && (t = t.replace(A, "<$1></$2>")), e === x && (e = L.test(t) && RegExp.$1), e in Z || (e = "*"), a = Z[e], a.innerHTML = "" + t, i = T.each($.call(a.childNodes),
                            function() {
                                a.removeChild(this)
                            })),
                        o(n) && (r = T(i), T.each(n,
                            function(t, e) {
                                z.indexOf(t) > -1 ? r[t](e) : r.attr(t, e)
                            })),
                            i
                    },
                    J.Z = function(t, e) {
                        return t = t || [],
                            t.__proto__ = T.fn,
                            t.selector = e || "",
                            t
                    },
                    J.isZ = function(t) {
                        return t instanceof J.Z
                    },
                    J.init = function(t, n) {
                        var i;
                        if (!t) return J.Z();
                        if ("string" == typeof t) if (t = t.trim(), "<" == t[0] && L.test(t)) i = J.fragment(t, RegExp.$1, n),
                            t = null;
                        else {
                            if (n !== x) return T(n).find(t);
                            i = J.qsa(k, t)
                        } else {
                            if (e(t)) return T(k).ready(t);
                            if (J.isZ(t)) return t;
                            if (G(t)) i = s(t);
                            else if (r(t)) i = [t],
                                t = null;
                            else if (L.test(t)) i = J.fragment(t.trim(), RegExp.$1, n),
                                t = null;
                            else {
                                if (n !== x) return T(n).find(t);
                                i = J.qsa(k, t)
                            }
                        }
                        return J.Z(i, t)
                    },
                    T = function(t, e) {
                        return J.init(t, e)
                    },
                    T.extend = function(t) {
                        var e, n = $.call(arguments, 1);
                        return "boolean" == typeof t && (e = t, t = n.shift()),
                            n.forEach(function(n) {
                                d(t, n, e)
                            }),
                            t
                    },
                    J.qsa = function(t, e) {
                        var n, r = "#" == e[0],
                            o = !r && "." == e[0],
                            a = r || o ? e.slice(1) : e,
                            s = X.test(a);
                        return i(t) && s && r ? (n = t.getElementById(a)) ? [n] : [] : 1 !== t.nodeType && 9 !== t.nodeType ? [] : $.call(s && !r ? o ? t.getElementsByClassName(a) : t.getElementsByTagName(e) : t.querySelectorAll(e))
                    },
                    T.contains = k.documentElement.contains ?
                        function(t, e) {
                            return t !== e && t.contains(e)
                        }: function(t, e) {
                        for (; e && (e = e.parentNode);) if (e === t) return ! 0;
                        return ! 1
                    },
                    T.type = t,
                    T.isFunction = e,
                    T.isWindow = n,
                    T.isArray = G,
                    T.isPlainObject = o,
                    T.isEmptyObject = function(t) {
                        var e;
                        for (e in t) return ! 1;
                        return ! 0
                    },
                    T.inArray = function(t, e, n) {
                        return C.indexOf.call(e, t, n)
                    },
                    T.camelCase = P,
                    T.trim = function(t) {
                        return null == t ? "": String.prototype.trim.call(t)
                    },
                    T.uuid = 0,
                    T.support = {},
                    T.expr = {},
                    T.map = function(t, e) {
                        var n, i, r, o = [];
                        if (a(t)) for (i = 0; i < t.length; i++) n = e(t[i], i),
                        null != n && o.push(n);
                        else for (r in t) n = e(t[r], r),
                        null != n && o.push(n);
                        return c(o)
                    },
                    T.each = function(t, e) {
                        var n, i;
                        if (a(t)) {
                            for (n = 0; n < t.length; n++) if (e.call(t[n], n, t[n]) === !1) return t
                        } else for (i in t) if (e.call(t[i], i, t[i]) === !1) return t;
                        return t
                    },
                    T.grep = function(t, e) {
                        return _.call(t, e)
                    },
                window.JSON && (T.parseJSON = JSON.parse),
                    T.each("Boolean Number String Function Array Date RegExp Object Error".split(" "),
                        function(t, e) {
                            B["[object " + e + "]"] = e.toLowerCase()
                        }),
                    T.fn = {
                        forEach: C.forEach,
                        reduce: C.reduce,
                        push: C.push,
                        sort: C.sort,
                        indexOf: C.indexOf,
                        concat: C.concat,
                        map: function(t) {
                            return T(T.map(this,
                                function(e, n) {
                                    return t.call(e, n, e)
                                }))
                        },
                        slice: function() {
                            return T($.apply(this, arguments))
                        },
                        ready: function(t) {
                            return q.test(k.readyState) && k.body ? t(T) : k.addEventListener("DOMContentLoaded",
                                function() {
                                    t(T)
                                },
                                !1),
                                this
                        },
                        get: function(t) {
                            return t === x ? $.call(this) : this[t >= 0 ? t: t + this.length]
                        },
                        toArray: function() {
                            return this.get()
                        },
                        size: function() {
                            return this.length
                        },
                        remove: function() {
                            return this.each(function() {
                                null != this.parentNode && this.parentNode.removeChild(this)
                            })
                        },
                        each: function(t) {
                            return C.every.call(this,
                                function(e, n) {
                                    return t.call(e, n, e) !== !1
                                }),
                                this
                        },
                        filter: function(t) {
                            return e(t) ? this.not(this.not(t)) : T(_.call(this,
                                function(e) {
                                    return J.matches(e, t)
                                }))
                        },
                        add: function(t, e) {
                            return T(j(this.concat(T(t, e))))
                        },
                        is: function(t) {
                            return this.length > 0 && J.matches(this[0], t)
                        },
                        not: function(t) {
                            var n = [];
                            if (e(t) && t.call !== x) this.each(function(e) {
                                t.call(this, e) || n.push(this)
                            });
                            else {
                                var i = "string" == typeof t ? this.filter(t) : a(t) && e(t.item) ? $.call(t) : T(t);
                                this.forEach(function(t) {
                                    i.indexOf(t) < 0 && n.push(t)
                                })
                            }
                            return T(n)
                        },
                        has: function(t) {
                            return this.filter(function() {
                                return r(t) ? T.contains(this, t) : T(this).find(t).size()
                            })
                        },
                        eq: function(t) {
                            return t === -1 ? this.slice(t) : this.slice(t, +t + 1)
                        },
                        first: function() {
                            var t = this[0];
                            return t && !r(t) ? t: T(t)
                        },
                        last: function() {
                            var t = this[this.length - 1];
                            return t && !r(t) ? t: T(t)
                        },
                        find: function(t) {
                            var e, n = this;
                            return e = t ? "object" == typeof t ? T(t).filter(function() {
                                var t = this;
                                return C.some.call(n,
                                    function(e) {
                                        return T.contains(e, t)
                                    })
                            }) : 1 == this.length ? T(J.qsa(this[0], t)) : this.map(function() {
                                return J.qsa(this, t)
                            }) : T()
                        },
                        closest: function(t, e) {
                            var n = [],
                                r = "object" == typeof t && T(t);
                            return this.each(function(o, a) {
                                for (; a && !(r ? r.indexOf(a) >= 0 : J.matches(a, t));) a = a !== e && !i(a) && a.parentNode;
                                a && n.indexOf(a) < 0 && n.push(a)
                            }),
                                T(n)
                        },
                        parents: function(t) {
                            for (var e = [], n = this; n.length > 0;) n = T.map(n,
                                function(t) {
                                    if ((t = t.parentNode) && !i(t) && e.indexOf(t) < 0) return e.push(t),
                                        t
                                });
                            return m(e, t)
                        },
                        parent: function(t) {
                            return m(j(this.pluck("parentNode")), t)
                        },
                        children: function(t) {
                            return m(this.map(function() {
                                return p(this)
                            }), t)
                        },
                        contents: function() {
                            return this.map(function() {
                                return $.call(this.childNodes)
                            })
                        },
                        siblings: function(t) {
                            return m(this.map(function(t, e) {
                                return _.call(p(e.parentNode),
                                    function(t) {
                                        return t !== e
                                    })
                            }), t)
                        },
                        empty: function() {
                            return this.each(function() {
                                this.innerHTML = ""
                            })
                        },
                        pluck: function(t) {
                            return T.map(this,
                                function(e) {
                                    return e[t]
                                })
                        },
                        show: function() {
                            return this.each(function() {
                                "none" == this.style.display && (this.style.display = ""),
                                "none" == getComputedStyle(this, "").getPropertyValue("display") && (this.style.display = h(this.nodeName))
                            })
                        },
                        replaceWith: function(t) {
                            return this.before(t).remove()
                        },
                        wrap: function(t) {
                            var n = e(t);
                            if (this[0] && !n) var i = T(t).get(0),
                                r = i.parentNode || this.length > 1;
                            return this.each(function(e) {
                                T(this).wrapAll(n ? t.call(this, e) : r ? i.cloneNode(!0) : i)
                            })
                        },
                        wrapAll: function(t) {
                            if (this[0]) {
                                T(this[0]).before(t = T(t));
                                for (var e; (e = t.children()).length;) t = e.first();
                                T(t).append(this)
                            }
                            return this
                        },
                        wrapInner: function(t) {
                            var n = e(t);
                            return this.each(function(e) {
                                var i = T(this),
                                    r = i.contents(),
                                    o = n ? t.call(this, e) : t;
                                r.length ? r.wrapAll(o) : i.append(o)
                            })
                        },
                        unwrap: function() {
                            return this.parent().each(function() {
                                T(this).replaceWith(T(this).children())
                            }),
                                this
                        },
                        clone: function() {
                            return this.map(function() {
                                return this.cloneNode(!0)
                            })
                        },
                        hide: function() {
                            return this.css("display", "none")
                        },
                        toggle: function(t) {
                            return this.each(function() {
                                var e = T(this); (t === x ? "none" == e.css("display") : t) ? e.show() : e.hide()
                            })
                        },
                        prev: function(t) {
                            return T(this.pluck("previousElementSibling")).filter(t || "*")
                        },
                        next: function(t) {
                            return T(this.pluck("nextElementSibling")).filter(t || "*")
                        },
                        html: function(t) {
                            return 0 in arguments ? this.each(function(e) {
                                var n = this.innerHTML;
                                T(this).empty().append(y(this, t, e, n))
                            }) : 0 in this ? this[0].innerHTML: null
                        },
                        text: function(t) {
                            return 0 in arguments ? this.each(function(e) {
                                var n = y(this, t, e, this.textContent);
                                this.textContent = null == n ? "": "" + n
                            }) : 0 in this ? this.pluck("textContent").join("") : null
                        },
                        attr: function(t, e) {
                            var n;
                            return "string" != typeof t || 1 in arguments ? this.each(function(n) {
                                if (1 === this.nodeType) if (r(t)) for (E in t) v(this, E, t[E]);
                                else v(this, t, y(this, e, n, this.getAttribute(t)))
                            }) : this.length && 1 === this[0].nodeType ? !(n = this[0].getAttribute(t)) && t in this[0] ? this[0][t] : n: x
                        },
                        removeAttr: function(t) {
                            return this.each(function() {
                                1 === this.nodeType && t.split(" ").forEach(function(t) {
                                        v(this, t)
                                    },
                                    this)
                            })
                        },
                        prop: function(t, e) {
                            return t = Y[t] || t,
                                1 in arguments ? this.each(function(n) {
                                    this[t] = y(this, e, n, this[t])
                                }) : this[0] && this[0][t]
                        },
                        data: function(t, e) {
                            var n = "data-" + t.replace(R, "-$1").toLowerCase(),
                                i = 1 in arguments ? this.attr(n, e) : this.attr(n);
                            return null !== i ? b(i) : x
                        },
                        val: function(t) {
                            return 0 in arguments ? (null == t && (t = ""), this.each(function(e) {
                                this.value = y(this, t, e, this.value)
                            })) : this[0] && (this[0].multiple ? T(this[0]).find("option").filter(function() {
                                return this.selected
                            }).pluck("value") : this[0].value)
                        },
                        offset: function(t) {
                            if (t) return this.each(function(e) {
                                var n = T(this),
                                    i = y(this, t, e, n.offset()),
                                    r = n.offsetParent().offset(),
                                    o = {
                                        top: i.top - r.top,
                                        left: i.left - r.left
                                    };
                                "static" == n.css("position") && (o.position = "relative"),
                                    n.css(o)
                            });
                            if (!this.length) return null;
                            if (k.documentElement !== this[0] && !T.contains(k.documentElement, this[0])) return {
                                top: 0,
                                left: 0
                            };
                            var e = this[0].getBoundingClientRect();
                            return {
                                left: e.left + window.pageXOffset,
                                top: e.top + window.pageYOffset,
                                width: Math.round(e.width),
                                height: Math.round(e.height)
                            }
                        },
                        css: function(e, n) {
                            if (arguments.length < 2) {
                                var i = this[0];
                                if ("string" == typeof e) {
                                    if (!i) return;
                                    return i.style[P(e)] || getComputedStyle(i, "").getPropertyValue(e)
                                }
                                if (G(e)) {
                                    if (!i) return;
                                    var r = {},
                                        o = getComputedStyle(i, "");
                                    return T.each(e,
                                        function(t, e) {
                                            r[e] = i.style[P(e)] || o.getPropertyValue(e)
                                        }),
                                        r
                                }
                            }
                            var a = "";
                            if ("string" == t(e)) n || 0 === n ? a = u(e) + ":" + f(e, n) : this.each(function() {
                                this.style.removeProperty(u(e))
                            });
                            else for (E in e) e[E] || 0 === e[E] ? a += u(E) + ":" + f(E, e[E]) + ";": this.each(function() {
                                this.style.removeProperty(u(E))
                            });
                            return this.each(function() {
                                this.style.cssText += ";" + a
                            })
                        },
                        index: function(t) {
                            return t ? this.indexOf(T(t)[0]) : this.parent().children().indexOf(this[0])
                        },
                        hasClass: function(t) {
                            return !! t && C.some.call(this,
                                    function(t) {
                                        return this.test(g(t))
                                    },
                                    l(t))
                        },
                        addClass: function(t) {
                            return t ? this.each(function(e) {
                                if ("className" in this) {
                                    S = [];
                                    var n = g(this),
                                        i = y(this, t, e, n);
                                    i.split(/\s+/g).forEach(function(t) {
                                            T(this).hasClass(t) || S.push(t)
                                        },
                                        this),
                                    S.length && g(this, n + (n ? " ": "") + S.join(" "))
                                }
                            }) : this
                        },
                        removeClass: function(t) {
                            return this.each(function(e) {
                                if ("className" in this) {
                                    if (t === x) return g(this, "");
                                    S = g(this),
                                        y(this, t, e, S).split(/\s+/g).forEach(function(t) {
                                            S = S.replace(l(t), " ")
                                        }),
                                        g(this, S.trim())
                                }
                            })
                        },
                        toggleClass: function(t, e) {
                            return t ? this.each(function(n) {
                                var i = T(this),
                                    r = y(this, t, n, g(this));
                                r.split(/\s+/g).forEach(function(t) { (e === x ? !i.hasClass(t) : e) ? i.addClass(t) : i.removeClass(t)
                                })
                            }) : this
                        },
                        scrollTop: function(t) {
                            if (this.length) {
                                var e = "scrollTop" in this[0];
                                return t === x ? e ? this[0].scrollTop: this[0].pageYOffset: this.each(e ?
                                    function() {
                                        this.scrollTop = t
                                    }: function() {
                                    this.scrollTo(this.scrollX, t)
                                })
                            }
                        },
                        scrollLeft: function(t) {
                            if (this.length) {
                                var e = "scrollLeft" in this[0];
                                return t === x ? e ? this[0].scrollLeft: this[0].pageXOffset: this.each(e ?
                                    function() {
                                        this.scrollLeft = t
                                    }: function() {
                                    this.scrollTo(t, this.scrollY)
                                })
                            }
                        },
                        position: function() {
                            if (this.length) {
                                var t = this[0],
                                    e = this.offsetParent(),
                                    n = this.offset(),
                                    i = V.test(e[0].nodeName) ? {
                                        top: 0,
                                        left: 0
                                    }: e.offset();
                                return n.top -= parseFloat(T(t).css("margin-top")) || 0,
                                    n.left -= parseFloat(T(t).css("margin-left")) || 0,
                                    i.top += parseFloat(T(e[0]).css("border-top-width")) || 0,
                                    i.left += parseFloat(T(e[0]).css("border-left-width")) || 0,
                                {
                                    top: n.top - i.top,
                                    left: n.left - i.left
                                }
                            }
                        },
                        offsetParent: function() {
                            return this.map(function() {
                                for (var t = this.offsetParent || k.body; t && !V.test(t.nodeName) && "static" == T(t).css("position");) t = t.offsetParent;
                                return t
                            })
                        }
                    },
                    T.fn.detach = T.fn.remove,
                    ["width", "height"].forEach(function(t) {
                        var e = t.replace(/./,
                            function(t) {
                                return t[0].toUpperCase()
                            });
                        T.fn[t] = function(r) {
                            var o, a = this[0];
                            return r === x ? n(a) ? a["inner" + e] : i(a) ? a.documentElement["scroll" + e] : (o = this.offset()) && o[t] : this.each(function(e) {
                                a = T(this),
                                    a.css(t, y(this, r, e, a[t]()))
                            })
                        }
                    }),
                    I.forEach(function(e, n) {
                        var i = n % 2;
                        T.fn[e] = function() {
                            var e, r, o = T.map(arguments,
                                function(n) {
                                    var i = [];
                                    return e = t(n),
                                        "array" == e ? (n.forEach(function(t) {
                                            return t.nodeType !== x ? i.push(t) : T.zepto.isZ(t) ? i = i.concat(t.get()) : void(i = i.concat(J.fragment(t)))
                                        }), i) : "object" == e || null == n ? n: J.fragment(n)
                                }),
                                a = this.length > 1;
                            return o.length < 1 ? this: this.each(function(t, e) {
                                r = i ? e: e.parentNode,
                                    e = 0 == n ? e.nextSibling: 1 == n ? e.firstChild: 2 == n ? e: null;
                                var s = T.contains(k.documentElement, r);
                                o.forEach(function(t) {
                                    if (a) t = t.cloneNode(!0);
                                    else if (!r) return T(t).remove();
                                    r.insertBefore(t, e),
                                    s && w(t,
                                        function(t) {
                                            if (! (null == t.nodeName || "SCRIPT" !== t.nodeName.toUpperCase() || t.type && "text/javascript" !== t.type || t.src)) {
                                                var e = t.ownerDocument ? t.ownerDocument.defaultView: window;
                                                e.eval.call(e, t.innerHTML)
                                            }
                                        })
                                })
                            })
                        },
                            T.fn[i ? e + "To": "insert" + (n ? "Before": "After")] = function(t) {
                                return T(t)[e](this),
                                    this
                            }
                    }),
                    J.Z.prototype = T.fn,
                    J.uniq = j,
                    J.deserializeValue = b,
                    T.zepto = J,
                    T
            } ();
            window.Zepto = n,
            void 0 === window.$ && (window.$ = n),
                function(t) {
                    function e(t) {
                        return t._zid || (t._zid = h++)
                    }
                    function n(t, n, o, a) {
                        if (n = i(n), n.ns) var s = r(n.ns);
                        return (y[e(t)] || []).filter(function(t) {
                            return t && (!n.e || t.e == n.e) && (!n.ns || s.test(t.ns)) && (!o || e(t.fn) === e(o)) && (!a || t.sel == a)
                        })
                    }
                    function i(t) {
                        var e = ("" + t).split(".");
                        return {
                            e: e[0],
                            ns: e.slice(1).sort().join(" ")
                        }
                    }
                    function r(t) {
                        return new RegExp("(?:^| )" + t.replace(" ", " .* ?") + "(?: |$)")
                    }
                    function o(t, e) {
                        return t.del && !g && t.e in b || !!e
                    }
                    function a(t) {
                        return w[t] || g && b[t] || t
                    }
                    function s(n, r, s, c, l, h, p) {
                        var d = e(n),
                            m = y[d] || (y[d] = []);
                        r.split(/\s/).forEach(function(e) {
                            if ("ready" == e) return t(document).ready(s);
                            var r = i(e);
                            r.fn = s,
                                r.sel = l,
                            r.e in w && (s = function(e) {
                                var n = e.relatedTarget;
                                if (!n || n !== this && !t.contains(this, n)) return r.fn.apply(this, arguments)
                            }),
                                r.del = h;
                            var d = h || s;
                            r.proxy = function(t) {
                                if (t = u(t), !t.isImmediatePropagationStopped()) {
                                    t.data = c;
                                    var e = d.apply(n, t._args == f ? [t] : [t].concat(t._args));
                                    return e === !1 && (t.preventDefault(), t.stopPropagation()),
                                        e
                                }
                            },
                                r.i = m.length,
                                m.push(r),
                            "addEventListener" in n && n.addEventListener(a(r.e), r.proxy, o(r, p))
                        })
                    }
                    function c(t, i, r, s, c) {
                        var u = e(t); (i || "").split(/\s/).forEach(function(e) {
                            n(t, e, r, s).forEach(function(e) {
                                delete y[u][e.i],
                                "removeEventListener" in t && t.removeEventListener(a(e.e), e.proxy, o(e, c))
                            })
                        })
                    }
                    function u(e, n) {
                        return ! n && e.isDefaultPrevented || (n || (n = e), t.each(S,
                            function(t, i) {
                                var r = n[t];
                                e[t] = function() {
                                    return this[i] = x,
                                    r && r.apply(n, arguments)
                                },
                                    e[i] = E
                            }), e.timeStamp || (e.timeStamp = Date.now()), (n.defaultPrevented !== f ? n.defaultPrevented: "returnValue" in n ? n.returnValue === !1 : n.getPreventDefault && n.getPreventDefault()) && (e.isDefaultPrevented = x)),
                            e
                    }
                    function l(t) {
                        var e, n = {
                            originalEvent: t
                        };
                        for (e in t) T.test(e) || t[e] === f || (n[e] = t[e]);
                        return u(n, t)
                    }
                    var f, h = 1,
                        p = Array.prototype.slice,
                        d = t.isFunction,
                        m = function(t) {
                            return "string" == typeof t
                        },
                        y = {},
                        v = {},
                        g = "onfocusin" in window,
                        b = {
                            focus: "focusin",
                            blur: "focusout"
                        },
                        w = {
                            mouseenter: "mouseover",
                            mouseleave: "mouseout"
                        };
                    v.click = v.mousedown = v.mouseup = v.mousemove = "MouseEvents",
                        t.event = {
                            add: s,
                            remove: c
                        },
                        t.proxy = function(n, i) {
                            var r = 2 in arguments && p.call(arguments, 2);
                            if (d(n)) {
                                var o = function() {
                                    return n.apply(i, r ? r.concat(p.call(arguments)) : arguments)
                                };
                                return o._zid = e(n),
                                    o
                            }
                            if (m(i)) return r ? (r.unshift(n[i], n), t.proxy.apply(null, r)) : t.proxy(n[i], n);
                            throw new TypeError("expected function")
                        },
                        t.fn.bind = function(t, e, n) {
                            return this.on(t, e, n)
                        },
                        t.fn.unbind = function(t, e) {
                            return this.off(t, e)
                        },
                        t.fn.one = function(t, e, n, i) {
                            return this.on(t, e, n, i, 1)
                        };
                    var x = function() {
                            return ! 0
                        },
                        E = function() {
                            return ! 1
                        },
                        T = /^([A-Z]|returnValue$|layer[XY]$|webkitMovement[XY]$)/,
                        S = {
                            preventDefault: "isDefaultPrevented",
                            stopImmediatePropagation: "isImmediatePropagationStopped",
                            stopPropagation: "isPropagationStopped"
                        };
                    t.fn.delegate = function(t, e, n) {
                        return this.on(e, t, n)
                    },
                        t.fn.undelegate = function(t, e, n) {
                            return this.off(e, t, n)
                        },
                        t.fn.live = function(e, n) {
                            return t(document.body).delegate(this.selector, e, n),
                                this
                        },
                        t.fn.die = function(e, n) {
                            return t(document.body).undelegate(this.selector, e, n),
                                this
                        },
                        t.fn.on = function(e, n, i, r, o) {
                            var a, u, h = this;
                            return e && !m(e) ? (t.each(e,
                                function(t, e) {
                                    h.on(t, n, i, e, o)
                                }), h) : (m(n) || d(r) || r === !1 || (r = i, i = n, n = f), r !== f && i !== !1 || (r = i, i = f), r === !1 && (r = E), h.each(function(f, h) {
                                o && (a = function(t) {
                                    return c(h, t.type, r),
                                        r.apply(this, arguments)
                                }),
                                n && (u = function(e) {
                                    var i, o = t(e.target).closest(n, h).get(0);
                                    if (o && o !== h) return i = t.extend(l(e), {
                                        currentTarget: o,
                                        liveFired: h
                                    }),
                                        (a || r).apply(o, [i].concat(p.call(arguments, 1)))
                                }),
                                    s(h, e, r, i, n, u || a)
                            }))
                        },
                        t.fn.off = function(e, n, i) {
                            var r = this;
                            return e && !m(e) ? (t.each(e,
                                function(t, e) {
                                    r.off(t, n, e)
                                }), r) : (m(n) || d(i) || i === !1 || (i = n, n = f), i === !1 && (i = E), r.each(function() {
                                c(this, e, i, n)
                            }))
                        },
                        t.fn.trigger = function(e, n) {
                            return e = m(e) || t.isPlainObject(e) ? t.Event(e) : u(e),
                                e._args = n,
                                this.each(function() {
                                    e.type in b && "function" == typeof this[e.type] ? this[e.type]() : "dispatchEvent" in this ? this.dispatchEvent(e) : t(this).triggerHandler(e, n)
                                })
                        },
                        t.fn.triggerHandler = function(e, i) {
                            var r, o;
                            return this.each(function(a, s) {
                                r = l(m(e) ? t.Event(e) : e),
                                    r._args = i,
                                    r.target = s,
                                    t.each(n(s, e.type || e),
                                        function(t, e) {
                                            if (o = e.proxy(r), r.isImmediatePropagationStopped()) return ! 1
                                        })
                            }),
                                o
                        },
                        "focusin focusout focus blur load resize scroll unload click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select keydown keypress keyup error".split(" ").forEach(function(e) {
                            t.fn[e] = function(t) {
                                return 0 in arguments ? this.bind(e, t) : this.trigger(e)
                            }
                        }),
                        t.Event = function(t, e) {
                            m(t) || (e = t, t = e.type);
                            var n = document.createEvent(v[t] || "Events"),
                                i = !0;
                            if (e) for (var r in e)"bubbles" == r ? i = !!e[r] : n[r] = e[r];
                            return n.initEvent(t, i, !0),
                                u(n)
                        }
                } (n),
                function(t) {
                    function e(e, n, i) {
                        var r = t.Event(n);
                        return t(e).trigger(r, i),
                            !r.isDefaultPrevented()
                    }
                    function n(t, n, i, r) {
                        if (t.global) return e(n || g, i, r)
                    }
                    function i(e) {
                        e.global && 0 === t.active++&&n(e, null, "ajaxStart")
                    }
                    function r(e) {
                        e.global && !--t.active && n(e, null, "ajaxStop")
                    }
                    function o(t, e) {
                        var i = e.context;
                        return e.beforeSend.call(i, t, e) !== !1 && n(e, i, "ajaxBeforeSend", [t, e]) !== !1 && void n(e, i, "ajaxSend", [t, e])
                    }
                    function a(t, e, i, r) {
                        var o = i.context,
                            a = "success";
                        i.success.call(o, t, a, e),
                        r && r.resolveWith(o, [t, a, e]),
                            n(i, o, "ajaxSuccess", [e, i, t]),
                            c(a, e, i)
                    }
                    function s(t, e, i, r, o) {
                        var a = r.context;
                        r.error.call(a, i, e, t),
                        o && o.rejectWith(a, [i, e, t]),
                            n(r, a, "ajaxError", [i, r, t || e]),
                            c(e, i, r)
                    }
                    function c(t, e, i) {
                        var o = i.context;
                        i.complete.call(o, e, t),
                            n(i, o, "ajaxComplete", [e, i]),
                            r(i)
                    }
                    function u() {}
                    function l(t) {
                        return t && (t = t.split(";", 2)[0]),
                        t && (t == T ? "html": t == E ? "json": w.test(t) ? "script": x.test(t) && "xml") || "text"
                    }
                    function f(t, e) {
                        return "" == e ? t: (t + "&" + e).replace(/[&?]{1,2}/, "?")
                    }
                    function h(e) {
                        e.processData && e.data && "string" != t.type(e.data) && (e.data = t.param(e.data, e.traditional)),
                        !e.data || e.type && "GET" != e.type.toUpperCase() && "jsonp" != e.dataType || (e.url = f(e.url, e.data), e.data = void 0)
                    }
                    function p(e, n, i, r) {
                        return t.isFunction(n) && (r = i, i = n, n = void 0),
                        t.isFunction(i) || (r = i, i = void 0),
                        {
                            url: e,
                            data: n,
                            success: i,
                            dataType: r
                        }
                    }
                    function d(e, n, i, r) {
                        var o, a = t.isArray(n),
                            s = t.isPlainObject(n);
                        t.each(n,
                            function(n, c) {
                                o = t.type(c),
                                r && (n = i ? r: r + "[" + (s || "object" == o || "array" == o ? n: "") + "]"),
                                    !r && a ? e.add(c.name, c.value) : "array" == o || !i && "object" == o ? d(e, c, i, n) : e.add(n, c)
                            })
                    }
                    var m, y, v = +new Date,
                        g = window.document,
                        b = /<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi,
                        w = /^(?:text|application)\/javascript/i,
                        x = /^(?:text|application)\/xml/i,
                        E = "application/json",
                        T = "text/html",
                        S = /^\s*$/,
                        P = g.createElement("a");
                    P.href = window.location.href,
                        t.active = 0,
                        t.ajaxJSONP = function(e, n) {
                            if (! ("type" in e)) return t.ajax(e);
                            var i, r, c = e.jsonpCallback,
                                u = (t.isFunction(c) ? c() : c) || "Zepto" + v++,
                                l = g.createElement("script"),
                                f = window[u],
                                h = function(e) {
                                    t(l).triggerHandler("error", e || "abort")
                                },
                                p = {
                                    abort: h
                                };
                            return n && n.promise(p),
                                t(l).on("load error",
                                    function(o, c) {
                                        clearTimeout(r),
                                            t(l).off().remove(),
                                            "error" != o.type && i ? a(i[0], p, e, n) : s(null, c || "error", p, e, n),
                                            window[u] = f,
                                        i && t.isFunction(f) && f(i[0]),
                                            f = i = void 0
                                    }),
                                o(p, e) === !1 ? (h("abort"), p) : (window[u] = function() {
                                    i = arguments
                                },
                                    l.src = e.url.replace(/\?(.+)=\?/, "?$1=" + u), g.head.appendChild(l), e.timeout > 0 && (r = setTimeout(function() {
                                        h("timeout")
                                    },
                                    e.timeout)), p)
                        },
                        t.ajaxSettings = {
                            type: "GET",
                            beforeSend: u,
                            success: u,
                            error: u,
                            complete: u,
                            context: null,
                            global: !0,
                            xhr: function() {
                                return new window.XMLHttpRequest
                            },
                            accepts: {
                                script: "text/javascript, application/javascript, application/x-javascript",
                                json: E,
                                xml: "application/xml, text/xml",
                                html: T,
                                text: "text/plain"
                            },
                            crossDomain: !1,
                            timeout: 0,
                            processData: !0,
                            cache: !0
                        },
                        t.ajax = function(e) {
                            var n, r, c = t.extend({},
                                    e || {}),
                                p = t.Deferred && t.Deferred();
                            for (m in t.ajaxSettings) void 0 === c[m] && (c[m] = t.ajaxSettings[m]);
                            i(c),
                            c.crossDomain || (n = g.createElement("a"), n.href = c.url, n.href = n.href, c.crossDomain = P.protocol + "//" + P.host != n.protocol + "//" + n.host),
                            c.url || (c.url = window.location.toString()),
                            (r = c.url.indexOf("#")) > -1 && (c.url = c.url.slice(0, r)),
                                h(c);
                            var d = c.dataType,
                                v = /\?.+=\?/.test(c.url);
                            if (v && (d = "jsonp"), c.cache !== !1 && (e && e.cache === !0 || "script" != d && "jsonp" != d) || (c.url = f(c.url, "_=" + Date.now())), "jsonp" == d) return v || (c.url = f(c.url, c.jsonp ? c.jsonp + "=?": c.jsonp === !1 ? "": "callback=?")),
                                t.ajaxJSONP(c, p);
                            var b, w = c.accepts[d],
                                x = {},
                                E = function(t, e) {
                                    x[t.toLowerCase()] = [t, e]
                                },
                                T = /^([\w-]+:)\/\//.test(c.url) ? RegExp.$1: window.location.protocol,
                                j = c.xhr(),
                                C = j.setRequestHeader;
                            if (p && p.promise(j), c.crossDomain || E("X-Requested-With", "XMLHttpRequest"), E("Accept", w || "*/*"), (w = c.mimeType || w) && (w.indexOf(",") > -1 && (w = w.split(",", 2)[0]), j.overrideMimeType && j.overrideMimeType(w)), (c.contentType || c.contentType !== !1 && c.data && "GET" != c.type.toUpperCase()) && E("Content-Type", c.contentType || "application/x-www-form-urlencoded"), c.headers) for (y in c.headers) E(y, c.headers[y]);
                            if (j.setRequestHeader = E, j.onreadystatechange = function() {
                                    if (4 == j.readyState) {
                                        j.onreadystatechange = u,
                                            clearTimeout(b);
                                        var e, n = !1;
                                        if (j.status >= 200 && j.status < 300 || 304 == j.status || 0 == j.status && "file:" == T) {
                                            if (d = d || l(c.mimeType || j.getResponseHeader("content-type")), "arraybuffer" == j.responseType || "blob" == j.responseType) e = j.response;
                                            else {
                                                e = j.responseText;
                                                try {
                                                    "script" == d ? (0, eval)(e) : "xml" == d ? e = j.responseXML: "json" == d && (e = S.test(e) ? null: t.parseJSON(e))
                                                } catch(i) {
                                                    n = i
                                                }
                                                if (n) return s(n, "parsererror", j, c, p)
                                            }
                                            a(e, j, c, p)
                                        } else s(j.statusText || null, j.status ? "error": "abort", j, c, p)
                                    }
                                },
                                o(j, c) === !1) return j.abort(),
                                s(null, "abort", j, c, p),
                                j;
                            var $ = !("async" in c) || c.async;
                            if (j.open(c.type, c.url, $, c.username, c.password), c.xhrFields) for (y in c.xhrFields) j[y] = c.xhrFields[y];
                            for (y in x) C.apply(j, x[y]);
                            return c.timeout > 0 && (b = setTimeout(function() {
                                    j.onreadystatechange = u,
                                        j.abort(),
                                        s(null, "timeout", j, c, p)
                                },
                                c.timeout)),
                                j.send(c.data ? c.data: null),
                                j
                        },
                        t.get = function() {
                            return t.ajax(p.apply(null, arguments))
                        },
                        t.post = function() {
                            var e = p.apply(null, arguments);
                            return e.type = "POST",
                                t.ajax(e)
                        },
                        t.getJSON = function() {
                            var e = p.apply(null, arguments);
                            return e.dataType = "json",
                                t.ajax(e)
                        },
                        t.fn.load = function(e, n, i) {
                            if (!this.length) return this;
                            var r, o = this,
                                a = e.split(/\s/),
                                s = p(e, n, i),
                                c = s.success;
                            return a.length > 1 && (s.url = a[0], r = a[1]),
                                s.success = function(e) {
                                    o.html(r ? t("<div>").html(e.replace(b, "")).find(r) : e),
                                    c && c.apply(o, arguments)
                                },
                                t.ajax(s),
                                this
                        };
                    var j = encodeURIComponent;
                    t.param = function(e, n) {
                        var i = [];
                        return i.add = function(e, n) {
                            t.isFunction(n) && (n = n()),
                            null == n && (n = ""),
                                this.push(j(e) + "=" + j(n))
                        },
                            d(i, e, n),
                            i.join("&").replace(/%20/g, "+")
                    }
                } (n),
                function(t) {
                    t.fn.serializeArray = function() {
                        var e, n, i = [],
                            r = function(t) {
                                return t.forEach ? t.forEach(r) : void i.push({
                                    name: e,
                                    value: t
                                })
                            };
                        return this[0] && t.each(this[0].elements,
                            function(i, o) {
                                n = o.type,
                                    e = o.name,
                                e && "fieldset" != o.nodeName.toLowerCase() && !o.disabled && "submit" != n && "reset" != n && "button" != n && "file" != n && ("radio" != n && "checkbox" != n || o.checked) && r(t(o).val())
                            }),
                            i
                    },
                        t.fn.serialize = function() {
                            var t = [];
                            return this.serializeArray().forEach(function(e) {
                                t.push(encodeURIComponent(e.name) + "=" + encodeURIComponent(e.value))
                            }),
                                t.join("&")
                        },
                        t.fn.submit = function(e) {
                            if (0 in arguments) this.bind("submit", e);
                            else if (this.length) {
                                var n = t.Event("submit");
                                this.eq(0).trigger(n),
                                n.isDefaultPrevented() || this.get(0).submit()
                            }
                            return this
                        }
                } (n),
                function(t) {
                    "__proto__" in {} || t.extend(t.zepto, {
                        Z: function(e, n) {
                            return e = e || [],
                                t.extend(e, t.fn),
                                e.selector = n || "",
                                e.__Z = !0,
                                e
                        },
                        isZ: function(e) {
                            return "array" === t.type(e) && "__Z" in e
                        }
                    });
                    try {
                        getComputedStyle(void 0)
                    } catch(e) {
                        var n = getComputedStyle;
                        window.getComputedStyle = function(t, e) {
                            try {
                                return n(t, e)
                            } catch(i) {
                                return null
                            }
                        }
                    }
                } (n)
        },
        function(t, e) {
            "use strict"; !
                function(t) {
                    function e(t, e, n, i) {
                        return Math.abs(t - e) >= Math.abs(n - i) ? t - e > 0 ? "Left": "Right": n - i > 0 ? "Up": "Down";
                    }
                    function n() {
                        l = null,
                        h.last && (h.el.trigger("longTap"), h = {})
                    }
                    function i() {
                        l && clearTimeout(l),
                            l = null
                    }
                    function r() {
                        s && clearTimeout(s),
                        c && clearTimeout(c),
                        u && clearTimeout(u),
                        l && clearTimeout(l),
                            s = c = u = l = null,
                            h = {}
                    }
                    function o(t) {
                        return ("touch" == t.pointerType || t.pointerType == t.MSPOINTER_TYPE_TOUCH) && t.isPrimary
                    }
                    function a(t, e) {
                        return t.type == "pointer" + e || t.type.toLowerCase() == "mspointer" + e
                    }
                    var s, c, u, l, f, h = {},
                        p = 750;
                    t(document).ready(function() {
                        var d, m, y, v, g = 0,
                            b = 0;
                        "MSGesture" in window && (f = new MSGesture, f.target = document.body),
                            t(document).bind("MSGestureEnd",
                                function(t) {
                                    var e = t.velocityX > 1 ? "Right": t.velocityX < -1 ? "Left": t.velocityY > 1 ? "Down": t.velocityY < -1 ? "Up": null;
                                    e && (h.el.trigger("swipe"), h.el.trigger("swipe" + e))
                                }).on("touchstart MSPointerDown pointerdown",
                                function(e) { (v = a(e, "down")) && !o(e) || (y = v ? e: e.touches[0], e.touches && 1 === e.touches.length && h.x2 && (h.x2 = void 0, h.y2 = void 0), d = Date.now(), m = d - (h.last || d), h.el = t("tagName" in y.target ? y.target: y.target.parentNode), s && clearTimeout(s), h.x1 = y.pageX, h.y1 = y.pageY, m > 0 && m <= 250 && (h.isDoubleTap = !0), h.last = d, l = setTimeout(n, p), f && v && f.addPointer(e.pointerId))
                                }).on("touchmove MSPointerMove pointermove",
                                function(t) { (v = a(t, "move")) && !o(t) || (y = v ? t: t.touches[0], i(), h.x2 = y.pageX, h.y2 = y.pageY, g += Math.abs(h.x1 - h.x2), b += Math.abs(h.y1 - h.y2))
                                }).on("touchend MSPointerUp pointerup",
                                function(n) { (v = a(n, "up")) && !o(n) || (i(), h.x2 && Math.abs(h.x1 - h.x2) > 30 || h.y2 && Math.abs(h.y1 - h.y2) > 30 ? u = setTimeout(function() {
                                        h.el && (h.el.trigger("swipe"), h.el.trigger("swipe" + e(h.x1, h.x2, h.y1, h.y2))),
                                            h = {}
                                    },
                                    0) : "last" in h && (g < 30 && b < 30 ? c = setTimeout(function() {
                                        var e = t.Event("tap");
                                        e.cancelTouch = r,
                                        h.el && h.el.trigger(e),
                                            h.isDoubleTap ? (h.el && h.el.trigger("doubleTap"), h = {}) : s = setTimeout(function() {
                                                    s = null,
                                                    h.el && h.el.trigger("singleTap"),
                                                        h = {}
                                                },
                                                250)
                                    },
                                    0) : h = {}), g = b = 0)
                                }).on("touchcancel MSPointerCancel pointercancel", r),
                            t(window).on("scroll", r)
                    }),
                        ["swipe", "swipeLeft", "swipeRight", "swipeUp", "swipeDown", "doubleTap", "tap", "singleTap", "longTap"].forEach(function(e) {
                            t.fn[e] = function(t) {
                                return this.on(e, t)
                            }
                        })
                } (Zepto)
        },
        function(t, e, n) {
            "use strict";
            function i(t) {
                return t && t.__esModule ? t: {
                    "default": t
                }
            }
            Object.defineProperty(e, "__esModule", {
                value: !0
            }),
                n(11);
            var r = n(14),
                o = i(r),
                a = {
                    timer: null,
                    $el: null,
                    msg: "提示信息",
                    create$el: function() {
                        var t = this.$el = $('<div class="' + o["default"].container + '"><div class="motify-inner js-motify-text">' + this.msg + "</div></div>");
                        $("body").append(t)
                    },
                    toHide: function() {},
                    show: function(t, e) {
                        var n = this;
                        this.msg = t,
                        this.$el || this.create$el(),
                            this.$el.find(".js-motify-text").html(this.msg),
                            this.$el.show(),
                        this.timer && clearTimeout(this.timer),
                            this.timer = setTimeout(function() {
                                    n.hide()
                                },
                                e || 3e3)
                    },
                    hide: function() {
                        this.$el.hide()
                    }
                };
            e["default"] = a
        },
        function(t, e) {
            t.exports = {
                container: "bLETddoT8v_gcO_8SLGhF"
            }
        },
        function(t, e) {
            "use strict";
            Object.defineProperty(e, "__esModule", {
                value: !0
            });
            var n = {},
                i = n.mul = function(t, e) {
                    var n = 0,
                        i = t.toString(),
                        r = e.toString();
                    try {
                        n += i.split(".")[1].length
                    } catch(o) {}
                    try {
                        n += r.split(".")[1].length
                    } catch(o) {}
                    return Number(i.replace(".", "")) * Number(r.replace(".", "")) / Math.pow(10, n)
                },
                r = n.isPhone = function(t) {
                    return /^\d{11}$/.test(t)
                },
                o = n.linkValue = function(t) {
                    var e = t.target,
                        n = {};
                    n[e.name] = e.value,
                        this.setState(n)
                },
                a = n.getTerminal = function() {
                    var t = window.navigator.userAgent.toLowerCase(),
                        e = !1,
                        n = "pc",
                        i = void 0;
                    return "micromessenger" == t.match(/MicroMessenger/i) && (e = !0),
                    /test/i.test(location.href) && (/Android/i.test(t) ? t += "youzan_cashier_android": (/iPhone/i.test(t) || /ios/i.test(t) || /iPad/i.test(t) || /iPod/i.test(t)) && (t += "youzan_cashierhd_ios")),
                        /Android/i.test(t) ? (n = "android", (/youzan_cashier_android/i.test(t) || /youzan_cashierhd_android/i.test(t)) && (i = "android")) : /iPhone/i.test(t) || /ios/i.test(t) || /iPad/i.test(t) || /iPod/i.test(t) ? (n = "ios", /youzan_cashier_ios/i.test(t) && (i = "ios"), /youzan_cashierhd_ios/i.test(t) && (i = "ipad")) : t.match(/(iPhone|iPod|Android|ios)/i) || (n = "pc"),
                    {
                        isWX: e,
                        terminal: n,
                        appTerminal: i
                    }
                },
                s = n.formatList = function(t) {
                    t = t || {};
                    var e = [];
                    for (var n in t) e.push({
                        id: n,
                        name: t[n]
                    });
                    return e
                },
                c = n.getAreaCodesByCounty = function(t) {
                    var e = t.toString();
                    return 6 === e.length ? {
                        provinceId: 1e4 * e.substr(0, 2),
                        cityId: 100 * e.substr(0, 4)
                    }: null
                };
            e.mul = i,
                e.isPhone = r,
                e.linkValue = o,
                e.getTerminal = a,
                e.formatList = s,
                e.getAreaCodesByCounty = c,
                e.util = n
        }]));
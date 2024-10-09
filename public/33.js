(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[33],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/google/drive/imageThumbnailFullPathSizeFree.vue?vue&type=script&lang=js":
/*!*****************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/google/drive/imageThumbnailFullPathSizeFree.vue?vue&type=script&lang=js ***!
  \*****************************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["path", "size", "propID"]
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/punpang/menuOrder.vue?vue&type=script&lang=js":
/*!**********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/punpang/menuOrder.vue?vue&type=script&lang=js ***!
  \**********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
/* harmony import */ var _js_components_google_drive_imageThumbnailFullPathSizeFree__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @/js/components/google/drive/imageThumbnailFullPathSizeFree */ "./resources/js/components/google/drive/imageThumbnailFullPathSizeFree.vue");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function ownKeys(e, r) { var t = Object.keys(e); if (Object.getOwnPropertySymbols) { var o = Object.getOwnPropertySymbols(e); r && (o = o.filter(function (r) { return Object.getOwnPropertyDescriptor(e, r).enumerable; })), t.push.apply(t, o); } return t; }
function _objectSpread(e) { for (var r = 1; r < arguments.length; r++) { var t = null != arguments[r] ? arguments[r] : {}; r % 2 ? ownKeys(Object(t), !0).forEach(function (r) { _defineProperty(e, r, t[r]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(t)) : ownKeys(Object(t)).forEach(function (r) { Object.defineProperty(e, r, Object.getOwnPropertyDescriptor(t, r)); }); } return e; }
function _defineProperty(obj, key, value) { key = _toPropertyKey(key); if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return e; }; var t, e = {}, r = Object.prototype, n = r.hasOwnProperty, o = Object.defineProperty || function (t, e, r) { t[e] = r.value; }, i = "function" == typeof Symbol ? Symbol : {}, a = i.iterator || "@@iterator", c = i.asyncIterator || "@@asyncIterator", u = i.toStringTag || "@@toStringTag"; function define(t, e, r) { return Object.defineProperty(t, e, { value: r, enumerable: !0, configurable: !0, writable: !0 }), t[e]; } try { define({}, ""); } catch (t) { define = function define(t, e, r) { return t[e] = r; }; } function wrap(t, e, r, n) { var i = e && e.prototype instanceof Generator ? e : Generator, a = Object.create(i.prototype), c = new Context(n || []); return o(a, "_invoke", { value: makeInvokeMethod(t, r, c) }), a; } function tryCatch(t, e, r) { try { return { type: "normal", arg: t.call(e, r) }; } catch (t) { return { type: "throw", arg: t }; } } e.wrap = wrap; var h = "suspendedStart", l = "suspendedYield", f = "executing", s = "completed", y = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var p = {}; define(p, a, function () { return this; }); var d = Object.getPrototypeOf, v = d && d(d(values([]))); v && v !== r && n.call(v, a) && (p = v); var g = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(p); function defineIteratorMethods(t) { ["next", "throw", "return"].forEach(function (e) { define(t, e, function (t) { return this._invoke(e, t); }); }); } function AsyncIterator(t, e) { function invoke(r, o, i, a) { var c = tryCatch(t[r], t, o); if ("throw" !== c.type) { var u = c.arg, h = u.value; return h && "object" == _typeof(h) && n.call(h, "__await") ? e.resolve(h.__await).then(function (t) { invoke("next", t, i, a); }, function (t) { invoke("throw", t, i, a); }) : e.resolve(h).then(function (t) { u.value = t, i(u); }, function (t) { return invoke("throw", t, i, a); }); } a(c.arg); } var r; o(this, "_invoke", { value: function value(t, n) { function callInvokeWithMethodAndArg() { return new e(function (e, r) { invoke(t, n, e, r); }); } return r = r ? r.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(e, r, n) { var o = h; return function (i, a) { if (o === f) throw Error("Generator is already running"); if (o === s) { if ("throw" === i) throw a; return { value: t, done: !0 }; } for (n.method = i, n.arg = a;;) { var c = n.delegate; if (c) { var u = maybeInvokeDelegate(c, n); if (u) { if (u === y) continue; return u; } } if ("next" === n.method) n.sent = n._sent = n.arg;else if ("throw" === n.method) { if (o === h) throw o = s, n.arg; n.dispatchException(n.arg); } else "return" === n.method && n.abrupt("return", n.arg); o = f; var p = tryCatch(e, r, n); if ("normal" === p.type) { if (o = n.done ? s : l, p.arg === y) continue; return { value: p.arg, done: n.done }; } "throw" === p.type && (o = s, n.method = "throw", n.arg = p.arg); } }; } function maybeInvokeDelegate(e, r) { var n = r.method, o = e.iterator[n]; if (o === t) return r.delegate = null, "throw" === n && e.iterator["return"] && (r.method = "return", r.arg = t, maybeInvokeDelegate(e, r), "throw" === r.method) || "return" !== n && (r.method = "throw", r.arg = new TypeError("The iterator does not provide a '" + n + "' method")), y; var i = tryCatch(o, e.iterator, r.arg); if ("throw" === i.type) return r.method = "throw", r.arg = i.arg, r.delegate = null, y; var a = i.arg; return a ? a.done ? (r[e.resultName] = a.value, r.next = e.nextLoc, "return" !== r.method && (r.method = "next", r.arg = t), r.delegate = null, y) : a : (r.method = "throw", r.arg = new TypeError("iterator result is not an object"), r.delegate = null, y); } function pushTryEntry(t) { var e = { tryLoc: t[0] }; 1 in t && (e.catchLoc = t[1]), 2 in t && (e.finallyLoc = t[2], e.afterLoc = t[3]), this.tryEntries.push(e); } function resetTryEntry(t) { var e = t.completion || {}; e.type = "normal", delete e.arg, t.completion = e; } function Context(t) { this.tryEntries = [{ tryLoc: "root" }], t.forEach(pushTryEntry, this), this.reset(!0); } function values(e) { if (e || "" === e) { var r = e[a]; if (r) return r.call(e); if ("function" == typeof e.next) return e; if (!isNaN(e.length)) { var o = -1, i = function next() { for (; ++o < e.length;) if (n.call(e, o)) return next.value = e[o], next.done = !1, next; return next.value = t, next.done = !0, next; }; return i.next = i; } } throw new TypeError(_typeof(e) + " is not iterable"); } return GeneratorFunction.prototype = GeneratorFunctionPrototype, o(g, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), o(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, u, "GeneratorFunction"), e.isGeneratorFunction = function (t) { var e = "function" == typeof t && t.constructor; return !!e && (e === GeneratorFunction || "GeneratorFunction" === (e.displayName || e.name)); }, e.mark = function (t) { return Object.setPrototypeOf ? Object.setPrototypeOf(t, GeneratorFunctionPrototype) : (t.__proto__ = GeneratorFunctionPrototype, define(t, u, "GeneratorFunction")), t.prototype = Object.create(g), t; }, e.awrap = function (t) { return { __await: t }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, c, function () { return this; }), e.AsyncIterator = AsyncIterator, e.async = function (t, r, n, o, i) { void 0 === i && (i = Promise); var a = new AsyncIterator(wrap(t, r, n, o), i); return e.isGeneratorFunction(r) ? a : a.next().then(function (t) { return t.done ? t.value : a.next(); }); }, defineIteratorMethods(g), define(g, u, "Generator"), define(g, a, function () { return this; }), define(g, "toString", function () { return "[object Generator]"; }), e.keys = function (t) { var e = Object(t), r = []; for (var n in e) r.push(n); return r.reverse(), function next() { for (; r.length;) { var t = r.pop(); if (t in e) return next.value = t, next.done = !1, next; } return next.done = !0, next; }; }, e.values = values, Context.prototype = { constructor: Context, reset: function reset(e) { if (this.prev = 0, this.next = 0, this.sent = this._sent = t, this.done = !1, this.delegate = null, this.method = "next", this.arg = t, this.tryEntries.forEach(resetTryEntry), !e) for (var r in this) "t" === r.charAt(0) && n.call(this, r) && !isNaN(+r.slice(1)) && (this[r] = t); }, stop: function stop() { this.done = !0; var t = this.tryEntries[0].completion; if ("throw" === t.type) throw t.arg; return this.rval; }, dispatchException: function dispatchException(e) { if (this.done) throw e; var r = this; function handle(n, o) { return a.type = "throw", a.arg = e, r.next = n, o && (r.method = "next", r.arg = t), !!o; } for (var o = this.tryEntries.length - 1; o >= 0; --o) { var i = this.tryEntries[o], a = i.completion; if ("root" === i.tryLoc) return handle("end"); if (i.tryLoc <= this.prev) { var c = n.call(i, "catchLoc"), u = n.call(i, "finallyLoc"); if (c && u) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } else if (c) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); } else { if (!u) throw Error("try statement without catch or finally"); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } } } }, abrupt: function abrupt(t, e) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var o = this.tryEntries[r]; if (o.tryLoc <= this.prev && n.call(o, "finallyLoc") && this.prev < o.finallyLoc) { var i = o; break; } } i && ("break" === t || "continue" === t) && i.tryLoc <= e && e <= i.finallyLoc && (i = null); var a = i ? i.completion : {}; return a.type = t, a.arg = e, i ? (this.method = "next", this.next = i.finallyLoc, y) : this.complete(a); }, complete: function complete(t, e) { if ("throw" === t.type) throw t.arg; return "break" === t.type || "continue" === t.type ? this.next = t.arg : "return" === t.type ? (this.rval = this.arg = t.arg, this.method = "return", this.next = "end") : "normal" === t.type && e && (this.next = e), y; }, finish: function finish(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.finallyLoc === t) return this.complete(r.completion, r.afterLoc), resetTryEntry(r), y; } }, "catch": function _catch(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.tryLoc === t) { var n = r.completion; if ("throw" === n.type) { var o = n.arg; resetTryEntry(r); } return o; } } throw Error("illegal catch attempt"); }, delegateYield: function delegateYield(e, r, n) { return this.delegate = { iterator: values(e), resultName: r, nextLoc: n }, "next" === this.method && (this.arg = t), y; } }, e; }
function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }
function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }
var numeral = __webpack_require__(/*! numeral */ "./node_modules/numeral/numeral.js");
Vue.filter("formatNumber", function (value) {
  return numeral(value).format("0,0.00"); // displaying other groupings/separators is possible, look at the docs
});


/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    imageThumbnailFullPathSizeFree: _js_components_google_drive_imageThumbnailFullPathSizeFree__WEBPACK_IMPORTED_MODULE_1__["default"]
  },
  data: function data() {
    return {
      //   path: "https://www.punpang.online/images/menu/",
      //   path: "http://192.168.1.103/images/menu/",
      products: [],
      search: {
        tags: [],
        price_rank: ""
      }
    };
  },
  methods: {
    product_sum_price_for_menu: function product_sum_price_for_menu(v) {
      if (v.a_price.updated_at_date >= "2024-06-19") {
        return v.sum_price_for_menu;
      } else {
        var price_vat = parseInt(v.sum_price_for_menu * 1.07);
        var pv = String(price_vat);

        // let lpv = pv[pv.length - 1];
        var l = 0;
        // if (lpv >= 1 && lpv <= 5) {
        //     l = 5;
        // }

        var price = "";
        for (var i = 0; i < pv.length - 1; i++) {
          price = price + pv[i];
        }
        price = price + l;
        // if (l == 0) {
        price = parseFloat(price) + 10;
        // }
        return parseFloat(price);
      }
    },
    clickSearchReset: function clickSearchReset() {
      window.location.href = "/menu/orders";
    },
    clickSearch: function clickSearch() {
      var tags_url = "";
      for (var i = 0; i < this.search.tags.length; i++) {
        tags_url = "".concat(tags_url).concat(this.search.tags[i].text, ",");
      }
      var tags = tags_url.slice(0, -1) ? "&tags=" + tags_url.slice(0, -1) : "";
      var price_rank = this.search.price_rank ? "&price_rank=".concat(this.search.price_rank) : "";
      window.location.href = "/menu/orders?".concat(tags).concat(price_rank);
    },
    clickToOrder: function clickToOrder(v) {
      if (this.user.type == 1) {
        window.location.href = "/manages/order/".concat(v, "/showOrderByID");
        // window.location.href = `/manages/order/${v}/showOrderByID`;
      }
    },
    convert_tags: function convert_tags(v) {
      var text = "";
      for (var i = 0; i < v.length; i++) {
        var comma = i != v.length - 1 ? "," : "";
        text = text + v[i].tag.text + comma;
      }
      return text;
    },
    convert_add_on_name: function convert_add_on_name(v) {
      var text = "";
      for (var i = 0; i < v.length; i++) {
        if (v[i].product_add_on.price > 0) {
          var comma = i != v.length - 1 ? "," : "";
          text = text + v[i].product_add_on.goods_add_on.name + comma;
        }
      }
      return text;
    }
  },
  mounted: function mounted() {
    var _this = this;
    return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
      var loader, tags, price_rank, payload, result;
      return _regeneratorRuntime().wrap(function _callee$(_context) {
        while (1) switch (_context.prev = _context.next) {
          case 0:
            loader = _this.$loading.show();
            tags = _this.$route.query.tags != undefined ? "&tags=".concat(_this.$route.query.tags) : "";
            price_rank = _this.$route.query.price_rank != undefined ? "&price_rank=".concat(_this.$route.query.price_rank) : "";
            payload = "whereHas=imageForMenus,with=imageForMenus,multiCakes".concat(tags).concat(price_rank);
            _context.next = 6;
            return axios.get("/api/v1/guest/product/punpang/order_details/fetch_for_menu?".concat(payload));
          case 6:
            result = _context.sent;
            _this.products = result.data;
            if (!(_this.user.type == 1)) {
              _context.next = 11;
              break;
            }
            _context.next = 11;
            return _this.$store.dispatch("orderTags/fetch", "status=true");
          case 11:
            loader.hide();
          case 12:
          case "end":
            return _context.stop();
        }
      }, _callee);
    }))();
  },
  computed: _objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapGetters"])({
    user: "main/User",
    tags: "orderTags/fetch"
  }))
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/google/drive/imageThumbnailFullPathSizeFree.vue?vue&type=template&id=4ed1cd32":
/*!***************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/google/drive/imageThumbnailFullPathSizeFree.vue?vue&type=template&id=4ed1cd32 ***!
  \***************************************************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("v-img", {
    attrs: {
      src: "https://drive.google.com/thumbnail?id=".concat(_vm.path.google_image.src_name, "&sz=w").concat(_vm.size, "-h").concat(_vm.size),
      "lazy-src": "https://drive.google.com/thumbnail?id=".concat(_vm.path.google_image.src_name, "&sz=w").concat(_vm.size, "-h").concat(_vm.size)
    },
    scopedSlots: _vm._u([{
      key: "placeholder",
      fn: function fn() {
        return [_c("v-row", {
          staticClass: "fill-height ma-0",
          attrs: {
            align: "center",
            justify: "center"
          }
        }, [_c("v-progress-circular", {
          attrs: {
            indeterminate: "",
            color: "grey lighten-5"
          }
        })], 1)];
      },
      proxy: true
    }])
  }, [_vm.propID ? _c("v-btn", {
    staticClass: "deep-orange mt-3 ml-3 font-weight-bold",
    attrs: {
      outlined: "",
      dark: "",
      "x-small": ""
    }
  }, [_vm._v("#" + _vm._s(_vm.propID))]) : _vm._e()], 1);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/punpang/menuOrder.vue?vue&type=template&id=30e3c87a":
/*!********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/punpang/menuOrder.vue?vue&type=template&id=30e3c87a ***!
  \********************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", [_c("h2", [_vm._v("รายการสินค้า")]), _vm._v(" "), _c("p", {
    staticClass: "text-subtitle-2 mb-1"
  }, [_vm._v("สั่งซื้อวันนี้ รับราคาพิเศษ")]), _vm._v(" "), _vm._m(0), _vm._v(" "), _vm._m(1), _vm._v(" "), _vm.user.type == 1 ? _c("v-card", {
    staticClass: "mb-3",
    attrs: {
      outlined: ""
    }
  }, [_c("v-card-title", [_vm._v(" ค้นหา ")]), _vm._v(" "), _c("v-card-text", {
    staticClass: "pb-0"
  }, [_c("v-text-field", {
    staticClass: "mb-3",
    attrs: {
      label: "ราคาไม่เกิน",
      outlined: "",
      dense: "",
      "hide-details": ""
    },
    model: {
      value: _vm.search.price_rank,
      callback: function callback($$v) {
        _vm.$set(_vm.search, "price_rank", $$v);
      },
      expression: "search.price_rank"
    }
  }), _vm._v(" "), _c("v-combobox", {
    staticClass: "mb-3",
    attrs: {
      items: _vm.tags,
      label: "แท็ก",
      multiple: "",
      outlined: "",
      dense: "",
      "hide-details": ""
    },
    model: {
      value: _vm.search.tags,
      callback: function callback($$v) {
        _vm.$set(_vm.search, "tags", $$v);
      },
      expression: "search.tags"
    }
  })], 1), _vm._v(" "), _c("v-card-actions", [_c("v-btn", {
    staticClass: "error",
    on: {
      click: function click($event) {
        return _vm.clickSearchReset();
      }
    }
  }, [_vm._v("ล้าง")]), _vm._v(" "), _c("v-spacer"), _vm._v(" "), _c("v-btn", {
    staticClass: "success",
    on: {
      click: function click($event) {
        return _vm.clickSearch();
      }
    }
  }, [_vm._v("ค้นหา")])], 1)], 1) : _vm._e(), _vm._v(" "), _c("v-row", _vm._l(_vm.products, function (product) {
    return _c("v-col", {
      key: product.id,
      attrs: {
        cols: "12",
        sm: "6",
        md: "4",
        lg: "4",
        xl: "4"
      }
    }, [_c("v-card", {
      attrs: {
        outlined: ""
      }
    }, [product.image_for_menus.length > 1 ? _c("v-carousel", {
      attrs: {
        "hide-delimiters": "",
        height: "100%"
      }
    }, _vm._l(product.image_for_menus, function (item, i) {
      return _c("v-carousel-item", {
        key: i,
        attrs: {
          src: "https://drive.google.com/thumbnail?id=".concat(item.google_image.src_name, "&sz=w500-h500")
        }
      }, [_c("v-btn", {
        staticClass: "deep-orange mt-3 ml-3 font-weight-bold",
        attrs: {
          outlined: "",
          dark: "",
          "x-small": ""
        }
      }, [_vm._v("#" + _vm._s(product.id))])], 1);
    }), 1) : _c("imageThumbnailFullPathSizeFree", {
      attrs: {
        path: product.image_for_menus[0],
        size: 500,
        propID: product.id
      }
    }), _vm._v(" "), product.order_detail_id == null ? _c("v-card-text", [_c("div", {
      staticClass: "d-flex flex-row text-body-2 font-weight-black"
    }, [_vm._v("\n                        " + _vm._s(product.a_price.name_goods) + "\n                    ")]), _vm._v(" "), _c("div", {
      staticClass: "d-flex flex-row text-body-2 my-1 font-weight-bold deep-orange--text"
    }, [_vm._v("\n                        ฿" + _vm._s(_vm._f("formatNumber")(product.sum_price_for_menu)) + "\n                        ")]), _vm._v(" "), product.add_ons.length > 0 ? _c("div", {
      staticClass: "mt-1"
    }, [_c("v-divider", {
      staticClass: "my-2"
    }), _vm._v(" "), _c("strong", [_vm._v("เพิ่มเติม : ")]), _vm._v("\n\n                        " + _vm._s(_vm.convert_add_on_name(product.add_ons)) + "\n                    ")], 1) : _vm._e(), _vm._v(" "), product.order_tags.length > 0 ? _c("div", {
      staticClass: "mt-1"
    }, [_c("v-divider", {
      staticClass: "my-2"
    }), _vm._v(" "), _c("strong", [_vm._v("แท็ก : ")]), _vm._v("\n\n                        " + _vm._s(_vm.convert_tags(product.order_tags)) + "\n                    ")], 1) : _vm._e()]) : _c("v-card-text", [_c("div", {
      staticClass: "d-flex flex-row text-body-2 font-weight-black"
    }, [_vm._v("\n                        เค้ก " + _vm._s(product.multi_cakes.length) + " ชั้น\n                    ")]), _vm._v(" "), _c("div", {
      staticClass: "d-flex flex-row text-body-2 my-1 font-weight-bold deep-orange--text"
    }, [_vm.user.type == 1 ? _c("div", [_vm._v("\n                            ฿" + _vm._s(_vm._f("formatNumber")(product.sum_price_multi_cake_for_menu)) + "\n                        ")]) : _c("div", [_vm._v("โปรดสอบถามราคา")])]), _vm._v(" "), _vm._l(product.multi_cakes, function (multi_cake) {
      return _c("div", {
        key: multi_cake.id
      }, [_c("v-divider", {
        staticClass: "my-2"
      }), _vm._v(" "), _c("div", {
        staticClass: "mt-1"
      }, [_c("strong", [_vm._v("ชั้นที่ : ")]), _vm._v("\n                            " + _vm._s(multi_cake.sort_group_multi_cake) + "\n                        ")]), _vm._v(" "), _c("div", {
        staticClass: "d-flex flex-row text-body-2 font-weight-black"
      }, [_vm._v("\n                            " + _vm._s(multi_cake.a_price.name_goods) + "\n                        ")]), _vm._v(" "), multi_cake.add_ons.length > 0 ? _c("div", {
        staticClass: "mt-1"
      }, [_c("strong", [_vm._v("เพิ่มเติม : ")]), _vm._v("\n\n                            " + _vm._s(_vm.convert_add_on_name(multi_cake.add_ons)) + "\n                        ")]) : _vm._e()], 1);
    }), _vm._v(" "), _c("v-divider", {
      staticClass: "my-2"
    }), _vm._v(" "), product.order_tags.length > 0 ? _c("div", {
      staticClass: "mt-1"
    }, [_c("strong", [_vm._v("แท็ก : ")]), _vm._v("\n\n                        " + _vm._s(_vm.convert_tags(product.order_tags)) + "\n                    ")]) : _vm._e()], 2), _vm._v(" "), _vm.user.type == 1 ? _c("v-card-actions", [_c("v-btn", {
      attrs: {
        block: "",
        outlined: "",
        color: "primary"
      },
      on: {
        click: function click($event) {
          return _vm.clickToOrder(product.order_id);
        }
      }
    }, [_vm._v("ไปยังออร์เดอร์")])], 1) : _vm._e()], 1)], 1);
  }), 1)], 1);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("p", {
    staticClass: "text-subtitle-2 mb-0"
  }, [_c("strong", [_vm._v("*ไม่มีนโยบายคืนเงินทุกกรณี*")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("p", {
    staticClass: "text-subtitle-2"
  }, [_c("strong", [_vm._v("*ราคาสินค้ารวมภาษีมูลค่าเพิ่ม 7%*")])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/components/google/drive/imageThumbnailFullPathSizeFree.vue":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/google/drive/imageThumbnailFullPathSizeFree.vue ***!
  \*********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _imageThumbnailFullPathSizeFree_vue_vue_type_template_id_4ed1cd32__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./imageThumbnailFullPathSizeFree.vue?vue&type=template&id=4ed1cd32 */ "./resources/js/components/google/drive/imageThumbnailFullPathSizeFree.vue?vue&type=template&id=4ed1cd32");
/* harmony import */ var _imageThumbnailFullPathSizeFree_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./imageThumbnailFullPathSizeFree.vue?vue&type=script&lang=js */ "./resources/js/components/google/drive/imageThumbnailFullPathSizeFree.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _imageThumbnailFullPathSizeFree_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _imageThumbnailFullPathSizeFree_vue_vue_type_template_id_4ed1cd32__WEBPACK_IMPORTED_MODULE_0__["render"],
  _imageThumbnailFullPathSizeFree_vue_vue_type_template_id_4ed1cd32__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/google/drive/imageThumbnailFullPathSizeFree.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/google/drive/imageThumbnailFullPathSizeFree.vue?vue&type=script&lang=js":
/*!*********************************************************************************************************!*\
  !*** ./resources/js/components/google/drive/imageThumbnailFullPathSizeFree.vue?vue&type=script&lang=js ***!
  \*********************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_imageThumbnailFullPathSizeFree_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./imageThumbnailFullPathSizeFree.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/google/drive/imageThumbnailFullPathSizeFree.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_imageThumbnailFullPathSizeFree_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/google/drive/imageThumbnailFullPathSizeFree.vue?vue&type=template&id=4ed1cd32":
/*!***************************************************************************************************************!*\
  !*** ./resources/js/components/google/drive/imageThumbnailFullPathSizeFree.vue?vue&type=template&id=4ed1cd32 ***!
  \***************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_imageThumbnailFullPathSizeFree_vue_vue_type_template_id_4ed1cd32__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../../node_modules/vue-loader/lib??vue-loader-options!./imageThumbnailFullPathSizeFree.vue?vue&type=template&id=4ed1cd32 */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/google/drive/imageThumbnailFullPathSizeFree.vue?vue&type=template&id=4ed1cd32");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_imageThumbnailFullPathSizeFree_vue_vue_type_template_id_4ed1cd32__WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_imageThumbnailFullPathSizeFree_vue_vue_type_template_id_4ed1cd32__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/pages/punpang/menuOrder.vue":
/*!**************************************************!*\
  !*** ./resources/js/pages/punpang/menuOrder.vue ***!
  \**************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _menuOrder_vue_vue_type_template_id_30e3c87a__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./menuOrder.vue?vue&type=template&id=30e3c87a */ "./resources/js/pages/punpang/menuOrder.vue?vue&type=template&id=30e3c87a");
/* harmony import */ var _menuOrder_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./menuOrder.vue?vue&type=script&lang=js */ "./resources/js/pages/punpang/menuOrder.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _menuOrder_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _menuOrder_vue_vue_type_template_id_30e3c87a__WEBPACK_IMPORTED_MODULE_0__["render"],
  _menuOrder_vue_vue_type_template_id_30e3c87a__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/punpang/menuOrder.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/pages/punpang/menuOrder.vue?vue&type=script&lang=js":
/*!**************************************************************************!*\
  !*** ./resources/js/pages/punpang/menuOrder.vue?vue&type=script&lang=js ***!
  \**************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_menuOrder_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./menuOrder.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/punpang/menuOrder.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_menuOrder_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/punpang/menuOrder.vue?vue&type=template&id=30e3c87a":
/*!********************************************************************************!*\
  !*** ./resources/js/pages/punpang/menuOrder.vue?vue&type=template&id=30e3c87a ***!
  \********************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_menuOrder_vue_vue_type_template_id_30e3c87a__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../node_modules/vue-loader/lib??vue-loader-options!./menuOrder.vue?vue&type=template&id=30e3c87a */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/punpang/menuOrder.vue?vue&type=template&id=30e3c87a");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_menuOrder_vue_vue_type_template_id_30e3c87a__WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_menuOrder_vue_vue_type_template_id_30e3c87a__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);
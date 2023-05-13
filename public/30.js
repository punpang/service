(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[30],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/google/drive/imageThumbnailFullPathSizeFree.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/google/drive/imageThumbnailFullPathSizeFree.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["path", "size", "propID"]
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/punpang/menuOrder.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/punpang/menuOrder.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
/* harmony import */ var _js_components_google_drive_imageThumbnailFullPathSizeFree__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @/js/components/google/drive/imageThumbnailFullPathSizeFree */ "./resources/js/components/google/drive/imageThumbnailFullPathSizeFree.vue");
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }
function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }
function _defineProperty(obj, key, value) { key = _toPropertyKey(key); if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return exports; }; var exports = {}, Op = Object.prototype, hasOwn = Op.hasOwnProperty, defineProperty = Object.defineProperty || function (obj, key, desc) { obj[key] = desc.value; }, $Symbol = "function" == typeof Symbol ? Symbol : {}, iteratorSymbol = $Symbol.iterator || "@@iterator", asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator", toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag"; function define(obj, key, value) { return Object.defineProperty(obj, key, { value: value, enumerable: !0, configurable: !0, writable: !0 }), obj[key]; } try { define({}, ""); } catch (err) { define = function define(obj, key, value) { return obj[key] = value; }; } function wrap(innerFn, outerFn, self, tryLocsList) { var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator, generator = Object.create(protoGenerator.prototype), context = new Context(tryLocsList || []); return defineProperty(generator, "_invoke", { value: makeInvokeMethod(innerFn, self, context) }), generator; } function tryCatch(fn, obj, arg) { try { return { type: "normal", arg: fn.call(obj, arg) }; } catch (err) { return { type: "throw", arg: err }; } } exports.wrap = wrap; var ContinueSentinel = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var IteratorPrototype = {}; define(IteratorPrototype, iteratorSymbol, function () { return this; }); var getProto = Object.getPrototypeOf, NativeIteratorPrototype = getProto && getProto(getProto(values([]))); NativeIteratorPrototype && NativeIteratorPrototype !== Op && hasOwn.call(NativeIteratorPrototype, iteratorSymbol) && (IteratorPrototype = NativeIteratorPrototype); var Gp = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(IteratorPrototype); function defineIteratorMethods(prototype) { ["next", "throw", "return"].forEach(function (method) { define(prototype, method, function (arg) { return this._invoke(method, arg); }); }); } function AsyncIterator(generator, PromiseImpl) { function invoke(method, arg, resolve, reject) { var record = tryCatch(generator[method], generator, arg); if ("throw" !== record.type) { var result = record.arg, value = result.value; return value && "object" == _typeof(value) && hasOwn.call(value, "__await") ? PromiseImpl.resolve(value.__await).then(function (value) { invoke("next", value, resolve, reject); }, function (err) { invoke("throw", err, resolve, reject); }) : PromiseImpl.resolve(value).then(function (unwrapped) { result.value = unwrapped, resolve(result); }, function (error) { return invoke("throw", error, resolve, reject); }); } reject(record.arg); } var previousPromise; defineProperty(this, "_invoke", { value: function value(method, arg) { function callInvokeWithMethodAndArg() { return new PromiseImpl(function (resolve, reject) { invoke(method, arg, resolve, reject); }); } return previousPromise = previousPromise ? previousPromise.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(innerFn, self, context) { var state = "suspendedStart"; return function (method, arg) { if ("executing" === state) throw new Error("Generator is already running"); if ("completed" === state) { if ("throw" === method) throw arg; return doneResult(); } for (context.method = method, context.arg = arg;;) { var delegate = context.delegate; if (delegate) { var delegateResult = maybeInvokeDelegate(delegate, context); if (delegateResult) { if (delegateResult === ContinueSentinel) continue; return delegateResult; } } if ("next" === context.method) context.sent = context._sent = context.arg;else if ("throw" === context.method) { if ("suspendedStart" === state) throw state = "completed", context.arg; context.dispatchException(context.arg); } else "return" === context.method && context.abrupt("return", context.arg); state = "executing"; var record = tryCatch(innerFn, self, context); if ("normal" === record.type) { if (state = context.done ? "completed" : "suspendedYield", record.arg === ContinueSentinel) continue; return { value: record.arg, done: context.done }; } "throw" === record.type && (state = "completed", context.method = "throw", context.arg = record.arg); } }; } function maybeInvokeDelegate(delegate, context) { var methodName = context.method, method = delegate.iterator[methodName]; if (undefined === method) return context.delegate = null, "throw" === methodName && delegate.iterator["return"] && (context.method = "return", context.arg = undefined, maybeInvokeDelegate(delegate, context), "throw" === context.method) || "return" !== methodName && (context.method = "throw", context.arg = new TypeError("The iterator does not provide a '" + methodName + "' method")), ContinueSentinel; var record = tryCatch(method, delegate.iterator, context.arg); if ("throw" === record.type) return context.method = "throw", context.arg = record.arg, context.delegate = null, ContinueSentinel; var info = record.arg; return info ? info.done ? (context[delegate.resultName] = info.value, context.next = delegate.nextLoc, "return" !== context.method && (context.method = "next", context.arg = undefined), context.delegate = null, ContinueSentinel) : info : (context.method = "throw", context.arg = new TypeError("iterator result is not an object"), context.delegate = null, ContinueSentinel); } function pushTryEntry(locs) { var entry = { tryLoc: locs[0] }; 1 in locs && (entry.catchLoc = locs[1]), 2 in locs && (entry.finallyLoc = locs[2], entry.afterLoc = locs[3]), this.tryEntries.push(entry); } function resetTryEntry(entry) { var record = entry.completion || {}; record.type = "normal", delete record.arg, entry.completion = record; } function Context(tryLocsList) { this.tryEntries = [{ tryLoc: "root" }], tryLocsList.forEach(pushTryEntry, this), this.reset(!0); } function values(iterable) { if (iterable) { var iteratorMethod = iterable[iteratorSymbol]; if (iteratorMethod) return iteratorMethod.call(iterable); if ("function" == typeof iterable.next) return iterable; if (!isNaN(iterable.length)) { var i = -1, next = function next() { for (; ++i < iterable.length;) if (hasOwn.call(iterable, i)) return next.value = iterable[i], next.done = !1, next; return next.value = undefined, next.done = !0, next; }; return next.next = next; } } return { next: doneResult }; } function doneResult() { return { value: undefined, done: !0 }; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, defineProperty(Gp, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), defineProperty(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, toStringTagSymbol, "GeneratorFunction"), exports.isGeneratorFunction = function (genFun) { var ctor = "function" == typeof genFun && genFun.constructor; return !!ctor && (ctor === GeneratorFunction || "GeneratorFunction" === (ctor.displayName || ctor.name)); }, exports.mark = function (genFun) { return Object.setPrototypeOf ? Object.setPrototypeOf(genFun, GeneratorFunctionPrototype) : (genFun.__proto__ = GeneratorFunctionPrototype, define(genFun, toStringTagSymbol, "GeneratorFunction")), genFun.prototype = Object.create(Gp), genFun; }, exports.awrap = function (arg) { return { __await: arg }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, asyncIteratorSymbol, function () { return this; }), exports.AsyncIterator = AsyncIterator, exports.async = function (innerFn, outerFn, self, tryLocsList, PromiseImpl) { void 0 === PromiseImpl && (PromiseImpl = Promise); var iter = new AsyncIterator(wrap(innerFn, outerFn, self, tryLocsList), PromiseImpl); return exports.isGeneratorFunction(outerFn) ? iter : iter.next().then(function (result) { return result.done ? result.value : iter.next(); }); }, defineIteratorMethods(Gp), define(Gp, toStringTagSymbol, "Generator"), define(Gp, iteratorSymbol, function () { return this; }), define(Gp, "toString", function () { return "[object Generator]"; }), exports.keys = function (val) { var object = Object(val), keys = []; for (var key in object) keys.push(key); return keys.reverse(), function next() { for (; keys.length;) { var key = keys.pop(); if (key in object) return next.value = key, next.done = !1, next; } return next.done = !0, next; }; }, exports.values = values, Context.prototype = { constructor: Context, reset: function reset(skipTempReset) { if (this.prev = 0, this.next = 0, this.sent = this._sent = undefined, this.done = !1, this.delegate = null, this.method = "next", this.arg = undefined, this.tryEntries.forEach(resetTryEntry), !skipTempReset) for (var name in this) "t" === name.charAt(0) && hasOwn.call(this, name) && !isNaN(+name.slice(1)) && (this[name] = undefined); }, stop: function stop() { this.done = !0; var rootRecord = this.tryEntries[0].completion; if ("throw" === rootRecord.type) throw rootRecord.arg; return this.rval; }, dispatchException: function dispatchException(exception) { if (this.done) throw exception; var context = this; function handle(loc, caught) { return record.type = "throw", record.arg = exception, context.next = loc, caught && (context.method = "next", context.arg = undefined), !!caught; } for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i], record = entry.completion; if ("root" === entry.tryLoc) return handle("end"); if (entry.tryLoc <= this.prev) { var hasCatch = hasOwn.call(entry, "catchLoc"), hasFinally = hasOwn.call(entry, "finallyLoc"); if (hasCatch && hasFinally) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } else if (hasCatch) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); } else { if (!hasFinally) throw new Error("try statement without catch or finally"); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } } } }, abrupt: function abrupt(type, arg) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc <= this.prev && hasOwn.call(entry, "finallyLoc") && this.prev < entry.finallyLoc) { var finallyEntry = entry; break; } } finallyEntry && ("break" === type || "continue" === type) && finallyEntry.tryLoc <= arg && arg <= finallyEntry.finallyLoc && (finallyEntry = null); var record = finallyEntry ? finallyEntry.completion : {}; return record.type = type, record.arg = arg, finallyEntry ? (this.method = "next", this.next = finallyEntry.finallyLoc, ContinueSentinel) : this.complete(record); }, complete: function complete(record, afterLoc) { if ("throw" === record.type) throw record.arg; return "break" === record.type || "continue" === record.type ? this.next = record.arg : "return" === record.type ? (this.rval = this.arg = record.arg, this.method = "return", this.next = "end") : "normal" === record.type && afterLoc && (this.next = afterLoc), ContinueSentinel; }, finish: function finish(finallyLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.finallyLoc === finallyLoc) return this.complete(entry.completion, entry.afterLoc), resetTryEntry(entry), ContinueSentinel; } }, "catch": function _catch(tryLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc === tryLoc) { var record = entry.completion; if ("throw" === record.type) { var thrown = record.arg; resetTryEntry(entry); } return thrown; } } throw new Error("illegal catch attempt"); }, delegateYield: function delegateYield(iterable, resultName, nextLoc) { return this.delegate = { iterator: values(iterable), resultName: resultName, nextLoc: nextLoc }, "next" === this.method && (this.arg = undefined), ContinueSentinel; } }, exports; }
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
            payload = "whereHas=imageForMenus,with=imageForMenus".concat(tags).concat(price_rank);
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

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/google/drive/imageThumbnailFullPathSizeFree.vue?vue&type=template&id=4ed1cd32&":
/*!****************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/google/drive/imageThumbnailFullPathSizeFree.vue?vue&type=template&id=4ed1cd32& ***!
  \****************************************************************************************************************************************************************************************************************************************************************************/
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

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/punpang/menuOrder.vue?vue&type=template&id=30e3c87a&":
/*!*********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/punpang/menuOrder.vue?vue&type=template&id=30e3c87a& ***!
  \*********************************************************************************************************************************************************************************************************************************************/
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
  }, [_vm._v("สั่งซื้อวันนี้ รับราคาพิเศษ")]), _vm._v(" "), _vm._m(0), _vm._v(" "), _vm.user.type == 1 ? _c("v-card", {
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
    }), _vm._v(" "), _c("v-card-text", [_c("div", {
      staticClass: "d-flex flex-row text-body-2 font-weight-black"
    }, [_vm._v("\n                        " + _vm._s(product.a_price.name_goods) + "\n                    ")]), _vm._v(" "), _c("div", {
      staticClass: "d-flex flex-row text-body-2 my-1 font-weight-bold deep-orange--text"
    }, [_vm._v("\n                        ฿" + _vm._s(_vm._f("formatNumber")(product.sum_price_for_menu)) + "\n                    ")]), _vm._v(" "), product.add_ons.length > 0 ? _c("div", {
      staticClass: "mt-1"
    }, [_c("strong", [_vm._v("เพิ่มเติม : ")]), _vm._v("\n\n                        " + _vm._s(_vm.convert_add_on_name(product.add_ons)) + "\n                    ")]) : _vm._e(), _vm._v(" "), product.order_tags.length > 0 ? _c("div", {
      staticClass: "mt-1"
    }, [_c("strong", [_vm._v("แท็ก : ")]), _vm._v("\n\n                        " + _vm._s(_vm.convert_tags(product.order_tags)) + "\n                    ")]) : _vm._e()]), _vm._v(" "), _vm.user.type == 1 ? _c("v-card-actions", [_c("v-btn", {
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
    staticClass: "text-subtitle-2"
  }, [_c("strong", [_vm._v("*ไม่มีนโยบายคืนเงินทุกกรณี*")])]);
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
/* harmony import */ var _imageThumbnailFullPathSizeFree_vue_vue_type_template_id_4ed1cd32___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./imageThumbnailFullPathSizeFree.vue?vue&type=template&id=4ed1cd32& */ "./resources/js/components/google/drive/imageThumbnailFullPathSizeFree.vue?vue&type=template&id=4ed1cd32&");
/* harmony import */ var _imageThumbnailFullPathSizeFree_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./imageThumbnailFullPathSizeFree.vue?vue&type=script&lang=js& */ "./resources/js/components/google/drive/imageThumbnailFullPathSizeFree.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _imageThumbnailFullPathSizeFree_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _imageThumbnailFullPathSizeFree_vue_vue_type_template_id_4ed1cd32___WEBPACK_IMPORTED_MODULE_0__["render"],
  _imageThumbnailFullPathSizeFree_vue_vue_type_template_id_4ed1cd32___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
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

/***/ "./resources/js/components/google/drive/imageThumbnailFullPathSizeFree.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************!*\
  !*** ./resources/js/components/google/drive/imageThumbnailFullPathSizeFree.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_imageThumbnailFullPathSizeFree_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./imageThumbnailFullPathSizeFree.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/google/drive/imageThumbnailFullPathSizeFree.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_imageThumbnailFullPathSizeFree_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/google/drive/imageThumbnailFullPathSizeFree.vue?vue&type=template&id=4ed1cd32&":
/*!****************************************************************************************************************!*\
  !*** ./resources/js/components/google/drive/imageThumbnailFullPathSizeFree.vue?vue&type=template&id=4ed1cd32& ***!
  \****************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_imageThumbnailFullPathSizeFree_vue_vue_type_template_id_4ed1cd32___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../../node_modules/vue-loader/lib??vue-loader-options!./imageThumbnailFullPathSizeFree.vue?vue&type=template&id=4ed1cd32& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/google/drive/imageThumbnailFullPathSizeFree.vue?vue&type=template&id=4ed1cd32&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_imageThumbnailFullPathSizeFree_vue_vue_type_template_id_4ed1cd32___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_imageThumbnailFullPathSizeFree_vue_vue_type_template_id_4ed1cd32___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/pages/punpang/menuOrder.vue":
/*!**************************************************!*\
  !*** ./resources/js/pages/punpang/menuOrder.vue ***!
  \**************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _menuOrder_vue_vue_type_template_id_30e3c87a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./menuOrder.vue?vue&type=template&id=30e3c87a& */ "./resources/js/pages/punpang/menuOrder.vue?vue&type=template&id=30e3c87a&");
/* harmony import */ var _menuOrder_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./menuOrder.vue?vue&type=script&lang=js& */ "./resources/js/pages/punpang/menuOrder.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _menuOrder_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _menuOrder_vue_vue_type_template_id_30e3c87a___WEBPACK_IMPORTED_MODULE_0__["render"],
  _menuOrder_vue_vue_type_template_id_30e3c87a___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
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

/***/ "./resources/js/pages/punpang/menuOrder.vue?vue&type=script&lang=js&":
/*!***************************************************************************!*\
  !*** ./resources/js/pages/punpang/menuOrder.vue?vue&type=script&lang=js& ***!
  \***************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_menuOrder_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./menuOrder.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/punpang/menuOrder.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_menuOrder_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/punpang/menuOrder.vue?vue&type=template&id=30e3c87a&":
/*!*********************************************************************************!*\
  !*** ./resources/js/pages/punpang/menuOrder.vue?vue&type=template&id=30e3c87a& ***!
  \*********************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_menuOrder_vue_vue_type_template_id_30e3c87a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../node_modules/vue-loader/lib??vue-loader-options!./menuOrder.vue?vue&type=template&id=30e3c87a& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/punpang/menuOrder.vue?vue&type=template&id=30e3c87a&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_menuOrder_vue_vue_type_template_id_30e3c87a___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_menuOrder_vue_vue_type_template_id_30e3c87a___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);
(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[56],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/order/alertPaymentByOrderID.vue?vue&type=script&lang=js":
/*!********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/order/alertPaymentByOrderID.vue?vue&type=script&lang=js ***!
  \********************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function ownKeys(e, r) { var t = Object.keys(e); if (Object.getOwnPropertySymbols) { var o = Object.getOwnPropertySymbols(e); r && (o = o.filter(function (r) { return Object.getOwnPropertyDescriptor(e, r).enumerable; })), t.push.apply(t, o); } return t; }
function _objectSpread(e) { for (var r = 1; r < arguments.length; r++) { var t = null != arguments[r] ? arguments[r] : {}; r % 2 ? ownKeys(Object(t), !0).forEach(function (r) { _defineProperty(e, r, t[r]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(t)) : ownKeys(Object(t)).forEach(function (r) { Object.defineProperty(e, r, Object.getOwnPropertyDescriptor(t, r)); }); } return e; }
function _defineProperty(obj, key, value) { key = _toPropertyKey(key); if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return e; }; var t, e = {}, r = Object.prototype, n = r.hasOwnProperty, o = Object.defineProperty || function (t, e, r) { t[e] = r.value; }, i = "function" == typeof Symbol ? Symbol : {}, a = i.iterator || "@@iterator", c = i.asyncIterator || "@@asyncIterator", u = i.toStringTag || "@@toStringTag"; function define(t, e, r) { return Object.defineProperty(t, e, { value: r, enumerable: !0, configurable: !0, writable: !0 }), t[e]; } try { define({}, ""); } catch (t) { define = function define(t, e, r) { return t[e] = r; }; } function wrap(t, e, r, n) { var i = e && e.prototype instanceof Generator ? e : Generator, a = Object.create(i.prototype), c = new Context(n || []); return o(a, "_invoke", { value: makeInvokeMethod(t, r, c) }), a; } function tryCatch(t, e, r) { try { return { type: "normal", arg: t.call(e, r) }; } catch (t) { return { type: "throw", arg: t }; } } e.wrap = wrap; var h = "suspendedStart", l = "suspendedYield", f = "executing", s = "completed", y = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var p = {}; define(p, a, function () { return this; }); var d = Object.getPrototypeOf, v = d && d(d(values([]))); v && v !== r && n.call(v, a) && (p = v); var g = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(p); function defineIteratorMethods(t) { ["next", "throw", "return"].forEach(function (e) { define(t, e, function (t) { return this._invoke(e, t); }); }); } function AsyncIterator(t, e) { function invoke(r, o, i, a) { var c = tryCatch(t[r], t, o); if ("throw" !== c.type) { var u = c.arg, h = u.value; return h && "object" == _typeof(h) && n.call(h, "__await") ? e.resolve(h.__await).then(function (t) { invoke("next", t, i, a); }, function (t) { invoke("throw", t, i, a); }) : e.resolve(h).then(function (t) { u.value = t, i(u); }, function (t) { return invoke("throw", t, i, a); }); } a(c.arg); } var r; o(this, "_invoke", { value: function value(t, n) { function callInvokeWithMethodAndArg() { return new e(function (e, r) { invoke(t, n, e, r); }); } return r = r ? r.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(e, r, n) { var o = h; return function (i, a) { if (o === f) throw Error("Generator is already running"); if (o === s) { if ("throw" === i) throw a; return { value: t, done: !0 }; } for (n.method = i, n.arg = a;;) { var c = n.delegate; if (c) { var u = maybeInvokeDelegate(c, n); if (u) { if (u === y) continue; return u; } } if ("next" === n.method) n.sent = n._sent = n.arg;else if ("throw" === n.method) { if (o === h) throw o = s, n.arg; n.dispatchException(n.arg); } else "return" === n.method && n.abrupt("return", n.arg); o = f; var p = tryCatch(e, r, n); if ("normal" === p.type) { if (o = n.done ? s : l, p.arg === y) continue; return { value: p.arg, done: n.done }; } "throw" === p.type && (o = s, n.method = "throw", n.arg = p.arg); } }; } function maybeInvokeDelegate(e, r) { var n = r.method, o = e.iterator[n]; if (o === t) return r.delegate = null, "throw" === n && e.iterator["return"] && (r.method = "return", r.arg = t, maybeInvokeDelegate(e, r), "throw" === r.method) || "return" !== n && (r.method = "throw", r.arg = new TypeError("The iterator does not provide a '" + n + "' method")), y; var i = tryCatch(o, e.iterator, r.arg); if ("throw" === i.type) return r.method = "throw", r.arg = i.arg, r.delegate = null, y; var a = i.arg; return a ? a.done ? (r[e.resultName] = a.value, r.next = e.nextLoc, "return" !== r.method && (r.method = "next", r.arg = t), r.delegate = null, y) : a : (r.method = "throw", r.arg = new TypeError("iterator result is not an object"), r.delegate = null, y); } function pushTryEntry(t) { var e = { tryLoc: t[0] }; 1 in t && (e.catchLoc = t[1]), 2 in t && (e.finallyLoc = t[2], e.afterLoc = t[3]), this.tryEntries.push(e); } function resetTryEntry(t) { var e = t.completion || {}; e.type = "normal", delete e.arg, t.completion = e; } function Context(t) { this.tryEntries = [{ tryLoc: "root" }], t.forEach(pushTryEntry, this), this.reset(!0); } function values(e) { if (e || "" === e) { var r = e[a]; if (r) return r.call(e); if ("function" == typeof e.next) return e; if (!isNaN(e.length)) { var o = -1, i = function next() { for (; ++o < e.length;) if (n.call(e, o)) return next.value = e[o], next.done = !1, next; return next.value = t, next.done = !0, next; }; return i.next = i; } } throw new TypeError(_typeof(e) + " is not iterable"); } return GeneratorFunction.prototype = GeneratorFunctionPrototype, o(g, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), o(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, u, "GeneratorFunction"), e.isGeneratorFunction = function (t) { var e = "function" == typeof t && t.constructor; return !!e && (e === GeneratorFunction || "GeneratorFunction" === (e.displayName || e.name)); }, e.mark = function (t) { return Object.setPrototypeOf ? Object.setPrototypeOf(t, GeneratorFunctionPrototype) : (t.__proto__ = GeneratorFunctionPrototype, define(t, u, "GeneratorFunction")), t.prototype = Object.create(g), t; }, e.awrap = function (t) { return { __await: t }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, c, function () { return this; }), e.AsyncIterator = AsyncIterator, e.async = function (t, r, n, o, i) { void 0 === i && (i = Promise); var a = new AsyncIterator(wrap(t, r, n, o), i); return e.isGeneratorFunction(r) ? a : a.next().then(function (t) { return t.done ? t.value : a.next(); }); }, defineIteratorMethods(g), define(g, u, "Generator"), define(g, a, function () { return this; }), define(g, "toString", function () { return "[object Generator]"; }), e.keys = function (t) { var e = Object(t), r = []; for (var n in e) r.push(n); return r.reverse(), function next() { for (; r.length;) { var t = r.pop(); if (t in e) return next.value = t, next.done = !1, next; } return next.done = !0, next; }; }, e.values = values, Context.prototype = { constructor: Context, reset: function reset(e) { if (this.prev = 0, this.next = 0, this.sent = this._sent = t, this.done = !1, this.delegate = null, this.method = "next", this.arg = t, this.tryEntries.forEach(resetTryEntry), !e) for (var r in this) "t" === r.charAt(0) && n.call(this, r) && !isNaN(+r.slice(1)) && (this[r] = t); }, stop: function stop() { this.done = !0; var t = this.tryEntries[0].completion; if ("throw" === t.type) throw t.arg; return this.rval; }, dispatchException: function dispatchException(e) { if (this.done) throw e; var r = this; function handle(n, o) { return a.type = "throw", a.arg = e, r.next = n, o && (r.method = "next", r.arg = t), !!o; } for (var o = this.tryEntries.length - 1; o >= 0; --o) { var i = this.tryEntries[o], a = i.completion; if ("root" === i.tryLoc) return handle("end"); if (i.tryLoc <= this.prev) { var c = n.call(i, "catchLoc"), u = n.call(i, "finallyLoc"); if (c && u) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } else if (c) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); } else { if (!u) throw Error("try statement without catch or finally"); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } } } }, abrupt: function abrupt(t, e) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var o = this.tryEntries[r]; if (o.tryLoc <= this.prev && n.call(o, "finallyLoc") && this.prev < o.finallyLoc) { var i = o; break; } } i && ("break" === t || "continue" === t) && i.tryLoc <= e && e <= i.finallyLoc && (i = null); var a = i ? i.completion : {}; return a.type = t, a.arg = e, i ? (this.method = "next", this.next = i.finallyLoc, y) : this.complete(a); }, complete: function complete(t, e) { if ("throw" === t.type) throw t.arg; return "break" === t.type || "continue" === t.type ? this.next = t.arg : "return" === t.type ? (this.rval = this.arg = t.arg, this.method = "return", this.next = "end") : "normal" === t.type && e && (this.next = e), y; }, finish: function finish(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.finallyLoc === t) return this.complete(r.completion, r.afterLoc), resetTryEntry(r), y; } }, "catch": function _catch(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.tryLoc === t) { var n = r.completion; if ("throw" === n.type) { var o = n.arg; resetTryEntry(r); } return o; } } throw Error("illegal catch attempt"); }, delegateYield: function delegateYield(e, r, n) { return this.delegate = { iterator: values(e), resultName: r, nextLoc: n }, "next" === this.method && (this.arg = t), y; } }, e; }
function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }
function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      timeOptions: [{
        id: 1,
        text: "15 นาที",
        status_use: 1
      }, {
        id: 2,
        text: "30 นาที",
        status_use: 1
      }, {
        id: 3,
        text: "1 ชั่วโมง",
        status_use: 1
      }, {
        id: 4,
        text: "3 ชั่วโมง",
        status_use: 1
      }, {
        id: 5,
        text: "6 ชั่วโมง",
        status_use: 1
      }, {
        id: 6,
        text: "ก่อนวันรับสินค้า",
        status_use: 1
      }],
      dateTimeForPay: "",
      status_full_payment: 0,
      alertSMSToCustomer: 1
    };
  },
  methods: {
    clickAlertPaymentByOrderID: function clickAlertPaymentByOrderID() {
      var _this = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
        var loader, payload, res;
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              loader = _this.$loading.show();
              payload = {
                orderID: _this.order.id,
                payment_deadline: _this.dateTimeForPay,
                status_full_payment: _this.status_full_payment
              };
              res = _this.$store.dispatch("orderIndex/alertPaymentByOrderID", payload);
              loader.hide();
              console.log(res);
            case 5:
            case "end":
              return _context.stop();
          }
        }, _callee);
      }))();
    },
    detailText: function detailText() {
      var detail = "";
      //   if (
      //     this.order.m1 === 99 ||
      //     this.order.m2 === 99 ||
      //     this.order.m3 === 99 ||
      //     this.order.m4 === 99
      //   ) {
      //     detail = "";
      //   } else {
      //     detail = `${this.order.am1.m1}:${this.order.am2.m2}:${this.order.am3.m3}:${this.order.am4.m4}`;
      //   }

      var other = "\nthis.order.other";
      if (this.order.other === "-") {
        other = "";
      }
      var message = "\n\n\uD83D\uDCCC \u0E40\u0E02\u0E35\u0E22\u0E19\u0E02\u0E49\u0E2D\u0E04\u0E27\u0E32\u0E21\n".concat(this.order.msg);
      if (this.order.msg === "-") {
        message = "";
      }
      var sumUp = this.order.total + this.order.add;
      return "\n      \uD83D\uDCCC \u0E2B\u0E21\u0E32\u0E22\u0E40\u0E25\u0E02\u0E04\u0E33\u0E2A\u0E31\u0E48\u0E07\u0E0B\u0E37\u0E49\u0E2D #".concat(this.order.id, "\n\n\uD83D\uDCCC\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E25\u0E39\u0E01\u0E04\u0E49\u0E32\n\u0E04\u0E38\u0E13 ").concat(this.order.customer.name, "\n\u0E2B\u0E21\u0E32\u0E22\u0E40\u0E25\u0E02\u0E42\u0E17\u0E23\u0E28\u0E31\u0E1E\u0E17\u0E4C ").concat(this.order.customer.tel, "\n\n\uD83D\uDCCC \u0E27\u0E31\u0E19-\u0E40\u0E27\u0E25\u0E32\u0E19\u0E31\u0E14\u0E23\u0E31\u0E1A\u0E2A\u0E34\u0E19\u0E04\u0E49\u0E32\n").concat(this.order.date_get, " ").concat(this.order.time_get, "\n\n\uD83D\uDCCC \u0E23\u0E32\u0E22\u0E25\u0E30\u0E40\u0E2D\u0E35\u0E22\u0E14\u0E23\u0E32\u0E22\u0E01\u0E32\u0E23\u0E2A\u0E31\u0E48\u0E07\u0E0B\u0E37\u0E49\u0E2D\n").concat(detail).concat(other).concat(message, "\n\n\uD83D\uDCCC \u0E22\u0E2D\u0E14\u0E23\u0E27\u0E21\u0E17\u0E31\u0E49\u0E07\u0E2B\u0E21\u0E14 ").concat(sumUp, " \u0E1A\u0E32\u0E17\n\n\uD83D\uDCCC \u0E42\u0E1B\u0E23\u0E14\u0E0A\u0E33\u0E23\u0E30\u0E40\u0E07\u0E34\u0E19\u0E20\u0E32\u0E22\u0E43\u0E19\n").concat(this.dateTimeForPay, "\n\n\uD83D\uDCCC \u0E27\u0E34\u0E18\u0E35\u0E0A\u0E33\u0E23\u0E30\u0E40\u0E07\u0E34\u0E19\n\u0E01\u0E14\u0E17\u0E35\u0E48\u0E25\u0E34\u0E07\u0E01\u0E4C\u0E40\u0E1E\u0E37\u0E48\u0E2D\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A\u0E23\u0E32\u0E22\u0E25\u0E30\u0E40\u0E2D\u0E35\u0E22\u0E14\u0E41\u0E25\u0E30\u0E0A\u0E33\u0E23\u0E30\u0E40\u0E07\u0E34\u0E19\u0E14\u0E49\u0E32\u0E19\u0E43\u0E19\u0E25\u0E34\u0E07\u0E01\u0E4C http://192.168.1.103:8000/o/").concat(this.order.auth_order, "\n\n\u2757\uFE0F\u2757\uFE0F\u0E0A\u0E33\u0E23\u0E30\u0E40\u0E07\u0E34\u0E19\u0E1C\u0E48\u0E32\u0E19\u0E23\u0E30\u0E1A\u0E1A\u0E2B\u0E19\u0E49\u0E32\u0E40\u0E27\u0E47\u0E1A\u0E40\u0E17\u0E48\u0E32\u0E19\u0E31\u0E49\u0E19\u2757\uFE0F\u2757\uFE0F\n      ");
    },
    clickTimeOption: function clickTimeOption(v) {
      var datetime = new Date();
      var oDateTime = new Date(this.formatDateTimeGet());
      // console.log(oDateTime);

      switch (v.id) {
        case 1:
          datetime.setMinutes(datetime.getMinutes() + 15);
          break;
        case 2:
          datetime.setMinutes(datetime.getMinutes() + 30);
          break;
        case 3:
          datetime.setMinutes(datetime.getMinutes() + 60);
          break;
        case 4:
          datetime.setMinutes(datetime.getMinutes() + 180);
          break;
        case 5:
          datetime.setMinutes(datetime.getMinutes() + 360);
          break;
        case 6:
          oDateTime.setDate(oDateTime.getDate() - 1);
          oDateTime.setHours(12);
          oDateTime.setMinutes(0);
          break;
      }
      if (v.id === 6) {
        this.dateTimeForPay = oDateTime.toLocaleString();
      } else {
        this.dateTimeForPay = datetime.toLocaleString();
      }
    },
    changeTimeOption: function changeTimeOption(v) {
      this.clickTimeOption(v);
    },
    formatDateTimeGet: function formatDateTimeGet() {
      var d = this.order.date_get;
      var arr = d.split("-");
      var dd = arr[0];
      var mm = arr[1];
      var yyyy = parseInt(arr[2]) - 543;
      return "".concat(yyyy, "/").concat(mm, "/").concat(dd, " ").concat(this.order.time_get, ":00");
    },
    start: function start() {
      var _this2 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee2() {
        var res;
        return _regeneratorRuntime().wrap(function _callee2$(_context2) {
          while (1) switch (_context2.prev = _context2.next) {
            case 0:
              _context2.next = 2;
              return _this2.$store.dispatch("orderIndex/getOrderByID", {
                orderID: _this2.$route.params.id
              });
            case 2:
              res = _context2.sent;
            case 3:
            case "end":
              return _context2.stop();
          }
        }, _callee2);
      }))();
    },
    onCopy: function onCopy() {
      this.$swal({
        title: "คัดลอกแล้ว",
        icon: "success",
        allowOutsideClick: false,
        timerProgressBar: true,
        timer: 3000,
        showConfirmButton: false
      });
    }
  },
  mounted: function mounted() {
    var _this3 = this;
    return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee3() {
      return _regeneratorRuntime().wrap(function _callee3$(_context3) {
        while (1) switch (_context3.prev = _context3.next) {
          case 0:
            _context3.next = 2;
            return _this3.start();
          case 2:
          case "end":
            return _context3.stop();
        }
      }, _callee3);
    }))();
  },
  computed: _objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapGetters"])({
    text: "orderText/text",
    order: "orderIndex/order"
  }))
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/order/alertPaymentByOrderID.vue?vue&type=template&id=e7a1e364":
/*!******************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/order/alertPaymentByOrderID.vue?vue&type=template&id=e7a1e364 ***!
  \******************************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", [_c("v-card", {
    staticClass: "mb-2",
    attrs: {
      outlined: ""
    }
  }, [_c("v-card-title", {
    staticClass: "text-h6 white--text warning"
  }, [_vm._v("\n      แจ้งชำระเงิน")]), _vm._v(" "), _c("v-card-text", [_c("v-simple-table", [_c("tbody", [_c("tr", [_c("td", [_c("strong", [_vm._v("\n                " + _vm._s(_vm.text.order.number) + "\n              ")])]), _vm._v(" "), _c("td", {
    staticClass: "text-right"
  }, [_c("strong", [_vm._v(_vm._s(_vm.order.id))])])]), _vm._v(" "), _c("tr", [_c("td", [_c("strong", [_vm._v("วัน-เวลานัดรับสินค้า")])]), _vm._v(" "), _c("td", {
    staticClass: "text-right"
  }, [_c("strong", [_vm._v(_vm._s(_vm.order.date_get) + " " + _vm._s(_vm.order.time_get))])])])])])], 1)], 1), _vm._v(" "), _c("v-card", {
    staticClass: "mb-2",
    attrs: {
      outlined: ""
    }
  }, [_c("v-card-title", {
    staticClass: "text-h6 white--text warning"
  }, [_vm._v("\n      กำหนดวัน-เวลาชำระเงิน\n    ")]), _vm._v(" "), _c("v-card-text", [_c("v-item", {
    staticClass: "my-3"
  }, [_c("v-card", {
    staticClass: "d-flex align-center",
    attrs: {
      outlined: "",
      height: "50"
    }
  }, [_c("div", {
    staticClass: "text-h5 flex-grow-1 text-center"
  }, [_vm._v("\n            " + _vm._s(this.dateTimeForPay) + "\n          ")])])], 1), _vm._v(" "), _c("v-item-group", [_c("v-container", [_c("v-row", _vm._l(_vm.timeOptions, function (option) {
    return _c("v-col", {
      key: option.id,
      staticClass: "p-1",
      attrs: {
        cols: "6",
        lg: "3",
        md: "4"
      }
    }, [_c("v-item", {
      on: {
        change: function change($event) {
          return _vm.changeTimeOption(option);
        }
      },
      scopedSlots: _vm._u([{
        key: "default",
        fn: function fn(_ref) {
          var active = _ref.active,
            toggle = _ref.toggle;
          return [_c("v-card", {
            staticClass: "d-flex align-center",
            attrs: {
              color: active ? "teal darken-1" : "grey lighten-4",
              height: "50"
            },
            on: {
              click: toggle
            }
          }, [_c("v-scroll-y-transition", [active ? _c("div", {
            staticClass: "flex-grow-1 text-center white--text"
          }, [_c("strong", [_vm._v(_vm._s(option.text))])]) : _c("div", {
            staticClass: "flex-grow-1 text-center black--text"
          }, [_c("strong", [_vm._v("\n                        " + _vm._s(option.text) + "\n                      ")])])])], 1)];
        }
      }], null, true)
    })], 1);
  }), 1)], 1)], 1)], 1)], 1), _vm._v(" "), _c("v-card", [_c("v-card-title", {
    staticClass: "text-h6 white--text warning"
  }, [_vm._v("\n      ข้อบังคับ\n    ")]), _vm._v(" "), _c("v-card-text", [_c("v-checkbox", {
    attrs: {
      label: "แจ้งชำระเงินเต็มจำนวน",
      "hide-details": ""
    },
    model: {
      value: _vm.status_full_payment,
      callback: function callback($$v) {
        _vm.status_full_payment = $$v;
      },
      expression: "status_full_payment"
    }
  }), _vm._v(" "), _c("v-checkbox", {
    attrs: {
      label: "แจ้งเตือนลูกค้า (SMS)",
      "hide-details": ""
    },
    model: {
      value: _vm.alertSMSToCustomer,
      callback: function callback($$v) {
        _vm.alertSMSToCustomer = $$v;
      },
      expression: "alertSMSToCustomer"
    }
  })], 1), _vm._v(" "), _c("v-card-actions", [_c("v-spacer"), _vm._v(" "), _c("v-btn", {
    staticClass: "success",
    attrs: {
      large: "",
      dark: ""
    }
  }, [_c("v-icon", {
    attrs: {
      left: ""
    }
  }, [_vm._v("notifications")]), _vm._v(" "), _c("strong", [_vm._v("แจ้งเตือนชำระเงิน")])], 1), _vm._v(" "), _c("v-btn", {
    directives: [{
      name: "clipboard",
      rawName: "v-clipboard:copy",
      value: _vm.detailText(),
      expression: "detailText()",
      arg: "copy"
    }, {
      name: "clipboard",
      rawName: "v-clipboard:success",
      value: _vm.onCopy,
      expression: "onCopy",
      arg: "success"
    }],
    staticClass: "primary",
    attrs: {
      large: "",
      disabled: _vm.dateTimeForPay == ""
    },
    on: {
      click: _vm.clickAlertPaymentByOrderID
    }
  }, [_c("v-icon", {
    attrs: {
      left: ""
    }
  }, [_vm._v("arrow_back_ios")]), _vm._v(" "), _c("strong", [_vm._v("กลับไปหน้าก่อนและคัดลอก")]), _vm._v(" "), _c("v-icon", {
    attrs: {
      right: ""
    }
  }, [_vm._v("content_copy")])], 1)], 1)], 1)], 1);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/pages/order/alertPaymentByOrderID.vue":
/*!************************************************************!*\
  !*** ./resources/js/pages/order/alertPaymentByOrderID.vue ***!
  \************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _alertPaymentByOrderID_vue_vue_type_template_id_e7a1e364__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./alertPaymentByOrderID.vue?vue&type=template&id=e7a1e364 */ "./resources/js/pages/order/alertPaymentByOrderID.vue?vue&type=template&id=e7a1e364");
/* harmony import */ var _alertPaymentByOrderID_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./alertPaymentByOrderID.vue?vue&type=script&lang=js */ "./resources/js/pages/order/alertPaymentByOrderID.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _alertPaymentByOrderID_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _alertPaymentByOrderID_vue_vue_type_template_id_e7a1e364__WEBPACK_IMPORTED_MODULE_0__["render"],
  _alertPaymentByOrderID_vue_vue_type_template_id_e7a1e364__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/order/alertPaymentByOrderID.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/pages/order/alertPaymentByOrderID.vue?vue&type=script&lang=js":
/*!************************************************************************************!*\
  !*** ./resources/js/pages/order/alertPaymentByOrderID.vue?vue&type=script&lang=js ***!
  \************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_alertPaymentByOrderID_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./alertPaymentByOrderID.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/order/alertPaymentByOrderID.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_alertPaymentByOrderID_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/order/alertPaymentByOrderID.vue?vue&type=template&id=e7a1e364":
/*!******************************************************************************************!*\
  !*** ./resources/js/pages/order/alertPaymentByOrderID.vue?vue&type=template&id=e7a1e364 ***!
  \******************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_alertPaymentByOrderID_vue_vue_type_template_id_e7a1e364__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../node_modules/vue-loader/lib??vue-loader-options!./alertPaymentByOrderID.vue?vue&type=template&id=e7a1e364 */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/order/alertPaymentByOrderID.vue?vue&type=template&id=e7a1e364");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_alertPaymentByOrderID_vue_vue_type_template_id_e7a1e364__WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_alertPaymentByOrderID_vue_vue_type_template_id_e7a1e364__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);
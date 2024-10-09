(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[42],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/order/manages/goods/cake/productPrototype/waitingForNameFile.vue?vue&type=script&lang=js":
/*!**********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/order/manages/goods/cake/productPrototype/waitingForNameFile.vue?vue&type=script&lang=js ***!
  \**********************************************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return e; }; var t, e = {}, r = Object.prototype, n = r.hasOwnProperty, o = Object.defineProperty || function (t, e, r) { t[e] = r.value; }, i = "function" == typeof Symbol ? Symbol : {}, a = i.iterator || "@@iterator", c = i.asyncIterator || "@@asyncIterator", u = i.toStringTag || "@@toStringTag"; function define(t, e, r) { return Object.defineProperty(t, e, { value: r, enumerable: !0, configurable: !0, writable: !0 }), t[e]; } try { define({}, ""); } catch (t) { define = function define(t, e, r) { return t[e] = r; }; } function wrap(t, e, r, n) { var i = e && e.prototype instanceof Generator ? e : Generator, a = Object.create(i.prototype), c = new Context(n || []); return o(a, "_invoke", { value: makeInvokeMethod(t, r, c) }), a; } function tryCatch(t, e, r) { try { return { type: "normal", arg: t.call(e, r) }; } catch (t) { return { type: "throw", arg: t }; } } e.wrap = wrap; var h = "suspendedStart", l = "suspendedYield", f = "executing", s = "completed", y = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var p = {}; define(p, a, function () { return this; }); var d = Object.getPrototypeOf, v = d && d(d(values([]))); v && v !== r && n.call(v, a) && (p = v); var g = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(p); function defineIteratorMethods(t) { ["next", "throw", "return"].forEach(function (e) { define(t, e, function (t) { return this._invoke(e, t); }); }); } function AsyncIterator(t, e) { function invoke(r, o, i, a) { var c = tryCatch(t[r], t, o); if ("throw" !== c.type) { var u = c.arg, h = u.value; return h && "object" == _typeof(h) && n.call(h, "__await") ? e.resolve(h.__await).then(function (t) { invoke("next", t, i, a); }, function (t) { invoke("throw", t, i, a); }) : e.resolve(h).then(function (t) { u.value = t, i(u); }, function (t) { return invoke("throw", t, i, a); }); } a(c.arg); } var r; o(this, "_invoke", { value: function value(t, n) { function callInvokeWithMethodAndArg() { return new e(function (e, r) { invoke(t, n, e, r); }); } return r = r ? r.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(e, r, n) { var o = h; return function (i, a) { if (o === f) throw Error("Generator is already running"); if (o === s) { if ("throw" === i) throw a; return { value: t, done: !0 }; } for (n.method = i, n.arg = a;;) { var c = n.delegate; if (c) { var u = maybeInvokeDelegate(c, n); if (u) { if (u === y) continue; return u; } } if ("next" === n.method) n.sent = n._sent = n.arg;else if ("throw" === n.method) { if (o === h) throw o = s, n.arg; n.dispatchException(n.arg); } else "return" === n.method && n.abrupt("return", n.arg); o = f; var p = tryCatch(e, r, n); if ("normal" === p.type) { if (o = n.done ? s : l, p.arg === y) continue; return { value: p.arg, done: n.done }; } "throw" === p.type && (o = s, n.method = "throw", n.arg = p.arg); } }; } function maybeInvokeDelegate(e, r) { var n = r.method, o = e.iterator[n]; if (o === t) return r.delegate = null, "throw" === n && e.iterator["return"] && (r.method = "return", r.arg = t, maybeInvokeDelegate(e, r), "throw" === r.method) || "return" !== n && (r.method = "throw", r.arg = new TypeError("The iterator does not provide a '" + n + "' method")), y; var i = tryCatch(o, e.iterator, r.arg); if ("throw" === i.type) return r.method = "throw", r.arg = i.arg, r.delegate = null, y; var a = i.arg; return a ? a.done ? (r[e.resultName] = a.value, r.next = e.nextLoc, "return" !== r.method && (r.method = "next", r.arg = t), r.delegate = null, y) : a : (r.method = "throw", r.arg = new TypeError("iterator result is not an object"), r.delegate = null, y); } function pushTryEntry(t) { var e = { tryLoc: t[0] }; 1 in t && (e.catchLoc = t[1]), 2 in t && (e.finallyLoc = t[2], e.afterLoc = t[3]), this.tryEntries.push(e); } function resetTryEntry(t) { var e = t.completion || {}; e.type = "normal", delete e.arg, t.completion = e; } function Context(t) { this.tryEntries = [{ tryLoc: "root" }], t.forEach(pushTryEntry, this), this.reset(!0); } function values(e) { if (e || "" === e) { var r = e[a]; if (r) return r.call(e); if ("function" == typeof e.next) return e; if (!isNaN(e.length)) { var o = -1, i = function next() { for (; ++o < e.length;) if (n.call(e, o)) return next.value = e[o], next.done = !1, next; return next.value = t, next.done = !0, next; }; return i.next = i; } } throw new TypeError(_typeof(e) + " is not iterable"); } return GeneratorFunction.prototype = GeneratorFunctionPrototype, o(g, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), o(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, u, "GeneratorFunction"), e.isGeneratorFunction = function (t) { var e = "function" == typeof t && t.constructor; return !!e && (e === GeneratorFunction || "GeneratorFunction" === (e.displayName || e.name)); }, e.mark = function (t) { return Object.setPrototypeOf ? Object.setPrototypeOf(t, GeneratorFunctionPrototype) : (t.__proto__ = GeneratorFunctionPrototype, define(t, u, "GeneratorFunction")), t.prototype = Object.create(g), t; }, e.awrap = function (t) { return { __await: t }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, c, function () { return this; }), e.AsyncIterator = AsyncIterator, e.async = function (t, r, n, o, i) { void 0 === i && (i = Promise); var a = new AsyncIterator(wrap(t, r, n, o), i); return e.isGeneratorFunction(r) ? a : a.next().then(function (t) { return t.done ? t.value : a.next(); }); }, defineIteratorMethods(g), define(g, u, "Generator"), define(g, a, function () { return this; }), define(g, "toString", function () { return "[object Generator]"; }), e.keys = function (t) { var e = Object(t), r = []; for (var n in e) r.push(n); return r.reverse(), function next() { for (; r.length;) { var t = r.pop(); if (t in e) return next.value = t, next.done = !1, next; } return next.done = !0, next; }; }, e.values = values, Context.prototype = { constructor: Context, reset: function reset(e) { if (this.prev = 0, this.next = 0, this.sent = this._sent = t, this.done = !1, this.delegate = null, this.method = "next", this.arg = t, this.tryEntries.forEach(resetTryEntry), !e) for (var r in this) "t" === r.charAt(0) && n.call(this, r) && !isNaN(+r.slice(1)) && (this[r] = t); }, stop: function stop() { this.done = !0; var t = this.tryEntries[0].completion; if ("throw" === t.type) throw t.arg; return this.rval; }, dispatchException: function dispatchException(e) { if (this.done) throw e; var r = this; function handle(n, o) { return a.type = "throw", a.arg = e, r.next = n, o && (r.method = "next", r.arg = t), !!o; } for (var o = this.tryEntries.length - 1; o >= 0; --o) { var i = this.tryEntries[o], a = i.completion; if ("root" === i.tryLoc) return handle("end"); if (i.tryLoc <= this.prev) { var c = n.call(i, "catchLoc"), u = n.call(i, "finallyLoc"); if (c && u) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } else if (c) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); } else { if (!u) throw Error("try statement without catch or finally"); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } } } }, abrupt: function abrupt(t, e) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var o = this.tryEntries[r]; if (o.tryLoc <= this.prev && n.call(o, "finallyLoc") && this.prev < o.finallyLoc) { var i = o; break; } } i && ("break" === t || "continue" === t) && i.tryLoc <= e && e <= i.finallyLoc && (i = null); var a = i ? i.completion : {}; return a.type = t, a.arg = e, i ? (this.method = "next", this.next = i.finallyLoc, y) : this.complete(a); }, complete: function complete(t, e) { if ("throw" === t.type) throw t.arg; return "break" === t.type || "continue" === t.type ? this.next = t.arg : "return" === t.type ? (this.rval = this.arg = t.arg, this.method = "return", this.next = "end") : "normal" === t.type && e && (this.next = e), y; }, finish: function finish(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.finallyLoc === t) return this.complete(r.completion, r.afterLoc), resetTryEntry(r), y; } }, "catch": function _catch(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.tryLoc === t) { var n = r.completion; if ("throw" === n.type) { var o = n.arg; resetTryEntry(r); } return o; } } throw Error("illegal catch attempt"); }, delegateYield: function delegateYield(e, r, n) { return this.delegate = { iterator: values(e), resultName: r, nextLoc: n }, "next" === this.method && (this.arg = t), y; } }, e; }
function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }
function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }
var numeral = __webpack_require__(/*! numeral */ "./node_modules/numeral/numeral.js");
Vue.filter("formatNumber", function (value) {
  return numeral(value).format("0,0.00");
});
/* harmony default export */ __webpack_exports__["default"] = ({
  props: [],
  components: {},
  data: function data() {
    return {
      dialog: false,
      option: "",
      options: [{
        id: 1,
        text: "ดึงเงิน",
        fee: 100.0,
        remark: "สูงสุด 20 แบงค์",
        max: 20,
        min: 1
      }, {
        id: 2,
        text: "ล้อมเงิน",
        fee: 100.0,
        remark: "1:35,2:40,3:45 *ปอนด์:แบงค์*",
        max: 45,
        min: 35
      }, {
        id: 3,
        text: "ลูกบอลใส่เงิน",
        fee: 100.0,
        remark: "สูงสุด 10 แบงค์",
        max: 10,
        min: 1
      }, {
        id: 4,
        text: "ซ่อนเงิน",
        fee: 100.0,
        remark: "สูงสุด 99 แบงค์",
        max: 99,
        min: 1
      }],
      cash: {
        option_id: "",
        text: "",
        fee: "",
        remark: "",
        max: "",
        min: "",
        note: "",
        thb20: "0",
        thb50: "0",
        thb100: "0",
        thb500: "0",
        thb1000: "0"
      },
      // multiplier: {
      //     thb20: 20,
      //     thb50: 50,
      //     thb100: 100,
      //     thb500: 500,
      //     thb1000: 1000,
      // },
      cashTypes: [20, 50, 100, 500, 1000]
    };
  },
  methods: {
    clickSave: function clickSave() {
      var _this = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              if (!(_this.cashSum <= 0 || _this.thbSum <= 0)) {
                _context.next = 3;
                break;
              }
              _this.$swal({
                toast: true,
                allowOutsideClick: false,
                icon: "error",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                title: "โปรดกรอกข้อมูลให้ครบถ้วน",
                position: "bottom"
              });
              return _context.abrupt("return");
            case 3:
            case "end":
              return _context.stop();
          }
        }, _callee);
      }))();
    },
    isInteger: function isInteger(v) {
      if (v == "") {
        return 0;
      }
      if (!Number.isInteger(Number(v))) {
        return parseInt(v);
      }
      if (Number(v) <= -0) {
        return parseInt(v) * -1;
      }
      return v;
    },
    changeCash: function changeCash(v) {
      this.cash["thb".concat(v)] = this.isInteger(this.cash["thb".concat(v)]);
    },
    changeOption: function changeOption() {
      var _this2 = this;
      var e = this.options.find(function (e) {
        return e.id == _this2.option;
      });
      this.cash.option_id = e.id;
      this.cash.text = e.text;
      this.cash.remark = e.remark;
      this.cash.fee = e.fee;
      this.cash.max = e.max;
      this.cash.min = e.min;
    },
    exit: function exit() {
      this.dialog = false;
      this.option = "";
      this.cash = {
        option_id: "",
        text: "",
        fee: "",
        remark: "",
        max: "",
        min: "",
        thb20: "0",
        thb50: "0",
        thb100: "0",
        thb500: "0",
        thb1000: "0"
      };
    }
  },
  computed: {
    cashSum: function cashSum() {
      //รวมจำนวนแบงค์
      var sum = 0;
      for (var i = 0; i < this.cashTypes.length; i++) {
        sum += parseInt(this.cash["thb".concat(this.cashTypes[i])]);
      }
      return sum;
    },
    thbSum: function thbSum() {
      // รวมจำนวนเงิน
      var sum = 0;
      for (var i = 0; i < this.cashTypes.length; i++) {
        sum += parseInt(this.cash["thb".concat(this.cashTypes[i])] * this.cashTypes[i]);
      }
      return sum;
    },
    cashTotal: function cashTotal() {
      //รวมจำนวนเงิน + ค่าบริการ
      return this.thbSum + this.cash.fee;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/order/manages/goods/cake/productPrototype/waitingForNameFile.vue?vue&type=template&id=081b678e":
/*!********************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/order/manages/goods/cake/productPrototype/waitingForNameFile.vue?vue&type=template&id=081b678e ***!
  \********************************************************************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", [_c("v-dialog", {
    attrs: {
      persistent: "",
      width: "800",
      scrollable: "",
      transition: "dialog-top-transition"
    },
    scopedSlots: _vm._u([{
      key: "activator",
      fn: function fn(_ref) {
        var on = _ref.on;
        return [_c("v-list-item", _vm._g({}, on), [_c("v-list-item-icon", [_c("v-icon", [_vm._v("local_atm")])], 1), _vm._v(" "), _c("v-list-item-content", {
          staticClass: "p-0"
        }, [_c("v-list-item-title", {
          staticClass: "py-2"
        }, [_vm._v("บริการล้อม/ลูกบอล/ซ่อนเงิน/ดึงเงิน")])], 1)], 1)];
      }
    }]),
    model: {
      value: _vm.dialog,
      callback: function callback($$v) {
        _vm.dialog = $$v;
      },
      expression: "dialog"
    }
  }, [_vm._v(" "), _c("v-card", [_c("v-card-title", {
    staticClass: "text-h6"
  }, [_vm._v("\n                บริการล้อม/ลูกบอล/ซ่อนเงิน\n                "), _c("v-spacer"), _vm._v(" "), _c("v-btn", {
    attrs: {
      icon: "",
      fab: "",
      "x-small": ""
    },
    on: {
      click: function click($event) {
        return _vm.exit();
      }
    }
  }, [_c("v-icon", {
    attrs: {
      color: "error"
    }
  }, [_vm._v("close")])], 1)], 1), _vm._v(" "), _c("v-card-text", [_c("v-select", {
    staticClass: "py-1",
    attrs: {
      items: _vm.options,
      outlined: "",
      "hide-details": "",
      label: "บริการ",
      "item-value": "id"
    },
    on: {
      change: function change($event) {
        return _vm.changeOption();
      }
    },
    model: {
      value: _vm.option,
      callback: function callback($$v) {
        _vm.option = $$v;
      },
      expression: "option"
    }
  }), _vm._v(" "), _vm.option ? _c("p", {
    staticClass: "my-1 red--text text-caption font-weight-black"
  }, [_vm._v("\n                    หมายเหตุ : " + _vm._s(_vm.cash.remark) + "\n                ")]) : _vm._e(), _vm._v(" "), _vm.option ? _c("v-divider") : _vm._e(), _vm._v(" "), _vm.option ? _c("v-row", [_c("v-col", {
    attrs: {
      cols: "12",
      md: "6"
    }
  }, [_c("v-text-field", {
    staticClass: "mb-3",
    attrs: {
      label: "แบงค์ 20 บาท",
      outlined: "",
      "hide-details": "",
      suffix: "แบงค์",
      type: "number",
      pattern: "\\d*",
      dense: ""
    },
    on: {
      click: function click($event) {
        _vm.cash.thb20 = "";
      },
      change: function change($event) {
        return _vm.changeCash(20);
      }
    },
    model: {
      value: _vm.cash.thb20,
      callback: function callback($$v) {
        _vm.$set(_vm.cash, "thb20", $$v);
      },
      expression: "cash.thb20"
    }
  }), _vm._v(" "), _c("v-text-field", {
    staticClass: "mb-3",
    attrs: {
      dense: "",
      label: "แบงค์ 50 บาท",
      outlined: "",
      "hide-details": "",
      suffix: "แบงค์",
      type: "number",
      pattern: "\\d*"
    },
    on: {
      click: function click($event) {
        _vm.cash.thb50 = "";
      },
      change: function change($event) {
        return _vm.changeCash(50);
      }
    },
    model: {
      value: _vm.cash.thb50,
      callback: function callback($$v) {
        _vm.$set(_vm.cash, "thb50", $$v);
      },
      expression: "cash.thb50"
    }
  }), _vm._v(" "), _c("v-text-field", {
    staticClass: "mb-3",
    attrs: {
      dense: "",
      label: "แบงค์ 100 บาท",
      outlined: "",
      "hide-details": "",
      suffix: "แบงค์",
      type: "number",
      pattern: "\\d*"
    },
    on: {
      click: function click($event) {
        _vm.cash.thb100 = "";
      },
      change: function change($event) {
        return _vm.changeCash(100);
      }
    },
    model: {
      value: _vm.cash.thb100,
      callback: function callback($$v) {
        _vm.$set(_vm.cash, "thb100", $$v);
      },
      expression: "cash.thb100"
    }
  }), _vm._v(" "), _c("v-text-field", {
    staticClass: "mb-3",
    attrs: {
      dense: "",
      label: "แบงค์ 500 บาท",
      outlined: "",
      "hide-details": "",
      suffix: "แบงค์",
      type: "number",
      pattern: "\\d*"
    },
    on: {
      click: function click($event) {
        _vm.cash.thb500 = "";
      },
      change: function change($event) {
        return _vm.changeCash(500);
      }
    },
    model: {
      value: _vm.cash.thb500,
      callback: function callback($$v) {
        _vm.$set(_vm.cash, "thb500", $$v);
      },
      expression: "cash.thb500"
    }
  }), _vm._v(" "), _c("v-text-field", {
    staticClass: "mb-3",
    attrs: {
      dense: "",
      label: "แบงค์ 1,000 บาท",
      outlined: "",
      "hide-details": "",
      suffix: "แบงค์",
      type: "number",
      pattern: "\\d*"
    },
    on: {
      click: function click($event) {
        _vm.cash.thb1000 = "";
      },
      change: function change($event) {
        return _vm.changeCash(1000);
      }
    },
    model: {
      value: _vm.cash.thb1000,
      callback: function callback($$v) {
        _vm.$set(_vm.cash, "thb1000", $$v);
      },
      expression: "cash.thb1000"
    }
  }), _vm._v(" "), _c("v-textarea", {
    attrs: {
      dense: "",
      label: "หมายเหตุ",
      outlined: "",
      "hide-details": ""
    },
    model: {
      value: _vm.cash.note,
      callback: function callback($$v) {
        _vm.$set(_vm.cash, "note", $$v);
      },
      expression: "cash.note"
    }
  })], 1), _vm._v(" "), _c("v-col", {
    attrs: {
      cols: "12",
      md: "6"
    }
  }, [_c("v-simple-table", [_c("tbody", [_c("tr", {
    "class": _vm.cash.max < _vm.cashSum ? "red white--text" : ""
  }, [_c("td", [_vm._v("จำนวนแบงค์")]), _vm._v(" "), _c("td", {
    staticClass: "text-right"
  }, [_vm._v("\n                                        " + _vm._s(_vm.cashSum > 0 ? _vm.cashSum : 0) + " /\n                                        " + _vm._s(_vm.cash.max) + "\n                                        แบงค์\n                                    ")])]), _vm._v(" "), _c("tr", [_c("td", [_vm._v("จำนวนเงิน")]), _vm._v(" "), _c("td", {
    staticClass: "text-right"
  }, [_vm._v("\n                                        " + _vm._s(_vm._f("formatNumber")(_vm.thbSum)) + " บาท\n                                    ")])]), _vm._v(" "), _c("tr", [_c("td", [_vm._v("ค่าบริการ")]), _vm._v(" "), _c("td", {
    staticClass: "text-right"
  }, [_vm._v("\n                                        " + _vm._s(_vm._f("formatNumber")(_vm.cash.fee)) + "\n                                        บาท\n                                    ")])]), _vm._v(" "), _c("tr", [_c("td", [_vm._v("รวม")]), _vm._v(" "), _c("td", {
    staticClass: "text-right"
  }, [_vm._v("\n                                        " + _vm._s(_vm._f("formatNumber")(_vm.cashTotal)) + "\n                                        บาท\n                                    ")])])])]), _vm._v(" "), _c("v-btn", {
    staticClass: "my-3",
    attrs: {
      text: "",
      color: "error",
      large: "",
      block: ""
    }
  }, [_c("v-icon", {
    attrs: {
      left: ""
    }
  }, [_vm._v("delete")]), _vm._v("\n                            ลบรายการนี้\n                        ")], 1)], 1)], 1) : _vm._e()], 1), _vm._v(" "), _c("v-card-actions", [_c("v-btn", {
    staticClass: "error",
    on: {
      click: function click($event) {
        return _vm.exit();
      }
    }
  }, [_c("v-icon", {
    attrs: {
      left: ""
    }
  }, [_vm._v("exit_to_app")]), _vm._v("\n                    ออก\n                ")], 1), _vm._v(" "), _c("v-spacer"), _vm._v(" "), _c("v-btn", {
    staticClass: "success",
    attrs: {
      disabled: _vm.cashSum <= 0 || _vm.thbSum <= 0 || _vm.cash.max < _vm.cashSum
    },
    on: {
      click: function click($event) {
        return _vm.clickSave();
      }
    }
  }, [_c("v-icon", {
    attrs: {
      left: ""
    }
  }, [_vm._v("save")]), _vm._v("\n                    บันทึก\n                ")], 1)], 1)], 1)], 1), _vm._v(" "), _c("v-divider"), _vm._v(" "), _c("v-col", {
    attrs: {
      md: "8"
    }
  }, [_c("v-card", [_c("v-card-title", {
    staticClass: "text-h6"
  }, [_vm._v(" บริการเสริม ")]), _vm._v(" "), _c("v-card-text", [_c("v-card", {
    attrs: {
      outlined: ""
    }
  }, [_c("v-card-title", {
    staticClass: "body-1 font-weight-bold"
  }, [_vm._v("บริการ : ดึงเงิน\n                        "), _c("v-spacer"), _vm._v(" "), _c("v-btn", {
    attrs: {
      icon: "",
      fab: "",
      "x-small": ""
    }
  }, [_c("v-icon", {
    attrs: {
      color: "warning"
    }
  }, [_vm._v("edit")])], 1)], 1), _vm._v(" "), _c("v-card-text", {
    staticClass: "subtitle-1"
  }, [_c("v-row", [_c("v-col", {
    attrs: {
      cols: "12",
      md: "6"
    }
  }, [_c("v-simple-table", [_c("tbody", [_c("tr", [_c("td", [_vm._v("20 บาท")]), _vm._v(" "), _c("td", {
    staticClass: "text-right"
  }, [_vm._v("\n                                                2 แบงค์\n                                            ")])]), _vm._v(" "), _c("tr", [_c("td", [_vm._v("50 บาท")]), _vm._v(" "), _c("td", {
    staticClass: "text-right"
  }, [_vm._v("\n                                                2 แบงค์\n                                            ")])]), _vm._v(" "), _c("tr", [_c("td", [_vm._v("100 บาท")]), _vm._v(" "), _c("td", {
    staticClass: "text-right"
  }, [_vm._v("\n                                                2 แบงค์\n                                            ")])]), _vm._v(" "), _c("tr", [_c("td", [_vm._v("500 บาท")]), _vm._v(" "), _c("td", {
    staticClass: "text-right"
  }, [_vm._v("\n                                                2 แบงค์\n                                            ")])]), _vm._v(" "), _c("tr", [_c("td", [_vm._v("1,000 บาท")]), _vm._v(" "), _c("td", {
    staticClass: "text-right"
  }, [_vm._v("\n                                                2 แบงค์\n                                            ")])])])])], 1), _vm._v(" "), _c("v-col", {
    attrs: {
      cols: "12",
      md: "6"
    }
  }, [_c("v-simple-table", [_c("tbody", [_c("tr", [_c("td", [_vm._v("จำนวนแบงค์")]), _vm._v(" "), _c("td", {
    staticClass: "text-right"
  }, [_vm._v("\n                                                24 แบงค์\n                                            ")])]), _vm._v(" "), _c("tr", [_c("td", [_vm._v("จำนวนเงิน")]), _vm._v(" "), _c("td", {
    staticClass: "text-right"
  }, [_vm._v("\n                                                12,000 บาท\n                                            ")])]), _vm._v(" "), _c("tr", [_c("td", [_vm._v("ค่าบริการ")]), _vm._v(" "), _c("td", {
    staticClass: "text-right"
  }, [_vm._v("\n                                                100 บาท\n                                            ")])]), _vm._v(" "), _c("tr", [_c("td", [_vm._v("รวม")]), _vm._v(" "), _c("td", {
    staticClass: "text-right"
  }, [_vm._v("\n                                                12,100 บาท\n                                            ")])]), _vm._v(" "), _c("tr", [_c("td", [_vm._v("หมายเหตุ")]), _vm._v(" "), _c("td", {
    staticClass: "text-right"
  }, [_vm._v("\n                                                เค้กชั้นบน\n                                            ")])])])])], 1)], 1)], 1)], 1)], 1)], 1)], 1)], 1);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/components/order/manages/goods/cake/productPrototype/waitingForNameFile.vue":
/*!**************************************************************************************************!*\
  !*** ./resources/js/components/order/manages/goods/cake/productPrototype/waitingForNameFile.vue ***!
  \**************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _waitingForNameFile_vue_vue_type_template_id_081b678e__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./waitingForNameFile.vue?vue&type=template&id=081b678e */ "./resources/js/components/order/manages/goods/cake/productPrototype/waitingForNameFile.vue?vue&type=template&id=081b678e");
/* harmony import */ var _waitingForNameFile_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./waitingForNameFile.vue?vue&type=script&lang=js */ "./resources/js/components/order/manages/goods/cake/productPrototype/waitingForNameFile.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _waitingForNameFile_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _waitingForNameFile_vue_vue_type_template_id_081b678e__WEBPACK_IMPORTED_MODULE_0__["render"],
  _waitingForNameFile_vue_vue_type_template_id_081b678e__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/order/manages/goods/cake/productPrototype/waitingForNameFile.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/order/manages/goods/cake/productPrototype/waitingForNameFile.vue?vue&type=script&lang=js":
/*!**************************************************************************************************************************!*\
  !*** ./resources/js/components/order/manages/goods/cake/productPrototype/waitingForNameFile.vue?vue&type=script&lang=js ***!
  \**************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_waitingForNameFile_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../../../node_modules/vue-loader/lib??vue-loader-options!./waitingForNameFile.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/order/manages/goods/cake/productPrototype/waitingForNameFile.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_waitingForNameFile_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/order/manages/goods/cake/productPrototype/waitingForNameFile.vue?vue&type=template&id=081b678e":
/*!********************************************************************************************************************************!*\
  !*** ./resources/js/components/order/manages/goods/cake/productPrototype/waitingForNameFile.vue?vue&type=template&id=081b678e ***!
  \********************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_waitingForNameFile_vue_vue_type_template_id_081b678e__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../../../../../node_modules/vue-loader/lib??vue-loader-options!./waitingForNameFile.vue?vue&type=template&id=081b678e */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/order/manages/goods/cake/productPrototype/waitingForNameFile.vue?vue&type=template&id=081b678e");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_waitingForNameFile_vue_vue_type_template_id_081b678e__WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_waitingForNameFile_vue_vue_type_template_id_081b678e__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);
(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[37],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/order/manages/goods/cake/productPrototype/waitingForNameFile.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/order/manages/goods/cake/productPrototype/waitingForNameFile.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return exports; }; var exports = {}, Op = Object.prototype, hasOwn = Op.hasOwnProperty, defineProperty = Object.defineProperty || function (obj, key, desc) { obj[key] = desc.value; }, $Symbol = "function" == typeof Symbol ? Symbol : {}, iteratorSymbol = $Symbol.iterator || "@@iterator", asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator", toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag"; function define(obj, key, value) { return Object.defineProperty(obj, key, { value: value, enumerable: !0, configurable: !0, writable: !0 }), obj[key]; } try { define({}, ""); } catch (err) { define = function define(obj, key, value) { return obj[key] = value; }; } function wrap(innerFn, outerFn, self, tryLocsList) { var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator, generator = Object.create(protoGenerator.prototype), context = new Context(tryLocsList || []); return defineProperty(generator, "_invoke", { value: makeInvokeMethod(innerFn, self, context) }), generator; } function tryCatch(fn, obj, arg) { try { return { type: "normal", arg: fn.call(obj, arg) }; } catch (err) { return { type: "throw", arg: err }; } } exports.wrap = wrap; var ContinueSentinel = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var IteratorPrototype = {}; define(IteratorPrototype, iteratorSymbol, function () { return this; }); var getProto = Object.getPrototypeOf, NativeIteratorPrototype = getProto && getProto(getProto(values([]))); NativeIteratorPrototype && NativeIteratorPrototype !== Op && hasOwn.call(NativeIteratorPrototype, iteratorSymbol) && (IteratorPrototype = NativeIteratorPrototype); var Gp = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(IteratorPrototype); function defineIteratorMethods(prototype) { ["next", "throw", "return"].forEach(function (method) { define(prototype, method, function (arg) { return this._invoke(method, arg); }); }); } function AsyncIterator(generator, PromiseImpl) { function invoke(method, arg, resolve, reject) { var record = tryCatch(generator[method], generator, arg); if ("throw" !== record.type) { var result = record.arg, value = result.value; return value && "object" == _typeof(value) && hasOwn.call(value, "__await") ? PromiseImpl.resolve(value.__await).then(function (value) { invoke("next", value, resolve, reject); }, function (err) { invoke("throw", err, resolve, reject); }) : PromiseImpl.resolve(value).then(function (unwrapped) { result.value = unwrapped, resolve(result); }, function (error) { return invoke("throw", error, resolve, reject); }); } reject(record.arg); } var previousPromise; defineProperty(this, "_invoke", { value: function value(method, arg) { function callInvokeWithMethodAndArg() { return new PromiseImpl(function (resolve, reject) { invoke(method, arg, resolve, reject); }); } return previousPromise = previousPromise ? previousPromise.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(innerFn, self, context) { var state = "suspendedStart"; return function (method, arg) { if ("executing" === state) throw new Error("Generator is already running"); if ("completed" === state) { if ("throw" === method) throw arg; return doneResult(); } for (context.method = method, context.arg = arg;;) { var delegate = context.delegate; if (delegate) { var delegateResult = maybeInvokeDelegate(delegate, context); if (delegateResult) { if (delegateResult === ContinueSentinel) continue; return delegateResult; } } if ("next" === context.method) context.sent = context._sent = context.arg;else if ("throw" === context.method) { if ("suspendedStart" === state) throw state = "completed", context.arg; context.dispatchException(context.arg); } else "return" === context.method && context.abrupt("return", context.arg); state = "executing"; var record = tryCatch(innerFn, self, context); if ("normal" === record.type) { if (state = context.done ? "completed" : "suspendedYield", record.arg === ContinueSentinel) continue; return { value: record.arg, done: context.done }; } "throw" === record.type && (state = "completed", context.method = "throw", context.arg = record.arg); } }; } function maybeInvokeDelegate(delegate, context) { var methodName = context.method, method = delegate.iterator[methodName]; if (undefined === method) return context.delegate = null, "throw" === methodName && delegate.iterator["return"] && (context.method = "return", context.arg = undefined, maybeInvokeDelegate(delegate, context), "throw" === context.method) || "return" !== methodName && (context.method = "throw", context.arg = new TypeError("The iterator does not provide a '" + methodName + "' method")), ContinueSentinel; var record = tryCatch(method, delegate.iterator, context.arg); if ("throw" === record.type) return context.method = "throw", context.arg = record.arg, context.delegate = null, ContinueSentinel; var info = record.arg; return info ? info.done ? (context[delegate.resultName] = info.value, context.next = delegate.nextLoc, "return" !== context.method && (context.method = "next", context.arg = undefined), context.delegate = null, ContinueSentinel) : info : (context.method = "throw", context.arg = new TypeError("iterator result is not an object"), context.delegate = null, ContinueSentinel); } function pushTryEntry(locs) { var entry = { tryLoc: locs[0] }; 1 in locs && (entry.catchLoc = locs[1]), 2 in locs && (entry.finallyLoc = locs[2], entry.afterLoc = locs[3]), this.tryEntries.push(entry); } function resetTryEntry(entry) { var record = entry.completion || {}; record.type = "normal", delete record.arg, entry.completion = record; } function Context(tryLocsList) { this.tryEntries = [{ tryLoc: "root" }], tryLocsList.forEach(pushTryEntry, this), this.reset(!0); } function values(iterable) { if (iterable) { var iteratorMethod = iterable[iteratorSymbol]; if (iteratorMethod) return iteratorMethod.call(iterable); if ("function" == typeof iterable.next) return iterable; if (!isNaN(iterable.length)) { var i = -1, next = function next() { for (; ++i < iterable.length;) { if (hasOwn.call(iterable, i)) return next.value = iterable[i], next.done = !1, next; } return next.value = undefined, next.done = !0, next; }; return next.next = next; } } return { next: doneResult }; } function doneResult() { return { value: undefined, done: !0 }; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, defineProperty(Gp, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), defineProperty(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, toStringTagSymbol, "GeneratorFunction"), exports.isGeneratorFunction = function (genFun) { var ctor = "function" == typeof genFun && genFun.constructor; return !!ctor && (ctor === GeneratorFunction || "GeneratorFunction" === (ctor.displayName || ctor.name)); }, exports.mark = function (genFun) { return Object.setPrototypeOf ? Object.setPrototypeOf(genFun, GeneratorFunctionPrototype) : (genFun.__proto__ = GeneratorFunctionPrototype, define(genFun, toStringTagSymbol, "GeneratorFunction")), genFun.prototype = Object.create(Gp), genFun; }, exports.awrap = function (arg) { return { __await: arg }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, asyncIteratorSymbol, function () { return this; }), exports.AsyncIterator = AsyncIterator, exports.async = function (innerFn, outerFn, self, tryLocsList, PromiseImpl) { void 0 === PromiseImpl && (PromiseImpl = Promise); var iter = new AsyncIterator(wrap(innerFn, outerFn, self, tryLocsList), PromiseImpl); return exports.isGeneratorFunction(outerFn) ? iter : iter.next().then(function (result) { return result.done ? result.value : iter.next(); }); }, defineIteratorMethods(Gp), define(Gp, toStringTagSymbol, "Generator"), define(Gp, iteratorSymbol, function () { return this; }), define(Gp, "toString", function () { return "[object Generator]"; }), exports.keys = function (val) { var object = Object(val), keys = []; for (var key in object) { keys.push(key); } return keys.reverse(), function next() { for (; keys.length;) { var key = keys.pop(); if (key in object) return next.value = key, next.done = !1, next; } return next.done = !0, next; }; }, exports.values = values, Context.prototype = { constructor: Context, reset: function reset(skipTempReset) { if (this.prev = 0, this.next = 0, this.sent = this._sent = undefined, this.done = !1, this.delegate = null, this.method = "next", this.arg = undefined, this.tryEntries.forEach(resetTryEntry), !skipTempReset) for (var name in this) { "t" === name.charAt(0) && hasOwn.call(this, name) && !isNaN(+name.slice(1)) && (this[name] = undefined); } }, stop: function stop() { this.done = !0; var rootRecord = this.tryEntries[0].completion; if ("throw" === rootRecord.type) throw rootRecord.arg; return this.rval; }, dispatchException: function dispatchException(exception) { if (this.done) throw exception; var context = this; function handle(loc, caught) { return record.type = "throw", record.arg = exception, context.next = loc, caught && (context.method = "next", context.arg = undefined), !!caught; } for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i], record = entry.completion; if ("root" === entry.tryLoc) return handle("end"); if (entry.tryLoc <= this.prev) { var hasCatch = hasOwn.call(entry, "catchLoc"), hasFinally = hasOwn.call(entry, "finallyLoc"); if (hasCatch && hasFinally) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } else if (hasCatch) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); } else { if (!hasFinally) throw new Error("try statement without catch or finally"); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } } } }, abrupt: function abrupt(type, arg) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc <= this.prev && hasOwn.call(entry, "finallyLoc") && this.prev < entry.finallyLoc) { var finallyEntry = entry; break; } } finallyEntry && ("break" === type || "continue" === type) && finallyEntry.tryLoc <= arg && arg <= finallyEntry.finallyLoc && (finallyEntry = null); var record = finallyEntry ? finallyEntry.completion : {}; return record.type = type, record.arg = arg, finallyEntry ? (this.method = "next", this.next = finallyEntry.finallyLoc, ContinueSentinel) : this.complete(record); }, complete: function complete(record, afterLoc) { if ("throw" === record.type) throw record.arg; return "break" === record.type || "continue" === record.type ? this.next = record.arg : "return" === record.type ? (this.rval = this.arg = record.arg, this.method = "return", this.next = "end") : "normal" === record.type && afterLoc && (this.next = afterLoc), ContinueSentinel; }, finish: function finish(finallyLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.finallyLoc === finallyLoc) return this.complete(entry.completion, entry.afterLoc), resetTryEntry(entry), ContinueSentinel; } }, "catch": function _catch(tryLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc === tryLoc) { var record = entry.completion; if ("throw" === record.type) { var thrown = record.arg; resetTryEntry(entry); } return thrown; } } throw new Error("illegal catch attempt"); }, delegateYield: function delegateYield(iterable, resultName, nextLoc) { return this.delegate = { iterator: values(iterable), resultName: resultName, nextLoc: nextLoc }, "next" === this.method && (this.arg = undefined), ContinueSentinel; } }, exports; }
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
          while (1) {
            switch (_context.prev = _context.next) {
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

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/order/manages/goods/cake/productPrototype/waitingForNameFile.vue?vue&type=template&id=081b678e&":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/order/manages/goods/cake/productPrototype/waitingForNameFile.vue?vue&type=template&id=081b678e& ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************/
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
/* harmony import */ var _waitingForNameFile_vue_vue_type_template_id_081b678e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./waitingForNameFile.vue?vue&type=template&id=081b678e& */ "./resources/js/components/order/manages/goods/cake/productPrototype/waitingForNameFile.vue?vue&type=template&id=081b678e&");
/* harmony import */ var _waitingForNameFile_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./waitingForNameFile.vue?vue&type=script&lang=js& */ "./resources/js/components/order/manages/goods/cake/productPrototype/waitingForNameFile.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _waitingForNameFile_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _waitingForNameFile_vue_vue_type_template_id_081b678e___WEBPACK_IMPORTED_MODULE_0__["render"],
  _waitingForNameFile_vue_vue_type_template_id_081b678e___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
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

/***/ "./resources/js/components/order/manages/goods/cake/productPrototype/waitingForNameFile.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************!*\
  !*** ./resources/js/components/order/manages/goods/cake/productPrototype/waitingForNameFile.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_waitingForNameFile_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../../../node_modules/vue-loader/lib??vue-loader-options!./waitingForNameFile.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/order/manages/goods/cake/productPrototype/waitingForNameFile.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_waitingForNameFile_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/order/manages/goods/cake/productPrototype/waitingForNameFile.vue?vue&type=template&id=081b678e&":
/*!*********************************************************************************************************************************!*\
  !*** ./resources/js/components/order/manages/goods/cake/productPrototype/waitingForNameFile.vue?vue&type=template&id=081b678e& ***!
  \*********************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_waitingForNameFile_vue_vue_type_template_id_081b678e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../../../../../node_modules/vue-loader/lib??vue-loader-options!./waitingForNameFile.vue?vue&type=template&id=081b678e& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/order/manages/goods/cake/productPrototype/waitingForNameFile.vue?vue&type=template&id=081b678e&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_waitingForNameFile_vue_vue_type_template_id_081b678e___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_waitingForNameFile_vue_vue_type_template_id_081b678e___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);
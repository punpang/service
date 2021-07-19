(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[10],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/google/drive/imageThumbnailPathSize800WH200.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/google/drive/imageThumbnailPathSize800WH200.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["path"]
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/shabuNoonee/tableOrder/useTableOrder.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/shabuNoonee/tableOrder/useTableOrder.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
/* harmony import */ var _js_components_google_drive_imageThumbnailPathSize800WH200__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @/js/components/google/drive/imageThumbnailPathSize800WH200 */ "./resources/js/components/google/drive/imageThumbnailPathSize800WH200.vue");


function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) { symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); } keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    imageThumbnailPathSize800WH200: _js_components_google_drive_imageThumbnailPathSize800WH200__WEBPACK_IMPORTED_MODULE_2__["default"] //qrCode <qrCode text="http://192.168.1.103:8000/table"></qrCode>

  },
  data: function data() {
    return {
      products: [],
      sumCountProduct: 0
    };
  },
  methods: {
    colorCardByCountProduct: function colorCardByCountProduct(c) {
      if (c == 0) {
        return;
      }

      return "lime lighten-5";
    },
    colorBadgeSumProduct: function colorBadgeSumProduct(c) {
      if (c >= 20) {
        return "deep-orange darken-4";
      } else if (c >= 15) {
        return "yellow darken-3";
      } else if (c > 0) {
        return "green";
      }
    },
    countProduct: function countProduct(v) {
      var length = this.products.length;

      for (var i = 0; i < length; i++) {
        if (this.products[i].id == v) {
          return this.products[i].quantity;
        }
      }

      return 0;
    },
    clickAddProduct: function clickAddProduct(data) {
      if (this.sumCountProduct === 20) {
        this.$swal({
          icon: "warning",
          title: "สามารถสั่งได้ครั้งละ 20 ถาด",
          confirmButtonColor: "#3085d6",
          confirmButtonText: "ปิด",
          allowOutsideClick: false
        });
        return;
      }

      var length = this.products.length;

      if (length == 0) {
        this.productPush(data);
        this.sumCountProduct = 1;
      } else {
        for (var i = 0; i < length; i++) {
          if (this.products[i].id == data.id) {
            this.products[i].quantity = ++this.products[i].quantity;
            this.products[i].sumPrice = this.products[i].price * this.products[i].quantity;
            this.sumCountProduct = ++this.sumCountProduct;
            return;
          }
        }

        this.productPush(data);
        this.sumCountProduct = ++this.sumCountProduct;
      }
    },
    productPush: function productPush(data) {
      this.products.push({
        id: data.id,
        title: data.title,
        next_to: data.next_to,
        quantity: 1,
        price: data.price,
        sumPrice: data.price * 1,
        status_free: data.status_free
      });
    },
    clickCutProduct: function clickCutProduct(data) {
      var length = this.products.length;

      for (var i = 0; i < length; i++) {
        if (this.products[i].id == data.id) {
          if (this.products[i].quantity === 0) {
            return;
          }

          this.products[i].quantity = --this.products[i].quantity;
          this.products[i].sumPrice = this.products[i].price * this.products[i].quantity;
          this.sumCountProduct = --this.sumCountProduct;
          return;
        }
      }
    },
    save: function save() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee() {
        var form, res;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                if (!(_this.sumCountProduct <= 0)) {
                  _context.next = 3;
                  break;
                }

                _this.$swal({
                  icon: "warning",
                  title: "โปรดเพิ่มอาหารอย่างน้อย 1 รายการ",
                  confirmButtonColor: "#3085d6",
                  confirmButtonText: "ปิด",
                  allowOutsideClick: false
                });

                return _context.abrupt("return");

              case 3:
                form = {
                  diningTableId: _this.self.id,
                  products: _this.products,
                  sumCountProduct: _this.sumCountProduct
                };
                _context.next = 6;
                return _this.$store.dispatch("tableOrder/store", form);

              case 6:
                res = _context.sent;

                if (!(res.status === 200)) {
                  _context.next = 11;
                  break;
                }

                _this.$swal({
                  icon: "success",
                  confirmButtonColor: "#3085d6",
                  timer: 5000,
                  timerProgressBar: true,
                  showConfirmButton: false,
                  title: res.data.message,
                  text: res.data.queue,
                  footer: res.data.messageProductOutOfStock,
                  allowOutsideClick: false
                });

                _context.next = 16;
                break;

              case 11:
                if (!(res.status === 201)) {
                  _context.next = 16;
                  break;
                }

                _this.$swal({
                  icon: "error",
                  title: res.data.message,
                  text: res.data.messageText,
                  confirmButtonColor: "#3085d6",
                  confirmButtonText: "ปิด",
                  allowOutsideClick: false
                });

                if (!res.data.resetStatus) {
                  _context.next = 16;
                  break;
                }

                _context.next = 16;
                return _this.$store.dispatch("tableOrder/self");

              case 16:
                _this.reset();

              case 17:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    reset: function reset() {
      this.products = [];
      this.sumCountProduct = 0;
    }
  },
  mounted: function mounted() {
    var _this2 = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee2() {
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee2$(_context2) {
        while (1) {
          switch (_context2.prev = _context2.next) {
            case 0:
              _context2.next = 2;
              return _this2.$store.dispatch("tableOrder/productGroupAllow", _this2.self.price_range.product_group_allow);

            case 2:
            case "end":
              return _context2.stop();
          }
        }
      }, _callee2);
    }))();
  },
  computed: _objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapGetters"])({
    self: "tableOrder/self"
  })), Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapGetters"])({
    productGroupAllow: "tableOrder/productGroupAllow"
  }))
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/tableOrder/table.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/tableOrder/table.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
/* harmony import */ var _js_components_shabuNoonee_tableOrder_useTableOrder__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @/js/components/shabuNoonee/tableOrder/useTableOrder */ "./resources/js/components/shabuNoonee/tableOrder/useTableOrder.vue");
/* harmony import */ var _js_components_shabuNoonee_tableOrder_emptyTableOrder__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @/js/components/shabuNoonee/tableOrder/emptyTableOrder */ "./resources/js/components/shabuNoonee/tableOrder/emptyTableOrder.vue");


function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) { symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); } keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

//
//
//
//
//
//
//
//
//


 //import qrCode from 'vue-qrcode-component'

/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    useTableOrder: _js_components_shabuNoonee_tableOrder_useTableOrder__WEBPACK_IMPORTED_MODULE_2__["default"],
    emptyTableOrder: _js_components_shabuNoonee_tableOrder_emptyTableOrder__WEBPACK_IMPORTED_MODULE_3__["default"]
  },
  data: function data() {
    return {};
  },
  methods: {},
  mounted: function mounted() {
    var _this = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee() {
      var loader;
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              loader = _this.$loading.show();
              _context.next = 3;
              return _this.$store.dispatch("tableOrder/self");

            case 3:
              loader.hide();
              window.Echo.channel("DiningTableStatusOn").listen(".DiningTableStatusAs", function (e) {
                if (_this.tableUser.id === e.task.user_id) {
                  _this.$store.dispatch("tableOrder/self");
                }
              });

            case 5:
            case "end":
              return _context.stop();
          }
        }
      }, _callee);
    }))();
  },
  computed: _objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapGetters"])({
    self: "tableOrder/self"
  })), Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapGetters"])({
    tableUser: "main/User"
  }))
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/google/drive/imageThumbnailPathSize800WH200.vue?vue&type=template&id=afa4f700&":
/*!**********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/google/drive/imageThumbnailPathSize800WH200.vue?vue&type=template&id=afa4f700& ***!
  \**********************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("v-img", {
    attrs: {
      src:
        "https://drive.google.com/thumbnail?id=" + _vm.path + "&sz=w800-h800",
      "lazy-src":
        "https://drive.google.com/thumbnail?id=" + _vm.path + "&sz=w800-h800",
      "max-height": "200",
      "max-width": "200"
    },
    scopedSlots: _vm._u([
      {
        key: "placeholder",
        fn: function() {
          return [
            _c(
              "v-row",
              {
                staticClass: "fill-height ma-0",
                attrs: { align: "center", justify: "center" }
              },
              [
                _c("v-progress-circular", {
                  attrs: { indeterminate: "", color: "grey lighten-5" }
                })
              ],
              1
            )
          ]
        },
        proxy: true
      }
    ])
  })
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/shabuNoonee/tableOrder/emptyTableOrder.vue?vue&type=template&id=5ce72599&":
/*!*****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/shabuNoonee/tableOrder/emptyTableOrder.vue?vue&type=template&id=5ce72599& ***!
  \*****************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _c("v-row", { staticClass: "mt-16", attrs: { justify: "center" } }, [
        _c("h1", [_vm._v("โต๊ะว่าง")])
      ])
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/shabuNoonee/tableOrder/useTableOrder.vue?vue&type=template&id=42b2f553&":
/*!***************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/shabuNoonee/tableOrder/useTableOrder.vue?vue&type=template&id=42b2f553& ***!
  \***************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _vm._l(_vm.productGroupAllow, function(product) {
        return _c(
          "div",
          { key: product.id },
          [
            _c("v-divider"),
            _vm._v(" "),
            _c("h3", [_vm._v(_vm._s(product.name))]),
            _vm._v(" "),
            _c("v-divider"),
            _vm._v(" "),
            _vm._l(product.product, function(item_product) {
              return _c(
                "v-card",
                {
                  key: item_product.id,
                  staticClass: "mb-4",
                  attrs: {
                    outlined: "",
                    disabled: item_product.status == false,
                    shaped: "",
                    elevation: "2",
                    color: _vm.colorCardByCountProduct(
                      _vm.countProduct(item_product.id)
                    )
                  }
                },
                [
                  _c(
                    "v-card-text",
                    [
                      _c(
                        "v-row",
                        [
                          _c(
                            "v-col",
                            { attrs: { cols: "4" } },
                            [
                              _c("imageThumbnailPathSize800WH200", {
                                attrs: {
                                  path: item_product.googlg_image.src_name
                                }
                              })
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _c(
                            "v-col",
                            { attrs: { cols: "8" } },
                            [
                              _c("h5", { staticClass: "mb-4" }, [
                                _c("strong", [
                                  _vm._v(_vm._s(item_product.title))
                                ]),
                                _vm._v(" "),
                                item_product.status_free === 0
                                  ? _c("strong", [
                                      _vm._v(
                                        "( " +
                                          _vm._s(item_product.price) +
                                          " บาท )"
                                      )
                                    ])
                                  : _vm._e()
                              ]),
                              _vm._v(" "),
                              item_product.status
                                ? _c(
                                    "v-alert",
                                    {
                                      attrs: {
                                        dense: "",
                                        text: "",
                                        type: "success"
                                      }
                                    },
                                    [_c("strong", [_vm._v("มีสินค้า")])]
                                  )
                                : _c(
                                    "v-alert",
                                    {
                                      attrs: {
                                        dense: "",
                                        text: "",
                                        type: "error"
                                      }
                                    },
                                    [_c("strong", [_vm._v("หมดชั่วคราว")])]
                                  ),
                              _vm._v(" "),
                              item_product.status
                                ? _c(
                                    "div",
                                    [
                                      _c(
                                        "v-btn",
                                        {
                                          attrs: { small: "", outlined: "" },
                                          on: {
                                            click: function($event) {
                                              return _vm.clickCutProduct(
                                                item_product
                                              )
                                            }
                                          }
                                        },
                                        [_c("h3", [_vm._v("-")])]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "v-btn",
                                        { attrs: { small: "", disabled: "" } },
                                        [
                                          _c("h3", { staticClass: "mb-1" }, [
                                            _vm._v(
                                              "\n                  " +
                                                _vm._s(
                                                  _vm.countProduct(
                                                    item_product.id
                                                  )
                                                ) +
                                                "\n                "
                                            )
                                          ])
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "v-btn",
                                        {
                                          attrs: { small: "", outlined: "" },
                                          on: {
                                            click: function($event) {
                                              return _vm.clickAddProduct(
                                                item_product
                                              )
                                            }
                                          }
                                        },
                                        [_c("h3", [_vm._v("+")])]
                                      )
                                    ],
                                    1
                                  )
                                : _vm._e()
                            ],
                            1
                          )
                        ],
                        1
                      )
                    ],
                    1
                  )
                ],
                1
              )
            })
          ],
          2
        )
      }),
      _vm._v(" "),
      _c(
        "v-bottom-navigation",
        { staticClass: "yellow darken-4", attrs: { app: "", grow: "" } },
        [
          _c(
            "v-btn",
            [
              _c("span", { staticClass: "white--text" }, [
                _vm._v("เรียกเก็บเงิน")
              ]),
              _vm._v(" "),
              _c("v-icon", { staticClass: "white--text" }, [
                _vm._v("attach_money")
              ])
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "v-btn",
            {
              on: {
                click: function($event) {
                  return _vm.save()
                }
              }
            },
            [
              _c("span", { staticClass: "white--text" }, [_vm._v("สั่งอาหาร")]),
              _vm._v(" "),
              _c(
                "v-badge",
                {
                  attrs: {
                    content: _vm.sumCountProduct,
                    value: _vm.sumCountProduct,
                    color: _vm.colorBadgeSumProduct(_vm.sumCountProduct)
                  }
                },
                [
                  _c("v-icon", { staticClass: "white--text" }, [
                    _vm._v("restaurant_menu")
                  ])
                ],
                1
              )
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "v-btn",
            [
              _c("span", { staticClass: "white--text" }, [
                _vm._v("เรียกพนักงาน")
              ]),
              _vm._v(" "),
              _c("v-icon", { staticClass: "white--text" }, [
                _vm._v("people_alt")
              ])
            ],
            1
          )
        ],
        1
      )
    ],
    2
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/tableOrder/table.vue?vue&type=template&id=621ab9f0&":
/*!**************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/tableOrder/table.vue?vue&type=template&id=621ab9f0& ***!
  \**************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _vm.self === null
        ? _c("emptyTableOrder", [_vm._v("โต๊ะว่าง")])
        : _vm.self.status_id === 1
        ? _c("useTableOrder")
        : _vm.self.status_id === 2
        ? _c("div", [_vm._v("สถานะ 2 :: ชำระเงิน")])
        : _vm.self.status_id === 3
        ? _c("div", [_vm._v("สถานะ 3 :: กำลังทำความสะอาด")])
        : _vm._e()
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/google/drive/imageThumbnailPathSize800WH200.vue":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/google/drive/imageThumbnailPathSize800WH200.vue ***!
  \*********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _imageThumbnailPathSize800WH200_vue_vue_type_template_id_afa4f700___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./imageThumbnailPathSize800WH200.vue?vue&type=template&id=afa4f700& */ "./resources/js/components/google/drive/imageThumbnailPathSize800WH200.vue?vue&type=template&id=afa4f700&");
/* harmony import */ var _imageThumbnailPathSize800WH200_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./imageThumbnailPathSize800WH200.vue?vue&type=script&lang=js& */ "./resources/js/components/google/drive/imageThumbnailPathSize800WH200.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _imageThumbnailPathSize800WH200_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _imageThumbnailPathSize800WH200_vue_vue_type_template_id_afa4f700___WEBPACK_IMPORTED_MODULE_0__["render"],
  _imageThumbnailPathSize800WH200_vue_vue_type_template_id_afa4f700___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/google/drive/imageThumbnailPathSize800WH200.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/google/drive/imageThumbnailPathSize800WH200.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************!*\
  !*** ./resources/js/components/google/drive/imageThumbnailPathSize800WH200.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_imageThumbnailPathSize800WH200_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./imageThumbnailPathSize800WH200.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/google/drive/imageThumbnailPathSize800WH200.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_imageThumbnailPathSize800WH200_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/google/drive/imageThumbnailPathSize800WH200.vue?vue&type=template&id=afa4f700&":
/*!****************************************************************************************************************!*\
  !*** ./resources/js/components/google/drive/imageThumbnailPathSize800WH200.vue?vue&type=template&id=afa4f700& ***!
  \****************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_imageThumbnailPathSize800WH200_vue_vue_type_template_id_afa4f700___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./imageThumbnailPathSize800WH200.vue?vue&type=template&id=afa4f700& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/google/drive/imageThumbnailPathSize800WH200.vue?vue&type=template&id=afa4f700&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_imageThumbnailPathSize800WH200_vue_vue_type_template_id_afa4f700___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_imageThumbnailPathSize800WH200_vue_vue_type_template_id_afa4f700___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/shabuNoonee/tableOrder/emptyTableOrder.vue":
/*!****************************************************************************!*\
  !*** ./resources/js/components/shabuNoonee/tableOrder/emptyTableOrder.vue ***!
  \****************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _emptyTableOrder_vue_vue_type_template_id_5ce72599___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./emptyTableOrder.vue?vue&type=template&id=5ce72599& */ "./resources/js/components/shabuNoonee/tableOrder/emptyTableOrder.vue?vue&type=template&id=5ce72599&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");

var script = {}


/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_1__["default"])(
  script,
  _emptyTableOrder_vue_vue_type_template_id_5ce72599___WEBPACK_IMPORTED_MODULE_0__["render"],
  _emptyTableOrder_vue_vue_type_template_id_5ce72599___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/shabuNoonee/tableOrder/emptyTableOrder.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/shabuNoonee/tableOrder/emptyTableOrder.vue?vue&type=template&id=5ce72599&":
/*!***********************************************************************************************************!*\
  !*** ./resources/js/components/shabuNoonee/tableOrder/emptyTableOrder.vue?vue&type=template&id=5ce72599& ***!
  \***********************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_emptyTableOrder_vue_vue_type_template_id_5ce72599___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./emptyTableOrder.vue?vue&type=template&id=5ce72599& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/shabuNoonee/tableOrder/emptyTableOrder.vue?vue&type=template&id=5ce72599&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_emptyTableOrder_vue_vue_type_template_id_5ce72599___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_emptyTableOrder_vue_vue_type_template_id_5ce72599___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/shabuNoonee/tableOrder/useTableOrder.vue":
/*!**************************************************************************!*\
  !*** ./resources/js/components/shabuNoonee/tableOrder/useTableOrder.vue ***!
  \**************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _useTableOrder_vue_vue_type_template_id_42b2f553___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./useTableOrder.vue?vue&type=template&id=42b2f553& */ "./resources/js/components/shabuNoonee/tableOrder/useTableOrder.vue?vue&type=template&id=42b2f553&");
/* harmony import */ var _useTableOrder_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./useTableOrder.vue?vue&type=script&lang=js& */ "./resources/js/components/shabuNoonee/tableOrder/useTableOrder.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _useTableOrder_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _useTableOrder_vue_vue_type_template_id_42b2f553___WEBPACK_IMPORTED_MODULE_0__["render"],
  _useTableOrder_vue_vue_type_template_id_42b2f553___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/shabuNoonee/tableOrder/useTableOrder.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/shabuNoonee/tableOrder/useTableOrder.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************!*\
  !*** ./resources/js/components/shabuNoonee/tableOrder/useTableOrder.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_useTableOrder_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./useTableOrder.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/shabuNoonee/tableOrder/useTableOrder.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_useTableOrder_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/shabuNoonee/tableOrder/useTableOrder.vue?vue&type=template&id=42b2f553&":
/*!*********************************************************************************************************!*\
  !*** ./resources/js/components/shabuNoonee/tableOrder/useTableOrder.vue?vue&type=template&id=42b2f553& ***!
  \*********************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_useTableOrder_vue_vue_type_template_id_42b2f553___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./useTableOrder.vue?vue&type=template&id=42b2f553& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/shabuNoonee/tableOrder/useTableOrder.vue?vue&type=template&id=42b2f553&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_useTableOrder_vue_vue_type_template_id_42b2f553___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_useTableOrder_vue_vue_type_template_id_42b2f553___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/pages/tableOrder/table.vue":
/*!*************************************************!*\
  !*** ./resources/js/pages/tableOrder/table.vue ***!
  \*************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _table_vue_vue_type_template_id_621ab9f0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./table.vue?vue&type=template&id=621ab9f0& */ "./resources/js/pages/tableOrder/table.vue?vue&type=template&id=621ab9f0&");
/* harmony import */ var _table_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./table.vue?vue&type=script&lang=js& */ "./resources/js/pages/tableOrder/table.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _table_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _table_vue_vue_type_template_id_621ab9f0___WEBPACK_IMPORTED_MODULE_0__["render"],
  _table_vue_vue_type_template_id_621ab9f0___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/tableOrder/table.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/pages/tableOrder/table.vue?vue&type=script&lang=js&":
/*!**************************************************************************!*\
  !*** ./resources/js/pages/tableOrder/table.vue?vue&type=script&lang=js& ***!
  \**************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_table_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./table.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/tableOrder/table.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_table_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/tableOrder/table.vue?vue&type=template&id=621ab9f0&":
/*!********************************************************************************!*\
  !*** ./resources/js/pages/tableOrder/table.vue?vue&type=template&id=621ab9f0& ***!
  \********************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_table_vue_vue_type_template_id_621ab9f0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./table.vue?vue&type=template&id=621ab9f0& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/tableOrder/table.vue?vue&type=template&id=621ab9f0&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_table_vue_vue_type_template_id_621ab9f0___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_table_vue_vue_type_template_id_621ab9f0___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);
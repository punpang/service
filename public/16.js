(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[16],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/shabuNoonee/kitchen/queueOrder/nextToWaitress.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/shabuNoonee/kitchen/queueOrder/nextToWaitress.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");


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

/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["propStatus"],
  data: function data() {
    return {
      countUp: 1
    };
  },
  methods: {
    // countUpTimer() {
    //   setTimeout(() => {
    //     this.countUp += 1;
    //     this.countUpTimer();
    //   }, 1000);
    // },
    playSound: function playSound() {
      var soundurl = "https://soundbible.com/mp3/Fire_pager-jason-1283464858.mp3";
      var audio = new Audio(soundurl);
      audio.play();
    },
    save: function save() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee() {
        var res;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.next = 2;
                return _this.$store.dispatch("kitchenQueueOrder/nextToWaitress", _this.self.id);

              case 2:
                res = _context.sent;

                if (!_this.propStatus) {
                  _context.next = 6;
                  break;
                }

                _context.next = 6;
                return _this.$store.dispatch("kitchenQueueOrder/self");

              case 6:
                if (res.status === 200) {
                  _this.$swal({
                    icon: "success",
                    confirmButtonColor: "#3085d6",
                    title: res.data.message,
                    text: res.data.messageText,
                    confirmButtonText: "รายการถัดไป",
                    allowOutsideClick: false
                  });
                } else if (res.status === 201) {
                  _this.$swal({
                    icon: "warning",
                    confirmButtonColor: "#3085d6",
                    title: res.data.message,
                    confirmButtonText: "รายการถัดไป",
                    allowOutsideClick: false
                  });
                }

              case 7:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    }
  },
  mounted: function mounted() {//this.countUpTimer();

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee2() {
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee2$(_context2) {
        while (1) {
          switch (_context2.prev = _context2.next) {
            case 0:
            case "end":
              return _context2.stop();
          }
        }
      }, _callee2);
    }))();
  },
  computed: _objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapGetters"])({
    self: "kitchenQueueOrder/self"
  })), Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapGetters"])({
    sumQuantity: "kitchenQueueOrder/sumQuantity"
  }))
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/kitchen/kitchenQueueOrder.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/kitchen/kitchenQueueOrder.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _js_components_shabuNoonee_kitchen_queueOrder_nextToWaitress__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @/js/components/shabuNoonee/kitchen/queueOrder/nextToWaitress */ "./resources/js/components/shabuNoonee/kitchen/queueOrder/nextToWaitress.vue");
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");


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


/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    nextToWaitress: _js_components_shabuNoonee_kitchen_queueOrder_nextToWaitress__WEBPACK_IMPORTED_MODULE_1__["default"]
  },
  data: function data() {
    return {
      status: false
    };
  },
  methods: {
    start: function start() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                if (!_this.status) {
                  _context.next = 3;
                  break;
                }

                _context.next = 3;
                return _this.$store.dispatch("kitchenQueueOrder/self");

              case 3:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    playSound: function playSound() {
      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee2() {
        var soundurl, audio;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                soundurl = "https://soundbible.com/mp3/Fire_pager-jason-1283464858.mp3";
                audio = new Audio(soundurl);
                _context2.next = 4;
                return audio.play();

              case 4:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    }
  },
  mounted: function mounted() {
    var _this2 = this;

    window.Echo.channel("KitchenQueueOrderFetchOn").listen(".KitchenQueueOrderFetchAs", function (e) {
      if (_this2.status === true && !_this2.self.id) {
        _this2.playSound(); //console.log(this.playSound());


        _this2.start();
      }
    });
  },
  computed: _objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_2__["mapGetters"])({
    self: "kitchenQueueOrder/self"
  }))
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/shabuNoonee/kitchen/queueOrder/nextToWaitress.vue?vue&type=template&id=57c540b2&":
/*!************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/shabuNoonee/kitchen/queueOrder/nextToWaitress.vue?vue&type=template&id=57c540b2& ***!
  \************************************************************************************************************************************************************************************************************************************************/
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
      _vm.self.id
        ? _c(
            "v-card",
            [
              _c(
                "v-card-title",
                [
                  _c("h3", [_vm._v("# " + _vm._s(_vm.self.id))]),
                  _vm._v(" "),
                  _c("v-spacer"),
                  _vm._v(" "),
                  _c("h5", [
                    _vm._v("ทั้งหมด " + _vm._s(_vm.sumQuantity) + " ถาด")
                  ])
                ],
                1
              ),
              _vm._v(" "),
              _c("v-divider", { staticClass: "ma-0" }),
              _vm._v(" "),
              _c(
                "v-card-text",
                [
                  _c("v-simple-table", [
                    _c(
                      "tbody",
                      _vm._l(_vm.self.table_order_details, function(
                        table_order_detail
                      ) {
                        return _c("tr", { key: table_order_detail.id }, [
                          _c("td", [
                            _c("h2", { staticClass: "mt-2" }, [
                              _vm._v(_vm._s(table_order_detail.product.title))
                            ])
                          ]),
                          _vm._v(" "),
                          _c("td", { staticClass: "text-right" }, [
                            _c("h2", { staticClass: "mt-2" }, [
                              _vm._v(_vm._s(table_order_detail.quantity))
                            ])
                          ])
                        ])
                      }),
                      0
                    )
                  ])
                ],
                1
              ),
              _vm._v(" "),
              _c("v-divider", { staticClass: "ma-0" })
            ],
            1
          )
        : _c("v-alert", { attrs: { dense: "", type: "info" } }, [
            _c("strong", [_vm._v("ยังไม่มีรายการอาหาร")])
          ]),
      _vm._v(" "),
      _c(
        "v-bottom-navigation",
        { staticClass: "yellow darken-4", attrs: { app: "", grow: "" } },
        [
          _c(
            "v-btn",
            {
              attrs: { block: "", disabled: !_vm.self.id },
              on: {
                click: function($event) {
                  return _vm.save()
                }
              }
            },
            [
              _c("span", { staticClass: "white--text" }, [_vm._v(" ต่อไป ")]),
              _vm._v(" "),
              _c("v-icon", { staticClass: "white--text" }, [
                _vm._v("arrow_forward_ios")
              ])
            ],
            1
          )
        ],
        1
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/kitchen/kitchenQueueOrder.vue?vue&type=template&id=13cbfc86&":
/*!***********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/kitchen/kitchenQueueOrder.vue?vue&type=template&id=13cbfc86& ***!
  \***********************************************************************************************************************************************************************************************************************/
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
      _c(
        "v-card",
        { staticClass: "mb-4" },
        [
          _c(
            "v-card-title",
            [
              _c("h3", [_vm._v("ห้องครัว")]),
              _vm._v(" "),
              _c("v-spacer"),
              _vm._v(" "),
              _c("v-switch", {
                attrs: { inset: "" },
                on: {
                  click: function($event) {
                    return _vm.start()
                  }
                },
                model: {
                  value: _vm.status,
                  callback: function($$v) {
                    _vm.status = $$v
                  },
                  expression: "status"
                }
              })
            ],
            1
          )
        ],
        1
      ),
      _vm._v(" "),
      _c("nextToWaitress", { attrs: { propStatus: _vm.status } })
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/shabuNoonee/kitchen/queueOrder/nextToWaitress.vue":
/*!***********************************************************************************!*\
  !*** ./resources/js/components/shabuNoonee/kitchen/queueOrder/nextToWaitress.vue ***!
  \***********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _nextToWaitress_vue_vue_type_template_id_57c540b2___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./nextToWaitress.vue?vue&type=template&id=57c540b2& */ "./resources/js/components/shabuNoonee/kitchen/queueOrder/nextToWaitress.vue?vue&type=template&id=57c540b2&");
/* harmony import */ var _nextToWaitress_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./nextToWaitress.vue?vue&type=script&lang=js& */ "./resources/js/components/shabuNoonee/kitchen/queueOrder/nextToWaitress.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _nextToWaitress_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _nextToWaitress_vue_vue_type_template_id_57c540b2___WEBPACK_IMPORTED_MODULE_0__["render"],
  _nextToWaitress_vue_vue_type_template_id_57c540b2___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/shabuNoonee/kitchen/queueOrder/nextToWaitress.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/shabuNoonee/kitchen/queueOrder/nextToWaitress.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************!*\
  !*** ./resources/js/components/shabuNoonee/kitchen/queueOrder/nextToWaitress.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_nextToWaitress_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./nextToWaitress.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/shabuNoonee/kitchen/queueOrder/nextToWaitress.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_nextToWaitress_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/shabuNoonee/kitchen/queueOrder/nextToWaitress.vue?vue&type=template&id=57c540b2&":
/*!******************************************************************************************************************!*\
  !*** ./resources/js/components/shabuNoonee/kitchen/queueOrder/nextToWaitress.vue?vue&type=template&id=57c540b2& ***!
  \******************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_nextToWaitress_vue_vue_type_template_id_57c540b2___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./nextToWaitress.vue?vue&type=template&id=57c540b2& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/shabuNoonee/kitchen/queueOrder/nextToWaitress.vue?vue&type=template&id=57c540b2&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_nextToWaitress_vue_vue_type_template_id_57c540b2___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_nextToWaitress_vue_vue_type_template_id_57c540b2___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/pages/kitchen/kitchenQueueOrder.vue":
/*!**********************************************************!*\
  !*** ./resources/js/pages/kitchen/kitchenQueueOrder.vue ***!
  \**********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _kitchenQueueOrder_vue_vue_type_template_id_13cbfc86___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./kitchenQueueOrder.vue?vue&type=template&id=13cbfc86& */ "./resources/js/pages/kitchen/kitchenQueueOrder.vue?vue&type=template&id=13cbfc86&");
/* harmony import */ var _kitchenQueueOrder_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./kitchenQueueOrder.vue?vue&type=script&lang=js& */ "./resources/js/pages/kitchen/kitchenQueueOrder.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _kitchenQueueOrder_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _kitchenQueueOrder_vue_vue_type_template_id_13cbfc86___WEBPACK_IMPORTED_MODULE_0__["render"],
  _kitchenQueueOrder_vue_vue_type_template_id_13cbfc86___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/kitchen/kitchenQueueOrder.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/pages/kitchen/kitchenQueueOrder.vue?vue&type=script&lang=js&":
/*!***********************************************************************************!*\
  !*** ./resources/js/pages/kitchen/kitchenQueueOrder.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_kitchenQueueOrder_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./kitchenQueueOrder.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/kitchen/kitchenQueueOrder.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_kitchenQueueOrder_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/kitchen/kitchenQueueOrder.vue?vue&type=template&id=13cbfc86&":
/*!*****************************************************************************************!*\
  !*** ./resources/js/pages/kitchen/kitchenQueueOrder.vue?vue&type=template&id=13cbfc86& ***!
  \*****************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_kitchenQueueOrder_vue_vue_type_template_id_13cbfc86___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./kitchenQueueOrder.vue?vue&type=template&id=13cbfc86& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/kitchen/kitchenQueueOrder.vue?vue&type=template&id=13cbfc86&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_kitchenQueueOrder_vue_vue_type_template_id_13cbfc86___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_kitchenQueueOrder_vue_vue_type_template_id_13cbfc86___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);
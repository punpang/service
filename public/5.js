(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[5],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/layouts/overlay.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/layouts/overlay.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************/
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
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ['overlay']
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/testModule.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/testModule.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _js_layouts_overlay__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @/js/layouts/overlay */ "./resources/js/layouts/overlay.vue");


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
    overlay: _js_layouts_overlay__WEBPACK_IMPORTED_MODULE_1__["default"]
  },
  data: function data() {
    return {
      countDown: 0,
      step: 1,
      form: {
        phoneNumber: ""
      },
      formVerify: {
        phoneNumber: "",
        ref1: "",
        ref2: ""
      },
      overlay: false
    };
  },
  methods: {
    countDownTimer: function countDownTimer() {
      var _this = this;

      setTimeout(function () {
        _this.countDown -= 1;

        _this.countDownTimer();
      }, 1000);
    },
    addTime: function addTime() {
      this.countDown = 60;
    },
    sendOTP: function sendOTP() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee() {
        var res;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                if (!_this2.$refs.formCreateOTP.validate()) {
                  _context.next = 8;
                  break;
                }

                _this2.overlay = true;
                _context.next = 4;
                return _this2.$store.dispatch("smsOTP/sendOTP", _this2.form);

              case 4:
                res = _context.sent;

                if (res.data.status == 200) {
                  _this2.$toast.success(res.data.message);

                  _this2.formVerify = {
                    phoneNumber: _this2.form.phoneNumber,
                    ref1: res.data.data.ref1,
                    ref2: ""
                  };
                  _this2.step = 2;
                } else if (res.data.status == 500) {
                  _this2.$toast.error(res.data.message);

                  _this2.step = 3;
                } else {
                  _this2.$toast.warning("ระบบขัดข้อง : โปรดลองใหม่อีกครั้งภายหลัง");
                }

                _this2.addTime();

                _this2.overlay = false;

              case 8:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    clearPhone: function clearPhone() {
      this.form.phoneNumber = "";
      this.step = 1;
    },
    clickVerify: function clickVerify() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee2() {
        var res;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                if (!_this3.$refs.formVerifyOTP.validate()) {
                  _context2.next = 7;
                  break;
                }

                _this3.overlay = true;
                _context2.next = 4;
                return _this3.$store.dispatch("smsOTP/verify", _this3.formVerify);

              case 4:
                res = _context2.sent;

                if (res.status == 200) {
                  if (res.data.status == 200 || res.data.verified == true) {
                    _this3.$toast.success(res.data.message);
                  } else if (res.data.status == 500) {
                    _this3.$toast.warning(res.data.message);
                  } else if (res.data.status == 501) {
                    _this3.$toast.error(res.data.message);
                  }
                }

                _this3.overlay = false;

              case 7:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/layouts/overlay.vue?vue&type=template&id=0888f9bc&":
/*!*******************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/layouts/overlay.vue?vue&type=template&id=0888f9bc& ***!
  \*******************************************************************************************************************************************************************************************************/
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
    "v-overlay",
    { attrs: { value: _vm.overlay } },
    [
      _c("v-progress-circular", {
        attrs: {
          indeterminate: "",
          size: this.$store.getters["main/sizeOverlay"]
        }
      })
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/testModule.vue?vue&type=template&id=056aa8c7&":
/*!********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/testModule.vue?vue&type=template&id=056aa8c7& ***!
  \********************************************************************************************************************************************************************************************************/
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
        { staticClass: "mx-auto", attrs: { "max-width": "400" } },
        [
          _c(
            "v-form",
            { ref: "formCreateOTP", attrs: { "lazy-validation": "" } },
            [
              _vm.step == 1
                ? _c(
                    "v-card-text",
                    [
                      _c("v-text-field", {
                        staticClass: "mb-0",
                        attrs: {
                          outlined: "",
                          label: "หมายเลขโทรศัพท์",
                          type: "number",
                          pattern: "\\d*",
                          autofocus: "",
                          counter: 10,
                          rules: [
                            function(v) {
                              return !!v || "ห้ามเว้นว่าง"
                            },
                            function(v) {
                              return (
                                v.length == 10 || "กรอกเบอร์โทร 10 หลักเท่านั้น"
                              )
                            },
                            function(v) {
                              var pattern = /[0]{1}[0-9]{9}/
                              return (
                                pattern.test(v) ||
                                "กรุณาขึ้นต้นด้วยเลข 0 และกรอกเบอร์โทร 10 หลักเท่านั้น"
                              )
                            }
                          ],
                          "prepend-icon": "call"
                        },
                        model: {
                          value: _vm.form.phoneNumber,
                          callback: function($$v) {
                            _vm.$set(_vm.form, "phoneNumber", $$v)
                          },
                          expression: "form.phoneNumber"
                        }
                      }),
                      _vm._v(" "),
                      _c(
                        "v-btn",
                        {
                          attrs: { color: "info", block: "", large: "" },
                          on: {
                            click: function($event) {
                              _vm.countDownTimer(), _vm.sendOTP()
                            }
                          }
                        },
                        [
                          _c("v-icon", { attrs: { left: "" } }, [
                            _vm._v("sms")
                          ]),
                          _vm._v("\n          รับรหัส OTP\n        ")
                        ],
                        1
                      )
                    ],
                    1
                  )
                : _vm._e()
            ],
            1
          ),
          _vm._v(" "),
          _vm.step == 2
            ? _c(
                "v-card-text",
                [
                  _c(
                    "v-row",
                    [
                      _c(
                        "v-col",
                        {
                          staticClass: "pb-0",
                          attrs: { cols: "12", md: "12" }
                        },
                        [
                          _c("p", { staticClass: "subtitle-1 text-center" }, [
                            _vm._v(
                              "\n            รหัสยืนยันตัวตน จะถูกส่งไปทาง SMS ที่\n          "
                            )
                          ]),
                          _vm._v(" "),
                          _c(
                            "p",
                            { staticClass: "subtitle-1 mb-0 text-center" },
                            [
                              _vm._v(
                                "\n            " +
                                  _vm._s(_vm.form.phoneNumber) +
                                  "\n          "
                              )
                            ]
                          )
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "v-col",
                        { attrs: { cols: "12", md: "12" } },
                        [
                          _c(
                            "v-form",
                            {
                              ref: "formVerifyOTP",
                              attrs: { "lazy-validation": "" }
                            },
                            [
                              _c("v-text-field", {
                                staticClass: "mb-0",
                                attrs: {
                                  outlined: "",
                                  placeholder: "OTP",
                                  large: "",
                                  type: "number",
                                  pattern: "\\d*",
                                  autofocus: "",
                                  counter: 6,
                                  rules: [
                                    function(v) {
                                      return !!v || "ห้ามเว้นว่าง"
                                    },
                                    function(v) {
                                      var pattern = /[0-9]{6}/
                                      return (
                                        pattern.test(v) ||
                                        "โปรดกรอกเฉพาะตัวเลข 6 หลัก เท่านั้น"
                                      )
                                    },
                                    function(v) {
                                      return (
                                        v.length == 6 ||
                                        "โปรดกรอกเฉพาะตัวเลข 6 หลัก เท่านั้น"
                                      )
                                    }
                                  ]
                                },
                                model: {
                                  value: _vm.formVerify.ref2,
                                  callback: function($$v) {
                                    _vm.$set(_vm.formVerify, "ref2", $$v)
                                  },
                                  expression: "formVerify.ref2"
                                }
                              }),
                              _vm._v(" "),
                              _c(
                                "v-btn",
                                {
                                  attrs: {
                                    color: "success",
                                    block: "",
                                    large: ""
                                  },
                                  on: {
                                    click: function($event) {
                                      return _vm.clickVerify()
                                    }
                                  }
                                },
                                [_vm._v("ยืนยันตัวตน")]
                              ),
                              _vm._v(" "),
                              _c(
                                "p",
                                {
                                  directives: [
                                    {
                                      name: "show",
                                      rawName: "v-show",
                                      value: _vm.formVerify.ref1,
                                      expression: "formVerify.ref1"
                                    }
                                  ],
                                  staticClass:
                                    "mb-0 mt-4 subtitle-1 text-center"
                                },
                                [
                                  _vm._v(
                                    "\n              อ้างอิง : " +
                                      _vm._s(_vm.formVerify.ref1) +
                                      "\n            "
                                  )
                                ]
                              )
                            ],
                            1
                          )
                        ],
                        1
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _vm.countDown > 0
                    ? _c(
                        "p",
                        {
                          staticClass:
                            "red--text text-center mt-4 mb-0 subtitle-1"
                        },
                        [
                          _vm._v(
                            "\n        กรุณารอ " +
                              _vm._s(_vm.countDown) +
                              ' วินาที ก่อนกด "ส่งอีกครั้ง" อีกครั้ง\n      '
                          )
                        ]
                      )
                    : _c(
                        "p",
                        { staticClass: "text-center mt-4 mb-0 subtitle-1" },
                        [
                          _c(
                            "b",
                            {
                              on: {
                                click: function($event) {
                                  return _vm.sendOTP()
                                }
                              }
                            },
                            [_vm._v("ส่งอีกครั้ง")]
                          ),
                          _vm._v(" |\n        "),
                          _c(
                            "b",
                            {
                              on: {
                                click: function($event) {
                                  return _vm.clearPhone()
                                }
                              }
                            },
                            [_vm._v("เปลี่ยนหมายเลข")]
                          )
                        ]
                      )
                ],
                1
              )
            : _vm._e(),
          _vm._v(" "),
          _vm.step == 3
            ? _c("v-card-text", [
                _c("p", { staticClass: "text-center mb-0 subtitle-1" }, [
                  _c(
                    "b",
                    {
                      on: {
                        click: function($event) {
                          return _vm.sendOTP()
                        }
                      }
                    },
                    [_vm._v("ส่งอีกครั้ง")]
                  ),
                  _vm._v(" |\n        "),
                  _c(
                    "b",
                    {
                      on: {
                        click: function($event) {
                          return _vm.clearPhone()
                        }
                      }
                    },
                    [_vm._v("เปลี่ยนหมายเลข")]
                  )
                ])
              ])
            : _vm._e()
        ],
        1
      ),
      _vm._v(" "),
      _c("overlay", { attrs: { overlay: _vm.overlay } })
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/layouts/overlay.vue":
/*!******************************************!*\
  !*** ./resources/js/layouts/overlay.vue ***!
  \******************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _overlay_vue_vue_type_template_id_0888f9bc___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./overlay.vue?vue&type=template&id=0888f9bc& */ "./resources/js/layouts/overlay.vue?vue&type=template&id=0888f9bc&");
/* harmony import */ var _overlay_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./overlay.vue?vue&type=script&lang=js& */ "./resources/js/layouts/overlay.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _overlay_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _overlay_vue_vue_type_template_id_0888f9bc___WEBPACK_IMPORTED_MODULE_0__["render"],
  _overlay_vue_vue_type_template_id_0888f9bc___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/layouts/overlay.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/layouts/overlay.vue?vue&type=script&lang=js&":
/*!*******************************************************************!*\
  !*** ./resources/js/layouts/overlay.vue?vue&type=script&lang=js& ***!
  \*******************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_overlay_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./overlay.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/layouts/overlay.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_overlay_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/layouts/overlay.vue?vue&type=template&id=0888f9bc&":
/*!*************************************************************************!*\
  !*** ./resources/js/layouts/overlay.vue?vue&type=template&id=0888f9bc& ***!
  \*************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_overlay_vue_vue_type_template_id_0888f9bc___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./overlay.vue?vue&type=template&id=0888f9bc& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/layouts/overlay.vue?vue&type=template&id=0888f9bc&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_overlay_vue_vue_type_template_id_0888f9bc___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_overlay_vue_vue_type_template_id_0888f9bc___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/pages/testModule.vue":
/*!*******************************************!*\
  !*** ./resources/js/pages/testModule.vue ***!
  \*******************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _testModule_vue_vue_type_template_id_056aa8c7___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./testModule.vue?vue&type=template&id=056aa8c7& */ "./resources/js/pages/testModule.vue?vue&type=template&id=056aa8c7&");
/* harmony import */ var _testModule_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./testModule.vue?vue&type=script&lang=js& */ "./resources/js/pages/testModule.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _testModule_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _testModule_vue_vue_type_template_id_056aa8c7___WEBPACK_IMPORTED_MODULE_0__["render"],
  _testModule_vue_vue_type_template_id_056aa8c7___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/testModule.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/pages/testModule.vue?vue&type=script&lang=js&":
/*!********************************************************************!*\
  !*** ./resources/js/pages/testModule.vue?vue&type=script&lang=js& ***!
  \********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_testModule_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./testModule.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/testModule.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_testModule_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/testModule.vue?vue&type=template&id=056aa8c7&":
/*!**************************************************************************!*\
  !*** ./resources/js/pages/testModule.vue?vue&type=template&id=056aa8c7& ***!
  \**************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_testModule_vue_vue_type_template_id_056aa8c7___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./testModule.vue?vue&type=template&id=056aa8c7& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/testModule.vue?vue&type=template&id=056aa8c7&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_testModule_vue_vue_type_template_id_056aa8c7___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_testModule_vue_vue_type_template_id_056aa8c7___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);
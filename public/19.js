(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[19],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/lucky/register.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/lucky/register.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);


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
/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      datas: {
        number_of_right: "",
        customers: {
          name: "",
          phone: ""
        }
      },
      otp: "",
      verify_otp: "xxxx",
      nors: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
      //number of rights
      rules: {
        name: [function (v) {
          return !!v || "ห้ามเว้นว่าง";
        }],
        phone: [function (v) {
          return !!v || "ห้ามเว้นว่าง";
        }, function (v) {
          return v.length == 10 || "กรอกเบอร์โทร 10 หลักเท่านั้น";
        }, function (v) {
          var pattern = /[0]{1}[0-9]{9}/;
          return pattern.test(v) || "กรุณาขึ้นต้นด้วยเลข 0 และกรอกเบอร์โทร 10 หลักเท่านั้น";
        }],
        otp: [function (v) {
          return !!v || "ห้ามเว้นว่าง";
        }, function (v) {
          return v.length == 4 || "กรอกรหัส OTP 4 หลัก";
        }, function (v) {
          var pattern = /[0-9]{4}/;
          return pattern.test(v) || "กรุณกรอกรหัส OTP 4 หลัก";
        }],
        nors: [function (v) {
          return !!v || "ห้ามเว้นว่าง";
        }]
      }
    };
  },
  methods: {
    get_otp: function get_otp() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee() {
        var loader, random_otp, data, res;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                if (!_this.$refs.formRegister.validate()) {
                  _context.next = 10;
                  break;
                }

                loader = _this.$loading.show();
                random_otp = Math.floor(1000 + Math.random() * 9000);
                _this.verify_otp = random_otp;
                data = {
                  phone: _this.datas.customers.phone,
                  random_otp: random_otp
                };
                _context.next = 7;
                return _this.$store.dispatch("orderLuckyReward/getOTP", data);

              case 7:
                res = _context.sent;
                /// TEST START ///
                // const res = {
                //   data: {
                //     success: true,
                //     message: "SMS SUCCESS !!",
                //   },
                // };
                // this.otp = random_otp;
                /// TEST END ///
                loader.hide();

                if (res.data.success === true) {
                  _this.$swal({
                    title: res.data.message,
                    icon: "success",
                    allowOutsideClick: false,
                    confirmButtonText: "\u0E40\u0E23\u0E35\u0E22\u0E1A\u0E23\u0E49\u0E2D\u0E22"
                  });
                } else {
                  _this.$swal({
                    title: "เกิดข้อผิดพลาด",
                    icon: "error",
                    allowOutsideClick: false,
                    confirmButtonText: "\u0E23\u0E31\u0E1A\u0E17\u0E23\u0E32\u0E1A"
                  });
                }

              case 10:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    register: function register() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee2() {
        var loader, data, res;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                if (!(_this2.$refs.formRegister.validate() && _this2.$refs.formNORS.validate() && _this2.verify_otp == _this2.otp)) {
                  _context2.next = 9;
                  break;
                }

                loader = _this2.$loading.show();
                data = _this2.datas;
                _context2.next = 5;
                return _this2.$store.dispatch("orderLuckyReward/register", data);

              case 5:
                res = _context2.sent;
                loader.hide();

                if (res.data.success === true) {
                  _this2.$swal({
                    title: res.data.message,
                    icon: "success",
                    allowOutsideClick: false,
                    confirmButtonText: "\u0E40\u0E23\u0E35\u0E22\u0E1A\u0E23\u0E49\u0E2D\u0E22"
                  });
                }

                _this2.reset();

              case 9:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    reset: function reset() {
      this.datas = {
        number_of_right: "",
        customers: {
          name: "",
          phone: ""
        }
      };
      this.otp = "";
      this.verify_otp = "xxxx";
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/lucky/register.vue?vue&type=template&id=f654eada&":
/*!************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/lucky/register.vue?vue&type=template&id=f654eada& ***!
  \************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _c(
        "v-card",
        [
          _c("v-card-title", [_c("h2", [_vm._v("ลงทะเบียนลุ้นโชค")])]),
          _vm._v(" "),
          _c(
            "v-card-text",
            [
              _c(
                "v-form",
                { ref: "formRegister", attrs: { "lazy-validation": "" } },
                [
                  _c(
                    "v-row",
                    { attrs: { justify: "center" } },
                    [
                      _c(
                        "v-col",
                        { attrs: { md: "5" } },
                        [
                          _c("v-text-field", {
                            attrs: {
                              label: "ชื่อลูกค้า",
                              "prepend-icon": "person",
                              outlined: "",
                              "hide-details": "",
                              rules: _vm.rules.name,
                              autofocus: "",
                            },
                            model: {
                              value: _vm.datas.customers.name,
                              callback: function ($$v) {
                                _vm.$set(_vm.datas.customers, "name", $$v)
                              },
                              expression: "datas.customers.name",
                            },
                          }),
                        ],
                        1
                      ),
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "v-row",
                    { attrs: { justify: "center" } },
                    [
                      _c(
                        "v-col",
                        { attrs: { md: "5" } },
                        [
                          _c("v-text-field", {
                            attrs: {
                              label: "เบอร์โทรลูกค้า",
                              "prepend-icon": "phone",
                              outlined: "",
                              "hide-details": "",
                              pattern: "\\d*",
                              type: "number",
                              rules: _vm.rules.phone,
                            },
                            model: {
                              value: _vm.datas.customers.phone,
                              callback: function ($$v) {
                                _vm.$set(_vm.datas.customers, "phone", $$v)
                              },
                              expression: "datas.customers.phone",
                            },
                          }),
                        ],
                        1
                      ),
                    ],
                    1
                  ),
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "v-row",
                { staticClass: "mt-3", attrs: { justify: "center" } },
                [
                  _c(
                    "v-col",
                    { attrs: { md: "3", cols: "7" } },
                    [
                      _c("v-text-field", {
                        attrs: {
                          label: "OTP 4 หลัก",
                          "prepend-icon": "vpn_key",
                          outlined: "",
                          "hide-details": "",
                          pattern: "\\d*",
                          type: "number",
                          rules: _vm.rules.otp,
                        },
                        model: {
                          value: _vm.otp,
                          callback: function ($$v) {
                            _vm.otp = $$v
                          },
                          expression: "otp",
                        },
                      }),
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "v-col",
                    { attrs: { md: "2", cols: "5" } },
                    [
                      _c(
                        "v-btn",
                        {
                          staticClass: "success",
                          attrs: { block: "", height: "100%", large: "" },
                          on: { click: _vm.get_otp },
                        },
                        [
                          _c("v-icon", { attrs: { left: "" } }, [
                            _vm._v("sms"),
                          ]),
                          _vm._v("\n            รับรหัส\n          "),
                        ],
                        1
                      ),
                    ],
                    1
                  ),
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "v-form",
                { ref: "formNORS", attrs: { "lazy-validation": "" } },
                [
                  _vm.verify_otp == _vm.otp
                    ? _c(
                        "div",
                        { staticClass: "mt-3" },
                        [
                          _c(
                            "v-row",
                            { attrs: { justify: "center" } },
                            [
                              _c(
                                "v-col",
                                { attrs: { md: "5" } },
                                [
                                  _c("v-select", {
                                    attrs: {
                                      label: "จำนวนสิทธิ์",
                                      "prepend-icon": "casino",
                                      outlined: "",
                                      "hide-details": "",
                                      items: _vm.nors,
                                      "item-value": "value",
                                      rules: _vm.rules.nors,
                                    },
                                    model: {
                                      value: _vm.datas.number_of_right,
                                      callback: function ($$v) {
                                        _vm.$set(
                                          _vm.datas,
                                          "number_of_right",
                                          $$v
                                        )
                                      },
                                      expression: "datas.number_of_right",
                                    },
                                  }),
                                ],
                                1
                              ),
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _c(
                            "v-row",
                            { attrs: { justify: "center" } },
                            [
                              _c(
                                "v-col",
                                { staticClass: "pb-0", attrs: { md: "5" } },
                                [
                                  _c(
                                    "v-btn",
                                    {
                                      staticClass: "success",
                                      attrs: { block: "", large: "" },
                                      on: { click: _vm.register },
                                    },
                                    [
                                      _vm._v(
                                        "\n                ลงทะเบียน\n              "
                                      ),
                                    ]
                                  ),
                                ],
                                1
                              ),
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _c(
                            "v-row",
                            { attrs: { justify: "center" } },
                            [
                              _c(
                                "v-col",
                                { attrs: { md: "5" } },
                                [
                                  _c(
                                    "v-btn",
                                    {
                                      staticClass: "error",
                                      attrs: { block: "", large: "" },
                                      on: { click: _vm.reset },
                                    },
                                    [
                                      _vm._v(
                                        "\n                ล้างข้อมูล\n              "
                                      ),
                                    ]
                                  ),
                                ],
                                1
                              ),
                            ],
                            1
                          ),
                        ],
                        1
                      )
                    : _vm._e(),
                ]
              ),
            ],
            1
          ),
        ],
        1
      ),
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/pages/lucky/register.vue":
/*!***********************************************!*\
  !*** ./resources/js/pages/lucky/register.vue ***!
  \***********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _register_vue_vue_type_template_id_f654eada___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./register.vue?vue&type=template&id=f654eada& */ "./resources/js/pages/lucky/register.vue?vue&type=template&id=f654eada&");
/* harmony import */ var _register_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./register.vue?vue&type=script&lang=js& */ "./resources/js/pages/lucky/register.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _register_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _register_vue_vue_type_template_id_f654eada___WEBPACK_IMPORTED_MODULE_0__["render"],
  _register_vue_vue_type_template_id_f654eada___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/lucky/register.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/pages/lucky/register.vue?vue&type=script&lang=js&":
/*!************************************************************************!*\
  !*** ./resources/js/pages/lucky/register.vue?vue&type=script&lang=js& ***!
  \************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_register_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./register.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/lucky/register.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_register_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/lucky/register.vue?vue&type=template&id=f654eada&":
/*!******************************************************************************!*\
  !*** ./resources/js/pages/lucky/register.vue?vue&type=template&id=f654eada& ***!
  \******************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_register_vue_vue_type_template_id_f654eada___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./register.vue?vue&type=template&id=f654eada& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/lucky/register.vue?vue&type=template&id=f654eada&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_register_vue_vue_type_template_id_f654eada___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_register_vue_vue_type_template_id_f654eada___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);
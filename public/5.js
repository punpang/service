(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[5],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/punpang/orders/uploadImage.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/punpang/orders/uploadImage.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************/
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
      response: {
        data: {
          success: true
        }
      },
      previewExample: "",
      previewImages: [],
      form: {
        write: ""
      }
    };
  },
  methods: {
    start: function start() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee() {
        var loader, _ref, data;

        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                loader = _this.$loading.show();
                _this.token = _this.$route.params.token;
                _context.next = 4;
                return axios.get("/api/v1/guest/order/" + _this.token + "/uploadImageByToken");

              case 4:
                _ref = _context.sent;
                data = _ref.data;
                _this.response = data;
                _this.form.write = data.data.order_detail.write;
                loader.hide();

              case 9:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    onFileChangeExample: function onFileChangeExample(image) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee2() {
        var loader, exampleFile, formData, res;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                loader = _this2.$loading.show();
                exampleFile = event.target.files[0];
                formData = new FormData();
                formData.append("image", exampleFile);
                _context2.next = 6;
                return axios.post("/api/v1/guest/order/" + _this2.token + "/uploadImageByToken/example", formData);

              case 6:
                res = _context2.sent;
                loader.hide();
                _context2.next = 10;
                return _this2.start();

              case 10:
                _this2.toast(res);

              case 11:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    onFileChangeImages: function onFileChangeImages(images) {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee3() {
        var loader, Images, formData, i, _res;

        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                loader = _this3.$loading.show();
                Images = event.target.files;
                formData = new FormData();
                i = 0;

              case 4:
                if (!(i < images.length)) {
                  _context3.next = 12;
                  break;
                }

                formData.append("image", Images[i]);
                _context3.next = 8;
                return axios.post("/api/v1/guest/order/" + _this3.token + "/uploadImageByToken/images", formData);

              case 8:
                _res = _context3.sent;

              case 9:
                i++;
                _context3.next = 4;
                break;

              case 12:
                loader.hide();
                _context3.next = 15;
                return _this3.start();

              case 15:
                _this3.toast(res);

                _this3.$refs.formInputImages.reset();

              case 17:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    onFileChangeImagesV1: function onFileChangeImagesV1(images) {
      this.previewImages = [];

      for (var i = 0; i < images.length; i++) {
        this.previewImages.push(URL.createObjectURL(images[i]));
      }
    },
    clickRemoveImage: function clickRemoveImage(id) {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee4() {
        var loader, res;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                loader = _this4.$loading.show();
                _context4.next = 3;
                return axios["delete"]("/api/v1/guest/order/" + _this4.token + "/uploadImageByToken/" + id + "/delete");

              case 3:
                res = _context4.sent;
                loader.hide();
                _context4.next = 7;
                return _this4.start();

              case 7:
                _this4.toast(res);

              case 8:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    clickSubmitUpdateWrite: function clickSubmitUpdateWrite() {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee5() {
        var loader, res;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                loader = _this5.$loading.show();
                _context5.next = 3;
                return axios.post("/api/v1/guest/order/" + _this5.token + "/updateWrite", _this5.form);

              case 3:
                res = _context5.sent;
                loader.hide();
                _context5.next = 7;
                return _this5.start();

              case 7:
                _this5.toast(res);

              case 8:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
      }))();
    },
    toast: function toast(res) {
      if (res.status === 200) {
        if (res.data.success) {
          this.$toast.success(res.data.message);
        } else {
          this.$toast.error(res.data.message);
        }
      } else {
        this.$toast.error("เกิดข้อผิดพลาดบางอย่างขึ้น กรุณาลองอีกครั้ง");
      }
    }
  },
  mounted: function mounted() {
    var _this6 = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee6() {
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee6$(_context6) {
        while (1) {
          switch (_context6.prev = _context6.next) {
            case 0:
              _context6.next = 2;
              return _this6.start();

            case 2:
            case "end":
              return _context6.stop();
          }
        }
      }, _callee6);
    }))();
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/punpang/orders/uploadImage.vue?vue&type=template&id=45da7775&":
/*!************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/punpang/orders/uploadImage.vue?vue&type=template&id=45da7775& ***!
  \************************************************************************************************************************************************************************************************************************/
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
      !_vm.response.success
        ? _c("v-alert", { attrs: { type: "error" } }, [
            _vm._v("\n        " + _vm._s(_vm.response.message) + "\n    ")
          ])
        : _c(
            "v-row",
            [
              _c(
                "v-col",
                { attrs: { cols: "12", md: "6" } },
                [
                  _c(
                    "v-card",
                    [
                      _c("v-card-title", [_vm._v("รูปภาพต้นแบบสินค้า")]),
                      _vm._v(" "),
                      _vm.response.data.example
                        ? _c(
                            "v-card-text",
                            [
                              !_vm.response.data.example_image
                                ? _c(
                                    "div",
                                    [
                                      _c("v-file-input", {
                                        staticClass: "mb-4",
                                        attrs: {
                                          outlined: "",
                                          "prepend-icon": "image",
                                          placeholder: "รูปภาพต้นแบบสินค้า",
                                          accept: "image/*",
                                          "hide-details": "",
                                          rules: [
                                            function(v) {
                                              return !!v
                                            }
                                          ]
                                        },
                                        on: { change: _vm.onFileChangeExample }
                                      }),
                                      _vm._v(" "),
                                      _c(
                                        "v-alert",
                                        { attrs: { type: "info" } },
                                        [_vm._v("โปรดอัปโหลดรูป")]
                                      )
                                    ],
                                    1
                                  )
                                : _c(
                                    "v-img",
                                    {
                                      staticClass: "mb-4",
                                      attrs: {
                                        src: _vm.response.data.example_image.url
                                      }
                                    },
                                    [
                                      _c(
                                        "v-btn",
                                        {
                                          staticClass: "mt-4 ml-4",
                                          attrs: { color: "error" },
                                          on: {
                                            click: function($event) {
                                              return _vm.clickRemoveImage(
                                                _vm.response.data.example_image
                                                  .id
                                              )
                                            }
                                          }
                                        },
                                        [
                                          _c(
                                            "v-icon",
                                            { attrs: { left: "" } },
                                            [_vm._v("delete")]
                                          ),
                                          _vm._v(
                                            "\n                            ลบรูปนี้\n                        "
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
                        : _c(
                            "v-card-text",
                            [
                              _c("v-alert", { attrs: { type: "warning" } }, [
                                _vm._v("คุณไม่มีสิทธิ์อัปโหลดส่วนนี้")
                              ])
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
              _c(
                "v-col",
                { attrs: { cols: "12", md: "6" } },
                [
                  _c(
                    "v-card",
                    [
                      _c("v-card-title", [_vm._v("รูปสำหรับทำสินค้า")]),
                      _vm._v(" "),
                      _c(
                        "v-card-text",
                        [
                          _c(
                            "v-row",
                            [
                              _c(
                                "v-col",
                                { attrs: { cols: "12", md: "9" } },
                                [
                                  _c("v-text-field", {
                                    attrs: {
                                      label: "เขียนข้อความ",
                                      outlined: "",
                                      "hide-details": "",
                                      "prepend-icon": "edit"
                                    },
                                    model: {
                                      value: _vm.form.write,
                                      callback: function($$v) {
                                        _vm.$set(_vm.form, "write", $$v)
                                      },
                                      expression: "form.write"
                                    }
                                  })
                                ],
                                1
                              ),
                              _vm._v(" "),
                              _c(
                                "v-col",
                                { attrs: { cols: "12", md: "3" } },
                                [
                                  _c(
                                    "v-btn",
                                    {
                                      staticClass: "mt-2",
                                      attrs: {
                                        color: "success",
                                        block: "",
                                        disabled:
                                          _vm.form.write ==
                                            _vm.response.data.order_detail
                                              .write || _vm.form.write == ""
                                      },
                                      on: { click: _vm.clickSubmitUpdateWrite }
                                    },
                                    [
                                      _c("v-icon", { attrs: { left: "" } }, [
                                        _vm._v("save")
                                      ]),
                                      _vm._v(
                                        "\n                                บันทึก\n                            "
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
                          _c("v-divider"),
                          _vm._v(" "),
                          _c(
                            "v-form",
                            { ref: "formInputImages" },
                            [
                              _c("v-file-input", {
                                staticClass: "mb-4",
                                attrs: {
                                  multiple: "",
                                  outlined: "",
                                  "prepend-icon": "image",
                                  placeholder: "เลือกรูปที่นี่",
                                  accept: "image/*",
                                  "hide-details": ""
                                },
                                on: { change: _vm.onFileChangeImages }
                              })
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _c(
                            "v-row",
                            _vm._l(_vm.response.data.image, function(image) {
                              return _c(
                                "v-col",
                                {
                                  key: image.id,
                                  attrs: { cols: "12", md: "12" }
                                },
                                [
                                  _c(
                                    "v-img",
                                    { attrs: { src: image.url } },
                                    [
                                      _c(
                                        "v-btn",
                                        {
                                          staticClass: "mt-2 ml-2",
                                          attrs: { color: "primary" },
                                          on: {
                                            click: function($event) {
                                              return _vm.clickRemoveImage(
                                                image.id
                                              )
                                            }
                                          }
                                        },
                                        [
                                          _c(
                                            "v-icon",
                                            { attrs: { left: "" } },
                                            [_vm._v("bookmark")]
                                          ),
                                          _vm._v(
                                            "\n                                    ตั้งเป็นรูปหลัก\n                                "
                                          )
                                        ],
                                        1
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "v-btn",
                                        {
                                          staticClass: "mt-2 ml-2",
                                          attrs: { color: "error" },
                                          on: {
                                            click: function($event) {
                                              return _vm.clickRemoveImage(
                                                image.id
                                              )
                                            }
                                          }
                                        },
                                        [
                                          _c(
                                            "v-icon",
                                            { attrs: { left: "" } },
                                            [_vm._v("delete")]
                                          ),
                                          _vm._v(
                                            "\n                                    ลบรูปนี้\n                                "
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
                            }),
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

/***/ "./resources/js/pages/punpang/orders/uploadImage.vue":
/*!***********************************************************!*\
  !*** ./resources/js/pages/punpang/orders/uploadImage.vue ***!
  \***********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _uploadImage_vue_vue_type_template_id_45da7775___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./uploadImage.vue?vue&type=template&id=45da7775& */ "./resources/js/pages/punpang/orders/uploadImage.vue?vue&type=template&id=45da7775&");
/* harmony import */ var _uploadImage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./uploadImage.vue?vue&type=script&lang=js& */ "./resources/js/pages/punpang/orders/uploadImage.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _uploadImage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _uploadImage_vue_vue_type_template_id_45da7775___WEBPACK_IMPORTED_MODULE_0__["render"],
  _uploadImage_vue_vue_type_template_id_45da7775___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/punpang/orders/uploadImage.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/pages/punpang/orders/uploadImage.vue?vue&type=script&lang=js&":
/*!************************************************************************************!*\
  !*** ./resources/js/pages/punpang/orders/uploadImage.vue?vue&type=script&lang=js& ***!
  \************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_uploadImage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./uploadImage.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/punpang/orders/uploadImage.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_uploadImage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/punpang/orders/uploadImage.vue?vue&type=template&id=45da7775&":
/*!******************************************************************************************!*\
  !*** ./resources/js/pages/punpang/orders/uploadImage.vue?vue&type=template&id=45da7775& ***!
  \******************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_uploadImage_vue_vue_type_template_id_45da7775___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./uploadImage.vue?vue&type=template&id=45da7775& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/punpang/orders/uploadImage.vue?vue&type=template&id=45da7775&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_uploadImage_vue_vue_type_template_id_45da7775___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_uploadImage_vue_vue_type_template_id_45da7775___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);
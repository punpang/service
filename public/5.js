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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
      chooseRemove: false,
      previewExample: "",
      previewImages: [],
      form: {
        write: ""
      },
      chooseRemoveImages: []
    };
  },
  methods: {
    start: function start() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee() {
        var _ref, data;

        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _this.token = _this.$route.params.token;
                _context.next = 3;
                return axios.get("/api/v1/guest/order/" + _this.token + "/uploadImageByToken");

              case 3:
                _ref = _context.sent;
                data = _ref.data;
                _this.response = data;
                _this.form.write = data.data.order_detail.write;

              case 7:
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
                _context2.next = 9;
                return _this2.start();

              case 9:
                loader.hide();

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
        var loader, Images, formData, res, i;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                loader = _this3.$loading.show();
                Images = event.target.files;
                formData = new FormData();

                _this3.$toast.warning("กำลังอัปโหลดรูป " + images.length + " รูป");

                res = {};
                i = 0;

              case 6:
                if (!(i < images.length)) {
                  _context3.next = 15;
                  break;
                }

                formData.append("image", Images[i]);
                _context3.next = 10;
                return axios.post("/api/v1/guest/order/" + _this3.token + "/uploadImageByToken/images", formData);

              case 10:
                res = _context3.sent;

                if (res.data.success) {
                  _this3.$toast.success(res.data.message + " " + (i + 1) + "/" + images.length + " รูป");
                } else {
                  i = images.length;

                  _this3.$toast.error("คุณไม่มีสิทธิ์อัปโหลดส่วนนี้");
                }

              case 12:
                i++;
                _context3.next = 6;
                break;

              case 15:
                _context3.next = 17;
                return _this3.start();

              case 17:
                loader.hide(); //this.toast(res);

              case 18:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    clickRemoveImage: function clickRemoveImage(images) {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee4() {
        var loader, res, index;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                loader = _this4.$loading.show();
                res = {};

                _this4.$toast.warning("กำลังลบรูปภาพ " + images.length + " รูป");

                index = 0;

              case 4:
                if (!(index < images.length)) {
                  _context4.next = 12;
                  break;
                }

                _context4.next = 7;
                return axios["delete"]("/api/v1/guest/order/" + _this4.token + "/uploadImageByToken/" + images[index].id + "/delete");

              case 7:
                res = _context4.sent;

                if (res.data.success) {
                  _this4.$toast.success(res.data.message + " " + (index + 1) + "/" + images.length + " รูป");
                } else {
                  index = images.length;

                  _this4.$toast.error("คุณไม่มีสิทธิ์อัปโหลดส่วนนี้");
                }

              case 9:
                index++;
                _context4.next = 4;
                break;

              case 12:
                _this4.clickRemoveImageCancel();

                _context4.next = 15;
                return _this4.start();

              case 15:
                loader.hide();

              case 16:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    clickImageMain: function clickImageMain(image_id) {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee5() {
        var loader, res;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                loader = _this5.$loading.show();
                _context5.next = 3;
                return axios.post("/api/v1/guest/order/" + _this5.token + "/uploadImageByToken/" + image_id + "/ImageMain");

              case 3:
                res = _context5.sent;
                _context5.next = 6;
                return _this5.start();

              case 6:
                loader.hide();

                _this5.toast(res);

              case 8:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
      }))();
    },
    clickSubmitUpdateWrite: function clickSubmitUpdateWrite() {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee6() {
        var loader, res;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee6$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                loader = _this6.$loading.show();
                _context6.next = 3;
                return axios.post("/api/v1/guest/order/" + _this6.token + "/updateWrite", _this6.form);

              case 3:
                res = _context6.sent;
                _context6.next = 6;
                return _this6.start();

              case 6:
                loader.hide();

                _this6.toast(res);

              case 8:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee6);
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
    },
    clickRemoveImageCancel: function clickRemoveImageCancel() {
      this.chooseRemove = false;
      this.chooseRemoveImages = [];
    }
  },
  mounted: function mounted() {
    var _this7 = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee7() {
      var loader;
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee7$(_context7) {
        while (1) {
          switch (_context7.prev = _context7.next) {
            case 0:
              loader = _this7.$loading.show();
              _context7.next = 3;
              return _this7.start();

            case 3:
              loader.hide();

            case 4:
            case "end":
              return _context7.stop();
          }
        }
      }, _callee7);
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
                                              return _vm.clickRemoveImage([
                                                _vm.response.data.example_image
                                              ])
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
                      _c("v-card-title", [_vm._v("รูปภาพสำหรับทำสินค้า")]),
                      _vm._v(" "),
                      _vm.response.data.image
                        ? _c(
                            "v-card-text",
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
                              }),
                              _vm._v(" "),
                              _c(
                                "v-btn",
                                {
                                  staticClass: "mt-2",
                                  attrs: {
                                    large: "",
                                    color: "success",
                                    block: "",
                                    disabled:
                                      _vm.form.write ==
                                        _vm.response.data.order_detail.write ||
                                      _vm.form.write == ""
                                  },
                                  on: { click: _vm.clickSubmitUpdateWrite }
                                },
                                [
                                  _c("v-icon", { attrs: { left: "" } }, [
                                    _vm._v("save")
                                  ]),
                                  _vm._v(
                                    "\n                        บันทึกข้อความ\n                    "
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
                              _vm.response.data.images.length > 1
                                ? _c("div", [
                                    _vm.response.data.images.length > 1 &&
                                    !_vm.chooseRemove
                                      ? _c(
                                          "div",
                                          [
                                            _c(
                                              "v-btn",
                                              {
                                                staticClass: "mb-2",
                                                attrs: { color: "warning" },
                                                on: {
                                                  click: function($event) {
                                                    _vm.chooseRemove = true
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
                                                  "\n                                เลือกรูปที่ต้องการลบ"
                                                )
                                              ],
                                              1
                                            )
                                          ],
                                          1
                                        )
                                      : _c(
                                          "div",
                                          [
                                            _c(
                                              "v-btn",
                                              {
                                                staticClass: "mb-2",
                                                attrs: {
                                                  color: "error",
                                                  disabled:
                                                    _vm.chooseRemoveImages
                                                      .length == 0
                                                },
                                                on: {
                                                  click: function($event) {
                                                    return _vm.clickRemoveImage(
                                                      _vm.chooseRemoveImages
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
                                                  "\n                                ลบรูปที่เลือกไว้"
                                                )
                                              ],
                                              1
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "v-btn",
                                              {
                                                staticClass: "mb-2",
                                                attrs: { color: "error" },
                                                on: {
                                                  click: function($event) {
                                                    return _vm.clickRemoveImage(
                                                      _vm.response.data.images
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
                                                  "\n                                ลบรูปทั้งหมด"
                                                )
                                              ],
                                              1
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "v-btn",
                                              {
                                                staticClass: "mb-2",
                                                attrs: { color: "warning" },
                                                on: {
                                                  click:
                                                    _vm.clickRemoveImageCancel
                                                }
                                              },
                                              [
                                                _c(
                                                  "v-icon",
                                                  { attrs: { left: "" } },
                                                  [_vm._v("close")]
                                                ),
                                                _vm._v(
                                                  "\n                                ยกเลิก"
                                                )
                                              ],
                                              1
                                            )
                                          ],
                                          1
                                        )
                                  ])
                                : _vm._e(),
                              _vm._v(" "),
                              _vm.response.data.images.length == 0
                                ? _c("v-alert", { attrs: { type: "info" } }, [
                                    _vm._v("โปรดอัปโหลดรูป")
                                  ])
                                : _vm._e(),
                              _vm._v(" "),
                              _vm._l(_vm.response.data.images, function(image) {
                                return _c(
                                  "v-card",
                                  {
                                    key: image.id,
                                    staticClass: "mb-2",
                                    attrs: { outlined: "" }
                                  },
                                  [
                                    _c("v-img", {
                                      attrs: {
                                        src: image.url,
                                        "lazy-src": image.url
                                      },
                                      scopedSlots: _vm._u(
                                        [
                                          {
                                            key: "placeholder",
                                            fn: function() {
                                              return [
                                                _c(
                                                  "v-row",
                                                  {
                                                    staticClass:
                                                      "fill-height ma-0",
                                                    attrs: {
                                                      align: "center",
                                                      justify: "center"
                                                    }
                                                  },
                                                  [
                                                    _c("v-progress-circular", {
                                                      attrs: {
                                                        indeterminate: "",
                                                        color: "grey lighten-5"
                                                      }
                                                    })
                                                  ],
                                                  1
                                                )
                                              ]
                                            },
                                            proxy: true
                                          }
                                        ],
                                        null,
                                        true
                                      )
                                    }),
                                    _vm._v(" "),
                                    _c(
                                      "v-card-text",
                                      { staticClass: "pa-2" },
                                      [
                                        _vm.chooseRemove
                                          ? _c("v-checkbox", {
                                              staticClass: "ma-0",
                                              attrs: {
                                                label: "ลบรูปนี้",
                                                "hide-details": "",
                                                value: image
                                              },
                                              model: {
                                                value: _vm.chooseRemoveImages,
                                                callback: function($$v) {
                                                  _vm.chooseRemoveImages = $$v
                                                },
                                                expression: "chooseRemoveImages"
                                              }
                                            })
                                          : _c(
                                              "div",
                                              { staticClass: "mt-2" },
                                              [
                                                image.main
                                                  ? _c(
                                                      "v-btn",
                                                      {
                                                        attrs: {
                                                          color: "warning",
                                                          text: ""
                                                        },
                                                        on: {
                                                          click: function(
                                                            $event
                                                          ) {
                                                            return _vm.clickImageMain(
                                                              image.id
                                                            )
                                                          }
                                                        }
                                                      },
                                                      [
                                                        _c(
                                                          "v-icon",
                                                          {
                                                            attrs: { left: "" }
                                                          },
                                                          [
                                                            _vm._v(
                                                              "bookmark_border"
                                                            )
                                                          ]
                                                        ),
                                                        _vm._v(
                                                          "\n                                    ยกเลิกรูปหลัก\n                                "
                                                        )
                                                      ],
                                                      1
                                                    )
                                                  : _c(
                                                      "v-btn",
                                                      {
                                                        attrs: {
                                                          color: "primary",
                                                          text: ""
                                                        },
                                                        on: {
                                                          click: function(
                                                            $event
                                                          ) {
                                                            return _vm.clickImageMain(
                                                              image.id
                                                            )
                                                          }
                                                        }
                                                      },
                                                      [
                                                        _c(
                                                          "v-icon",
                                                          {
                                                            attrs: { left: "" }
                                                          },
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
                                                    attrs: {
                                                      color: "error",
                                                      text: ""
                                                    },
                                                    on: {
                                                      click: function($event) {
                                                        return _vm.clickRemoveImage(
                                                          [image]
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
                                  ],
                                  1
                                )
                              })
                            ],
                            2
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
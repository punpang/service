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
/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      response: {
        data: {
          success: true
        }
      },
      previewExample: "",
      previewImages: []
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
                //this.overlay = true;
                _this.token = _this.$route.params.token;
                _context.next = 3;
                return axios.get("/api/v1/guest/order/" + _this.token + "/uploadImageByToken");

              case 3:
                _this.response = _context.sent;

              case 4:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    onFileChangeExample: function onFileChangeExample(image) {
      this.slipFile = event.target.files[0];
      this.previewExample = URL.createObjectURL(image);
    },
    onFileChangeImages: function onFileChangeImages(images) {
      this.previewImages = [];

      for (var i = 0; i < images.length; i++) {
        this.previewImages.push(URL.createObjectURL(images[i]));
      }
    },
    clickRemoveImage: function clickRemoveImage(i) {
      console.log(i);
      this.previewImages.slice(i);
      console.log(this.previewImages);
    }
  },
  mounted: function mounted() {
    this.start();
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
      !_vm.response.data.success
        ? _c("v-alert", { attrs: { type: "error" } }, [
            _vm._v("\n        " + _vm._s(_vm.response.data.message) + "\n    ")
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
                      _c(
                        "v-card-text",
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
                          _c("v-img", {
                            staticClass: "mb-4",
                            attrs: { src: _vm.previewExample }
                          }),
                          _vm._v(
                            "\n                    " +
                              _vm._s(_vm.response.data) +
                              "\n                "
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
              _c(
                "v-col",
                { attrs: { cols: "12", md: "6" } },
                [
                  _c(
                    "v-card",
                    [
                      _c("v-card-title", [_vm._v("รูปภาพต้นแบบสินค้า")]),
                      _vm._v(" "),
                      _c(
                        "v-card-text",
                        [
                          _c("v-file-input", {
                            staticClass: "mb-4",
                            attrs: {
                              multiple: "",
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
                            on: { change: _vm.onFileChangeImages }
                          }),
                          _vm._v(" "),
                          _c(
                            "v-row",
                            _vm._l(_vm.previewImages, function(image, index) {
                              return _c(
                                "v-col",
                                { key: index, attrs: { cols: "12", md: "12" } },
                                [
                                  _c(
                                    "v-img",
                                    { attrs: { src: image } },
                                    [
                                       false
                                        ? undefined
                                        : _vm._e()
                                    ],
                                    1
                                  )
                                ],
                                1
                              )
                            }),
                            1
                          ),
                          _vm._v(
                            "\n\n                    " +
                              _vm._s(_vm.response.data) +
                              "\n                "
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
(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[62],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/test/qr-code-reader.vue?vue&type=script&lang=js":
/*!************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/test/qr-code-reader.vue?vue&type=script&lang=js ***!
  \************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue_qrcode_reader__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-qrcode-reader */ "./node_modules/vue-qrcode-reader/dist/VueQrcodeReader.common.js");
/* harmony import */ var vue_qrcode_reader__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue_qrcode_reader__WEBPACK_IMPORTED_MODULE_0__);

/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    QrcodeCapture: vue_qrcode_reader__WEBPACK_IMPORTED_MODULE_0__["QrcodeCapture"]
  },
  data: function data() {
    return {
      testest: {},
      dshgfui: {}
    };
  },
  methods: {
    asdhasno: function asdhasno() {
      console.log(event);
      console.log(event.target.files[0]);
      this.onDecode(event);
    },
    onDecode: function onDecode(decodedString) {
      console.log("🚀 ~ file: qr-code-reader.vue:18 ~ onDecode ~ decodedString", decodedString);
      // ...
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/test/qr-code-reader.vue?vue&type=template&id=26c3e63b":
/*!**********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/test/qr-code-reader.vue?vue&type=template&id=26c3e63b ***!
  \**********************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", [_vm._v("\n    " + _vm._s(_vm.testest) + "\n    "), _c("v-file-input", {
    attrs: {
      accept: "image/*",
      label: "File input"
    },
    on: {
      decode: _vm.onDecode,
      change: _vm.asdhasno
    },
    model: {
      value: _vm.testest,
      callback: function callback($$v) {
        _vm.testest = $$v;
      },
      expression: "testest"
    }
  }), _vm._v(" "), _c("QrcodeCapture", {
    on: {
      decode: function decode($event) {
        return _vm.onDecode();
      }
    }
  })], 1);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/pages/test/qr-code-reader.vue":
/*!****************************************************!*\
  !*** ./resources/js/pages/test/qr-code-reader.vue ***!
  \****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _qr_code_reader_vue_vue_type_template_id_26c3e63b__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./qr-code-reader.vue?vue&type=template&id=26c3e63b */ "./resources/js/pages/test/qr-code-reader.vue?vue&type=template&id=26c3e63b");
/* harmony import */ var _qr_code_reader_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./qr-code-reader.vue?vue&type=script&lang=js */ "./resources/js/pages/test/qr-code-reader.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _qr_code_reader_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _qr_code_reader_vue_vue_type_template_id_26c3e63b__WEBPACK_IMPORTED_MODULE_0__["render"],
  _qr_code_reader_vue_vue_type_template_id_26c3e63b__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/test/qr-code-reader.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/pages/test/qr-code-reader.vue?vue&type=script&lang=js":
/*!****************************************************************************!*\
  !*** ./resources/js/pages/test/qr-code-reader.vue?vue&type=script&lang=js ***!
  \****************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_qr_code_reader_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./qr-code-reader.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/test/qr-code-reader.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_qr_code_reader_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/test/qr-code-reader.vue?vue&type=template&id=26c3e63b":
/*!**********************************************************************************!*\
  !*** ./resources/js/pages/test/qr-code-reader.vue?vue&type=template&id=26c3e63b ***!
  \**********************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_qr_code_reader_vue_vue_type_template_id_26c3e63b__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../node_modules/vue-loader/lib??vue-loader-options!./qr-code-reader.vue?vue&type=template&id=26c3e63b */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/test/qr-code-reader.vue?vue&type=template&id=26c3e63b");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_qr_code_reader_vue_vue_type_template_id_26c3e63b__WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_qr_code_reader_vue_vue_type_template_id_26c3e63b__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);
(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[21],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/lucky/redeem-code.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/lucky/redeem-code.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************/
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
        number_of_right: 0,
        customers: {
          name: "",
          phone: ""
        }
      },
      nors: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10] //number of rights

    };
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/lucky/redeem-code.vue?vue&type=template&id=1ad0b93e&":
/*!***************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/lucky/redeem-code.vue?vue&type=template&id=1ad0b93e& ***!
  \***************************************************************************************************************************************************************************************************************/
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
          _c("v-card-title", [
            _c("h3", [_vm._v("\n      แลกรางวัล (REDEEM CODE)")]),
          ]),
          _vm._v(" "),
          _c(
            "v-card-text",
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
                          label: "เบอร์โทรลูกค้า",
                          "prepend-icon": "phone",
                          outlined: "",
                          "hide-details": "",
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
                          label: "Redeem Code",
                          "prepend-icon": "redeem",
                          outlined: "",
                          "hide-details": "",
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
                    { staticClass: "pb-0", attrs: { md: "5" } },
                    [
                      _c(
                        "v-btn",
                        {
                          staticClass: "success",
                          attrs: { block: "", large: "" },
                        },
                        [_vm._v("\n              ตรวจสอบข้อมูล\n          ")]
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
                        },
                        [_vm._v("\n              ล้างข้อมูล\n          ")]
                      ),
                    ],
                    1
                  ),
                ],
                1
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

/***/ "./resources/js/pages/lucky/redeem-code.vue":
/*!**************************************************!*\
  !*** ./resources/js/pages/lucky/redeem-code.vue ***!
  \**************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _redeem_code_vue_vue_type_template_id_1ad0b93e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./redeem-code.vue?vue&type=template&id=1ad0b93e& */ "./resources/js/pages/lucky/redeem-code.vue?vue&type=template&id=1ad0b93e&");
/* harmony import */ var _redeem_code_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./redeem-code.vue?vue&type=script&lang=js& */ "./resources/js/pages/lucky/redeem-code.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _redeem_code_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _redeem_code_vue_vue_type_template_id_1ad0b93e___WEBPACK_IMPORTED_MODULE_0__["render"],
  _redeem_code_vue_vue_type_template_id_1ad0b93e___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/lucky/redeem-code.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/pages/lucky/redeem-code.vue?vue&type=script&lang=js&":
/*!***************************************************************************!*\
  !*** ./resources/js/pages/lucky/redeem-code.vue?vue&type=script&lang=js& ***!
  \***************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_redeem_code_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./redeem-code.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/lucky/redeem-code.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_redeem_code_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/lucky/redeem-code.vue?vue&type=template&id=1ad0b93e&":
/*!*********************************************************************************!*\
  !*** ./resources/js/pages/lucky/redeem-code.vue?vue&type=template&id=1ad0b93e& ***!
  \*********************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_redeem_code_vue_vue_type_template_id_1ad0b93e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./redeem-code.vue?vue&type=template&id=1ad0b93e& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/lucky/redeem-code.vue?vue&type=template&id=1ad0b93e&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_redeem_code_vue_vue_type_template_id_1ad0b93e___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_redeem_code_vue_vue_type_template_id_1ad0b93e___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);
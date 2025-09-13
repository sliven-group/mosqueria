"use strict";
(self["webpackChunkmosqueira"] = self["webpackChunkmosqueira"] || []).push([["/js/sale"],{

/***/ "./src/js/blocks/sale.js":
/*!*******************************!*\
  !*** ./src/js/blocks/sale.js ***!
  \*******************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _helpers_ajax__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../helpers/ajax */ "./src/js/helpers/ajax.js");
/* global jsVars */

window.addEventListener('load', function () {
  var result = document.getElementById('mos-sale-product');
  var loadMoreBtn = document.getElementById('mos-load-more-sale');
  if (loadMoreBtn) {
    loadMoreBtn.addEventListener('click', function (e) {
      e.preventDefault();
      //const page = loadMoreBtn.getAttribute('data-page');
      var formData = new FormData();
      formData.append('action', 'load_more_product_sale');
      formData.append('nonce', jsVars.nonce);
      //formData.append('page', page);

      loadMoreBtn.textContent = 'CARGANDO...';
      (0,_helpers_ajax__WEBPACK_IMPORTED_MODULE_0__["default"])({
        url: jsVars.ajax_url,
        method: 'POST',
        params: formData,
        async: true,
        done: function done(response) {
          if (response.status) {
            result.innerHTML += response.html;
          }
          if (!response.enabled) {
            loadMoreBtn.classList.add('ds-none');
          }
          loadMoreBtn.dataset.page = response.page;
        },
        error: function error(_error) {
          // eslint-disable-next-line no-console
          console.log(_error);
        },
        always: function always() {
          loadMoreBtn.textContent = 'MOSTRAR MÁS';
        }
      });
    });
  }
});

/***/ }),

/***/ "./src/js/helpers/ajax.js":
/*!********************************!*\
  !*** ./src/js/helpers/ajax.js ***!
  \********************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ ajax; }
/* harmony export */ });
function ajax(_ref) {
  var url = _ref.url,
    _ref$method = _ref.method,
    method = _ref$method === void 0 ? 'GET' : _ref$method,
    _ref$params = _ref.params,
    params = _ref$params === void 0 ? {} : _ref$params,
    _ref$async = _ref.async,
    async = _ref$async === void 0 ? true : _ref$async,
    _ref$done = _ref.done,
    done = _ref$done === void 0 ? function () {} : _ref$done,
    _ref$error = _ref.error,
    error = _ref$error === void 0 ? function () {} : _ref$error,
    _ref$always = _ref.always,
    always = _ref$always === void 0 ? function () {} : _ref$always,
    _ref$responseType = _ref.responseType,
    responseType = _ref$responseType === void 0 ? 'json' : _ref$responseType;
  var request = new XMLHttpRequest();
  request.responseType = responseType;
  request.onreadystatechange = function () {
    if (request.readyState === 4) {
      always();
      if (request.status === 200) {
        done(request.response);
      } else {
        error(request.status);
      }
    }
  };
  request.open(method, url, async);
  request.send(params);
}

/***/ })

},
/******/ function(__webpack_require__) { // webpackRuntimeModules
/******/ var __webpack_exec__ = function(moduleId) { return __webpack_require__(__webpack_require__.s = moduleId); }
/******/ var __webpack_exports__ = (__webpack_exec__("./src/js/blocks/sale.js"));
/******/ }
]);
//# sourceMappingURL=sale.js.map
"use strict";
(self["webpackChunkmosqueira"] = self["webpackChunkmosqueira"] || []).push([["/js/unsubscribe"],{

/***/ "./src/js/blocks/unsubscribe.js":
/*!**************************************!*\
  !*** ./src/js/blocks/unsubscribe.js ***!
  \**************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _helpers_ajax__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../helpers/ajax */ "./src/js/helpers/ajax.js");
/* harmony import */ var just_validate__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! just-validate */ "./node_modules/just-validate/dist/just-validate.es.js");
/* global jsVars */


window.addEventListener('load', function () {
  var form = document.getElementById('mos-form-unsubscribe');
  var button = form.querySelector('#mos-form-unsubscribe-btn');
  var messageResult = document.getElementById('mos-form-unsubscribe-message');
  var validation = new just_validate__WEBPACK_IMPORTED_MODULE_1__["default"](form);
  var formData = new FormData();
  validation.addField('#unsubscribe-email', [{
    rule: 'required',
    errorMessage: 'Email es requerido'
  }, {
    rule: 'email',
    errorMessage: 'Email no tiene un formato valido'
  }]).onSuccess(function () {
    button.textContent = 'CARGANDO...';
    formData.append('action', 'mos_unsubscribe');
    formData.append('user_email', document.querySelector('input[name="unsubscribe-email"]').value);
    (0,_helpers_ajax__WEBPACK_IMPORTED_MODULE_0__["default"])({
      url: jsVars.ajax_url,
      method: 'POST',
      params: formData,
      async: true,
      done: function done(response) {
        if (response.success) {
          if (messageResult) {
            messageResult.innerHTML = response.data.message;
          }
        } else {
          if (messageResult) {
            messageResult.innerHTML = response.data.error;
          }
        }
      },
      error: function error(status) {
        //console.error('Error al procesar la solicitud:', status);
        if (messageResult) {
          messageResult.innerHTML = 'Error al procesar la solicitud:' + status;
        }
      },
      always: function always() {
        button.textContent = 'DESUSCRIBIRSE';
        setTimeout(function () {
          messageResult.innerHTML = '';
        }, 5000);
        //console.log('La solicitud AJAX ha finalizado.');
      }
    });
  });
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
/******/ __webpack_require__.O(0, ["/js/vendor"], function() { return __webpack_exec__("./src/js/blocks/unsubscribe.js"); });
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=unsubscribe.js.map
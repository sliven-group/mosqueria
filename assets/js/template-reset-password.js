"use strict";
(self["webpackChunkmosqueira"] = self["webpackChunkmosqueira"] || []).push([["/js/template-reset-password"],{

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

/***/ }),

/***/ "./src/js/templates/template-reset-password.js":
/*!*****************************************************!*\
  !*** ./src/js/templates/template-reset-password.js ***!
  \*****************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _helpers_ajax__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../helpers/ajax */ "./src/js/helpers/ajax.js");
/* harmony import */ var just_validate__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! just-validate */ "./node_modules/just-validate/dist/just-validate.es.js");
/* global jsVars */


window.addEventListener('load', function () {
  var form = document.getElementById('mos-form-password-create');
  var button = form.querySelector('#mos-form-password-create-btn');
  var messageResult = document.querySelector('#mos-form-password-create-message p');
  var messageResultBtn = document.querySelector('#mos-form-password-create-message button');
  var validation = new just_validate__WEBPACK_IMPORTED_MODULE_1__["default"](form);
  var formData = new FormData();
  validation.addField('#email-password', [{
    rule: 'required',
    errorMessage: 'Email es requerido'
  }, {
    rule: 'email',
    errorMessage: 'Email no tiene un formato valido'
  }]).addField('#password-password', [{
    rule: 'required',
    errorMessage: 'La contraseña es requerido'
  }, {
    rule: 'password',
    errorMessage: 'La contraseña debe contener un mínimo de ocho caracteres, al menos una letra y un número'
  }]).addField('#password-password-2', [{
    validator: function validator(value, fields) {
      if (fields['#password-password'] && fields['#password-password'].elem) {
        var repeatPasswordValue = fields['#password-password'].elem.value;
        return value === repeatPasswordValue;
      }
      return true;
    },
    errorMessage: 'La contraseña no coincide'
  }]).onSuccess(function () {
    button.textContent = 'CARGANDO...';
    button.disabled = true;
    formData.append('action', 'reset_password');
    formData.append('user_email', form.querySelector('input[name="email-password"]').value);
    formData.append('user_pass_1', form.querySelector('input[name="password-password"]').value);
    formData.append('user_pass_2', form.querySelector('input[name="password-password-2"]').value);
    formData.append('user_login', form.querySelector('input[name="user_login"]').value);
    formData.append('rp_key', form.querySelector('input[name="rp_key"]').value);
    (0,_helpers_ajax__WEBPACK_IMPORTED_MODULE_0__["default"])({
      url: jsVars.ajax_url,
      method: 'POST',
      params: formData,
      async: true,
      done: function done(response) {
        messageResult.innerHTML = response.data.message;
        if (response.success) {
          messageResultBtn.classList.remove('ds-none');
        }
      },
      error: function error(/*status*/
      ) {
        //console.error('Error al procesar la solicitud:', status);
        //alert('Error en la solicitud AJAX');
      },
      always: function always() {
        button.textContent = 'Guardar nueva contraseña';
        button.disabled = false;
        //console.log('La solicitud AJAX ha finalizado.');
      }
    });
  });
});

/***/ })

},
/******/ function(__webpack_require__) { // webpackRuntimeModules
/******/ var __webpack_exec__ = function(moduleId) { return __webpack_require__(__webpack_require__.s = moduleId); }
/******/ __webpack_require__.O(0, ["/js/vendor"], function() { return __webpack_exec__("./src/js/templates/template-reset-password.js"); });
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=template-reset-password.js.map
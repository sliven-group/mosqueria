"use strict";
(self["webpackChunkmosqueira"] = self["webpackChunkmosqueira"] || []).push([["/js/template-perfil"],{

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

/***/ "./src/js/templates/template-perfil.js":
/*!*********************************************!*\
  !*** ./src/js/templates/template-perfil.js ***!
  \*********************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _helpers_ajax__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../helpers/ajax */ "./src/js/helpers/ajax.js");
/* harmony import */ var just_validate__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! just-validate */ "./node_modules/just-validate/dist/just-validate.es.js");
/* global jsVars */


window.addEventListener('load', function () {
  var form = document.getElementById('mos-form-account');
  var button = form.querySelector('#mos-form-account-btn');
  var messageResult = document.getElementById('mos-form-account-message');
  var validation = new just_validate__WEBPACK_IMPORTED_MODULE_1__["default"](form);
  var formData = new FormData();
  var formBilling = document.getElementById('mos-form-billing');
  var formBillingBtn = formBilling.querySelector('#mos-form-billing-btn');
  var messageResultformBilling = document.getElementById('mos-form-billing-message');
  var validationformBilling = new just_validate__WEBPACK_IMPORTED_MODULE_1__["default"](formBilling);
  var formDataformBilling = new FormData();
  var departamentoSelect = document.getElementById('departamento-billing');
  var provinciaSelect = document.getElementById('provincia-billing');
  var distritoSelect = document.getElementById('distrito-billing');
  var idDepa = departamentoSelect === null || departamentoSelect === void 0 ? void 0 : departamentoSelect.value;
  var idProv = provinciaSelect === null || provinciaSelect === void 0 ? void 0 : provinciaSelect.dataset.provincia;
  var idDist = distritoSelect === null || distritoSelect === void 0 ? void 0 : distritoSelect.dataset.distrito;
  formBilling.querySelector('input[name="name-billing"]').value = form.querySelector('input[name="name-account"]').value;
  formBilling.querySelector('input[name="lastname-billing"]').value = form.querySelector('input[name="lastname-account"]').value;
  validation.addField('#name-account', [{
    rule: 'required',
    errorMessage: 'Nombre de usuario es requerido'
  }]).addField('#lastname-account', [{
    rule: 'required',
    errorMessage: 'Apellido es requerido'
  }])
  /*.addField('#nickname-account', [
  	{
  		rule: 'required',
  		errorMessage: 'Nombre de usuario es requerido',
  	},
  ])*/.addField('#day-account', [{
    rule: 'required',
    errorMessage: 'Día de nacimiento es requerido'
  }]).addField('#mount-account', [{
    rule: 'required',
    errorMessage: 'Mes de nacimiento es requerido'
  }]).addField('#year-account', [{
    rule: 'required',
    errorMessage: 'Año de nacimiento es requerido'
  }])
  /*.addField('#phone-code-account', [
  	{
  		rule: 'required',
  		errorMessage: 'Codigo de telefono es requerido',
  	},
  ])*/.addField('#phone-account', [{
    rule: 'required',
    errorMessage: 'Telefono es requerido'
  }]).addField('#email-account', [{
    rule: 'required',
    errorMessage: 'Email es requerido'
  }, {
    rule: 'email',
    errorMessage: 'Email no tiene un formato valido'
  }]).addField('#password-account', [{
    rule: 'password',
    errorMessage: 'La contraseña debe contener un mínimo de ocho caracteres, al menos una letra y un número'
  }]).addField('#password-confirm-account', [{
    validator: function validator(value, fields) {
      if (fields['#password-account'] && fields['#password-account'].elem) {
        var repeatPasswordValue = fields['#password-account'].elem.value;
        return value === repeatPasswordValue;
      }
      return true;
    },
    errorMessage: 'La contraseña no coincide'
  }]).addField('#personal-data-account', [{
    rule: 'required',
    errorMessage: 'Confirmación de mayor de edad es requerido'
  }]).onSuccess(function () {
    formBilling.querySelector('input[name="name-billing"]').value = form.querySelector('input[name="name-account"]').value;
    formBilling.querySelector('input[name="lastname-billing"]').value = form.querySelector('input[name="lastname-account"]').value;
    button.textContent = 'CARGANDO...';
    formData.append('action', 'update_user');
    formData.append('user_id', document.querySelector('input[name="user-id"]').value);
    formData.append('account_first_name', form.querySelector('input[name="name-account"]').value);
    formData.append('account_last_name', form.querySelector('input[name="lastname-account"]').value);
    formData.append('account_display_name', form.querySelector('input[name="nickname-account"]').value);
    formData.append('account_day', form.querySelector('select[name="day-account"]').value);
    formData.append('account_month', form.querySelector('select[name="mount-account"]').value);
    formData.append('account_year', form.querySelector('select[name="year-account"]').value);
    //formData.append('account_code_phone', form.querySelector('select[name="phone-code-account"]').value);
    formData.append('account_phone', form.querySelector('input[name="phone-account"]').value);
    formData.append('account_email', form.querySelector('input[name="email-account"]').value);
    formData.append('password_current', form.querySelector('input[name="password-account"]').value);
    formData.append('password_confirm', form.querySelector('input[name="password-confirm-account"]').value);
    formData.append('account_confirm_age', form.querySelector('input[name="personal-data-account"]').checked);
    (0,_helpers_ajax__WEBPACK_IMPORTED_MODULE_0__["default"])({
      url: jsVars.ajax_url,
      method: 'POST',
      params: formData,
      async: true,
      done: function done(response) {
        if (response.status) {
          if (messageResult) {
            messageResult.innerHTML = response.message;
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
        button.textContent = 'GUARDAR CAMBIOS';
        setTimeout(function () {
          messageResult.innerHTML = '';
        }, 5000);
        //console.log('La solicitud AJAX ha finalizado.');
      }
    });
  });
  validationformBilling.addField('#name-billing', [{
    rule: 'required',
    errorMessage: 'Nombre de usuario es requerido'
  }]).addField('#lastname-billing', [{
    rule: 'required',
    errorMessage: 'Apellido es requerido'
  }]).addField('#address-billing', [{
    rule: 'required',
    errorMessage: 'Dirección es requerido'
  }]).addField('#departamento-billing', [{
    rule: 'required',
    errorMessage: 'Departamento es requerido'
  }]).addField('#provincia-billing', [{
    rule: 'required',
    errorMessage: 'Provincia es requerido'
  }]).addField('#distrito-billing', [{
    rule: 'required',
    errorMessage: 'Distrito es requerido'
  }]).onSuccess(function () {
    formBilling.querySelector('input[name="name-billing"]').value = form.querySelector('input[name="name-account"]').value;
    formBilling.querySelector('input[name="lastname-billing"]').value = form.querySelector('input[name="lastname-account"]').value;
    formBillingBtn.textContent = 'CARGANDO...';
    formDataformBilling.append('action', 'update_address');
    formDataformBilling.append('user_id', document.querySelector('input[name="user-id"]').value);
    formDataformBilling.append('billing_first_name', formBilling.querySelector('input[name="name-billing"]').value);
    formDataformBilling.append('billing_last_name', formBilling.querySelector('input[name="lastname-billing"]').value);
    formDataformBilling.append('billing_adresss', formBilling.querySelector('input[name="address-billing"]').value);
    formDataformBilling.append('billing_departamento', formBilling.querySelector('select[name="departamento-billing"]').value);
    formDataformBilling.append('billing_provincia', formBilling.querySelector('select[name="provincia-billing"]').value);
    formDataformBilling.append('billing_distrito', formBilling.querySelector('select[name="distrito-billing"]').value);
    (0,_helpers_ajax__WEBPACK_IMPORTED_MODULE_0__["default"])({
      url: jsVars.ajax_url,
      method: 'POST',
      params: formDataformBilling,
      async: true,
      done: function done(response) {
        //console.log(response);
        if (response.success) {
          if (messageResultformBilling) {
            messageResultformBilling.innerHTML = response.data.message;
          }
        }
      },
      error: function error(status) {
        //console.error('Error al procesar la solicitud:', status);
        if (messageResultformBilling) {
          messageResultformBilling.innerHTML = 'Error al procesar la solicitud:' + status;
        }
      },
      always: function always() {
        formBillingBtn.textContent = 'GUARDAR CAMBIOS';
        setTimeout(function () {
          messageResultformBilling.innerHTML = '';
        }, 5000);
        //console.log('La solicitud AJAX ha finalizado.');
      }
    });
  });
  if (idDepa && idProv) {
    var _formData = new FormData();
    _formData.append('action', 'get_provincias');
    _formData.append('id_depa', idDepa);
    (0,_helpers_ajax__WEBPACK_IMPORTED_MODULE_0__["default"])({
      url: jsVars.ajax_url,
      method: 'POST',
      params: _formData,
      async: true,
      done: function done(response) {
        if (response.success) {
          provinciaSelect.innerHTML = '<option value="">Seleccione provincia</option>';
          response.data.forEach(function (item) {
            var option = document.createElement('option');
            option.value = item.idProv;
            option.textContent = item.nombre;
            if (item.idProv == idProv) option.selected = true;
            provinciaSelect.appendChild(option);
          });

          // luego de poblar provincias, cargamos distritos si hay un valor
          if (idProv && idDist) {
            var formDataDist = new FormData();
            formDataDist.append('action', 'get_distritos');
            formDataDist.append('id_prov', idProv);
            (0,_helpers_ajax__WEBPACK_IMPORTED_MODULE_0__["default"])({
              url: jsVars.ajax_url,
              method: 'POST',
              params: formDataDist,
              async: true,
              done: function done(response) {
                if (response.success) {
                  distritoSelect.innerHTML = '<option value="">Seleccione distrito</option>';
                  response.data.forEach(function (item) {
                    var option = document.createElement('option');
                    option.value = item.idDist;
                    option.textContent = item.nombre;
                    if (item.idDist == idDist) option.selected = true;
                    distritoSelect.appendChild(option);
                  });
                }
              }
            });
          }
        }
      }
    });
  }
  if (departamentoSelect) {
    departamentoSelect.addEventListener('change', function () {
      var idDepa = this.value;
      if (provinciaSelect) {
        provinciaSelect.innerHTML = '<option value=""></option>';
        var _formData2 = new FormData();
        _formData2.append('action', 'get_provincias');
        _formData2.append('id_depa', idDepa);
        (0,_helpers_ajax__WEBPACK_IMPORTED_MODULE_0__["default"])({
          url: jsVars.ajax_url,
          method: 'POST',
          params: _formData2,
          async: true,
          done: function done(response) {
            if (response.success) {
              provinciaSelect.innerHTML = '<option value="">Seleccione provincia</option>';
              response.data.forEach(function (item) {
                var option = document.createElement('option');
                option.value = item.idProv;
                option.textContent = item.nombre;
                provinciaSelect.appendChild(option);
              });
            } else {
              //alert(response.data.message);
            }
          },
          error: function error() {},
          always: function always() {}
        });
      }
    });
  }
  if (provinciaSelect) {
    provinciaSelect.addEventListener('change', function () {
      var idProv = this.value;
      if (distritoSelect) {
        distritoSelect.innerHTML = '<option value=""></option>';
        var _formData3 = new FormData();
        _formData3.append('action', 'get_distritos');
        _formData3.append('id_prov', idProv);
        (0,_helpers_ajax__WEBPACK_IMPORTED_MODULE_0__["default"])({
          url: jsVars.ajax_url,
          method: 'POST',
          params: _formData3,
          async: true,
          done: function done(response) {
            if (response.success) {
              distritoSelect.innerHTML = '<option value="">Seleccione distrito</option>';
              response.data.forEach(function (item) {
                var option = document.createElement('option');
                option.value = item.idDist;
                option.textContent = item.nombre;
                distritoSelect.appendChild(option);
              });
            } else {
              //alert(response.data.message);
            }
          },
          error: function error() {},
          always: function always() {
            //console.log('La solicitud AJAX ha finalizado.');
          }
        });
      }
    });
  }
});

/***/ })

},
/******/ function(__webpack_require__) { // webpackRuntimeModules
/******/ var __webpack_exec__ = function(moduleId) { return __webpack_require__(__webpack_require__.s = moduleId); }
/******/ __webpack_require__.O(0, ["/js/vendor"], function() { return __webpack_exec__("./src/js/templates/template-perfil.js"); });
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=template-perfil.js.map
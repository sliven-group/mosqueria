"use strict";
(self["webpackChunkmosqueira"] = self["webpackChunkmosqueira"] || []).push([["/js/template-cart"],{

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

/***/ "./src/js/helpers/varible-rate-districts.js":
/*!**************************************************!*\
  !*** ./src/js/helpers/varible-rate-districts.js ***!
  \**************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   variableRateDistrictsExpress: function() { return /* binding */ variableRateDistrictsExpress; },
/* harmony export */   variableRateDistrictsRegular: function() { return /* binding */ variableRateDistrictsRegular; }
/* harmony export */ });
var variableRateDistrictsRegular = ['ANCON', 'ATE', 'CARABAYLLO', 'CHACLACAYO', 'CIENEGUILLA', 'COMAS', 'INDEPENDENCIA', 'LA MOLINA', 'LA PLANICIE', 'LA VICTORIA', 'CERCADO DE LIMA', 'LOS OLIVOS', 'LURIN', 'PACHACAMAC', 'PUENTE PIEDRA', 'RIMAC', 'SAN JUAN DE LURIGANCHO', 'SAN JUAN DE MIRAFLORES', 'SAN LUIS', 'SAN MARTIN DE PORRES', 'SAN MIGUEL', 'SANTA ROSA', 'VILLA EL SALVADOR', 'VILLA MARIA DEL TRIUNFO', 'LA PUNTA', 'CALLAO', 'CARMEN DE LA LEGUA'];
var variableRateDistrictsExpress = ['VILLA EL SALVADOR', 'VILLA MARIA DEL TRIUNFO', 'LA MOLINA', 'SAN JUAN DE LURIGANCHO', 'COMAS', 'SAN MARTIN DE PORRES', 'SAN MIGUEL', 'CALLAO', 'LOS OLIVOS', 'LA VICTORIA', 'SAN LUIS', 'RIMAC', 'LIMA'];


/***/ }),

/***/ "./src/js/templates/template-cart.js":
/*!*******************************************!*\
  !*** ./src/js/templates/template-cart.js ***!
  \*******************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _helpers_ajax__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../helpers/ajax */ "./src/js/helpers/ajax.js");
/* harmony import */ var _helpers_varible_rate_districts__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../helpers/varible-rate-districts */ "./src/js/helpers/varible-rate-districts.js");
/* global jsVars, tarifasDistritos */


window.addEventListener('load', function () {
  var departamentoSelect = document.getElementById('billing_departamento');
  var provinciaSelect = document.getElementById('billing_provincia');
  var distritoSelect = document.getElementById('billing_distrito');
  var calcularBtn = document.getElementById('mos-form-billing-btn');
  var messageCartShipping = document.getElementById('message-cart-shipping');
  // const billing_delivery_methods = document.getElementById('billing_delivery_methods');
  var expressDistricts = tarifasDistritos.express.map(function (d) {
    return d.toUpperCase();
  });
  var regularDistricts = tarifasDistritos.regular.map(function (d) {
    return d.toUpperCase();
  });
  //const provinceDistricts = tarifasDistritos.provincia.map((d) => d.toUpperCase());

  if (departamentoSelect) {
    departamentoSelect.addEventListener('change', function () {
      var idDepa = this.value;
      if (messageCartShipping) {
        messageCartShipping.innerHTML = '';
      }
      if (provinciaSelect) {
        provinciaSelect.innerHTML = '<option value=""></option>';
        var formData = new FormData();
        formData.append('action', 'get_provincias');
        formData.append('id_depa', idDepa);
        (0,_helpers_ajax__WEBPACK_IMPORTED_MODULE_0__["default"])({
          url: jsVars.ajax_url,
          method: 'POST',
          params: formData,
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
      if (messageCartShipping) {
        messageCartShipping.innerHTML = '';
      }
      if (distritoSelect) {
        distritoSelect.innerHTML = '<option value=""></option>';
        var formData = new FormData();
        formData.append('action', 'get_distritos');
        formData.append('id_prov', idProv);
        (0,_helpers_ajax__WEBPACK_IMPORTED_MODULE_0__["default"])({
          url: jsVars.ajax_url,
          method: 'POST',
          params: formData,
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
  function mostrarMensajeVariable(wrapper) {
    wrapper.innerHTML = '<p>La tarifa de delivery hacia su destino es variable. <a href="https://wa.me/51908900915?text=Necesito cotizar la tarifa de envío" target="_blank">Comuníquese con un asesor</a></p>';
  }
  function updateDeliveryMethods() {
    var wrapperElement = document.querySelector('#billing_delivery_methods_wrapper');
    var selectElement = document.getElementById('billing_delivery_methods');
    var distritoElement = document.getElementById('billing_distrito');
    var provinciaElement = document.getElementById('billing_provincia');
    var departamentoElement = document.getElementById('billing_departamento');
    if (!selectElement) {
      wrapperElement.innerHTML = '<select name="billing_delivery_methods" id="billing_delivery_methods" class="select"><option value="">Selecciona un método</option></select>';
      selectElement = document.getElementById('billing_delivery_methods');
    }
    var distrito = distritoElement ? distritoElement.options[distritoElement.selectedIndex].textContent.trimStart().trimEnd() : '';
    var provincia = provinciaElement ? provinciaElement.options[provinciaElement.selectedIndex].textContent.trimStart().trimEnd() : '';
    var departamento = departamentoElement ? departamentoElement.options[departamentoElement.selectedIndex].textContent.trimStart().trimEnd() : '';
    selectElement.innerHTML = '<option value="">Selecciona un método</option>';
    messageCartShipping.innerHTML = '';
    if (departamento === 'LIMA' && provincia === 'LIMA' && regularDistricts.includes(distrito) && expressDistricts.includes(distrito)) {
      selectElement.innerHTML = "\n                <option value=\"\">Selecciona un m\xE9todo</option>\n                <option value=\"express\">Env\xEDo Express - M\xE1x. 4 horas</option>\n                <option value=\"regular\">Env\xEDo Regular - M\xE1x. 2 d\xEDas h\xE1biles</option>\n            ";
    } else if (departamento === 'LIMA' && provincia === 'LIMA' && expressDistricts.includes(distrito) && !_helpers_varible_rate_districts__WEBPACK_IMPORTED_MODULE_1__.variableRateDistrictsExpress.includes(distrito)) {
      selectElement.innerHTML += '<option value="express">Envío Express - Máx. 4 horas</option>';
    } else if (departamento === 'LIMA' && provincia === 'LIMA' && regularDistricts.includes(distrito) && !_helpers_varible_rate_districts__WEBPACK_IMPORTED_MODULE_1__.variableRateDistrictsRegular.includes(distrito)) {
      selectElement.innerHTML += '<option value="regular">Envío Regular - Máx. 2 días hábiles</option>';
    } else if (departamento !== 'LIMA' && provincia !== 'LIMA' && tarifasDistritos.provincia.some(function (item) {
      return item.departamento.toUpperCase() === departamento && item.provincia.toUpperCase() === provincia && item.distrito.toUpperCase() === distrito;
    })) {
      selectElement.innerHTML += '<option value="provincia">Envío Provincia - Máx. 5 días hábiles</option>';
    } else if (departamento === 'LIMA' && provincia !== 'LIMA' && tarifasDistritos.provincia.some(function (item) {
      return item.departamento.toUpperCase() === departamento && item.provincia.toUpperCase() === provincia && item.distrito.toUpperCase() === distrito;
    })) {
      selectElement.innerHTML += '<option value="provincia">Envío Provincia - Máx. 5 días hábiles</option>';
    } else if (departamento === 'LIMA' && provincia === 'LIMA' && (_helpers_varible_rate_districts__WEBPACK_IMPORTED_MODULE_1__.variableRateDistrictsRegular.includes(distrito) || _helpers_varible_rate_districts__WEBPACK_IMPORTED_MODULE_1__.variableRateDistrictsExpress.includes(distrito))) {
      mostrarMensajeVariable(wrapperElement);
    } else if (departamento === 'LIMA' && provincia === 'CALLAO' && (_helpers_varible_rate_districts__WEBPACK_IMPORTED_MODULE_1__.variableRateDistrictsRegular.includes(distrito) || _helpers_varible_rate_districts__WEBPACK_IMPORTED_MODULE_1__.variableRateDistrictsExpress.includes(distrito))) {
      mostrarMensajeVariable(wrapperElement);
    } else {
      wrapperElement.innerHTML = '<p>No se realizan envíos a la ubicación seleccionada.</p>';
    }
  }
  if (distritoSelect) {
    var observer = new MutationObserver(function (mutations) {
      mutations.forEach(function (mutation) {
        if (mutation.type === 'childList') {
          updateDeliveryMethods();
        }
      });
    });
    observer.observe(distritoSelect, {
      childList: true
    });
    distritoSelect.addEventListener('change', updateDeliveryMethods);
  }
  if (calcularBtn) {
    calcularBtn.addEventListener('click', function () {
      var distrito = distritoSelect ? distritoSelect.options[distritoSelect.selectedIndex].textContent : '';
      var metodo = document.getElementById('billing_delivery_methods');
      var formData = new FormData();
      if (distritoSelect.value === '' && metodo.value == '') {
        return;
      }
      formData.append('action', 'calcular_envio_dinamico');
      formData.append('distrito', distrito);
      formData.append('metodo', metodo.value);
      calcularBtn.innerHTML = 'CALCULANDO...';
      messageCartShipping.innerHTML = '';
      (0,_helpers_ajax__WEBPACK_IMPORTED_MODULE_0__["default"])({
        url: jsVars.ajax_url,
        method: 'POST',
        params: formData,
        async: true,
        done: function done(response) {
          if (response.success) {
            messageCartShipping.innerHTML = "<p>Metodo: ".concat(response.data.metodo, "</p><p>Precio: S/").concat(response.data.precio, "</p>");
          } else {
            messageCartShipping.innerHTML = 'Error: ' + response.data.message;
          }
        },
        error: function error() {},
        always: function always() {
          calcularBtn.innerHTML = 'CALCULAR';
        }
      });
    });
  }
  var wrapperElement = document.querySelector('#billing_delivery_methods_wrapper');
  if (wrapperElement) {
    wrapperElement.addEventListener('change', function (event) {
      if (event.target && event.target.id === 'billing_delivery_methods') {
        var idMethods = event.target.value;
        if (idMethods === '') {
          messageCartShipping.innerHTML = '';
        }
      }
    });
  }
});

/***/ })

},
/******/ function(__webpack_require__) { // webpackRuntimeModules
/******/ var __webpack_exec__ = function(moduleId) { return __webpack_require__(__webpack_require__.s = moduleId); }
/******/ var __webpack_exports__ = (__webpack_exec__("./src/js/templates/template-cart.js"));
/******/ }
]);
//# sourceMappingURL=template-cart.js.map
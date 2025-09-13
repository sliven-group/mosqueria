"use strict";
(self["webpackChunkmosqueira"] = self["webpackChunkmosqueira"] || []).push([["/js/complaints-book"],{

/***/ "./src/js/blocks/complaints-book.js":
/*!******************************************!*\
  !*** ./src/js/blocks/complaints-book.js ***!
  \******************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _helpers_ajax__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../helpers/ajax */ "./src/js/helpers/ajax.js");
/* harmony import */ var just_validate__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! just-validate */ "./node_modules/just-validate/dist/just-validate.es.js");
/* global jsVars */


window.addEventListener('load', function () {
  var form = document.getElementById('mos-form-cb');
  var button = form.querySelector('#mos-form-cb-btn');
  var messageResult = document.getElementById('mos-form-cb-message');
  var departamentoSelect = document.getElementById('departamento-cb');
  var provinciaSelect = document.getElementById('provincia-cb');
  var distritoSelect = document.getElementById('distrito-cb');
  var idDepa = departamentoSelect === null || departamentoSelect === void 0 ? void 0 : departamentoSelect.value;
  var idProv = provinciaSelect === null || provinciaSelect === void 0 ? void 0 : provinciaSelect.dataset.provincia;
  var idDist = distritoSelect === null || distritoSelect === void 0 ? void 0 : distritoSelect.dataset.distrito;
  var underAgeRadios = document.querySelectorAll('input[name="your-age-cb"]');
  var underAgeContainer = document.getElementById('pamatu-cb');
  var textarea = document.querySelectorAll('#mos-form-cb textarea');
  var validation = new just_validate__WEBPACK_IMPORTED_MODULE_1__["default"](form);
  var formData = new FormData();
  var validateDocNumber = function validateDocNumber(tipoDoc, value) {
    if (!tipoDoc || value.trim() === '') return false;
    switch (tipoDoc) {
      case 'DNI':
        return /^\d{8}$/.test(value);
      case 'Pasaporte':
        return /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{5,15}$/.test(value);
      case 'CE':
        return /^\d{9}$/.test(value);
      case 'RUC':
        return /^\d{11}$/.test(value);
      default:
        return true;
    }
  };
  validation.addField('#name-cb', [{
    rule: 'required',
    errorMessage: 'Campo requerido'
  }]).addField('#lastname-cb', [{
    rule: 'required',
    errorMessage: 'Campo requerido'
  }]).addField('#tipo-doc-cb', [{
    rule: 'required',
    errorMessage: 'Campo requerido'
  }]).addField('#nro-doc-cb', [{
    validator: function validator(value) {
      return validateDocNumber(document.querySelector('#tipo-doc-cb').value, value);
    },
    errorMessage: 'Número de documentación inválido según el tipo'
  }]).addField('#cel-cb', [{
    rule: 'required',
    errorMessage: 'Telefono es requerido'
  }]).addField('#departamento-cb', [{
    rule: 'required',
    errorMessage: 'Campo requerido'
  }]).addField('#provincia-cb', [{
    rule: 'required',
    errorMessage: 'Campo requerido'
  }]).addField('#distrito-cb', [{
    rule: 'required',
    errorMessage: 'Campo requerido'
  }]).addField('#dir-cb', [{
    rule: 'required',
    errorMessage: 'Campo requerido'
  }]).addField('#ref-cb', [{
    rule: 'required',
    errorMessage: 'Campo requerido'
  }]).addField('#email-cb', [{
    rule: 'required',
    errorMessage: 'Email es requerido'
  }, {
    rule: 'email',
    errorMessage: 'Email no tiene un formato valido'
  }]).addRequiredGroup('#yourage_cb_radio_group').addField('#tipo-rec-cb', [{
    rule: 'required',
    errorMessage: 'Campo requerido'
  }]).addField('#tipo-con-cb', [{
    rule: 'required',
    errorMessage: 'Campo requerido'
  }]).addField('#npedido-cb', [{
    rule: 'required',
    errorMessage: 'Campo requerido'
  }]).addField('#daterac-cb', [{
    rule: 'required',
    errorMessage: 'Campo requerido'
  }]).addField('#prov-cb', [{
    rule: 'required',
    errorMessage: 'Campo requerido'
  }]).addField('#mont-cb', [{
    rule: 'required',
    errorMessage: 'Campo requerido'
  }]).addField('#desc-cb', [{
    rule: 'required',
    errorMessage: 'Campo requerido'
  }]).addField('#datec-cb', [{
    rule: 'required',
    errorMessage: 'Campo requerido'
  }]).addField('#dated-cb', [{
    rule: 'required',
    errorMessage: 'Campo requerido'
  }]).addField('#datea-cb', [{
    rule: 'required',
    errorMessage: 'Campo requerido'
  }]).addField('#det-cb', [{
    rule: 'required',
    errorMessage: 'Campo requerido'
  }]).addField('#ped-cb', [{
    rule: 'required',
    errorMessage: 'Campo requerido'
  }]).addField('#acepto-cb', [{
    rule: 'required',
    errorMessage: 'Campo requerido'
  }]).addField('#temr-cb', [{
    rule: 'required',
    errorMessage: 'Campo requerido'
  }]).onSuccess(function () {
    var _document$querySelect, _document$querySelect2, _document$querySelect3, _document$querySelect4, _document$querySelect5, _document$querySelect6;
    formData.append('action', 'libro_lrq');
    formData.append('nombres', document.querySelector('input[name="name-cb"]').value);
    formData.append('apellidos', document.querySelector('input[name="lastname-cb"]').value);
    formData.append('tipo_doc', document.querySelector('select[name="tipo-doc-cb"]').value);
    formData.append('nro_documento', document.querySelector('input[name="nro-doc-cb"]').value);
    formData.append('celular', document.querySelector('input[name="cel-cb"]').value);
    formData.append('departamento', document.querySelector('select[name="departamento-cb"]').value);
    formData.append('provincia', document.querySelector('select[name="provincia-cb"]').value);
    formData.append('distrito', document.querySelector('select[name="distrito-cb"]').value);
    formData.append('direccion', document.querySelector('input[name="dir-cb"]').value);
    formData.append('referencia', document.querySelector('input[name="ref-cb"]').value);
    formData.append('email', document.querySelector('input[name="email-cb"]').value);
    formData.append('flag_menor', (_document$querySelect = (_document$querySelect2 = document.querySelector('input[name="your-age-cb"]:checked')) === null || _document$querySelect2 === void 0 ? void 0 : _document$querySelect2.value) !== null && _document$querySelect !== void 0 ? _document$querySelect : '');
    formData.append('nombre_tutor', document.querySelector('input[name="padmatu-name-cb"]').value);
    formData.append('email_tutor', document.querySelector('input[name="padmatu-email-cb"]').value);
    formData.append('tipo_doc_tutor', document.querySelector('select[name="padmatu-tipo-doc-cb"]').value);
    formData.append('numero_documento_tutor', document.querySelector('input[name="padmatu-nro-doc-cb"]').value);
    formData.append('tipo_reclamacion', document.querySelector('select[name="tipo-rec-cb"]').value);
    formData.append('tipo_consumo', document.querySelector('select[name="tipo-con-cb"]').value);
    formData.append('nro_pedido', document.querySelector('input[name="npedido-cb"]').value);
    formData.append('fch_reclamo', document.querySelector('input[name="daterac-cb"]').value);
    formData.append('proveedor', document.querySelector('input[name="prov-cb"]').value);
    formData.append('monto_reclamado', document.querySelector('input[name="mont-cb"]').value);
    formData.append('descripcion', document.querySelector('textarea[name="desc-cb"]').value);
    formData.append('fch_compra', document.querySelector('input[name="datec-cb"]').value);
    formData.append('fch_consumo', document.querySelector('input[name="dated-cb"]').value);
    formData.append('fch_vencimiento', document.querySelector('input[name="datea-cb"]').value);
    formData.append('detalle', document.querySelector('textarea[name="det-cb"]').value);
    formData.append('pedido_cliente', document.querySelector('textarea[name="ped-cb"]').value);
    formData.append('acepta_contenido', (_document$querySelect3 = (_document$querySelect4 = document.querySelector('input[name="acepto-cb"]:checked')) === null || _document$querySelect4 === void 0 ? void 0 : _document$querySelect4.value) !== null && _document$querySelect3 !== void 0 ? _document$querySelect3 : '');
    formData.append('acepta_politica', (_document$querySelect5 = (_document$querySelect6 = document.querySelector('input[name="temr-cb"]:checked')) === null || _document$querySelect6 === void 0 ? void 0 : _document$querySelect6.value) !== null && _document$querySelect5 !== void 0 ? _document$querySelect5 : '');
    button.disabled = true;
    button.textContent = 'CARGANDO...';
    (0,_helpers_ajax__WEBPACK_IMPORTED_MODULE_0__["default"])({
      url: jsVars.ajax_url,
      method: 'POST',
      params: formData,
      async: true,
      done: function done(response) {
        messageResult.innerHTML = response.data;
      },
      error: function error(status) {
        if (messageResult) {
          messageResult.innerHTML = 'Error al procesar la solicitud:' + status;
        }
      },
      always: function always() {
        button.textContent = 'ENVIAR';
        button.disabled = false;
        setTimeout(function () {
          messageResult.innerHTML = '';
        }, 5000);
      }
    });
  });
  underAgeRadios.forEach(function (radio) {
    radio.addEventListener('change', function (e) {
      if (e.target.value === 'Si') {
        underAgeContainer.classList.remove('ds-none');
        validation.addField('#padmatu-name-cb', [{
          rule: 'required',
          errorMessage: 'Campo requerido'
        }]).addField('#padmatu-email-cb', [{
          rule: 'required',
          errorMessage: 'Email es requerido'
        }, {
          rule: 'email',
          errorMessage: 'Email no tiene un formato valido'
        }]).addField('#padmatu-tipo-doc-cb', [{
          rule: 'required',
          errorMessage: 'Campo requerido'
        }]).addField('#padmatu-nro-doc-cb', [{
          validator: function validator(value) {
            return validateDocNumber(document.querySelector('#padmatu-tipo-doc-cb').value, value);
          },
          errorMessage: 'Número de documentación inválido según el tipo'
        }]);
      } else {
        underAgeContainer.classList.add('ds-none');
        validation.removeField('#padmatu-name-cb');
        validation.removeField('#padmatu-email-cb');
        validation.removeField('#padmatu-tipo-doc-cb');
        validation.removeField('#padmatu-nro-doc-cb');
      }
    });
  });
  textarea.forEach(function (item) {
    item.addEventListener('input', function () {
      item.style.height = 'auto'; // Reinicia la altura
      item.style.height = item.scrollHeight + 'px'; // Ajusta al contenido
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
        distritoSelect.innerHTML = '<option value=""></option>';
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
              distritoSelect.innerHTML = '<option value="">Seleccione distrito</option>';
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
  var select = document.getElementById('tipo-doc-cb');
  var mediaQuery = window.matchMedia('(max-width: 767px)');
  function updateSelectedOption(e) {
    if (!select || select.options.length < 2) return;

    // Limpiar cualquier "selected" actual
    Array.from(select.options).forEach(function (option) {
      return option.removeAttribute('selected');
    });
    if (e.matches) {
      // Mobile: seleccionar opción 2
      select.selectedIndex = 1;
      select.options[1].setAttribute('selected', 'selected');
    } else {
      // Desktop: seleccionar opción 1
      select.selectedIndex = 0;
      select.options[0].setAttribute('selected', 'selected');
    }
  }

  // Ejecutar al cargar
  updateSelectedOption(mediaQuery);

  // Escuchar cambios de tamaño de pantalla
  mediaQuery.addEventListener('change', updateSelectedOption);
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
/******/ __webpack_require__.O(0, ["/js/vendor"], function() { return __webpack_exec__("./src/js/blocks/complaints-book.js"); });
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=complaints-book.js.map
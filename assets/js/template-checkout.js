"use strict";
(self["webpackChunkmosqueira"] = self["webpackChunkmosqueira"] || []).push([["/js/template-checkout"],{

/***/ "./src/js/helpers/on.js":
/*!******************************!*\
  !*** ./src/js/helpers/on.js ***!
  \******************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ on; }
/* harmony export */ });
function on(ele, type, selector, handler) {
  ele.addEventListener(type, function (event) {
    var el = event.target.closest(selector);
    if (el) handler.call(el, event);
  });
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

/***/ "./src/js/templates/template-checkout.js":
/*!***********************************************!*\
  !*** ./src/js/templates/template-checkout.js ***!
  \***********************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _helpers_on__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../helpers/on */ "./src/js/helpers/on.js");
/* harmony import */ var _helpers_varible_rate_districts__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../helpers/varible-rate-districts */ "./src/js/helpers/varible-rate-districts.js");
/* global jsVars, tarifasDistritos, preloadedData */


window.addEventListener('load', function () {
  var checkoutForm = document.querySelector('form.checkout');
  var stepItems = document.querySelectorAll('.mos__steps__item');
  var contentItems = document.querySelectorAll('.mos__steps__content__item');
  var currentStep = jsVars.is_checkout == '1' ? 2 : 1;
  var additionalEmail = document.getElementById('additional_email');
  var additionalName = document.getElementById('additional_name');
  var additionalLastname = document.getElementById('additional_lastname');
  var additionalDni = document.getElementById('additional_dni');
  var additionalPhone = document.getElementById('additional_phone');
  var additionalNewsletter = document.getElementById('additional_newsletter');
  var billingFirstName = document.getElementById('billing_first_name');
  var billingLastName = document.getElementById('billing_last_name');
  var billingPhone = document.getElementById('billing_phone');
  var billingEmail = document.getElementById('billing_email');
  var billingDepartamento = document.getElementById('billing_departamento');
  var billingProvincia = document.getElementById('billing_provincia');
  var billingDistrito = document.getElementById('billing_distrito');
  var billingAddress1 = document.getElementById('billing_address_1');
  var billingCity = this.document.getElementById('billing_city');
  var additionalFields = {
    additional_email: additionalEmail,
    additional_name: additionalName,
    additional_lastname: additionalLastname,
    additional_dni: additionalDni,
    additional_phone: additionalPhone
  };
  var billingFields = {
    billing_first_name: billingFirstName,
    billing_last_name: billingLastName,
    billing_phone: billingPhone,
    billing_email: billingEmail,
    billing_departamento: billingDepartamento,
    billing_provincia: billingProvincia,
    billing_distrito: billingDistrito,
    billing_address_1: billingAddress1
  };
  var expressDistricts = tarifasDistritos.express.map(function (d) {
    return d.toUpperCase();
  });
  var regularDistricts = tarifasDistritos.regular.map(function (d) {
    return d.toUpperCase();
  });
  //const provinceDistricts = tarifasDistritos.provincia.map((item) => item.distrito.toUpperCase());

  function showStep(stepNumber) {
    if (jsVars.is_cart == '1') return;
    if (stepNumber < 1 || stepNumber > stepItems.length) return;
    stepItems.forEach(function (item) {
      return item.classList.remove('active');
    });
    contentItems.forEach(function (item) {
      return item.classList.remove('active');
    });
    var currentStepItem = document.querySelector("[data-step=\"step-".concat(stepNumber, "\"]"));
    if (currentStepItem) currentStepItem.classList.add('active');
    var currentContentItem = document.getElementById("step-".concat(stepNumber));
    if (currentContentItem) currentContentItem.classList.add('active');
    currentStep = stepNumber;
  }
  function validateBillingFields() {
    var isValid = true;
    for (var key in billingFields) {
      var field = billingFields[key];
      var valid = validateField(key, field);
      if (!valid) isValid = false;
    }
    return isValid;
  }
  function validateAdditionalFields() {
    var isValid = true;
    for (var key in additionalFields) {
      var field = additionalFields[key];
      var valid = validateField(key, field);
      if (!valid) isValid = false;
    }
    return isValid;
  }
  function validateField(key, field) {
    var value = field.value.trim();
    var errorElement = document.getElementById('error-' + key);

    // Crear el contenedor del mensaje si no existe
    if (!errorElement) {
      errorElement = document.createElement('div');
      errorElement.id = 'error-' + key;
      errorElement.className = 'error-message';
      field.insertAdjacentElement('afterend', errorElement);
    }

    // Limpiar mensaje anterior
    errorElement.innerText = '';

    // Validar vacío
    if (value === '') {
      field.classList.add('invalid');
      errorElement.innerText = 'Este campo es obligatorio.';
      return false;
    } else {
      field.classList.remove('invalid');
    }
    if (key === 'additional_dni') {
      if (!/^\d{8}$/.test(value)) {
        field.classList.add('invalid');
        errorElement.innerText = 'El DNI debe tener exactamente 8 dígitos.';
        return false;
      }
    }
    if (key === 'additional_email') {
      var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(value)) {
        field.classList.add('invalid');
        errorElement.innerText = 'Ingrese un correo electrónico válido.';
        return false;
      }
    }
    if (key === 'additional_phone') {
      if (!/^\d{9}$/.test(value)) {
        field.classList.add('invalid');
        errorElement.innerText = 'El Teléfono debe tener exactamente 9 dígitos.';
        return false;
      }
    }
    return true;
  }
  function mostrarMensajeVariable(wrapper, buttonStep) {
    wrapper.innerHTML = '<p>La tarifa de delivery hacia su destino es variable. <a href="https://wa.me/51908900915?text=Hola! Quiero realizar un pedido y la tarifa a mi distrito es variable" target="_blank">Comuníquese con un asesor</a></p>';
    buttonStep.classList.add('ds-none');
  }
  function updateDeliveryMethods() {
    if (currentStep < 3) {
      return;
    }
    var distritoElement = document.getElementById('billing_distrito');
    var provinciaElement = document.getElementById('billing_provincia');
    var departamentoElement = document.getElementById('billing_departamento');
    var wrapperElement = document.querySelector('#billing_delivery_methods_field .woocommerce-input-wrapper');
    var selectElement = document.getElementById('billing_delivery_methods');
    var buttonStep = document.getElementById('mos-checkout-next-step');
    if (!selectElement) {
      wrapperElement.innerHTML = '<select name="billing_delivery_methods" id="billing_delivery_methods" class="select"><option value="">Selecciona un método</option></select>';
      selectElement = document.getElementById('billing_delivery_methods');
    }
    var distrito = distritoElement ? distritoElement.options[distritoElement.selectedIndex].textContent.trimEnd() : '';
    var provincia = provinciaElement ? provinciaElement.options[provinciaElement.selectedIndex].textContent.trimEnd() : '';
    var departamento = departamentoElement ? departamentoElement.options[departamentoElement.selectedIndex].textContent.trimEnd() : '';
    //const ciudad = ciudadElement ? ciudadElement.options[ciudadElement.selectedIndex].textContent.trimEnd() : '';

    selectElement.innerHTML = '';
    if (billingCity) billingCity.value = distrito;

    // Limpia el select primero
    selectElement.innerHTML = '<option value="">Selecciona un método</option>';
    if (departamento === 'LIMA' && provincia === 'LIMA' && regularDistricts.includes(distrito) && expressDistricts.includes(distrito) || departamento === 'LIMA' && provincia === 'CALLAO' && distrito === 'LA PUNTA') {
      selectElement.innerHTML = "\n\t\t\t\t<option value=\"\">Selecciona un m\xE9todo</option>\n\t\t\t\t<option value=\"express\">Env\xEDo Express - M\xE1x. 4 horas</option>\n\t\t\t\t<option value=\"regular\">Env\xEDo Regular - M\xE1x. 2 d\xEDas h\xE1biles</option>\n\t\t\t";
      buttonStep.classList.remove('ds-none');
    } else if (departamento === 'LIMA' && provincia === 'LIMA' && expressDistricts.includes(distrito) && !_helpers_varible_rate_districts__WEBPACK_IMPORTED_MODULE_1__.variableRateDistrictsExpress.includes(distrito)) {
      selectElement.innerHTML += '<option value="express">Envío Express - Máx. 4 horas</option>';
      buttonStep.classList.remove('ds-none');
    } else if (departamento === 'LIMA' && provincia === 'LIMA' && regularDistricts.includes(distrito) && !_helpers_varible_rate_districts__WEBPACK_IMPORTED_MODULE_1__.variableRateDistrictsRegular.includes(distrito)) {
      selectElement.innerHTML += '<option value="regular">Envío Regular - Máx. 2 días hábiles</option>';
      buttonStep.classList.remove('ds-none');
    } else if (departamento !== 'LIMA' && provincia !== 'LIMA' && tarifasDistritos.provincia.some(function (item) {
      return item.departamento.toUpperCase() === departamento && item.provincia.toUpperCase() === provincia && item.distrito.toUpperCase() === distrito;
    })) {
      selectElement.innerHTML += '<option value="provincia">Envío Provincia - Máx. 5 días hábiles</option>';
      buttonStep.classList.remove('ds-none');
    } else if (departamento === 'LIMA' && provincia !== 'LIMA' && tarifasDistritos.provincia.some(function (item) {
      return item.departamento.toUpperCase() === departamento && item.provincia.toUpperCase() === provincia && item.distrito.toUpperCase() === distrito;
    })) {
      selectElement.innerHTML += '<option value="provincia">Envío Provincia - Máx. 5 días hábiles</option>';
      buttonStep.classList.remove('ds-none');
    } else if (departamento === 'LIMA' && provincia === 'LIMA' && distrito === 'YAUYOS' || departamento === 'LORETO' && provincia === 'DATEM DEL MARAÑON' && distrito === 'BARRANCA') {
      selectElement.innerHTML += '<option value="provincia">Envío Provincia - Máx. 5 días hábiles</option>';
      buttonStep.classList.remove('ds-none');
    } else if (departamento === 'LIMA' && provincia === 'LIMA' && (_helpers_varible_rate_districts__WEBPACK_IMPORTED_MODULE_1__.variableRateDistrictsRegular.includes(distrito) || _helpers_varible_rate_districts__WEBPACK_IMPORTED_MODULE_1__.variableRateDistrictsExpress.includes(distrito))) {
      mostrarMensajeVariable(wrapperElement, buttonStep);
    } else if (departamento === 'LIMA' && provincia === 'CALLAO' && (_helpers_varible_rate_districts__WEBPACK_IMPORTED_MODULE_1__.variableRateDistrictsRegular.includes(distrito) || _helpers_varible_rate_districts__WEBPACK_IMPORTED_MODULE_1__.variableRateDistrictsExpress.includes(distrito))) {
      mostrarMensajeVariable(wrapperElement, buttonStep);
    } else {
      wrapperElement.innerHTML = '<p>No se realizan envíos a la ubicación seleccionada.</p>';
      buttonStep.classList.add('ds-none');
    }
  }
  function preloadData() {
    additionalEmail.value = preloadedData.email;
    additionalName.value = preloadedData.nombres;
    additionalLastname.value = preloadedData.apellidos;
    additionalPhone.value = preloadedData.telefono;
    setTimeout(function () {
      billingDepartamento.value = preloadedData.departamento;
    }, 1000);
    setTimeout(function () {
      billingProvincia.value = preloadedData.provincia;
    }, 2000);

    /*setTimeout(() => {
    	billingDistrito.value = preloadedData.distrito;
    }, 3000);*/

    setTimeout(function () {
      billingDepartamento.dispatchEvent(new Event('change'));
    }, 1500);
    setTimeout(function () {
      billingProvincia.dispatchEvent(new Event('change'));
    }, 2500);
    setTimeout(function () {
      var wrapperElement = document.querySelector('#billing_delivery_methods_field .woocommerce-input-wrapper');
      wrapperElement.innerHTML = '<select name="billing_delivery_methods" id="billing_delivery_methods" class="select"><option value="">Selecciona un método</option></select>';
    }, 3000);

    /*setTimeout(() => {
    	billingDistrito.dispatchEvent(new Event('change'));
    }, 3000);*/
  }
  (0,_helpers_on__WEBPACK_IMPORTED_MODULE_0__["default"])(document, 'click', '#mos-checkout-next-step', function (e) {
    e.preventDefault;
    var _this = this;
    var billingDeliveryMethods = document.getElementById('billing_delivery_methods');
    var placeOrder = document.getElementById('place_order');
    if (currentStep === 2) {
      if (validateAdditionalFields()) {
        showStep(3); // Avanza al siguiente paso si todo es válido
        billingFirstName.value = additionalName.value;
        billingLastName.value = additionalLastname.value;
        billingPhone.value = additionalPhone.value;
        billingEmail.value = additionalEmail.value;
        if (window.innerWidth < 768) {
          window.scrollTo({
            top: 0,
            behavior: 'smooth'
          });
        }
      }
    } else if (currentStep === 3) {
      if (validateBillingFields() && billingDeliveryMethods.value != '') {
        showStep(4); // Avanza al siguiente paso si todo es válido
        if (currentStep === 4) {
          _this.classList.add('ds-none');
          placeOrder.classList.remove('ds-none');
        }
      }
    }
  });
  (0,_helpers_on__WEBPACK_IMPORTED_MODULE_0__["default"])(document, 'click', '.mos__step__back', function (e) {
    e.preventDefault;
    var buttonStep = document.getElementById('mos-checkout-next-step');
    var placeOrder = document.getElementById('place_order');
    showStep(--currentStep);
    if (currentStep === 3) {
      placeOrder.classList.add('ds-none');
      buttonStep.classList.remove('ds-none');
    }
  });
  if (billingDistrito) {
    var observer = new MutationObserver(function (mutations) {
      mutations.forEach(function (mutation) {
        if (mutation.type === 'childList') {
          updateDeliveryMethods();
        }
      });
    });
    observer.observe(billingDistrito, {
      childList: true
    });
    billingDistrito.addEventListener('change', updateDeliveryMethods);
  }
  if (additionalEmail) {
    var _loop = function _loop(key) {
      var field = additionalFields[key];
      field.addEventListener('input', function () {
        validateField(key, field);
      });
    };
    for (var key in additionalFields) {
      _loop(key);
    }
    var _loop2 = function _loop2(_key) {
      var field = billingFields[_key];
      field.addEventListener('input', function () {
        validateField(_key, field);
      });
    };
    for (var _key in billingFields) {
      _loop2(_key);
    }
  }
  if (checkoutForm) {
    var _observer = new MutationObserver(function (mutations) {
      mutations.forEach(function (mutation) {
        if (mutation.attributeName === 'class') {
          if (checkoutForm.classList.contains('processing')) {
            document.getElementById('place_order').innerHTML = 'PROCESANDO...';
            document.getElementById('place_order').disabled = true;
          } else {
            document.getElementById('place_order').innerHTML = 'REALIZAR EL PEDIDO';
            document.getElementById('place_order').disabled = false;
          }
        }
      });
    });
    _observer.observe(checkoutForm, {
      attributes: true
    });
  }
  if (additionalNewsletter) {
    additionalNewsletter.addEventListener('change', function () {
      if (this.checked) {
        this.setAttribute('value', '1');
      } else {
        this.setAttribute('value', '0');
      }
    });
  }
  preloadData();
  showStep(currentStep);
});

/***/ })

},
/******/ function(__webpack_require__) { // webpackRuntimeModules
/******/ var __webpack_exec__ = function(moduleId) { return __webpack_require__(__webpack_require__.s = moduleId); }
/******/ var __webpack_exports__ = (__webpack_exec__("./src/js/templates/template-checkout.js"));
/******/ }
]);
//# sourceMappingURL=template-checkout.js.map
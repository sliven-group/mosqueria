"use strict";
(self["webpackChunkmosqueira"] = self["webpackChunkmosqueira"] || []).push([["/js/quiz"],{

/***/ "./src/js/blocks/quiz.js":
/*!*******************************!*\
  !*** ./src/js/blocks/quiz.js ***!
  \*******************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _helpers_ajax__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../helpers/ajax */ "./src/js/helpers/ajax.js");
/* harmony import */ var just_validate__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! just-validate */ "./node_modules/just-validate/dist/just-validate.es.js");
/* global jsVars */


window.addEventListener('load', function () {
  var form = document.getElementById('mos-form-quiz');
  var button = form.querySelector('#mos-form-quiz-btn');
  var messageResult = document.getElementById('mos-form-quiz-message');
  var otroCheckbox = document.getElementById('reason-quiz-6');
  var otroInputContainer = form.querySelector('#reason_quiz_radio_group + .form-input-inside');
  var otroInput = document.getElementById('reason-quiz-other');
  var canalWebCheckbox = document.getElementById('canal-quiz-1');
  var canalWhatsCheckbox = document.getElementById('canal-quiz-2');
  var webInputContainer = document.getElementById('yes_web_quiz_group');
  var whatsInputContainer = document.getElementById('yes_whats_quiz_group');
  var siCanalWebCheckbox = document.getElementById('nav-siteweb-quiz-1');
  var noCanalWebCheckbox = document.getElementById('nav-siteweb-quiz-2');
  var noCanalWebInput = document.getElementById('nav-siteweb-no-quiz');
  var noCanalWebContainer = form.querySelector('#siteweb_2_quiz_radio_group + .form-input-inside');
  var calserCheckbox = document.querySelectorAll('input[name="calser-quiz"]');
  var calserContainer = document.querySelector('#whats_2_quiz_radio_group + .form-input-inside');
  var calserCheckbox3 = document.getElementById('calser-quiz-3');
  var calserCheckbox4 = document.getElementById('calser-quiz-4');
  var whatsCheckbox = document.querySelectorAll('input[name="whats-quiz"]');
  var whatsContainer = document.querySelector('#whats_1_quiz_radio_group + .form-input-inside');
  var whatsCheckbox3 = document.getElementById('whats-quiz-3');
  var whatsCheckbox4 = document.getElementById('whats-quiz-4');
  var containerGeneral = document.querySelector('.mos__block__quiz');
  var textarea = document.getElementById('comment-quiz');
  var validation = new just_validate__WEBPACK_IMPORTED_MODULE_1__["default"](form);
  var formData = new FormData();
  validation.addRequiredGroup('#recommendation_quiz_radio_group').addRequiredGroup('#qualification_quiz_radio_group').addRequiredGroup('#presentation_quiz_radio_group').addRequiredGroup('#experience_quiz_radio_group').addRequiredGroup('#reason_quiz_radio_group').addField('#reason-quiz-other', [{
    rule: 'function',
    validator: function validator(value) {
      if (otroCheckbox && otroCheckbox.checked) {
        return value.trim() !== '';
      }
      return true;
    },
    errorMessage: 'Campo obligatorio'
  }]).addRequiredGroup('#canal_quiz_radio_group').addField('#nav-siteweb-no-quiz', [{
    rule: 'function',
    validator: function validator(value) {
      if (noCanalWebCheckbox && noCanalWebCheckbox.checked) {
        return value.trim() !== '';
      }
      return true;
    },
    errorMessage: 'Campo obligatorio'
  }]).addField('#calser-rema-quiz', [{
    rule: 'function',
    validator: function validator(value) {
      if (calserCheckbox4 && calserCheckbox4.checked || calserCheckbox3 && calserCheckbox3.checked) {
        return value.trim() !== '';
      }
      return true;
    },
    errorMessage: 'Campo obligatorio'
  }]).addField('#whats-rema-quiz', [{
    rule: 'function',
    validator: function validator(value) {
      if (whatsCheckbox3 && whatsCheckbox3.checked || whatsCheckbox4 && whatsCheckbox4.checked) {
        return value.trim() !== '';
      }
      return true;
    },
    errorMessage: 'Campo obligatorio'
  }]).addField('#comment-quiz', [{
    rule: 'required',
    errorMessage: 'Campo requerido'
  }]).onSuccess(function () {
    var _form$querySelector, _form$querySelector2, _form$querySelector3, _form$querySelector4, _form$querySelector5, _form$querySelector$v, _form$querySelector6, _form$querySelector$v2, _form$querySelector7, _form$querySelector$v3, _form$querySelector8, _form$querySelector$v4, _form$querySelector9;
    formData.append('action', 'mos_submit_quiz');
    formData.append('user_wp', document.querySelector('input[name="user-name-quiz"]').value);
    formData.append('recommendation', (_form$querySelector = form.querySelector('input[name="recommendation-quiz"]:checked')) === null || _form$querySelector === void 0 ? void 0 : _form$querySelector.value);
    formData.append('qualification', (_form$querySelector2 = form.querySelector('input[name="qualification-quiz"]:checked')) === null || _form$querySelector2 === void 0 ? void 0 : _form$querySelector2.value);
    formData.append('presentation', (_form$querySelector3 = form.querySelector('input[name="presentation-quiz"]:checked')) === null || _form$querySelector3 === void 0 ? void 0 : _form$querySelector3.value);
    formData.append('experience', (_form$querySelector4 = form.querySelector('input[name="experience-quiz"]:checked')) === null || _form$querySelector4 === void 0 ? void 0 : _form$querySelector4.value);
    formData.append('reasons', Array.from(form.querySelectorAll('input[name="reason-quiz"]:checked')).map(function (el) {
      return el.value;
    }));
    formData.append('other_reason', document.getElementById('reason-quiz-other').value);
    formData.append('channel', (_form$querySelector5 = form.querySelector('input[name="canal-quiz"]:checked')) === null || _form$querySelector5 === void 0 ? void 0 : _form$querySelector5.value);
    formData.append('site_experience', (_form$querySelector$v = (_form$querySelector6 = form.querySelector('input[name="siteweb-quiz"]:checked')) === null || _form$querySelector6 === void 0 ? void 0 : _form$querySelector6.value) !== null && _form$querySelector$v !== void 0 ? _form$querySelector$v : '');
    formData.append('site_navigation', (_form$querySelector$v2 = (_form$querySelector7 = form.querySelector('input[name="nav-siteweb-quiz"]:checked')) === null || _form$querySelector7 === void 0 ? void 0 : _form$querySelector7.value) !== null && _form$querySelector$v2 !== void 0 ? _form$querySelector$v2 : '');
    formData.append('site_improvement', document.getElementById('nav-siteweb-no-quiz').value);
    formData.append('advisor_experience', (_form$querySelector$v3 = (_form$querySelector8 = form.querySelector('input[name="whats-quiz"]:checked')) === null || _form$querySelector8 === void 0 ? void 0 : _form$querySelector8.value) !== null && _form$querySelector$v3 !== void 0 ? _form$querySelector$v3 : '');
    formData.append('advisor_improvement', document.getElementById('whats-rema-quiz').value);
    formData.append('delivery_experience', (_form$querySelector$v4 = (_form$querySelector9 = form.querySelector('input[name="calser-quiz"]:checked')) === null || _form$querySelector9 === void 0 ? void 0 : _form$querySelector9.value) !== null && _form$querySelector$v4 !== void 0 ? _form$querySelector$v4 : '');
    formData.append('delivery_improvement', document.getElementById('calser-rema-quiz').value);
    formData.append('comment', document.getElementById('comment-quiz').value);
    button.disabled = true;
    button.textContent = 'CARGANDO...';
    (0,_helpers_ajax__WEBPACK_IMPORTED_MODULE_0__["default"])({
      url: jsVars.ajax_url,
      method: 'POST',
      params: formData,
      async: true,
      done: function done(response) {
        if (response.success) {
          if (containerGeneral) {
            window.scrollTo({
              top: 0
            });
            containerGeneral.innerHTML = "<div class=\"mos__container\"><h2>\xA1Gracias por completar la encuesta!</h2><p>".concat(response.data, "</p></div>");
          }
        } else {
          if (messageResult) {
            messageResult.innerHTML = response.data;
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
        button.textContent = 'ENVIAR';
        button.disabled = false;
        setTimeout(function () {
          messageResult.innerHTML = '';
        }, 5000);
        //console.log('La solicitud AJAX ha finalizado.');
      }
    });
  });
  otroCheckbox.addEventListener('change', function () {
    if (this.checked) {
      otroInputContainer.style.display = 'block';
    } else {
      otroInputContainer.style.display = 'none';
      otroInput.value = '';
    }
    validation.revalidateField('#reason-quiz-other');
  });
  canalWebCheckbox.addEventListener('change', function () {
    if (this.checked) {
      webInputContainer.style.display = 'block';
      whatsInputContainer.style.display = 'none';
      ['#siteweb_1_quiz_radio_group', '#siteweb_2_quiz_radio_group'].forEach(function (groupSelector) {
        validation.addRequiredGroup(groupSelector);
      });
      ['#whats_1_quiz_radio_group', '#whats_2_quiz_radio_group'].forEach(function (groupSelector) {
        if (validation.hasGroup && validation.hasGroup(groupSelector)) {
          validation.removeGroup(groupSelector);
        }
      });
    } else {
      webInputContainer.style.display = 'none';
      whatsInputContainer.style.display = 'block';
      ['#siteweb_1_quiz_radio_group', '#siteweb_2_quiz_radio_group'].forEach(function (groupSelector) {
        validation.removeGroup(groupSelector);
      });
    }
  });
  canalWhatsCheckbox.addEventListener('change', function () {
    if (this.checked) {
      webInputContainer.style.display = 'none';
      whatsInputContainer.style.display = 'block';
      siCanalWebCheckbox.checked = false;
      noCanalWebCheckbox.checked = false;
      ['#whats_1_quiz_radio_group', '#whats_2_quiz_radio_group'].forEach(function (groupSelector) {
        if (validation.hasGroup && validation.hasGroup(groupSelector)) {
          validation.addRequiredGroup(groupSelector);
        }
      });
      ['#siteweb_1_quiz_radio_group', '#siteweb_2_quiz_radio_group'].forEach(function (groupSelector) {
        validation.removeGroup(groupSelector);
      });
    } else {
      webInputContainer.style.display = 'block';
      whatsInputContainer.style.display = 'none';
      ['#whats_1_quiz_radio_group', '#whats_2_quiz_radio_group'].forEach(function (groupSelector) {
        if (validation.hasGroup && validation.hasGroup(groupSelector)) {
          validation.removeGroup(groupSelector);
        }
      });
    }
  });
  noCanalWebCheckbox.addEventListener('change', function () {
    if (this.checked) {
      noCanalWebContainer.style.display = 'block';
    }
    validation.revalidateField('#nav-siteweb-no-quiz');
  });
  siCanalWebCheckbox.addEventListener('change', function () {
    if (this.checked) {
      noCanalWebContainer.style.display = 'none';
      noCanalWebInput.value = '';
    }
  });
  textarea.addEventListener('input', function () {
    this.style.height = 'auto'; // Reinicia la altura
    this.style.height = this.scrollHeight + 'px'; // Ajusta al contenido
  });
  calserCheckbox.forEach(function (radio) {
    radio.addEventListener('change', function () {
      var selectedOption = document.querySelector('input[name="calser-quiz"]:checked');
      if (selectedOption) {
        var value = selectedOption.value;
        if (value === 'Regular' || value === 'Mala') {
          calserContainer.style.display = 'block';
        } else {
          validation.revalidateField('#calser-rema-quiz');
          calserContainer.style.display = 'none';
        }
      }
    });
  });
  whatsCheckbox.forEach(function (radio) {
    radio.addEventListener('change', function () {
      var selectedOption = document.querySelector('input[name="whats-quiz"]:checked');
      if (selectedOption) {
        var value = selectedOption.value;
        if (value === 'Regular' || value === 'Mala') {
          whatsContainer.style.display = 'block';
        } else {
          validation.revalidateField('#whats-rema-quiz');
          whatsContainer.style.display = 'none';
        }
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
/******/ __webpack_require__.O(0, ["/js/vendor"], function() { return __webpack_exec__("./src/js/blocks/quiz.js"); });
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=quiz.js.map
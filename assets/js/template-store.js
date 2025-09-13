"use strict";
(self["webpackChunkmosqueira"] = self["webpackChunkmosqueira"] || []).push([["/js/template-store"],{

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

/***/ "./src/js/templates/template-store.js":
/*!********************************************!*\
  !*** ./src/js/templates/template-store.js ***!
  \********************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _helpers_ajax__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../helpers/ajax */ "./src/js/helpers/ajax.js");
/* global jsVars */

window.addEventListener('load', function () {
  var buttonFilterAttr = document.getElementById('mos-store-filters-btn');
  var result = document.getElementById('mos-archive-product');
  var filterOrder = document.querySelectorAll('.filter-order');
  var currentCategory = document.getElementById('product-current-category');
  var loadMoreBtn = document.getElementById('mos-load-more-product');
  var inputOrder = document.getElementById('mos-filter-order');
  function doesNotIncludeEmptyString(arr) {
    return !arr.includes('');
  }
  function getCheckedValues(name) {
    return Array.from(document.querySelectorAll("input[name=\"".concat(name, "\"]:checked"))).map(function (input) {
      return input.value;
    });
  }
  function handleExclusiveCheckbox(groupName) {
    var checkboxes = document.querySelectorAll("input[name=\"".concat(groupName, "\"]"));
    checkboxes.forEach(function (checkbox) {
      checkbox.addEventListener('change', function () {
        var _this = this;
        var isEmpty = this.value === '';
        if (isEmpty && this.checked) {
          // Si se selecciona la opción '', deselecciona todas las demás
          checkboxes.forEach(function (cb) {
            if (cb !== _this) cb.checked = false;
          });
        } else if (!isEmpty && this.checked) {
          // Si se selecciona otra opción, deselecciona la vacía
          checkboxes.forEach(function (cb) {
            if (cb.value === '') cb.checked = false;
          });
        }
      });
    });
  }
  document.querySelectorAll('.mos__store__filters__item').forEach(function (item) {
    var button = item.querySelector('button');
    var dropdown = item.querySelector('.mos__store__filters__item__content');
    if (dropdown) {
      button.addEventListener('click', function (event) {
        event.stopPropagation();
        // Cierra cualquier otro desplegable activo
        document.querySelectorAll('.mos__store__filters__item .mos__store__filters__item__content.active').forEach(function (otherDropdown) {
          if (otherDropdown !== dropdown) {
            otherDropdown.classList.remove('active');
          }
        });
        // Alterna la clase 'active' del desplegable actual
        dropdown.classList.toggle('active');
      });
    }
  });
  document.addEventListener('click', function (event) {
    document.querySelectorAll('.mos__store__filters__item .mos__store__filters__item__content.active').forEach(function (dropdown) {
      if (!dropdown.closest('.mos__store__filters__item').contains(event.target)) {
        dropdown.classList.remove('active');
      }
    });
  });
  var array_id_one = [];
  var get_post = '';
  if (result) {
    for (var i = 0; i < result.children.length; i++) {
      array_id_one.push(result.children[i].getAttribute('data-product-id'));
    }
  }
  if (buttonFilterAttr) {
    buttonFilterAttr.addEventListener('click', function () {
      var formData = new FormData();
      var colores = getCheckedValues('color[]');
      var tallas = getCheckedValues('talla[]');
      var container = this.parentElement.parentElement;

      //result.innerHTML = 'Cargando...';
      container.classList.remove('active');
      formData.append('action', 'get_related_atribute_products');
      formData.append('category', currentCategory.value);
      formData.append('orden', inputOrder.value);
      formData.append('page', 1);
      if (doesNotIncludeEmptyString(colores)) {
        colores.forEach(function (color) {
          return formData.append('colores[]', color);
        });
      }
      if (doesNotIncludeEmptyString(tallas)) {
        tallas.forEach(function (talla) {
          return formData.append('tallas[]', talla);
        });
      }
      result.innerHTML = '';
      (0,_helpers_ajax__WEBPACK_IMPORTED_MODULE_0__["default"])({
        url: jsVars.ajax_url,
        method: 'POST',
        params: formData,
        async: true,
        done: function done(response) {
          result.innerHTML += response.data.html;
          if (response.data.html == '') {
            loadMoreBtn.classList.add('ds-none');
            result.innerHTML = '<p style="position: absolute;">' + response.data.message + '</p>';
          } else {
            loadMoreBtn.classList.remove('ds-none');
          }
          loadMoreBtn.dataset.page = 1;
          //console.log(response);
        },
        error: function error() {
          //console.error('Error al procesar la solicitud:', status);
          //alert('Error en la solicitud AJAX');
        },
        always: function always() {
          //console.log('La solicitud AJAX ha finalizado.');
        }
      });
    });
  }
  filterOrder.forEach(function (item) {
    item.addEventListener('click', function () {
      var parent = this.parentElement;
      var parentContainer = parent.parentElement;
      var buttonText = parentContainer.querySelector('button span');
      var textItem = this.textContent;
      var orden = item.getAttribute('data-orden');
      var formData = new FormData();
      parent.classList.remove('active');
      buttonText.innerHTML = textItem;
      inputOrder.value = orden;
      formData.append('action', 'get_product_by_order');
      formData.append('category', currentCategory.value);
      formData.append('orden', orden);
      formData.append('page', 1);
      (0,_helpers_ajax__WEBPACK_IMPORTED_MODULE_0__["default"])({
        url: jsVars.ajax_url,
        method: 'POST',
        params: formData,
        async: true,
        done: function done(response) {
          result.innerHTML = response.html;
          loadMoreBtn.dataset.page = 1;
          loadMoreBtn.classList.toggle('ds-none', !response.enabled);
          //console.log(response);
          if (!response.enabled) {
            result.innerHTML = '<p style="position: absolute;">' + response.data.message + '</p>';
          }
        },
        error: function error() {
          //console.error('Error al procesar la solicitud:', status);
          //alert('Error en la solicitud AJAX');
        },
        always: function always() {
          //console.log('La solicitud AJAX ha finalizado.');
        }
      });
    });
  });
  if (loadMoreBtn) {
    get_post = array_id_one.toString();
    loadMoreBtn.addEventListener('click', function (e) {
      e.preventDefault();
      var page = loadMoreBtn.getAttribute('data-page');
      var category = loadMoreBtn.getAttribute('data-cat');
      var formData = new FormData();
      var colores = getCheckedValues('color[]');
      var tallas = getCheckedValues('talla[]');
      array_id_one = [];
      for (var _i = 0; _i < result.children.length; _i++) {
        array_id_one.push(result.children[_i].getAttribute('data-product-id'));
      }
      get_post = array_id_one.toString();
      formData.append('action', 'load_more_product_post');
      formData.append('nonce', jsVars.nonce);
      formData.append('page', page);
      formData.append('get_post', get_post);
      formData.append('orden', inputOrder.value);
      formData.append('category_id', category);
      if (doesNotIncludeEmptyString(colores)) {
        colores.forEach(function (color) {
          return formData.append('colores[]', color);
        });
      }
      if (doesNotIncludeEmptyString(tallas)) {
        tallas.forEach(function (talla) {
          return formData.append('tallas[]', talla);
        });
      }
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
            if (response.data.message) {
              result.innerHTML = '<p style="position: absolute;">' + response.data.message + '</p>';
            }
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
  handleExclusiveCheckbox('color[]');
  handleExclusiveCheckbox('talla[]');
});

/***/ })

},
/******/ function(__webpack_require__) { // webpackRuntimeModules
/******/ var __webpack_exec__ = function(moduleId) { return __webpack_require__(__webpack_require__.s = moduleId); }
/******/ var __webpack_exports__ = (__webpack_exec__("./src/js/templates/template-store.js"));
/******/ }
]);
//# sourceMappingURL=template-store.js.map
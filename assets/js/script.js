(self["webpackChunkmosqueira"] = self["webpackChunkmosqueira"] || []).push([["/js/script"],{

/***/ "./src/js/components/add-to-cart/index.js":
/*!************************************************!*\
  !*** ./src/js/components/add-to-cart/index.js ***!
  \************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _helpers_ajax__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../helpers/ajax */ "./src/js/helpers/ajax.js");
/* harmony import */ var _helpers_on__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../helpers/on */ "./src/js/helpers/on.js");
/* global jsVars */


window.addEventListener('load', function () {
  var resultCart = document.getElementById('mos-carrito-result');
  var countCart = document.querySelector('.cart-count');
  var body = document.body;
  var modalCart = document.getElementById('mos-modal-carrito');
  var btnCouponCode = document.getElementById('apply_coupon_btn');
  var subTotal = document.querySelector('.cart-sub-total');
  var total = document.querySelector('.cart-total');
  var popupSubTotal = document.querySelector('.pop-cart-subtotal');
  var popupTotal = document.querySelector('.pop-cart-total');
  var popupDesc = document.querySelector('.pop-cart-desc');
  var messageResult = document.getElementById('message-product-single');
  var modalCombine = document.getElementById('mos-modal-combine');
  var datacuponcustomServer = document.querySelectorAll('.data-cupon-custom-server');
  var datacuponcustomTemp = document.querySelectorAll('.data-cupon-custom-temp');
  var cartFeesPriceQuantity = document.querySelector('.cart-fees-price');
  if (datacuponcustomServer.length > 0) {
    datacuponcustomTemp.forEach(function (element) {
      element.remove();
    });
  }
  function quantityAjax(newKey, newVal) {
    var formData = new FormData();
    var loadingCart = document.querySelector('.mos__cart__loading');
    formData.append('action', 'set_cart_item_quantity');
    formData.append('key', newKey);
    formData.append('quantity', newVal);
    if (loadingCart) {
      loadingCart.classList.add('active');
    }
    (0,_helpers_ajax__WEBPACK_IMPORTED_MODULE_0__["default"])({
      url: jsVars.ajax_url,
      method: 'POST',
      params: formData,
      async: true,
      done: function done(response) {
        if (response.success) {
          if (resultCart) {
            var _response$data;
            resultCart.innerHTML = response === null || response === void 0 || (_response$data = response.data) === null || _response$data === void 0 ? void 0 : _response$data.mini_cart;
          }
          if (countCart) {
            var _response$data2;
            countCart.innerHTML = response === null || response === void 0 || (_response$data2 = response.data) === null || _response$data2 === void 0 ? void 0 : _response$data2.cart_count;
          }
          if (subTotal) {
            var _response$data3;
            subTotal.innerHTML = response === null || response === void 0 || (_response$data3 = response.data) === null || _response$data3 === void 0 ? void 0 : _response$data3.subtotal;
          }
          if (total) {
            var _response$data4;
            total.innerHTML = response === null || response === void 0 || (_response$data4 = response.data) === null || _response$data4 === void 0 ? void 0 : _response$data4.total;
          }
          if (cartFeesPriceQuantity) {
            var _response$data5;
            cartFeesPriceQuantity.innerHTML = '-' + (response === null || response === void 0 || (_response$data5 = response.data) === null || _response$data5 === void 0 ? void 0 : _response$data5.discount_total);
          }
        }
      },
      error: function error(/*error*/
      ) {
        //console.info(error);
      },
      always: function always() {
        loadingCart.classList.remove('active');
      }
    });
  }
  (0,_helpers_on__WEBPACK_IMPORTED_MODULE_1__["default"])(document, 'click', '.remove-coupon-btn', function () {
    var li = this.closest('li');
    var couponCode = li.getAttribute('data-coupon');
    var subTotal = document.querySelector('.cart-sub-total');
    var total = document.querySelector('.cart-total');
    var desc = document.querySelector('.cart-desc');
    var datacuponcustom = document.querySelectorAll('.data-cupon-custom');
    var data = new FormData();
    data.append('action', 'remove_coupon_ajax');
    data.append('coupon_code', couponCode);
    if (datacuponcustomServer.length > 0) {
      datacuponcustomTemp.forEach(function (element) {
        element.remove();
      });
    }
    (0,_helpers_ajax__WEBPACK_IMPORTED_MODULE_0__["default"])({
      url: jsVars.ajax_url,
      method: 'POST',
      params: data,
      async: true,
      done: function done(response) {
        if (response.success) {
          desc.innerHTML = "<div class=\"ds-flex justify-space-between\"><span>Descuento</span><span><strong>-".concat(response.data.discount, "</strong></span></div><br>");
          subTotal.innerHTML = response.data.subtotal;
          total.innerHTML = response.data.total;
          popupSubTotal.innerHTML = response.data.subtotal;
          popupTotal.innerHTML = response.data.total;
          setTimeout(function () {
            popupDesc.innerHTML = response.data.discount;
          }, 1000);
          li.remove();
          if (!response.data.has_coupon) {
            desc.innerHTML = '';
          }
          datacuponcustom.forEach(function (element) {
            element.classList.add('ds-none');
          });
        }
      },
      error: function error(/*error*/
      ) {
        //console.info(error);
      },
      always: function always() {}
    });
  });
  (0,_helpers_on__WEBPACK_IMPORTED_MODULE_1__["default"])(document, 'click', '#apply_coupon_btn', function () {
    var messageCoupon = document.getElementById('promo_code_message');
    var subTotal = document.querySelector('.cart-sub-total');
    var total = document.querySelector('.cart-total');
    var desc = document.querySelector('.cart-desc');
    var datacuponcustom = document.querySelectorAll('.data-cupon-custom');
    var couponContent = document.querySelector('.cart-coupons');
    var couponCode = document.getElementById('promo_code').value;
    if (datacuponcustomServer.length > 0) {
      datacuponcustomTemp.forEach(function (element) {
        element.remove();
      });
    }
    if (!couponCode) return;
    var data = new FormData();
    messageCoupon.innerHTML = '';
    btnCouponCode.style.pointerEvents = 'none';
    data.append('action', 'apply_coupon_ajax');
    data.append('coupon_code', couponCode);
    (0,_helpers_ajax__WEBPACK_IMPORTED_MODULE_0__["default"])({
      url: jsVars.ajax_url,
      method: 'POST',
      params: data,
      async: true,
      done: function done(response) {
        if (response.success) {
          desc.innerHTML = "<div class=\"ds-flex justify-space-between\"><span>Descuento</span><span><strong>-".concat(response.data.discount, "</strong></span></div><br>");
          subTotal.innerHTML = response.data.subtotal;
          total.innerHTML = response.data.total;
          popupSubTotal.innerHTML = response.data.subtotal;
          popupTotal.innerHTML = response.data.total;
          setTimeout(function () {
            popupDesc.innerHTML = "-".concat(response.data.discount);
          }, 1000);
          var html = '';
          if (response.data.coupons.length > 0) {
            html += '<ul>';
            response.data.coupons.forEach(function (coupon) {
              html += "\n\t\t\t\t\t\t\t\t<li class=\"ds-flex align-center justify-space-between\" data-coupon=\"".concat(coupon.code, "\">\n\t\t\t\t\t\t\t\t\t<span>\n\t\t\t\t\t\t\t\t\t\t<strong>").concat(coupon.code, "</strong>\n\t\t\t\t\t\t\t\t\t\t- Descuento: ").concat(coupon.amount, "\n\t\t\t\t\t\t\t\t\t</span>\n\t\t\t\t\t\t\t\t\t<button type=\"button\" class=\"remove-coupon-btn\">\n\t\t\t\t\t\t\t\t\t\t<svg width=\"16\" height=\"16\" viewBox=\"0 0 16 16\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">\n\t\t\t\t\t\t\t\t\t\t\t<path d=\"M7 7H5V13H7V7Z\" fill=\"black\"></path>\n\t\t\t\t\t\t\t\t\t\t\t<path d=\"M11 7H9V13H11V7Z\" fill=\"black\"></path>\n\t\t\t\t\t\t\t\t\t\t\t<path d=\"M12 1C12 0.4 11.6 0 11 0H5C4.4 0 4 0.4 4 1V3H0V5H1V15C1 15.6 1.4 16 2 16H14C14.6 16 15 15.6 15 15V5H16V3H12V1ZM6 2H10V3H6V2ZM13 5V14H3V5H13Z\" fill=\"black\"></path>\n\t\t\t\t\t\t\t\t\t\t</svg>\n\t\t\t\t\t\t\t\t\t</button>\n\t\t\t\t\t\t\t\t</li>\n\t\t\t\t\t\t\t");
            });
            html += '</ul>';
          }
          couponContent.innerHTML = html;
          datacuponcustom.forEach(function (element) {
            element.classList.remove('ds-none');
          });
        } else {
          messageCoupon.innerHTML = "<span>".concat(response.data, "</span>");
          datacuponcustom.forEach(function (element) {
            element.classList.add('ds-none');
          });
        }
      },
      error: function error(/*error*/
      ) {
        //console.info(error);
      },
      always: function always() {
        btnCouponCode.style.pointerEvents = 'auto';
      }
    });
  });
  (0,_helpers_on__WEBPACK_IMPORTED_MODULE_1__["default"])(document, 'click', '.js-btn-quantity', function () {
    var input = this.parentNode.querySelector('.quantity');
    var quantity = input.value;
    var key = input.getAttribute('name');
    var newVal;
    if (this.classList.contains('btn-plus')) {
      newVal = parseFloat(quantity) + 1;
      if (quantity === '10') {
        return false;
      }
      if (isNaN(newVal)) {
        newVal = 1;
      }
    } else {
      if (quantity > 1) {
        newVal = parseFloat(quantity) - 1;
      } else {
        return false;
      }
    }
    input.value = newVal;
    quantityAjax(key, newVal);
  });
  (0,_helpers_on__WEBPACK_IMPORTED_MODULE_1__["default"])(document, 'click', '.js-add-cart', function () {
    var button = this;
    var product_id = this.dataset.id;
    var formData = new FormData();
    var quantity = this.closest('.js-cart-product').querySelector('.product-quantity') || 1;
    var color = this.closest('.js-cart-product').querySelector('select[name="attribute_pa_color"]');
    var talla = this.closest('.js-cart-product').querySelector('select[name="attribute_pa_talla"]');
    var variation_id = 0;
    var variation = {};
    if (quantity) {
      quantity = quantity.value;
    }
    /*if (color) {
    	variation['attribute_pa_color'] = color.value;
    }*/
    if (color) {
      //formData.append('color', color.value);
      formData.append('color', color.options[color.selectedIndex].textContent);
    }
    if (talla.value === '') {
      messageResult.innerHTML = '<p style="text-align:center; color:red; margin: 20px 0 0;">Seleccione una talla</p>';
      setTimeout(function () {
        messageResult.innerHTML = '';
      }, 2000);
      return;
    }
    if (talla) {
      variation['attribute_pa_talla'] = talla.options[talla.selectedIndex].textContent;
      variation_id = talla.value;
    }
    formData.append('action', 'add_product_to_cart');
    formData.append('product_id', product_id);
    formData.append('quantity', quantity);
    formData.append('variation', JSON.stringify(variation));
    formData.append('variation_id', variation_id);
    button.textContent = 'CARGANDO...';
    button.style.pointerEvents = 'none';
    (0,_helpers_ajax__WEBPACK_IMPORTED_MODULE_0__["default"])({
      url: jsVars.ajax_url,
      method: 'POST',
      params: formData,
      async: true,
      done: function done(response) {
        if (response.success) {
          if (resultCart) {
            var _response$data6;
            resultCart.innerHTML = response === null || response === void 0 || (_response$data6 = response.data) === null || _response$data6 === void 0 ? void 0 : _response$data6.mini_cart;
          }
          if (countCart) {
            var _response$data7;
            countCart.innerHTML = response === null || response === void 0 || (_response$data7 = response.data) === null || _response$data7 === void 0 ? void 0 : _response$data7.cart_count;
          }
          if (modalCart) {
            var _response$data8;
            if ((response === null || response === void 0 || (_response$data8 = response.data) === null || _response$data8 === void 0 ? void 0 : _response$data8.cart_count) < 1) {
              modalCart.classList.add('cart-empty');
            } else {
              modalCart.classList.remove('cart-empty');
              countCart.classList.remove('hidden');
            }
            setTimeout(function () {
              modalCart.classList.add('active');
              body.classList.add('no-scroll');
            }, 600);
          }
        } else {
          if (messageResult) {
            var _response$data9;
            messageResult.innerHTML = "<p style=\"text-align:center; color:red; margin: 20px 0 0;\">".concat(response === null || response === void 0 || (_response$data9 = response.data) === null || _response$data9 === void 0 ? void 0 : _response$data9.message, "</p>");
          }
        }
      },
      error: function error() {
        //console.error('Error al procesar la solicitud:', status);
        //alert('Error en la solicitud AJAX');
      },
      always: function always() {
        //console.log('La solicitud AJAX ha finalizado.');
        button.innerHTML = 'AGREGAR AL CARRITO';
        button.style.pointerEvents = 'auto';
        if (messageResult) {
          setTimeout(function () {
            messageResult.innerHTML = '';
          }, 3000);
        }
      }
    });
  });
  (0,_helpers_on__WEBPACK_IMPORTED_MODULE_1__["default"])(document, 'click', '.js-quick-purchase', function () {
    var product_id = this.closest('.js-cart-product').getAttribute('data-product-id');
    var attr_talla = this.getAttribute('data-talla');
    var quantity = 1;
    var variation = {};
    var variation_id = this.getAttribute('data-id') || 0;
    var formData = new FormData();
    variation['attribute_pa_talla'] = attr_talla;
    formData.append('action', 'add_product_to_quick_purchase');
    formData.append('product_id', product_id);
    formData.append('quantity', quantity);
    formData.append('variation', JSON.stringify(variation));
    formData.append('variation_id', variation_id);
    (0,_helpers_ajax__WEBPACK_IMPORTED_MODULE_0__["default"])({
      url: jsVars.ajax_url,
      method: 'POST',
      params: formData,
      async: true,
      done: function done(response) {
        if (response.success) {
          if (body.classList.contains('single-product')) {
            modalCombine.classList.remove('active');
          }
          if (resultCart) {
            var _response$data0;
            resultCart.innerHTML = response === null || response === void 0 || (_response$data0 = response.data) === null || _response$data0 === void 0 ? void 0 : _response$data0.mini_cart;
          }
          if (countCart) {
            var _response$data1;
            countCart.innerHTML = response === null || response === void 0 || (_response$data1 = response.data) === null || _response$data1 === void 0 ? void 0 : _response$data1.cart_count;
          }
          if (modalCart) {
            var _response$data10;
            if ((response === null || response === void 0 || (_response$data10 = response.data) === null || _response$data10 === void 0 ? void 0 : _response$data10.cart_count) < 1) {
              modalCart.classList.add('cart-empty');
            } else {
              modalCart.classList.remove('cart-empty');
              countCart.classList.remove('hidden');
            }
            setTimeout(function () {
              modalCart.classList.add('active');
              body.classList.add('no-scroll');
            }, 600);
          }
        } else {
          var _response$data11;
          alert(response === null || response === void 0 || (_response$data11 = response.data) === null || _response$data11 === void 0 ? void 0 : _response$data11.message);
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
  (0,_helpers_on__WEBPACK_IMPORTED_MODULE_1__["default"])(document, 'click', '.delete-cart-product', function () {
    var _this = this;
    var product_key = this.dataset.key;
    var formData = new FormData();
    formData.append('action', 'delete_product_to_cart');
    formData.append('key', product_key);
    if (datacuponcustomServer.length > 0) {
      datacuponcustomTemp.forEach(function (element) {
        element.remove();
      });
    }
    (0,_helpers_ajax__WEBPACK_IMPORTED_MODULE_0__["default"])({
      url: jsVars.ajax_url,
      method: 'POST',
      params: formData,
      async: true,
      done: function done(response) {
        if (response.success) {
          // Actualizar mini carrito y contador
          resultCart.innerHTML = response.data.mini_cart;
          countCart.innerHTML = response.data.cart_count;

          // Actualizar subtotal
          var _subTotal = document.querySelector('.cart-sub-total');
          if (_subTotal) {
            _subTotal.innerHTML = response.data.subtotal;
          }
          var discount = document.querySelector('.cart-desc');
          var discountFees = document.querySelector('.cart-desc-fees');
          //const cartFees = document.querySelector('.cart-fees');
          var cartFeesPrice = document.querySelector('.cart-fees-price');
          if (discount && response.data.discount_total && response.data.has_discount == true && !discountFees) {
            discount.innerHTML = "\n\t\t\t\t\t\t\t<div class=\"ds-flex justify-space-between\">\n\t\t\t\t\t\t\t<span>Descuento</span>\n\t\t\t\t\t\t\t<span>\n\t\t\t\t\t\t\t\t<strong>-".concat(response.data.discount_total, "</strong>\n\t\t\t\t\t\t\t</span>\n\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t<br>\n\t\t\t\t\t\t");
          }
          if (cartFeesPrice) {
            cartFeesPrice.innerHTML = '-' + response.data.discount_total;
          }
          var popCartDesc = document.querySelector('.pop-cart-desc');
          setTimeout(function () {
            if (popCartDesc && response.data.discount_total && response.data.has_discount == true) {
              popCartDesc.innerHTML = response.data.discount_total;
            }
          }, 1000);
          var popCartTotal = document.querySelector('.pop-cart-total');
          if (popCartTotal) {
            popCartTotal.innerHTML = response.data.total;
          }

          // Actualizar total
          var _total = document.querySelector('.cart-total');
          if (_total) {
            _total.innerHTML = response.data.total;
          }

          // Mostrar/ocultar carrito vacío
          if (response.data.cart_count < 1) {
            modalCart.classList.add('cart-empty');
            countCart.classList.add('hidden');
          } else {
            modalCart.classList.remove('cart-empty');
            countCart.classList.remove('hidden');
          }

          // Si estás en la página de carrito, elimina el item del DOM y recarga si necesario
          if (jsVars.is_cart === '1') {
            var parentLi = _this.closest('li.cart__item');
            if (parentLi) parentLi.remove();
            if (response.data.carrito) {
              setTimeout(function () {
                window.location.reload();
              }, 500);
            }
          }
        }
      },
      error: function error() {
        //console.error('Error al procesar la solicitud AJAX');
      }
    });
  });
  (0,_helpers_on__WEBPACK_IMPORTED_MODULE_1__["default"])(document, 'click', '.modal__cart__close', function () {
    modalCart.classList.remove('active');
    body.classList.remove('no-scroll');
  });

  //***********************************PACK******************************************

  // Tabla de precios fijos por cantidad total de productos en el pack
  var packPrices = {
    2: 180.00,
    3: 255.00,
    4: 320.00,
    5: 390.00,
    6: 450.00
  };
  var packItems = {};
  var miniCart = document.getElementById('mini-pack-cart');
  var addPackBtn = document.getElementById('add-pack-to-cart');
  var errorMsgDiv = document.createElement('div');
  errorMsgDiv.className = 'pack-error-message';
  errorMsgDiv.style.color = 'red';
  errorMsgDiv.style.marginTop = '10px';

  // Cargar pack guardado en localStorage si existe
  if (addPackBtn) {
    var savedPack = localStorage.getItem('mosqueira_pack');
    if (savedPack) {
      try {
        packItems = JSON.parse(savedPack);
      } catch (e) {
        //console.error('Error al parsear pack del localStorage:', e);
      }
    }

    // Evento: seleccionar talla
    document.querySelectorAll('.size-option.in-stock').forEach(function (option) {
      option.addEventListener('click', function () {
        var variationId = option.dataset.id;
        var size = option.dataset.talla;
        var title = option.closest('.product-card').querySelector('h2').innerText;

        // Sumar cantidad total actual + 1 para validar límite
        var totalQty = 0;
        Object.values(packItems).forEach(function (item) {
          return totalQty += item.quantity;
        });
        if (totalQty >= 6) {
          showError('Máximo 6 productos en el pack.');
          return;
        }

        // Agregar o aumentar cantidad
        if (packItems[variationId]) {
          packItems[variationId].quantity += 1;
        } else {
          packItems[variationId] = {
            size: size,
            title: title,
            quantity: 1
          };
        }
        clearError();
        localStorage.setItem('mosqueira_pack', JSON.stringify(packItems));
        renderMiniCart();
      });
    });

    // Evento: eliminar ítem
    miniCart.addEventListener('click', function (e) {
      if (e.target.closest('.remove-item')) {
        var id = e.target.closest('.remove-item').dataset.id;
        delete packItems[id];
        clearError();
        localStorage.setItem('mosqueira_pack', JSON.stringify(packItems));
        renderMiniCart();
      }
    });

    // Evento: enviar pack al servidor
    addPackBtn.addEventListener('click', function () {
      var _this2 = this;
      var totalQty = Object.values(packItems).reduce(function (acc, item) {
        return acc + item.quantity;
      }, 0);
      if (totalQty < 2) {
        showError('Debe seleccionar al menos 2 productos para el pack.');
        return;
      }
      if (totalQty > 6) {
        showError('Máximo 6 productos permitidos en el pack.');
        return;
      }

      // Calcular precio fijo según cantidad
      var packTotal = packPrices[totalQty];
      if (!packTotal) {
        showError('Error: Precio para esta cantidad no definido.');
        return;
      }
      clearError();
      var formData = new FormData();
      formData.append('action', 'create_dynamic_pack');
      formData.append('pack_items', JSON.stringify(packItems));
      formData.append('pack_total', packTotal);
      this.classList.add('loading');
      this.closest('.mini-pack-cart').classList.add('loading');
      fetch(jsVars.ajax_url, {
        method: 'POST',
        body: formData,
        credentials: 'same-origin'
      }).then(function (res) {
        return res.json();
      }).then(function (response) {
        if (response.success) {
          localStorage.removeItem('mosqueira_pack');
          packItems = {};
          renderMiniCart();
          modalCart.classList.remove('cart-empty');
          refreshCustomMiniCart();

          // Actualizar contador de carrito si existe
          if (typeof countCart !== 'undefined' && countCart) {
            countCart.innerHTML = response.data.total_items;
            countCart.classList.remove('hidden');
          }
          _this2.classList.remove('loading');
          _this2.closest('.mini-pack-cart').classList.remove('loading');
        } else {
          var _response$data12;
          showError(((_response$data12 = response.data) === null || _response$data12 === void 0 ? void 0 : _response$data12.message) || 'Error desconocido al agregar pack.');
          _this2.classList.remove('loading');
          _this2.closest('.mini-pack-cart').classList.remove('loading');
        }
      })["catch"](function (error) {
        showError('Error al enviar el pack: ' + error.message);
        _this2.classList.remove('loading');
        _this2.closest('.mini-pack-cart').classList.remove('loading');
      });
    });

    // Renderizar mini carrito con productos y total
    renderMiniCart();
  }

  // Función para renderizar el mini carrito del pack
  function renderMiniCart() {
    miniCart.innerHTML = '';
    var totalItems = 0;
    Object.keys(packItems).forEach(function (variationId) {
      var item = packItems[variationId];
      totalItems += item.quantity;
      var div = document.createElement('div');
      div.className = 'mini-cart-item';
      var unitText = item.quantity === 1 ? "".concat(item.quantity, " unidad") : "".concat(item.quantity, " unidades");
      div.innerHTML = "\n            <strong>".concat(item.title, "</strong> - Talla: ").concat(item.size.toUpperCase(), " - (").concat(unitText, ")\n            <button data-id=\"").concat(variationId, "\" class=\"remove-item\" title=\"Eliminar producto\">\n                <svg width=\"16\" height=\"16\" viewBox=\"0 0 16 16\" fill=\"none\" aria-hidden=\"true\">\n                    <path d=\"M7 7H5V13H7V7Z\" fill=\"black\"></path>\n                    <path d=\"M11 7H9V13H11V7Z\" fill=\"black\"></path>\n                    <path d=\"M12 1C12 0.4 11.6 0 11 0H5C4.4 0 4 0.4 4 1V3H0V5H1V15C1 15.6 1.4 16 2 16H14C14.6 16 15 15.6 15 15V5H16V3H12V1ZM6 2H10V3H6V2ZM13 5V14H3V5H13Z\" fill=\"black\"></path>\n                </svg>\n            </button>\n        ");
      miniCart.appendChild(div);
    });

    // Mostrar mensaje si no hay productos
    if (totalItems === 0) {
      miniCart.innerHTML = '<div><small>No hay productos en el pack.</small></div>';
    }

    // Mostrar o esconder botón agregar pack según cantidad mínima
    addPackBtn.style.display = totalItems >= 2 ? 'inline-block' : 'none';

    // Mostrar el precio fijo según total seleccionado
    if (totalItems >= 2 && totalItems <= 6) {
      var price = packPrices[totalItems];
      var priceHtml = "<div class=\"pack-total-price\" style=\"margin-top:10px; font-weight:bold;\">Precio pack: S/ ".concat(price.toFixed(2), "</div>");
      if (!miniCart.querySelector('.pack-total-price')) {
        miniCart.insertAdjacentHTML('beforeend', priceHtml);
      } else {
        miniCart.querySelector('.pack-total-price').textContent = "Precio pack: S/ ".concat(price.toFixed(2));
      }
    } else {
      // Eliminar precio si cantidad fuera de rango
      var existingPrice = miniCart.querySelector('.pack-total-price');
      if (existingPrice) existingPrice.remove();
    }
  }

  // Función para mostrar mensajes de error en el mini carrito
  function showError(message) {
    if (!miniCart.contains(errorMsgDiv)) {
      miniCart.appendChild(errorMsgDiv);
    }
    errorMsgDiv.textContent = message;
  }

  // Función para limpiar mensajes de error
  function clearError() {
    if (miniCart.contains(errorMsgDiv)) {
      errorMsgDiv.textContent = '';
      miniCart.removeChild(errorMsgDiv);
    }
  }

  // Función para refrescar el mini carrito WooCommerce sin recargar la página
  function refreshCustomMiniCart() {
    fetch(jsVars.ajax_url + '?action=get_custom_mini_cart', {
      method: 'GET',
      credentials: 'same-origin'
    }).then(function (response) {
      return response.json();
    }).then(function (data) {
      if (data.success && data.data.html) {
        var cartContainer = document.querySelector('.mos__cart_temp');
        var mosCcart = document.querySelector('.mos__modal__content_ajax');
        if (cartContainer || mosCcart) {
          if (cartContainer) {
            cartContainer.innerHTML = data.data.html;
          } else if (mosCcart) {
            mosCcart.innerHTML = data.data.html;
          }
          modalCart.classList.add('active');
        }
      }
    })["catch"](function () {
      // Error silenciado intencionalmente
    });
  }
  /****************************END PACKS******************************* */
});

/***/ }),

/***/ "./src/js/components/header/index.js":
/*!*******************************************!*\
  !*** ./src/js/components/header/index.js ***!
  \*******************************************/
/***/ (function() {

var body = document.querySelector('body');
var openMenu = document.querySelector('.js-open-menu');
var menu = document.querySelector('.mos__header__nav');
var header = document.querySelector('.mos__header');
var menuItems = document.querySelectorAll('.mos__header__menu .menu-item-has-children');
function FixHeader() {
  if (window.scrollY > 0) {
    header.classList.add('active');
  } else {
    header.classList.remove('active');
  }
  setTimeout(FixHeader, 100);
}
window.addEventListener('load', function () {
  openMenu.addEventListener('click', function () {
    menu.classList.toggle('active');
    body.classList.toggle('no-scroll');
    this.classList.toggle('active');
  });
  if (body.classList.contains('home')) {
    FixHeader();
  }
  if (window.innerWidth < 770) {
    menuItems.forEach(function (item) {
      var prev = item.querySelector('.prev-menu-full');
      var subMenuFull = item.querySelector('.mos__header__menu__full');
      var button = item.querySelector('.menu-item-has-children-a');
      button.addEventListener('click', function (e) {
        e.preventDefault();
        subMenuFull.classList.add('active');
      });
      prev.addEventListener('click', function () {
        subMenuFull.classList.remove('active');
      });
    });
  }
});

/***/ }),

/***/ "./src/js/components/login/index.js":
/*!******************************************!*\
  !*** ./src/js/components/login/index.js ***!
  \******************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _helpers_ajax__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../helpers/ajax */ "./src/js/helpers/ajax.js");
/* harmony import */ var just_validate__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! just-validate */ "./node_modules/just-validate/dist/just-validate.es.js");
/* global jsVars */


window.addEventListener('load', function () {
  var form = document.getElementById('mos-form-login');
  var button = form.querySelector('#mos-form-login-btn');
  var messageResult = document.getElementById('mos-form-login-message');
  var validation = new just_validate__WEBPACK_IMPORTED_MODULE_1__["default"](form);
  var formData = new FormData();
  var urlParams = new URLSearchParams(window.location.search);
  var showLoginModal = urlParams.get('modal_login');
  var urlQuiz = urlParams.get('url_encuesta');
  if (showLoginModal === 'true') {
    // Asume que tu modal tiene el ID 'login-modal'.
    // Cambia 'login-modal' por el ID real de tu elemento modal.
    var loginModalElement = document.getElementById('mos-modal-account');
    // Asume que la clase que quieres añadir es 'show-modal'.
    // Cambia 'show-modal' por la clase CSS que controla la visibilidad de tu modal.

    if (loginModalElement) {
      loginModalElement.classList.add('active'); // Añade la clase para mostrarlo
    }
  }
  validation.addField('#email-login', [{
    rule: 'required',
    errorMessage: 'Email es requerido'
  }, {
    rule: 'email',
    errorMessage: 'Email no tiene un formato valido'
  }]).addField('#password-login', [{
    rule: 'required',
    errorMessage: 'La contraseña es requerido'
  }
  /*{
  	rule: 'password',
  	errorMessage: 'La contraseña debe contener un mínimo de ocho caracteres, al menos una letra y un número',
  },*/]).onSuccess(function () {
    button.textContent = 'CARGANDO...';
    button.disabled = true;
    formData.append('action', 'login_user');
    formData.append('user_email', form.querySelector('input[name="email-login"]').value);
    formData.append('user_password', form.querySelector('input[name="password-login"]').value);
    (0,_helpers_ajax__WEBPACK_IMPORTED_MODULE_0__["default"])({
      url: jsVars.ajax_url,
      method: 'POST',
      params: formData,
      async: true,
      done: function done(response) {
        if (response.success) {
          if (urlQuiz) {
            setTimeout(function () {
              window.location = urlQuiz;
            }, 500);
          } else {
            setTimeout(function () {
              window.location = response.data.redirect;
            }, 500);
          }
        } else {
          messageResult.innerHTML = response.data.message;
        }
      },
      error: function error(/*status*/
      ) {
        //console.error('Error al procesar la solicitud:', status);
        //alert('Error en la solicitud AJAX');
      },
      always: function always() {
        button.textContent = 'INICIAR SESIÓN';
        button.disabled = false;
        setTimeout(function () {
          messageResult.innerHTML = '';
        }, 3000);
        //console.log('La solicitud AJAX ha finalizado.');
      }
    });
  });
});

/***/ }),

/***/ "./src/js/components/marquee/index.js":
/*!********************************************!*\
  !*** ./src/js/components/marquee/index.js ***!
  \********************************************/
/***/ (function() {

var slider = document.querySelector('.mos__header__top__slider');
var slides = document.querySelectorAll('.mos__header__top__slide');
var containerWidth = document.querySelector('.mos__header__top');
var currentIndex = 1;
var totalSlides = slides.length;
function nextSlide() {
  currentIndex++;
  updateSliderPosition();
  if (currentIndex === totalSlides + 1) {
    setTimeout(function () {
      currentIndex = 1;
      updateSliderPosition(false);
    }, 500);
  }
}
function startSlider() {
  updateSliderPosition(false);
  if (totalSlides > 1) {
    setInterval(nextSlide, 5000);
  }
}
function updateSliderPosition() {
  var animate = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : true;
  var offset = -currentIndex * containerWidth.offsetWidth;
  if (!animate) {
    slider.style.transition = 'none';
  } else {
    slider.style.transition = 'transform 0.5s ease-in-out';
  }
  slider.style.transform = "translateX(".concat(offset, "px)");
}
document.addEventListener('DOMContentLoaded', function () {
  if (containerWidth) {
    var firstClone = slides[0].cloneNode(true);
    var lastClone = slides[slides.length - 1].cloneNode(true);
    slider.appendChild(firstClone);
    slider.insertBefore(lastClone, slides[0]);
    if (slides.length > 1) {
      startSlider();
    }
  }
});

/***/ }),

/***/ "./src/js/components/modal-promo/index.js":
/*!************************************************!*\
  !*** ./src/js/components/modal-promo/index.js ***!
  \************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _helpers_get_cookie__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../helpers/get-cookie */ "./src/js/helpers/get-cookie.js");
/* harmony import */ var _helpers_set_cookie__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../helpers/set-cookie */ "./src/js/helpers/set-cookie.js");


var modalPromo = document.getElementById('mos-modal-discount');
var urlParams = new URLSearchParams(window.location.search);
var showLoginModal = urlParams.get('modal_login');
window.addEventListener('load', function () {
  if (showLoginModal === 'true') {
    return;
  }
  function closeModalAndSetCookie() {
    if (modalPromo) {
      modalPromo.classList.remove('active');
      (0,_helpers_set_cookie__WEBPACK_IMPORTED_MODULE_1__["default"])('modalPromoClosed', '1', 1);
    }
  }
  if (modalPromo) {
    var close = modalPromo.querySelector('.mos__modal__close');
    var bg = modalPromo.querySelector('.mos__modal__bg');
    var btn = modalPromo.querySelector('.mos__btn');
    if (!(0,_helpers_get_cookie__WEBPACK_IMPORTED_MODULE_0__["default"])('modalPromoClosed')) {
      modalPromo.classList.add('active');
    }
    if (close) {
      close.addEventListener('click', closeModalAndSetCookie);
    }
    if (bg) {
      bg.addEventListener('click', closeModalAndSetCookie);
    }
    if (btn) {
      btn.addEventListener('click', closeModalAndSetCookie);
    }
  }
});

/***/ }),

/***/ "./src/js/components/modal/index.js":
/*!******************************************!*\
  !*** ./src/js/components/modal/index.js ***!
  \******************************************/
/***/ (function() {

function _toConsumableArray(r) { return _arrayWithoutHoles(r) || _iterableToArray(r) || _unsupportedIterableToArray(r) || _nonIterableSpread(); }
function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _unsupportedIterableToArray(r, a) { if (r) { if ("string" == typeof r) return _arrayLikeToArray(r, a); var t = {}.toString.call(r).slice(8, -1); return "Object" === t && r.constructor && (t = r.constructor.name), "Map" === t || "Set" === t ? Array.from(r) : "Arguments" === t || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t) ? _arrayLikeToArray(r, a) : void 0; } }
function _iterableToArray(r) { if ("undefined" != typeof Symbol && null != r[Symbol.iterator] || null != r["@@iterator"]) return Array.from(r); }
function _arrayWithoutHoles(r) { if (Array.isArray(r)) return _arrayLikeToArray(r); }
function _arrayLikeToArray(r, a) { (null == a || a > r.length) && (a = r.length); for (var e = 0, n = Array(a); e < a; e++) n[e] = r[e]; return n; }
var body = document.body;
var modals = document.querySelectorAll('.mos__modal');
var modalTriggers = document.querySelectorAll('.js-modal-trigger');
var closeModalButtons = document.querySelectorAll('.mos__modal__close');
var modalBackgrounds = document.querySelectorAll('.mos__modal__bg'); // Seleccionamos los fondos

function openModal(event) {
  event.preventDefault();
  var modalId = event.currentTarget.getAttribute('data-modal-target');
  var modal = document.getElementById(modalId);
  if (modal) {
    modals.forEach(function (m) {
      if (m !== modal) {
        m.classList.remove('active');
      }
    });
    modal.classList.add('active');
    body.classList.add('no-scroll');
  }
}
function closeModals(event) {
  event.preventDefault();
  modals.forEach(function (modal) {
    return modal.classList.remove('active');
  });
  body.classList.remove('no-scroll');
}
window.addEventListener('load', function () {
  modalTriggers.forEach(function (trigger) {
    trigger.addEventListener('click', openModal);
  });
  [].concat(_toConsumableArray(closeModalButtons), _toConsumableArray(modalBackgrounds)).forEach(function (element) {
    element.addEventListener('click', closeModals);
  });
});

/***/ }),

/***/ "./src/js/components/newsletter/index.js":
/*!***********************************************!*\
  !*** ./src/js/components/newsletter/index.js ***!
  \***********************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _helpers_ajax__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../helpers/ajax */ "./src/js/helpers/ajax.js");
/* harmony import */ var just_validate__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! just-validate */ "./node_modules/just-validate/dist/just-validate.es.js");
/* global jsVars */


window.addEventListener('load', function () {
  var form = document.getElementById('mos-form-newsletter');
  var button = form.querySelector('#mos-form-newsletter-btn');
  var messageResult = document.getElementById('mos-form-newsletter-message');
  var validation = new just_validate__WEBPACK_IMPORTED_MODULE_1__["default"](form);
  var formData = new FormData();
  validation.addField('#email-newsletter', [{
    rule: 'required',
    errorMessage: 'Email es requerido'
  }, {
    rule: 'email',
    errorMessage: 'Email no tiene un formato valido'
  }]).onSuccess(function () {
    button.textContent = 'CARGANDO...';
    formData.append('action', 'mos_newsletter');
    formData.append('user_email', form.querySelector('input[name="email-newsletter"]').value);
    (0,_helpers_ajax__WEBPACK_IMPORTED_MODULE_0__["default"])({
      url: jsVars.ajax_url,
      method: 'POST',
      params: formData,
      async: true,
      done: function done(response) {
        if (response.success) {
          messageResult.innerHTML = response.data.message;
        } else {
          messageResult.innerHTML = response.data.error;
        }
      },
      error: function error(/*status*/
      ) {
        //console.error('Error al procesar la solicitud:', status);
        //alert('Error en la solicitud AJAX');
      },
      always: function always() {
        button.textContent = 'SUSCRIBIRSE';
        form.querySelector('input[name="email-newsletter"]').value = '';
        setTimeout(function () {
          messageResult.innerHTML = '';
        }, 3000);
        //console.log('La solicitud AJAX ha finalizado.');
      }
    });
  });
});

/***/ }),

/***/ "./src/js/components/password/index.js":
/*!*********************************************!*\
  !*** ./src/js/components/password/index.js ***!
  \*********************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _helpers_ajax__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../helpers/ajax */ "./src/js/helpers/ajax.js");
/* harmony import */ var just_validate__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! just-validate */ "./node_modules/just-validate/dist/just-validate.es.js");
/* global jsVars */


window.addEventListener('load', function () {
  var form = document.getElementById('mos-form-password');
  var button = form.querySelector('#mos-form-password-btn');
  var messageResult = document.getElementById('mos-form-password-message');
  var validation = new just_validate__WEBPACK_IMPORTED_MODULE_1__["default"](form);
  var formData = new FormData();
  validation.addField('#email-password', [{
    rule: 'required',
    errorMessage: 'Email es requerido'
  }, {
    rule: 'email',
    errorMessage: 'Email no tiene un formato valido'
  }]).onSuccess(function () {
    button.textContent = 'CARGANDO...';
    button.disabled = true;
    messageResult.innerHTML = '';
    formData.append('action', 'login_password');
    formData.append('user_email', form.querySelector('input[name="email-password"]').value);
    (0,_helpers_ajax__WEBPACK_IMPORTED_MODULE_0__["default"])({
      url: jsVars.ajax_url,
      method: 'POST',
      params: formData,
      async: true,
      done: function done(response) {
        messageResult.innerHTML = response.data.message;
      },
      error: function error(/*status*/
      ) {
        //console.error('Error al procesar la solicitud:', status);
        //alert('Error en la solicitud AJAX');
      },
      always: function always() {
        button.textContent = 'Obtener una contraseña nueva';
        button.disabled = false;
        //console.log('La solicitud AJAX ha finalizado.');
      }
    });
  });
  var passwordFields = document.querySelectorAll('input[type="password"]');
  if (passwordFields) {
    passwordFields.forEach(function (field) {
      var wrapper = document.createElement('div');
      wrapper.classList.add('password-wrapper');
      field.parentNode.insertBefore(wrapper, field);
      wrapper.appendChild(field);
      var toggleBtn = document.createElement('button');
      toggleBtn.type = 'button';
      toggleBtn.classList.add('toggle-password');
      toggleBtn.innerHTML = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512"><g id="icomoon-ignore"></g><path fill="#000" d="M256 96c-111.659 0-208.441 65.021-256 160 47.559 94.979 144.341 160 256 160 111.656 0 208.438-65.021 256-160-47.558-94.979-144.344-160-256-160zM382.225 180.852c30.081 19.187 55.571 44.887 74.717 75.148-19.146 30.261-44.637 55.961-74.718 75.148-37.797 24.109-81.445 36.852-126.224 36.852-44.78 0-88.429-12.743-126.226-36.852-30.079-19.186-55.569-44.886-74.716-75.148 19.146-30.262 44.637-55.962 74.717-75.148 1.959-1.25 3.938-2.461 5.93-3.65-4.98 13.664-7.705 28.411-7.705 43.798 0 70.691 57.308 128 128 128s128-57.309 128-128c0-15.387-2.726-30.134-7.704-43.799 1.989 1.189 3.969 2.401 5.929 3.651v0zM256 208c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.491 48 48z"></path></svg>';
      toggleBtn.addEventListener('click', function () {
        var isVisible = field.type === 'text';
        field.type = isVisible ? 'password' : 'text';
        toggleBtn.innerHTML = isVisible ? '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512"><g id="icomoon-ignore"></g><path fill="#000" d="M256 96c-111.659 0-208.441 65.021-256 160 47.559 94.979 144.341 160 256 160 111.656 0 208.438-65.021 256-160-47.558-94.979-144.344-160-256-160zM382.225 180.852c30.081 19.187 55.571 44.887 74.717 75.148-19.146 30.261-44.637 55.961-74.718 75.148-37.797 24.109-81.445 36.852-126.224 36.852-44.78 0-88.429-12.743-126.226-36.852-30.079-19.186-55.569-44.886-74.716-75.148 19.146-30.262 44.637-55.962 74.717-75.148 1.959-1.25 3.938-2.461 5.93-3.65-4.98 13.664-7.705 28.411-7.705 43.798 0 70.691 57.308 128 128 128s128-57.309 128-128c0-15.387-2.726-30.134-7.704-43.799 1.989 1.189 3.969 2.401 5.929 3.651v0zM256 208c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.491 48 48z"></path></svg>' : '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512"><g id="icomoon-ignore"></g><path fill="#000" d="M472.971 7.029c-9.373-9.372-24.568-9.372-33.941 0l-101.082 101.082c-25.969-7.877-53.474-12.111-81.948-12.111-111.659 0-208.441 65.021-256 160 20.561 41.062 50.324 76.52 86.511 103.548l-79.481 79.481c-9.373 9.373-9.373 24.568 0 33.941 4.686 4.687 10.828 7.030 16.97 7.030s12.284-2.343 16.971-7.029l432-432c9.372-9.373 9.372-24.569 0-33.942zM208 160c21.12 0 39.041 13.647 45.46 32.598l-60.862 60.862c-18.951-6.419-32.598-24.34-32.598-45.46 0-26.51 21.49-48 48-48zM55.058 256c19.146-30.262 44.637-55.962 74.717-75.148 1.959-1.25 3.938-2.461 5.931-3.65-4.981 13.664-7.706 28.411-7.706 43.798 0 27.445 8.643 52.869 23.35 73.709l-30.462 30.462c-26.223-18.421-48.601-41.941-65.83-69.171z"></path><path fill="#000" d="M384 221c0-13.583-2.128-26.667-6.051-38.949l-160.904 160.904c12.284 3.921 25.371 6.045 38.955 6.045 70.691 0 128-57.309 128-128z"></path><path fill="#000" d="M415.013 144.987l-34.681 34.681c0.632 0.393 1.265 0.784 1.893 1.184 30.081 19.187 55.571 44.887 74.717 75.148-19.146 30.261-44.637 55.961-74.718 75.148-37.797 24.109-81.445 36.852-126.224 36.852-19.332 0-38.451-2.38-56.981-7.020l-38.447 38.447c29.859 10.731 61.975 16.573 95.428 16.573 111.655 0 208.438-65.021 256-160-22.511-44.958-56.059-83.198-96.987-111.013z"></path></svg>';
      });
      wrapper.appendChild(toggleBtn);
    });
  }
});

/***/ }),

/***/ "./src/js/components/register/index.js":
/*!*********************************************!*\
  !*** ./src/js/components/register/index.js ***!
  \*********************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _helpers_ajax__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../helpers/ajax */ "./src/js/helpers/ajax.js");
/* harmony import */ var just_validate__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! just-validate */ "./node_modules/just-validate/dist/just-validate.es.js");
/* global jsVars */


window.addEventListener('load', function () {
  var form = document.getElementById('mos-form-register');
  var button = form.querySelector('#mos-form-create-btn');
  var messageResult = document.getElementById('mos-form-create-message');
  var validation = new just_validate__WEBPACK_IMPORTED_MODULE_1__["default"](form);
  var formData = new FormData();
  var urlParams = new URLSearchParams(window.location.search);
  var showRegisterModal = urlParams.get('modal_register');
  var showAccountModal = urlParams.get('modal_account');
  var urlQuiz = urlParams.get('url_encuesta');
  var urlAccount = urlParams.get('url_account');
  if (showRegisterModal === 'true') {
    // Asume que tu modal tiene el ID 'login-modal'.
    // Cambia 'login-modal' por el ID real de tu elemento modal.
    var registerModalElement = document.getElementById('mos-modal-account-create');
    // Asume que la clase que quieres añadir es 'show-modal'.
    // Cambia 'show-modal' por la clase CSS que controla la visibilidad de tu modal.

    if (registerModalElement) {
      registerModalElement.classList.add('active'); // Añade la clase para mostrarlo
    }
  }
  if (showAccountModal === 'true') {
    var accountModalElement = document.getElementById('mos-modal-account');
    if (accountModalElement) {
      accountModalElement.classList.add('active'); // Añade la clase para mostrarlo
    }
  }
  validation
  /*.addField('#nickname-create', [
  	{
  		rule: 'required',
  		errorMessage: 'Nombre de usuario es requerido',
  	},
  ])*/.addField('#name-create', [{
    rule: 'required',
    errorMessage: 'Nombre es requerido'
  }]).addField('#lastname-create', [{
    rule: 'required',
    errorMessage: 'Apellido es requerido'
  }]).addField('#email-create', [{
    rule: 'required',
    errorMessage: 'Email es requerido'
  }, {
    rule: 'email',
    errorMessage: 'Email no tiene un formato valido'
  }]).addField('#password-create', [{
    rule: 'required',
    errorMessage: 'La contraseña es requerido'
  }, {
    rule: 'password',
    errorMessage: 'La contraseña debe contener un mínimo de ocho caracteres, al menos una letra y un número'
  }]).addField('#genero-create', [{
    rule: 'required',
    errorMessage: 'Género es requerido'
  }]).addField('#term-cond-create', [{
    rule: 'required',
    errorMessage: 'Términos y condiciones es requerido'
  }]).onSuccess(function () {
    var name = form.querySelector('input[name="name-create"]').value;
    var lastName = form.querySelector('input[name="lastname-create"]').value;
    var nickName = form.querySelector('input[name="nickname-create"]');
    var valueCombined = name + lastName;
    var valueClean = valueCombined.replace(/[^a-zA-Z0-9]/g, '');
    nickName.value = valueClean;
    button.textContent = 'CARGANDO...';
    button.disabled = true;
    formData.append('action', 'register_user');
    formData.append('user_nickname_register', nickName.value);
    formData.append('user_name_register', name);
    formData.append('user_lastname_register', lastName);
    formData.append('user_email_register', form.querySelector('input[name="email-create"]').value);
    formData.append('user_password_register', form.querySelector('input[name="password-create"]').value);
    formData.append('user_subscribe_register', form.querySelector('input[name="subscribe-create"]').checked);
    formData.append('user_genero_register', form.querySelector('select[name="genero-create"]').value);
    (0,_helpers_ajax__WEBPACK_IMPORTED_MODULE_0__["default"])({
      url: jsVars.ajax_url,
      method: 'POST',
      params: formData,
      async: true,
      done: function done(response) {
        if (response.success) {
          if (urlQuiz) {
            setTimeout(function () {
              window.location = urlQuiz;
            }, 500);
          } else {
            setTimeout(function () {
              window.location = response.data.redirect;
            }, 500);
          }
          if (urlAccount) {
            setTimeout(function () {
              window.location = urlAccount;
            }, 500);
          } else {
            setTimeout(function () {
              window.location = response.data.redirect;
            }, 500);
          }
        } else {
          messageResult.innerHTML = response.data.error;
        }
      },
      error: function error() {
        //console.error('Error al procesar la solicitud:', status);
        //alert('Error en la solicitud AJAX');
      },
      always: function always() {
        button.textContent = 'INICIAR SESIÓN';
        button.disabled = false;
        setTimeout(function () {
          messageResult.innerHTML = '';
        }, 3000);
        //console.log('La solicitud AJAX ha finalizado.');
      }
    });
  });
});

/***/ }),

/***/ "./src/js/components/search-product/index.js":
/*!***************************************************!*\
  !*** ./src/js/components/search-product/index.js ***!
  \***************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _helpers_ajax__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../helpers/ajax */ "./src/js/helpers/ajax.js");
/* global jsVars */

var search = document.getElementById('mos-search');
var searchResult = document.getElementById('mos-result-search-products');
var searchTitle = document.querySelector('.title-search');
var loadMoreBtn = document.getElementById('mos-load-search');
var currentPage = 1;
var currentSearch = '';
var temporizadorDebounce;
function realizarBusqueda(texto) {
  var page = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 1;
  var append = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;
  var formData = new FormData();
  loadMoreBtn.innerHTML = 'CARGANDO...';
  formData.append('action', 'search_product');
  formData.append('search', texto);
  formData.append('nonce', jsVars.nonce);
  formData.append('page', page);
  (0,_helpers_ajax__WEBPACK_IMPORTED_MODULE_0__["default"])({
    url: jsVars.ajax_url,
    method: 'POST',
    params: formData,
    async: true,
    done: function done(response) {
      if (response && response.status && response.html) {
        if (append) {
          searchResult.innerHTML += response.html;
        } else {
          searchResult.innerHTML = response.html;
          searchTitle.innerHTML = 'Resultado de búsqueda: ' + texto;
        }
        if (response.has_more) {
          loadMoreBtn.style.display = 'block';
        } else {
          loadMoreBtn.style.display = 'none';
        }
      } else {
        if (!append) {
          searchResult.innerHTML = '<p style="position:absolute;top:0;right:0;left:0;text-align:center;margin:30px 0 0;">No se encontraron productos.</p>';
          searchTitle.innerHTML = 'Resultado de búsqueda: ' + texto;
        }
        loadMoreBtn.style.display = 'none';
      }
    },
    error: function error(/*error*/
    ) {
      //console.log(error,"error");
    },
    always: function always() {
      loadMoreBtn.innerHTML = 'MOSTRAR MÁS';
    }
  });
}
search.addEventListener('input', function () {
  var text = search.value.trim();
  if (text.length < 3) {
    return;
  }
  clearTimeout(temporizadorDebounce);
  temporizadorDebounce = setTimeout(function () {
    currentSearch = text;
    currentPage = 1;
    realizarBusqueda(currentSearch, currentPage);
  }, 500);
});
loadMoreBtn.addEventListener('click', function () {
  currentPage++;
  realizarBusqueda(currentSearch, currentPage, true);
});

/***/ }),

/***/ "./src/js/components/tabs/index.js":
/*!*****************************************!*\
  !*** ./src/js/components/tabs/index.js ***!
  \*****************************************/
/***/ (function() {

var tabs = document.querySelector('.mos__tab');
var tabButton = document.querySelectorAll('.mos__tab__li');
var contents = document.querySelectorAll('.mos__tab__content');
window.addEventListener('load', function () {
  if (typeof tabs != 'undefined' && tabs != null) {
    var currentHash = window.location.hash.substring(1);
    if (currentHash) {
      var targetTab = document.querySelector(".mos__tab__li[data-id=\"".concat(currentHash, "\"]"));
      var targetContent = document.getElementById(currentHash);
      if (targetTab && targetContent) {
        tabButton.forEach(function (btn) {
          return btn.classList.remove('active');
        });
        contents.forEach(function (content) {
          return content.classList.remove('active');
        });
        targetTab.classList.add('active');
        targetContent.classList.add('active');
      }
    }
    tabs.addEventListener('click', function (e) {
      var id = e.target.dataset.id;
      if (id) {
        tabButton.forEach(function (btn) {
          return btn.classList.remove('active');
        });
        e.target.classList.add('active');
        contents.forEach(function (content) {
          return content.classList.remove('active');
        });
        var element = document.getElementById(id);
        element.classList.add('active');
        history.replaceState(null, null, "#".concat(id));
      }
    });
  }

  //tabl MSC
  var table = document.querySelector('.mos__container .items table');
  if (!table) return;
  var itemWrapper = table.closest('.item');
  var itemsContainer = itemWrapper === null || itemWrapper === void 0 ? void 0 : itemWrapper.parentNode;
  if (!itemWrapper || !itemsContainer) return;
  var newContainer = document.createElement('div');
  newContainer.classList.add('benefits-container-generate');
  var theadTh = table.querySelector('thead th.tableHeader');
  var thWidth = 0;
  var thHeight = 0;
  if (theadTh) {
    var rect = theadTh.getBoundingClientRect();
    thWidth = rect.width;
    thHeight = rect.height;
    var titleDiv = document.createElement('div');
    titleDiv.classList.add('benefit-heading');
    titleDiv.innerHTML = theadTh.innerHTML;
    titleDiv.style.width = "".concat(thWidth, "px");
    titleDiv.style.height = "".concat(thHeight, "px");
    newContainer.appendChild(titleDiv);
  }
  var rows = table.querySelectorAll('tbody tr');
  rows.forEach(function (row) {
    var benefitCell = row.querySelector('th, th');
    if (benefitCell) {
      var _rect = benefitCell.getBoundingClientRect();
      var benefitDiv = document.createElement('div');
      benefitDiv.classList.add('benefit-item');
      benefitDiv.textContent = benefitCell.textContent.trim();
      benefitDiv.style.width = "".concat(thWidth, "px");
      benefitDiv.style.height = "".concat(_rect.height, "px");
      newContainer.appendChild(benefitDiv);
    }
  });
  itemsContainer.insertBefore(newContainer, itemWrapper);
  itemsContainer.classList.add('benefits-container-generate-wrap');
});

/***/ }),

/***/ "./src/js/helpers/ajax.js":
/*!********************************!*\
  !*** ./src/js/helpers/ajax.js ***!
  \********************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
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

/***/ "./src/js/helpers/get-cookie.js":
/*!**************************************!*\
  !*** ./src/js/helpers/get-cookie.js ***!
  \**************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ getCookie; }
/* harmony export */ });
function getCookie(name) {
  var value = "; ".concat(document.cookie);
  var parts = value.split("; ".concat(name, "="));
  if (parts.length === 2) return parts.pop().split(';').shift();
}

/***/ }),

/***/ "./src/js/helpers/on.js":
/*!******************************!*\
  !*** ./src/js/helpers/on.js ***!
  \******************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
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

/***/ "./src/js/helpers/set-cookie.js":
/*!**************************************!*\
  !*** ./src/js/helpers/set-cookie.js ***!
  \**************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ setCookie; }
/* harmony export */ });
function setCookie(name, value, days) {
  var date = new Date();
  date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
  document.cookie = "".concat(name, "=").concat(value, "; expires=").concat(date.toUTCString(), "; path=/");
}

/***/ }),

/***/ "./src/js/script.js":
/*!**************************!*\
  !*** ./src/js/script.js ***!
  \**************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _components_marquee__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./components/marquee */ "./src/js/components/marquee/index.js");
/* harmony import */ var _components_marquee__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_components_marquee__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _components_header__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./components/header */ "./src/js/components/header/index.js");
/* harmony import */ var _components_header__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_components_header__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _components_search_product__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./components/search-product */ "./src/js/components/search-product/index.js");
/* harmony import */ var _components_add_to_cart__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./components/add-to-cart */ "./src/js/components/add-to-cart/index.js");
/* harmony import */ var _components_modal__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./components/modal */ "./src/js/components/modal/index.js");
/* harmony import */ var _components_modal__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_components_modal__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _components_login__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./components/login */ "./src/js/components/login/index.js");
/* harmony import */ var _components_register__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./components/register */ "./src/js/components/register/index.js");
/* harmony import */ var _components_password__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./components/password */ "./src/js/components/password/index.js");
/* harmony import */ var _components_newsletter__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./components/newsletter */ "./src/js/components/newsletter/index.js");
/* harmony import */ var _components_tabs__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ./components/tabs */ "./src/js/components/tabs/index.js");
/* harmony import */ var _components_tabs__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(_components_tabs__WEBPACK_IMPORTED_MODULE_9__);
/* harmony import */ var _components_modal_promo__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ./components/modal-promo */ "./src/js/components/modal-promo/index.js");




//import './components/wishlist';








/***/ }),

/***/ "./src/scss/blocks/banner-principal.scss":
/*!***********************************************!*\
  !*** ./src/scss/blocks/banner-principal.scss ***!
  \***********************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./src/scss/blocks/complaints-book.scss":
/*!**********************************************!*\
  !*** ./src/scss/blocks/complaints-book.scss ***!
  \**********************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./src/scss/blocks/info-accordion.scss":
/*!*********************************************!*\
  !*** ./src/scss/blocks/info-accordion.scss ***!
  \*********************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./src/scss/blocks/latest-products.scss":
/*!**********************************************!*\
  !*** ./src/scss/blocks/latest-products.scss ***!
  \**********************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./src/scss/blocks/msc-banner.scss":
/*!*****************************************!*\
  !*** ./src/scss/blocks/msc-banner.scss ***!
  \*****************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./src/scss/blocks/msc-benefits.scss":
/*!*******************************************!*\
  !*** ./src/scss/blocks/msc-benefits.scss ***!
  \*******************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./src/scss/blocks/msc-interesting.scss":
/*!**********************************************!*\
  !*** ./src/scss/blocks/msc-interesting.scss ***!
  \**********************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./src/scss/blocks/msc-points.scss":
/*!*****************************************!*\
  !*** ./src/scss/blocks/msc-points.scss ***!
  \*****************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./src/scss/blocks/msc-steps.scss":
/*!****************************************!*\
  !*** ./src/scss/blocks/msc-steps.scss ***!
  \****************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./src/scss/blocks/promotion.scss":
/*!****************************************!*\
  !*** ./src/scss/blocks/promotion.scss ***!
  \****************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./src/scss/blocks/quiz.scss":
/*!***********************************!*\
  !*** ./src/scss/blocks/quiz.scss ***!
  \***********************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./src/scss/blocks/sale.scss":
/*!***********************************!*\
  !*** ./src/scss/blocks/sale.scss ***!
  \***********************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./src/scss/blocks/subscribe.scss":
/*!****************************************!*\
  !*** ./src/scss/blocks/subscribe.scss ***!
  \****************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./src/scss/blocks/unsubscribe.scss":
/*!******************************************!*\
  !*** ./src/scss/blocks/unsubscribe.scss ***!
  \******************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./src/scss/style.scss":
/*!*****************************!*\
  !*** ./src/scss/style.scss ***!
  \*****************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./src/scss/templates/single-product.scss":
/*!************************************************!*\
  !*** ./src/scss/templates/single-product.scss ***!
  \************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./src/scss/templates/template-checkout.scss":
/*!***************************************************!*\
  !*** ./src/scss/templates/template-checkout.scss ***!
  \***************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./src/scss/templates/template-mosqueira-social-club.scss":
/*!****************************************************************!*\
  !*** ./src/scss/templates/template-mosqueira-social-club.scss ***!
  \****************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./src/scss/templates/template-pedidos.scss":
/*!**************************************************!*\
  !*** ./src/scss/templates/template-pedidos.scss ***!
  \**************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./src/scss/templates/template-perfil.scss":
/*!*************************************************!*\
  !*** ./src/scss/templates/template-perfil.scss ***!
  \*************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./src/scss/templates/template-reset-password.scss":
/*!*********************************************************!*\
  !*** ./src/scss/templates/template-reset-password.scss ***!
  \*********************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./src/scss/templates/template-store.scss":
/*!************************************************!*\
  !*** ./src/scss/templates/template-store.scss ***!
  \************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

},
/******/ function(__webpack_require__) { // webpackRuntimeModules
/******/ var __webpack_exec__ = function(moduleId) { return __webpack_require__(__webpack_require__.s = moduleId); }
/******/ __webpack_require__.O(0, ["css/latest-products","css/info-accordion","css/complaints-book","css/banner-principal","css/style","css/template-store","css/template-reset-password","css/template-perfil","css/template-pedidos","css/template-mosqueira-social-club","css/template-checkout","css/single-product","css/unsubscribe","css/subscribe","css/sale","css/quiz","css/promotion","css/msc-steps","css/msc-points","css/msc-interesting","css/msc-benefits","css/msc-banner","/js/vendor"], function() { return __webpack_exec__("./src/js/script.js"), __webpack_exec__("./src/scss/style.scss"), __webpack_exec__("./src/scss/blocks/banner-principal.scss"), __webpack_exec__("./src/scss/blocks/complaints-book.scss"), __webpack_exec__("./src/scss/blocks/info-accordion.scss"), __webpack_exec__("./src/scss/blocks/latest-products.scss"), __webpack_exec__("./src/scss/blocks/msc-banner.scss"), __webpack_exec__("./src/scss/blocks/msc-benefits.scss"), __webpack_exec__("./src/scss/blocks/msc-interesting.scss"), __webpack_exec__("./src/scss/blocks/msc-points.scss"), __webpack_exec__("./src/scss/blocks/msc-steps.scss"), __webpack_exec__("./src/scss/blocks/promotion.scss"), __webpack_exec__("./src/scss/blocks/quiz.scss"), __webpack_exec__("./src/scss/blocks/sale.scss"), __webpack_exec__("./src/scss/blocks/subscribe.scss"), __webpack_exec__("./src/scss/blocks/unsubscribe.scss"), __webpack_exec__("./src/scss/templates/single-product.scss"), __webpack_exec__("./src/scss/templates/template-checkout.scss"), __webpack_exec__("./src/scss/templates/template-mosqueira-social-club.scss"), __webpack_exec__("./src/scss/templates/template-pedidos.scss"), __webpack_exec__("./src/scss/templates/template-perfil.scss"), __webpack_exec__("./src/scss/templates/template-reset-password.scss"), __webpack_exec__("./src/scss/templates/template-store.scss"); });
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=script.js.map
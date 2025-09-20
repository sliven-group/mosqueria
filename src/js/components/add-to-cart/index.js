/* global jsVars */
import ajax from '../../helpers/ajax';
import on from '../../helpers/on';

window.addEventListener('load', function () {
	const resultCart = document.getElementById('mos-carrito-result');
	const countCart = document.querySelector('.cart-count');
	const body = document.body;
	const modalCart = document.getElementById('mos-modal-carrito');
	const btnCouponCode = document.getElementById('apply_coupon_btn');
	const subTotal = document.querySelector('.cart-sub-total');
	const total = document.querySelector('.cart-total');
	const popupSubTotal = document.querySelector('.pop-cart-subtotal');
	const popupTotal = document.querySelector('.pop-cart-total');
	const popupDesc = document.querySelector('.pop-cart-desc');
	const messageResult = document.getElementById('message-product-single');
	const modalCombine = document.getElementById('mos-modal-combine');
	const datacuponcustomServer = document.querySelectorAll('.data-cupon-custom-server');
	const datacuponcustomTemp = document.querySelectorAll('.data-cupon-custom-temp');
	const cartFeesPriceQuantity = document.querySelector('.cart-fees-price');

	if (datacuponcustomServer.length > 0) {
		datacuponcustomTemp.forEach(element => {
			element.remove(); 
		});
	}
	function quantityAjax(newKey, newVal) {
		let formData = new FormData();
		const loadingCart = document.querySelector('.mos__cart__loading');

		formData.append('action', 'set_cart_item_quantity');
		formData.append('key', newKey);
		formData.append('quantity', newVal);

		if (loadingCart) {
			loadingCart.classList.add('active');
		}
		ajax({
			url: jsVars.ajax_url,
			method: 'POST',
			params: formData,
			async: true,
			done: function (response) {
				
				if (response.success) {
					if (resultCart) {
						resultCart.innerHTML = response?.data?.mini_cart;
					}
					if (countCart) {
						countCart.innerHTML = response?.data?.cart_count;
					}
					if (subTotal) {
						subTotal.innerHTML = response?.data?.subtotal;
					}
					if (total) {
						total.innerHTML = response?.data?.total;
					}
					if(cartFeesPriceQuantity){
						cartFeesPriceQuantity.innerHTML = '-'+response?.data?.discount_total;
					}
				}
			},
			error: function (/*error*/) {
				//console.info(error);
			},
			always: function () {
				loadingCart.classList.remove('active');
			},
		});
	}

	on(document, 'click', '.remove-coupon-btn', function () {
		const li = this.closest('li');
		const couponCode = li.getAttribute('data-coupon');
		const subTotal = document.querySelector('.cart-sub-total');
		const total = document.querySelector('.cart-total');
		const desc = document.querySelector('.cart-desc');
		const datacuponcustom = document.querySelectorAll('.data-cupon-custom');
		const data = new FormData();

		data.append('action', 'remove_coupon_ajax');
		data.append('coupon_code', couponCode);

		if (datacuponcustomServer.length > 0) {
			datacuponcustomTemp.forEach(element => {
				element.remove();
			});
		}

		ajax({
			url: jsVars.ajax_url,
			method: 'POST',
			params: data,
			async: true,
			done: function (response) {
				if (response.success) {
					desc.innerHTML = `<div class="ds-flex justify-space-between"><span>Descuento</span><span><strong>-${response.data.discount}</strong></span></div><br>`;
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

					datacuponcustom.forEach(element => {
						element.classList.add('ds-none');
					});
				}
			},
			error: function (/*error*/) {
				//console.info(error);
			},
			always: function () {},
		});
	});

	on(document, 'click', '#apply_coupon_btn', function () {
		const messageCoupon = document.getElementById('promo_code_message');
		const subTotal = document.querySelector('.cart-sub-total');
		const total = document.querySelector('.cart-total');
		const desc = document.querySelector('.cart-desc');
		const datacuponcustom = document.querySelectorAll('.data-cupon-custom');
		const couponContent = document.querySelector('.cart-coupons');
		const couponCode = document.getElementById('promo_code').value;

		if (datacuponcustomServer.length > 0) {
			datacuponcustomTemp.forEach(element => {
				element.remove();
			});
		}

		if (!couponCode) return;

		const data = new FormData();

		messageCoupon.innerHTML = '';
		btnCouponCode.style.pointerEvents = 'none';

		data.append('action', 'apply_coupon_ajax');
		data.append('coupon_code', couponCode);

		ajax({
			url: jsVars.ajax_url,
			method: 'POST',
			params: data,
			async: true,
			done: function (response) {
				
				if (response.success) {
					desc.innerHTML = `<div class="ds-flex justify-space-between"><span>Descuento</span><span><strong>-${response.data.discount}</strong></span></div><br>`;
					subTotal.innerHTML = response.data.subtotal;
					total.innerHTML = response.data.total;

					popupSubTotal.innerHTML = response.data.subtotal;
					popupTotal.innerHTML = response.data.total;

					setTimeout(function () {
						popupDesc.innerHTML = `-${response.data.discount}`;
					}, 1000);

					let html = '';

					if (response.data.coupons.length > 0) {
						html += '<ul>';
						response.data.coupons.forEach((coupon) => {
							html += `
								<li class="ds-flex align-center justify-space-between" data-coupon="${coupon.code}">
									<span>
										<strong>${coupon.code}</strong>
										- Descuento: ${coupon.amount}
									</span>
									<button type="button" class="remove-coupon-btn">
										<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M7 7H5V13H7V7Z" fill="black"></path>
											<path d="M11 7H9V13H11V7Z" fill="black"></path>
											<path d="M12 1C12 0.4 11.6 0 11 0H5C4.4 0 4 0.4 4 1V3H0V5H1V15C1 15.6 1.4 16 2 16H14C14.6 16 15 15.6 15 15V5H16V3H12V1ZM6 2H10V3H6V2ZM13 5V14H3V5H13Z" fill="black"></path>
										</svg>
									</button>
								</li>
							`;
						});
						html += '</ul>';
					}

					couponContent.innerHTML = html;				
					datacuponcustom.forEach(element => {
						element.classList.remove('ds-none');
					});											
				} else {
					messageCoupon.innerHTML = `<span>${response.data}</span>`;
					datacuponcustom.forEach(element => {
						element.classList.add('ds-none');
					});			

				}
			},
			error: function (/*error*/) {
				//console.info(error);
			},
			always: function () {
				btnCouponCode.style.pointerEvents = 'auto';
			},
		});
	});

	on(document, 'click', '.js-btn-quantity', function () {
		const input = this.parentNode.querySelector('.quantity');
		const quantity = input.value;

		const key = input.getAttribute('name');
		let newVal;

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

	on(document, 'click', '.js-add-cart', function () {
		const button = this;
		const product_id = this.dataset.id;
		const formData = new FormData();
		let quantity = this.closest('.js-cart-product').querySelector('.product-quantity') || 1;
		const color = this.closest('.js-cart-product').querySelector('select[name="attribute_pa_color"]');
		const talla = this.closest('.js-cart-product').querySelector('select[name="attribute_pa_talla"]');
		let variation_id = 0;

		const variation = {};

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

			setTimeout(() => {
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

		ajax({
			url: jsVars.ajax_url,
			method: 'POST',
			params: formData,
			async: true,
			done: function (response) {
				if (response.success) {
					if (resultCart) {
						resultCart.innerHTML = response?.data?.mini_cart;
					}
					if (countCart) {
						countCart.innerHTML = response?.data?.cart_count;
					}
					if (modalCart) {
						if (response?.data?.cart_count < 1) {
							modalCart.classList.add('cart-empty');
						} else {
							modalCart.classList.remove('cart-empty');
							countCart.classList.remove('hidden');
						}
						setTimeout(() => {
							modalCart.classList.add('active');
							body.classList.add('no-scroll');
						}, 600);
					}
				} else {
					if (messageResult) {
						messageResult.innerHTML = `<p style="text-align:center; color:red; margin: 20px 0 0;">${response?.data?.message}</p>`;
					}
				}
			},
			error: function () {
				//console.error('Error al procesar la solicitud:', status);
				//alert('Error en la solicitud AJAX');
			},
			always: function () {
				//console.log('La solicitud AJAX ha finalizado.');
				button.innerHTML = 'AGREGAR AL CARRITO';
				button.style.pointerEvents = 'auto';
				if (messageResult) {
					setTimeout(() => {
						messageResult.innerHTML = '';
					}, 3000);
				}
			},
		});
	});

	on(document, 'click', '.js-quick-purchase', function () {
		const product_id = this.closest('.js-cart-product').getAttribute('data-product-id');
		const attr_talla = this.getAttribute('data-talla');
		const quantity = 1;
		const variation = {};
		let variation_id = this.getAttribute('data-id') || 0;
		const formData = new FormData();

		variation['attribute_pa_talla'] = attr_talla;

		formData.append('action', 'add_product_to_quick_purchase');
		formData.append('product_id', product_id);
		formData.append('quantity', quantity);
		formData.append('variation', JSON.stringify(variation));
		formData.append('variation_id', variation_id);

		ajax({
			url: jsVars.ajax_url,
			method: 'POST',
			params: formData,
			async: true,
			done: function (response) {
				if (response.success) {
					if (body.classList.contains('single-product')) {
						modalCombine.classList.remove('active');
					}
					if (resultCart) {
						resultCart.innerHTML = response?.data?.mini_cart;
					}
					if (countCart) {
						countCart.innerHTML = response?.data?.cart_count;
					}
					if (modalCart) {
						if (response?.data?.cart_count < 1) {
							modalCart.classList.add('cart-empty');
						} else {
							modalCart.classList.remove('cart-empty');
							countCart.classList.remove('hidden');
						}
						setTimeout(() => {
							modalCart.classList.add('active');
							body.classList.add('no-scroll');
						}, 600);
					}
				} else {
					alert(response?.data?.message);
				}
			},
			error: function () {
				//console.error('Error al procesar la solicitud:', status);
				//alert('Error en la solicitud AJAX');
			},
			always: function () {
				//console.log('La solicitud AJAX ha finalizado.');
			},
		});
	});

	on(document, 'click', '.delete-cart-product', function () {
		const _this = this;
		const product_key = this.dataset.key;
		const formData = new FormData();

		formData.append('action', 'delete_product_to_cart');
		formData.append('key', product_key);

		if (datacuponcustomServer.length > 0) {
			datacuponcustomTemp.forEach(element => {
				element.remove();
			});
		}

		ajax({
			url: jsVars.ajax_url,
			method: 'POST',
			params: formData,
			async: true,
			done: function (response) {
				if (response.success) {
					// Actualizar mini carrito y contador
					resultCart.innerHTML = response.data.mini_cart;
					countCart.innerHTML = response.data.cart_count;

					// Actualizar subtotal
					const subTotal = document.querySelector('.cart-sub-total');

					if (subTotal) {
						subTotal.innerHTML = response.data.subtotal;
					}

					const discount = document.querySelector('.cart-desc');
					const discountFees = document.querySelector('.cart-desc-fees');
					//const cartFees = document.querySelector('.cart-fees');
					const cartFeesPrice = document.querySelector('.cart-fees-price');								

					if (discount && response.data.discount_total && response.data.has_discount==true && !discountFees ) {
						discount.innerHTML = `
							<div class="ds-flex justify-space-between">
							<span>Descuento</span>
							<span>
								<strong>-${response.data.discount_total}</strong>
							</span>
							</div>
							<br>
						`;
					}

					if(cartFeesPrice){
						cartFeesPrice.innerHTML = '-'+response.data.discount_total;
					}
					
					const popCartDesc = document.querySelector('.pop-cart-desc');

					setTimeout(function () {
						if (popCartDesc && response.data.discount_total && response.data.has_discount==true ) {
							popCartDesc.innerHTML = response.data.discount_total;
						}
					}, 1000);

					const popCartTotal = document.querySelector('.pop-cart-total');

					if (popCartTotal) {
						popCartTotal.innerHTML = response.data.total;
					}


					// Actualizar total
					const total = document.querySelector('.cart-total');

					if (total) {
						total.innerHTML = response.data.total;
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
						const parentLi = _this.closest('li.cart__item');

						if (parentLi) parentLi.remove();

						if (response.data.carrito) {
							setTimeout(function () {
								window.location.reload();
							}, 500);
						}
					}					
				}
			},
			error: function () {
				//console.error('Error al procesar la solicitud AJAX');
			}
		});
	});

	on(document, 'click', '.modal__cart__close', function () {
		modalCart.classList.remove('active');
		body.classList.remove('no-scroll');
	});


	//***********************************PACK******************************************

	// Tabla de precios fijos por cantidad total de productos en el pack
	const packPrices = {
		2: 180.00,
		3: 255.00,
		4: 320.00,
		5: 390.00,
		6: 450.00
	};

	let packItems = {};
	const miniCart = document.getElementById('mini-pack-cart');
	const addPackBtn = document.getElementById('add-pack-to-cart');
	const errorMsgDiv = document.createElement('div');

	errorMsgDiv.className = 'pack-error-message';
	errorMsgDiv.style.color = 'red';
	errorMsgDiv.style.marginTop = '10px';

// Cargar pack guardado en localStorage si existe
if (addPackBtn) {
    const savedPack = localStorage.getItem('mosqueira_pack');

    if (savedPack) {
        try {
            packItems = JSON.parse(savedPack);
        } catch (e) {
            //console.error('Error al parsear pack del localStorage:', e);
        }
    }

    // Evento: seleccionar talla
    document.querySelectorAll('.size-option.in-stock').forEach(option => {
        option.addEventListener('click', () => {
            const variationId = option.dataset.id;
            const size = option.dataset.talla;
            const title = option.closest('.product-card').querySelector('h2').innerText;

            // Sumar cantidad total actual + 1 para validar límite
            let totalQty = 0;

            Object.values(packItems).forEach(item => totalQty += item.quantity);

            if (totalQty >= 6) {
                showError('Máximo 6 productos en el pack.');

                return;
            }

            // Agregar o aumentar cantidad
            if (packItems[variationId]) {
                packItems[variationId].quantity += 1;
            } else {
                packItems[variationId] = { size, title, quantity: 1 };
            }

            clearError();
            localStorage.setItem('mosqueira_pack', JSON.stringify(packItems));
            renderMiniCart();
        });
    });

    // Evento: eliminar ítem
    miniCart.addEventListener('click', function (e) {
        if (e.target.closest('.remove-item')) {
            const id = e.target.closest('.remove-item').dataset.id;

            delete packItems[id];
            clearError();
            localStorage.setItem('mosqueira_pack', JSON.stringify(packItems));
            renderMiniCart();
        }
    });

    // Evento: enviar pack al servidor
    addPackBtn.addEventListener('click', function () {
        const totalQty = Object.values(packItems).reduce((acc, item) => acc + item.quantity, 0);

        if (totalQty < 2) {
            showError('Debe seleccionar al menos 2 productos para el pack.');

            return;
        }

        if (totalQty > 6) {
            showError('Máximo 6 productos permitidos en el pack.');

            return;
        }

        // Calcular precio fijo según cantidad
        const packTotal = packPrices[totalQty];

        if (!packTotal) {
            showError('Error: Precio para esta cantidad no definido.');

            return;
        }

        clearError();

        const formData = new FormData();

        formData.append('action', 'create_dynamic_pack');
        formData.append('pack_items', JSON.stringify(packItems));
        formData.append('pack_total', packTotal);

        this.classList.add('loading');
		this.closest('.mini-pack-cart').classList.add('loading');
		

        fetch(jsVars.ajax_url, {
            method: 'POST',
            body: formData,
            credentials: 'same-origin'
        })
        .then(res => res.json())
        .then(response => {
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

                this.classList.remove('loading');
				this.closest('.mini-pack-cart').classList.remove('loading');
            } else {
                showError(response.data?.message || 'Error desconocido al agregar pack.');
                this.classList.remove('loading');
				this.closest('.mini-pack-cart').classList.remove('loading');
            }
        })
        .catch(error => {
            showError('Error al enviar el pack: ' + error.message);
            this.classList.remove('loading');
			this.closest('.mini-pack-cart').classList.remove('loading');
        });
    });

    // Renderizar mini carrito con productos y total
    renderMiniCart();
}

// Función para renderizar el mini carrito del pack
function renderMiniCart() {
    miniCart.innerHTML = '';
    let totalItems = 0;

    Object.keys(packItems).forEach(variationId => {
        const item = packItems[variationId];

        totalItems += item.quantity;

        const div = document.createElement('div');

        div.className = 'mini-cart-item';

        const unitText = item.quantity === 1 ? `${item.quantity} unidad` : `${item.quantity} unidades`;

        div.innerHTML = `
            <strong>${item.title}</strong> - Talla: ${item.size.toUpperCase()} - (${unitText})
            <button data-id="${variationId}" class="remove-item" title="Eliminar producto">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                    <path d="M7 7H5V13H7V7Z" fill="black"></path>
                    <path d="M11 7H9V13H11V7Z" fill="black"></path>
                    <path d="M12 1C12 0.4 11.6 0 11 0H5C4.4 0 4 0.4 4 1V3H0V5H1V15C1 15.6 1.4 16 2 16H14C14.6 16 15 15.6 15 15V5H16V3H12V1ZM6 2H10V3H6V2ZM13 5V14H3V5H13Z" fill="black"></path>
                </svg>
            </button>
        `;
        miniCart.appendChild(div);
    });

    // Mostrar mensaje si no hay productos
    if (totalItems === 0) {
        miniCart.innerHTML = '<div><small>No hay productos en el pack.</small></div>';
    }

    // Mostrar o esconder botón agregar pack según cantidad mínima
    addPackBtn.style.display = (totalItems >= 2) ? 'inline-block' : 'none';

    // Mostrar el precio fijo según total seleccionado
    if (totalItems >= 2 && totalItems <= 6) {
        const price = packPrices[totalItems];
        const priceHtml = `<div class="pack-total-price" style="margin-top:10px; font-weight:bold;">Precio pack: S/ ${price.toFixed(2)}</div>`;
        
		if (!miniCart.querySelector('.pack-total-price')) {
            miniCart.insertAdjacentHTML('beforeend', priceHtml);
        } else {
            miniCart.querySelector('.pack-total-price').textContent = `Precio pack: S/ ${price.toFixed(2)}`;
        }
    } else {
        // Eliminar precio si cantidad fuera de rango
        const existingPrice = miniCart.querySelector('.pack-total-price');

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
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.data.html) {
            const cartContainer = document.querySelector('.mos__cart_temp');
            const mosCcart = document.querySelector('.mos__modal__content_ajax');

            if (cartContainer || mosCcart) {
                if (cartContainer) {
                    cartContainer.innerHTML = data.data.html;
                } else if (mosCcart) {
                    mosCcart.innerHTML = data.data.html;
                }
                modalCart.classList.add('active');
            }
        }
    })
    .catch(() => {
		// Error silenciado intencionalmente
	});

}
	/****************************END PACKS******************************* */

});

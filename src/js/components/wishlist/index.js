/* global jsVars */
import ajax from '../../helpers/ajax';
import on from '../../helpers/on';

window.addEventListener('load', function () {
	on(document, 'click', '.js-product-wishlist', function () {
		const product_id = this.dataset.id;
		const button = this;
		const params = {
			action: 'toggle_wishlist',
			product_id: product_id,
		};

		ajax({
			url: jsVars.ajax_url,
			method: 'POST',
			params: params,
			async: true,
			done: function (response) {
				if (response.success) {
					button.classList.toggle('wishlist-added');
					alert(response.data.message);
				} else {
					alert(response.data.message);
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
});

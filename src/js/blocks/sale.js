/* global jsVars */
import ajax from '../helpers/ajax';

window.addEventListener('load', function () {
	const result = document.getElementById('mos-sale-product');
	const loadMoreBtn = document.getElementById('mos-load-more-sale');

	if (loadMoreBtn) {
		loadMoreBtn.addEventListener('click', function (e) {
			e.preventDefault();
			//const page = loadMoreBtn.getAttribute('data-page');
			const formData = new FormData();

			formData.append('action', 'load_more_product_sale');
			formData.append('nonce', jsVars.nonce);
			//formData.append('page', page);

			loadMoreBtn.textContent = 'CARGANDO...';

			ajax({
				url: jsVars.ajax_url,
				method: 'POST',
				params: formData,
				async: true,
				done: function (response) {
					if (response.status) {
						result.innerHTML += response.html;
					}
					if (!response.enabled) {
						loadMoreBtn.classList.add('ds-none');
					}
					loadMoreBtn.dataset.page = response.page;
				},
				error: function (error) {
					// eslint-disable-next-line no-console
					console.log(error);
				},
				always: function () {
					loadMoreBtn.textContent = 'MOSTRAR MÁS';
				},
			});
		});
	}
});

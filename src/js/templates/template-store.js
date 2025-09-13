/* global jsVars */
import ajax from '../helpers/ajax';

window.addEventListener('load', function () {
	const buttonFilterAttr = document.getElementById('mos-store-filters-btn');
	const result = document.getElementById('mos-archive-product');
	const filterOrder = document.querySelectorAll('.filter-order');
	const currentCategory = document.getElementById('product-current-category');
	const loadMoreBtn = document.getElementById('mos-load-more-product');
	const inputOrder = document.getElementById('mos-filter-order');

	function doesNotIncludeEmptyString(arr) {
		return !arr.includes('');
	}

	function getCheckedValues(name) {
		return Array.from(document.querySelectorAll(`input[name="${name}"]:checked`)).map((input) => input.value);
	}

	function handleExclusiveCheckbox(groupName) {
		const checkboxes = document.querySelectorAll(`input[name="${groupName}"]`);

		checkboxes.forEach((checkbox) => {
			checkbox.addEventListener('change', function () {
				const isEmpty = this.value === '';

				if (isEmpty && this.checked) {
					// Si se selecciona la opción '', deselecciona todas las demás
					checkboxes.forEach((cb) => {
						if (cb !== this) cb.checked = false;
					});
				} else if (!isEmpty && this.checked) {
					// Si se selecciona otra opción, deselecciona la vacía
					checkboxes.forEach((cb) => {
						if (cb.value === '') cb.checked = false;
					});
				}
			});
		});
	}

	document.querySelectorAll('.mos__store__filters__item').forEach((item) => {
		let button = item.querySelector('button');
		let dropdown = item.querySelector('.mos__store__filters__item__content');

		if (dropdown) {
			button.addEventListener('click', function (event) {
				event.stopPropagation();
				// Cierra cualquier otro desplegable activo
				document.querySelectorAll('.mos__store__filters__item .mos__store__filters__item__content.active').forEach((otherDropdown) => {
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
		document.querySelectorAll('.mos__store__filters__item .mos__store__filters__item__content.active').forEach((dropdown) => {
			if (!dropdown.closest('.mos__store__filters__item').contains(event.target)) {
				dropdown.classList.remove('active');
			}
		});
	});

	let array_id_one = [];
	let get_post = '';

	if(result){
		
		for (let i = 0; i < result.children.length; i++) {
			array_id_one.push(result.children[i].getAttribute('data-product-id'));
		}
	}
	if (buttonFilterAttr) {
		buttonFilterAttr.addEventListener('click', function () {
			const formData = new FormData();
			let colores = getCheckedValues('color[]');
			let tallas = getCheckedValues('talla[]');
			const container = this.parentElement.parentElement;

			//result.innerHTML = 'Cargando...';
			container.classList.remove('active');

			formData.append('action', 'get_related_atribute_products');
			formData.append('category', currentCategory.value);
			formData.append('orden', inputOrder.value);
			formData.append('page', 1);

			if (doesNotIncludeEmptyString(colores)) {
				colores.forEach((color) => formData.append('colores[]', color));
			}

			if (doesNotIncludeEmptyString(tallas)) {
				tallas.forEach((talla) => formData.append('tallas[]', talla));
			}
			result.innerHTML = '';
			ajax({
				url: jsVars.ajax_url,
				method: 'POST',
				params: formData,
				async: true,
				done: function (response) {
				
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
				error: function () {
					//console.error('Error al procesar la solicitud:', status);
					//alert('Error en la solicitud AJAX');
				},
				always: function () {
					//console.log('La solicitud AJAX ha finalizado.');
				},
			});
		});
	}

	filterOrder.forEach((item) => {
		item.addEventListener('click', function () {
			const parent = this.parentElement;
			const parentContainer = parent.parentElement;
			const buttonText = parentContainer.querySelector('button span');
			const textItem = this.textContent;
			const orden = item.getAttribute('data-orden');
			const formData = new FormData();

			parent.classList.remove('active');
			buttonText.innerHTML = textItem;
			inputOrder.value = orden;
			formData.append('action', 'get_product_by_order');
			formData.append('category', currentCategory.value);
			formData.append('orden', orden);
			formData.append('page', 1);

			ajax({
				url: jsVars.ajax_url,
				method: 'POST',
				params: formData,
				async: true,
				done: function (response) {
					result.innerHTML = response.html;
					loadMoreBtn.dataset.page = 1;
					loadMoreBtn.classList.toggle('ds-none', !response.enabled);
					//console.log(response);
					if (!response.enabled) {
						result.innerHTML = '<p style="position: absolute;">' + response.data.message + '</p>';
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

	if (loadMoreBtn) {	

		get_post = array_id_one.toString();
		
		loadMoreBtn.addEventListener('click', function (e) {
			e.preventDefault();
			const page = loadMoreBtn.getAttribute('data-page');
			const category = loadMoreBtn.getAttribute('data-cat');
			const formData = new FormData();
			let colores = getCheckedValues('color[]');
			let tallas = getCheckedValues('talla[]');

			array_id_one = [];
			for (let i = 0; i < result.children.length; i++) {
				array_id_one.push(result.children[i].getAttribute('data-product-id'));
			}
			
			get_post = array_id_one.toString();

			formData.append('action', 'load_more_product_post');
			formData.append('nonce', jsVars.nonce);
			formData.append('page', page);
			formData.append('get_post', get_post);
			formData.append('orden', inputOrder.value);
			formData.append('category_id', category);

			if (doesNotIncludeEmptyString(colores)) {
				colores.forEach((color) => formData.append('colores[]', color));
			}

			if (doesNotIncludeEmptyString(tallas)) {
				tallas.forEach((talla) => formData.append('tallas[]', talla));
			}

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
						if(response.data.message){
							result.innerHTML = '<p style="position: absolute;">' + response.data.message + '</p>';
						}						
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

	handleExclusiveCheckbox('color[]');
	handleExclusiveCheckbox('talla[]');
});

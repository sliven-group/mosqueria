/* global jsVars */
import ajax from '../../helpers/ajax';

const search = document.getElementById('mos-search');
const searchResult = document.getElementById('mos-result-search-products');
const searchTitle = document.querySelector('.title-search');
const loadMoreBtn = document.getElementById('mos-load-search');
let currentPage = 1;
let currentSearch = '';
let temporizadorDebounce;

function realizarBusqueda(texto, page = 1, append = false) {
	const formData = new FormData();

	loadMoreBtn.innerHTML = 'CARGANDO...';
	formData.append('action', 'search_product');
	formData.append('search', texto);
	formData.append('nonce', jsVars.nonce);
	formData.append('page', page);

	ajax({
		url: jsVars.ajax_url,
		method: 'POST',
		params: formData,
		async: true,
		done: function (response) {

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
					searchResult.innerHTML =
						'<p style="position:absolute;top:0;right:0;left:0;text-align:center;margin:30px 0 0;">No se encontraron productos.</p>';
					searchTitle.innerHTML = 'Resultado de búsqueda: ' + texto;
				}
				loadMoreBtn.style.display = 'none';
			}
		},
		error: function (/*error*/) {
			//console.log(error,"error");
		},
		always: function () {
			loadMoreBtn.innerHTML = 'MOSTRAR MÁS';
		},
	});
}

search.addEventListener('input', function () {
	const text = search.value.trim();

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

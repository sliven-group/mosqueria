/* global jsVars */
import ajax from '../helpers/ajax';
import JustValidate from 'just-validate';

window.addEventListener('load', function () {
	const form = document.getElementById('mos-form-unsubscribe');
	const button = form.querySelector('#mos-form-unsubscribe-btn');
	const messageResult = document.getElementById('mos-form-unsubscribe-message');
	const validation = new JustValidate(form);
	const formData = new FormData();

	validation
		.addField('#unsubscribe-email', [
			{
				rule: 'required',
				errorMessage: 'Email es requerido',
			},
			{
				rule: 'email',
				errorMessage: 'Email no tiene un formato valido',
			},
		])
		.onSuccess(() => {
			button.textContent = 'CARGANDO...';
			formData.append('action', 'mos_unsubscribe');
			formData.append('user_email', document.querySelector('input[name="unsubscribe-email"]').value);
			ajax({
				url: jsVars.ajax_url,
				method: 'POST',
				params: formData,
				async: true,
				done: function (response) {
					if (response.success) {
						if (messageResult) {
							messageResult.innerHTML = response.data.message;
						}
					} else {
						if (messageResult) {
							messageResult.innerHTML = response.data.error;
						}
					}
				},
				error: function (status) {
					//console.error('Error al procesar la solicitud:', status);
					if (messageResult) {
						messageResult.innerHTML = 'Error al procesar la solicitud:' + status;
					}
				},
				always: function () {
					button.textContent = 'DESUSCRIBIRSE';
					setTimeout(() => {
						messageResult.innerHTML = '';
					}, 5000);
					//console.log('La solicitud AJAX ha finalizado.');
				},
			});
		});
});

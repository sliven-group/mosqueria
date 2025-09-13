/* global jsVars */
import ajax from '../../helpers/ajax';
import JustValidate from 'just-validate';

window.addEventListener('load', function () {
	const form = document.getElementById('mos-form-newsletter');
	const button = form.querySelector('#mos-form-newsletter-btn');
	const messageResult = document.getElementById('mos-form-newsletter-message');
	const validation = new JustValidate(form);
	const formData = new FormData();

	validation
		.addField('#email-newsletter', [
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
			formData.append('action', 'mos_newsletter');
			formData.append('user_email', form.querySelector('input[name="email-newsletter"]').value);

			ajax({
				url: jsVars.ajax_url,
				method: 'POST',
				params: formData,
				async: true,
				done: function (response) {
					if (response.success) {
						messageResult.innerHTML = response.data.message;
					} else {
						messageResult.innerHTML = response.data.error;
					}
				},
				error: function (/*status*/) {
					//console.error('Error al procesar la solicitud:', status);
					//alert('Error en la solicitud AJAX');
				},
				always: function () {
					button.textContent = 'SUSCRIBIRSE';
					form.querySelector('input[name="email-newsletter"]').value = '';
					setTimeout(() => {
						messageResult.innerHTML = '';
					}, 3000);
					//console.log('La solicitud AJAX ha finalizado.');
				},
			});
		});
});

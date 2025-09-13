/* global jsVars */
import ajax from '../../helpers/ajax';
import JustValidate from 'just-validate';

window.addEventListener('load', function () {
	const form = document.getElementById('mos-form-login');
	const button = form.querySelector('#mos-form-login-btn');
	const messageResult = document.getElementById('mos-form-login-message');
	const validation = new JustValidate(form);
	const formData = new FormData();
	const urlParams = new URLSearchParams(window.location.search);
	const showLoginModal = urlParams.get('modal_login');
	const urlQuiz = urlParams.get('url_encuesta');

	if (showLoginModal === 'true') {
		// Asume que tu modal tiene el ID 'login-modal'.
		// Cambia 'login-modal' por el ID real de tu elemento modal.
		const loginModalElement = document.getElementById('mos-modal-account');
		// Asume que la clase que quieres añadir es 'show-modal'.
		// Cambia 'show-modal' por la clase CSS que controla la visibilidad de tu modal.

		if (loginModalElement) {
			loginModalElement.classList.add('active'); // Añade la clase para mostrarlo
		}
	}

	validation
		.addField('#email-login', [
			{
				rule: 'required',
				errorMessage: 'Email es requerido',
			},
			{
				rule: 'email',
				errorMessage: 'Email no tiene un formato valido',
			},
		])
		.addField('#password-login', [
			{
				rule: 'required',
				errorMessage: 'La contraseña es requerido',
			},
			/*{
				rule: 'password',
				errorMessage: 'La contraseña debe contener un mínimo de ocho caracteres, al menos una letra y un número',
			},*/
		])
		.onSuccess(() => {
			button.textContent = 'CARGANDO...';
			button.disabled = true;
			formData.append('action', 'login_user');
			formData.append('user_email', form.querySelector('input[name="email-login"]').value);
			formData.append('user_password', form.querySelector('input[name="password-login"]').value);

			ajax({
				url: jsVars.ajax_url,
				method: 'POST',
				params: formData,
				async: true,
				done: function (response) {
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
				error: function (/*status*/) {
					//console.error('Error al procesar la solicitud:', status);
					//alert('Error en la solicitud AJAX');
				},
				always: function () {
					button.textContent = 'INICIAR SESIÓN';
					button.disabled = false;
					setTimeout(() => {
						messageResult.innerHTML = '';
					}, 3000);
					//console.log('La solicitud AJAX ha finalizado.');
				},
			});
		});
});

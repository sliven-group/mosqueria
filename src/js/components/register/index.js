/* global jsVars */
import ajax from '../../helpers/ajax';
import JustValidate from 'just-validate';

window.addEventListener('load', function () {
	const form = document.getElementById('mos-form-register');
	const button = form.querySelector('#mos-form-create-btn');
	const messageResult = document.getElementById('mos-form-create-message');
	const validation = new JustValidate(form);
	const formData = new FormData();
	const urlParams = new URLSearchParams(window.location.search);
	const showRegisterModal = urlParams.get('modal_register');
	const showAccountModal = urlParams.get('modal_account');
	const urlQuiz = urlParams.get('url_encuesta');
	const urlAccount = urlParams.get('url_account');

	if (showRegisterModal === 'true') {
		// Asume que tu modal tiene el ID 'login-modal'.
		// Cambia 'login-modal' por el ID real de tu elemento modal.
		const registerModalElement = document.getElementById('mos-modal-account-create');
		// Asume que la clase que quieres añadir es 'show-modal'.
		// Cambia 'show-modal' por la clase CSS que controla la visibilidad de tu modal.

		if (registerModalElement) {
			registerModalElement.classList.add('active'); // Añade la clase para mostrarlo
		}
	}

	if (showAccountModal === 'true') {
		const accountModalElement = document.getElementById('mos-modal-account');
		
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
		])*/
		.addField('#name-create', [
			{
				rule: 'required',
				errorMessage: 'Nombre es requerido',
			},
		])
		.addField('#lastname-create', [
			{
				rule: 'required',
				errorMessage: 'Apellido es requerido',
			},
		])
		.addField('#email-create', [
			{
				rule: 'required',
				errorMessage: 'Email es requerido',
			},
			{
				rule: 'email',
				errorMessage: 'Email no tiene un formato valido',
			},
		])
		.addField('#password-create', [
			{
				rule: 'required',
				errorMessage: 'La contraseña es requerido',
			},
			{
				rule: 'password',
				errorMessage: 'La contraseña debe contener un mínimo de ocho caracteres, al menos una letra y un número',
			},
		])
		.addField('#genero-create', [
			{
				rule: 'required',
				errorMessage: 'Género es requerido',
			},
		])
		.addField('#term-cond-create', [
			{
				rule: 'required',
				errorMessage: 'Términos y condiciones es requerido',
			},
		])
		.onSuccess(() => {
			const name = form.querySelector('input[name="name-create"]').value;
			const lastName = form.querySelector('input[name="lastname-create"]').value;
			const nickName = form.querySelector('input[name="nickname-create"]');
			const valueCombined = name + lastName;
			const valueClean = valueCombined.replace(/[^a-zA-Z0-9]/g, '');

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
				error: function () {
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

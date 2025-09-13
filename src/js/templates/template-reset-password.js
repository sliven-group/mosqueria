/* global jsVars */
import ajax from '../helpers/ajax';
import JustValidate from 'just-validate';

window.addEventListener('load', function () {
	const form = document.getElementById('mos-form-password-create');
	const button = form.querySelector('#mos-form-password-create-btn');
	const messageResult = document.querySelector('#mos-form-password-create-message p');
	const messageResultBtn = document.querySelector('#mos-form-password-create-message button');
	const validation = new JustValidate(form);
	const formData = new FormData();

	validation
		.addField('#email-password', [
			{
				rule: 'required',
				errorMessage: 'Email es requerido',
			},
			{
				rule: 'email',
				errorMessage: 'Email no tiene un formato valido',
			},
		])
		.addField('#password-password', [
			{
				rule: 'required',
				errorMessage: 'La contraseña es requerido',
			},
			{
				rule: 'password',
				errorMessage: 'La contraseña debe contener un mínimo de ocho caracteres, al menos una letra y un número',
			},
		])
		.addField('#password-password-2', [
			{
				validator: (value, fields) => {
					if (fields['#password-password'] && fields['#password-password'].elem) {
						const repeatPasswordValue = fields['#password-password'].elem.value;

						return value === repeatPasswordValue;
					}

					return true;
				},
				errorMessage: 'La contraseña no coincide',
			},
		])
		.onSuccess(() => {
			button.textContent = 'CARGANDO...';
			button.disabled = true;
			formData.append('action', 'reset_password');
			formData.append('user_email', form.querySelector('input[name="email-password"]').value);
			formData.append('user_pass_1', form.querySelector('input[name="password-password"]').value);
			formData.append('user_pass_2', form.querySelector('input[name="password-password-2"]').value);
			formData.append('user_login', form.querySelector('input[name="user_login"]').value);
			formData.append('rp_key', form.querySelector('input[name="rp_key"]').value);

			ajax({
				url: jsVars.ajax_url,
				method: 'POST',
				params: formData,
				async: true,
				done: function (response) {
					messageResult.innerHTML = response.data.message;
					if (response.success) {
						messageResultBtn.classList.remove('ds-none');
					}
				},
				error: function (/*status*/) {
					//console.error('Error al procesar la solicitud:', status);
					//alert('Error en la solicitud AJAX');
				},
				always: function () {
					button.textContent = 'Guardar nueva contraseña';
					button.disabled = false;
					//console.log('La solicitud AJAX ha finalizado.');
				},
			});
		});
});

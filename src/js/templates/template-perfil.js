/* global jsVars */
import ajax from '../helpers/ajax';
import JustValidate from 'just-validate';

window.addEventListener('load', function () {
	const form = document.getElementById('mos-form-account');
	const button = form.querySelector('#mos-form-account-btn');
	const messageResult = document.getElementById('mos-form-account-message');
	const validation = new JustValidate(form);
	const formData = new FormData();

	const formBilling = document.getElementById('mos-form-billing');
	const formBillingBtn = formBilling.querySelector('#mos-form-billing-btn');
	const messageResultformBilling = document.getElementById('mos-form-billing-message');
	const validationformBilling = new JustValidate(formBilling);
	const formDataformBilling = new FormData();

	const departamentoSelect = document.getElementById('departamento-billing');
	const provinciaSelect = document.getElementById('provincia-billing');
	const distritoSelect = document.getElementById('distrito-billing');

	const idDepa = departamentoSelect?.value;
	const idProv = provinciaSelect?.dataset.provincia;
	const idDist = distritoSelect?.dataset.distrito;

	formBilling.querySelector('input[name="name-billing"]').value = form.querySelector('input[name="name-account"]').value;
	formBilling.querySelector('input[name="lastname-billing"]').value = form.querySelector('input[name="lastname-account"]').value;

	validation
		.addField('#name-account', [
			{
				rule: 'required',
				errorMessage: 'Nombre de usuario es requerido',
			},
		])
		.addField('#lastname-account', [
			{
				rule: 'required',
				errorMessage: 'Apellido es requerido',
			},
		])
		/*.addField('#nickname-account', [
			{
				rule: 'required',
				errorMessage: 'Nombre de usuario es requerido',
			},
		])*/
		.addField('#day-account', [
			{
				rule: 'required',
				errorMessage: 'Día de nacimiento es requerido',
			},
		])
		.addField('#mount-account', [
			{
				rule: 'required',
				errorMessage: 'Mes de nacimiento es requerido',
			},
		])
		.addField('#year-account', [
			{
				rule: 'required',
				errorMessage: 'Año de nacimiento es requerido',
			},
		])
		/*.addField('#phone-code-account', [
			{
				rule: 'required',
				errorMessage: 'Codigo de telefono es requerido',
			},
		])*/
		.addField('#phone-account', [
			{
				rule: 'required',
				errorMessage: 'Telefono es requerido',
			},
		])
		.addField('#email-account', [
			{
				rule: 'required',
				errorMessage: 'Email es requerido',
			},
			{
				rule: 'email',
				errorMessage: 'Email no tiene un formato valido',
			},
		])
		.addField('#password-account', [
			{
				rule: 'password',
				errorMessage: 'La contraseña debe contener un mínimo de ocho caracteres, al menos una letra y un número',
			},
		])
		.addField('#password-confirm-account', [
			{
				validator: (value, fields) => {
					if (fields['#password-account'] && fields['#password-account'].elem) {
						const repeatPasswordValue = fields['#password-account'].elem.value;

						return value === repeatPasswordValue;
					}

					return true;
				},
				errorMessage: 'La contraseña no coincide',
			},
		])
		.addField('#personal-data-account', [
			{
				rule: 'required',
				errorMessage: 'Confirmación de mayor de edad es requerido',
			},
		])
		.onSuccess(() => {
			formBilling.querySelector('input[name="name-billing"]').value = form.querySelector('input[name="name-account"]').value;
			formBilling.querySelector('input[name="lastname-billing"]').value = form.querySelector('input[name="lastname-account"]').value;
			button.textContent = 'CARGANDO...';
			formData.append('action', 'update_user');
			formData.append('user_id', document.querySelector('input[name="user-id"]').value);
			formData.append('account_first_name', form.querySelector('input[name="name-account"]').value);
			formData.append('account_last_name', form.querySelector('input[name="lastname-account"]').value);
			formData.append('account_display_name', form.querySelector('input[name="nickname-account"]').value);

			formData.append('account_day', form.querySelector('select[name="day-account"]').value);
			formData.append('account_month', form.querySelector('select[name="mount-account"]').value);
			formData.append('account_year', form.querySelector('select[name="year-account"]').value);
			//formData.append('account_code_phone', form.querySelector('select[name="phone-code-account"]').value);
			formData.append('account_phone', form.querySelector('input[name="phone-account"]').value);
			formData.append('account_email', form.querySelector('input[name="email-account"]').value);

			formData.append('password_current', form.querySelector('input[name="password-account"]').value);
			formData.append('password_confirm', form.querySelector('input[name="password-confirm-account"]').value);

			formData.append('account_confirm_age', form.querySelector('input[name="personal-data-account"]').checked);

			ajax({
				url: jsVars.ajax_url,
				method: 'POST',
				params: formData,
				async: true,
				done: function (response) {
					if (response.status) {
						if (messageResult) {
							messageResult.innerHTML = response.message;
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
					button.textContent = 'GUARDAR CAMBIOS';
					setTimeout(() => {
						messageResult.innerHTML = '';
					}, 5000);
					//console.log('La solicitud AJAX ha finalizado.');
				},
			});
		});

	validationformBilling
		.addField('#name-billing', [
			{
				rule: 'required',
				errorMessage: 'Nombre de usuario es requerido',
			},
		])
		.addField('#lastname-billing', [
			{
				rule: 'required',
				errorMessage: 'Apellido es requerido',
			},
		])
		.addField('#address-billing', [
			{
				rule: 'required',
				errorMessage: 'Dirección es requerido',
			},
		])
		.addField('#departamento-billing', [
			{
				rule: 'required',
				errorMessage: 'Departamento es requerido',
			},
		])
		.addField('#provincia-billing', [
			{
				rule: 'required',
				errorMessage: 'Provincia es requerido',
			},
		])
		.addField('#distrito-billing', [
			{
				rule: 'required',
				errorMessage: 'Distrito es requerido',
			},
		])
		.onSuccess(() => {

			formBilling.querySelector('input[name="name-billing"]').value = form.querySelector('input[name="name-account"]').value;
			formBilling.querySelector('input[name="lastname-billing"]').value = form.querySelector('input[name="lastname-account"]').value;
			formBillingBtn.textContent = 'CARGANDO...';
			formDataformBilling.append('action', 'update_address');
			formDataformBilling.append('user_id', document.querySelector('input[name="user-id"]').value);
			formDataformBilling.append('billing_first_name', formBilling.querySelector('input[name="name-billing"]').value);
			formDataformBilling.append('billing_last_name', formBilling.querySelector('input[name="lastname-billing"]').value);
			formDataformBilling.append('billing_adresss', formBilling.querySelector('input[name="address-billing"]').value);
			formDataformBilling.append('billing_departamento', formBilling.querySelector('select[name="departamento-billing"]').value);
			formDataformBilling.append('billing_provincia', formBilling.querySelector('select[name="provincia-billing"]').value);
			formDataformBilling.append('billing_distrito', formBilling.querySelector('select[name="distrito-billing"]').value);	
			ajax({
				url: jsVars.ajax_url,
				method: 'POST',
				params: formDataformBilling,
				async: true,
				done: function (response) {
					//console.log(response);
					if (response.success) {
						if (messageResultformBilling) {
							messageResultformBilling.innerHTML = response.data.message;
						}
					}
				},
				error: function (status) {
					//console.error('Error al procesar la solicitud:', status);
					if (messageResultformBilling) {
						messageResultformBilling.innerHTML = 'Error al procesar la solicitud:' + status;
					}
				},
				always: function () {
					formBillingBtn.textContent = 'GUARDAR CAMBIOS';
					setTimeout(() => {
						messageResultformBilling.innerHTML = '';
					}, 5000);
					//console.log('La solicitud AJAX ha finalizado.');
				},
			});
		});

	if (idDepa && idProv) {
		const formData = new FormData();

		formData.append('action', 'get_provincias');
		formData.append('id_depa', idDepa);

		ajax({
			url: jsVars.ajax_url,
			method: 'POST',
			params: formData,
			async: true,
			done: function (response) {
				if (response.success) {
					provinciaSelect.innerHTML = '<option value="">Seleccione provincia</option>';
					response.data.forEach((item) => {
						const option = document.createElement('option');

						option.value = item.idProv;
						option.textContent = item.nombre;
						if (item.idProv == idProv) option.selected = true;
						provinciaSelect.appendChild(option);
					});

					// luego de poblar provincias, cargamos distritos si hay un valor
					if (idProv && idDist) {
						const formDataDist = new FormData();

						formDataDist.append('action', 'get_distritos');
						formDataDist.append('id_prov', idProv);

						ajax({
							url: jsVars.ajax_url,
							method: 'POST',
							params: formDataDist,
							async: true,
							done: function (response) {
								if (response.success) {
									distritoSelect.innerHTML = '<option value="">Seleccione distrito</option>';
									response.data.forEach((item) => {
										const option = document.createElement('option');

										option.value = item.idDist;
										option.textContent = item.nombre;
										if (item.idDist == idDist) option.selected = true;
										distritoSelect.appendChild(option);
									});
								}
							},
						});
					}
				}
			},
		});
	}

	if (departamentoSelect) {
		departamentoSelect.addEventListener('change', function () {
			const idDepa = this.value;

			if (provinciaSelect) {
				provinciaSelect.innerHTML = '<option value=""></option>';

				const formData = new FormData();

				formData.append('action', 'get_provincias');
				formData.append('id_depa', idDepa);

				ajax({
					url: jsVars.ajax_url,
					method: 'POST',
					params: formData,
					async: true,
					done: function (response) {
						if (response.success) {
							provinciaSelect.innerHTML = '<option value="">Seleccione provincia</option>';
							response.data.forEach((item) => {
								const option = document.createElement('option');

								option.value = item.idProv;
								option.textContent = item.nombre;
								provinciaSelect.appendChild(option);
							});
						} else {
							//alert(response.data.message);
						}
					},
					error: function () {},
					always: function () {},
				});
			}
		});
	}

	if (provinciaSelect) {
		provinciaSelect.addEventListener('change', function () {
			const idProv = this.value;

			if (distritoSelect) {
				distritoSelect.innerHTML = '<option value=""></option>';

				const formData = new FormData();

				formData.append('action', 'get_distritos');
				formData.append('id_prov', idProv);

				ajax({
					url: jsVars.ajax_url,
					method: 'POST',
					params: formData,
					async: true,
					done: function (response) {
						if (response.success) {
							distritoSelect.innerHTML = '<option value="">Seleccione distrito</option>';
							response.data.forEach((item) => {
								const option = document.createElement('option');

								option.value = item.idDist;
								option.textContent = item.nombre;
								distritoSelect.appendChild(option);
							});
						} else {
							//alert(response.data.message);
						}
					},
					error: function () {},
					always: function () {
						//console.log('La solicitud AJAX ha finalizado.');
					},
				});
			}
		});
	}
});

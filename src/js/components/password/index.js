/* global jsVars */
import ajax from '../../helpers/ajax';
import JustValidate from 'just-validate';

window.addEventListener('load', function () {
	const form = document.getElementById('mos-form-password');
	const button = form.querySelector('#mos-form-password-btn');
	const messageResult = document.getElementById('mos-form-password-message');
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
		.onSuccess(() => {
			button.textContent = 'CARGANDO...';
			button.disabled = true;
			messageResult.innerHTML = '';
			formData.append('action', 'login_password');
			formData.append('user_email', form.querySelector('input[name="email-password"]').value);

			ajax({
				url: jsVars.ajax_url,
				method: 'POST',
				params: formData,
				async: true,
				done: function (response) {
					messageResult.innerHTML = response.data.message;
				},
				error: function (/*status*/) {
					//console.error('Error al procesar la solicitud:', status);
					//alert('Error en la solicitud AJAX');
				},
				always: function () {
					button.textContent = 'Obtener una contraseña nueva';
					button.disabled = false;
					//console.log('La solicitud AJAX ha finalizado.');
				},
			});
		});
	

	const passwordFields = document.querySelectorAll('input[type="password"]');

	if(passwordFields){

		passwordFields.forEach((field) => {

			const wrapper = document.createElement('div');

			wrapper.classList.add('password-wrapper');
			field.parentNode.insertBefore(wrapper, field);
			wrapper.appendChild(field);

			const toggleBtn = document.createElement('button');

			toggleBtn.type = 'button';
			toggleBtn.classList.add('toggle-password');
			toggleBtn.innerHTML = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512"><g id="icomoon-ignore"></g><path fill="#000" d="M256 96c-111.659 0-208.441 65.021-256 160 47.559 94.979 144.341 160 256 160 111.656 0 208.438-65.021 256-160-47.558-94.979-144.344-160-256-160zM382.225 180.852c30.081 19.187 55.571 44.887 74.717 75.148-19.146 30.261-44.637 55.961-74.718 75.148-37.797 24.109-81.445 36.852-126.224 36.852-44.78 0-88.429-12.743-126.226-36.852-30.079-19.186-55.569-44.886-74.716-75.148 19.146-30.262 44.637-55.962 74.717-75.148 1.959-1.25 3.938-2.461 5.93-3.65-4.98 13.664-7.705 28.411-7.705 43.798 0 70.691 57.308 128 128 128s128-57.309 128-128c0-15.387-2.726-30.134-7.704-43.799 1.989 1.189 3.969 2.401 5.929 3.651v0zM256 208c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.491 48 48z"></path></svg>';

			toggleBtn.addEventListener('click', function () {
				const isVisible = field.type === 'text';
				
				field.type = isVisible ? 'password' : 'text';
				toggleBtn.innerHTML = isVisible ? '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512"><g id="icomoon-ignore"></g><path fill="#000" d="M256 96c-111.659 0-208.441 65.021-256 160 47.559 94.979 144.341 160 256 160 111.656 0 208.438-65.021 256-160-47.558-94.979-144.344-160-256-160zM382.225 180.852c30.081 19.187 55.571 44.887 74.717 75.148-19.146 30.261-44.637 55.961-74.718 75.148-37.797 24.109-81.445 36.852-126.224 36.852-44.78 0-88.429-12.743-126.226-36.852-30.079-19.186-55.569-44.886-74.716-75.148 19.146-30.262 44.637-55.962 74.717-75.148 1.959-1.25 3.938-2.461 5.93-3.65-4.98 13.664-7.705 28.411-7.705 43.798 0 70.691 57.308 128 128 128s128-57.309 128-128c0-15.387-2.726-30.134-7.704-43.799 1.989 1.189 3.969 2.401 5.929 3.651v0zM256 208c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.491 48 48z"></path></svg>' : '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512"><g id="icomoon-ignore"></g><path fill="#000" d="M472.971 7.029c-9.373-9.372-24.568-9.372-33.941 0l-101.082 101.082c-25.969-7.877-53.474-12.111-81.948-12.111-111.659 0-208.441 65.021-256 160 20.561 41.062 50.324 76.52 86.511 103.548l-79.481 79.481c-9.373 9.373-9.373 24.568 0 33.941 4.686 4.687 10.828 7.030 16.97 7.030s12.284-2.343 16.971-7.029l432-432c9.372-9.373 9.372-24.569 0-33.942zM208 160c21.12 0 39.041 13.647 45.46 32.598l-60.862 60.862c-18.951-6.419-32.598-24.34-32.598-45.46 0-26.51 21.49-48 48-48zM55.058 256c19.146-30.262 44.637-55.962 74.717-75.148 1.959-1.25 3.938-2.461 5.931-3.65-4.981 13.664-7.706 28.411-7.706 43.798 0 27.445 8.643 52.869 23.35 73.709l-30.462 30.462c-26.223-18.421-48.601-41.941-65.83-69.171z"></path><path fill="#000" d="M384 221c0-13.583-2.128-26.667-6.051-38.949l-160.904 160.904c12.284 3.921 25.371 6.045 38.955 6.045 70.691 0 128-57.309 128-128z"></path><path fill="#000" d="M415.013 144.987l-34.681 34.681c0.632 0.393 1.265 0.784 1.893 1.184 30.081 19.187 55.571 44.887 74.717 75.148-19.146 30.261-44.637 55.961-74.718 75.148-37.797 24.109-81.445 36.852-126.224 36.852-19.332 0-38.451-2.38-56.981-7.020l-38.447 38.447c29.859 10.731 61.975 16.573 95.428 16.573 111.655 0 208.438-65.021 256-160-22.511-44.958-56.059-83.198-96.987-111.013z"></path></svg>';
			});

			wrapper.appendChild(toggleBtn);
		});
	}
	

});

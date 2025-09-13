/* global jsVars, tarifasDistritos, preloadedData */
import on from '../helpers/on';
import { variableRateDistrictsRegular, variableRateDistrictsExpress } from '../helpers/varible-rate-districts';

window.addEventListener('load', function () {
	const checkoutForm = document.querySelector('form.checkout');
	const stepItems = document.querySelectorAll('.mos__steps__item');
	const contentItems = document.querySelectorAll('.mos__steps__content__item');
	let currentStep = jsVars.is_checkout == '1' ? 2 : 1;

	const additionalEmail = document.getElementById('additional_email');
	const additionalName = document.getElementById('additional_name');
	const additionalLastname = document.getElementById('additional_lastname');
	const additionalDni = document.getElementById('additional_dni');
	const additionalPhone = document.getElementById('additional_phone');
	const additionalNewsletter = document.getElementById('additional_newsletter');

	const billingFirstName = document.getElementById('billing_first_name');
	const billingLastName = document.getElementById('billing_last_name');
	const billingPhone = document.getElementById('billing_phone');
	const billingEmail = document.getElementById('billing_email');
	const billingDepartamento = document.getElementById('billing_departamento');
	const billingProvincia = document.getElementById('billing_provincia');
	const billingDistrito = document.getElementById('billing_distrito');
	const billingAddress1 = document.getElementById('billing_address_1');
	const billingCity = this.document.getElementById('billing_city');

	const additionalFields = {
		additional_email: additionalEmail,
		additional_name: additionalName,
		additional_lastname: additionalLastname,
		additional_dni: additionalDni,
		additional_phone: additionalPhone,
	};
	const billingFields = {
		billing_first_name: billingFirstName,
		billing_last_name: billingLastName,
		billing_phone: billingPhone,
		billing_email: billingEmail,
		billing_departamento: billingDepartamento,
		billing_provincia: billingProvincia,
		billing_distrito: billingDistrito,
		billing_address_1: billingAddress1,
	};
	const expressDistricts = tarifasDistritos.express.map((d) => d.toUpperCase());
	const regularDistricts = tarifasDistritos.regular.map((d) => d.toUpperCase());
	//const provinceDistricts = tarifasDistritos.provincia.map((item) => item.distrito.toUpperCase());

	function showStep(stepNumber) {
		if (jsVars.is_cart == '1') return;
		if (stepNumber < 1 || stepNumber > stepItems.length) return;

		stepItems.forEach((item) => item.classList.remove('active'));
		contentItems.forEach((item) => item.classList.remove('active'));

		const currentStepItem = document.querySelector(`[data-step="step-${stepNumber}"]`);

		if (currentStepItem) currentStepItem.classList.add('active');

		const currentContentItem = document.getElementById(`step-${stepNumber}`);

		if (currentContentItem) currentContentItem.classList.add('active');

		currentStep = stepNumber;
	}

	function validateBillingFields() {
		let isValid = true;

		for (const key in billingFields) {
			const field = billingFields[key];
			const valid = validateField(key, field);

			if (!valid) isValid = false;
		}

		return isValid;
	}

	function validateAdditionalFields() {
		let isValid = true;

		for (const key in additionalFields) {
			const field = additionalFields[key];
			const valid = validateField(key, field);

			if (!valid) isValid = false;
		}

		return isValid;
	}

	function validateField(key, field) {
		const value = field.value.trim();
		let errorElement = document.getElementById('error-' + key);

		// Crear el contenedor del mensaje si no existe
		if (!errorElement) {
			errorElement = document.createElement('div');
			errorElement.id = 'error-' + key;
			errorElement.className = 'error-message';
			field.insertAdjacentElement('afterend', errorElement);
		}

		// Limpiar mensaje anterior
		errorElement.innerText = '';

		// Validar vacío
		if (value === '') {
			field.classList.add('invalid');
			errorElement.innerText = 'Este campo es obligatorio.';

			return false;
		} else {
			field.classList.remove('invalid');
		}

		if (key === 'additional_dni') {
			if (!/^\d{8}$/.test(value)) {
				field.classList.add('invalid');
				errorElement.innerText = 'El DNI debe tener exactamente 8 dígitos.';

				return false;
			}
		}

		if (key === 'additional_email') {
			const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

			if (!emailRegex.test(value)) {
				field.classList.add('invalid');
				errorElement.innerText = 'Ingrese un correo electrónico válido.';

				return false;
			}
		}

		if (key === 'additional_phone') {
			if (!/^\d{9}$/.test(value)) {
				field.classList.add('invalid');
				errorElement.innerText = 'El Teléfono debe tener exactamente 9 dígitos.';

				return false;
			}
		}

		return true;
	}

	function mostrarMensajeVariable(wrapper, buttonStep) {
		wrapper.innerHTML =
			'<p>La tarifa de delivery hacia su destino es variable. <a href="https://wa.me/51908900915?text=Hola! Quiero realizar un pedido y la tarifa a mi distrito es variable" target="_blank">Comuníquese con un asesor</a></p>';
		buttonStep.classList.add('ds-none');
	}

	function updateDeliveryMethods() {
		if (currentStep < 3) {
			return;
		}
		const distritoElement = document.getElementById('billing_distrito');
		const provinciaElement = document.getElementById('billing_provincia');
		const departamentoElement = document.getElementById('billing_departamento');

		const wrapperElement = document.querySelector('#billing_delivery_methods_field .woocommerce-input-wrapper');
		let selectElement = document.getElementById('billing_delivery_methods');
		const buttonStep = document.getElementById('mos-checkout-next-step');

		if (!selectElement) {
			wrapperElement.innerHTML =
				'<select name="billing_delivery_methods" id="billing_delivery_methods" class="select"><option value="">Selecciona un método</option></select>';

			selectElement = document.getElementById('billing_delivery_methods');
		}

		const distrito = distritoElement ? distritoElement.options[distritoElement.selectedIndex].textContent.trimEnd() : '';
		const provincia = provinciaElement ? provinciaElement.options[provinciaElement.selectedIndex].textContent.trimEnd() : '';
		const departamento = departamentoElement ? departamentoElement.options[departamentoElement.selectedIndex].textContent.trimEnd() : '';
		//const ciudad = ciudadElement ? ciudadElement.options[ciudadElement.selectedIndex].textContent.trimEnd() : '';

		selectElement.innerHTML = '';
		if (billingCity) billingCity.value = distrito;

		// Limpia el select primero
		selectElement.innerHTML = '<option value="">Selecciona un método</option>';

		if (
			(departamento === 'LIMA' && provincia === 'LIMA' && regularDistricts.includes(distrito) && expressDistricts.includes(distrito)) ||
			(departamento === 'LIMA' && provincia === 'CALLAO' && distrito === 'LA PUNTA')
		) {
			selectElement.innerHTML = `
				<option value="">Selecciona un método</option>
				<option value="express">Envío Express - Máx. 4 horas</option>
				<option value="regular">Envío Regular - Máx. 2 días hábiles</option>
			`;
			buttonStep.classList.remove('ds-none');
		} else if (
			departamento === 'LIMA' &&
			provincia === 'LIMA' &&
			expressDistricts.includes(distrito) &&
			!variableRateDistrictsExpress.includes(distrito)
		) {
			selectElement.innerHTML += '<option value="express">Envío Express - Máx. 4 horas</option>';
			buttonStep.classList.remove('ds-none');
		} else if (
			departamento === 'LIMA' &&
			provincia === 'LIMA' &&
			regularDistricts.includes(distrito) &&
			!variableRateDistrictsRegular.includes(distrito)
		) {
			selectElement.innerHTML += '<option value="regular">Envío Regular - Máx. 2 días hábiles</option>';
			buttonStep.classList.remove('ds-none');
		} else if (
			departamento !== 'LIMA' &&
			provincia !== 'LIMA' &&
			tarifasDistritos.provincia.some(
				(item) =>
					item.departamento.toUpperCase() === departamento && item.provincia.toUpperCase() === provincia && item.distrito.toUpperCase() === distrito,
			)
		) {
			selectElement.innerHTML += '<option value="provincia">Envío Provincia - Máx. 5 días hábiles</option>';
			buttonStep.classList.remove('ds-none');
		} else if (
			departamento === 'LIMA' &&
			provincia !== 'LIMA' &&
			tarifasDistritos.provincia.some(
				(item) =>
					item.departamento.toUpperCase() === departamento && item.provincia.toUpperCase() === provincia && item.distrito.toUpperCase() === distrito,
			)
		) {
			selectElement.innerHTML += '<option value="provincia">Envío Provincia - Máx. 5 días hábiles</option>';
			buttonStep.classList.remove('ds-none');
		} else if (
			(departamento === 'LIMA' && provincia === 'LIMA' && distrito === 'YAUYOS') ||
			(departamento === 'LORETO' && provincia === 'DATEM DEL MARAÑON' && distrito === 'BARRANCA')
		) {
			selectElement.innerHTML += '<option value="provincia">Envío Provincia - Máx. 5 días hábiles</option>';
			buttonStep.classList.remove('ds-none');
		} else if (
			departamento === 'LIMA' &&
			provincia === 'LIMA' &&
			(variableRateDistrictsRegular.includes(distrito) || variableRateDistrictsExpress.includes(distrito))
		) {
			mostrarMensajeVariable(wrapperElement, buttonStep);
		} else if (
			departamento === 'LIMA' &&
			provincia === 'CALLAO' &&
			(variableRateDistrictsRegular.includes(distrito) || variableRateDistrictsExpress.includes(distrito))
		) {
			mostrarMensajeVariable(wrapperElement, buttonStep);
		} else {
			wrapperElement.innerHTML = '<p>No se realizan envíos a la ubicación seleccionada.</p>';
			buttonStep.classList.add('ds-none');
		}
	}

	function preloadData() {
		additionalEmail.value = preloadedData.email;
		additionalName.value = preloadedData.nombres;
		additionalLastname.value = preloadedData.apellidos;
		additionalPhone.value = preloadedData.telefono;
		setTimeout(() => {
			billingDepartamento.value = preloadedData.departamento;
		}, 1000);

		setTimeout(() => {
			billingProvincia.value = preloadedData.provincia;
		}, 2000);

		/*setTimeout(() => {
			billingDistrito.value = preloadedData.distrito;
		}, 3000);*/

		setTimeout(() => {
			billingDepartamento.dispatchEvent(new Event('change'));
		}, 1500);

		setTimeout(() => {
			billingProvincia.dispatchEvent(new Event('change'));
		}, 2500);

		setTimeout(() => {
			const wrapperElement = document.querySelector('#billing_delivery_methods_field .woocommerce-input-wrapper');

			wrapperElement.innerHTML =
				'<select name="billing_delivery_methods" id="billing_delivery_methods" class="select"><option value="">Selecciona un método</option></select>';
		}, 3000);

		/*setTimeout(() => {
			billingDistrito.dispatchEvent(new Event('change'));
		}, 3000);*/
	}

	on(document, 'click', '#mos-checkout-next-step', function (e) {
		e.preventDefault;
		const _this = this;
		const billingDeliveryMethods = document.getElementById('billing_delivery_methods');
		const placeOrder = document.getElementById('place_order');

		if (currentStep === 2) {
			if (validateAdditionalFields()) {
				showStep(3); // Avanza al siguiente paso si todo es válido
				billingFirstName.value = additionalName.value;
				billingLastName.value = additionalLastname.value;
				billingPhone.value = additionalPhone.value;
				billingEmail.value = additionalEmail.value;
				
				if(window.innerWidth<768){
					window.scrollTo({
						top: 0,
						behavior: 'smooth'
					});
				}
			}
		} else if (currentStep === 3) {
			if (validateBillingFields() && billingDeliveryMethods.value != '') {
				
			
				showStep(4); // Avanza al siguiente paso si todo es válido
				if (currentStep === 4) {
					_this.classList.add('ds-none');
					placeOrder.classList.remove('ds-none');
				}
			}
		}
	});

	on(document, 'click', '.mos__step__back', function (e) {
		e.preventDefault;
		const buttonStep = document.getElementById('mos-checkout-next-step');
		const placeOrder = document.getElementById('place_order');

		showStep(--currentStep);
		if (currentStep === 3) {
			placeOrder.classList.add('ds-none');
			buttonStep.classList.remove('ds-none');
		}
	});

	if (billingDistrito) {
		const observer = new MutationObserver(function (mutations) {
			mutations.forEach(function (mutation) {
				if (mutation.type === 'childList') {
					updateDeliveryMethods();
				}
			});
		});

		observer.observe(billingDistrito, { childList: true });
		billingDistrito.addEventListener('change', updateDeliveryMethods);
	}

	if (additionalEmail) {
		for (const key in additionalFields) {
			const field = additionalFields[key];

			field.addEventListener('input', () => {
				validateField(key, field);
			});
		}

		for (const key in billingFields) {
			const field = billingFields[key];

			field.addEventListener('input', () => {
				validateField(key, field);
			});
		}
	}

	if (checkoutForm) {
		const observer = new MutationObserver(function (mutations) {
			mutations.forEach(function (mutation) {
				if (mutation.attributeName === 'class') {
					if (checkoutForm.classList.contains('processing')) {
						document.getElementById('place_order').innerHTML = 'PROCESANDO...';
						document.getElementById('place_order').disabled = true;
					} else {
						document.getElementById('place_order').innerHTML = 'REALIZAR EL PEDIDO';
						document.getElementById('place_order').disabled = false;
					}
				}
			});
		});

		observer.observe(checkoutForm, {
			attributes: true,
		});
	}

	if (additionalNewsletter) {
		additionalNewsletter.addEventListener('change', function () {
			if (this.checked) {
				this.setAttribute('value', '1');
			} else {
				this.setAttribute('value', '0');
			}
		});
	}

	preloadData();
	showStep(currentStep);
});

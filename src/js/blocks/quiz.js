/* global jsVars */
import ajax from '../helpers/ajax';
import JustValidate from 'just-validate';

window.addEventListener('load', function () {
	const form = document.getElementById('mos-form-quiz');
	const button = form.querySelector('#mos-form-quiz-btn');
	const messageResult = document.getElementById('mos-form-quiz-message');

	const otroCheckbox = document.getElementById('reason-quiz-6');
	const otroInputContainer = form.querySelector('#reason_quiz_radio_group + .form-input-inside');
	const otroInput = document.getElementById('reason-quiz-other');

	const canalWebCheckbox = document.getElementById('canal-quiz-1');
	const canalWhatsCheckbox = document.getElementById('canal-quiz-2');
	const webInputContainer = document.getElementById('yes_web_quiz_group');
	const whatsInputContainer = document.getElementById('yes_whats_quiz_group');

	const siCanalWebCheckbox = document.getElementById('nav-siteweb-quiz-1');
	const noCanalWebCheckbox = document.getElementById('nav-siteweb-quiz-2');
	const noCanalWebInput = document.getElementById('nav-siteweb-no-quiz');
	const noCanalWebContainer = form.querySelector('#siteweb_2_quiz_radio_group + .form-input-inside');

	const calserCheckbox = document.querySelectorAll('input[name="calser-quiz"]');
	const calserContainer = document.querySelector('#whats_2_quiz_radio_group + .form-input-inside');
	const calserCheckbox3 = document.getElementById('calser-quiz-3');
	const calserCheckbox4 = document.getElementById('calser-quiz-4');

	const whatsCheckbox = document.querySelectorAll('input[name="whats-quiz"]');
	const whatsContainer = document.querySelector('#whats_1_quiz_radio_group + .form-input-inside');
	const whatsCheckbox3 = document.getElementById('whats-quiz-3');
	const whatsCheckbox4 = document.getElementById('whats-quiz-4');

	const containerGeneral = document.querySelector('.mos__block__quiz');

	const textarea = document.getElementById('comment-quiz');

	const validation = new JustValidate(form);
	const formData = new FormData();

	validation
		.addRequiredGroup('#recommendation_quiz_radio_group')
		.addRequiredGroup('#qualification_quiz_radio_group')
		.addRequiredGroup('#presentation_quiz_radio_group')
		.addRequiredGroup('#experience_quiz_radio_group')
		.addRequiredGroup('#reason_quiz_radio_group')
		.addField('#reason-quiz-other', [
			{
				rule: 'function',
				validator: function (value) {
					if (otroCheckbox && otroCheckbox.checked) {
						return value.trim() !== '';
					}

					return true;
				},
				errorMessage: 'Campo obligatorio',
			},
		])
		.addRequiredGroup('#canal_quiz_radio_group')
		.addField('#nav-siteweb-no-quiz', [
			{
				rule: 'function',
				validator: function (value) {
					if (noCanalWebCheckbox && noCanalWebCheckbox.checked) {
						return value.trim() !== '';
					}

					return true;
				},
				errorMessage: 'Campo obligatorio',
			},
		])
		.addField('#calser-rema-quiz', [
			{
				rule: 'function',
				validator: function (value) {
					if ((calserCheckbox4 && calserCheckbox4.checked) || (calserCheckbox3 && calserCheckbox3.checked)) {
						return value.trim() !== '';
					}

					return true;
				},
				errorMessage: 'Campo obligatorio',
			},
		])
		.addField('#whats-rema-quiz', [
			{
				rule: 'function',
				validator: function (value) {
					if ((whatsCheckbox3 && whatsCheckbox3.checked) || (whatsCheckbox4 && whatsCheckbox4.checked)) {
						return value.trim() !== '';
					}

					return true;
				},
				errorMessage: 'Campo obligatorio',
			},
		])
		.addField('#comment-quiz', [
			{
				rule: 'required',
				errorMessage: 'Campo requerido',
			},
		])
		.onSuccess(() => {
			formData.append('action', 'mos_submit_quiz');
			formData.append('user_wp', document.querySelector('input[name="user-name-quiz"]').value);
			formData.append('recommendation', form.querySelector('input[name="recommendation-quiz"]:checked')?.value);
			formData.append('qualification', form.querySelector('input[name="qualification-quiz"]:checked')?.value);
			formData.append('presentation', form.querySelector('input[name="presentation-quiz"]:checked')?.value);
			formData.append('experience', form.querySelector('input[name="experience-quiz"]:checked')?.value);
			formData.append(
				'reasons',
				Array.from(form.querySelectorAll('input[name="reason-quiz"]:checked')).map((el) => el.value),
			);
			formData.append('other_reason', document.getElementById('reason-quiz-other').value);
			formData.append('channel', form.querySelector('input[name="canal-quiz"]:checked')?.value);
			formData.append('site_experience', form.querySelector('input[name="siteweb-quiz"]:checked')?.value ?? '');
			formData.append('site_navigation', form.querySelector('input[name="nav-siteweb-quiz"]:checked')?.value ?? '');
			formData.append('site_improvement', document.getElementById('nav-siteweb-no-quiz').value);
			formData.append('advisor_experience', form.querySelector('input[name="whats-quiz"]:checked')?.value ?? '');
			formData.append('advisor_improvement', document.getElementById('whats-rema-quiz').value);
			formData.append('delivery_experience', form.querySelector('input[name="calser-quiz"]:checked')?.value ?? '');
			formData.append('delivery_improvement', document.getElementById('calser-rema-quiz').value);
			formData.append('comment', document.getElementById('comment-quiz').value);

			button.disabled = true;
			button.textContent = 'CARGANDO...';
			ajax({
				url: jsVars.ajax_url,
				method: 'POST',
				params: formData,
				async: true,
				done: function (response) {
					if (response.success) {
						if (containerGeneral) {
							window.scrollTo({
								top: 0,
							});
							containerGeneral.innerHTML = `<div class="mos__container"><h2>¡Gracias por completar la encuesta!</h2><p>${response.data}</p></div>`;
						}
					} else {
						if (messageResult) {
							messageResult.innerHTML = response.data;
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
					button.textContent = 'ENVIAR';
					button.disabled = false;
					setTimeout(() => {
						messageResult.innerHTML = '';
					}, 5000);
					//console.log('La solicitud AJAX ha finalizado.');
				},
			});
		});

	otroCheckbox.addEventListener('change', function () {
		if (this.checked) {
			otroInputContainer.style.display = 'block';
		} else {
			otroInputContainer.style.display = 'none';
			otroInput.value = '';
		}
		validation.revalidateField('#reason-quiz-other');
	});

	canalWebCheckbox.addEventListener('change', function () {
		if (this.checked) {
			webInputContainer.style.display = 'block';
			whatsInputContainer.style.display = 'none';
			['#siteweb_1_quiz_radio_group', '#siteweb_2_quiz_radio_group'].forEach(function (groupSelector) {
				validation.addRequiredGroup(groupSelector);
			});
			['#whats_1_quiz_radio_group', '#whats_2_quiz_radio_group'].forEach(function (groupSelector) {
				if (validation.hasGroup && validation.hasGroup(groupSelector)) {
					validation.removeGroup(groupSelector);
				}
			});
		} else {
			webInputContainer.style.display = 'none';
			whatsInputContainer.style.display = 'block';

			['#siteweb_1_quiz_radio_group', '#siteweb_2_quiz_radio_group'].forEach(function (groupSelector) {
				validation.removeGroup(groupSelector);
			});
		}
	});

	canalWhatsCheckbox.addEventListener('change', function () {
		if (this.checked) {
			webInputContainer.style.display = 'none';
			whatsInputContainer.style.display = 'block';
			siCanalWebCheckbox.checked = false;
			noCanalWebCheckbox.checked = false;

			['#whats_1_quiz_radio_group', '#whats_2_quiz_radio_group'].forEach(function (groupSelector) {
				if (validation.hasGroup && validation.hasGroup(groupSelector)) {
					validation.addRequiredGroup(groupSelector);
				}
			});
			['#siteweb_1_quiz_radio_group', '#siteweb_2_quiz_radio_group'].forEach(function (groupSelector) {
				validation.removeGroup(groupSelector);
			});
		} else {
			webInputContainer.style.display = 'block';
			whatsInputContainer.style.display = 'none';

			['#whats_1_quiz_radio_group', '#whats_2_quiz_radio_group'].forEach(function (groupSelector) {
				if (validation.hasGroup && validation.hasGroup(groupSelector)) {
					validation.removeGroup(groupSelector);
				}
			});
		}
	});

	noCanalWebCheckbox.addEventListener('change', function () {
		if (this.checked) {
			noCanalWebContainer.style.display = 'block';
		}
		validation.revalidateField('#nav-siteweb-no-quiz');
	});

	siCanalWebCheckbox.addEventListener('change', function () {
		if (this.checked) {
			noCanalWebContainer.style.display = 'none';
			noCanalWebInput.value = '';
		}
	});

	textarea.addEventListener('input', function () {
		this.style.height = 'auto'; // Reinicia la altura
		this.style.height = this.scrollHeight + 'px'; // Ajusta al contenido
	});

	calserCheckbox.forEach((radio) => {
		radio.addEventListener('change', () => {
			const selectedOption = document.querySelector('input[name="calser-quiz"]:checked');

			if (selectedOption) {
				const value = selectedOption.value;

				if (value === 'Regular' || value === 'Mala') {
					calserContainer.style.display = 'block';
				} else {
					validation.revalidateField('#calser-rema-quiz');
					calserContainer.style.display = 'none';
				}
			}
		});
	});

	whatsCheckbox.forEach((radio) => {
		radio.addEventListener('change', () => {
			const selectedOption = document.querySelector('input[name="whats-quiz"]:checked');

			if (selectedOption) {
				const value = selectedOption.value;

				if (value === 'Regular' || value === 'Mala') {
					whatsContainer.style.display = 'block';
				} else {
					validation.revalidateField('#whats-rema-quiz');
					whatsContainer.style.display = 'none';
				}
			}
		});
	});
});

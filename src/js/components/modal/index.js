const body = document.body;
const modals = document.querySelectorAll('.mos__modal');
const modalTriggers = document.querySelectorAll('.js-modal-trigger');
const closeModalButtons = document.querySelectorAll('.mos__modal__close');
const modalBackgrounds = document.querySelectorAll('.mos__modal__bg'); // Seleccionamos los fondos

function openModal(event) {
	event.preventDefault();
	const modalId = event.currentTarget.getAttribute('data-modal-target');
	const modal = document.getElementById(modalId);

	if (modal) {
		modals.forEach((m) => {
			if (m !== modal) {
				m.classList.remove('active');
			}
		});

		modal.classList.add('active');
		body.classList.add('no-scroll');
	}
}

function closeModals(event) {
	event.preventDefault();
	modals.forEach((modal) => modal.classList.remove('active'));
	body.classList.remove('no-scroll');
}

window.addEventListener('load', function () {
	modalTriggers.forEach((trigger) => {
		trigger.addEventListener('click', openModal);
	});

	[...closeModalButtons, ...modalBackgrounds].forEach((element) => {
		element.addEventListener('click', closeModals);
	});
});

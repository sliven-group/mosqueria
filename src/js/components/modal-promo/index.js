import getCookie from '../../helpers/get-cookie';
import setCookie from '../../helpers/set-cookie';

const modalPromo = document.getElementById('mos-modal-discount');
const urlParams = new URLSearchParams(window.location.search);
const showLoginModal = urlParams.get('modal_login');

window.addEventListener('load', function () {
	if (showLoginModal === 'true') {
		return;
	}

	function closeModalAndSetCookie() {
		if (modalPromo) {
			modalPromo.classList.remove('active');
			setCookie('modalPromoClosed', '1', 1);
		}
	}

	if (modalPromo) {
		const close = modalPromo.querySelector('.mos__modal__close');
		const bg = modalPromo.querySelector('.mos__modal__bg');
		const btn = modalPromo.querySelector('.mos__btn');

		if (!getCookie('modalPromoClosed')) {
			modalPromo.classList.add('active');
		}

		if (close) {
			close.addEventListener('click', closeModalAndSetCookie);
		}

		if (bg) {
			bg.addEventListener('click', closeModalAndSetCookie);
		}

		if (btn) {
			btn.addEventListener('click', closeModalAndSetCookie);
		}
	}
});

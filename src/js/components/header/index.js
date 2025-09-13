const body = document.querySelector('body');
const openMenu = document.querySelector('.js-open-menu');
const menu = document.querySelector('.mos__header__nav');
const header = document.querySelector('.mos__header');
const menuItems = document.querySelectorAll('.mos__header__menu .menu-item-has-children');

function FixHeader() {
	if (window.scrollY > 0) {
		header.classList.add('active');
	} else {
		header.classList.remove('active');
	}
	setTimeout(FixHeader, 100);
}

window.addEventListener('load', function () {
	openMenu.addEventListener('click', function () {
		menu.classList.toggle('active');
		body.classList.toggle('no-scroll');
		this.classList.toggle('active');
	});
	if (body.classList.contains('home')) {
		FixHeader();
	}
	if (window.innerWidth < 770) {
		menuItems.forEach((item) => {
			const prev = item.querySelector('.prev-menu-full');
			const subMenuFull = item.querySelector('.mos__header__menu__full');
			const button = item.querySelector('.menu-item-has-children-a');

			button.addEventListener('click', function (e) {
				e.preventDefault();
				subMenuFull.classList.add('active');
			});

			prev.addEventListener('click', function () {
				subMenuFull.classList.remove('active');
			});
		});
	}
});

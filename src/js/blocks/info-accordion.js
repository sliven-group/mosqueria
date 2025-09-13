document.addEventListener('DOMContentLoaded', function () {
	const items = document.querySelectorAll('.mos__block__ia .item');

	items.forEach((item) => {
		const header = item.querySelector('.item__header');

		header.addEventListener('click', function () {
			const isActive = item.classList.contains('active');

			items.forEach((i) => {
				i.classList.remove('active');
			});

			if (!isActive) {
				item.classList.add('active');
			}
		});
	});
});

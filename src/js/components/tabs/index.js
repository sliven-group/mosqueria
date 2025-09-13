const tabs = document.querySelector('.mos__tab');
const tabButton = document.querySelectorAll('.mos__tab__li');
const contents = document.querySelectorAll('.mos__tab__content');

window.addEventListener('load', function () {
	if (typeof tabs != 'undefined' && tabs != null) {
		const currentHash = window.location.hash.substring(1);

		if (currentHash) {
			const targetTab = document.querySelector(`.mos__tab__li[data-id="${currentHash}"]`);
			const targetContent = document.getElementById(currentHash);

			if (targetTab && targetContent) {
				tabButton.forEach((btn) => btn.classList.remove('active'));
				contents.forEach((content) => content.classList.remove('active'));

				targetTab.classList.add('active');
				targetContent.classList.add('active');
			}
		}

		tabs.addEventListener('click', function (e) {
			const id = e.target.dataset.id;

			if (id) {
				tabButton.forEach((btn) => btn.classList.remove('active'));
				e.target.classList.add('active');

				contents.forEach((content) => content.classList.remove('active'));
				const element = document.getElementById(id);

				element.classList.add('active');

				history.replaceState(null, null, `#${id}`);
			}
		});
	}
	
	//tabl MSC
	const table = document.querySelector('.mos__container .items table');

	if (!table) return;

	const itemWrapper = table.closest('.item');
	const itemsContainer = itemWrapper?.parentNode;

	if (!itemWrapper || !itemsContainer) return;

	const newContainer = document.createElement('div');

	newContainer.classList.add('benefits-container-generate');

	const theadTh = table.querySelector('thead th.tableHeader');
	let thWidth = 0;
	let thHeight = 0;

	if (theadTh) {

		const rect = theadTh.getBoundingClientRect();

		thWidth = rect.width;
		thHeight = rect.height;

		const titleDiv = document.createElement('div');

		titleDiv.classList.add('benefit-heading');
		titleDiv.innerHTML = theadTh.innerHTML;
		titleDiv.style.width = `${thWidth}px`;
		titleDiv.style.height = `${thHeight}px`;
		newContainer.appendChild(titleDiv);
	}

	const rows = table.querySelectorAll('tbody tr');

	rows.forEach(row => {
		const benefitCell = row.querySelector('th, th');

		if (benefitCell) {

			const rect = benefitCell.getBoundingClientRect();
			const benefitDiv = document.createElement('div');

			benefitDiv.classList.add('benefit-item');
			benefitDiv.textContent = benefitCell.textContent.trim();
			benefitDiv.style.width = `${thWidth}px`;
			benefitDiv.style.height = `${rect.height}px`; 
			newContainer.appendChild(benefitDiv);
		}
	});
	
	itemsContainer.insertBefore(newContainer, itemWrapper);
	itemsContainer.classList.add('benefits-container-generate-wrap');

});
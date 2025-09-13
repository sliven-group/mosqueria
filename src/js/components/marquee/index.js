const slider = document.querySelector('.mos__header__top__slider');
const slides = document.querySelectorAll('.mos__header__top__slide');
const containerWidth = document.querySelector('.mos__header__top');
let currentIndex = 1;
let totalSlides = slides.length;

function nextSlide() {
	currentIndex++;
	updateSliderPosition();

	if (currentIndex === totalSlides + 1) {
		setTimeout(() => {
			currentIndex = 1;
			updateSliderPosition(false);
		}, 500);
	}
}

function startSlider() {
	updateSliderPosition(false);
	if (totalSlides > 1) {
		setInterval(nextSlide, 5000);
	}
}

function updateSliderPosition(animate = true) {
	const offset = -currentIndex * containerWidth.offsetWidth;

	if (!animate) {
		slider.style.transition = 'none';
	} else {
		slider.style.transition = 'transform 0.5s ease-in-out';
	}
	slider.style.transform = `translateX(${offset}px)`;
}

document.addEventListener('DOMContentLoaded', function () {
	if (containerWidth) {
		const firstClone = slides[0].cloneNode(true);
		const lastClone = slides[slides.length - 1].cloneNode(true);

		slider.appendChild(firstClone);
		slider.insertBefore(lastClone, slides[0]);

		if (slides.length > 1) {
			startSlider();
		}
	}
});

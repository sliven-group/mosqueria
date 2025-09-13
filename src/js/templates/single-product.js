import Swiper from 'swiper';
import { Navigation, Scrollbar } from 'swiper/modules';

window.addEventListener('load', function () {
	const color = document.getElementById('variation-color');
	const gallery = this.document.getElementById('mos-modal-gallery');
	const galleryOpen = document.querySelectorAll('.item-gallery');
	const galleryClose = document.querySelector('.mos__modal__gallery__close');
	const iconZoom = document.querySelector('.mos__zoom-img');
	const itemsSwiper = document.querySelectorAll('.mos__modal__gallery .swiper-slide');
	const breakpoint = window.matchMedia('(min-width:768px)');
	const galleryCarrouselId = document.getElementById('mos-prod-gallery');

	let galleryCarrousel;
	let isDragging = false;
	let startX = 0;
	let startY = 0;
	let translateX = 0;
	let translateY = 0;
	let activeImg = null;

	function breakpointChecker() {
		if (breakpoint.matches === true) {
			if (galleryCarrousel !== undefined && document.body.contains(galleryCarrouselId)) {
				galleryCarrousel.destroy(true, true);
			}
		} else {
			return enableSwiper();
		}
	}

	function enableSwiper() {
		galleryCarrousel = new Swiper(galleryCarrouselId, {
			modules: [Scrollbar],
			slidesPerView: 1,
			spaceBetween: 0,
			watchOverflow: true,
			scrollbar: {
				el: '.swiper-scrollbar',
				hide: false,
				draggable: true,
			},
			/*pagination: {
				el: '.swiper-pagination',
				clickable: true
			},*/
			on: {
				resize: function () {
					if (breakpoint.matches === true) {
						galleryCarrouselId.destroy(true, true);
					}
				},
			},
		});
	}

	const carrousel = new Swiper('.mos__modal__gallery .swiper', {
		modules: [Navigation],
		slidesPerView: 'auto',
		disableOnInteraction: false,
		pauseOnMouseEnter: false,
		spaceBetween: 0,
		loop: false,
		draggable: false,
		allowTouchMove: false,
		navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev',
		},
	});

	galleryOpen.forEach((item) => {
		item.addEventListener('click', function () {
			const index = item.getAttribute('data-slide');

			carrousel.slideTo(index);
			gallery.classList.add('active');
			setTimeout(() => {
				iconZoom.classList.add('hidden');
			}, 2000);
		});
	});

	if(galleryClose){
		galleryClose.addEventListener('click', function (e) {
			e.preventDefault();
			gallery.classList.remove('active');
			iconZoom.classList.remove('hidden');
		});
	}

	itemsSwiper.forEach((item) => {
		item.addEventListener('click', function () {
			const slide = carrousel.slides[carrousel.activeIndex];
			const img = slide.querySelector('img');

			if (!img) return;

			// Unzoom si ya estaba zoomed
			if (img.classList.contains('zoomed')) {
				img.classList.remove('zoomed');
				img.style.transform = '';
				img.style.transition = 'transform 0.3s ease';
				img.style.cursor = '';
				translateX = 0;
				translateY = 0;
				activeImg = null;
			} else {
				// Unzoom en todas las demás
				carrousel.slides.forEach((s) => {
					const otherImg = s.querySelector('img');

					if (otherImg) {
						otherImg.classList.remove('zoomed');
						otherImg.style.transform = '';
						otherImg.style.cursor = '';
					}
				});

				img.classList.add('zoomed');
				img.style.cursor = 'grab';
				img.style.transform = 'scale(2) translate(0px, 0px)';
				img.style.transition = 'transform 0.3s ease';

				translateX = 0;
				translateY = 0;
				activeImg = img;

				// Mouse Events
				img.addEventListener('mousedown', onMouseDown);
				document.addEventListener('mousemove', onMouseMove);
				document.addEventListener('mouseup', onMouseUp);

				// Touch Events
				img.addEventListener('touchstart', onTouchStart, { passive: false });
				document.addEventListener('touchmove', onTouchMove, { passive: false });
				document.addEventListener('touchend', onTouchEnd);
			}
		});
	});

	carrousel.on('slideChange', function () {
		carrousel.slides.forEach((slide) => {
			const img = slide.querySelector('img');

			if (!img) return;

			img.classList.remove('zoomed');
			img.style.transform = '';
			img.style.position = '';
			img.style.top = '';
			img.style.left = '';
			img.style.cursor = '';
		});

		// Reset drag state
		translateX = 0;
		translateY = 0;
		activeImg = null;
	});

	// Drag para mouse
	function onMouseDown(e) {
		if (!e.target.classList.contains('zoomed')) return;
		isDragging = true;
		startX = e.clientX;
		startY = e.clientY;
		activeImg = e.target;
		activeImg.style.cursor = 'grabbing';
	}

	function onMouseMove(e) {
		if (!isDragging || !activeImg) return;

		const dx = e.clientX - startX;
		const dy = e.clientY - startY;

		translateX += dx;
		translateY += dy;

		activeImg.style.transform = `scale(2) translate(${translateX}px, ${translateY}px)`;

		startX = e.clientX;
		startY = e.clientY;
	}

	function onMouseUp() {
		isDragging = false;
		if (activeImg) activeImg.style.cursor = 'grab';
	}

	// Drag para touch
	function onTouchStart(e) {
		if (!e.target.classList.contains('zoomed')) return;
		isDragging = true;
		const touch = e.touches[0];

		startX = touch.clientX;
		startY = touch.clientY;
		activeImg = e.target;
	}

	function onTouchMove(e) {
		if (!isDragging || !activeImg) return;
		const touch = e.touches[0];
		const dx = touch.clientX - startX;
		const dy = touch.clientY - startY;

		translateX += dx;
		translateY += dy;

		activeImg.style.transform = `scale(2) translate(${translateX}px, ${translateY}px)`;

		startX = touch.clientX;
		startY = touch.clientY;
	}

	function onTouchEnd() {
		isDragging = false;
	}

	if (color) {
		color.addEventListener('change', function () {
			const selectedOption = this.options[this.selectedIndex];
			const url = selectedOption.getAttribute('data-url');

			if (url) {
				window.location.href = url;
			}
		});
	}

	breakpoint.addListener(breakpointChecker);
	breakpointChecker();
});

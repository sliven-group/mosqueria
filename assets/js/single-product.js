"use strict";
(self["webpackChunkmosqueira"] = self["webpackChunkmosqueira"] || []).push([["/js/single-product"],{

/***/ "./src/js/templates/single-product.js":
/*!********************************************!*\
  !*** ./src/js/templates/single-product.js ***!
  \********************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var swiper__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! swiper */ "./node_modules/swiper/swiper.mjs");
/* harmony import */ var swiper_modules__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! swiper/modules */ "./node_modules/swiper/modules/index.mjs");


window.addEventListener('load', function () {
  var color = document.getElementById('variation-color');
  var gallery = this.document.getElementById('mos-modal-gallery');
  var galleryOpen = document.querySelectorAll('.item-gallery');
  var galleryClose = document.querySelector('.mos__modal__gallery__close');
  var iconZoom = document.querySelector('.mos__zoom-img');
  var itemsSwiper = document.querySelectorAll('.mos__modal__gallery .swiper-slide');
  var breakpoint = window.matchMedia('(min-width:768px)');
  var galleryCarrouselId = document.getElementById('mos-prod-gallery');
  var galleryCarrousel;
  var isDragging = false;
  var startX = 0;
  var startY = 0;
  var translateX = 0;
  var translateY = 0;
  var activeImg = null;
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
    galleryCarrousel = new swiper__WEBPACK_IMPORTED_MODULE_0__["default"](galleryCarrouselId, {
      modules: [swiper_modules__WEBPACK_IMPORTED_MODULE_1__.Scrollbar],
      slidesPerView: 1,
      spaceBetween: 0,
      watchOverflow: true,
      scrollbar: {
        el: '.swiper-scrollbar',
        hide: false,
        draggable: true
      },
      /*pagination: {
      	el: '.swiper-pagination',
      	clickable: true
      },*/
      on: {
        resize: function resize() {
          if (breakpoint.matches === true) {
            galleryCarrouselId.destroy(true, true);
          }
        }
      }
    });
  }
  var carrousel = new swiper__WEBPACK_IMPORTED_MODULE_0__["default"]('.mos__modal__gallery .swiper', {
    modules: [swiper_modules__WEBPACK_IMPORTED_MODULE_1__.Navigation],
    slidesPerView: 'auto',
    disableOnInteraction: false,
    pauseOnMouseEnter: false,
    spaceBetween: 0,
    loop: false,
    draggable: false,
    allowTouchMove: false,
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev'
    }
  });
  galleryOpen.forEach(function (item) {
    item.addEventListener('click', function () {
      var index = item.getAttribute('data-slide');
      carrousel.slideTo(index);
      gallery.classList.add('active');
      setTimeout(function () {
        iconZoom.classList.add('hidden');
      }, 2000);
    });
  });
  if (galleryClose) {
    galleryClose.addEventListener('click', function (e) {
      e.preventDefault();
      gallery.classList.remove('active');
      iconZoom.classList.remove('hidden');
    });
  }
  itemsSwiper.forEach(function (item) {
    item.addEventListener('click', function () {
      var slide = carrousel.slides[carrousel.activeIndex];
      var img = slide.querySelector('img');
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
        carrousel.slides.forEach(function (s) {
          var otherImg = s.querySelector('img');
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
        img.addEventListener('touchstart', onTouchStart, {
          passive: false
        });
        document.addEventListener('touchmove', onTouchMove, {
          passive: false
        });
        document.addEventListener('touchend', onTouchEnd);
      }
    });
  });
  carrousel.on('slideChange', function () {
    carrousel.slides.forEach(function (slide) {
      var img = slide.querySelector('img');
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
    var dx = e.clientX - startX;
    var dy = e.clientY - startY;
    translateX += dx;
    translateY += dy;
    activeImg.style.transform = "scale(2) translate(".concat(translateX, "px, ").concat(translateY, "px)");
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
    var touch = e.touches[0];
    startX = touch.clientX;
    startY = touch.clientY;
    activeImg = e.target;
  }
  function onTouchMove(e) {
    if (!isDragging || !activeImg) return;
    var touch = e.touches[0];
    var dx = touch.clientX - startX;
    var dy = touch.clientY - startY;
    translateX += dx;
    translateY += dy;
    activeImg.style.transform = "scale(2) translate(".concat(translateX, "px, ").concat(translateY, "px)");
    startX = touch.clientX;
    startY = touch.clientY;
  }
  function onTouchEnd() {
    isDragging = false;
  }
  if (color) {
    color.addEventListener('change', function () {
      var selectedOption = this.options[this.selectedIndex];
      var url = selectedOption.getAttribute('data-url');
      if (url) {
        window.location.href = url;
      }
    });
  }
  breakpoint.addListener(breakpointChecker);
  breakpointChecker();
});

/***/ })

},
/******/ function(__webpack_require__) { // webpackRuntimeModules
/******/ var __webpack_exec__ = function(moduleId) { return __webpack_require__(__webpack_require__.s = moduleId); }
/******/ __webpack_require__.O(0, ["/js/vendor"], function() { return __webpack_exec__("./src/js/templates/single-product.js"); });
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=single-product.js.map
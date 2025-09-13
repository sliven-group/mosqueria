(self["webpackChunkmosqueira"] = self["webpackChunkmosqueira"] || []).push([["/js/info-accordion"],{

/***/ "./src/js/blocks/info-accordion.js":
/*!*****************************************!*\
  !*** ./src/js/blocks/info-accordion.js ***!
  \*****************************************/
/***/ (function() {

document.addEventListener('DOMContentLoaded', function () {
  var items = document.querySelectorAll('.mos__block__ia .item');
  items.forEach(function (item) {
    var header = item.querySelector('.item__header');
    header.addEventListener('click', function () {
      var isActive = item.classList.contains('active');
      items.forEach(function (i) {
        i.classList.remove('active');
      });
      if (!isActive) {
        item.classList.add('active');
      }
    });
  });
});

/***/ })

},
/******/ function(__webpack_require__) { // webpackRuntimeModules
/******/ var __webpack_exec__ = function(moduleId) { return __webpack_require__(__webpack_require__.s = moduleId); }
/******/ var __webpack_exports__ = (__webpack_exec__("./src/js/blocks/info-accordion.js"));
/******/ }
]);
//# sourceMappingURL=info-accordion.js.map
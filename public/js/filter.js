/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!********************************!*\
  !*** ./resources/js/filter.js ***!
  \********************************/
console.log("loaded");
var filterButtons = document.getElementsByClassName("filterButton");

var filterStyles = function filterStyles() {
  Array.from(filterButtons).forEach(function (filterButton) {
    filterButton.classList.remove("activeFilter");
  });
  this.classList.add("activeFilter");
  var filter = this.getAttribute("data-filter");
  var episodes = document.getElementsByClassName('episode');
  Array.from(episodes).forEach(function (episode) {
    episode.classList.remove("hidden");

    if (filter == "all") {
      return;
    }

    var style = episode.getAttribute("data-style");

    if (style != filter) {
      episode.classList.add("hidden");
    }
  });
};

Array.from(filterButtons).forEach(function (filterButton) {
  filterButton.addEventListener('click', filterStyles);
});
/******/ })()
;
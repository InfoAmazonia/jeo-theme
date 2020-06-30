/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./assets/javascript/app.js":
/*!**********************************!*\
  !*** ./assets/javascript/app.js ***!
  \**********************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("(function ($) {\n  $(document).ready(function () {\n    if ($('.single .featured-image-behind').length) {\n      $('.featured-image-behind .image-info i').click(function () {\n        $('.featured-image-behind .image-info-container').toggleClass('active');\n        $('.featured-image-behind .image-info i').toggleClass('fa-info-circle fa-times-circle ');\n      });\n    }\n\n    $(window).scroll(function () {\n      var headerHeight = $('.middle-header-contain').height(); // console.log(headerHeight);\n\n      if ($(this).scrollTop() > headerHeight) {\n        $('.bottom-header-contain').addClass(\"fixed-header\");\n      } else {\n        $('.bottom-header-contain').removeClass(\"fixed-header\");\n      }\n    });\n  });\n})(jQuery);//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvamF2YXNjcmlwdC9hcHAuanM/NmUyOSJdLCJuYW1lcyI6WyIkIiwiZG9jdW1lbnQiLCJyZWFkeSIsImxlbmd0aCIsImNsaWNrIiwidG9nZ2xlQ2xhc3MiLCJ3aW5kb3ciLCJzY3JvbGwiLCJoZWFkZXJIZWlnaHQiLCJoZWlnaHQiLCJzY3JvbGxUb3AiLCJhZGRDbGFzcyIsInJlbW92ZUNsYXNzIiwialF1ZXJ5Il0sIm1hcHBpbmdzIjoiQUFBQSxDQUFDLFVBQVVBLENBQVYsRUFBYTtBQUNWQSxHQUFDLENBQUNDLFFBQUQsQ0FBRCxDQUFZQyxLQUFaLENBQWtCLFlBQVk7QUFDMUIsUUFBR0YsQ0FBQyxDQUFDLGdDQUFELENBQUQsQ0FBb0NHLE1BQXZDLEVBQStDO0FBQzNDSCxPQUFDLENBQUMsc0NBQUQsQ0FBRCxDQUEwQ0ksS0FBMUMsQ0FBZ0QsWUFBVztBQUN2REosU0FBQyxDQUFDLDhDQUFELENBQUQsQ0FBa0RLLFdBQWxELENBQThELFFBQTlEO0FBQ0FMLFNBQUMsQ0FBQyxzQ0FBRCxDQUFELENBQTBDSyxXQUExQyxDQUFzRCxpQ0FBdEQ7QUFDSCxPQUhEO0FBSUg7O0FBRURMLEtBQUMsQ0FBQ00sTUFBRCxDQUFELENBQVVDLE1BQVYsQ0FBaUIsWUFBWTtBQUN6QixVQUFJQyxZQUFZLEdBQUdSLENBQUMsQ0FBQyx3QkFBRCxDQUFELENBQTRCUyxNQUE1QixFQUFuQixDQUR5QixDQUV6Qjs7QUFDQSxVQUFJVCxDQUFDLENBQUMsSUFBRCxDQUFELENBQVFVLFNBQVIsS0FBc0JGLFlBQTFCLEVBQXdDO0FBQ3BDUixTQUFDLENBQUMsd0JBQUQsQ0FBRCxDQUE0QlcsUUFBNUIsQ0FBcUMsY0FBckM7QUFDSCxPQUZELE1BRU87QUFDSFgsU0FBQyxDQUFDLHdCQUFELENBQUQsQ0FBNEJZLFdBQTVCLENBQXdDLGNBQXhDO0FBQ0g7QUFDSixLQVJEO0FBU0gsR0FqQkQ7QUFrQkgsQ0FuQkQsRUFtQkdDLE1BbkJIIiwiZmlsZSI6Ii4vYXNzZXRzL2phdmFzY3JpcHQvYXBwLmpzLmpzIiwic291cmNlc0NvbnRlbnQiOlsiKGZ1bmN0aW9uICgkKSB7XG4gICAgJChkb2N1bWVudCkucmVhZHkoZnVuY3Rpb24gKCkge1xuICAgICAgICBpZigkKCcuc2luZ2xlIC5mZWF0dXJlZC1pbWFnZS1iZWhpbmQnKS5sZW5ndGgpIHtcbiAgICAgICAgICAgICQoJy5mZWF0dXJlZC1pbWFnZS1iZWhpbmQgLmltYWdlLWluZm8gaScpLmNsaWNrKGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgICAgICQoJy5mZWF0dXJlZC1pbWFnZS1iZWhpbmQgLmltYWdlLWluZm8tY29udGFpbmVyJykudG9nZ2xlQ2xhc3MoJ2FjdGl2ZScpO1xuICAgICAgICAgICAgICAgICQoJy5mZWF0dXJlZC1pbWFnZS1iZWhpbmQgLmltYWdlLWluZm8gaScpLnRvZ2dsZUNsYXNzKCdmYS1pbmZvLWNpcmNsZSBmYS10aW1lcy1jaXJjbGUgJyk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfVxuXG4gICAgICAgICQod2luZG93KS5zY3JvbGwoZnVuY3Rpb24gKCkge1xuICAgICAgICAgICAgdmFyIGhlYWRlckhlaWdodCA9ICQoJy5taWRkbGUtaGVhZGVyLWNvbnRhaW4nKS5oZWlnaHQoKTtcbiAgICAgICAgICAgIC8vIGNvbnNvbGUubG9nKGhlYWRlckhlaWdodCk7XG4gICAgICAgICAgICBpZiAoJCh0aGlzKS5zY3JvbGxUb3AoKSA+IGhlYWRlckhlaWdodCkge1xuICAgICAgICAgICAgICAgICQoJy5ib3R0b20taGVhZGVyLWNvbnRhaW4nKS5hZGRDbGFzcyhcImZpeGVkLWhlYWRlclwiKTtcbiAgICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAgICAgJCgnLmJvdHRvbS1oZWFkZXItY29udGFpbicpLnJlbW92ZUNsYXNzKFwiZml4ZWQtaGVhZGVyXCIpO1xuICAgICAgICAgICAgfVxuICAgICAgICB9KTtcbiAgICB9KTtcbn0pKGpRdWVyeSk7XG4iXSwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///./assets/javascript/app.js\n");

/***/ }),

/***/ "./assets/scss/app.scss":
/*!******************************!*\
  !*** ./assets/scss/app.scss ***!
  \******************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("// removed by extract-text-webpack-plugin//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvc2Nzcy9hcHAuc2Nzcz8wYzNkIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiJBQUFBIiwiZmlsZSI6Ii4vYXNzZXRzL3Njc3MvYXBwLnNjc3MuanMiLCJzb3VyY2VzQ29udGVudCI6WyIvLyByZW1vdmVkIGJ5IGV4dHJhY3QtdGV4dC13ZWJwYWNrLXBsdWdpbiJdLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./assets/scss/app.scss\n");

/***/ }),

/***/ 0:
/*!***************************************************************!*\
  !*** multi ./assets/javascript/app.js ./assets/scss/app.scss ***!
  \***************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /home/isaquemelo/Documents/jeo-theme/themes/jeo-theme/assets/javascript/app.js */"./assets/javascript/app.js");
module.exports = __webpack_require__(/*! /home/isaquemelo/Documents/jeo-theme/themes/jeo-theme/assets/scss/app.scss */"./assets/scss/app.scss");


/***/ })

/******/ });
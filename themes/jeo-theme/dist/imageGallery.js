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
/******/ 	__webpack_require__.p = ".//dist";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./assets/javascript/blocks/imageGallery/index.js":
/*!********************************************************!*\
  !*** ./assets/javascript/blocks/imageGallery/index.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _toConsumableArray(arr) {
  return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread();
}

function _nonIterableSpread() {
  throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
}

function _unsupportedIterableToArray(o, minLen) {
  if (!o) return;
  if (typeof o === "string") return _arrayLikeToArray(o, minLen);
  var n = Object.prototype.toString.call(o).slice(8, -1);
  if (n === "Object" && o.constructor) n = o.constructor.name;
  if (n === "Map" || n === "Set") return Array.from(o);
  if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen);
}

function _iterableToArray(iter) {
  if (typeof Symbol !== "undefined" && Symbol.iterator in Object(iter)) return Array.from(iter);
}

function _arrayWithoutHoles(arr) {
  if (Array.isArray(arr)) return _arrayLikeToArray(arr);
}

function _arrayLikeToArray(arr, len) {
  if (len == null || len > arr.length) len = arr.length;

  for (var i = 0, arr2 = new Array(len); i < len; i++) {
    arr2[i] = arr[i];
  }

  return arr2;
}

var _wp$editor = wp.editor,
    MediaUpload = _wp$editor.MediaUpload,
    RichText = _wp$editor.RichText;
var Button = wp.components.Button;
var __ = wp.i18n.__;
var registerBlockType = wp.blocks.registerBlockType;
registerBlockType('jeo-theme/custom-image-gallery-block', {
  title: __('Image Gallery'),
  icon: 'format-gallery',
  category: 'common',
  keywords: [__('materialtheme'), __('photos'), __('images')],
  attributes: {
    galleryTitle: {
      type: 'string'
    },
    images: {
      type: 'array'
    },
    imagesDescriptions: {
      type: 'array'
    },
    imagesCredits: {
      type: 'array'
    }
  },
  edit: function edit(_ref) {
    var attributes = _ref.attributes,
        className = _ref.className,
        setAttributes = _ref.setAttributes;
    var _attributes$galleryTi = attributes.galleryTitle,
        galleryTitle = _attributes$galleryTi === void 0 ? "" : _attributes$galleryTi,
        _attributes$images = attributes.images,
        images = _attributes$images === void 0 ? [] : _attributes$images,
        _attributes$imagesDes = attributes.imagesDescriptions,
        imagesDescriptions = _attributes$imagesDes === void 0 ? [] : _attributes$imagesDes,
        _attributes$imagesCre = attributes.imagesCredits,
        imagesCredits = _attributes$imagesCre === void 0 ? [] : _attributes$imagesCre;
    console.log(attributes);
    images.forEach(function (element, index) {
      if (!imagesDescriptions[index]) {
        imagesDescriptions[index] = "";
      }

      if (!imagesCredits[index]) {
        imagesCredits[index] = "";
      }
    });

    var removeImage = function removeImage(removeImageIndex) {
      var newImages = images.filter(function (image, index) {
        if (index != removeImageIndex) {
          return image;
        }
      });
      imagesDescriptions.splice(removeImageIndex, 1);
      imagesCredits.splice(removeImageIndex, 1);
      setAttributes({
        images: newImages,
        imagesDescriptions: imagesDescriptions,
        imagesCredits: imagesCredits
      });
    };

    var displayImages = function displayImages(images) {
      //console.log(external_link_api); 
      return images.map(function (image, index) {
        //console.log(image);
        return /*#__PURE__*/React.createElement("div", {
          className: "gallery-item-container"
        }, /*#__PURE__*/React.createElement("img", {
          className: "gallery-item",
          src: image.url,
          key: image.id
        }), /*#__PURE__*/React.createElement(RichText, {
          tagName: "span",
          className: "description-field",
          value: imagesDescriptions[index],
          formattingControls: ['bold', 'italic'],
          onChange: function onChange(content) {
            setAttributes({
              imagesDescriptions: imagesDescriptions.map(function (item, i) {
                if (i == index) {
                  return content;
                } else {
                  return item;
                }
              })
            });
          },
          placeholder: __('Type here your description')
        }), /*#__PURE__*/React.createElement(RichText, {
          tagName: "span",
          className: "credit-field",
          value: imagesCredits[index],
          formattingControls: ['bold', 'italic'],
          onChange: function onChange(content) {
            setAttributes({
              imagesCredits: imagesCredits.map(function (item, i) {
                if (i == index) {
                  return content;
                } else {
                  return item;
                }
              })
            });
          },
          placeholder: __('Type the credits here')
        }), /*#__PURE__*/React.createElement("div", {
          className: "remove-item",
          onClick: function onClick() {
            return removeImage(index);
          }
        }, /*#__PURE__*/React.createElement("span", {
          "class": "dashicons dashicons-trash"
        })));
      });
    };

    return /*#__PURE__*/React.createElement("div", {
      className: "image-gallery"
    }, /*#__PURE__*/React.createElement(RichText, {
      tagName: "h2",
      className: "gallery-title",
      value: galleryTitle,
      formattingControls: ['bold', 'italic'],
      onChange: function onChange(galleryTitle) {
        setAttributes({
          galleryTitle: galleryTitle
        });
      },
      placeholder: __('Type a title')
    }), /*#__PURE__*/React.createElement("div", {
      className: "gallery-grid"
    }, displayImages(images), /*#__PURE__*/React.createElement(MediaUpload, {
      onSelect: function onSelect(media) {
        setAttributes({
          images: [].concat(_toConsumableArray(images), _toConsumableArray(media))
        });
      },
      type: "image",
      multiple: true,
      value: images,
      render: function render(_ref2) {
        var open = _ref2.open;
        return /*#__PURE__*/React.createElement("div", {
          className: "select-images-button is-button is-default is-large",
          onClick: open
        }, /*#__PURE__*/React.createElement("span", {
          "class": "dashicons dashicons-plus"
        }));
      }
    })));
  },
  save: function save(_ref3) {
    var attributes = _ref3.attributes;
    var _attributes$galleryTi2 = attributes.galleryTitle,
        galleryTitle = _attributes$galleryTi2 === void 0 ? "" : _attributes$galleryTi2,
        _attributes$images2 = attributes.images,
        images = _attributes$images2 === void 0 ? [] : _attributes$images2,
        _attributes$imagesDes2 = attributes.imagesDescriptions,
        imagesDescriptions = _attributes$imagesDes2 === void 0 ? [] : _attributes$imagesDes2,
        _attributes$imagesCre2 = attributes.imagesCredits,
        imagesCredits = _attributes$imagesCre2 === void 0 ? [] : _attributes$imagesCre2; //console.log(imagesDescriptions);

    var displayImages = function displayImages(images) {
      return images.map(function (image, index) {
        return /*#__PURE__*/React.createElement("div", {
          className: "gallery-item-container"
        }, /*#__PURE__*/React.createElement("img", {
          className: "gallery-item",
          key: images.id,
          src: image.url,
          alt: image.alt
        }), /*#__PURE__*/React.createElement("div", {
          "class": "image-meta"
        }, /*#__PURE__*/React.createElement("div", {
          "class": "image-description"
        }, " ", /*#__PURE__*/React.createElement(RichText.Content, {
          tagName: "span",
          value: imagesDescriptions[index]
        })), /*#__PURE__*/React.createElement("i", {
          "class": "fas fa-camera"
        }), /*#__PURE__*/React.createElement("div", {
          "class": "image-credit"
        }, " ", /*#__PURE__*/React.createElement(RichText.Content, {
          tagName: "span",
          value: imagesCredits[index]
        }))));
      });
    };

    return /*#__PURE__*/React.createElement("div", {
      className: "image-gallery"
    }, /*#__PURE__*/React.createElement("div", {
      className: "image-gallery-wrapper"
    }, /*#__PURE__*/React.createElement("div", {
      className: "gallery-title"
    }, /*#__PURE__*/React.createElement(RichText.Content, {
      tagName: "h2",
      value: galleryTitle
    })), /*#__PURE__*/React.createElement("div", {
      className: "actions"
    }, /*#__PURE__*/React.createElement("button", {
      action: "display-grid"
    }, /*#__PURE__*/React.createElement("i", {
      "class": "fas fa-th"
    })), /*#__PURE__*/React.createElement("button", {
      action: "fullsreen"
    }, /*#__PURE__*/React.createElement("i", {
      "class": "fas fa-expand"
    }))), /*#__PURE__*/React.createElement("div", {
      className: "gallery-grid",
      "data-total-slides": images.length
    }, displayImages(images))));
  }
});

/***/ }),

/***/ 2:
/*!**************************************************************!*\
  !*** multi ./assets/javascript/blocks/imageGallery/index.js ***!
  \**************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /home/pame/Documents/Hacklab/jeo-theme-final/jeo-theme/themes/jeo-theme/assets/javascript/blocks/imageGallery/index.js */"./assets/javascript/blocks/imageGallery/index.js");


/***/ })

/******/ });
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vd2VicGFjay9ib290c3RyYXAiLCJ3ZWJwYWNrOi8vLy4vYXNzZXRzL2phdmFzY3JpcHQvYmxvY2tzL2ltYWdlR2FsbGVyeS9pbmRleC5qcyJdLCJuYW1lcyI6WyJ3cCIsImVkaXRvciIsIk1lZGlhVXBsb2FkIiwiUmljaFRleHQiLCJCdXR0b24iLCJjb21wb25lbnRzIiwiX18iLCJpMThuIiwicmVnaXN0ZXJCbG9ja1R5cGUiLCJibG9ja3MiLCJ0aXRsZSIsImljb24iLCJjYXRlZ29yeSIsImtleXdvcmRzIiwiYXR0cmlidXRlcyIsImdhbGxlcnlUaXRsZSIsInR5cGUiLCJpbWFnZXMiLCJpbWFnZXNEZXNjcmlwdGlvbnMiLCJpbWFnZXNDcmVkaXRzIiwiZWRpdCIsImNsYXNzTmFtZSIsInNldEF0dHJpYnV0ZXMiLCJjb25zb2xlIiwicmVtb3ZlSW1hZ2UiLCJuZXdJbWFnZXMiLCJpbmRleCIsImRpc3BsYXlJbWFnZXMiLCJpbWFnZSIsImlkIiwiaSIsIm9wZW4iLCJzYXZlIiwiYWx0IiwibGVuZ3RoIl0sIm1hcHBpbmdzIjoiO1FBQUE7UUFDQTs7UUFFQTtRQUNBOztRQUVBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBOztRQUVBO1FBQ0E7O1FBRUE7UUFDQTs7UUFFQTtRQUNBO1FBQ0E7OztRQUdBO1FBQ0E7O1FBRUE7UUFDQTs7UUFFQTtRQUNBO1FBQ0E7UUFDQSwwQ0FBMEMsZ0NBQWdDO1FBQzFFO1FBQ0E7O1FBRUE7UUFDQTtRQUNBO1FBQ0Esd0RBQXdELGtCQUFrQjtRQUMxRTtRQUNBLGlEQUFpRCxjQUFjO1FBQy9EOztRQUVBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQSx5Q0FBeUMsaUNBQWlDO1FBQzFFLGdIQUFnSCxtQkFBbUIsRUFBRTtRQUNySTtRQUNBOztRQUVBO1FBQ0E7UUFDQTtRQUNBLDJCQUEyQiwwQkFBMEIsRUFBRTtRQUN2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TyxFQUF6QjtBQUFpQyxlQUFLLEVBQUdDLGFBQWE7QUFBdEQsVUFBM0IsQ0FISixDQVJKLENBREo7QUFIUixPQUNJLENBREo7QUFESjs7QUF5QkEsd0JBQ0k7QUFBSyxlQUFTLEVBQUM7QUFBZixvQkFDSTtBQUFLLGVBQVMsRUFBQztBQUFmLG9CQUNJO0FBQUssZUFBUyxFQUFDO0FBQWYsb0JBQ0ksb0JBQUMsUUFBRDtBQUFrQixhQUFPLEVBQXpCO0FBQStCLFdBQUssRUFBR0o7QUFBdkMsTUFESixDQURKLGVBSUk7QUFBSyxlQUFTLEVBQUM7QUFBZixvQkFDSTtBQUFRLFlBQU0sRUFBQztBQUFmLG9CQUNJO0FBQUcsZUFBTTtBQUFULE1BREosQ0FESixlQUtJO0FBQVEsWUFBTSxFQUFDO0FBQWYsb0JBQ0k7QUFBRyxlQUFNO0FBQVQsTUFESixDQUxKLENBSkosZUFjSTtBQUFLLGVBQVMsRUFBZDtBQUE4QiwyQkFBbUJFLE1BQU0sQ0FBQ2lCO0FBQXhELE9BQ0tQLGFBQWEsQ0FqQjlCLE1BaUI4QixDQURsQixDQWRKLENBREosQ0FESjtBQXVCSDtBQWhNcUQsQ0FBekMsQ0FBakJuQixDIiwiZmlsZSI6Ii9pbWFnZUdhbGxlcnkuanMiLCJzb3VyY2VzQ29udGVudCI6WyIgXHQvLyBUaGUgbW9kdWxlIGNhY2hlXG4gXHR2YXIgaW5zdGFsbGVkTW9kdWxlcyA9IHt9O1xuXG4gXHQvLyBUaGUgcmVxdWlyZSBmdW5jdGlvblxuIFx0ZnVuY3Rpb24gX193ZWJwYWNrX3JlcXVpcmVfXyhtb2R1bGVJZCkge1xuXG4gXHRcdC8vIENoZWNrIGlmIG1vZHVsZSBpcyBpbiBjYWNoZVxuIFx0XHRpZihpbnN0YWxsZWRNb2R1bGVzW21vZHVsZUlkXSkge1xuIFx0XHRcdHJldHVybiBpbnN0YWxsZWRNb2R1bGVzW21vZHVsZUlkXS5leHBvcnRzO1xuIFx0XHR9XG4gXHRcdC8vIENyZWF0ZSBhIG5ldyBtb2R1bGUgKGFuZCBwdXQgaXQgaW50byB0aGUgY2FjaGUpXG4gXHRcdHZhciBtb2R1bGUgPSBpbnN0YWxsZWRNb2R1bGVzW21vZHVsZUlkXSA9IHtcbiBcdFx0XHRpOiBtb2R1bGVJZCxcbiBcdFx0XHRsOiBmYWxzZSxcbiBcdFx0XHRleHBvcnRzOiB7fVxuIFx0XHR9O1xuXG4gXHRcdC8vIEV4ZWN1dGUgdGhlIG1vZHVsZSBmdW5jdGlvblxuIFx0XHRtb2R1bGVzW21vZHVsZUlkXS5jYWxsKG1vZHVsZS5leHBvcnRzLCBtb2R1bGUsIG1vZHVsZS5leHBvcnRzLCBfX3dlYnBhY2tfcmVxdWlyZV9fKTtcblxuIFx0XHQvLyBGbGFnIHRoZSBtb2R1bGUgYXMgbG9hZGVkXG4gXHRcdG1vZHVsZS5sID0gdHJ1ZTtcblxuIFx0XHQvLyBSZXR1cm4gdGhlIGV4cG9ydHMgb2YgdGhlIG1vZHVsZVxuIFx0XHRyZXR1cm4gbW9kdWxlLmV4cG9ydHM7XG4gXHR9XG5cblxuIFx0Ly8gZXhwb3NlIHRoZSBtb2R1bGVzIG9iamVjdCAoX193ZWJwYWNrX21vZHVsZXNfXylcbiBcdF9fd2VicGFja19yZXF1aXJlX18ubSA9IG1vZHVsZXM7XG5cbiBcdC8vIGV4cG9zZSB0aGUgbW9kdWxlIGNhY2hlXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLmMgPSBpbnN0YWxsZWRNb2R1bGVzO1xuXG4gXHQvLyBkZWZpbmUgZ2V0dGVyIGZ1bmN0aW9uIGZvciBoYXJtb255IGV4cG9ydHNcbiBcdF9fd2VicGFja19yZXF1aXJlX18uZCA9IGZ1bmN0aW9uKGV4cG9ydHMsIG5hbWUsIGdldHRlcikge1xuIFx0XHRpZighX193ZWJwYWNrX3JlcXVpcmVfXy5vKGV4cG9ydHMsIG5hbWUpKSB7XG4gXHRcdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsIG5hbWUsIHsgZW51bWVyYWJsZTogdHJ1ZSwgZ2V0OiBnZXR0ZXIgfSk7XG4gXHRcdH1cbiBcdH07XG5cbiBcdC8vIGRlZmluZSBfX2VzTW9kdWxlIG9uIGV4cG9ydHNcbiBcdF9fd2VicGFja19yZXF1aXJlX18uciA9IGZ1bmN0aW9uKGV4cG9ydHMpIHtcbiBcdFx0aWYodHlwZW9mIFN5bWJvbCAhPT0gJ3VuZGVmaW5lZCcgJiYgU3ltYm9sLnRvU3RyaW5nVGFnKSB7XG4gXHRcdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsIFN5bWJvbC50b1N0cmluZ1RhZywgeyB2YWx1ZTogJ01vZHVsZScgfSk7XG4gXHRcdH1cbiBcdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsICdfX2VzTW9kdWxlJywgeyB2YWx1ZTogdHJ1ZSB9KTtcbiBcdH07XG5cbiBcdC8vIGNyZWF0ZSBhIGZha2UgbmFtZXNwYWNlIG9iamVjdFxuIFx0Ly8gbW9kZSAmIDE6IHZhbHVlIGlzIGEgbW9kdWxlIGlkLCByZXF1aXJlIGl0XG4gXHQvLyBtb2RlICYgMjogbWVyZ2UgYWxsIHByb3BlcnRpZXMgb2YgdmFsdWUgaW50byB0aGUgbnNcbiBcdC8vIG1vZGUgJiA0OiByZXR1cm4gdmFsdWUgd2hlbiBhbHJlYWR5IG5zIG9iamVjdFxuIFx0Ly8gbW9kZSAmIDh8MTogYmVoYXZlIGxpa2UgcmVxdWlyZVxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy50ID0gZnVuY3Rpb24odmFsdWUsIG1vZGUpIHtcbiBcdFx0aWYobW9kZSAmIDEpIHZhbHVlID0gX193ZWJwYWNrX3JlcXVpcmVfXyh2YWx1ZSk7XG4gXHRcdGlmKG1vZGUgJiA4KSByZXR1cm4gdmFsdWU7XG4gXHRcdGlmKChtb2RlICYgNCkgJiYgdHlwZW9mIHZhbHVlID09PSAnb2JqZWN0JyAmJiB2YWx1ZSAmJiB2YWx1ZS5fX2VzTW9kdWxlKSByZXR1cm4gdmFsdWU7XG4gXHRcdHZhciBucyA9IE9iamVjdC5jcmVhdGUobnVsbCk7XG4gXHRcdF9fd2VicGFja19yZXF1aXJlX18ucihucyk7XG4gXHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShucywgJ2RlZmF1bHQnLCB7IGVudW1lcmFibGU6IHRydWUsIHZhbHVlOiB2YWx1ZSB9KTtcbiBcdFx0aWYobW9kZSAmIDIgJiYgdHlwZW9mIHZhbHVlICE9ICdzdHJpbmcnKSBmb3IodmFyIGtleSBpbiB2YWx1ZSkgX193ZWJwYWNrX3JlcXVpcmVfXy5kKG5zLCBrZXksIGZ1bmN0aW9uKGtleSkgeyByZXR1cm4gdmFsdWVba2V5XTsgfS5iaW5kKG51bGwsIGtleSkpO1xuIFx0XHRyZXR1cm4gbnM7XG4gXHR9O1xuXG4gXHQvLyBnZXREZWZhdWx0RXhwb3J0IGZ1bmN0aW9uIGZvciBjb21wYXRpYmlsaXR5IHdpdGggbm9uLWhhcm1vbnkgbW9kdWxlc1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5uID0gZnVuY3Rpb24obW9kdWxlKSB7XG4gXHRcdHZhciBnZXR0ZXIgPSBtb2R1bGUgJiYgbW9kdWxlLl9fZXNNb2R1bGUgP1xuIFx0XHRcdGZ1bmN0aW9uIGdldERlZmF1bHQoKSB7IHJldHVybiBtb2R1bGVbJ2RlZmF1bHQnXTsgfSA6XG4gXHRcdFx0ZnVuY3Rpb24gZ2V0TW9kdWxlRXhwb3J0cygpIHsgcmV0dXJuIG1vZHVsZTsgfTtcbiBcdFx0X193ZWJwYWNrX3JlcXVpcmVfXy5kKGdldHRlciwgJ2EnLCBnZXR0ZXIpO1xuIFx0XHRyZXR1cm4gZ2V0dGVyO1xuIFx0fTtcblxuIFx0Ly8gT2JqZWN0LnByb3RvdHlwZS5oYXNPd25Qcm9wZXJ0eS5jYWxsXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLm8gPSBmdW5jdGlvbihvYmplY3QsIHByb3BlcnR5KSB7IHJldHVybiBPYmplY3QucHJvdG90eXBlLmhhc093blByb3BlcnR5LmNhbGwob2JqZWN0LCBwcm9wZXJ0eSk7IH07XG5cbiBcdC8vIF9fd2VicGFja19wdWJsaWNfcGF0aF9fXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLnAgPSBcIi4vL2Rpc3RcIjtcblxuXG4gXHQvLyBMb2FkIGVudHJ5IG1vZHVsZSBhbmQgcmV0dXJuIGV4cG9ydHNcbiBcdHJldHVybiBfX3dlYnBhY2tfcmVxdWlyZV9fKF9fd2VicGFja19yZXF1aXJlX18ucyA9IDIpO1xuIiwiY29uc3QgeyBNZWRpYVVwbG9hZCwgUmljaFRleHQgfSA9IHdwLmVkaXRvcjtcbmNvbnN0IHsgQnV0dG9uIH0gPSB3cC5jb21wb25lbnRzO1xuY29uc3QgeyBfXyB9ICAgICAgICAgICAgICAgID0gd3AuaTE4bjtcbmNvbnN0IHsgcmVnaXN0ZXJCbG9ja1R5cGUgfSA9IHdwLmJsb2NrcztcblxuXG5cblxuXG5yZWdpc3RlckJsb2NrVHlwZSgnamVvLXRoZW1lL2N1c3RvbS1pbWFnZS1nYWxsZXJ5LWJsb2NrJywge1xuICAgIHRpdGxlOiBfXygnSW1hZ2UgR2FsbGVyeScpLFxuICAgIGljb246ICdmb3JtYXQtZ2FsbGVyeScsXG4gICAgY2F0ZWdvcnk6ICdjb21tb24nLFxuICAgIGtleXdvcmRzOiBbXG4gICAgICAgIF9fKCdtYXRlcmlhbHRoZW1lJyksXG4gICAgICAgIF9fKCdwaG90b3MnKSxcbiAgICAgICAgX18oJ2ltYWdlcycpXG4gICAgXSxcbiAgICBhdHRyaWJ1dGVzOiB7XG4gICAgICAgIGdhbGxlcnlUaXRsZToge1xuICAgICAgICAgICAgdHlwZTogJ3N0cmluZycsXG4gICAgICAgIH0sXG5cbiAgICAgICAgaW1hZ2VzOiB7XG4gICAgICAgICAgICB0eXBlOiAnYXJyYXknLFxuICAgICAgICB9LCAgIFxuXG4gICAgICAgIGltYWdlc0Rlc2NyaXB0aW9uczoge1xuICAgICAgICAgICAgdHlwZTogJ2FycmF5JyxcbiAgICAgICAgfSxcblxuICAgICAgICBpbWFnZXNDcmVkaXRzOiB7XG4gICAgICAgICAgICB0eXBlOiAnYXJyYXknLFxuICAgICAgICB9XG4gICAgfSxcblxuICAgIGVkaXQoeyBhdHRyaWJ1dGVzLCBjbGFzc05hbWUsIHNldEF0dHJpYnV0ZXN9KSB7XG4gICAgICAgIGNvbnN0IHsgZ2FsbGVyeVRpdGxlID0gXCJcIiwgaW1hZ2VzID0gW10sIGltYWdlc0Rlc2NyaXB0aW9ucyA9IFtdLCBpbWFnZXNDcmVkaXRzID0gW10gfSA9IGF0dHJpYnV0ZXM7XG4gICAgICAgIGNvbnNvbGUubG9nKGF0dHJpYnV0ZXMpO1xuXG4gICAgICAgIGltYWdlcy5mb3JFYWNoKCAoZWxlbWVudCwgaW5kZXgpID0+IHtcbiAgICAgICAgICAgIGlmKCFpbWFnZXNEZXNjcmlwdGlvbnNbaW5kZXhdKSB7XG4gICAgICAgICAgICAgICAgaW1hZ2VzRGVzY3JpcHRpb25zW2luZGV4XSA9IFwiXCI7XG4gICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIGlmKCFpbWFnZXNDcmVkaXRzW2luZGV4XSkge1xuICAgICAgICAgICAgICAgIGltYWdlc0NyZWRpdHNbaW5kZXhdID0gXCJcIjtcbiAgICAgICAgICAgIH1cbiAgICAgICAgfSk7XG5cbiAgICAgICAgY29uc3QgcmVtb3ZlSW1hZ2UgPSAocmVtb3ZlSW1hZ2VJbmRleCkgPT4ge1xuICAgICAgICAgICAgY29uc3QgbmV3SW1hZ2VzID0gaW1hZ2VzLmZpbHRlcigoaW1hZ2UsIGluZGV4KSA9PiB7XG4gICAgICAgICAgICAgICAgaWYgKGluZGV4ICE9IHJlbW92ZUltYWdlSW5kZXgpIHtcbiAgICAgICAgICAgICAgICAgICAgcmV0dXJuIGltYWdlO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH0pO1xuXG4gICAgICAgICAgICBpbWFnZXNEZXNjcmlwdGlvbnMuc3BsaWNlKHJlbW92ZUltYWdlSW5kZXgsIDEpO1xuICAgICAgICAgICAgaW1hZ2VzQ3JlZGl0cy5zcGxpY2UocmVtb3ZlSW1hZ2VJbmRleCwgMSk7XG5cbiAgICAgICAgICAgIHNldEF0dHJpYnV0ZXMoe1xuICAgICAgICAgICAgICAgIGltYWdlczogbmV3SW1hZ2VzLFxuICAgICAgICAgICAgICAgIGltYWdlc0Rlc2NyaXB0aW9ucyxcbiAgICAgICAgICAgICAgICBpbWFnZXNDcmVkaXRzLFxuICAgICAgICAgICAgfSlcbiAgICAgICAgfVxuXG4gICAgICAgIGNvbnN0IGRpc3BsYXlJbWFnZXMgPSAoaW1hZ2VzKSA9PiB7XG4gICAgICAgICAgICBcbiAgICAgICAgICAgIC8vY29uc29sZS5sb2coZXh0ZXJuYWxfbGlua19hcGkpOyBcbiAgICAgICAgICAgIHJldHVybiAoXG4gICAgICAgICAgICAgICAgaW1hZ2VzLm1hcCgoaW1hZ2UsIGluZGV4KSA9PiB7XG4gICAgICAgICAgICAgICAgICAgIC8vY29uc29sZS5sb2coaW1hZ2UpO1xuICAgICAgICAgICAgICAgICAgICByZXR1cm4gKFxuICAgICAgICAgICAgICAgICAgICAgICAgPGRpdiBjbGFzc05hbWU9XCJnYWxsZXJ5LWl0ZW0tY29udGFpbmVyXCI+XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPGltZyBjbGFzc05hbWU9J2dhbGxlcnktaXRlbScgc3JjPXtpbWFnZS51cmx9IGtleT17aW1hZ2UuaWR9IC8+XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPFJpY2hUZXh0XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHRhZ05hbWU9XCJzcGFuXCJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgY2xhc3NOYW1lPVwiZGVzY3JpcHRpb24tZmllbGRcIlxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB2YWx1ZT17IGltYWdlc0Rlc2NyaXB0aW9uc1tpbmRleF0gfVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBmb3JtYXR0aW5nQ29udHJvbHM9eyBbICdib2xkJywgJ2l0YWxpYycgXSB9IFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBvbkNoYW5nZT17ICggY29udGVudCApID0+IHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHNldEF0dHJpYnV0ZXMoIHsgaW1hZ2VzRGVzY3JpcHRpb25zOiBpbWFnZXNEZXNjcmlwdGlvbnMubWFwKCAoaXRlbSwgaSkgPT4ge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGlmIChpID09IGluZGV4KSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHJldHVybiBjb250ZW50O1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHJldHVybiBpdGVtO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0pIH0gKVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9IH1cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgcGxhY2Vob2xkZXI9eyBfXyggJ1R5cGUgaGVyZSB5b3VyIGRlc2NyaXB0aW9uJyApIH0gXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLz5cblxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxSaWNoVGV4dFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB0YWdOYW1lPVwic3BhblwiXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNsYXNzTmFtZT1cImNyZWRpdC1maWVsZFwiXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHZhbHVlPXsgaW1hZ2VzQ3JlZGl0c1tpbmRleF0gfVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBmb3JtYXR0aW5nQ29udHJvbHM9eyBbICdib2xkJywgJ2l0YWxpYycgXSB9IFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBvbkNoYW5nZT17ICggY29udGVudCApID0+IHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHNldEF0dHJpYnV0ZXMoIHsgaW1hZ2VzQ3JlZGl0czogaW1hZ2VzQ3JlZGl0cy5tYXAoIChpdGVtLCBpKSA9PiB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgaWYgKGkgPT0gaW5kZXgpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgcmV0dXJuIGNvbnRlbnQ7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgcmV0dXJuIGl0ZW07XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfSkgfSApXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0gfVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBwbGFjZWhvbGRlcj17IF9fKCAnVHlwZSB0aGUgY3JlZGl0cyBoZXJlJyApIH0gXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLz5cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8ZGl2IGNsYXNzTmFtZT0ncmVtb3ZlLWl0ZW0nIG9uQ2xpY2s9eygpID0+IHJlbW92ZUltYWdlKGluZGV4KX0+PHNwYW4gY2xhc3M9XCJkYXNoaWNvbnMgZGFzaGljb25zLXRyYXNoXCI+PC9zcGFuPjwvZGl2PlxuICAgICAgICAgICAgICAgICAgICAgICAgPC9kaXY+XG4gICAgICAgICAgICAgICAgICAgIClcbiAgICAgICAgICAgICAgICB9KVxuXG4gICAgICAgICAgICApXG4gICAgICAgIH1cblxuICAgICAgICByZXR1cm4gKFxuICAgICAgICAgICAgPGRpdiBjbGFzc05hbWU9XCJpbWFnZS1nYWxsZXJ5XCI+XG4gICAgICAgICAgICAgICAgPFJpY2hUZXh0XG4gICAgICAgICAgICAgICAgICAgIHRhZ05hbWU9XCJoMlwiXG4gICAgICAgICAgICAgICAgICAgIGNsYXNzTmFtZT1cImdhbGxlcnktdGl0bGVcIlxuICAgICAgICAgICAgICAgICAgICB2YWx1ZT17IGdhbGxlcnlUaXRsZSB9XG4gICAgICAgICAgICAgICAgICAgIGZvcm1hdHRpbmdDb250cm9scz17IFsgJ2JvbGQnLCAnaXRhbGljJyBdIH0gXG4gICAgICAgICAgICAgICAgICAgIG9uQ2hhbmdlPXsgKCBnYWxsZXJ5VGl0bGUgKSA9PiB7XG4gICAgICAgICAgICAgICAgICAgICAgICBzZXRBdHRyaWJ1dGVzKCB7IGdhbGxlcnlUaXRsZSB9IClcbiAgICAgICAgICAgICAgICAgICAgfSB9XG4gICAgICAgICAgICAgICAgICAgIHBsYWNlaG9sZGVyPXsgX18oICdUeXBlIGEgdGl0bGUnICkgfSBcbiAgICAgICAgICAgICAgICAvPlxuICAgICAgICAgICAgICAgIDxkaXYgY2xhc3NOYW1lPVwiZ2FsbGVyeS1ncmlkXCI+XG4gICAgICAgICAgICAgICAgICAgIHtkaXNwbGF5SW1hZ2VzKGltYWdlcyl9XG4gICAgICAgICAgICAgICAgICAgIDxNZWRpYVVwbG9hZFxuICAgICAgICAgICAgICAgICAgICAgICAgb25TZWxlY3Q9eyhtZWRpYSkgPT4geyBzZXRBdHRyaWJ1dGVzKHsgaW1hZ2VzOiBbLi4uaW1hZ2VzLCAuLi5tZWRpYV0gfSk7IH19XG4gICAgICAgICAgICAgICAgICAgICAgICB0eXBlPVwiaW1hZ2VcIlxuICAgICAgICAgICAgICAgICAgICAgICAgbXVsdGlwbGU9e3RydWV9XG4gICAgICAgICAgICAgICAgICAgICAgICB2YWx1ZT17aW1hZ2VzfVxuICAgICAgICAgICAgICAgICAgICAgICAgcmVuZGVyPXsoeyBvcGVuIH0pID0+IChcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8ZGl2IGNsYXNzTmFtZT1cInNlbGVjdC1pbWFnZXMtYnV0dG9uIGlzLWJ1dHRvbiBpcy1kZWZhdWx0IGlzLWxhcmdlXCIgb25DbGljaz17b3Blbn0+XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxzcGFuIGNsYXNzPVwiZGFzaGljb25zIGRhc2hpY29ucy1wbHVzXCI+PC9zcGFuPlxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDwvZGl2PlxuICAgICAgICAgICAgICAgICAgICAgICAgKX1cbiAgICAgICAgICAgICAgICAgICAgLz5cbiAgICAgICAgICAgICAgICA8L2Rpdj5cblxuICAgICAgICAgICAgPC9kaXY+XG5cbiAgICAgICAgKTtcbiAgICB9LFxuXG4gICAgc2F2ZTogKHsgYXR0cmlidXRlcyB9KSA9PiB7XG4gICAgICAgIGNvbnN0IHsgZ2FsbGVyeVRpdGxlID0gXCJcIiwgaW1hZ2VzID0gW10sIGltYWdlc0Rlc2NyaXB0aW9ucyA9IFtdLCBpbWFnZXNDcmVkaXRzID0gW10gfSA9IGF0dHJpYnV0ZXM7XG4gICAgICAgIC8vY29uc29sZS5sb2coaW1hZ2VzRGVzY3JpcHRpb25zKTtcblxuICAgICAgICBjb25zdCBkaXNwbGF5SW1hZ2VzID0gKGltYWdlcykgPT4ge1xuICAgICAgICAgICAgcmV0dXJuIChcbiAgICAgICAgICAgICAgICBpbWFnZXMubWFwKChpbWFnZSwgaW5kZXgpID0+IHtcblxuICAgICAgICAgICAgICAgICAgICByZXR1cm4gKFxuICAgICAgICAgICAgICAgICAgICAgICAgPGRpdiBjbGFzc05hbWU9XCJnYWxsZXJ5LWl0ZW0tY29udGFpbmVyXCI+XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPGltZ1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBjbGFzc05hbWU9J2dhbGxlcnktaXRlbSdcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAga2V5PXtpbWFnZXMuaWR9XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHNyYz17aW1hZ2UudXJsfVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBhbHQ9e2ltYWdlLmFsdH1cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAvPlxuXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPGRpdiBjbGFzcz1cImltYWdlLW1ldGFcIj5cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgPGRpdiBjbGFzcz1cImltYWdlLWRlc2NyaXB0aW9uXCI+IDxSaWNoVGV4dC5Db250ZW50IHRhZ05hbWU9XCJzcGFuXCIgdmFsdWU9eyBpbWFnZXNEZXNjcmlwdGlvbnNbaW5kZXhdIH0gLz48L2Rpdj5cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgPGkgY2xhc3M9XCJmYXMgZmEtY2FtZXJhXCI+PC9pPlxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA8ZGl2IGNsYXNzPVwiaW1hZ2UtY3JlZGl0XCI+IDxSaWNoVGV4dC5Db250ZW50IHRhZ05hbWU9XCJzcGFuXCIgdmFsdWU9eyBpbWFnZXNDcmVkaXRzW2luZGV4XSB9IC8+PC9kaXY+XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPC9kaXY+XG5cbiAgICAgICAgICAgICAgICAgICAgICAgIDwvZGl2PlxuICAgICAgICAgICAgICAgICAgICApXG4gICAgICAgICAgICAgICAgfSlcbiAgICAgICAgICAgIClcbiAgICAgICAgfVxuXG4gICAgICAgIHJldHVybiAoXG4gICAgICAgICAgICA8ZGl2IGNsYXNzTmFtZT1cImltYWdlLWdhbGxlcnlcIj5cbiAgICAgICAgICAgICAgICA8ZGl2IGNsYXNzTmFtZT1cImltYWdlLWdhbGxlcnktd3JhcHBlclwiPlxuICAgICAgICAgICAgICAgICAgICA8ZGl2IGNsYXNzTmFtZT1cImdhbGxlcnktdGl0bGVcIj5cbiAgICAgICAgICAgICAgICAgICAgICAgIDxSaWNoVGV4dC5Db250ZW50IHRhZ05hbWU9XCJoMlwiIHZhbHVlPXsgZ2FsbGVyeVRpdGxlIH0gLz5cbiAgICAgICAgICAgICAgICAgICAgPC9kaXY+XG4gICAgICAgICAgICAgICAgICAgIDxkaXYgY2xhc3NOYW1lPVwiYWN0aW9uc1wiPlxuICAgICAgICAgICAgICAgICAgICAgICAgPGJ1dHRvbiBhY3Rpb249XCJkaXNwbGF5LWdyaWRcIj5cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8aSBjbGFzcz1cImZhcyBmYS10aFwiPjwvaT5cbiAgICAgICAgICAgICAgICAgICAgICAgIDwvYnV0dG9uPlxuXG4gICAgICAgICAgICAgICAgICAgICAgICA8YnV0dG9uIGFjdGlvbj1cImZ1bGxzcmVlblwiPlxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxpIGNsYXNzPVwiZmFzIGZhLWV4cGFuZFwiPjwvaT5cbiAgICAgICAgICAgICAgICAgICAgICAgIDwvYnV0dG9uPlxuICAgICAgICAgICAgICAgICAgICA8L2Rpdj5cblxuICAgICAgICAgICAgICAgICAgICA8ZGl2IGNsYXNzTmFtZT1cImdhbGxlcnktZ3JpZFwiIGRhdGEtdG90YWwtc2xpZGVzPXtpbWFnZXMubGVuZ3RofT5cbiAgICAgICAgICAgICAgICAgICAgICAgIHtkaXNwbGF5SW1hZ2VzKGltYWdlcyl9XG4gICAgICAgICAgICAgICAgICAgIDwvZGl2PlxuICAgICAgICAgICAgICAgIDwvZGl2PlxuICAgICAgICAgICAgPC9kaXY+XG4gICAgICAgICk7XG5cbiAgICB9LFxufSk7Il0sInNvdXJjZVJvb3QiOiIifQ==
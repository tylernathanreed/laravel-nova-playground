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
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
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
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports) {

/* globals __VUE_SSR_CONTEXT__ */

// IMPORTANT: Do NOT use ES2015 features in this file.
// This module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle.

module.exports = function normalizeComponent (
  rawScriptExports,
  compiledTemplate,
  functionalTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier /* server only */
) {
  var esModule
  var scriptExports = rawScriptExports = rawScriptExports || {}

  // ES6 modules interop
  var type = typeof rawScriptExports.default
  if (type === 'object' || type === 'function') {
    esModule = rawScriptExports
    scriptExports = rawScriptExports.default
  }

  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (compiledTemplate) {
    options.render = compiledTemplate.render
    options.staticRenderFns = compiledTemplate.staticRenderFns
    options._compiled = true
  }

  // functional template
  if (functionalTemplate) {
    options.functional = true
  }

  // scopedId
  if (scopeId) {
    options._scopeId = scopeId
  }

  var hook
  if (moduleIdentifier) { // server build
    hook = function (context) {
      // 2.3 injection
      context =
        context || // cached call
        (this.$vnode && this.$vnode.ssrContext) || // stateful
        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional
      // 2.2 with runInNewContext: true
      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
        context = __VUE_SSR_CONTEXT__
      }
      // inject component styles
      if (injectStyles) {
        injectStyles.call(this, context)
      }
      // register component module identifier for async chunk inferrence
      if (context && context._registeredComponents) {
        context._registeredComponents.add(moduleIdentifier)
      }
    }
    // used by ssr in case component is cached and beforeCreate
    // never gets called
    options._ssrRegister = hook
  } else if (injectStyles) {
    hook = injectStyles
  }

  if (hook) {
    var functional = options.functional
    var existing = functional
      ? options.render
      : options.beforeCreate

    if (!functional) {
      // inject component registration as beforeCreate hook
      options.beforeCreate = existing
        ? [].concat(existing, hook)
        : [hook]
    } else {
      // for template-only hot-reload because in that case the render fn doesn't
      // go through the normalizer
      options._injectStyles = hook
      // register for functioal component in vue file
      options.render = function renderWithStyleInjection (h, context) {
        hook.call(context)
        return existing(h, context)
      }
    }
  }

  return {
    esModule: esModule,
    exports: scriptExports,
    options: options
  }
}


/***/ }),
/* 1 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(2);
module.exports = __webpack_require__(8);


/***/ }),
/* 2 */
/***/ (function(module, exports, __webpack_require__) {

Nova.booting(function (Vue, router) {
    Vue.component('resource-table-row', __webpack_require__(3));
    Vue.component('resource-table-row-actions', __webpack_require__(6));
});

/***/ }),
/* 3 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(0)
/* script */
var __vue_script__ = __webpack_require__(4)
/* template */
var __vue_template__ = __webpack_require__(5)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/js/components/ResourceTableRow.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-14075ac5", Component.options)
  } else {
    hotAPI.reload("data-v-14075ac5", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 4 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
    props: ['testId', 'deleteResource', 'restoreResource', 'resource', 'resourcesSelected', 'resourceName', 'relationshipType', 'viaRelationship', 'viaResource', 'viaResourceId', 'viaManyToMany', 'checked', 'actionsAreAvailable', 'shouldShowCheckboxes', 'updateSelectionStatus'],

    data: function data() {
        return {
            deleteModalOpen: false,
            restoreModalOpen: false
        };
    },

    methods: {
        /**
         * Select the resource in the parent component
         */
        toggleSelection: function toggleSelection() {
            this.updateSelectionStatus(this.resource);
        },
        openDeleteModal: function openDeleteModal() {
            this.deleteModalOpen = true;
        },
        confirmDelete: function confirmDelete() {
            this.deleteResource(this.resource);
            this.closeDeleteModal();
        },
        closeDeleteModal: function closeDeleteModal() {
            this.deleteModalOpen = false;
        },
        openRestoreModal: function openRestoreModal() {
            this.restoreModalOpen = true;
        },
        confirmRestore: function confirmRestore() {
            this.restoreResource(this.resource);
            this.closeRestoreModal();
        },
        closeRestoreModal: function closeRestoreModal() {
            this.restoreModalOpen = false;
        }
    }
});

/***/ }),
/* 5 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "tr",
    { attrs: { dusk: _vm.resource["id"].value + "-row" } },
    [
      _c(
        "td",
        {
          class: {
            "w-16": _vm.shouldShowCheckboxes,
            "w-8": !_vm.shouldShowCheckboxes
          }
        },
        [
          _vm.shouldShowCheckboxes
            ? _c("checkbox", {
                attrs: {
                  "data-testid": _vm.testId + "-checkbox",
                  dusk: _vm.resource["id"].value + "-checkbox",
                  checked: _vm.checked
                },
                on: { input: _vm.toggleSelection }
              })
            : _vm._e()
        ],
        1
      ),
      _vm._v(" "),
      _vm._l(_vm.resource.fields, function(field) {
        return _c(
          "td",
          [
            _c("index-" + field.component, {
              tag: "component",
              class: "text-" + field.textAlign,
              attrs: {
                "resource-name": _vm.resourceName,
                "via-resource": _vm.viaResource,
                "via-resource-id": _vm.viaResourceId,
                field: field
              }
            })
          ],
          1
        )
      }),
      _vm._v(" "),
      _c(
        "td",
        { staticClass: "td-fit text-right pr-6" },
        [
          _c("resource-table-row-actions", {
            attrs: {
              "delete-resource": _vm.deleteResource,
              "restore-resource": _vm.restoreResource,
              resource: _vm.resource,
              "resource-name": _vm.resourceName,
              "relationship-type": _vm.relationshipType,
              "via-relationship": _vm.viaRelationship,
              "via-resource": _vm.viaResource,
              "via-resource-id": _vm.viaResourceId,
              "via-many-to-many": _vm.viaManyToMany
            }
          })
        ],
        1
      )
    ],
    2
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-14075ac5", module.exports)
  }
}

/***/ }),
/* 6 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(0)
/* script */
var __vue_script__ = __webpack_require__(13)
/* template */
var __vue_template__ = __webpack_require__(7)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/js/components/ResourceTableRowActions.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-68e11828", Component.options)
  } else {
    hotAPI.reload("data-v-68e11828", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 7 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _vm.resource.authorizedToView
        ? _c(
            "span",
            [
              _c(
                "router-link",
                {
                  staticClass: "cursor-pointer text-70 hover:text-primary mr-3",
                  attrs: {
                    "data-testid": _vm.testId + "-view-button",
                    dusk: _vm.resource["id"].value + "-view-button",
                    to: {
                      name: "detail",
                      params: {
                        resourceName: _vm.resourceName,
                        resourceId: _vm.resource["id"].value
                      }
                    },
                    title: _vm.__("View")
                  }
                },
                [
                  _c("icon", {
                    attrs: {
                      type: "view",
                      width: "22",
                      height: "18",
                      "view-box": "0 0 22 16"
                    }
                  })
                ],
                1
              )
            ],
            1
          )
        : _vm._e(),
      _vm._v(" "),
      _vm.resource.authorizedToUpdate
        ? _c(
            "span",
            [
              _vm.relationshipType == "belongsToMany" ||
              _vm.relationshipType == "morphToMany"
                ? _c(
                    "router-link",
                    {
                      staticClass:
                        "cursor-pointer text-70 hover:text-primary mr-3",
                      attrs: {
                        dusk:
                          _vm.resource["id"].value + "-edit-attached-button",
                        to: {
                          name: "edit-attached",
                          params: {
                            resourceName: _vm.viaResource,
                            resourceId: _vm.viaResourceId,
                            relatedResourceName: _vm.resourceName,
                            relatedResourceId: _vm.resource["id"].value
                          },
                          query: {
                            viaRelationship: _vm.viaRelationship
                          }
                        },
                        title: _vm.__("Edit Attached")
                      }
                    },
                    [_c("icon", { attrs: { type: "edit" } })],
                    1
                  )
                : _c(
                    "router-link",
                    {
                      staticClass:
                        "cursor-pointer text-70 hover:text-primary mr-3",
                      attrs: {
                        dusk: _vm.resource["id"].value + "-edit-button",
                        to: {
                          name: "edit",
                          params: {
                            resourceName: _vm.resourceName,
                            resourceId: _vm.resource["id"].value
                          },
                          query: {
                            viaResource: _vm.viaResource,
                            viaResourceId: _vm.viaResourceId,
                            viaRelationship: _vm.viaRelationship
                          }
                        },
                        title: _vm.__("Edit")
                      }
                    },
                    [_c("icon", { attrs: { type: "edit" } })],
                    1
                  )
            ],
            1
          )
        : _vm._e(),
      _vm._v(" "),
      _vm.resource.authorizedToDelete &&
      (!_vm.resource.softDeleted || _vm.viaManyToMany)
        ? _c(
            "button",
            {
              staticClass:
                "appearance-none cursor-pointer text-70 hover:text-primary mr-3",
              attrs: {
                "data-testid": _vm.testId + "-delete-button",
                dusk: _vm.resource["id"].value + "-delete-button",
                title: _vm.__(_vm.viaManyToMany ? "Detach" : "Delete")
              },
              on: {
                click: function($event) {
                  $event.preventDefault()
                  return _vm.openDeleteModal($event)
                }
              }
            },
            [_c("icon")],
            1
          )
        : _vm._e(),
      _vm._v(" "),
      _vm.resource.authorizedToRestore &&
      _vm.resource.softDeleted &&
      !_vm.viaManyToMany
        ? _c(
            "button",
            {
              staticClass:
                "appearance-none cursor-pointer text-70 hover:text-primary mr-3",
              attrs: {
                dusk: _vm.resource["id"].value + "-restore-button",
                title: _vm.__("Restore")
              },
              on: {
                click: function($event) {
                  $event.preventDefault()
                  return _vm.openRestoreModal($event)
                }
              }
            },
            [
              _c("icon", {
                attrs: { type: "restore", with: "20", height: "21" }
              })
            ],
            1
          )
        : _vm._e(),
      _vm._v(" "),
      _c(
        "portal",
        { attrs: { to: "modals" } },
        [
          _c(
            "transition",
            { attrs: { name: "fade" } },
            [
              _vm.deleteModalOpen
                ? _c("delete-resource-modal", {
                    attrs: { mode: _vm.viaManyToMany ? "detach" : "delete" },
                    on: {
                      confirm: _vm.confirmDelete,
                      close: _vm.closeDeleteModal
                    },
                    scopedSlots: _vm._u([
                      {
                        key: "default",
                        fn: function(ref) {
                          var uppercaseMode = ref.uppercaseMode
                          var mode = ref.mode
                          return _c(
                            "div",
                            { staticClass: "p-8" },
                            [
                              _c(
                                "heading",
                                { staticClass: "mb-6", attrs: { level: 2 } },
                                [
                                  _vm._v(
                                    _vm._s(_vm.__(uppercaseMode + " Resource"))
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "p",
                                { staticClass: "text-80 leading-normal" },
                                [
                                  _vm._v(
                                    _vm._s(
                                      _vm.__(
                                        "Are you sure you want to " +
                                          mode +
                                          " this resource?"
                                      )
                                    )
                                  )
                                ]
                              )
                            ],
                            1
                          )
                        }
                      }
                    ])
                  })
                : _vm._e()
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "transition",
            { attrs: { name: "fade" } },
            [
              _vm.restoreModalOpen
                ? _c(
                    "restore-resource-modal",
                    {
                      on: {
                        confirm: _vm.confirmRestore,
                        close: _vm.closeRestoreModal
                      }
                    },
                    [
                      _c(
                        "div",
                        { staticClass: "p-8" },
                        [
                          _c(
                            "heading",
                            { staticClass: "mb-6", attrs: { level: 2 } },
                            [_vm._v(_vm._s(_vm.__("Restore Resource")))]
                          ),
                          _vm._v(" "),
                          _c("p", { staticClass: "text-80 leading-normal" }, [
                            _vm._v(
                              _vm._s(
                                _vm.__(
                                  "Are you sure you want to restore this resource?"
                                )
                              )
                            )
                          ])
                        ],
                        1
                      )
                    ]
                  )
                : _vm._e()
            ],
            1
          )
        ],
        1
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-68e11828", module.exports)
  }
}

/***/ }),
/* 8 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 9 */,
/* 10 */,
/* 11 */,
/* 12 */,
/* 13 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
    props: ['testId', 'deleteResource', 'restoreResource', 'resource', 'resourcesSelected', 'resourceName', 'relationshipType', 'viaRelationship', 'viaResource', 'viaResourceId', 'viaManyToMany', 'checked', 'actionsAreAvailable', 'shouldShowCheckboxes', 'updateSelectionStatus'],

    data: function data() {
        return {
            deleteModalOpen: false,
            restoreModalOpen: false
        };
    },

    methods: {
        /**
         * Select the resource in the parent component
         */
        toggleSelection: function toggleSelection() {
            this.updateSelectionStatus(this.resource);
        },
        openDeleteModal: function openDeleteModal() {
            this.deleteModalOpen = true;
        },
        confirmDelete: function confirmDelete() {
            this.deleteResource(this.resource);
            this.closeDeleteModal();
        },
        closeDeleteModal: function closeDeleteModal() {
            this.deleteModalOpen = false;
        },
        openRestoreModal: function openRestoreModal() {
            this.restoreModalOpen = true;
        },
        confirmRestore: function confirmRestore() {
            this.restoreResource(this.resource);
            this.closeRestoreModal();
        },
        closeRestoreModal: function closeRestoreModal() {
            this.restoreModalOpen = false;
        }
    }
});

/***/ })
/******/ ]);
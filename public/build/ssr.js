"use strict";
var __defProp = Object.defineProperty;
var __defProps = Object.defineProperties;
var __getOwnPropDescs = Object.getOwnPropertyDescriptors;
var __getOwnPropSymbols = Object.getOwnPropertySymbols;
var __hasOwnProp = Object.prototype.hasOwnProperty;
var __propIsEnum = Object.prototype.propertyIsEnumerable;
var __defNormalProp = (obj, key, value) => key in obj ? __defProp(obj, key, { enumerable: true, configurable: true, writable: true, value }) : obj[key] = value;
var __spreadValues = (a, b) => {
  for (var prop in b || (b = {}))
    if (__hasOwnProp.call(b, prop))
      __defNormalProp(a, prop, b[prop]);
  if (__getOwnPropSymbols)
    for (var prop of __getOwnPropSymbols(b)) {
      if (__propIsEnum.call(b, prop))
        __defNormalProp(a, prop, b[prop]);
    }
  return a;
};
var __spreadProps = (a, b) => __defProps(a, __getOwnPropDescs(b));
var vue = require("vue");
var serverRenderer$1 = require("@vue/server-renderer");
var inertiaVue3 = require("@inertiajs/inertia-vue3");
var createServer = require("@inertiajs/server");
var qs = require("qs");
var serverRenderer = require("vue/server-renderer");
function _interopDefaultLegacy(e) {
  return e && typeof e === "object" && "default" in e ? e : { "default": e };
}
var createServer__default = /* @__PURE__ */ _interopDefaultLegacy(createServer);
class Route {
  constructor(name, definition, config) {
    var _a, _b;
    this.name = name;
    this.definition = definition;
    this.bindings = (_a = definition.bindings) != null ? _a : {};
    this.wheres = (_b = definition.wheres) != null ? _b : {};
    this.config = config;
  }
  get template() {
    const origin = !this.config.absolute ? "" : this.definition.domain ? `${this.config.url.match(/^\w+:\/\//)[0]}${this.definition.domain}${this.config.port ? `:${this.config.port}` : ""}` : this.config.url;
    return `${origin}/${this.definition.uri}`.replace(/\/+$/, "");
  }
  get parameterSegments() {
    var _a, _b;
    return (_b = (_a = this.template.match(/{[^}?]+\??}/g)) == null ? void 0 : _a.map((segment) => ({
      name: segment.replace(/{|\??}/g, ""),
      required: !/\?}$/.test(segment)
    }))) != null ? _b : [];
  }
  matchesUrl(url) {
    if (!this.definition.methods.includes("GET"))
      return false;
    const pattern = this.template.replace(/(\/?){([^}?]*)(\??)}/g, (_, slash, segment, optional) => {
      var _a;
      const regex = `(?<${segment}>${((_a = this.wheres[segment]) == null ? void 0 : _a.replace(/(^\^)|(\$$)/g, "")) || "[^/?]+"})`;
      return optional ? `(${slash}${regex})?` : `${slash}${regex}`;
    }).replace(/^\w+:\/\//, "");
    const [location, query] = url.replace(/^\w+:\/\//, "").split("?");
    const matches = new RegExp(`^${pattern}/?$`).exec(location);
    return matches ? { params: matches.groups, query: qs.parse(query) } : false;
  }
  compile(params) {
    const segments = this.parameterSegments;
    if (!segments.length)
      return this.template;
    return this.template.replace(/{([^}?]+)(\??)}/g, (_, segment, optional) => {
      var _a, _b, _c;
      if (!optional && [null, void 0].includes(params[segment])) {
        throw new Error(`Ziggy error: '${segment}' parameter is required for route '${this.name}'.`);
      }
      if (segments[segments.length - 1].name === segment && this.wheres[segment] === ".*") {
        return encodeURIComponent((_a = params[segment]) != null ? _a : "").replace(/%2F/g, "/");
      }
      if (this.wheres[segment] && !new RegExp(`^${optional ? `(${this.wheres[segment]})?` : this.wheres[segment]}$`).test((_b = params[segment]) != null ? _b : "")) {
        throw new Error(`Ziggy error: '${segment}' parameter does not match required format '${this.wheres[segment]}' for route '${this.name}'.`);
      }
      return encodeURIComponent((_c = params[segment]) != null ? _c : "");
    }).replace(/\/+$/, "");
  }
}
class Router extends String {
  constructor(name, params, absolute = true, config) {
    super();
    this._config = config != null ? config : typeof Ziggy !== "undefined" ? Ziggy : globalThis == null ? void 0 : globalThis.Ziggy;
    this._config = __spreadProps(__spreadValues({}, this._config), { absolute });
    if (name) {
      if (!this._config.routes[name]) {
        throw new Error(`Ziggy error: route '${name}' is not in the route list.`);
      }
      this._route = new Route(name, this._config.routes[name], this._config);
      this._params = this._parse(params);
    }
  }
  toString() {
    const unhandled = Object.keys(this._params).filter((key) => !this._route.parameterSegments.some(({ name }) => name === key)).filter((key) => key !== "_query").reduce((result, current) => __spreadProps(__spreadValues({}, result), { [current]: this._params[current] }), {});
    return this._route.compile(this._params) + qs.stringify(__spreadValues(__spreadValues({}, unhandled), this._params["_query"]), {
      addQueryPrefix: true,
      arrayFormat: "indices",
      encodeValuesOnly: true,
      skipNulls: true,
      encoder: (value, encoder) => typeof value === "boolean" ? Number(value) : encoder(value)
    });
  }
  _unresolve(url) {
    if (!url) {
      url = this._currentUrl();
    } else if (this._config.absolute && url.startsWith("/")) {
      url = this._location().host + url;
    }
    let matchedParams = {};
    const [name, route2] = Object.entries(this._config.routes).find(([name2, route3]) => matchedParams = new Route(name2, route3, this._config).matchesUrl(url)) || [void 0, void 0];
    return __spreadProps(__spreadValues({ name }, matchedParams), { route: route2 });
  }
  _currentUrl() {
    const { host, pathname, search } = this._location();
    return (this._config.absolute ? host + pathname : pathname.replace(this._config.url.replace(/^\w*:\/\/[^/]+/, ""), "").replace(/^\/+/, "/")) + search;
  }
  current(name, params) {
    const { name: current, params: currentParams, query, route: route2 } = this._unresolve();
    if (!name)
      return current;
    const match = new RegExp(`^${name.replace(/\./g, "\\.").replace(/\*/g, ".*")}$`).test(current);
    if ([null, void 0].includes(params) || !match)
      return match;
    const routeObject = new Route(current, route2, this._config);
    params = this._parse(params, routeObject);
    const routeParams = __spreadValues(__spreadValues({}, currentParams), query);
    if (Object.values(params).every((p) => !p) && !Object.values(routeParams).some((v) => v !== void 0))
      return true;
    return Object.entries(params).every(([key, value]) => routeParams[key] == value);
  }
  _location() {
    var _a, _b, _c, _d, _e, _f;
    const { host = "", pathname = "", search = "" } = typeof window !== "undefined" ? window.location : {};
    return {
      host: (_b = (_a = this._config.location) == null ? void 0 : _a.host) != null ? _b : host,
      pathname: (_d = (_c = this._config.location) == null ? void 0 : _c.pathname) != null ? _d : pathname,
      search: (_f = (_e = this._config.location) == null ? void 0 : _e.search) != null ? _f : search
    };
  }
  get params() {
    const { params, query } = this._unresolve();
    return __spreadValues(__spreadValues({}, params), query);
  }
  has(name) {
    return Object.keys(this._config.routes).includes(name);
  }
  _parse(params = {}, route2 = this._route) {
    params = ["string", "number"].includes(typeof params) ? [params] : params;
    const segments = route2.parameterSegments.filter(({ name }) => !this._config.defaults[name]);
    if (Array.isArray(params)) {
      params = params.reduce((result, current, i) => segments[i] ? __spreadProps(__spreadValues({}, result), { [segments[i].name]: current }) : typeof current === "object" ? __spreadValues(__spreadValues({}, result), current) : __spreadProps(__spreadValues({}, result), { [current]: "" }), {});
    } else if (segments.length === 1 && !params[segments[0].name] && (params.hasOwnProperty(Object.values(route2.bindings)[0]) || params.hasOwnProperty("id"))) {
      params = { [segments[0].name]: params };
    }
    return __spreadValues(__spreadValues({}, this._defaults(route2)), this._substituteBindings(params, route2));
  }
  _defaults(route2) {
    return route2.parameterSegments.filter(({ name }) => this._config.defaults[name]).reduce((result, { name }, i) => __spreadProps(__spreadValues({}, result), { [name]: this._config.defaults[name] }), {});
  }
  _substituteBindings(params, { bindings, parameterSegments }) {
    return Object.entries(params).reduce((result, [key, value]) => {
      if (!value || typeof value !== "object" || Array.isArray(value) || !parameterSegments.some(({ name }) => name === key)) {
        return __spreadProps(__spreadValues({}, result), { [key]: value });
      }
      if (!value.hasOwnProperty(bindings[key])) {
        if (value.hasOwnProperty("id")) {
          bindings[key] = "id";
        } else {
          throw new Error(`Ziggy error: object passed as '${key}' parameter is missing route model binding key '${bindings[key]}'.`);
        }
      }
      return __spreadProps(__spreadValues({}, result), { [key]: value[bindings[key]] });
    }, {});
  }
  valueOf() {
    return this.toString();
  }
  check(name) {
    return this.has(name);
  }
}
function route(name, params, absolute, config) {
  const router = new Router(name, params, absolute, config);
  return name ? router.toString() : router;
}
const ZiggyVue = {
  install: (v, options) => {
    const r = (name, params, absolute, config = options) => route(name, params, absolute, config);
    v.mixin({
      methods: {
        route: r
      }
    });
    if (parseInt(v.version) > 2) {
      v.provide("route", r);
    }
  }
};
const Ziggy$1 = { "url": "http://laravel.test", "port": null, "defaults": {}, "routes": { "ignition.healthCheck": { "uri": "_ignition/health-check", "methods": ["GET", "HEAD"] }, "ignition.executeSolution": { "uri": "_ignition/execute-solution", "methods": ["POST"] }, "ignition.updateConfig": { "uri": "_ignition/update-config", "methods": ["POST"] }, "index": { "uri": "/", "methods": ["GET", "HEAD"] }, "about": { "uri": "about", "methods": ["GET", "HEAD"] }, "contact": { "uri": "contact", "methods": ["POST"] } } };
if (typeof window !== "undefined" && typeof window.Ziggy !== "undefined") {
  Object.assign(Ziggy$1.routes, window.Ziggy.routes);
}
var _export_sfc = (sfc, props) => {
  const target = sfc.__vccOpts || sfc;
  for (const [key, val] of props) {
    target[key] = val;
  }
  return target;
};
const _sfc_main$2 = {};
function _sfc_ssrRender(_ctx, _push, _parent, _attrs) {
  _push(`<div${serverRenderer.ssrRenderAttrs(vue.mergeProps({ class: "container mx-auto" }, _attrs))}>`);
  serverRenderer.ssrRenderSlot(_ctx.$slots, "default", {}, null, _push, _parent);
  _push(`</div>`);
}
const _sfc_setup$2 = _sfc_main$2.setup;
_sfc_main$2.setup = (props, ctx) => {
  const ssrContext = vue.useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/Layout/Layout.vue");
  return _sfc_setup$2 ? _sfc_setup$2(props, ctx) : void 0;
};
var Layout = /* @__PURE__ */ _export_sfc(_sfc_main$2, [["ssrRender", _sfc_ssrRender]]);
createServer__default["default"]((page) => inertiaVue3.createInertiaApp({
  page,
  render: serverRenderer$1.renderToString,
  resolve: (name) => {
    var _a;
    const pages = { "./Pages/About.vue": () => Promise.resolve().then(function() {
      return About;
    }), "./Pages/Welcome.vue": () => Promise.resolve().then(function() {
      return Welcome;
    }) };
    const page2 = pages[`./Pages/${name}.vue`]();
    (_a = page2.layout) != null ? _a : page2.layout = Layout;
    return page2;
  },
  setup({ app, props, plugin }) {
    return vue.createSSRApp({
      render: () => vue.h(app, props)
    }).use(plugin).use(ZiggyVue, Ziggy$1);
  }
}));
const _sfc_main$1 = {
  name: "About",
  __ssrInlineRender: true,
  setup(__props) {
    const form = inertiaVue3.useForm({
      email: "",
      name: "",
      message: ""
    });
    vue.inject("route");
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<!--[-->`);
      _push(serverRenderer.ssrRenderComponent(vue.unref(inertiaVue3.Head), { title: "About" }, null, _parent));
      _push(`<div class="flex flex-col justify-center items-center"><h1>This is about page</h1><form><div><label>Email</label><input type="email" class="form-input block"${serverRenderer.ssrRenderAttr("value", vue.unref(form).email)}>`);
      if (vue.unref(form).errors.email) {
        _push(`<div class="text-red-500">${serverRenderer.ssrInterpolate(vue.unref(form).errors.email)}</div>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div><div><label>Name</label><input type="text" class="form-input block"${serverRenderer.ssrRenderAttr("value", vue.unref(form).name)}>`);
      if (vue.unref(form).errors.name) {
        _push(`<div class="text-red-500">${serverRenderer.ssrInterpolate(vue.unref(form).errors.name)}</div>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div><div><label>Message</label><input type="text" class="form-input block"${serverRenderer.ssrRenderAttr("value", vue.unref(form).message)}>`);
      if (vue.unref(form).errors.message) {
        _push(`<div class="text-red-500">${serverRenderer.ssrInterpolate(vue.unref(form).errors.message)}</div>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div><button type="submit" class="btn btn-primary"${serverRenderer.ssrIncludeBooleanAttr(vue.unref(form).processing) ? " disabled" : ""}>Login</button></form></div>`);
      _push(serverRenderer.ssrRenderComponent(vue.unref(inertiaVue3.Link), {
        href: "/",
        class: "link"
      }, {
        default: vue.withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`Home page`);
          } else {
            return [
              vue.createTextVNode("Home page")
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(`<!--]-->`);
    };
  }
};
const _sfc_setup$1 = _sfc_main$1.setup;
_sfc_main$1.setup = (props, ctx) => {
  const ssrContext = vue.useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/About.vue");
  return _sfc_setup$1 ? _sfc_setup$1(props, ctx) : void 0;
};
var About = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  "default": _sfc_main$1
}, Symbol.toStringTag, { value: "Module" }));
const _sfc_main = {
  name: "Welcome",
  __ssrInlineRender: true,
  setup(__props) {
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<!--[-->`);
      _push(serverRenderer.ssrRenderComponent(vue.unref(inertiaVue3.Head), { title: "Welcome" }, null, _parent));
      _push(`<div class="text-center"><h1>Welcome to Laravel with Inertia and Vite</h1><h3>Let&#39;s get started!</h3>`);
      _push(serverRenderer.ssrRenderComponent(vue.unref(inertiaVue3.Link), {
        href: _ctx.route("about")
      }, {
        default: vue.withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`About`);
          } else {
            return [
              vue.createTextVNode("About")
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(`</div><!--]-->`);
    };
  }
};
const _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
  const ssrContext = vue.useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/Welcome.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
var Welcome = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  "default": _sfc_main
}, Symbol.toStringTag, { value: "Module" }));

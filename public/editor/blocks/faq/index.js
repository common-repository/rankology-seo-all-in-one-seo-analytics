! function() {
    "use strict";
    var e, t = {
            616: function() {
                var e = window.wp.components,
                    t = window.wp.blockEditor,
                    n = window.wp,
                    r = n.data.withSelect,
                    a = (n.element.Component, n.components),
                    s = a.Spinner,
                    i = a.Button,
                    o = (a.ResponsiveWrapper, n.compose.compose),
                    __ = n.i18n.__,
                    l = ["image"],
                    c = o(r((function(e, t) {
                        return {
                            image: t.value ? e("core").getMedia(t.value) : null
                        }
                    })))((function(e) {
                        var n = e.value,
                            r = e.image,
                            a = React.createElement("p", null, __("To edit the background image, you need permission to upload media.", "wp-rankology"));
                        return React.createElement("div", {
                            className: "wp-block-wp-rankology-image"
                        }, React.createElement(t.MediaUploadCheck, {
                            fallback: a
                        }, React.createElement(t.MediaUpload, {
                            title: __("Set Image", "wp-rankology"),
                            onSelect: function(t) {
                                e.onSelect(t.id, e.index)
                            },
                            allowedTypes: l,
                            value: n,
                            render: function(t) {
                                var a = t.open,
                                    o = function(t) {
                                        var n = null;
                                        try {
                                            if (null != t && ((n = {}).source_url = t.guid.raw, null != t.media_details.sizes)) switch (n = null, e.imageSize) {
                                                case "thumbnail":
                                                    n = null != t ? t.media_details.sizes.thumbnail : null;
                                                    break;
                                                case "medium":
                                                    n = null != t ? t.media_details.sizes.medium : null;
                                                    break;
                                                case "large":
                                                    n = null != t ? null != t.media_details.sizes.large ? t.media_details.sizes.large : t.media_details.sizes.medium_large : null;
                                                    break;
                                                default:
                                                    n = null != t ? t.media_details.sizes.full : null
                                            }
                                            return n
                                        } catch (e) {
                                            return n
                                        }
                                    }(r);
                                return React.createElement(i, {
                                    className: n ? "editor-post-featured-image__preview" : "editor-post-featured-image__toggle",
                                    onClick: a
                                }, !n && __("Set Image", "wp-rankology"), !!n && !r && React.createElement(s, null), !!n && r && o && o.source_url && React.createElement("img", {
                                    src: o.source_url,
                                    alt: __("Set Image", "wp-rankology")
                                }))
                            }
                        })), !!n && React.createElement(t.MediaUploadCheck, null, React.createElement(i, {
                            onClick: function() {
                                e.onRemoveImage(e.index)
                            },
                            isLink: !0,
                            isDestructive: !0
                        }, __("Remove Image", "wp-rankology"))))
                    }));

                function u(e, t) {
                    var n = Object.keys(e);
                    if (Object.getOwnPropertySymbols) {
                        var r = Object.getOwnPropertySymbols(e);
                        t && (r = r.filter((function(t) {
                            return Object.getOwnPropertyDescriptor(e, t).enumerable
                        }))), n.push.apply(n, r)
                    }
                    return n
                }

                function p(e) {
                    for (var t = 1; t < arguments.length; t++) {
                        var n = null != arguments[t] ? arguments[t] : {};
                        t % 2 ? u(Object(n), !0).forEach((function(t) {
                            m(e, t, n[t])
                        })) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(n)) : u(Object(n)).forEach((function(t) {
                            Object.defineProperty(e, t, Object.getOwnPropertyDescriptor(n, t))
                        }))
                    }
                    return e
                }

                function m(e, t, n) {
                    return t in e ? Object.defineProperty(e, t, {
                        value: n,
                        enumerable: !0,
                        configurable: !0,
                        writable: !0
                    }) : e[t] = n, e
                }

                function f(e, t) {
                    (null == t || t > e.length) && (t = e.length);
                    for (var n = 0, r = new Array(t); n < t; n++) r[n] = e[n];
                    return r
                }
                var d = wp.element.Fragment,
                    w = wp.i18n,
                    g = w.__,
                    _x = w._x,
                    b = (0, wp.compose.compose)((0, wp.data.withSelect)((function(e, t) {
                        var n = t.attributes,
                            r = e("core").getMedia,
                            a = n.selectedImageId;
                        return {
                            selectedImage: a ? r(a) : 0
                        }
                    })))((function(n) {
                        var r = n.attributes,
                            a = r.listStyle,
                            s = r.titleWrapper,
                            i = r.imageSize,
                            o = r.showFAQScheme,
                            l = r.showAccordion,
                            u = r.isProActive,
                            m = function() {
                                return "none" === r.listStyle && r.faqs.map((function(e, n) {
                                    return React.createElement("div", {
                                        key: n,
                                        className: "wprankology-faqs-area"
                                    }, React.createElement("div", {
                                        className: "wprankology-faq"
                                    }, React.createElement(t.RichText, {
                                        tagName: r.titleWrapper,
                                        className: "wprankology-faq-question",
                                        placeholder: g("Question...", "wp-rankology"),
                                        value: e ? e.question : "",
                                        onChange: function(e) {
                                            return b(e, n)
                                        }
                                    }), React.createElement("div", {
                                        className: "wprankology-answer-meta"
                                    }, React.createElement(c, {
                                        value: e ? e.image : "",
                                        onSelect: v,
                                        onRemoveImage: y,
                                        imageSize: r.imageSize,
                                        index: n
                                    }), React.createElement(t.RichText, {
                                        tagName: "p",
                                        className: "wprankology-faq-answer",
                                        placeholder: g("Answer...", "wp-rankology"),
                                        value: e ? e.answer : "",
                                        onChange: function(e) {
                                            return R(e, n)
                                        }
                                    }))), React.createElement("div", {
                                        className: "wprankology-faq-cta"
                                    }, React.createElement("button", {
                                        className: "components-button is-tertiary is-destructive",
                                        value: g("Remove", "wp-rankology"),
                                        onClick: function() {
                                            return w(n)
                                        }
                                    }, g("Remove", "wp-rankology"))))
                                })) || ("ul" === r.listStyle || "ol" === r.listStyle) && r.faqs.map((function(e, n) {
                                    return React.createElement("li", {
                                        key: n,
                                        className: "wprankology-faqs-area"
                                    }, React.createElement("div", {
                                        className: "wprankology-faq"
                                    }, React.createElement(t.RichText, {
                                        tagName: r.titleWrapper,
                                        className: "wprankology-faq-question",
                                        placeholder: g("Question...", "wp-rankology"),
                                        value: e ? e.question : "",
                                        onChange: function(e) {
                                            return b(e, n)
                                        }
                                    }), React.createElement("div", {
                                        className: "wprankology-answer-meta"
                                    }, React.createElement(c, {
                                        value: e ? e.image : "",
                                        onSelect: v,
                                        onRemoveImage: y,
                                        imageSize: r.imageSize,
                                        index: n
                                    }), React.createElement(t.RichText, {
                                        tagName: "div",
                                        className: "wprankology-faq-answer",
                                        placeholder: g("Answer...", "wp-rankology"),
                                        value: e ? e.answer : "",
                                        onChange: function(e) {
                                            return R(e, n)
                                        }
                                    }))), React.createElement("div", {
                                        className: "wprankology-faq-cta"
                                    }, React.createElement("button", {
                                        className: "components-button is-tertiary is-destructive",
                                        value: g("Remove", "wp-rankology"),
                                        onClick: function() {
                                            return w(n)
                                        }
                                    }, g("Remove", "wp-rankology"))))
                                }))
                            },
                            w = function(e) {
                                var t = r.faqs.filter((function(t, n) {
                                    return n !== e
                                }));
                                n.setAttributes({
                                    faqs: t
                                })
                            },
                            b = function(e, t) {
                                var a = r.faqs.map((function(n, r) {
                                    return r !== t ? n : p(p({}, n), {}, {
                                        question: e
                                    })
                                }));
                                n.setAttributes({
                                    faqs: a
                                })
                            },
                            R = function(e, t) {
                                var a = r.faqs.map((function(n, r) {
                                    return r !== t ? n : p(p({}, n), {}, {
                                        answer: e
                                    })
                                }));
                                n.setAttributes({
                                    faqs: a
                                })
                            },
                            v = function(e, t) {
                                var a = r.faqs.map((function(n, r) {
                                    return r !== t ? n : p(p({}, n), {}, {
                                        image: e
                                    })
                                }));
                                n.setAttributes({
                                    faqs: a
                                })
                            },
                            y = function(e) {
                                var t = r.faqs.map((function(t, n) {
                                    return n !== e ? t : p(p({}, t), {}, {
                                        image: null
                                    })
                                }));
                                n.setAttributes({
                                    faqs: t
                                })
                            },
                            E = React.createElement(t.InspectorControls, null, React.createElement(e.PanelBody, {
                                title: g("FAQ Settings", "wp-rankology")
                            }, React.createElement("p", null, g("List Style", "wp-rankology")), React.createElement(e.PanelRow, {
                                className: "wprankology-faqs-list-style"
                            }, React.createElement(e.ButtonGroup, null, React.createElement(e.Button, {
                                isSecondary: !0,
                                isPrimary: "none" == a,
                                onClick: function(e) {
                                    n.setAttributes({
                                        listStyle: "none"
                                    })
                                }
                            }, _x("NONE", "Div tag List", "wp-rankology")), React.createElement(e.Button, {
                                isSecondary: !0,
                                isPrimary: "ol" == a,
                                onClick: function(e) {
                                    n.setAttributes({
                                        listStyle: "ol"
                                    })
                                }
                            }, _x("OL", "Numbered List", "wp-rankology")), React.createElement(e.Button, {
                                isSecondary: !0,
                                isPrimary: "ul" == a,
                                onClick: function(e) {
                                    n.setAttributes({
                                        listStyle: "ul"
                                    })
                                }
                            }, _x("UL", "Unordered List", "wp-rankology")))), React.createElement("p", null, g("Title Wrapper", "wp-rankology")), React.createElement(e.PanelRow, {
                                className: "wprankology-faqs-title-wrapper"
                            }, React.createElement(e.ButtonGroup, null, React.createElement(e.Button, {
                                isSecondary: !0,
                                isPrimary: "h2" == s,
                                onClick: function(e) {
                                    n.setAttributes({
                                        titleWrapper: "h2"
                                    })
                                }
                            }, _x("H2", "H2 title tag", "wp-rankology")), React.createElement(e.Button, {
                                isSecondary: !0,
                                isPrimary: "h3" == s,
                                onClick: function(e) {
                                    n.setAttributes({
                                        titleWrapper: "h3"
                                    })
                                }
                            }, _x("H3", "H3 title tag", "wp-rankology")), React.createElement(e.Button, {
                                isSecondary: !0,
                                isPrimary: "h4" == s,
                                onClick: function(e) {
                                    n.setAttributes({
                                        titleWrapper: "h4"
                                    })
                                }
                            }, _x("H4", "H4 title tag", "wp-rankology")), React.createElement(e.Button, {
                                isSecondary: !0,
                                isPrimary: "h5" == s,
                                onClick: function(e) {
                                    n.setAttributes({
                                        titleWrapper: "h5"
                                    })
                                }
                            }, _x("H5", "H5 title tag", "wp-rankology")), React.createElement(e.Button, {
                                isSecondary: !0,
                                isPrimary: "h6" == s,
                                onClick: function(e) {
                                    n.setAttributes({
                                        titleWrapper: "h6"
                                    })
                                }
                            }, _x("H6", "H6 title tag", "wp-rankology")), React.createElement(e.Button, {
                                isSecondary: !0,
                                isPrimary: "p" == s,
                                onClick: function(e) {
                                    n.setAttributes({
                                        titleWrapper: "p"
                                    })
                                }
                            }, _x("P", "P title tag", "wp-rankology")), React.createElement(e.Button, {
                                isSecondary: !0,
                                isPrimary: "div" == s,
                                onClick: function(e) {
                                    n.setAttributes({
                                        titleWrapper: "div"
                                    })
                                }
                            }, _x("DIV", "DIV title tag", "wp-rankology")))), React.createElement("p", null, g("Image Size", "wp-rankology")), React.createElement(e.PanelRow, {
                                className: "wprankology-faqs-image-size"
                            }, React.createElement(e.ButtonGroup, null, React.createElement(e.Button, {
                                isSecondary: !0,
                                isPrimary: "thumbnail" == i,
                                onClick: function(e) {
                                    n.setAttributes({
                                        imageSize: "thumbnail"
                                    })
                                }
                            }, _x("S", "Thubmnail Size", "wp-rankology")), React.createElement(e.Button, {
                                isSecondary: !0,
                                isPrimary: "medium" == i,
                                onClick: function(e) {
                                    n.setAttributes({
                                        imageSize: "medium"
                                    })
                                }
                            }, _x("M", "Medium Size", "wp-rankology")), React.createElement(e.Button, {
                                isSecondary: !0,
                                isPrimary: "large" == i,
                                onClick: function(e) {
                                    n.setAttributes({
                                        imageSize: "large"
                                    })
                                }
                            }, _x("L", "Large Size", "wp-rankology")), React.createElement(e.Button, {
                                isSecondary: !0,
                                isPrimary: "full" == i,
                                onClick: function(e) {
                                    n.setAttributes({
                                        imageSize: "full"
                                    })
                                }
                            }, _x("XL", "Original Size", "wp-rankology")))), u && React.createElement(React.Fragment, null, React.createElement("p", null, g("SEO Settings", "wp-rankology")), React.createElement(e.PanelRow, null, React.createElement(e.ToggleControl, {
                                label: g("Enable FAQ Schema", "wp-rankology"),
                                checked: !!o,
                                onChange: function(e) {
                                    n.setAttributes({
                                        showFAQScheme: !o
                                    })
                                }
                            }))), React.createElement("p", null, g("Display", "wp-rankology")), React.createElement(e.PanelRow, null, React.createElement(e.ToggleControl, {
                                label: g("Enable accordion", "wp-rankology"),
                                checked: !!l,
                                onChange: function(e) {
                                    n.setAttributes({
                                        showAccordion: !l
                                    })
                                }
                            }))));
                        return React.createElement(d, null, E, React.createElement("div", {
                            className: "wprankology-faqs"
                        }, "ul" === a && React.createElement("ul", null, m()), "ol" === a && React.createElement("ol", null, m()), "none" === a && m(), React.createElement("div", {
                            className: "wprankology-faqs-actions"
                        }, React.createElement("button", {
                            type: "button",
                            title: g("Add FAQ", "wp-rankology"),
                            className: "add-faq components-button is-secondary",
                            onClick: function(e) {
                                var t;
                                e.preventDefault(), n.setAttributes({
                                    faqs: [].concat((t = r.faqs, function(e) {
                                        if (Array.isArray(e)) return f(e)
                                    }(t) || function(e) {
                                        if ("undefined" != typeof Symbol && null != e[Symbol.iterator] || null != e["@@iterator"]) return Array.from(e)
                                    }(t) || function(e, t) {
                                        if (e) {
                                            if ("string" == typeof e) return f(e, t);
                                            var n = Object.prototype.toString.call(e).slice(8, -1);
                                            return "Object" === n && e.constructor && (n = e.constructor.name), "Map" === n || "Set" === n ? Array.from(e) : "Arguments" === n || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n) ? f(e, t) : void 0
                                        }
                                    }(t) || function() {
                                        throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")
                                    }()), [{
                                        question: "",
                                        answer: "",
                                        image: ""
                                    }])
                                })
                            }
                        }, g("Add FAQ", "wp-rankology")))))
                    })),
                    R = window.wp.blocks,
                    v = window.wp.i18n;
                (0, R.registerBlockType)("wprankology/faq-block", {
                    title: (0, v.__)("FAQ", "wp-rankology"),
                    icon: "index-card",
                    category: "wprankology",
                    example: {},
                    edit: b,
                    save: function() {
                        return null
                    }
                })
            }
        },
        n = {};

    function r(e) {
        var a = n[e];
        if (void 0 !== a) return a.exports;
        var s = n[e] = {
            exports: {}
        };
        return t[e](s, s.exports, r), s.exports
    }
    r.m = t, e = [], r.O = function(t, n, a, s) {
            if (!n) {
                var i = 1 / 0;
                for (u = 0; u < e.length; u++) {
                    n = e[u][0], a = e[u][1], s = e[u][2];
                    for (var o = !0, l = 0; l < n.length; l++)(!1 & s || i >= s) && Object.keys(r.O).every((function(e) {
                        return r.O[e](n[l])
                    })) ? n.splice(l--, 1) : (o = !1, s < i && (i = s));
                    if (o) {
                        e.splice(u--, 1);
                        var c = a();
                        void 0 !== c && (t = c)
                    }
                }
                return t
            }
            s = s || 0;
            for (var u = e.length; u > 0 && e[u - 1][2] > s; u--) e[u] = e[u - 1];
            e[u] = [n, a, s]
        }, r.o = function(e, t) {
            return Object.prototype.hasOwnProperty.call(e, t)
        },
        function() {
            var e = {
                826: 0,
                431: 0
            };
            r.O.j = function(t) {
                return 0 === e[t]
            };
            var t = function(t, n) {
                    var a, s, i = n[0],
                        o = n[1],
                        l = n[2],
                        c = 0;
                    if (i.some((function(t) {
                            return 0 !== e[t]
                        }))) {
                        for (a in o) r.o(o, a) && (r.m[a] = o[a]);
                        if (l) var u = l(r)
                    }
                    for (t && t(n); c < i.length; c++) s = i[c], r.o(e, s) && e[s] && e[s][0](), e[s] = 0;
                    return r.O(u)
                },
                n = self.webpackChunkwp_rankology = self.webpackChunkwp_rankology || [];
            n.forEach(t.bind(null, 0)), n.push = t.bind(null, n.push.bind(n))
        }();
    var a = r.O(void 0, [431], (function() {
        return r(616)
    }));
    a = r.O(a)
}();
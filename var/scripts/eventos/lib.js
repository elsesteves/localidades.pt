/*https://cdn.viralagenda.com/lib/lib.js?v=337*/

! function() {
    var e = $("#viral-loader"),
        a = $("#viral-loader img");
    window.Loader = {
        show: function() {
            a.attr("src", e.find("img").attr("data-src")), e.show()
        },
        hide: function() {
            e.hide()
        },
        buttonLoader: function(e) {
            var a = e.width();
            e.width(a), e.find("span").hide(), e.addClass("btn-loader"), e.append('<span class="spinner"></span>')
        },
        removeButtonLoader: function(e) {
            e.find("span.spinner").remove(), e.removeClass("btn-loader"), setTimeout(function() {
                e.find("span").show()
            }, 500)
        }
    }
}(),
function() {
    var e = 1,
        a = !0,
        t = !1,
        n = function() {
            if (4 != init_account) {
                if (t) return void l.load();
                var e = document.createElement("script");
                e.type = "text/javascript", e.async = !0, e.src = "https://www.googletagservices.com/tag/js/gpt.js";
                var a = document.getElementsByTagName("script")[0];
                e.onload = function() {
                    l.load(), t = !0
                }, e.onerror = function() {
                    1 == init_account && (hasAdBlocker = !0, UI.isMobile() ? $(".event-full-googlead").remove() : l.loadAblockAds())
                }, a.parentNode.insertBefore(e, a);
                var n = document.createElement("script");
                n.onload = function() {
                    $("#jumbo-gad").length > 0 ? $("body").addClass("jumbo-adsense") : $("body").removeClass("jumbo-adsense")
                }, n.onerror = function() {
                    1 == init_account && (hasAdBlocker = !0, UI.isMobile() ? $(".event-full-googlead").remove() : l.loadAblockAds())
                }, n.src = cdn_url + "/lib/ads.js", 1 != init_account && 2 != init_account || document.head.appendChild(n)
            }
        },
        i = function() {
            if (!(init_account > 2)) return 1 == init_account && hasAdBlocker ? void l.loadAblockAds() : void googletag.cmd.push(function() {
                a && (googletag.pubads().enableSingleRequest(), googletag.enableServices(), a = !1), $(".adsbygoogle").not(".loaded").each(function() {
                    var e, a = $(this).attr("data-type");
                    if (1 == init_account) switch (a) {
                        case "mobile-list-thumb":
                            e = googletag.defineSlot("/312810430/Thumb_Mobile_PT", [300, 250]).addService(googletag.pubads());
                            break;
                        case "painel":
                            e = googletag.defineSlot("/312810430/PAINEL_PT", [970, 250]).addService(googletag.pubads());
                            break;
                        case "event-mrec-top-left":
                            e = googletag.defineSlot("/312810430/ERP/EVT_RECT_PT_TOP_LEFT", [300, 250]).addService(googletag.pubads());
                            break;
                        case "event-mrec-top-right":
                            e = googletag.defineSlot("/312810430/ERP/EVT_RECT_PT_TOP_RIGHT", [300, 250]).addService(googletag.pubads());
                            break;
                        case "event-mrec-bottom-right":
                            e = googletag.defineSlot("/312810430/ERP/EVT_RECT_PT_BOTTOM_RIGHT", [300, 250]).addService(googletag.pubads());
                            break;
                        case "event-mrec-bottom-left":
                            e = googletag.defineSlot("/312810430/ERP/EVT_RECT_PT_BOTTOM_LEFT", [300, 250]).addService(googletag.pubads());
                            break;
                        case "list-thumb":
                            e = googletag.defineSlot("/312810430/EVT_THUMB_PT", [300, 250]).addService(googletag.pubads());
                            break;
                        case "skyscraper":
                            e = googletag.defineSlot("/312810430/SKYSCRAPPER_PT", [300, 600]).addService(googletag.pubads());
                            break;
                        case "mobile-sticky":
                            e = googletag.defineSlot("/312810430/MOBILE_STICKY_PT", [
                                [320, 50],
                                [320, 100]
                            ]).addService(googletag.pubads())
                    }
                    if (2 == init_account) switch (a) {
                        case "mobile-list-thumb":
                            e = googletag.defineSlot("/312810430/Thumb_Mobile_CR", [300, 250]).addService(googletag.pubads());
                            break;
                        case "painel":
                            e = googletag.defineSlot("/312810430/Painel_CR", [970, 250]).addService(googletag.pubads());
                            break;
                        case "event-mrec-top-left":
                            e = googletag.defineSlot("/312810430/Event_Rectangles_CR/EVT_RECT_CR_TOP_LEFT", [300, 250]).addService(googletag.pubads());
                            break;
                        case "event-mrec-top-right":
                            e = googletag.defineSlot("/312810430/Event_Rectangles_CR/EVT_RECT_CR_TOP_RIGHT", [300, 250]).addService(googletag.pubads());
                            break;
                        case "event-mrec-bottom-right":
                            e = googletag.defineSlot("/312810430/Event_Rectangles_CR/EVT_RECT_CR_BOTTOM_RIGHT", [300, 250]).addService(googletag.pubads());
                            break;
                        case "event-mrec-bottom-left":
                            e = googletag.defineSlot("/312810430/Event_Rectangles_CR/EVT_RECT_CR_BOTTOM_LEFT", [300, 250]).addService(googletag.pubads());
                            break;
                        case "list-thumb":
                            e = googletag.defineSlot("/312810430/EVT_THUMB_CR", [300, 250]).addService(googletag.pubads());
                            break;
                        case "skyscraper":
                            e = googletag.defineSlot("/312810430/SKYSCRAPPER_CR", [300, 600]).addService(googletag.pubads())
                    }
                    var t = document.createElement("div");
                    t.id = e.getSlotElementId(), $(this).addClass("loaded"), this.appendChild(t), googletag.display(e)
                })
            })
        },
        o = function() {
            $(".viral-skyscrapper").show(), $(".viral-skyscrapper").html("<div data-type='skyscraper' class='adsbygoogle' style='height:600px; width:300px;'></div>"), r()
        },
        r = function() {
            1 != init_account && 2 != init_account || "undefined" != typeof googletag && googletag.cmd.push(function() {
                $(".adsbygoogle").not(".loaded").each(function() {
                    var e = googletag.defineSlot("/312810430/ERP/EVT_THUMB_PT", [300, 250]).addService(googletag.pubads()),
                        a = document.createElement("div");
                    a.id = e.getSlotElementId(), $(this).addClass("loaded"), this.appendChild(a), googletag.display(e)
                })
            })
        },
        s = function() {
            $('.adsbygoogle:not(".imgviral")').each(function() {
                var a, t = Math.floor(3 * Math.random() + 1);
                switch ($(this).attr("data-type")) {
                    case "painel":
                        a = '<img class="nojumbo" src="' + cdn_url + "/images/placeholders/painel-" + t + '.png" width="970" height="250"/>';
                        break;
                    case "rectangle":
                        a = '<img class="nojumbo" src="' + cdn_url + "/images/placeholders/rectangle-" + e + '.png" width="300" height="250"/>';
                        break;
                    case "list-thumb":
                    case "event-mrec-top-left":
                    case "event-mrec-top-right":
                    case "event-mrec-bottom-left":
                    case "event-mrec-bottom-right":
                        a = '<img class="nojumbo" src="' + cdn_url + "/images/placeholders/rectangle-" + e + '.png" style="margin-top:30px;" width="300" height="250"/>';
                        break;
                    case "skyscraper":
                        a = '<img class="nojumbo" src="' + cdn_url + "/images/placeholders/skyscraper-" + t + '.png" width="300" height="600"/>'
                }
                $(this).addClass("imgviral"), $(this).parent().append('<a href="https://goo.gl/m3eJf5">' + a + "</a>"), e++, 4 == e && (e = 1)
            })
        },
        l = {
            init: n,
            load: i,
            loadSky: o,
            loadAblockAds: s
        };
    window.Ads = l
}(),
function() {
    var e, a, t, n, i, o, r, s, l, c = $("#viral-wrapper"),
        d = 0,
        u = 0,
        p = null,
        v = null,
        g = $("#jumbo").find(".jumbo-meta"),
        h = !0,
        f = !1,
        m = 0,
        b = !1,
        w = !1,
        k = !1,
        y = !0,
        _ = !1,
        C = !1,
        T = !1,
        L = !1,
        P = !1,
        S = function() {
            h && (h = !1, !v && (v || ContentLoader.currentPageType() != ContentLoader.EVENT && ContentLoader.currentPageType() != ContentLoader.POST) || Ads.init(), UI.checkStylesLoaded(), ContentLoader.currentPageType() != ContentLoader.EVENT && UI.loadImgs(), UI.loadEvtImgs()), null !== p && clearTimeout(p), p = setTimeout(function() {
                var e = $(this).scrollTop(),
                    a = $(window).scrollTop();
                if (ContentLoader.currentPageType() != ContentLoader.EVENT && UI.loadImgs(), 100 * (a + $(window).height()) / $(document).height() > 80 && ContentLoader.lazyLoading(), a > 300 ? $("body").addClass("scrolled") : $("body").removeClass("scrolled"), e > d) {
                    switch (u = e, ContentLoader.currentPageType()) {
                        case ContentLoader.POSTS:
                        case ContentLoader.INFO:
                        case ContentLoader.TAG:
                        case ContentLoader.CITY_MAP:
                        case ContentLoader.PAGE_MAP:
                        case ContentLoader.EVENT_MAP:
                        case ContentLoader.POST:
                            break;
                        default:
                            a > 10 && g.addClass("hide"), a > 300 ? (0 == $(".viral-footer-page-2").length && $(".viral-footer-page").clone().appendTo("#viral-container").attr("class", "viral-footer-page viral-footer-page-2"), $("body").addClass("shrink")) : $("body").removeClass("shrink")
                    }
                    if (!v && ContentLoader.currentPageType() == ContentLoader.PAGE && a > 120 && a < 700) {
                        var t = parseInt($(".adsentitiespage").css("margin-top")) + u / 50;
                        t > 253 && (t = 253), $(".adsentitiespage").css("margin-top", t + "px")
                    }
                } else {
                    if (a < 15 && g.removeClass("hide"), !v && ContentLoader.currentPageType() == ContentLoader.PAGE && a < 900) {
                        var t = parseInt($(".adsentitiespage").css("margin-top")) - u / 50;
                        t < 0 && (t = 0), $(".adsentitiespage").css("margin-top", t + "px")
                    }
                    a > 300 ? $("body").addClass("shrink scrolled") : $("body").removeClass("shrink scrolled")
                }
                d = e
            }, 15)
        },
        E = function() {
            $("#viral-menu").css("width", "100%"), menu_width = $("#viral-menu").width(), $("body").hasClass("viral-filters") && Filters.setHeight(), ($("body").hasClass("viral-events") || $("body").hasClass("viral-highlights")) && Events.resizeEvents(), "undefined" != typeof Youtube && Youtube.resize()
        },
        x = function(e, a, t) {
            $("a:not(.viral-linked)").each(function() {
                var e = $(this);
                e.addClass("viral-linked");
                var a = $(this).attr("href");
                "undefined" == typeof a && (a = $(this).data("url")), null != a && a.length > 0 && a.indexOf("javascript:") === -1 && $(this).click(function(e) {
                    var t = $(this).attr("id");
                    stopLink(e), 0 !== a.indexOf("http") ? "event-nav-next" == t || "event-nav-prev" == t ? Navigate.changeAddr(a) : window.location = a : window.open(a, "_blank")
                })
            }), $("li.viral-item:not(.viral-linked)").each(function() {
                var e = $(this);
                e.addClass("viral-linked");
                var a = $(this).data("url");
                "" !== $(this).data("href") && (a = $(this).data("href")), null != a && a.length > 0 && (0 === a.indexOf("/") || a.indexOf("www") > 0) && $(this).click(function(e) {
                    if ("" == $(this).data("href")) return stopLink(e), a.indexOf("www") === -1 && a.indexOf("suggest") === -1 ? Navigate.changeAddr(a) : a.indexOf("/info/suggest") === -1 ? window.open(a, "_blank") : window.location = a, !1
                })
            })
        },
        A = function() {
            navigator.userAgent.match(/(iPod|iPhone|iPad)/) && $("body").addClass("ios")
        },
        I = function() {
            window.scrollTo(0, 0)
        },
        j = {
            infoResize: E,
            ajaxCompleted: x,
            init: function() {
                if (v = UI.isMobile(), $(window).resize(function() {
                        this.resizeTO && clearTimeout(this.resizeTO), this.resizeTO = setTimeout(function() {
                            $(this).trigger("resizeEnd")
                        }, 100)
                    }), $(window).bind("resizeEnd", E), A(), parseInt(init_pageType) == ContentLoader.MAIN || parseInt(init_pageType) == ContentLoader.POSTS || parseInt(init_pageType) == ContentLoader.POST ? (y = !1, UI.checkStylesLoaded()) : ContentLoader.currentPageType() != ContentLoader.MAP && ContentLoader.init(), ContentLoader.currentPageType() == ContentLoader.CITY_MAP && UI.loadAnalytics(), $(window).on("beforeunload", I), window.scrollTo(0, 0), $(window).scroll(S), initFuncs.length > 0)
                    for (var e in initFuncs) initFuncs[e]();
                ($("body").hasClass("viral-events") || $("body").hasClass("viral-highlights")) && Events.resizeEvents()
            },
            loadAnalytics: function() {
                if (!b) {
                    var e = document.createElement("script");
                    e.type = "text/javascript", e.setAttribute("async", "true"), e.setAttribute("src", "https://www.googletagmanager.com/gtag/js?id=" + gg_analytics), document.documentElement.firstChild.appendChild(e), window.dataLayer = window.dataLayer || [], window.gtag = function() {
                        dataLayer.push(arguments)
                    }, window.gtag("js", new Date), window.gtag("config", gg_analytics), "undefined" != typeof trackJumbo && trackJumbo > 0 && window.gtag("event", "JupiterView", {
                        event_category: "Jupiter",
                        event_label: trackJumbo
                    }), b = !0
                }
            },
            checkStylesLoaded: function() {
                if (!f) {
                    UI.loadAnalytics();
                    var e, a = parseInt(ContentLoader.currentPageType());
                    e = "extremadura" == account_id ? "extremadura" : "cr" == account_id ? "cr" : lang, a != -2 && (UI.loadJS(cdn_url_s + "/lib/" + e + "/second.js?v=" + s_version, UI.jsLoaded), UI.loadJS(cdn_url_s + "/lib/atcb.2.2.5.min.js?v=" + s_version), $("<link/>", {
                        rel: "stylesheet",
                        type: "text/css",
                        href: cdn_url_s + "/css/second.css?v=" + css_version
                    }).appendTo("head"), $("<link/>", {
                        rel: "stylesheet",
                        type: "text/css",
                        href: cdn_url_s + "/css/atcb.2.2.5.min.css?v=" + css_version
                    }).appendTo("head")), f = !0, v && Facebook.init()
                }
            },
            isMobile: function() {
                if (null !== v) return v;
                var e = !1;
                return (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0, 4))) && (e = !0), e
            },
            setMenuWidth: function() {
                menu_width = $("#viral-menu").width(), $(":root").css("overflow", "hidden"), $("#viral-menu").width(menu_width)
            },
            scrollTo: function(e, a) {
                "undefined" == typeof a && (a = 300), $("html, body").animate({
                    scrollTop: null == e || 0 == e.length ? 0 : e.offset().top - 90
                }, a)
            },
            gotoTop: function() {
                UI.scrollToElement(c)
            },
            onLoad: function(e) {
                9 != e && UI.loadImgs(), Navigate.init(), Search.init(), Sidebar.init(), Input.init(), User.init(), v || setTimeout(Facebook.init, 300), 3 == init_account || 4 == init_account || UI.isMobile() || ContentLoader.currentPageType() != ContentLoader.CITY && ContentLoader.currentPageType() != ContentLoader.PAGE && ContentLoader.currentPageType() != ContentLoader.PROMOTER && ContentLoader.currentPageType() != ContentLoader.TYPE && ContentLoader.currentPageType() != ContentLoader.TAG && ContentLoader.currentPageType() != ContentLoader.DATETYPE && ContentLoader.currentPageType() != ContentLoader.MAIN && ContentLoader.currentPageType() != ContentLoader.DATE || setTimeout(Ads.init, 30), hasAdBlocker && Ads.loadAblockAds(), x(), $("#viral-logo").on("click", function(e) {
                    UI.isMobile() && ContentLoader.currentPageType() == ContentLoader.EVENT ? ContentLoader.closeEvent() : Navigate.openSameWindow("/")
                }), Facebook.isFacebookApp() || Cookies.checkCookie()
            },
            loadEvtImgs: function() {
                if (ContentLoader.currentPageType() == ContentLoader.EVENT) {
                    for (var e = $("#viral-event-app img"), a = 0; a < e.length; a++) e[a].getAttribute("data-src") && e[a].setAttribute("src", e[a].getAttribute("data-src"));
                    e = $("#viral-event-media .image");
                    for (var a = 0; a < e.length; a++) e[a].getAttribute("data-src") && e[a].setAttribute("style", "background-image:url(" + e[a].getAttribute("data-src") + ")")
                }
            },
            loadImgs: function() {
                m = 0, $(".viral-event:not(.processed)", $("#viral-events")).each(function() {
                    if ($(this).isInViewport() && (m++, m < 3 && v && !f || m < 6 && !v && !f || f)) {
                        $(this).addClass("processed");
                        var e = $(this).find(".viral-event-image");
                        e.css("background-image", "url(" + e.attr("data-img") + ")")
                    }
                })
            },
            loadJS: function(e, a) {
                var t = document.createElement("script");
                t.src = e, "undefined" != typeof a && (t.onload = a, t.onreadystatechange = a), document.head.appendChild(t)
            },
            openSharePopup: function(n, i) {
                stopLink(n), a = n, t = i, e = "popup", UI.checkStylesLoaded(), w ? Share.openPopup(a, t) : T = !0
            },
            share: function(a) {
                n = a, e = "show", UI.checkStylesLoaded(), w ? Share.show(a) : T = !0
            },
            closeShare: function() {
                $("html").hasClass("inactive") && $(":root").css("overflow-y", "scroll"), $(".viral-share-popup").length > 0 && ($("html").removeClass("inactive"), $("#viral-popup").css("width", "100%"), $("#viral-popup").css("overflow", "hidden"), $("#viral-popup-box").removeClass("bounceInDown").addClass("bounceOutDown"), $("#viral-popup-background").remove(), $("#viral-menu").find(".viral-menu-btn-share").removeClass("selected"), setTimeout(function() {
                    $("#viral-popup").remove()
                }, 1e3))
            },
            applyFilters: function(e, a, t) {
                switch (e) {
                    case "categories":
                        Filters.categories(a);
                        break;
                    case "tags":
                        Filters.categories(a);
                        break;
                    case "districts":
                        Filters.districts(a);
                        break;
                    case "subDistricts":
                        Filters.subDistricts(a);
                        break;
                    case "atoms":
                        Filters.atoms(a, t);
                        break;
                    case "datepicker":
                        Filters.openDatePicker();
                        break;
                    case "languages":
                        Filters.languages()
                }
            },
            filters: function(e, a, t) {
                UI.checkStylesLoaded(), w ? UI.applyFilters(e, a, t) : (i = e, o = a, r = t)
            },
            showAuth: function() {
                UI.checkStylesLoaded(), w ? User.showAuth() : _ = !0
            },
            store: function(e, a, t) {
                stopLink(e), UI.checkStylesLoaded(), w ? Store.highlights(a, t) : (l = a, s = t, L = !0)
            },
            sidebar: function() {
                UI.checkStylesLoaded(), w ? User.sidebar() : k = !0
            },
            relatedEvents: function() {},
            closeViralAlert: function() {
                $("#viral-alert").hide()
            },
            closeEvent: function(e) {
                stopLink(e), UI.checkStylesLoaded(), w ? ContentLoader.closeEvent() : C = !0, "" === $(".viral-skyscrapper").html() && 3 != init_account && Ads.loadSky(), $("#viral-alert").hide()
            },
            loader: function(e, a) {
                (bLoadingContent = e) ? Loader.show(): Loader.hide()
            },
            scrollToElement: function(e) {
                null != e.offset() && $("html, body").animate({
                    scrollTop: e.offset().top - 90
                }, 300)
            },
            scrollToAnswer: function() {
                var e = $(this).parent().attr("class").substring(13);
                UI.scrollToElement($("li.faq-answer-" + e))
            },
            openApp: function(e, a, t) {
                "undefined" != typeof t && stopLink(t), w ? executeFunctionByName(e, window) : (UI.checkStylesLoaded(), P = !0, appFunc = e)
            },
            jsLoaded: function() {
                w = !0, "undefined" != typeof i && (UI.applyFilters(i, o, r), i = o = r = void 0), T && ("popup" == e ? Share.openPopup(a, t) : Share.show(n), T = !1), y || ContentLoader.init(), C && (ContentLoader.closeEvent(), C = !1), k && (User.sidebar(), k = !1), _ && (_ = !1, User.showAuth()), L && (L = !1, Store.highlights(l, s)), P && (P = !1, executeFunctionByName(appFunc, window))
            }
        };
    window.UI = j
}();
var getParameterByName = function(e) {
        e = e.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var a = new RegExp("[\\?&]" + e + "=([^&#]*)"),
            t = a.exec(location.search);
        return null === t ? "" : decodeURIComponent(t[1].replace(/\+/g, " "))
    },
    stopLink = function(e) {
        try {
            var a = e || window.event;
            a.preventDefault(), a.stopPropagation(), a.stopImmediatePropagation()
        } catch (a) {}
    },
    executeFunctionByName = function(e, a) {
        for (var t = Array.prototype.slice.call(arguments, 2), n = e.split("."), i = n.pop(), o = 0; o < n.length; o++) a = a[n[o]];
        return a[i].apply(a, t)
    };
$.fn.isInViewport = function() {
        var e = $(this).offset().top,
            a = e + $(this).outerHeight(),
            t = $(window).scrollTop(),
            n = t + $(window).height();
        return a > t && e < n
    },
    function() {
        var e = $("#viral-events"),
            a = ($(window), !1),
            t = function() {
                $("body").addClass("jumbo"), Navigate.setLocal("viral-highlights"), $("li.finished", e).removeClass("finished"), s()
            },
            n = function(a) {
                e.html(a.html), t()
            },
            i = function() {
                ContentLoader.setUrl(), ContentLoader.currentPageType() !== ContentLoader.PAGE && ContentLoader.currentPageType() !== ContentLoader.PROMOTER && ContentLoader.currentPageType() !== ContentLoader.TAG || $("#viral-events-options .viral-map, #viral-events-options .viral-jumbo").hide(), ContentLoader.currentPageType() != ContentLoader.CITY ? ($("#viral-footer-events").find("a.viral-menu-agenda-map").hide(), $("#viral-menu-agenda-actions").find("a.viral-menu-agenda-map").hide()) : ($("#viral-footer-events").find("a.viral-menu-agenda-map").show(), $("#viral-menu-agenda-actions").find("a.viral-menu-agenda-map").show());
                var a = window.location.protocol + "//" + window.location.host + site_url;
                $("#viral-menu-agenda-actions .viral-menu-agenda-widget, .viral-footer-page .viral-btn-widget").unbind("click").click(function() {
                    $("#widgetconf-preview-bg").show();
                    var e = null;
                    e = (i = window.location.pathname.indexOf("/tags/")) >= 0 ? {
                        url: a + "wt/" + window.location.pathname.substring(i).split("/")[2],
                        tag: window.location.pathname.substring(i).split("/")[2]
                    } : (i = window.location.pathname.indexOf("/p/")) >= 0 ? {
                        url: a + "wp/" + window.location.pathname.substring(i).split("/")[2],
                        username: window.location.pathname.substring(i).split("/")[2]
                    } : {
                        url: a + "w/" + window.location.pathname.substring(window.location.pathname.indexOf(site_url) + site_url.length),
                        urlFrag: window.location.pathname.substring(window.location.pathname.indexOf(site_url) + site_url.length)
                    }, Widget.open(e)
                });
                e.attr("data-node"), e.attr("data-subnode");
                if (r(), $(".viral-item", $("#viral-events")).length >= 20 || "" !== e.attr("data-date") && null !== e.attr("data-date") ? ($("#viral-menu-datepicker-icon").show(), $("#viral-menu-datepicker").show()) : $(window).width() < 640 ? $("#viral-menu-datepicker-icon").hide() : 1 == init_account ? $("#viral-menu-datepicker-icon").hide() : $("#viral-menu-datepicker-icon").show(), 0 === $(".viral-item", e).length)
                    if (ContentLoader.currentPageType() != ContentLoader.FOLLOW && ContentLoader.currentPageType() != ContentLoader.PINNED && ContentLoader.currentPageType() != ContentLoader.MYEVENTS && ContentLoader.currentPageType() != ContentLoader.PAGE) {
                        Navigate.setLocal("viral-events-404");
                        var t = location.pathname.split("/");
                        "undefined" != typeof t[2] && "follow" === t[2] && ($(".viral-no-future-events").hide(), $(".viral-no-future-events-follows").show(), $("#events-filters-box").find("a.viral-btn-follows").removeClass("hidden"), $("#events-filters-box").find("a.viral-btn-create").hide(), $("#events-filters-box").find(".viral-filters-btns").hide())
                    } else switch (ContentLoader.currentPageType()) {
                        case ContentLoader.FOLLOW:
                            "0" === viral_user.is_viral ? $("#follow-select-nocontent-facebook").show() : $("#follow-select-nocontent-viral").show();
                            break;
                        case ContentLoader.PINNED:
                            $("#follow-select-nocontent-saved").show();
                            break;
                        case ContentLoader.MYEVENTS:
                            $("#follow-select-nocontent-created").show()
                    }
            },
            o = function(a) {
                if (ContentLoader.currentPageType() != ContentLoader.EVENT && ContentLoader.currentPageType() != ContentLoader.PAGE && ContentLoader.currentPageType() != ContentLoader.PINNED && ContentLoader.currentPageType() != ContentLoader.FOLLOW) {
                    var t = $("#viral-container").find(".fb-like"),
                        n = t.parent();
                    t.remove(), n.prepend("<div class='fb-like fb_iframe_widget' data-href='https://www.viralagenda.com" + window.location.pathname + "' data-send='false' data-layout='button_count' data-width='80' data-show-faces='false' data-font='lucida grande'></div>"), t = $("#viral-container").find(".fb-like"), FB.XFBML.parse(), "undefined" != typeof gapi && gapi.plusone.render("viral-footer-social-plusone")
                }
                ContentLoader.currentPageType() != ContentLoader.PAGE && ContentLoader.currentPageType() != ContentLoader.PINNED && ContentLoader.currentPageType() != ContentLoader.FOLLOW && ContentLoader.currentPageType() != ContentLoader.MYEVENTS ? ($("#viral-menu-title").html(a.eventsTitle), null !== a.following && a.following.showFollow ? $("#viral-footer-events a.follow, .viral-footer-page a.follow, #viral-menu-agenda-actions a.follow").show() : $("#viral-footer-events a.follow, .viral-footer-page a.follow, #viral-menu-agenda-actions a.follow").hide()) : ContentLoader.currentPageType() === ContentLoader.PAGE ? (a.page.v_pages_visit_website = v_pages_visit_website, a.page.website = "undefined" != typeof a.page.website && isValidURL(a.page.website) ? "http://" + a.page.website.replace(/.*?:\/\//g, "") : null, a.page.picture = null === a.page.picture || 0 === a.page.picture.length ? "/images/entity.png" : a.page.picture, $("#viral-footer-page-data").html(Mustache.render(pageInfoTemplate, a))) : ContentLoader.currentPageType() == ContentLoader.FOLLOW, $("#viral-events-location .viral-content").html(a.eventsTitle), e.attr("data-type", a.type), e.attr("data-node", a.node), e.attr("data-subnode", a.subnode), e.attr("data-page", null != a.page ? a.page.username : null), e.attr("data-category", a.category), e.attr("data-date", a.date), e.attr("data-tag", a.tag), e.attr("data-p", 1), e.attr("data-total", a.total), e.html(a.html), $("#viral-main").find(".total-events-number").html(a.total), i()
            },
            r = function() {
                User.followCheck(), s()
            },
            s = function() {
                $("ul#viral-events li.prev-highlight-double").removeClass("prev-highlight-double highlight-extended").addClass("highlight-double");
                var e = Math.round($("#viral-events").width()),
                    a = Math.round($("ul#viral-events li:not(.highlight-double):not(.viral-sticky-double-loaded)").first().outerWidth(!0)),
                    t = Math.round(e / a);
                $("ul#viral-events li.highlight-double").each(function() {
                    var e = $(this),
                        a = e.prevAll(".highlight-double").length,
                        n = a + $(this).index("#viral-events li") + 1;
                    n % t === 0 && e.removeClass("highlight-double").addClass("prev-highlight-double highlight-extended")
                })
            },
            l = function() {
                a = !0, r(), UI.loadImgs()
            },
            c = function() {
                0 === $("li.viral-event-end", e).length && (e.append(listItemEndTemplate), Facebook.showLikeBox() && (e.append(listItemLikeTemplate), Facebook.parse($("li.viral-event-like", e))))
            },
            d = function() {
                $(".event_time").removeClass("hidden"), $(".event_time_expand").hide()
            },
            u = {
                init: i,
                render: o,
                lazyLoad: l,
                lazyLoadEnd: c,
                initHighlights: t,
                renderHighlights: n,
                resizeEvents: s,
                showEventTimes: d
            };
        window.Events = u
    }(),
    function() {
        var e, a = $("#viral-single"),
            t = $("#viral-events"),
            n = $("#viral-posts"),
            i = 662,
            o = 347,
            r = !1,
            s = function() {
                g($("#post-details").attr("data-id"), n), $("#viral-single").addClass("viral-single-post"), $("#viral-single-background", a).unbind("click").click(ContentLoader.closePost);
                var e = window.location.hash.substr(1);
                "" != e && UI.scrollTo($("#" + e)), Facebook.loadPost(a)
            },
            l = function(e) {
                $("#viral-single-content", a).html(e.html), s()
            },
            c = function() {
                window.scrollTo(0, e)
            },
            d = function(t) {
                $("#jumbo-gad").hide(), UI.isMobile() && (e = $(window).scrollTop(), $("#jumbo").hide(), $("#viral-container").hide(), window.scrollTo(0, 0)), $("#viral-single-content", a).html(t.html), v(), UI.loadEvtImgs(), $("#viral-menu-event-mobile").html($("#viral-event h1").text())
            },
            u = function(e) {
                r = !0, $("#viral-single-content", a).html(e.html), v(), $("#viral-single-background", a).unbind("click").click(UI.closeEvent), $(".vira-event-links a, .viral-informations a", a).addClass("viral-linked").attr("target", "_blank"), $(".viral-informations-share a", a).attr("href", "#"), $("#viral-event-comments").remove(), $("ul.viral-informations").remove(), Loader.hide()
            },
            p = function(e, a, t) {
                return img_w = a, img_h = t, real_img_h = i * img_h / img_w - o, result = real_img_h * e / 100 * -1, Math.floor(result) + "px"
            },
            v = function(e) {
                $("body").addClass("viral-event"), "undefined" == typeof e && (e = !1), g($("#viral-event").attr("data-id"), t, e);
                var n = $(".viral-event-image", a),
                    i = $("img", n);
                i.hide();
                var s = function() {
                    i.hide(), i.height() > 220 && (i.height() < o ? $(".container", n).height(i.height()) : $(".container", n).height(o)), i.width() <= i.height() && i.height() > o && (i.attr("src").indexOf(cdn_url) != -1 || r ? UI.isMobile() || (i.css("top", i.data("top")), i.css("left", i.data("left"))) : i.css("top", p(i.data("top"), i.data("width"), i.data("height")))), i.show(), i.height() > parseInt($(".container", n).css("height")) && $(".expand", n).show().click(function() {
                        $(this).hide(), i.css("top", 0), $(".container", n).animate({
                            height: i.height()
                        }, 150)
                    })
                };
                i.on("load", s);
                var l = $("img", n).attr("src");
                0 === i.height() && (i.hide(), i.attr("src", l)), e && s(), Facebook.loadEvent(a), $("#viral-single-background", a).unbind("click").click(UI.closeEvent), setTimeout(function() {
                    var e = $(".viral-event-description", a);
                    e.length > 0 && $(".container", e).get(0).scrollHeight > parseInt($(".container", e).css("maxHeight")) && $(".expand", e).show().click(function() {
                        $(this).hide(), $(".container", e).animate({
                            maxHeight: $(".container", e).get(0).scrollHeight
                        }, 150)
                    })
                }, 100)
            },
            g = function(e, t, n) {
                var i = null,
                    o = null,
                    r = null,
                    s = 0;
                $(".viral-item", t).each(function() {
                    return 1 == s && null == i ? void(i = $(this)) : ($(this).attr("data-id") == e && (o = r, s = 1), void(r = $(this)))
                }), null != i ? $(".viral-nav-next", a).click(function() {
                    Navigate.changeAddr(i.attr("data-url"))
                }).attr("data-url", i.attr("data-url")).show() : $(".viral-nav-next", a).hide(), null != o ? $(".viral-nav-prev", a).click(function() {
                    Navigate.changeAddr(o.attr("data-url"))
                }).attr("data-url", o.attr("data-url")).show() : $(".viral-nav-prev", a).hide();
                var l = $("#c" + e, t);
                if (l = 0 == l.length ? $("li:first-child", t) : l, a.show(), $("#viral-event-media .viral-media-box li", a).each(h), !n) {
                    var c, d = 0;
                    $("#viral-events").offset();
                    "undefined" != typeof l.offset() && (d = l.offset().top, c = l.offset()), $("body").hasClass("jumbo-adsense") ? a.css("top", $(window).scrollTop() - 360) : $("body").hasClass("jumbo") ? a.css("top", $(window).scrollTop() - 460) : a.css("top", $(window).scrollTop() - 60), UI.isMobile() && ($("body").hasClass("viral-page") ? a.css("top", parseInt(a.css("top")) + 22 + "px") : $("body").hasClass("viral-events") ? $(window).width() <= 320 ? a.css("top", parseInt(a.css("top")) + 403 + "px") : a.css("top", parseInt(a.css("top")) + 203 + "px") : a.css("top", parseInt(a.css("top")) - 3 + "px")), $("a.event-type-link-action, a.event-city-link, a.event-location-link", $("#viral-single")).click(Navigate.onLinkClick)
                }
            },
            h = function() {
                var e = $(this);
                if (!e.hasClass("processed")) {
                    e.addClass("processed");
                    var t = function(e) {
                        var n = e,
                            i = n.attr("rel"),
                            o = "",
                            r = n.closest("li");
                        if (r.hasClass("picture")) o = '\t\t\t\t\t<div id="viral-media-event-wrapper">\t\t\t\t\t\t<div class="box">\t\t\t\t\t\t\t<img class="animated" src=" ' + i + '" />\t\t\t\t\t\t</div>\t\t\t\t\t\t<div class="viral-media-event-wrapper-prev"><span class="simple-line-icons-121"></span></div>\t\t\t\t\t\t<div class="viral-media-event-wrapper-next"><span class="simple-line-icons-120"></span></div>\t\t\t\t\t</div>\t\t\t\t';
                        else if (r.hasClass("youtube")) o = '\t\t\t\t\t<div id="viral-media-event-wrapper">\t\t\t\t\t\t<div class="box">\t\t\t\t\t\t\t<iframe width="640" height="360" src="https://www.youtube.com/embed/' + i + '?autoplay=1&wmode=opaque&modestbranding=1" allowfullscreen="allowfullscreen" frameborder="0" type="text/html"></iframe>\t\t\t\t\t\t</div>\t\t\t\t\t\t<div class="viral-media-event-wrapper-prev"><span class="simple-line-icons-121"></span></div>\t\t\t\t\t\t<div class="viral-media-event-wrapper-next"><span class="simple-line-icons-120"></span></div>\t\t\t\t\t</div>\t\t\t\t';
                        else if (r.hasClass("facebook")) o = '                    <div id="viral-media-event-wrapper">                        <div class="box">                            <iframe src="https://www.facebook.com/plugins/video.php?href=' + i + "&width=640&autoplay=true&show_text=false&" + facebook_app_id + '&height=358" width="640" height="358" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allowFullScreen="true"></iframe>                        </div>                        <div class="viral-media-event-wrapper-prev"><span class="simple-line-icons-121"></span></div>                        <div class="viral-media-event-wrapper-next"><span class="simple-line-icons-120"></span></div>                    </div>                ';
                        else if (r.hasClass("vimeo")) o = '\t\t\t\t\t<div id="viral-media-event-wrapper">\t\t\t\t\t\t<div class="box">\t\t\t\t\t\t\t<iframe width="640" height="360" src="' + i + '?title=0&amp;byline=0&autoplay=1&wmode=opaque" frameborder="0" type="text/html" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>\t\t\t\t\t\t</div>\t\t\t\t\t\t<div class="viral-media-event-wrapper-prev"><span class="simple-line-icons-121"></span></div>\t\t\t\t\t\t<div class="viral-media-event-wrapper-next"><span class="simple-line-icons-120"></span></div>\t\t\t\t\t</div>\t\t\t\t';
                        else if (r.hasClass("soundcloud") || r.hasClass("bandcamp") || r.hasClass("mixcloud")) return;
                        0 != o.length && ($("#viral-media-event-wrapper").remove(), $("#viral-event-media .viral-media-box", a).append(o), 0 == $("a", n.closest("li").prev()).length ? $("#viral-event-media .viral-media-box .viral-media-event-wrapper-prev", a).remove() : $("#viral-event-media .viral-media-box .viral-media-event-wrapper-prev", a).click(function() {
                            t($("a", n.closest("li").prev()))
                        }), 0 == $("a", n.closest("li").next()).length ? $("#viral-event-media .viral-media-box .viral-media-event-wrapper-next", a).remove() : ($("#viral-event-media .viral-media-box .viral-media-event-wrapper-next", a).click(function() {
                            t($("a", n.parent().closest("li").next()))
                        }), $("a", n.closest("li").next()).length > 0 && $("#viral-event-media .viral-media-box img", a).click(function() {
                            t($("a", n.closest("li").next()))
                        })), UI.scrollTo($("#viral-media-event-wrapper")), $("#viral-media-event-wrapper").click(function() {
                            $(this).remove()
                        }))
                    };
                    $("a", e).click(function() {
                        t($(this))
                    })
                }
            },
            f = {
                event: function(e) {
                    v(e)
                },
                post: s,
                eventRender: d,
                eventRenderPreview: u,
                setScrollPos: c,
                postRender: l
            };
        window.SingleContent = f
    }(),
    function() {
        function e() {
            window.location = "https://www.facebook.com/dialog/oauth?client_id=" + facebook_app_id + "&redirect_uri=" + window.location.href + "&scope=" + l
        }
        var a, t, n, i, o = new Array,
            r = new Array,
            s = null,
            l = "email",
            c = function() {
                var e = navigator.userAgent || navigator.vendor || window.opera;
                return e.indexOf("FBAN") > -1 || e.indexOf("FBAV") > -1
            },
            d = function() {
                return null != a
            },
            u = function(e) {
                a = null, t = null, o = new Array, s && (s(), s = null)
            },
            p = function(e) {
                c() || e.authResponse && (a = e.authResponse.accessToken, t = e.authResponse.signedRequest, $.ajax({
                    url: site_url + "connect/facebook",
                    data: {
                        access_token: a
                    },
                    dataType: "json",
                    error: function() {},
                    success: function(e) {
                        return is_viral = !1, "undefined" != typeof i ? (i(), void(i = void 0)) : void User.login(e)
                    }
                }))
            },
            v = function(e) {
                f(e)
            },
            g = function(e) {
                "undefined" != typeof FB && null !== FB ? e() : r.push(e)
            },
            h = function() {
                var e = r;
                r = [];
                for (var a in e) e[a]()
            },
            f = function(e) {
                g(function() {
                    FB.XFBML.parse(e[0])
                })
            },
            m = {
                isFacebookApp: c,
                init: function() {
                    c() || $.getScript("//connect.facebook.net/" + lang + "_" + lang.toUpperCase() + "/sdk.js", function() {
                        FB.init({
                            appId: facebook_app_id,
                            status: !0,
                            cookie: !0,
                            xfbml: !0,
                            oauth: !0,
                            autoLogAppEvents: !0,
                            version: "v12.0"
                        }), FB.Event.subscribe("auth.statusChange", Facebook.isLogged), FB.Event.subscribe("auth.logout", Facebook.isLoggedOut), FB.getLoginStatus(Facebook.tryIsLogged), h()
                    })
                },
                parse: f,
                doLogin: function(a) {
                    c() || (navigator.userAgent.match("CriOS") ? e() : "undefined" == typeof a ? FB.login(p, {
                        scope: l
                    }) : (o = new Array, FB.login(p, {
                        scope: a,
                        auth_type: "rerequest"
                    })))
                },
                loadEvent: function(e) {
                    UI.isMobile() || v($("#viral-event-comments", e))
                },
                managePage: function(e) {
                    FB.login(e, {
                        scope: "manage_pages",
                        auth_type: "rerequest"
                    })
                },
                userEvents: function(e) {
                    FB.login(e, {
                        scope: "user_events",
                        auth_type: "rerequest"
                    })
                },
                loadPost: function(e) {
                    g(function() {
                        v($("#viral-post-comments"), e)
                    }), f($(".viral-post-fb-like", e)), f($(".viral-informations-share .like", e))
                },
                logout: function(e) {
                    s = e, d() ? FB.logout(function() {
                        u()
                    }) : u()
                },
                tryIsLogged: function(e) {
                    !d() && null !== e && e.authResponse ? p(e) : d() || u()
                },
                isLogged: function(e) {
                    null !== e && "null" !== e.authResponse ? "connected" === e.status ? p(e) : ("not_authorized" === e.status, u()) : u()
                },
                isLoggedOut: u,
                getSignedRequest: function() {
                    return t
                },
                getPermissionValue: function(e) {
                    for (var a = 0; a < n.length; a++)
                        if (n[a].permission === e && "granted" === n[a].status) return !0;
                    return !1
                },
                getCallback: function() {
                    return i
                },
                setCallback: function(e) {
                    i = e
                },
                getAccessToken: function() {
                    return a
                },
                showLikeBox: function() {
                    return !d()
                },
                getPermissions: function() {
                    try {
                        FB.api("/me/permissions?access_token=" + Facebook.getAccessToken(), function(e, a) {
                            n = e.data
                        })
                    } catch (e) {
                        console.log(e)
                    }
                }
            };
        window.Facebook = m
    }(),
    function() {
        var e, a = ($("title"), 0),
            t = 1,
            n = 2,
            i = 3,
            o = 4,
            r = 5,
            s = 6,
            l = 7,
            c = 8,
            d = 9,
            u = 10,
            p = 11,
            v = 12,
            g = 13,
            h = 14,
            f = 15,
            m = 16,
            b = 17,
            w = 18,
            k = init_pageType,
            y = null,
            _ = 20,
            C = 10,
            T = {},
            L = $("#viral-main"),
            P = $("#jumbo"),
            S = P.find("a"),
            E = !0,
            x = [],
            A = function(e) {
                var a = $("#viral-events");
                null == e && (e = !0);
                var t = site_url.substr(0, site_url.length - 1),
                    n = a.attr("data-node"),
                    i = a.attr("data-subnode"),
                    o = a.attr("data-page"),
                    r = a.attr("data-category"),
                    s = a.attr("data-date"),
                    l = a.attr("data-tag");
                if (null != n && "" != n)
                    for (var c in viral_nodes)
                        if (viral_nodes[c].id == n && (t += "/" + viral_nodes[c].slug, null != i && "" != i))
                            for (var d in viral_nodes[c].children) viral_nodes[c].children[d].id == i && (t += "/" + viral_nodes[c].children[d].slug);
                return null != l && "" != l && (t = site_url + "tags/" + l), null != r && "" != r && (t += "/" + r), null != o && "" != o && (t = site_url + "p/" + o), e && null != s && "" != s && (t += "/" + s), $("body").hasClass("viral-pinned") ? t += "/follow/pinned" : $("body").hasClass("viral-follow") && (t += "/follow"), t = Navigate.getLocaleUrl(t)
            },
            I = function() {
                var e = $("#viral-events"),
                    a = e.attr("data-node"),
                    t = e.attr("data-subnode"),
                    n = e.attr("data-page"),
                    i = e.attr("data-category");
                return {
                    node: null != a && "" != a ? a : null,
                    subnode: null != t && "" != t ? t : null,
                    category: j(i),
                    page: null != n && "" != n ? n : null
                }
            },
            j = function(e) {
                if (null != e && "" != e)
                    for (var a in viral_categories)
                        if (viral_categories[a].url == e) return viral_categories[a].id;
                return null
            },
            U = function(e) {
                if ($("#jumbo-gad").remove(), $("#viral-main-wrapper").removeClass("hasJumboAd"), L.removeClass("hasJumbo isViral"), null === e.banner || "1" !== e.banner.is_payd && 3 != init_account && !UI.isMobile()) S.removeAttr("href"), P.css("background-image", "none"), P.append("<div id='jumbo-gad' style='width:100%; text-align: center; margin-top: 30px;'>    \t\t<ins class='adsbygoogle' style='display:inline-block;width:970px;height:250px' data-ad-client='ca-pub-4410218056861224' data-ad-slot='4438869627'></ins>    </div>"), $("#viral-main-wrapper").addClass("hasJumboAd");
                else {
                    e.banner.link.length > 0 ? S.attr("href", e.banner.link) : S.removeAttr("href"), $("#jumbo-player").animate({
                        opacity: 0
                    }, {
                        duration: 1e3,
                        queue: !1,
                        done: function() {}
                    }), P.data("attr", "jumbo-" + e.banner.id), S.find("img").addClass("old"), UI.isMobile() === !1 ? (P.css("background-image", "url(" + e.banner.image_big + ")"), $("#jumbo").removeClass(), "null" == e.banner.bg_pos_horiz && (e.banner.bg_pos_horiz = "center"), "null" == e.banner.bg_pos_vert && (e.banner.bg_pos_vert = "center"), P.addClass("bg-" + e.banner.bg_pos_horiz + "-" + e.banner.bg_pos_vert)) : P.css("background-image", "url(" + e.banner.image + ")"), $("#jumbo-player").insertAfter(S.find("img:last")), null != e.banner.video && "" != e.banner.video ? Youtube.load(e.banner.video, e.banner.autoplay) : Youtube.unload(), k != n && P.show(), $("#jumbo .jumbo-title").html(e.banner.title), $("#jumbo .jumbo-description p").html(e.banner.description), "" == e.banner.title ? $("#jumbo .jumbo-meta").hide() : $("#jumbo .jumbo-meta").show(), $("#viral-main").addClass("hasJumbo"), 1 == e.banner.is_viral ? L.addClass("isViral").addClass("hasJumbo") : L.addClass("hasJumbo");
                    var a = $("#jumbo").data("attr");
                    "undefined" != typeof window.gtag && window.gtag("event", "JupiterView", {
                        event_category: "Jupiter",
                        event_label: a.substr(6)
                    })
                }
            },
            F = function() {
                P.hide()
            },
            O = function() {
                $("#viral-media-event-wrapper").remove(), $("#viral-single").hide(), $(window).trigger("scroll"), "undefined" != typeof Youtube && Youtube.pause()
            },
            R = function(e) {
                e.pageTotal < _ && (E = !1);
                var a = $("body").hasClass("viral-events") ? $("#viral-events") : $("#viral-posts");
                0 == $(".viral-lazy-loading-" + a.attr("data-p"), a).length && (a.append('<div class="viral-lazy-loading-' + a.attr("data-p") + '">' + e.html + "</div>"), a.attr("data-p", parseInt(e.p) / _ + 1), Ads.load(), Navigate.isLayout(Navigate.VIRAL_EVENTS) && Events.lazyLoad()), UI.ajaxCompleted()
            },
            N = function() {
                y = window.location.pathname + ""
            },
            M = function() {
                return y
            },
            V = {
                init: function() {
                    switch (e = k, k = parseInt(init_pageType), T = {}, parseInt(init_pageType)) {
                        case a:
                            Events.initHighlights();
                            break;
                        case t:
                            Events.init();
                            break;
                        case n:
                            Events.init();
                            break;
                        case i:
                            Events.init();
                            break;
                        case o:
                            Posts.init();
                            break;
                        case r:
                            Info.init();
                            break;
                        case s:
                            Events.init();
                            break;
                        case l:
                            Events.init();
                            break;
                        case c:
                            Events.init();
                            break;
                        case d:
                            _ = C, Events.init(), SingleContent.event(!0);
                            break;
                        case u:
                            Events.init();
                            break;
                        case p:
                        case v:
                        case g:
                            MapLoader.init();
                            break;
                        case h:
                            Posts.init(), SingleContent.post();
                            break;
                        case m:
                            Events.init();
                            break;
                        case b:
                            Events.init();
                            break;
                        case w:
                            Events.init()
                    }
                },
                render: function(f) {
                    switch (e = k, k = parseInt(f.type), T = {}, Loader.hide(), k != t && k != s && k != l && k != c && k != a ? k != d && (E = !0, F()) : (E = !0, U(f)), O(), UI.infoResize(), $("title").html(f.title), k != d && $("#viral-menu #viral-menu-title").html(f.eventTitle), Navigate.currentLayout() == Navigate.VIRAL_EVENTS && k === d ? $("body").removeClass("viral-event  viral-post") : $("body").removeClass("scrolled viral-event  viral-post"), k) {
                        case a:
                            Events.renderHighlights(f);
                            break;
                        case t:
                            Events.render(f);
                            break;
                        case n:
                            Events.render(f);
                            break;
                        case i:
                            Events.render(f);
                            break;
                        case o:
                            Posts.render(f);
                            break;
                        case r:
                            Info.render(f);
                            break;
                        case s:
                            Events.render(f);
                            break;
                        case l:
                            Events.render(f);
                            break;
                        case c:
                            Events.render(f);
                            break;
                        case d:
                            SingleContent.eventRender(f);
                            break;
                        case u:
                            Events.render(f), $("body").addClass("viral-tag");
                            break;
                        case p:
                        case v:
                        case g:
                            MapLoader.render(f);
                            break;
                        case h:
                            SingleContent.postRender(f);
                            break;
                        case m:
                            Events.render(f);
                            break;
                        case b:
                            Events.render(f);
                            break;
                        case w:
                            Events.render(f)
                    }
                    Ads.load(), UI.ajaxCompleted()
                },
                lazyLoading: function() {
                    if (E && (Navigate.isLayout(Navigate.VIRAL_EVENTS) && k != d || Navigate.isLayout(Navigate.VIRAL_POSTS) && k != h)) {
                        var e = Navigate.isLayout(Navigate.VIRAL_EVENTS) ? $("#viral-events") : $("#viral-posts"),
                            a = $(".viral-item", e).length,
                            t = $(".viral-item", e).last(),
                            n = 0;
                        $(".viral-event-past").length > 0 && (n = 1);
                        var i = 0;
                        $(".viral-event-ongoing").length && (i = 1), t = t.find("time").first().attr("datetime");
                        var o = parseInt(e.attr("data-p"));
                        if (a < _) return void(E = !1);
                        var r = e.attr("id") + "-" + o;
                        if (!(r in T)) {
                            T[r] = 1;
                            var s = window.location.pathname;
                            s = Navigate.getLocaleUrl(s), $.ajax({
                                url: s,
                                dataType: "json",
                                data: {
                                    ajax: 1,
                                    page: o * _,
                                    last: t,
                                    past: n,
                                    ongoing: i,
                                    perpage: _
                                },
                                error: function() {},
                                success: R
                            })
                        }
                    }
                },
                closeEvent: function(e) {
                    return $("body").removeClass("viral-event"), k == r ? (stopLink(e), $("#viral-single #viral-single-content").html(""), !1) : (k = $("#viral-events").attr("data-type"), k == d && (k = n), UI.checkStylesLoaded(), UI.loadImgs(), Places.cancelCall(), O(), $("#viral-single-content").html(""), Navigate.closePopup(Navigate.currentLayout() == Navigate.VIRAL_HIGHLIGHTS ? site_url + "home" : A() + ""), $("body").hasClass("viral-events") && k != n && k == u && $("#jumbo").show(), $("#jumbo-gad").show(), $(".adsbygoogle").not(".loaded").each(function() {
                        $(this).addClass("loaded"), (adsbygoogle = window.adsbygoogle || []).push({})
                    }), UI.isMobile() && ($("#viral-container").show(), $("#jumbo").show(), SingleContent.setScrollPos()), void($("body").hasClass("ajax-load") || ($("body").removeClass("scrolled shrink"), window.scrollTo(0, 0))))
                },
                closePost: function(e) {
                    k = $("#viral-posts").attr("data-type"), k == h && (k = o), stopLink(e), O(), Navigate.closePopup(null == M() ? site_url + "posts" : M() + "")
                },
                jumboClick: function(e) {
                    var a = $("#jumbo").data("attr");
                    "undefined" == typeof x[a] && "undefined" != typeof window.gtag && window.gtag("event", "JupiterClick", {
                        event_category: "Jupiter",
                        event_label: a.substr(6)
                    })
                },
                setUrl: N,
                getUrl: M,
                getParams: I,
                currentPageType: function() {
                    return k
                },
                prevPageType: function() {
                    return e
                },
                getCurrentUrl: A,
                MAIN: a,
                CITY: t,
                PAGE: n,
                PROMOTER: i,
                POSTS: o,
                INFO: r,
                DATE: s,
                TYPE: l,
                DATETYPE: c,
                EVENT: d,
                TAG: u,
                CITY_MAP: p,
                PAGE_MAP: v,
                EVENT_MAP: g,
                POST: h,
                PREVIEWEVENT: f,
                FOLLOW: m,
                PINNED: b,
                MYEVENTS: w
            };
        window.ContentLoader = V
    }(),
    function() {
        var e = {
            checkCookie: function() {
                if (1 != e.getCookie("viral_agenda_cookies")) {
                    var a = $(window).width();
                    a > 1024 && $("#viral-footer").show()
                } else $("#viral-footer").hide()
            },
            getCookie: function(e) {
                var a, t, n, i = document.cookie.split(";");
                for (a = 0; a < i.length; a++)
                    if (t = i[a].substr(0, i[a].indexOf("=")), n = i[a].substr(i[a].indexOf("=") + 1), t = t.replace(/^\s+|\s+$/g, ""), t == e) return unescape(n);
                return !1
            },
            setCookie: function(e, a, t) {
                var n = new Date;
                n.setDate(n.getDate() + t);
                var i = escape(a) + (null == t ? "" : "; expires=" + n.toUTCString());
                document.cookie = e + "=" + i + "; path=/"
            },
            hideCookie: function() {
                e.setCookie("viral_agenda_cookies", "1", "365"), $("#viral-footer").hide()
            }
        };
        window.Cookies = e
    }(),
    function() {
        var e, a = -1,
            t = 0,
            n = 1,
            i = 2,
            o = 3,
            r = 4,
            s = 5,
            l = "",
            c = null,
            d = !1,
            u = function(e, a) {
                "undefined" == typeof ga && UI.loadAnalytics(), e = Navigate.getLocaleUrl(e), window.history.pushState && window.history.replaceState ? (a && (d = !0, window.history.pushState("nav", e, e)), Loader.show(), $("body").addClass("ajax-load"), $.ajax({
                    url: e,
                    dataType: "json",
                    data: {
                        ajax: !0
                    },
                    error: function() {
                        Loader.hide(), window.location = e
                    },
                    success: ContentLoader.render
                })) : window.location = e
            },
            p = /^((?!chrome|android).)*safari/i.test(navigator.userAgent),
            v = function() {
                var e = navigator.userAgent.match(/Chrom(e|ium)\/([0-9]+)\./);
                return !!e && parseInt(e[2], 10)
            },
            g = v(),
            h = !1;
        g !== !1 && g < 33 && (h = !0);
        var f = function() {
                $(".viral-option ul").addClass("hidden"), setTimeout(function() {
                    $(".viral-option ul").removeClass("hidden")
                }, 500)
            },
            m = {
                init: function() {
                    window.onpopstate = function(e) {
                        if (window.history.length > 1) {
                            if (!p || (p || h) && d) {
                                if (null === window.history.state) return window.history.back(), !0;
                                window.location = window.location.pathname
                            }
                            d = !0
                        }
                    }, l = $("#viral-district-name").html(), UI.isMobile() === !1 && $("body").keyup(Navigate.onKeyUp)
                },
                getLocaleUrl: function(e) {
                    var a = {};
                    return location.search.substr(1).split("&").forEach(function(e) {
                        a[e.split("=")[0]] = e.split("=")[1]
                    }), "undefined" != typeof a.locale && (e = e.indexOf("?id=") !== -1 ? e + "&locale=" + a.locale : e + "?locale=" + a.locale), e
                },
                onKeyUp: function(e) {
                    switch (e.keyCode) {
                        case 9:
                            break;
                        case 13:
                            Search.keyPressed(e.keyCode);
                            break;
                        case 27:
                            break;
                        case 37:
                            var a = $(".viral-nav-prev");
                            null != a && a.is(":visible") && Navigate.changeAddr(a.data("url"));
                            break;
                        case 38:
                            Search.keyPressed(e.keyCode);
                            break;
                        case 39:
                            var t = $(".viral-nav-next");
                            null != t && t.is(":visible") && Navigate.changeAddr(t.data("url"));
                            break;
                        case 40:
                            Search.keyPressed(e.keyCode)
                    }
                    return !1
                },
                onTicketClick: function(e) {
                    if ("undefined" != typeof window.gtag && window.gtag("event", "TicketClick", {
                            event_category: "Ticket",
                            event_label: e
                        }), !$("#top-fb").hasClass("logged")) return Facebook.doLogin(), !1
                },
                closePopup: function(a) {
                    window.history.pushState && window.history.replaceState ? (e = a, window.history.pushState("nav", a, a)) : window.location = url
                },
                toggleMap: function() {
                    if ("undefined" == typeof block_ui || !block_ui) {
                        $("#viral-menu").find(".viral-menu-agenda-map").toggleClass("selected");
                        var e = window.location.pathname,
                            a = e.substr(-1);
                        "/" == a && (e = e.slice(0, -1)), Navigate.isLayout(Navigate.VIRAL_MAP) ? window.location = e.substr(0, e.length - 4) : window.location = e + "/map"
                    }
                },
                closeMap: function() {
                    $("#viral-menu").find(".viral-menu-agenda-map").toggleClass("selected"), window.location = window.location.pathname.replace("/map", "")
                },
                openHref: function(e) {
                    var a = $(e).attr("href");
                    a.indexOf("http") === -1 && (stopLink(), event.stopPropagation(), event.preventDefault(), Navigate.changeAddr($(e).attr("href")))
                },
                openNewWindow: function(e, a, t) {
                    window.open(e, a, t)
                },
                openSameWindow: function(e, a, t) {
                    return e = Navigate.getLocaleUrl(e), window.location = e, !1
                },
                openCta: function(e, a, t) {
                    return "undefined" != typeof event && (event.stopPropagation(), event.preventDefault()), "undefined" != typeof window.gtag && window.gtag("event", "CTAClick", {
                        event_category: "CTA",
                        event_label: a
                    }), window.open(e), !1
                },
                clickLink: function(e) {
                    "undefined" != typeof event && (event.stopPropagation(), event.preventDefault()), "undefined" != typeof window.gtag && window.gtag("event", "OutboundClick", {
                        event_category: "Outbound",
                        event_label: e
                    }), window.open(e)
                },
                changeAddr: function(a, t, n) {
                    if ("undefined" == typeof n && (n = !1), a != e || n) return e = a, f(), User.clearRefresh(), $("body").removeClass("viral-tag"), c && clearTimeout(c), c = setTimeout(function() {
                        t = t || !1, Search.reset(!0), User.close(), "undefined" != typeof Share && Share.close(), "undefined" != typeof Filters && Filters.close(), Sidebar.close(), u(a, !0)
                    }, 100), !1
                },
                currentLayout: function() {
                    var e = $("body");
                    return e.hasClass("viral-highlights") ? t : e.hasClass("viral-events") ? n : e.hasClass("viral-posts") ? i : e.hasClass("viral-info") ? r : e.hasClass("viral-map") ? o : e.hasClass("viral-error") ? a : e.hasClass("viral-events-404") ? s : -1
                },
                isLayout: function(e) {
                    return Navigate.currentLayout() == e
                },
                changeLang: function(e) {
                    window.location = "/?locale=" + e
                },
                changeUrl: function(e) {
                    window.location = "/" + $("option:selected", e).val() + "/"
                },
                setLocal: function(e) {
                    $("body").removeClass("jumbo-video viral-events viral-highlights viral-posts viral-map viral-tag viral-info viral-error viral-events-404").addClass(e)
                },
                VIRAL_HIGHLIGHTS: t,
                VIRAL_EVENTS: n,
                VIRAL_POSTS: i,
                VIRAL_INFO: r,
                VIRAL_MAP: o,
                VIRAL_ERROR: a,
                VIRAL_EVENTS_EMPTY: s
            };
        window.Navigate = m
    }(),
    function() {
        var e, a, t, n, i, o, r = null,
            s = !1,
            l = new Array,
            c = null,
            d = {},
            u = 3,
            p = function(e) {
                r = e, s = !0;
                var t;
                n.hide(), selectedIdx = 0, e = e.results;
                var i = {
                    pages: [],
                    events: [],
                    regions: [],
                    no_results_title: a.data("no-results"),
                    region_title: a.data("region-title"),
                    page_title: a.data("page-title"),
                    event_title: a.data("event-title")
                };
                for (var o in e) {
                    t = e[o];
                    var l = !1,
                        c = !1,
                        d = !1,
                        u = !1;
                    switch (o.substring(0, 1)) {
                        case "p":
                            var p = t.picture;
                            (null == p || "" == p || "https://www.viralagenda.com" == p || "https://cdn.viralagenda.com" == p || p.includes("fbcdn") || p.includes("fbexternal") || p.includes("facebook.com")) && (p = cdn_url + "/images/common/no-page-photo.png"), i.pages.push({
                                name: t.name,
                                img: p,
                                address: address = !(!t.street && !t.city) && t.street + (t.street && t.city ? " - " : "") + t.city,
                                link: site_url + "p/" + t.username
                            });
                            break;
                        case "r":
                            1 == t.type && (l = !0), 2 == t.type && (c = !0), 3 == t.type && (d = !0), ("Badajoz" === t.name || "CÃ¡ceres" === t.name || "MÃ©rida" === t.name || "Plasencia" === t.name) && t.type > 1 && (u = !0, c = falseisAtom = l = !1), i.regions.push({
                                name: t.name,
                                img: t.img,
                                link: site_url + t.slug,
                                isMunicipality: c,
                                isDistrict: l,
                                isCity: u,
                                isAtom: d
                            });
                            break;
                        case "e":
                            i.events.push({
                                name: t.name,
                                img: "" === t.picture ? "https://graph.facebook.com/" + t.ex_id + "/picture?type=square" : cdn_url + t.picture,
                                time: t.time,
                                link: site_url + "events/" + o.substring(2) + "/" + t.slug
                            })
                    }
                }
                i.has_pages = i.pages.length > 0, i.has_events = i.events.length > 0, i.has_regions = i.regions.length > 0, i.no_results = !i.has_pages && !i.has_events && !i.has_regions, $("#viral-search-scroll", a).remove(), a.append(Mustache.render(searchTemplate, i)), $(".viral-search-hover").removeClass("viral-search-hover"), $("ul li:eq(0)", a).addClass("viral-search-hover");
                var v = 0;
                $("li", a).each(function() {
                    $(this).attr("name", "search-result-" + v).attr("count", v), $(this).hover(function() {
                        $(".viral-search-hover").removeClass("viral-search-hover"), $(this).addClass("viral-search-hover")
                    }), v++
                })
            },
            v = function(e) {
                if (s) {
                    var t = $(".viral-search-hover", a),
                        n = parseInt(t.attr("count"));
                    switch (e) {
                        case 13:
                            "page" == t.data("search-type") ? window.location = $("a", t).attr("href") : Navigate.changeAddr($("a", t).attr("href"), !0);
                            break;
                        case 38:
                            t.removeClass("viral-search-hover");
                            var i = n - 1;
                            i < 0 && (i = $("li", a).length - 1), $('[name="search-result-' + i + '"]', a).addClass("viral-search-hover");
                            break;
                        case 40:
                            t.removeClass("viral-search-hover");
                            var o = n + 1;
                            o >= $("li", a).length && (o = 0), $('[name="search-result-' + o + '"]', a).addClass("viral-search-hover")
                    }
                    return !1
                }
            },
            g = function() {
                var e = t.val().split(" "),
                    a = "";
                for (var n in e) e[n].length > 2 && (a += 0 == a.length ? e[n] : " " + e[n]);
                return 0 == a.length ? null : a
            },
            h = function(e, a) {
                l.push([e, a])
            },
            f = function(e) {
                for (var a in l)
                    if (l[a][0] == e) return l[a][1];
                return null
            },
            m = function(e) {
                d = {}, $.grep(viral_nodes, function(a) {
                    var t;
                    if (a.name.toLowerCase().latinise().indexOf(e.toLowerCase().latinise()) > -1 && (t = cdn_url + "/images" + site_url + "regions/" + a.slug + ".png", a.type = 1, a.link = a.slug, b(a, t)), 1 != v_structure_type)
                        for (var n in a.children) {
                            var i = a.children[n];
                            i.name.toLowerCase().latinise().indexOf(e.toLowerCase().latinise()) > -1 && (t = cdn_url + "/images" + site_url + "regions/" + a.slug + "/" + i.slug + ".png", i.type = 2, i.link = a.slug + "/" + i.slug, b(i, t));
                            for (var o in i.atoms) {
                                var r = i.atoms[o];
                                r.name.toLowerCase().latinise().indexOf(e.toLowerCase().latinise()) > -1 && (t = cdn_url + "/images" + site_url + "regions/" + a.slug + "/" + i.slug + "/" + r.slug + ".png", r.type = 3, r.link = a.slug + "/" + i.slug + "/" + r.slug, b(r, t))
                            }
                        }
                })
            },
            b = function(e, a) {
                var t = Object.keys(d).length;
                if (t !== u) {
                    var n = {};
                    n.name = e.name, n.slug = e.link, n.type = e.type, n.img = a, d["r_" + e.id] = n
                }
            },
            w = function() {
                var e = g();
                return null == e ? void p({}) : (m(e), void(null != (data = f(e)) ? p(data) : (null != c && clearTimeout(c), c = setTimeout(function() {
                    n.show(), $.getJSON(site_url + "search", {
                        term: e
                    }, function(a) {
                        n.hide(), $.extend(a.results, d), a && (null == a || "" == a ? Search.reset() : (i = a, p(a), h(e, a)))
                    })
                }, 300))))
            },
            k = function() {
                $("#viral-menu").removeClass("viral-search-mode"), "" == t.val() && t.val(o)
            },
            y = function() {
                $("#viral-menu").removeClass("viral-search-mode").addClass("viral-search-mode"), t.val() == o && t.val("")
            },
            _ = {
                init: function() {
                    e = $("#viral-sidebar"), a = $("#viral-search", e), t = $("#viral-search-autocomplete", e), n = $("#viral-search-loader", e), o = t.val(), t.blur(k).focus(y), t.bind("input propertychange", w), t.focus(), null != r && p(r)
                },
                sidebar: function() {
                    if ("undefined" == typeof block_ui || !block_ui) {
                        var e = function() {
                                Search.init(), Sidebar.setSelected($("#viral-menu a.menu-link-search")), $("#viral-sidebar .mobile-content .menu-link:nth(1)").addClass("selected")
                            },
                            a = function() {
                                Sidebar.removeSelected(), $("#viral-sidebar .mobile-content .menu-link.selected").removeClass("selected")
                            };
                        Sidebar.open(sidebarSearchTemplate, e, a)
                    }
                },
                keyPressed: v,
                reset: function() {
                    n.hide(), setTimeout(function() {
                        $("#viral-search-scroll", a).remove()
                    }, 300), s = !1
                }
            };
        window.Search = _
    }(),
    function() {
        var e = null,
            a = null,
            t = null,
            n = !1,
            i = {
                init: function() {},
                detectClickOutside: function() {
                    $(document).click(function(e) {
                        var a = $(e.target);
                        if (!a.closest("#viral-sidebar").length)
                            if (a.hasClass("icon-menu-item") || a.hasClass("menu-label") || a.hasClass("menu-link")) {
                                if (a.hasClass("selected") || a.parent().hasClass("selected")) return stopLink(e), void Sidebar.close()
                            } else if (!a.closest("#viral-sidebar").length && $("#viral-sidebar").is(":visible")) return void Sidebar.close()
                    })
                },
                open: function(i, o, r) {
                    UI.checkStylesLoaded(), t = {
                        content: i,
                        onOpen: o,
                        onClose: r
                    }, e && e(), clearTimeout(a), e = r, n = !0, $("#viral-sidebar .mobile-content").html($("#viral-menu-right-icons .options").html()), $("#viral-sidebar .content").html(i), $(":root").css("overflow", "hidden"), Sidebar.detectClickOutside(), setTimeout(function() {
                        o && o(), 0 == $("body.sidebar").length && $("body").addClass("sidebar"), UI.infoResize()
                    }, 100)
                },
                over: function() {
                    clearTimeout(a)
                },
                close: function() {
                    return $("#viral-search-autocomplete").is(":focus") ? void $("#viral-search-autocomplete").blur(Sidebar.close) : (e && e(), void($("body").hasClass("sidebar") && ($(":root").css("overflow-y", "scroll"), $(document).off("click"), n = !1, $("body").removeClass("sidebar"), $(".icon-menu-item").blur(), Youtube.pause())))
                },
                toggle: function(e) {
                    "undefined" != typeof block_ui && block_ui || ($("body").hasClass("sidebar") ? Sidebar.close() : null == t ? User.sidebar() : this.open(t.content, t.onOpen, t.onClose))
                },
                setSelected: function(e) {
                    e.addClass("selected")
                },
                clearLastAction: function() {
                    t = null
                },
                removeSelected: function() {
                    $("#viral-menu-right-icons").find("a").removeClass("selected")
                }
            };
        window.Sidebar = i
    }(),
    function() {
        var e, a, t, n, i, o, r = 1,
            s = 2,
            l = 3,
            c = function() {
                W($(this))
            },
            d = /^(?:[\u00c0-\u01ffa-zA-Z'-]){3,}$/i,
            u = !1,
            p = null,
            v = null,
            g = !1,
            h = "AuthorizationBearer",
            f = !1,
            m = 1,
            b = "",
            w = !1,
            k = !1,
            y = function(e, a) {
                a = a || window.event;
                var t = a.target || a.srcElement;
                $(t).parent().parent().find(".popup-page-info").show()
            },
            _ = function(e, a) {
                a = a || window.event;
                var t = a.target || a.srcElement;
                $(t).parent().parent().find(".popup-page-info").hide()
            },
            C = function(e) {
                null == e && (e = 1), null == m && (m = 1), t = setTimeout(P, 1500), $.ajax({
                    url: site_url + "connect/pagesranking",
                    dataType: "json",
                    data: {
                        page: e,
                        type: m
                    },
                    success: T,
                    error: function(e) {
                        Loader.hide()
                    }
                })
            },
            T = function(e) {
                S();
                var a = e.content,
                    t = (a.page - 1) * a.limit;
                a.ord = function() {
                    return ++t
                }, a.selected = function() {
                    return null != p && p.id == this.id
                }, a.showPager = a.total > a.limit, a.pages = [];
                var n = a.total / a.limit + (Math.round(a.total % a.limit == 0) ? 0 : 1);
                if (a.showPager) {
                    a.pages = [];
                    for (var i, o = 5, r = 1; r <= n; r++) a.pages.push({
                        page: r,
                        current: r == a.page ? "selected" : ""
                    }), r == a.page && (i = r - 1);
                    for (var s = 0, l = 0, r = i; r > 0 && s < 2; r--) s++;
                    for (var r = i; r < a.pages.length && l + s <= o; r++) l++;
                    l + s < o && (s = Math.max(0, s + (o - (l + s)))), a.pages = a.pages.splice(i - s, o)
                }
                for (var c = 0; c < e.content.ranking.length; c++) {
                    if (a.ranking[c].hasImage = !0, "" === a.ranking[c].thumbnail || null == a.ranking[c].thumbnail || "null" === a.ranking[c].thumbnail) a.ranking[c].hasImage = !1;
                    else {
                        var d = a.ranking[c].thumbnail;
                        d = d.replace("?type=large", "").replace("/users/", "/users/thumbnails/"), d.indexOf("fbcdn") !== -1 ? a.ranking[c].thumbnail = "https://graph.facebook.com/" + a.ranking[c].username + "/picture" : d.indexOf("graph.facebook") === -1 ? a.ranking[c].thumbnail = cdn_url + "/" + d : a.ranking[c].thumbnail = d
                    }
                    0 == m && (a.ranking[c].likes = parseInt(e.content.ranking[c].likes) - Math.floor(4e3 * Math.random()))
                }
                $("#viral-user-leaderboard").html(Mustache.render(drawLikesTemplate, a));
                var u;
                m ? ($("ul#leaderboard-select li:eq(0)").addClass("selected"), $("ul#leaderboard-select li:eq(1)").removeClass("selected"), u = "View Month") : ($("ul#leaderboard-select li:eq(1)").addClass("selected"), $("ul#leaderboard-select li:eq(0)").removeClass("selected"), u = "View Total")
            },
            L = function(e, a) {
                n = e, i = a
            },
            P = function() {
                $("#viral-user-loading").show()
            },
            S = function() {
                $("#viral-user-loading").hide(), clearTimeout(t)
            },
            E = function(e, a) {
                t = setTimeout(P, 1500), $.ajax({
                    url: site_url + "follow/following",
                    dataType: "json",
                    data: {
                        page: e,
                        search: a
                    },
                    success: Y,
                    error: function(e) {
                        S()
                    }
                })
            },
            x = function(e, t) {
                if (null === e && (e = 1), g = "undefined" != typeof t) {
                    if (t === b) return;
                    clearTimeout(a), a = setTimeout(E, 400, e, t), b = t
                } else E(e, t)
            },
            A = function() {
                var e = $("#viral-event").attr("data-id");
                Loader.show();
                var a = User.getUser();
                return null == a ? void User.showAuth($(this), !0) : void $.ajax({
                    url: site_url + "follow/pinevent",
                    dataType: "json",
                    data: {
                        event: e
                    },
                    success: function(e) {
                        Loader.hide(), 0 != e.type && ($("#viral-event").find("a.saved-event").hasClass("selected") ? ($("#viral-event").find("a.saved-event").hide(), $("#viral-event").find("a.saved-event").removeClass("selected"), $("#viral-event").find("a.save-event").css("display", "block")) : ($("#viral-event").find("a.saved-event").addClass("selected"), $("#viral-event").find("a.save-event").hide(), $("#viral-event").find("a.saved-event").css("display", "block")))
                    },
                    error: function(e) {
                        Loader.hide()
                    }
                })
            },
            I = function() {
                f = !0, $.ajax({
                    url: site_url + "follow/import",
                    dataType: "json",
                    data: {
                        access_token: Facebook.getAccessToken()
                    },
                    success: Y,
                    error: function(e) {
                        $("#viral-user-loading").hide()
                    }
                })
            },
            j = function(e, a) {
                w = a, e && ($("#viral-user, #viral-user-background").remove(), $("body").append(followingTemplate), $("#viral-user-following-search input").keyup(M).change(M), User.setHtmlInactive());
                var t;
                $("#viral-user-loading").show(), null !== (t = Facebook.getAccessToken()) && (Facebook.getPermissionValue("user_likes") ? User.importFacebookAjax() : (Facebook.setCallback(User.importFacebookAjax), Facebook.doLogin("user_likes")))
            },
            U = !1,
            F = function() {
                var e = User.getUser();
                return null == e ? void User.showAuth($(this), !0) : void(U || (U = !0, Loader.show(), $.ajax({
                    url: site_url + "follow/toggle",
                    dataType: "json",
                    data: N(),
                    success: function(e) {
                        Loader.hide();
                        var a = $("#viral-footer-events a.follow, .viral-footer-page a.follow, #viral-menu-agenda-actions a.follow");
                        U = !1, 1 == e.type && 1 == e.content.isFollowing ? a.removeClass("selected").addClass("selected") : a.removeClass("selected"), 1 == e.type && 1 == e.content.isFollowing && 1 == e.content.isFirst && O()
                    },
                    error: function(e) {
                        Loader.hide(), U = !1
                    }
                })))
            },
            O = function(e) {
                var e = e || window.event;
                stopLink(e), Sidebar.close(), "undefined" != typeof Share && Share.close(), "undefined" != typeof Alert && Alert.close(), $("#viral-user, #viral-user-background").remove(), $("body").append(importFollowingTemplate), User.setHtmlInactive()
            },
            R = function() {
                if (null !== User.getUser() && (ContentLoader.currentPageType() == ContentLoader.PAGE || ContentLoader.currentPageType() == ContentLoader.PROMOTER)) {
                    var e = $("body").hasClass("viral-events") ? $("#viral-events") : $("#viral-posts"),
                        a = parseInt(e.attr("data-p"));
                    if (a > 1) return;
                    if (U) return;
                    U = !0, $.ajax({
                        url: site_url + "follow/check",
                        dataType: "json",
                        data: N(),
                        success: function(e) {
                            var a = $("#viral-footer-events a.follow, .viral-footer-page a.follow, #viral-menu-agenda-actions a.follow");
                            e.content.show ? a.show() : a.hide(), U = !1, 1 == e.type && 1 == e.content.isFollowing ? a.removeClass("selected").addClass("selected") : a.removeClass("selected")
                        },
                        error: function(e) {
                            U = !1
                        }
                    })
                }
            },
            N = function() {
                var e = ContentLoader.getParams(),
                    a = l,
                    t = null,
                    n = null;
                return null != e.page ? (a = s, n = e.page) : null != e.category ? (a = r, n = e.category, t = e.node) : n = e.category, {
                    type: a,
                    object_id: n,
                    node: t
                }
            },
            M = function() {
                var e = $(this);
                x(1, e.val())
            },
            V = function(e) {
                m = e, C(1, e)
            },
            B = function() {
                $("#viral-user-following-search input").val("").trigger("change")
            },
            z = '\t\t<ul id="follows">\t\t{{#follows}}\t\t\t<li data-type="{{type}}" data-object_id="{{object_id}}" data-node_id="{{node_id}}">\t\t\t\t<div class="icon">{{{category}}}</div><div class="thumb">{{{thumbnail}}}</div><div class="text"><a class="viral-linked" rel="noopener" target="_blank" href="' + site_url + 'p/{{username}}">{{name}}</a></div>\t\t\t\t<div class="onoffswitch">\t\t\t\t    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" onchange="javascript:User.checkFollow(this);" id="onoffswitch{{type}}{{object_id}}" {{checked}}>\t\t\t\t    <label class="onoffswitch-label" for="onoffswitch{{type}}{{object_id}}">\t\t\t\t        <span class="onoffswitch-inner"></span>\t\t\t\t        <span class="onoffswitch-switch"></span>\t\t\t\t    </label>\t\t\t\t</div>\t\t\t</li>\t\t{{/follows}}\t\t</ul>\t\t{{#showPager}}\t\t<ul id="follows-pager">\t\t{{#pages}}\t\t\t<li onclick="javascript:User.goTo({{page}});" class="{{current}}">{{page}}</li>\t\t{{/pages}}\t\t</ul>\t\t{{/showPager}}\t\t',
            q = '        <ul id="follows">        {{#follows}}            <li data-type="{{type}}" data-page_id="{{page_id}}" data-object_id="{{ex_id}}">                <div class="icon" style="width:15px;">{{{category}}}</div><div class="thumb">{{{thumbnail}}}</div><div class="text"><a class="viral-linked" rel="noopener" target="_blank" href="{{user_link}}">{{name}}</a></div>        \t\t{{#is_active}}                <div class="onoffswitch">                    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" onchange="javascript:User.checkManagedPage(this);" id="onoffswitch{{username}}" {{checked}}>                    <label class="onoffswitch-label" for="onoffswitch{{username}}">                        <span class="onoffswitch-inner"></span>                        <span class="onoffswitch-switch"></span>                    </label>                </div>        \t\t{{/is_active}}        \t\t{{^is_active}}\t        \t\t{{#is_pending}}\t        \t\t<a class="link-suggest-page pending">Sugerida! Em aprovaÃ§Ã£o...</a>\t        \t\t{{/is_pending}}\t        \t\t{{^is_pending}}\t        \t\t<a class="link-suggest-page" onclick="javascript:User.suggestPage(this);">Activar esta pÃ¡gina</a>\t        \t\t{{/is_pending}}        \t\t{{/is_active}}            </li>        {{/follows}}        </ul>        {{#showPager}}        <ul id="follows-pager">        {{#pages}}            <li onclick="javascript:User.goToPages({{page}});" class="{{current}}">{{page}}</li>        {{/pages}}        </ul>        <p style="font-size: 12px;width: 100%;float: left;clear: left;text-align: center;margin-top: 18px;"><span class="simple-line-icons-127" style="margin: 0px 7px 0px 0px;"></span>Os eventos das pÃ¡ginas activas serÃ£o periodicamente detectados pela Viral e publicados apÃ³s aprovaÃ§Ã£o</p>        {{/showPager}}        ',
            H = function() {
                $("#viral-user-following-search").find(".closeBtnSearch").hide(), B()
            },
            Y = function(e) {
                S();
                var a = e.content;
                p.follow_count = a.total, a.category = function() {
                    var e = this,
                        a = "";
                    switch (parseInt(e.type)) {
                        case 1:
                            a = "simple-line-icons-84";
                            break;
                        case 2:
                            1 == e.item_type ? a = "simple-line-icons-149" : 2 == e.item_type ? a = "simple-line-icons-19" : 3 == e.item_type ? a = "simple-line-icons-149" : 4 == e.item_type && (a = "simple-line-icons-19");
                            break;
                        case 3:
                            a = "simple-line-icons-84"
                    }
                    return '<span class="' + a + '"></span>'
                }, a.thumbnail = function() {
                    var e = this,
                        a = "";
                    switch (parseInt(e.type)) {
                        case 1:
                            a = '<span class="icon-category_' + e.icon + '"></span>';
                            break;
                        case 2:
                            a = '<img class="thumbnail" src="' + e.icon + '" />';
                            break;
                        case 3:
                            a = '<span class="simple-line-icons-44"></span>'
                    }
                    return a
                }, a.checked = function() {
                    return 1 == this.status ? "checked" : ""
                }, a.showPager = a.total > a.limit, a.pages = [];
                var t = a.total / a.limit + (Math.round(a.total % a.limit == 0) ? 0 : 1);
                if (a.showPager) {
                    a.pages = [];
                    for (var n, i = 5, o = 1; o <= t; o++) a.pages.push({
                        page: o,
                        current: o == a.page ? "selected" : ""
                    }), o == a.page && (n = o - 1);
                    for (var r = 0, s = 0, o = n; o > 0 && r < 2; o--) r++;
                    for (var o = n; o < a.pages.length && s + r <= i; o++) s++;
                    s + r < i && (r = Math.max(0, r + (i - (s + r)))), a.pages = a.pages.splice(n - r, i)
                }
                $("#viral-user-following-search, #viral-user-following, #viral-user-following-import, #viral-user-following-no-content").removeClass("selected"), 0 == a.total ? f ? $("#viral-user-following-no-content").addClass("selected") : g ? $("#viral-user-following-search,#viral-user-following-no-content").addClass("selected") : v ? $("#viral-user-following-info").addClass("selected") : $("#viral-user-following-import,#viral-user-following-info").addClass("selected") : ($("#viral-user-following-search, #viral-user-following").addClass("selected"), $("#viral-user-following").html(Mustache.render(z, a))), g && ("" === M ? $("#viral-user-following-search").find(".closeBtnSearch").hide() : $("#viral-user-following-search").find(".closeBtnSearch").show()), f = !1
            },
            D = function(e) {
                Loader.show(), $.ajax({
                    url: site_url + "connect/refreshpageevents",
                    type: "POST",
                    dataType: "json",
                    data: {
                        access_token: Facebook.getAccessToken(),
                        page_id: e
                    },
                    success: G,
                    error: function(e) {
                        $("#viral-user-loading").hide()
                    }
                })
            },
            G = function() {
                location.reload()
            },
            J = function(e) {
                S();
                var a = e.content;
                p.has_managed_pages = !0, $("#suggest-event-manage").hide(), a.category = function() {
                    var e = this,
                        a = "simple-line-icons-149";
                    switch (parseInt(e.type)) {
                        case 1:
                        case 3:
                            a = "simple-line-icons-149";
                            break;
                        case 2:
                        case 4:
                            a = "simple-line-icons-19";
                            break;
                        default:
                            a = ""
                    }
                    return '<span class="' + a + '"></span>'
                }, a.thumbnail = function() {
                    var e = this,
                        a = "https://graph.facebook.com/" + e.ex_id + "/picture";
                    return thumbnail = '<img class="thumbnail" src="' + a + '" />'
                }, a.checked = function() {
                    return "undefined" != typeof this.status && 0 == this.status ? "" : 1 == this ? "checked" : ""
                }, a.user_link = function() {
                    return null == this.username || 5 == this.status ? "https://www.facebook.com/" + this.ex_id : site_url + "p/" + this.username
                }, a.is_active = function() {
                    return 0 == this.status ? this.checked = "" : this.checked = "checked", 1 == this.status || 0 == this.status ? 1 : 0
                }, a.is_pending = function() {
                    return 5 == this.status ? 1 : 0
                }, a.showPager = a.total > a.limit, a.pages = [];
                var t = a.total / a.limit + (Math.round(a.total % a.limit == 0) ? 0 : 1);
                if (a.showPager) {
                    a.pages = [];
                    var n, i, o = 5;
                    for (i = 1; i <= t; i++) a.pages.push({
                        page: i,
                        current: i == a.page ? "selected" : ""
                    }), i == a.page && (n = i - 1);
                    var r = 0,
                        s = 0;
                    for (i = n; i > 0 && r < 2; i--) r++;
                    for (i = n; i < a.pages.length && s + r <= o; i++) s++;
                    s + r < o && (r = Math.max(0, r + (o - (s + r)))), a.pages = a.pages.splice(n - r, o);
                }
                $("#viral-user-following-search, #viral-user-following, #viral-user-following-import, #viral-user-following-no-content").removeClass("selected"), 0 === a.total ? $("#viral-user-following-no-content").addClass("selected") : ($("#viral-user-following-search, #viral-user-following").addClass("selected"), $("#viral-user-following").html(Mustache.render(q, a))), User.setHtmlInactive(), f = !1
            },
            W = function(e) {
                var a = $("#viral-user"),
                    t = $("#viral-user-nav", a);
                $("li.selected", t).removeClass("selected"), $(".viral-screen.selected", a).removeClass("selected"), e.addClass("selected"), $(".viral-screen:nth(" + $(e, t).index() + ")", a).addClass("selected")
            },
            K = function() {
                $("#viral-user").addClass("viral-loading")
            },
            X = function() {
                $("#viral-user").removeClass("viral-loading")
            },
            Q = function(e) {
                1 == e.status && User.close(!1), Alert.show(void 0, e.message)
            },
            Z = function(e) {
                Cookies.setCookie(h, e, 30)
            },
            ee = function(e) {
                Facebook.isFacebookApp() || (u = !0, Z(e), $.ajax({
                    type: "POST",
                    url: site_url + "connect/authenticate",
                    dataType: "json",
                    success: function(e) {
                        1 === e.is_viral && te(e)
                    },
                    error: function(e) {
                        ae(), X()
                    }
                }))
            },
            ae = function(e) {
                var a, t = getParameterByName("showAuth"),
                    n = getParameterByName("lang"),
                    i = getParameterByName("locale"),
                    r = getParameterByName("time_id");
                if (null !== r && r.length > 0);
                else if (null !== n && n.length > 0);
                else if (null !== i && i.length > 0);
                else if (null !== t && t.length > 0) {
                    if (1 == parseInt(t)) User.showAuth();
                    else if (2 == parseInt(t)) User.showRegister();
                    else if (3 == parseInt(t)) {
                        k = !0;
                        var s = getParameterByName("email");
                        o = s, User.showRecover(getParameterByName("email"))
                    }
                    history.pushState && (a = window.location.protocol + "//" + window.location.host + window.location.pathname, window.history.pushState({
                        path: a
                    }, "", a))
                } else history.pushState && (a = window.location.protocol + "//" + window.location.host + window.location.pathname, window.history.pushState({
                    path: a
                }, "", a))
            },
            te = function(a) {
                if (Z(a.token), "/" == window.location.pathname || "/#" == window.location.pathname) window.location = "/" + a.account.account_id + "/home";
                else {
                    p = a.user, v = a.is_viral, p.hasNewsletter = 1 == p.newsletter, viral_user_account = a.account, p.follow_count = a.follow_count ? a.follow_count : 0, p.edit_events = "1" == a.user.edit_events ? 1 : 0;
                    var t = a.managed_pages ? a.managed_pages : null;
                    if (p.managed_pages = [], null != t)
                        for (var o = 0; o < t.length; o++) "1" == t[o].status && p.managed_pages.push(t[o]);
                    p.has_managed_pages = null != p.managed_pages && p.managed_pages.length > 0, p.has_fb_managed_pages = !1, "1" === a.has_page_ranking ? p.has_page_ranking = !0 : p.has_page_ranking = !1, 0 === v ? (p.has_fb_managed_pages = null != p.managed_pages && p.managed_pages.length > 0, "1" == init_account && (p.notviral = !0), $(".viral-test-box").show(), $(".viral-suggestfb-box").hide()) : p.isviral = !0, ($("body").hasClass("sidebar") || $("#viral-user-box").length > 0) && User.close(!1), $("body").removeClass("logged").addClass("logged");
                    var r = !1;
                    if (null != p.image && p.image.replace("?type=large", "").length > 0) {
                        var s = p.image.replace("?type=large", "").replace("/users/", "/users/thumbnails/");
                        s.indexOf("graph.facebook") === -1 ? s = cdn_url + "/" + s : 2 == account_id ? s = s + "?access_token=" + Facebook.getAccessToken() : r = !0, r ? e.html('<span class="simple-line-icons-2"></span><span class="menu-label entrar-label">Perfil</span>') : e.html('<img src="' + s + '"/><span class="menu-label entrar-label">Perfil</span>')
                    } else e.html('<span class="simple-line-icons-2"></span><span class="menu-label entrar-label">Perfil</span>');
                    R(), $("body").hasClass("sidebar") ? User.sidebar() : Sidebar.clearLastAction(), v || Facebook.getPermissions();
                    var l = getParameterByName("showAuth"),
                        c = getParameterByName("showManage");
                    if (null !== c && c && oe(), 3 == parseInt(l)) {
                        getParameterByName("email");
                        User.showRecover(getParameterByName("email"))
                    }
                    "undefined" != typeof n && n(this, i)
                }
                u = !1
            },
            ne = function() {
                $.ajax({
                    type: "POST",
                    url: site_url + "connect/logout",
                    dataType: "json",
                    success: function(e) {
                        p = null, viral_user_account = null, User.close(!1), Cookies.setCookie(h, null), Z(null), $("#viral-menu-user").hasClass("sidebar") && User.sidebar(), window.location = site_url + "home"
                    },
                    error: function(e) {
                        X()
                    }
                })
            },
            ie = function(e) {
                return w && "undefined" == typeof e ? void location.reload() : (w = !1, $("html").hasClass("inactive") && $(":root").css("overflow-y", "scroll"), $("html").removeClass("inactive"), $("#viral-menu").css("width", "100%"), $("#viral-user").css("overflow", "hidden"), $("#viral-user-box").removeClass("bounceInDown").addClass("bounceOutDown"), $("#viral-user-background").remove(), void setTimeout(function() {
                    $("#viral-user").remove(), n = void 0, i = void 0
                }, 1e3))
            },
            oe = function(e) {
                "undefined" == typeof e && (hasPagesActivated = !0);
                var e = e || window.event;
                stopLink(e), Sidebar.close(), "undefined" != typeof Share && Share.close(), "undefined" != typeof Alert && Alert.close(), $("#viral-user, #viral-user-background").remove(), $("body").append(managePagesTemplate), $("#viral-user-following-import").addClass("selected"), User.setHtmlInactive()
            },
            re = function(e) {
                var a = a || window.event;
                stopLink(a), Sidebar.close(), "undefined" != typeof Share && Share.close(), Alert.close(), $("#viral-user, #viral-user-background").remove(), $("body").append(managePagesTemplate), "undefined" == typeof e && (e = 1), se(e)
            },
            se = function(e) {
                t = setTimeout(P, 1e3), $.ajax({
                    url: site_url + "connect/managed",
                    dataType: "json",
                    data: {
                        page: e
                    },
                    success: J,
                    error: function(e) {
                        $("#viral-user-loading").hide()
                    }
                })
            },
            le = function() {
                $.ajax({
                    url: site_url + "connect/importmanagedpages",
                    dataType: "json",
                    data: {
                        access_token: Facebook.getAccessToken()
                    },
                    success: J,
                    error: function(e) {
                        $("#viral-user-loading").hide()
                    }
                })
            },
            ce = function() {
                "undefined" == typeof e && (hasPagesActivated = !0);
                var e = e || window.event;
                stopLink(e), Sidebar.close(), "undefined" != typeof Share && Share.close(), Alert.close(), $("#viral-user, #viral-user-background").remove(), $("body").append(managePagesTemplate), User.setHtmlInactive(), de()
            },
            de = function() {
                var e;
                $("#viral-user-loading").show(), null !== (e = Facebook.getAccessToken()) && (Facebook.getPermissionValue("manage_pages") ? Facebook.managePage(le) : (Facebook.setCallback(le), Facebook.doLogin("manage_pages")))
            };
        $("body").click(function(e) {
            $("html").hasClass("inactive") && ($(e.target).is("#viral-user") || $(e.target).is("#viral-sidebar") || $(e.target).closest("#viral-sidebar").length) && ie()
        });
        var ue = {
            init: function(a) {
                e = $("#viral-menu a.viral-menu-login"), Facebook.isFacebookApp() || (null != a ? te(a) : (token = Cookies.getCookie(h)) !== !1 ? ee(token) : ae())
            },
            login: te,
            show: function() {
                Sidebar.close(), null == p ? User.showAuth() : User.showProfile()
            },
            showRegister: function(e) {
                User.showAuth(), User.goToRegister()
            },
            showRecover: function(e) {
                UI.showAuth(), User.goToRecover(), "undefined" != typeof e && $("form.viral-user-container").find("input").val(e)
            },
            setHtmlInactive: function(e) {
                menu_width = $("#viral-menu").width(), $("html").addClass("inactive"), $(":root").css("overflow", "hidden"), $("#viral-menu").width(menu_width)
            },
            showAuth: function(e, a) {
                if ("undefined" == typeof authTemplate) return void UI.showAuth();
                Loader.hide(), stopLink(e), UI.checkStylesLoaded(), Sidebar.close(), "undefined" != typeof Share && Share.close(), "undefined" != typeof Alert && Alert.close(), "undefined" == typeof a && (a = !1), $("#viral-user, #viral-user-background").remove(), $("body").append(authTemplate), User.setHtmlInactive(), Input.init(), Select.init();
                var t = $("#viral-user-login form");
                t.validate({
                    rules: {
                        email: {
                            email: !0,
                            required: !0
                        },
                        password: {
                            required: !0
                        }
                    }
                }), $("#viral-user-login .viral-submit").click(function() {
                    if (t.valid()) {
                        K();
                        var e = t.serializeObject();
                        e.password = hex_md5(e.password), $.ajax({
                            type: "POST",
                            url: site_url + "connect/viral",
                            dataType: "json",
                            data: e,
                            success: function(e) {
                                X(), 0 == e.status ? Q(e) : (v = !0, te(e))
                            },
                            error: function(e) {
                                X()
                            }
                        })
                    }
                });
                var n = $("#viral-user-register form");
                n.validate({
                    rules: {
                        first_name: {
                            required: !0,
                            regex: d
                        },
                        last_name: {
                            required: !0,
                            regex: d
                        },
                        email: {
                            email: !0,
                            required: !0
                        },
                        password: {
                            required: !0,
                            minlength: 6
                        },
                        repeatPassword: {
                            required: !0,
                            equalTo: '#viral-user-register form input[name="password"]'
                        }
                    }
                }), $("#viral-user-register .viral-submit").click(function() {
                    if (n.valid()) {
                        var e = n.serializeObject();
                        delete e.repeatPassword, e.password = hex_md5(e.password), K(), $.ajax({
                            type: "POST",
                            url: site_url + "connect/register",
                            dataType: "json",
                            data: e,
                            success: function(e) {
                                X(), Q(e), 0 != e.status && te(e)
                            },
                            error: function(e) {
                                X()
                            }
                        })
                    }
                });
                var i = $("#viral-user-recover form");
                return i.validate({
                    rules: {
                        email: {
                            email: !0,
                            required: !0
                        }
                    }
                }), $(".viral-submit", i).click(function() {
                    if (i.valid()) {
                        var e = i.serializeObject();
                        K(), $.ajax({
                            type: "POST",
                            url: site_url + "connect/request-recover",
                            dataType: "json",
                            data: e,
                            success: function(e) {
                                X(), Q(e)
                            },
                            error: function(e) {
                                X()
                            }
                        })
                    }
                }), $("#viral-user #viral-user-nav li").click(c), User.goToLogin(), a ? void setTimeout(function() {
                    $(".viral-user-container.connect-login-continue").show()
                }, 250) : ("undefined" != typeof SuggestForm && User.setCallback(SuggestForm.userLogged), void(k && (k = !1, User.goToRecover())))
            },
            showProfile: function(e) {
                stopLink(e), $("#viral-user, #viral-user-background").remove();
                try {
                    null != p.image && (p.image.indexOf("graph.facebook") === -1 ? p.image = cdn_url + "/" + p.image.replace("/users/", "/users/thumbnails/").replace("/thumbnails/thumbnails/", "/thumbnails/") : p.image = p.image.replace("/users/", "/users/thumbnails/").replace("/thumbnails/thumbnails/", "/thumbnails/"))
                } catch (e) {}
                Youtube.pause(), "undefined" != typeof Share && Share.close(), User.setHtmlInactive();
                var a = [{
                    id: "1",
                    name: "Portugal",
                    url: "pt"
                }, {
                    id: "4",
                    name: "Espanha",
                    url: "es"
                }];
                $("body").append(Mustache.render(profileTemplate, jQuery.extend({
                    isViral: v,
                    countries: a
                }, p))), Input.init(), Select.init();
                var t = $("#viral-user-profile form.viral-user-container");
                t.validate({
                    ignore: ".no-validate",
                    rules: {
                        first_name: {
                            required: !0,
                            regex: d
                        },
                        last_name: {
                            required: !0,
                            regex: d
                        },
                        email_password: {
                            required: !0,
                            minlength: 6
                        },
                        email: {
                            email: !0,
                            required: !0
                        },
                        current_password: {
                            required: !0
                        },
                        password: {
                            required: !0,
                            minlength: 6
                        },
                        repeatPassword: {
                            equalTo: '#viral-user-profile form.viral-user-container input[name="password"]'
                        }
                    }
                }), User.getNewsletterStatus(p.email), $(".viral-submit", t).click(function() {
                    if (t.valid()) {
                        var e = t.serializeObject();
                        delete e.repeatPassword, e.password = e.password ? hex_md5(e.password) : null, null == e.password && delete e.password, e.email_password = e.email_password ? hex_md5(e.email_password) : null, null == e.email_password && delete e.email_password, null == e.email && delete e.email, e.current_password = e.current_password ? hex_md5(e.current_password) : null, null == e.current_password && delete e.current_password, e.newsletter = $('input[name="newsletter"]', t).is(":checked") ? 1 : 0, e.ranking = $('input[name="ranking"]', t).is(":checked") ? 1 : 0, K(), $.ajax({
                            type: "POST",
                            url: site_url + "connect/edit",
                            dataType: "json",
                            data: e,
                            success: function(e) {
                                X(), 1 == e.status ? (p = e.user, p.hasNewsletter = 1 == p.newsletter, viral_user_account = e.account, $("#viral-menu-user").hasClass("sidebar") && User.sidebar(), e.status = 0, Q(e)) : Q(e)
                            },
                            error: function(e) {
                                X()
                            }
                        })
                    }
                })
            },
            getNewsletterStatus: function(e) {
                $.ajax({
                    url: site_url + "connect/newsletterstatus",
                    dataType: "json",
                    type: "POST",
                    data: {
                        email: e
                    },
                    error: function(e) {},
                    success: function(e) {
                        switch (newsletter_status = e, e) {
                            case "Subscribed":
                                $("#viral-user-profile-cb").attr("checked", !0);
                                break;
                            default:
                                $("#viral-user-profile-cb").attr("checked", !1)
                        }
                    }
                })
            },
            editEmail: function() {
                var e = $("#viral-user-profile #editEmail");
                e.hasClass("open") ? ($("#viral-user-profile .viral-user-container-option.open").removeClass("open"), $("input", e).addClass("no-validate")) : ($("#viral-user-profile .viral-user-container-option.open").removeClass("open"), $("input", e).removeClass("no-validate"), e.addClass("open"))
            },
            closeEmail: function() {
                var e = $("#viral-user-profile #editEmail");
                $("#viral-user-profile .viral-user-container-option.open").removeClass("open"), $("input", e).addClass("no-validate")
            },
            editPassword: function() {
                var e = $("#viral-user-profile #editPassword");
                e.hasClass("open") ? ($("#viral-user-profile .viral-user-container-option.open").removeClass("open"), $("input", e).addClass("no-validate")) : ($("#viral-user-profile .viral-user-container-option.open").removeClass("open"), $("input", e).removeClass("no-validate"), e.addClass("open"))
            },
            clearRefresh: function() {
                w = !1
            },
            closePassword: function() {
                var e = $("#viral-user-profile #editPassword");
                $("#viral-user-profile .viral-user-container-option.open").removeClass("open"), $("input", e).addClass("no-validate")
            },
            close: ie,
            goToLogin: function() {
                W($("#viral-user #viral-user-nav li:first-child"))
            },
            goToRegister: function() {
                W($("#viral-user #viral-user-nav li:nth(1)"))
            },
            goToRecover: function() {
                "undefined" != typeof Alert && Alert.close(), W($("#viral-user #viral-user-nav li:nth(2)")), "undefined" != typeof o && $("form.viral-user-container").find("input").val(o)
            },
            logout: function() {
                K(), v ? ne() : Facebook.logout(ne)
            },
            sidebar: function() {
                if ("undefined" == typeof block_ui || !block_ui) {
                    var a = function() {
                            $("#viral-menu-user").addClass("sidebar"), Sidebar.setSelected(e)
                        },
                        t = function() {
                            Sidebar.removeSelected(), $("#viral-menu-user").removeClass("sidebar")
                        };
                    null == p ? Sidebar.open(Mustache.render(sidebarAuthTemplate), a, t) : Sidebar.open(Mustache.render(sidebarUserTemplate, p), a, t);
                    var n = {};
                    location.search.substr(1).split("&").forEach(function(e) {
                        n[e.split("=")[0]] = e.split("=")[1]
                    }), "undefined" != typeof n.locale && $("a.sidebar-auth-link,li.content-window a").each(function(e) {
                        var a;
                        "undefined" != typeof $(this).attr("href") && (a = $(this).attr("href").replace("/" + lang + "/", "/" + account_id + "/"), $(this).attr("href", a + "?locale=" + n.locale)), "undefined" != typeof $(this).attr("onclick") && (a = $(this).attr("onclick").replace("/" + lang + "/", "/" + account_id + "/"), $(this).attr("onclick", a))
                    })
                }
            },
            uploadChange: function(e) {
                Loader.show(), $("form#uploadForm")[0].submit()
            },
            uploadFinished: function(a, t) {
                Loader.hide(), p = a;
                var n = "/" + p.image;
                n = n.replace("?type=large", "").replace("/users/", "/users/thumbnails/"), n = cdn_url + n, e.html('<img src="' + n + '"/>'), $("#viral-user-content .user-upload .user-symbol img").remove(), $("#viral-user-content .user-upload .user-symbol").append('<img src="' + n + '"/>'), $("form#uploadForm")[0].reset(), Z(t)
            },
            resendEmail: function() {
                $.ajax({
                    type: "POST",
                    url: site_url + "connect/resend",
                    dataType: "json",
                    success: function(e) {
                        Alert.show(void 0, e.message)
                    },
                    error: function(e) {
                        X()
                    }
                })
            },
            pagesRanking: function(e) {
                stopLink(e), Sidebar.close(), "undefined" != typeof Share && Share.close(), Alert.close(), $("#viral-user, #viral-user-background").remove(), $("body").append(leaderboardpagesTemplate), $("#viral-user-following-search input").keyup(M).change(M), C(), User.setHtmlInactive()
            },
            following: function(e) {
                stopLink(e), Sidebar.close(), "undefined" != typeof Share && Share.close(), "undefined" != typeof Alert && Alert.close(), $("#viral-user, #viral-user-background").remove(), $("body").append(followingTemplate), $("#viral-user-following-search input").keyup(M).change(M), x(), User.setHtmlInactive()
            },
            leaderboard: function(e) {
                stopLink(e), Sidebar.close(), "undefined" != typeof Share && Share.close(), "undefined" != typeof Alert && Alert.close(), $("#viral-user, #viral-user-background").remove(), $("body").append(leaderboardTemplate), C(), User.setHtmlInactive()
            },
            checkFollow: function(e) {
                var a = $(e),
                    t = a.closest("li");
                $.ajax({
                    url: site_url + "follow/toggle",
                    dataType: "json",
                    data: {
                        type: t.data("type"),
                        object_id: t.data("object_id"),
                        node_id: t.data("node_id")
                    },
                    success: R
                })
            },
            checkManagedPage: function(e) {
                var a = $(e),
                    t = a.closest("li");
                $.ajax({
                    url: site_url + "connect/togglemanaged",
                    dataType: "json",
                    data: {
                        checked: a.is(":checked"),
                        object_id: t.data("page_id")
                    }
                })
            },
            suggestPage: function(e) {
                P();
                var a = $(e),
                    t = a.closest("li"),
                    n = "https://www.facebook.com/" + t.data("object_id"),
                    i = Facebook.getSignedRequest(),
                    o = Facebook.getAccessToken();
                $.ajax({
                    url: site_url + "suggest/importfacebook",
                    dataType: "json",
                    data: {
                        user_id: p.id,
                        url: n,
                        signedRequest: i,
                        accessToken: o,
                        managed: 1
                    },
                    error: function() {
                        alert("error")
                    },
                    success: function(a) {
                        S(), a.type ? ($(e).addClass("pending"), $(e).html("Sugerida! Em aprovaÃ§Ã£o..."), $(e).prop("onclick", null).off("click")) : alert("Ocorreu um erro. Por favor tenta mais tarde!")
                    }
                })
            },
            followInfo: function() {
                $("#viral-user-following-info").hasClass("selected") ? ($("#viral-user-following-info").removeClass("selected"), $("#viral-user-following-info").find(".viral-user-following-info-txt2").hide()) : ($("#viral-user-following-info").addClass("selected"), $("#viral-user-following-info").find(".viral-user-following-info-txt2").show())
            },
            leaderboardInfo: function() {
                $("#viral-user-leaderboard-info").hasClass("selected") ? $("#viral-user-leaderboard-info").removeClass("selected") : $("#viral-user-leaderboard-info").addClass("selected")
            },
            goTo: x,
            goToPages: se,
            goToRanking: C,
            followCurrent: F,
            rankingToggle: V,
            askManagePages: oe,
            getManagedPages: re,
            refreshPageEvents: D,
            importManagedPages: de,
            showPageInfo: y,
            hidePageInfo: _,
            reImportManagedPages: ce,
            importFacebook: j,
            pinEvent: A,
            importFacebookAjax: I,
            followCheck: R,
            askImport: O,
            closeSearchFollowing: H,
            setCallback: L,
            isLogged: function(e) {
                return null != p ? (e && e(), !0) : (u && setTimeout(function() {
                    User.isLogged(e)
                }, 250), !1)
            },
            getUser: function() {
                return p
            }
        };
        window.User = ue
    }(),
    function() {
        var e = function() {
                $(this).parent().removeClass("error filled").addClass("focus")
            },
            a = function() {
                $(this).parent().removeClass("focus filled"), $(this).val().length > 0 && $(this).parent().addClass("filled")
            },
            t = function() {
                $(this).val("").focus().blur()
            };
        window.Input = {
            init: function() {
                $('input[type="text"]:not(.processed), input[type="password"]:not(.processed)').each(function() {
                    $(this).addClass("processed").focus(e).blur(a)
                }), $('input[type="checkbox"]:not(.processed)').each(function() {
                    var e = $(this);
                    e.addClass("processed"), $("span", e.parent()).click(function() {
                        e.prop("checked", !e.prop("checked"))
                    })
                })
            },
            reset: t
        }
    }();
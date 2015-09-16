

(function (a) {
    var b = {
        width : 960,
        auto_play : true,
        duration: 7e3,
        next_btn: ".next-slide",
        prev_btn: ".previous-slide",
        anim_duration: 1e3,
        anim_easing: "easeInOutExpo"
    }, c, d, e, f, g, h, i, j, k, l = false,
        m = false,
        n = 0,
        o = function (a) {
            return a.hasClass("left") ? "left" : "right"
        }, p = function (b) {
            var d = o(b),
                g = {
                    top: 0
                };
            g[d] = (a(f).width() - c.width) / 2;
            e.animate({
                backgroundColor: b.attr("data-background-color")
            }, 200, "linear", function () {
                var e = b.attr("data-background");
                if (d == "right") {
                    h = "-" + h
                }
                f.css({
                    backgroundImage: "url(" + e + ")",
                    left: h
                }).stop().animate({
                    left: 0,
                    top: 0
                }, c.anim_duration, c.anim_easing);
                b.stop().animate(g, c.anim_duration, c.anim_easing, function () {
                    m = false
                })
            });
            if (!l && c.auto_play) {
                k = setTimeout(s.next_banner, c.duration)
            }
        }, q = function () {
            ++n
        }, r = function (b, d) {

            if (n != i.length) {
                setTimeout(r(b, d), 250);
                return
            }
            var e = o(b),
                g = {
                    top: 0
                }, h = {
                    top: 0
                };
            m = true;
            g[e] = -945;
            b.stop().animate(g, c.anim_duration, c.anim_easing, function () {
                p(d)
            });
            if ("right" == e) {
                h = {
                    left: "-" + a(f).width()
                }
            } else {
                h = {
                    left: a(f).width()
                }
            }
            f.stop().animate(h, c.anim_duration, c.anim_easing)
        }, s = {
            init: function (k) {
                var l = this;
                k = k || {};
                c = a.extend(b, k);
                i = a(this).find("li");
                u = a(this).find("ul");
                j = i.first();
                e = a(this).find(".background");
                f = a(this).find(".image");
                g = a(c.next_btn, this);
                h = a(c.prev_btn, this);
                d = a(this);
                active = false;
                d.css("width", a(d).width() - "px");
                u.animate({opacity:1},500);
                g.click(function () {
                    if (!m) {
                        //console.log(this);
                        d.airslider("stop");
                        d.airslider("next_banner")
                    }
                    return false
                });
                h.click(function () {
                    if (!m) {
                        d.airslider("stop");
                        d.airslider("previous_banner")
                    }
                    return false;                    
                });
                var n = i.each(function (b) {
                    var c = {
                        top: "auto"
                    }, d = o(a(this));
                    c[d] = "-955px";
                    a(this).css(c);
                    a.preload_images(a(this).attr("data-background"), function () {
                        q()
                    })
                });
                p(j);
                return n
            },
            next_banner: function () {
               
                var a = j;
                j = j.next();
                if (j.length == 0) {
                    j = i.first()
                }
                r(a, j);
            },
            previous_banner: function () {
                var a = j;
                j = j.prev();
                if (j.length == 0) {
                    j = i.last()
                }
                r(a, j);
            },
            stop: function () {
                clearTimeout(k);
                l = true
            }
        };
    a.fn.airslider = function (b) {
        if (s[b]) {
            return s[b].apply(this, Array.prototype.slice.call(arguments, 1))
        } else if (typeof b === "object" || !b) {
            return s.init.apply(this, arguments)
        } else {
            a.error("Method " + b + " does not exist")
        }
    }
})(this.jQuery);
(function (a) {
    a.preload_images = function () {
        var b, c = [],
            d, e = function () {};
        if (a.isFunction(arguments[arguments.length - 1])) {
            e = arguments[arguments.length - 1]
        }
        for (b = 0; b < arguments.length; b++) {
            if (!a.isFunction(arguments[b])) {
                d = a("<img />", {
                    src: arguments[b]
                }).load(e);
                c.push(d)
            }
        }
    }
})(this.jQuery)
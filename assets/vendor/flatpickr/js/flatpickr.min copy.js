/* flatpickr v4.6.9,, @license MIT */
!(function (e, t) {
  "object" == typeof exports && "undefined" != typeof module
    ? (module.exports = t())
    : "function" == typeof define && define.amd
    ? define(t)
    : ((e =
        "undefined" != typeof globalThis ? globalThis : e || self).flatpickr =
        t());
})(this, function () {
  "use strict";
  var e = function () {
    return (e =
      Object.assign ||
      function (e) {
        for (var t, n = 1, a = arguments.length; n < a; n++)
          for (var i in (t = arguments[n]))
            Object.prototype.hasOwnProperty.call(t, i) && (e[i] = t[i]);
        return e;
      }).apply(this, arguments);
  };
  function t() {
    for (var e = 0, t = 0, n = arguments.length; t < n; t++)
      e += arguments[t].length;
    var a = Array(e),
      i = 0;
    for (t = 0; t < n; t++)
      for (var o = arguments[t], r = 0, l = o.length; r < l; r++, i++)
        a[i] = o[r];
    return a;
  }
  var n = [
      "onChange",
      "onClose",
      "onDayCreate",
      "onDestroy",
      "onKeyDown",
      "onMonthChange",
      "onOpen",
      "onParseConfig",
      "onReady",
      "onValueUpdate",
      "onYearChange",
      "onPreCalendarPosition",
    ],
    a = {
      _disable: [],
      allowInput: !1,
      allowInvalidPreload: !1,
      altFormat: "F j, Y",
      altInput: !1,
      altInputClass: "form-control input",
      animate:
        "object" == typeof window &&
        -1 === window.navigator.userAgent.indexOf("MSIE"),
      ariaDateFormat: "F j, Y",
      autoFillDefaultTime: !0,
      clickOpens: !0,
      closeOnSelect: !0,
      conjunction: ", ",
      dateFormat: "Y-m-d",
      defaultHour: 12,
      defaultMinute: 0,
      defaultSeconds: 0,
      disable: [],
      disableMobile: !1,
      enableSeconds: !1,
      enableTime: !1,
      errorHandler: function (e) {
        return "undefined" != typeof console && console.warn(e);
      },
      getWeek: function (e) {
        var t = new Date(e.getTime());
        t.setHours(0, 0, 0, 0),
          t.setDate(t.getDate() + 3 - ((t.getDay() + 6) % 7));
        var n = new Date(t.getFullYear(), 0, 4);
        return (
          1 +
          Math.round(
            ((t.getTime() - n.getTime()) / 864e5 - 3 + ((n.getDay() + 6) % 7)) /
              7
          )
        );
      },
      hourIncrement: 1,
      ignoredFocusElements: [],
      inline: !1,
      locale: "default",
      minuteIncrement: 5,
      mode: "single",
      monthSelectorType: "dropdown",
      nextArrow:
        "<svg version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 17 17'><g></g><path d='M13.207 8.472l-7.854 7.854-0.707-0.707 7.146-7.146-7.146-7.148 0.707-0.707 7.854 7.854z' /></svg>",
      noCalendar: !1,
      now: new Date(),
      onChange: [],
      onClose: [],
      onDayCreate: [],
      onDestroy: [],
      onKeyDown: [],
      onMonthChange: [],
      onOpen: [],
      onParseConfig: [],
      onReady: [],
      onValueUpdate: [],
      onYearChange: [],
      onPreCalendarPosition: [],
      plugins: [],
      position: "auto",
      positionElement: void 0,
      prevArrow:
        "<svg version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 17 17'><g></g><path d='M5.207 8.471l7.146 7.147-0.707 0.707-7.853-7.854 7.854-7.853 0.707 0.707-7.147 7.146z' /></svg>",
      shorthandCurrentMonth: !1,
      showMonths: 1,
      static: !1,
      time_24hr: !1,
      weekNumbers: !1,
      wrap: !1,
    },
    i = {
        weekdays: {
            shorthand: ["الأحد", "الإثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة", "السبت"],
            longhand: [
              "الأحد",
              "الإثنين",
              "الثلاثاء",
              "الأربعاء",
              "الخميس",
              "الجمعة",
              "السبت",
            ],
          },
          months: {
            shorthand: [
              "يناير", "فبراير", "مارس", "أبريل", "مايو", "يونيو", "يوليو", "أغسطس", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"
            ],
            longhand: [
              "يناير",
              "فبراير",
              "مارس",
              "أبريل",
              "مايو",
              "يونيو",
              "يوليو",
              "أغسطس",
              "سبتمبر",
              "أكتوبر",
              "نوفمبر",
              "ديسمبر",
            ],
          },
      daysInMonth: [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31],
      firstDayOfWeek: 0,
      ordinal: function (e) {
        var t = e % 100;
        if (t > 3 && t < 21) return "th";
        switch (t % 10) {
          case 1:
            return "st";
          case 2:
            return "nd";
          case 3:
            return "rd";
          default:
            return "th";
        }
      },
      rangeSeparator: " to ",
      weekAbbreviation: "Wk",
      scrollTitle: "Scroll to increment",
      toggleTitle: "Click to toggle",
      amPM: ["AM", "PM"],
      yearAriaLabel: "Year",
      monthAriaLabel: "Month",
      hourAriaLabel: "Hour",
      minuteAriaLabel: "Minute",
      time_24hr: !1,
    },
    o = function (e, t) {
      return void 0 === t && (t = 2), ("000" + e).slice(-1 * t);
    },
    r = function (e) {
      return !0 === e ? 1 : 0;
    };
  function l(e, t) {
    var n;
    return function () {
      var a = this;
      clearTimeout(n),
        (n = setTimeout(function () {
          return e.apply(a, arguments);
        }, t));
    };
  }
  var c = function (e) {
    return e instanceof Array ? e : [e];
  };
  function d(e, t, n) {
    if (!0 === n) return e.classList.add(t);
    e.classList.remove(t);
  }
  function s(e, t, n) {
    var a = window.document.createElement(e);
    return (
      (t = t || ""),
      (n = n || ""),
      (a.className = t),
      void 0 !== n && (a.textContent = n),
      a
    );
  }
  function u(e) {
    for (; e.firstChild; ) e.removeChild(e.firstChild);
  }
  function f(e, t) {
    return t(e) ? e : e.parentNode ? f(e.parentNode, t) : void 0;
  }
  function m(e, t) {
    var n = s("div", "numInputWrapper"),
      a = s("input", "numInput " + e),
      i = s("span", "arrowUp"),
      o = s("span", "arrowDown");
    if (
      (-1 === navigator.userAgent.indexOf("MSIE 9.0")
        ? (a.type = "number")
        : ((a.type = "text"), (a.pattern = "\\d*")),
      void 0 !== t)
    )
      for (var r in t) a.setAttribute(r, t[r]);
    return n.appendChild(a), n.appendChild(i), n.appendChild(o), n;
  }
  function g(e) {
    try {
      return "function" == typeof e.composedPath
        ? e.composedPath()[0]
        : e.target;
    } catch (t) {
      return e.target;
    }
  }
  var p = function () {},
    h = function (e, t, n) {
      return n.months[t ? "shorthand" : "longhand"][e];
    },
    v = {
      D: p,
      F: function (e, t, n) {
        e.setMonth(n.months.longhand.indexOf(t));
      },
      G: function (e, t) {
        e.setHours(parseFloat(t));
      },
      H: function (e, t) {
        e.setHours(parseFloat(t));
      },
      J: function (e, t) {
        e.setDate(parseFloat(t));
      },
      K: function (e, t, n) {
        e.setHours(
          (e.getHours() % 12) + 12 * r(new RegExp(n.amPM[1], "i").test(t))
        );
      },
      M: function (e, t, n) {
        e.setMonth(n.months.shorthand.indexOf(t));
      },
      S: function (e, t) {
        e.setSeconds(parseFloat(t));
      },
      U: function (e, t) {
        return new Date(1e3 * parseFloat(t));
      },
      W: function (e, t, n) {
        var a = parseInt(t),
          i = new Date(e.getFullYear(), 0, 2 + 7 * (a - 1), 0, 0, 0, 0);
        return i.setDate(i.getDate() - i.getDay() + n.firstDayOfWeek), i;
      },
      Y: function (e, t) {
        e.setFullYear(parseFloat(t));
      },
      Z: function (e, t) {
        return new Date(t);
      },
      d: function (e, t) {
        e.setDate(parseFloat(t));
      },
      h: function (e, t) {
        e.setHours(parseFloat(t));
      },
      i: function (e, t) {
        e.setMinutes(parseFloat(t));
      },
      j: function (e, t) {
        e.setDate(parseFloat(t));
      },
      l: p,
      m: function (e, t) {
        e.setMonth(parseFloat(t) - 1);
      },
      n: function (e, t) {
        e.setMonth(parseFloat(t) - 1);
      },
      s: function (e, t) {
        e.setSeconds(parseFloat(t));
      },
      u: function (e, t) {
        return new Date(parseFloat(t));
      },
      w: p,
      y: function (e, t) {
        e.setFullYear(2e3 + parseFloat(t));
      },
    },
    D = {
      D: "(\\w+)",
      F: "(\\w+)",
      G: "(\\d\\d|\\d)",
      H: "(\\d\\d|\\d)",
      J: "(\\d\\d|\\d)\\w+",
      K: "",
      M: "(\\w+)",
      S: "(\\d\\d|\\d)",
      U: "(.+)",
      W: "(\\d\\d|\\d)",
      Y: "(\\d{4})",
      Z: "(.+)",
      d: "(\\d\\d|\\d)",
      h: "(\\d\\d|\\d)",
      i: "(\\d\\d|\\d)",
      j: "(\\d\\d|\\d)",
      l: "(\\w+)",
      m: "(\\d\\d|\\d)",
      n: "(\\d\\d|\\d)",
      s: "(\\d\\d|\\d)",
      u: "(.+)",
      w: "(\\d\\d|\\d)",
      y: "(\\d{2})",
    },
    w = {
      Z: function (e) {
        return e.toISOString();
      },
      D: function (e, t, n) {
        return t.weekdays.shorthand[w.w(e, t, n)];
      },
      F: function (e, t, n) {
        return h(w.n(e, t, n) - 1, !1, t);
      },
      G: function (e, t, n) {
        return o(w.h(e, t, n));
      },
      H: function (e) {
        return o(e.getHours());
      },
      J: function (e, t) {
        return void 0 !== t.ordinal
          ? e.getDate() + t.ordinal(e.getDate())
          : e.getDate();
      },
      K: function (e, t) {
        return t.amPM[r(e.getHours() > 11)];
      },
      M: function (e, t) {
        return h(e.getMonth(), !0, t);
      },
      S: function (e) {
        return o(e.getSeconds());
      },
      U: function (e) {
        return e.getTime() / 1e3;
      },
      W: function (e, t, n) {
        return n.getWeek(e);
      },
      Y: function (e) {
        return o(e.getFullYear(), 4);
      },
      d: function (e) {
        return o(e.getDate());
      },
      h: function (e) {
        return e.getHours() % 12 ? e.getHours() % 12 : 12;
      },
      i: function (e) {
        return o(e.getMinutes());
      },
      j: function (e) {
        return e.getDate();
      },
      l: function (e, t) {
        return t.weekdays.longhand[e.getDay()];
      },
      m: function (e) {
        return o(e.getMonth() + 1);
      },
      n: function (e) {
        return e.getMonth() + 1;
      },
      s: function (e) {
        return e.getSeconds();
      },
      u: function (e) {
        return e.getTime();
      },
      w: function (e) {
        return e.getDay();
      },
      y: function (e) {
        return String(e.getFullYear()).substring(2);
      },
    },
    b = function (e) {
      var t = e.config,
        n = void 0 === t ? a : t,
        o = e.l10n,
        r = void 0 === o ? i : o,
        l = e.isMobile,
        c = void 0 !== l && l;
      return function (e, t, a) {
        var i = a || r;
        return void 0 === n.formatDate || c
          ? t
              .split("")
              .map(function (t, a, o) {
                return w[t] && "\\" !== o[a - 1]
                  ? w[t](e, i, n)
                  : "\\" !== t
                  ? t
                  : "";
              })
              .join("")
          : n.formatDate(e, t, i);
      };
    },
    C = function (e) {
      var t = e.config,
        n = void 0 === t ? a : t,
        o = e.l10n,
        r = void 0 === o ? i : o;
      return function (e, t, i, o) {
        if (0 === e || e) {
          var l,
            c = o || r,
            d = e;
          if (e instanceof Date) l = new Date(e.getTime());
          else if ("string" != typeof e && void 0 !== e.toFixed)
            l = new Date(e);
          else if ("string" == typeof e) {
            var s = t || (n || a).dateFormat,
              u = String(e).trim();
            if ("today" === u) (l = new Date()), (i = !0);
            else if (/Z$/.test(u) || /GMT$/.test(u)) l = new Date(e);
            else if (n && n.parseDate) l = n.parseDate(e, s);
            else {
              l =
                n && n.noCalendar
                  ? new Date(new Date().setHours(0, 0, 0, 0))
                  : new Date(new Date().getFullYear(), 0, 1, 0, 0, 0, 0);
              for (
                var f = void 0, m = [], g = 0, p = 0, h = "";
                g < s.length;
                g++
              ) {
                var w = s[g],
                  b = "\\" === w,
                  C = "\\" === s[g - 1] || b;
                if (D[w] && !C) {
                  h += D[w];
                  var M = new RegExp(h).exec(e);
                  M &&
                    (f = !0) &&
                    m["Y" !== w ? "push" : "unshift"]({
                      fn: v[w],
                      val: M[++p],
                    });
                } else b || (h += ".");
                m.forEach(function (e) {
                  var t = e.fn,
                    n = e.val;
                  return (l = t(l, n, c) || l);
                });
              }
              l = f ? l : void 0;
            }
          }
          if (l instanceof Date && !isNaN(l.getTime()))
            return !0 === i && l.setHours(0, 0, 0, 0), l;
          n.errorHandler(new Error("Invalid date provided: " + d));
        }
      };
    };
  function M(e, t, n) {
    return (
      void 0 === n && (n = !0),
      !1 !== n
        ? new Date(e.getTime()).setHours(0, 0, 0, 0) -
          new Date(t.getTime()).setHours(0, 0, 0, 0)
        : e.getTime() - t.getTime()
    );
  }
  var y = 864e5;
  function x(e) {
    var t = e.defaultHour,
      n = e.defaultMinute,
      a = e.defaultSeconds;
    if (void 0 !== e.minDate) {
      var i = e.minDate.getHours(),
        o = e.minDate.getMinutes(),
        r = e.minDate.getSeconds();
      t < i && (t = i),
        t === i && n < o && (n = o),
        t === i && n === o && a < r && (a = e.minDate.getSeconds());
    }
    if (void 0 !== e.maxDate) {
      var l = e.maxDate.getHours(),
        c = e.maxDate.getMinutes();
      (t = Math.min(t, l)) === l && (n = Math.min(c, n)),
        t === l && n === c && (a = e.maxDate.getSeconds());
    }
    return { hours: t, minutes: n, seconds: a };
  }
  "function" != typeof Object.assign &&
    (Object.assign = function (e) {
      for (var t = [], n = 1; n < arguments.length; n++)
        t[n - 1] = arguments[n];
      if (!e) throw TypeError("Cannot convert undefined or null to object");
      for (
        var a = function (t) {
            t &&
              Object.keys(t).forEach(function (n) {
                return (e[n] = t[n]);
              });
          },
          i = 0,
          o = t;
        i < o.length;
        i++
      ) {
        var r = o[i];
        a(r);
      }
      return e;
    });
  function E(p, v) {
    var w = { config: e(e({}, a), T.defaultConfig), l10n: i };
    function E(e) {
      return e.bind(w);
    }
    function k() {
      var e = w.config;
      (!1 === e.weekNumbers && 1 === e.showMonths) ||
        (!0 !== e.noCalendar &&
          window.requestAnimationFrame(function () {
            if (
              (void 0 !== w.calendarContainer &&
                ((w.calendarContainer.style.visibility = "hidden"),
                (w.calendarContainer.style.display = "block")),
              void 0 !== w.daysContainer)
            ) {
              var t = (w.days.offsetWidth + 1) * e.showMonths;
              (w.daysContainer.style.width = t + "px"),
                (w.calendarContainer.style.width =
                  t +
                  (void 0 !== w.weekWrapper ? w.weekWrapper.offsetWidth : 0) +
                  "px"),
                w.calendarContainer.style.removeProperty("visibility"),
                w.calendarContainer.style.removeProperty("display");
            }
          }));
    }
    function I(e) {
      if (0 === w.selectedDates.length) {
        var t =
            void 0 === w.config.minDate || M(new Date(), w.config.minDate) >= 0
              ? new Date()
              : new Date(w.config.minDate.getTime()),
          n = x(w.config);
        t.setHours(n.hours, n.minutes, n.seconds, t.getMilliseconds()),
          (w.selectedDates = [t]),
          (w.latestSelectedDateObj = t);
      }
      void 0 !== e &&
        "blur" !== e.type &&
        (function (e) {
          e.preventDefault();
          var t = "keydown" === e.type,
            n = g(e),
            a = n;
          void 0 !== w.amPM &&
            n === w.amPM &&
            (w.amPM.textContent =
              w.l10n.amPM[r(w.amPM.textContent === w.l10n.amPM[0])]);
          var i = parseFloat(a.getAttribute("min")),
            l = parseFloat(a.getAttribute("max")),
            c = parseFloat(a.getAttribute("step")),
            d = parseInt(a.value, 10),
            s = e.delta || (t ? (38 === e.which ? 1 : -1) : 0),
            u = d + c * s;
          if (void 0 !== a.value && 2 === a.value.length) {
            var f = a === w.hourElement,
              m = a === w.minuteElement;
            u < i
              ? ((u = l + u + r(!f) + (r(f) && r(!w.amPM))),
                m && j(void 0, -1, w.hourElement))
              : u > l &&
                ((u = a === w.hourElement ? u - l - r(!w.amPM) : i),
                m && j(void 0, 1, w.hourElement)),
              w.amPM &&
                f &&
                (1 === c ? u + d === 23 : Math.abs(u - d) > c) &&
                (w.amPM.textContent =
                  w.l10n.amPM[r(w.amPM.textContent === w.l10n.amPM[0])]),
              (a.value = o(u));
          }
        })(e);
      var a = w._input.value;
      S(), be(), w._input.value !== a && w._debouncedChange();
    }
    function S() {
      if (void 0 !== w.hourElement && void 0 !== w.minuteElement) {
        var e,
          t,
          n = (parseInt(w.hourElement.value.slice(-2), 10) || 0) % 24,
          a = (parseInt(w.minuteElement.value, 10) || 0) % 60,
          i =
            void 0 !== w.secondElement
              ? (parseInt(w.secondElement.value, 10) || 0) % 60
              : 0;
        void 0 !== w.amPM &&
          ((e = n),
          (t = w.amPM.textContent),
          (n = (e % 12) + 12 * r(t === w.l10n.amPM[1])));
        var o =
          void 0 !== w.config.minTime ||
          (w.config.minDate &&
            w.minDateHasTime &&
            w.latestSelectedDateObj &&
            0 === M(w.latestSelectedDateObj, w.config.minDate, !0));
        if (
          void 0 !== w.config.maxTime ||
          (w.config.maxDate &&
            w.maxDateHasTime &&
            w.latestSelectedDateObj &&
            0 === M(w.latestSelectedDateObj, w.config.maxDate, !0))
        ) {
          var l =
            void 0 !== w.config.maxTime ? w.config.maxTime : w.config.maxDate;
          (n = Math.min(n, l.getHours())) === l.getHours() &&
            (a = Math.min(a, l.getMinutes())),
            a === l.getMinutes() && (i = Math.min(i, l.getSeconds()));
        }
        if (o) {
          var c =
            void 0 !== w.config.minTime ? w.config.minTime : w.config.minDate;
          (n = Math.max(n, c.getHours())) === c.getHours() &&
            a < c.getMinutes() &&
            (a = c.getMinutes()),
            a === c.getMinutes() && (i = Math.max(i, c.getSeconds()));
        }
        O(n, a, i);
      }
    }
    function _(e) {
      var t = e || w.latestSelectedDateObj;
      t && O(t.getHours(), t.getMinutes(), t.getSeconds());
    }
    function O(e, t, n) {
      void 0 !== w.latestSelectedDateObj &&
        w.latestSelectedDateObj.setHours(e % 24, t, n || 0, 0),
        w.hourElement &&
          w.minuteElement &&
          !w.isMobile &&
          ((w.hourElement.value = o(
            w.config.time_24hr ? e : ((12 + e) % 12) + 12 * r(e % 12 == 0)
          )),
          (w.minuteElement.value = o(t)),
          void 0 !== w.amPM && (w.amPM.textContent = w.l10n.amPM[r(e >= 12)]),
          void 0 !== w.secondElement && (w.secondElement.value = o(n)));
    }
    function F(e) {
      var t = g(e),
        n = parseInt(t.value) + (e.delta || 0);
      (n / 1e3 > 1 || ("Enter" === e.key && !/[^\d]/.test(n.toString()))) &&
        Q(n);
    }
    function A(e, t, n, a) {
      return t instanceof Array
        ? t.forEach(function (t) {
            return A(e, t, n, a);
          })
        : e instanceof Array
        ? e.forEach(function (e) {
            return A(e, t, n, a);
          })
        : (e.addEventListener(t, n, a),
          void w._handlers.push({
            remove: function () {
              return e.removeEventListener(t, n);
            },
          }));
    }
    function N() {
      pe("onChange");
    }
    function P(e, t) {
      var n =
          void 0 !== e
            ? w.parseDate(e)
            : w.latestSelectedDateObj ||
              (w.config.minDate && w.config.minDate > w.now
                ? w.config.minDate
                : w.config.maxDate && w.config.maxDate < w.now
                ? w.config.maxDate
                : w.now),
        a = w.currentYear,
        i = w.currentMonth;
      try {
        void 0 !== n &&
          ((w.currentYear = n.getFullYear()), (w.currentMonth = n.getMonth()));
      } catch (e) {
        (e.message = "Invalid date supplied: " + n), w.config.errorHandler(e);
      }
      t && w.currentYear !== a && (pe("onYearChange"), K()),
        !t ||
          (w.currentYear === a && w.currentMonth === i) ||
          pe("onMonthChange"),
        w.redraw();
    }
    function Y(e) {
      var t = g(e);
      ~t.className.indexOf("arrow") &&
        j(e, t.classList.contains("arrowUp") ? 1 : -1);
    }
    function j(e, t, n) {
      var a = e && g(e),
        i = n || (a && a.parentNode && a.parentNode.firstChild),
        o = he("increment");
      (o.delta = t), i && i.dispatchEvent(o);
    }
    function H(e, t, n, a) {
      var i = X(t, !0),
        o = s("span", "flatpickr-day " + e, t.getDate().toString());
      return (
        (o.dateObj = t),
        (o.$i = a),
        o.setAttribute("aria-label", w.formatDate(t, w.config.ariaDateFormat)),
        -1 === e.indexOf("hidden") &&
          0 === M(t, w.now) &&
          ((w.todayDateElem = o),
          o.classList.add("today"),
          o.setAttribute("aria-current", "date")),
        i
          ? ((o.tabIndex = -1),
            ve(t) &&
              (o.classList.add("selected"),
              (w.selectedDateElem = o),
              "range" === w.config.mode &&
                (d(
                  o,
                  "startRange",
                  w.selectedDates[0] && 0 === M(t, w.selectedDates[0], !0)
                ),
                d(
                  o,
                  "endRange",
                  w.selectedDates[1] && 0 === M(t, w.selectedDates[1], !0)
                ),
                "nextMonthDay" === e && o.classList.add("inRange"))))
          : o.classList.add("flatpickr-disabled"),
        "range" === w.config.mode &&
          (function (e) {
            return (
              !("range" !== w.config.mode || w.selectedDates.length < 2) &&
              M(e, w.selectedDates[0]) >= 0 &&
              M(e, w.selectedDates[1]) <= 0
            );
          })(t) &&
          !ve(t) &&
          o.classList.add("inRange"),
        w.weekNumbers &&
          1 === w.config.showMonths &&
          "prevMonthDay" !== e &&
          n % 7 == 1 &&
          w.weekNumbers.insertAdjacentHTML(
            "beforeend",
            "<span class='flatpickr-day'>" + w.config.getWeek(t) + "</span>"
          ),
        pe("onDayCreate", o),
        o
      );
    }
    function L(e) {
      e.focus(), "range" === w.config.mode && ae(e);
    }
    function W(e) {
      for (
        var t = e > 0 ? 0 : w.config.showMonths - 1,
          n = e > 0 ? w.config.showMonths : -1,
          a = t;
        a != n;
        a += e
      )
        for (
          var i = w.daysContainer.children[a],
            o = e > 0 ? 0 : i.children.length - 1,
            r = e > 0 ? i.children.length : -1,
            l = o;
          l != r;
          l += e
        ) {
          var c = i.children[l];
          if (-1 === c.className.indexOf("hidden") && X(c.dateObj)) return c;
        }
    }
    function R(e, t) {
      var n = ee(document.activeElement || document.body),
        a =
          void 0 !== e
            ? e
            : n
            ? document.activeElement
            : void 0 !== w.selectedDateElem && ee(w.selectedDateElem)
            ? w.selectedDateElem
            : void 0 !== w.todayDateElem && ee(w.todayDateElem)
            ? w.todayDateElem
            : W(t > 0 ? 1 : -1);
      void 0 === a
        ? w._input.focus()
        : n
        ? (function (e, t) {
            for (
              var n =
                  -1 === e.className.indexOf("Month")
                    ? e.dateObj.getMonth()
                    : w.currentMonth,
                a = t > 0 ? w.config.showMonths : -1,
                i = t > 0 ? 1 : -1,
                o = n - w.currentMonth;
              o != a;
              o += i
            )
              for (
                var r = w.daysContainer.children[o],
                  l =
                    n - w.currentMonth === o
                      ? e.$i + t
                      : t < 0
                      ? r.children.length - 1
                      : 0,
                  c = r.children.length,
                  d = l;
                d >= 0 && d < c && d != (t > 0 ? c : -1);
                d += i
              ) {
                var s = r.children[d];
                if (
                  -1 === s.className.indexOf("hidden") &&
                  X(s.dateObj) &&
                  Math.abs(e.$i - d) >= Math.abs(t)
                )
                  return L(s);
              }
            w.changeMonth(i), R(W(i), 0);
          })(a, t)
        : L(a);
    }
    function B(e, t) {
      for (
        var n = (new Date(e, t, 1).getDay() - w.l10n.firstDayOfWeek + 7) % 7,
          a = w.utils.getDaysInMonth((t - 1 + 12) % 12, e),
          i = w.utils.getDaysInMonth(t, e),
          o = window.document.createDocumentFragment(),
          r = w.config.showMonths > 1,
          l = r ? "prevMonthDay hidden" : "prevMonthDay",
          c = r ? "nextMonthDay hidden" : "nextMonthDay",
          d = a + 1 - n,
          u = 0;
        d <= a;
        d++, u++
      )
        o.appendChild(H(l, new Date(e, t - 1, d), d, u));
      for (d = 1; d <= i; d++, u++)
        o.appendChild(H("", new Date(e, t, d), d, u));
      for (
        var f = i + 1;
        f <= 42 - n && (1 === w.config.showMonths || u % 7 != 0);
        f++, u++
      )
        o.appendChild(H(c, new Date(e, t + 1, f % i), f, u));
      var m = s("div", "dayContainer");
      return m.appendChild(o), m;
    }
    function J() {
      if (void 0 !== w.daysContainer) {
        u(w.daysContainer), w.weekNumbers && u(w.weekNumbers);
        for (
          var e = document.createDocumentFragment(), t = 0;
          t < w.config.showMonths;
          t++
        ) {
          var n = new Date(w.currentYear, w.currentMonth, 1);
          n.setMonth(w.currentMonth + t),
            e.appendChild(B(n.getFullYear(), n.getMonth()));
        }
        w.daysContainer.appendChild(e),
          (w.days = w.daysContainer.firstChild),
          "range" === w.config.mode && 1 === w.selectedDates.length && ae();
      }
    }
    function K() {
      if (
        !(w.config.showMonths > 1 || "dropdown" !== w.config.monthSelectorType)
      ) {
        var e = function (e) {
          return (
            !(
              void 0 !== w.config.minDate &&
              w.currentYear === w.config.minDate.getFullYear() &&
              e < w.config.minDate.getMonth()
            ) &&
            !(
              void 0 !== w.config.maxDate &&
              w.currentYear === w.config.maxDate.getFullYear() &&
              e > w.config.maxDate.getMonth()
            )
          );
        };
        (w.monthsDropdownContainer.tabIndex = -1),
          (w.monthsDropdownContainer.innerHTML = "");
        for (var t = 0; t < 12; t++)
          if (e(t)) {
            var n = s("option", "flatpickr-monthDropdown-month");
            (n.value = new Date(w.currentYear, t).getMonth().toString()),
              (n.textContent = h(t, w.config.shorthandCurrentMonth, w.l10n)),
              (n.tabIndex = -1),
              w.currentMonth === t && (n.selected = !0),
              w.monthsDropdownContainer.appendChild(n);
          }
      }
    }
    function U() {
      var e,
        t = s("div", "flatpickr-month"),
        n = window.document.createDocumentFragment();
      w.config.showMonths > 1 || "static" === w.config.monthSelectorType
        ? (e = s("span", "cur-month"))
        : ((w.monthsDropdownContainer = s(
            "select",
            "flatpickr-monthDropdown-months"
          )),
          w.monthsDropdownContainer.setAttribute(
            "aria-label",
            w.l10n.monthAriaLabel
          ),
          A(w.monthsDropdownContainer, "change", function (e) {
            var t = g(e),
              n = parseInt(t.value, 10);
            w.changeMonth(n - w.currentMonth), pe("onMonthChange");
          }),
          K(),
          (e = w.monthsDropdownContainer));
      var a = m("cur-year", { tabindex: "-1" }),
        i = a.getElementsByTagName("input")[0];
      i.setAttribute("aria-label", w.l10n.yearAriaLabel),
        w.config.minDate &&
          i.setAttribute("min", w.config.minDate.getFullYear().toString()),
        w.config.maxDate &&
          (i.setAttribute("max", w.config.maxDate.getFullYear().toString()),
          (i.disabled =
            !!w.config.minDate &&
            w.config.minDate.getFullYear() === w.config.maxDate.getFullYear()));
      var o = s("div", "flatpickr-current-month");
      return (
        o.appendChild(e),
        o.appendChild(a),
        n.appendChild(o),
        t.appendChild(n),
        { container: t, yearElement: i, monthElement: e }
      );
    }
    function q() {
      u(w.monthNav),
        w.monthNav.appendChild(w.prevMonthNav),
        w.config.showMonths && ((w.yearElements = []), (w.monthElements = []));
      for (var e = w.config.showMonths; e--; ) {
        var t = U();
        w.yearElements.push(t.yearElement),
          w.monthElements.push(t.monthElement),
          w.monthNav.appendChild(t.container);
      }
      w.monthNav.appendChild(w.nextMonthNav);
    }
    function $() {
      w.weekdayContainer
        ? u(w.weekdayContainer)
        : (w.weekdayContainer = s("div", "flatpickr-weekdays"));
      for (var e = w.config.showMonths; e--; ) {
        var t = s("div", "flatpickr-weekdaycontainer");
        w.weekdayContainer.appendChild(t);
      }
      return z(), w.weekdayContainer;
    }
    function z() {
      if (w.weekdayContainer) {
        var e = w.l10n.firstDayOfWeek,
          n = t(w.l10n.weekdays.shorthand);
        e > 0 && e < n.length && (n = t(n.splice(e, n.length), n.splice(0, e)));
        for (var a = w.config.showMonths; a--; )
          w.weekdayContainer.children[a].innerHTML =
            "\n      <span class='flatpickr-weekday'>\n        " +
            n.join("</span><span class='flatpickr-weekday'>") +
            "\n      </span>\n      ";
      }
    }
    function G(e, t) {
      void 0 === t && (t = !0);
      var n = t ? e : e - w.currentMonth;
      (n < 0 && !0 === w._hidePrevMonthArrow) ||
        (n > 0 && !0 === w._hideNextMonthArrow) ||
        ((w.currentMonth += n),
        (w.currentMonth < 0 || w.currentMonth > 11) &&
          ((w.currentYear += w.currentMonth > 11 ? 1 : -1),
          (w.currentMonth = (w.currentMonth + 12) % 12),
          pe("onYearChange"),
          K()),
        J(),
        pe("onMonthChange"),
        De());
    }
    function V(e) {
      return (
        !(!w.config.appendTo || !w.config.appendTo.contains(e)) ||
        w.calendarContainer.contains(e)
      );
    }
    function Z(e) {
      if (w.isOpen && !w.config.inline) {
        var t = g(e),
          n = V(t),
          a =
            t === w.input ||
            t === w.altInput ||
            w.element.contains(t) ||
            (e.path &&
              e.path.indexOf &&
              (~e.path.indexOf(w.input) || ~e.path.indexOf(w.altInput))),
          i =
            "blur" === e.type
              ? a && e.relatedTarget && !V(e.relatedTarget)
              : !a && !n && !V(e.relatedTarget),
          o = !w.config.ignoredFocusElements.some(function (e) {
            return e.contains(t);
          });
        i &&
          o &&
          (void 0 !== w.timeContainer &&
            void 0 !== w.minuteElement &&
            void 0 !== w.hourElement &&
            "" !== w.input.value &&
            void 0 !== w.input.value &&
            I(),
          w.close(),
          w.config &&
            "range" === w.config.mode &&
            1 === w.selectedDates.length &&
            (w.clear(!1), w.redraw()));
      }
    }
    function Q(e) {
      if (
        !(
          !e ||
          (w.config.minDate && e < w.config.minDate.getFullYear()) ||
          (w.config.maxDate && e > w.config.maxDate.getFullYear())
        )
      ) {
        var t = e,
          n = w.currentYear !== t;
        (w.currentYear = t || w.currentYear),
          w.config.maxDate && w.currentYear === w.config.maxDate.getFullYear()
            ? (w.currentMonth = Math.min(
                w.config.maxDate.getMonth(),
                w.currentMonth
              ))
            : w.config.minDate &&
              w.currentYear === w.config.minDate.getFullYear() &&
              (w.currentMonth = Math.max(
                w.config.minDate.getMonth(),
                w.currentMonth
              )),
          n && (w.redraw(), pe("onYearChange"), K());
      }
    }
    function X(e, t) {
      var n;
      void 0 === t && (t = !0);
      var a = w.parseDate(e, void 0, t);
      if (
        (w.config.minDate &&
          a &&
          M(a, w.config.minDate, void 0 !== t ? t : !w.minDateHasTime) < 0) ||
        (w.config.maxDate &&
          a &&
          M(a, w.config.maxDate, void 0 !== t ? t : !w.maxDateHasTime) > 0)
      )
        return !1;
      if (!w.config.enable && 0 === w.config.disable.length) return !0;
      if (void 0 === a) return !1;
      for (
        var i = !!w.config.enable,
          o =
            null !== (n = w.config.enable) && void 0 !== n
              ? n
              : w.config.disable,
          r = 0,
          l = void 0;
        r < o.length;
        r++
      ) {
        if ("function" == typeof (l = o[r]) && l(a)) return i;
        if (l instanceof Date && void 0 !== a && l.getTime() === a.getTime())
          return i;
        if ("string" == typeof l) {
          var c = w.parseDate(l, void 0, !0);
          return c && c.getTime() === a.getTime() ? i : !i;
        }
        if (
          "object" == typeof l &&
          void 0 !== a &&
          l.from &&
          l.to &&
          a.getTime() >= l.from.getTime() &&
          a.getTime() <= l.to.getTime()
        )
          return i;
      }
      return !i;
    }
    function ee(e) {
      return (
        void 0 !== w.daysContainer &&
        -1 === e.className.indexOf("hidden") &&
        -1 === e.className.indexOf("flatpickr-disabled") &&
        w.daysContainer.contains(e)
      );
    }
    function te(e) {
      !(e.target === w._input) ||
        !(w.selectedDates.length > 0 || w._input.value.length > 0) ||
        (e.relatedTarget && V(e.relatedTarget)) ||
        w.setDate(
          w._input.value,
          !0,
          e.target === w.altInput ? w.config.altFormat : w.config.dateFormat
        );
    }
    function ne(e) {
      var t = g(e),
        n = w.config.wrap ? p.contains(t) : t === w._input,
        a = w.config.allowInput,
        i = w.isOpen && (!a || !n),
        o = w.config.inline && n && !a;
      if (13 === e.keyCode && n) {
        if (a)
          return (
            w.setDate(
              w._input.value,
              !0,
              t === w.altInput ? w.config.altFormat : w.config.dateFormat
            ),
            t.blur()
          );
        w.open();
      } else if (V(t) || i || o) {
        var r = !!w.timeContainer && w.timeContainer.contains(t);
        switch (e.keyCode) {
          case 13:
            r ? (e.preventDefault(), I(), se()) : ue(e);
            break;
          case 27:
            e.preventDefault(), se();
            break;
          case 8:
          case 46:
            n && !w.config.allowInput && (e.preventDefault(), w.clear());
            break;
          case 37:
          case 39:
            if (r || n) w.hourElement && w.hourElement.focus();
            else if (
              (e.preventDefault(),
              void 0 !== w.daysContainer &&
                (!1 === a ||
                  (document.activeElement && ee(document.activeElement))))
            ) {
              var l = 39 === e.keyCode ? 1 : -1;
              e.ctrlKey
                ? (e.stopPropagation(), G(l), R(W(1), 0))
                : R(void 0, l);
            }
            break;
          case 38:
          case 40:
            e.preventDefault();
            var c = 40 === e.keyCode ? 1 : -1;
            (w.daysContainer && void 0 !== t.$i) ||
            t === w.input ||
            t === w.altInput
              ? e.ctrlKey
                ? (e.stopPropagation(), Q(w.currentYear - c), R(W(1), 0))
                : r || R(void 0, 7 * c)
              : t === w.currentYearElement
              ? Q(w.currentYear - c)
              : w.config.enableTime &&
                (!r && w.hourElement && w.hourElement.focus(),
                I(e),
                w._debouncedChange());
            break;
          case 9:
            if (r) {
              var d = [w.hourElement, w.minuteElement, w.secondElement, w.amPM]
                  .concat(w.pluginElements)
                  .filter(function (e) {
                    return e;
                  }),
                s = d.indexOf(t);
              if (-1 !== s) {
                var u = d[s + (e.shiftKey ? -1 : 1)];
                e.preventDefault(), (u || w._input).focus();
              }
            } else
              !w.config.noCalendar &&
                w.daysContainer &&
                w.daysContainer.contains(t) &&
                e.shiftKey &&
                (e.preventDefault(), w._input.focus());
        }
      }
      if (void 0 !== w.amPM && t === w.amPM)
        switch (e.key) {
          case w.l10n.amPM[0].charAt(0):
          case w.l10n.amPM[0].charAt(0).toLowerCase():
            (w.amPM.textContent = w.l10n.amPM[0]), S(), be();
            break;
          case w.l10n.amPM[1].charAt(0):
          case w.l10n.amPM[1].charAt(0).toLowerCase():
            (w.amPM.textContent = w.l10n.amPM[1]), S(), be();
        }
      (n || V(t)) && pe("onKeyDown", e);
    }
    function ae(e) {
      if (
        1 === w.selectedDates.length &&
        (!e ||
          (e.classList.contains("flatpickr-day") &&
            !e.classList.contains("flatpickr-disabled")))
      ) {
        for (
          var t = e
              ? e.dateObj.getTime()
              : w.days.firstElementChild.dateObj.getTime(),
            n = w.parseDate(w.selectedDates[0], void 0, !0).getTime(),
            a = Math.min(t, w.selectedDates[0].getTime()),
            i = Math.max(t, w.selectedDates[0].getTime()),
            o = !1,
            r = 0,
            l = 0,
            c = a;
          c < i;
          c += y
        )
          X(new Date(c), !0) ||
            ((o = o || (c > a && c < i)),
            c < n && (!r || c > r)
              ? (r = c)
              : c > n && (!l || c < l) && (l = c));
        for (var d = 0; d < w.config.showMonths; d++)
          for (
            var s = w.daysContainer.children[d],
              u = function (a, i) {
                var c,
                  d,
                  u,
                  f = s.children[a],
                  m = f.dateObj.getTime(),
                  g = (r > 0 && m < r) || (l > 0 && m > l);
                return g
                  ? (f.classList.add("notAllowed"),
                    ["inRange", "startRange", "endRange"].forEach(function (e) {
                      f.classList.remove(e);
                    }),
                    "continue")
                  : o && !g
                  ? "continue"
                  : ([
                      "startRange",
                      "inRange",
                      "endRange",
                      "notAllowed",
                    ].forEach(function (e) {
                      f.classList.remove(e);
                    }),
                    void (
                      void 0 !== e &&
                      (e.classList.add(
                        t <= w.selectedDates[0].getTime()
                          ? "startRange"
                          : "endRange"
                      ),
                      n < t && m === n
                        ? f.classList.add("startRange")
                        : n > t && m === n && f.classList.add("endRange"),
                      m >= r &&
                        (0 === l || m <= l) &&
                        ((d = n),
                        (u = t),
                        (c = m) > Math.min(d, u) && c < Math.max(d, u)) &&
                        f.classList.add("inRange"))
                    ));
              },
              f = 0,
              m = s.children.length;
            f < m;
            f++
          )
            u(f);
      }
    }
    function ie() {
      !w.isOpen || w.config.static || w.config.inline || ce();
    }
    function oe(e) {
      return function (t) {
        var n = (w.config["_" + e + "Date"] = w.parseDate(
            t,
            w.config.dateFormat
          )),
          a = w.config["_" + ("min" === e ? "max" : "min") + "Date"];
        void 0 !== n &&
          (w["min" === e ? "minDateHasTime" : "maxDateHasTime"] =
            n.getHours() > 0 || n.getMinutes() > 0 || n.getSeconds() > 0),
          w.selectedDates &&
            ((w.selectedDates = w.selectedDates.filter(function (e) {
              return X(e);
            })),
            w.selectedDates.length || "min" !== e || _(n),
            be()),
          w.daysContainer &&
            (de(),
            void 0 !== n
              ? (w.currentYearElement[e] = n.getFullYear().toString())
              : w.currentYearElement.removeAttribute(e),
            (w.currentYearElement.disabled =
              !!a && void 0 !== n && a.getFullYear() === n.getFullYear()));
      };
    }
    function re() {
      return w.config.wrap ? p.querySelector("[data-input]") : p;
    }
    function le() {
      "object" != typeof w.config.locale &&
        void 0 === T.l10ns[w.config.locale] &&
        w.config.errorHandler(
          new Error("flatpickr: invalid locale " + w.config.locale)
        ),
        (w.l10n = e(
          e({}, T.l10ns.default),
          "object" == typeof w.config.locale
            ? w.config.locale
            : "default" !== w.config.locale
            ? T.l10ns[w.config.locale]
            : void 0
        )),
        (D.K =
          "(" +
          w.l10n.amPM[0] +
          "|" +
          w.l10n.amPM[1] +
          "|" +
          w.l10n.amPM[0].toLowerCase() +
          "|" +
          w.l10n.amPM[1].toLowerCase() +
          ")"),
        void 0 ===
          e(e({}, v), JSON.parse(JSON.stringify(p.dataset || {}))).time_24hr &&
          void 0 === T.defaultConfig.time_24hr &&
          (w.config.time_24hr = w.l10n.time_24hr),
        (w.formatDate = b(w)),
        (w.parseDate = C({ config: w.config, l10n: w.l10n }));
    }
    function ce(e) {
      if ("function" != typeof w.config.position) {
        if (void 0 !== w.calendarContainer) {
          pe("onPreCalendarPosition");
          var t = e || w._positionElement,
            n = Array.prototype.reduce.call(
              w.calendarContainer.children,
              function (e, t) {
                return e + t.offsetHeight;
              },
              0
            ),
            a = w.calendarContainer.offsetWidth,
            i = w.config.position.split(" "),
            o = i[0],
            r = i.length > 1 ? i[1] : null,
            l = t.getBoundingClientRect(),
            c = window.innerHeight - l.bottom,
            s = "above" === o || ("below" !== o && c < n && l.top > n),
            u = window.pageYOffset + l.top + (s ? -n - 2 : t.offsetHeight + 2);
          if (
            (d(w.calendarContainer, "arrowTop", !s),
            d(w.calendarContainer, "arrowBottom", s),
            !w.config.inline)
          ) {
            var f = window.pageXOffset + l.left,
              m = !1,
              g = !1;
            "center" === r
              ? ((f -= (a - l.width) / 2), (m = !0))
              : "right" === r && ((f -= a - l.width), (g = !0)),
              d(w.calendarContainer, "arrowLeft", !m && !g),
              d(w.calendarContainer, "arrowCenter", m),
              d(w.calendarContainer, "arrowRight", g);
            var p =
                window.document.body.offsetWidth -
                (window.pageXOffset + l.right),
              h = f + a > window.document.body.offsetWidth,
              v = p + a > window.document.body.offsetWidth;
            if ((d(w.calendarContainer, "rightMost", h), !w.config.static))
              if (((w.calendarContainer.style.top = u + "px"), h))
                if (v) {
                  var D = (function () {
                    for (
                      var e = null, t = 0;
                      t < document.styleSheets.length;
                      t++
                    ) {
                      var n = document.styleSheets[t];
                      try {
                        n.cssRules;
                      } catch (e) {
                        continue;
                      }
                      e = n;
                      break;
                    }
                    return null != e
                      ? e
                      : ((a = document.createElement("style")),
                        document.head.appendChild(a),
                        a.sheet);
                    var a;
                  })();
                  if (void 0 === D) return;
                  var b = window.document.body.offsetWidth,
                    C = Math.max(0, b / 2 - a / 2),
                    M = D.cssRules.length,
                    y = "{left:" + l.left + "px;right:auto;}";
                  d(w.calendarContainer, "rightMost", !1),
                    d(w.calendarContainer, "centerMost", !0),
                    D.insertRule(
                      ".flatpickr-calendar.centerMost:before,.flatpickr-calendar.centerMost:after" +
                        y,
                      M
                    ),
                    (w.calendarContainer.style.left = C + "px"),
                    (w.calendarContainer.style.right = "auto");
                } else
                  (w.calendarContainer.style.left = "auto"),
                    (w.calendarContainer.style.right = p + "px");
              else
                (w.calendarContainer.style.left = f + "px"),
                  (w.calendarContainer.style.right = "auto");
          }
        }
      } else w.config.position(w, e);
    }
    function de() {
      w.config.noCalendar || w.isMobile || (K(), De(), J());
    }
    function se() {
      w._input.focus(),
        -1 !== window.navigator.userAgent.indexOf("MSIE") ||
        void 0 !== navigator.msMaxTouchPoints
          ? setTimeout(w.close, 0)
          : w.close();
    }
    function ue(e) {
      e.preventDefault(), e.stopPropagation();
      var t = f(g(e), function (e) {
        return (
          e.classList &&
          e.classList.contains("flatpickr-day") &&
          !e.classList.contains("flatpickr-disabled") &&
          !e.classList.contains("notAllowed")
        );
      });
      if (void 0 !== t) {
        var n = t,
          a = (w.latestSelectedDateObj = new Date(n.dateObj.getTime())),
          i =
            (a.getMonth() < w.currentMonth ||
              a.getMonth() > w.currentMonth + w.config.showMonths - 1) &&
            "range" !== w.config.mode;
        if (((w.selectedDateElem = n), "single" === w.config.mode))
          w.selectedDates = [a];
        else if ("multiple" === w.config.mode) {
          var o = ve(a);
          o ? w.selectedDates.splice(parseInt(o), 1) : w.selectedDates.push(a);
        } else
          "range" === w.config.mode &&
            (2 === w.selectedDates.length && w.clear(!1, !1),
            (w.latestSelectedDateObj = a),
            w.selectedDates.push(a),
            0 !== M(a, w.selectedDates[0], !0) &&
              w.selectedDates.sort(function (e, t) {
                return e.getTime() - t.getTime();
              }));
        if ((S(), i)) {
          var r = w.currentYear !== a.getFullYear();
          (w.currentYear = a.getFullYear()),
            (w.currentMonth = a.getMonth()),
            r && (pe("onYearChange"), K()),
            pe("onMonthChange");
        }
        if (
          (De(),
          J(),
          be(),
          i || "range" === w.config.mode || 1 !== w.config.showMonths
            ? void 0 !== w.selectedDateElem &&
              void 0 === w.hourElement &&
              w.selectedDateElem &&
              w.selectedDateElem.focus()
            : L(n),
          void 0 !== w.hourElement &&
            void 0 !== w.hourElement &&
            w.hourElement.focus(),
          w.config.closeOnSelect)
        ) {
          var l = "single" === w.config.mode && !w.config.enableTime,
            c =
              "range" === w.config.mode &&
              2 === w.selectedDates.length &&
              !w.config.enableTime;
          (l || c) && se();
        }
        N();
      }
    }
    (w.parseDate = C({ config: w.config, l10n: w.l10n })),
      (w._handlers = []),
      (w.pluginElements = []),
      (w.loadedPlugins = []),
      (w._bind = A),
      (w._setHoursFromDate = _),
      (w._positionCalendar = ce),
      (w.changeMonth = G),
      (w.changeYear = Q),
      (w.clear = function (e, t) {
        void 0 === e && (e = !0);
        void 0 === t && (t = !0);
        (w.input.value = ""), void 0 !== w.altInput && (w.altInput.value = "");
        void 0 !== w.mobileInput && (w.mobileInput.value = "");
        (w.selectedDates = []),
          (w.latestSelectedDateObj = void 0),
          !0 === t &&
            ((w.currentYear = w._initialDate.getFullYear()),
            (w.currentMonth = w._initialDate.getMonth()));
        if (!0 === w.config.enableTime) {
          var n = x(w.config),
            a = n.hours,
            i = n.minutes,
            o = n.seconds;
          O(a, i, o);
        }
        w.redraw(), e && pe("onChange");
      }),
      (w.close = function () {
        (w.isOpen = !1),
          w.isMobile ||
            (void 0 !== w.calendarContainer &&
              w.calendarContainer.classList.remove("open"),
            void 0 !== w._input && w._input.classList.remove("active"));
        pe("onClose");
      }),
      (w._createElement = s),
      (w.destroy = function () {
        void 0 !== w.config && pe("onDestroy");
        for (var e = w._handlers.length; e--; ) w._handlers[e].remove();
        if (((w._handlers = []), w.mobileInput))
          w.mobileInput.parentNode &&
            w.mobileInput.parentNode.removeChild(w.mobileInput),
            (w.mobileInput = void 0);
        else if (w.calendarContainer && w.calendarContainer.parentNode)
          if (w.config.static && w.calendarContainer.parentNode) {
            var t = w.calendarContainer.parentNode;
            if ((t.lastChild && t.removeChild(t.lastChild), t.parentNode)) {
              for (; t.firstChild; ) t.parentNode.insertBefore(t.firstChild, t);
              t.parentNode.removeChild(t);
            }
          } else
            w.calendarContainer.parentNode.removeChild(w.calendarContainer);
        w.altInput &&
          ((w.input.type = "text"),
          w.altInput.parentNode &&
            w.altInput.parentNode.removeChild(w.altInput),
          delete w.altInput);
        w.input &&
          ((w.input.type = w.input._type),
          w.input.classList.remove("flatpickr-input"),
          w.input.removeAttribute("readonly"));
        [
          "_showTimeInput",
          "latestSelectedDateObj",
          "_hideNextMonthArrow",
          "_hidePrevMonthArrow",
          "__hideNextMonthArrow",
          "__hidePrevMonthArrow",
          "isMobile",
          "isOpen",
          "selectedDateElem",
          "minDateHasTime",
          "maxDateHasTime",
          "days",
          "daysContainer",
          "_input",
          "_positionElement",
          "innerContainer",
          "rContainer",
          "monthNav",
          "todayDateElem",
          "calendarContainer",
          "weekdayContainer",
          "prevMonthNav",
          "nextMonthNav",
          "monthsDropdownContainer",
          "currentMonthElement",
          "currentYearElement",
          "navigationCurrentMonth",
          "selectedDateElem",
          "config",
        ].forEach(function (e) {
          try {
            delete w[e];
          } catch (e) {}
        });
      }),
      (w.isEnabled = X),
      (w.jumpToDate = P),
      (w.open = function (e, t) {
        void 0 === t && (t = w._positionElement);
        if (!0 === w.isMobile) {
          if (e) {
            e.preventDefault();
            var n = g(e);
            n && n.blur();
          }
          return (
            void 0 !== w.mobileInput &&
              (w.mobileInput.focus(), w.mobileInput.click()),
            void pe("onOpen")
          );
        }
        if (w._input.disabled || w.config.inline) return;
        var a = w.isOpen;
        (w.isOpen = !0),
          a ||
            (w.calendarContainer.classList.add("open"),
            w._input.classList.add("active"),
            pe("onOpen"),
            ce(t));
        !0 === w.config.enableTime &&
          !0 === w.config.noCalendar &&
          (!1 !== w.config.allowInput ||
            (void 0 !== e && w.timeContainer.contains(e.relatedTarget)) ||
            setTimeout(function () {
              return w.hourElement.select();
            }, 50));
      }),
      (w.redraw = de),
      (w.set = function (e, t) {
        if (null !== e && "object" == typeof e)
          for (var a in (Object.assign(w.config, e), e))
            void 0 !== fe[a] &&
              fe[a].forEach(function (e) {
                return e();
              });
        else
          (w.config[e] = t),
            void 0 !== fe[e]
              ? fe[e].forEach(function (e) {
                  return e();
                })
              : n.indexOf(e) > -1 && (w.config[e] = c(t));
        w.redraw(), be(!0);
      }),
      (w.setDate = function (e, t, n) {
        void 0 === t && (t = !1);
        void 0 === n && (n = w.config.dateFormat);
        if ((0 !== e && !e) || (e instanceof Array && 0 === e.length))
          return w.clear(t);
        me(e, n),
          (w.latestSelectedDateObj =
            w.selectedDates[w.selectedDates.length - 1]),
          w.redraw(),
          P(void 0, t),
          _(),
          0 === w.selectedDates.length && w.clear(!1);
        be(t), t && pe("onChange");
      }),
      (w.toggle = function (e) {
        if (!0 === w.isOpen) return w.close();
        w.open(e);
      });
    var fe = {
      locale: [le, z],
      showMonths: [q, k, $],
      minDate: [P],
      maxDate: [P],
      clickOpens: [
        function () {
          !0 === w.config.clickOpens
            ? (A(w._input, "focus", w.open), A(w._input, "click", w.open))
            : (w._input.removeEventListener("focus", w.open),
              w._input.removeEventListener("click", w.open));
        },
      ],
    };
    function me(e, t) {
      var n = [];
      if (e instanceof Array)
        n = e.map(function (e) {
          return w.parseDate(e, t);
        });
      else if (e instanceof Date || "number" == typeof e)
        n = [w.parseDate(e, t)];
      else if ("string" == typeof e)
        switch (w.config.mode) {
          case "single":
          case "time":
            n = [w.parseDate(e, t)];
            break;
          case "multiple":
            n = e.split(w.config.conjunction).map(function (e) {
              return w.parseDate(e, t);
            });
            break;
          case "range":
            n = e.split(w.l10n.rangeSeparator).map(function (e) {
              return w.parseDate(e, t);
            });
        }
      else
        w.config.errorHandler(
          new Error("Invalid date supplied: " + JSON.stringify(e))
        );
      (w.selectedDates = w.config.allowInvalidPreload
        ? n
        : n.filter(function (e) {
            return e instanceof Date && X(e, !1);
          })),
        "range" === w.config.mode &&
          w.selectedDates.sort(function (e, t) {
            return e.getTime() - t.getTime();
          });
    }
    function ge(e) {
      return e
        .slice()
        .map(function (e) {
          return "string" == typeof e ||
            "number" == typeof e ||
            e instanceof Date
            ? w.parseDate(e, void 0, !0)
            : e && "object" == typeof e && e.from && e.to
            ? {
                from: w.parseDate(e.from, void 0),
                to: w.parseDate(e.to, void 0),
              }
            : e;
        })
        .filter(function (e) {
          return e;
        });
    }
    function pe(e, t) {
      if (void 0 !== w.config) {
        var n = w.config[e];
        if (void 0 !== n && n.length > 0)
          for (var a = 0; n[a] && a < n.length; a++)
            n[a](w.selectedDates, w.input.value, w, t);
        "onChange" === e &&
          (w.input.dispatchEvent(he("change")),
          w.input.dispatchEvent(he("input")));
      }
    }
    function he(e) {
      var t = document.createEvent("Event");
      return t.initEvent(e, !0, !0), t;
    }
    function ve(e) {
      for (var t = 0; t < w.selectedDates.length; t++)
        if (0 === M(w.selectedDates[t], e)) return "" + t;
      return !1;
    }
    function De() {
      w.config.noCalendar ||
        w.isMobile ||
        !w.monthNav ||
        (w.yearElements.forEach(function (e, t) {
          var n = new Date(w.currentYear, w.currentMonth, 1);
          n.setMonth(w.currentMonth + t),
            w.config.showMonths > 1 || "static" === w.config.monthSelectorType
              ? (w.monthElements[t].textContent =
                  h(n.getMonth(), w.config.shorthandCurrentMonth, w.l10n) + " ")
              : (w.monthsDropdownContainer.value = n.getMonth().toString()),
            (e.value = n.getFullYear().toString());
        }),
        (w._hidePrevMonthArrow =
          void 0 !== w.config.minDate &&
          (w.currentYear === w.config.minDate.getFullYear()
            ? w.currentMonth <= w.config.minDate.getMonth()
            : w.currentYear < w.config.minDate.getFullYear())),
        (w._hideNextMonthArrow =
          void 0 !== w.config.maxDate &&
          (w.currentYear === w.config.maxDate.getFullYear()
            ? w.currentMonth + 1 > w.config.maxDate.getMonth()
            : w.currentYear > w.config.maxDate.getFullYear())));
    }
    function we(e) {
      return w.selectedDates
        .map(function (t) {
          return w.formatDate(t, e);
        })
        .filter(function (e, t, n) {
          return (
            "range" !== w.config.mode ||
            w.config.enableTime ||
            n.indexOf(e) === t
          );
        })
        .join(
          "range" !== w.config.mode
            ? w.config.conjunction
            : w.l10n.rangeSeparator
        );
    }
    function be(e) {
      void 0 === e && (e = !0),
        void 0 !== w.mobileInput &&
          w.mobileFormatStr &&
          (w.mobileInput.value =
            void 0 !== w.latestSelectedDateObj
              ? w.formatDate(w.latestSelectedDateObj, w.mobileFormatStr)
              : ""),
        (w.input.value = we(w.config.dateFormat)),
        void 0 !== w.altInput && (w.altInput.value = we(w.config.altFormat)),
        !1 !== e && pe("onValueUpdate");
    }
    function Ce(e) {
      var t = g(e),
        n = w.prevMonthNav.contains(t),
        a = w.nextMonthNav.contains(t);
      n || a
        ? G(n ? -1 : 1)
        : w.yearElements.indexOf(t) >= 0
        ? t.select()
        : t.classList.contains("arrowUp")
        ? w.changeYear(w.currentYear + 1)
        : t.classList.contains("arrowDown") && w.changeYear(w.currentYear - 1);
    }
    return (
      (function () {
        (w.element = w.input = p),
          (w.isOpen = !1),
          (function () {
            var t = [
                "wrap",
                "weekNumbers",
                "allowInput",
                "allowInvalidPreload",
                "clickOpens",
                "time_24hr",
                "enableTime",
                "noCalendar",
                "altInput",
                "shorthandCurrentMonth",
                "inline",
                "static",
                "enableSeconds",
                "disableMobile",
              ],
              i = e(e({}, JSON.parse(JSON.stringify(p.dataset || {}))), v),
              o = {};
            (w.config.parseDate = i.parseDate),
              (w.config.formatDate = i.formatDate),
              Object.defineProperty(w.config, "enable", {
                get: function () {
                  return w.config._enable;
                },
                set: function (e) {
                  w.config._enable = ge(e);
                },
              }),
              Object.defineProperty(w.config, "disable", {
                get: function () {
                  return w.config._disable;
                },
                set: function (e) {
                  w.config._disable = ge(e);
                },
              });
            var r = "time" === i.mode;
            if (!i.dateFormat && (i.enableTime || r)) {
              var l = T.defaultConfig.dateFormat || a.dateFormat;
              o.dateFormat =
                i.noCalendar || r
                  ? "H:i" + (i.enableSeconds ? ":S" : "")
                  : l + " H:i" + (i.enableSeconds ? ":S" : "");
            }
            if (i.altInput && (i.enableTime || r) && !i.altFormat) {
              var d = T.defaultConfig.altFormat || a.altFormat;
              o.altFormat =
                i.noCalendar || r
                  ? "h:i" + (i.enableSeconds ? ":S K" : " K")
                  : d + " h:i" + (i.enableSeconds ? ":S" : "") + " K";
            }
            Object.defineProperty(w.config, "minDate", {
              get: function () {
                return w.config._minDate;
              },
              set: oe("min"),
            }),
              Object.defineProperty(w.config, "maxDate", {
                get: function () {
                  return w.config._maxDate;
                },
                set: oe("max"),
              });
            var s = function (e) {
              return function (t) {
                w.config["min" === e ? "_minTime" : "_maxTime"] = w.parseDate(
                  t,
                  "H:i:S"
                );
              };
            };
            Object.defineProperty(w.config, "minTime", {
              get: function () {
                return w.config._minTime;
              },
              set: s("min"),
            }),
              Object.defineProperty(w.config, "maxTime", {
                get: function () {
                  return w.config._maxTime;
                },
                set: s("max"),
              }),
              "time" === i.mode &&
                ((w.config.noCalendar = !0), (w.config.enableTime = !0));
            Object.assign(w.config, o, i);
            for (var u = 0; u < t.length; u++)
              w.config[t[u]] =
                !0 === w.config[t[u]] || "true" === w.config[t[u]];
            n
              .filter(function (e) {
                return void 0 !== w.config[e];
              })
              .forEach(function (e) {
                w.config[e] = c(w.config[e] || []).map(E);
              }),
              (w.isMobile =
                !w.config.disableMobile &&
                !w.config.inline &&
                "single" === w.config.mode &&
                !w.config.disable.length &&
                !w.config.enable &&
                !w.config.weekNumbers &&
                /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
                  navigator.userAgent
                ));
            for (u = 0; u < w.config.plugins.length; u++) {
              var f = w.config.plugins[u](w) || {};
              for (var m in f)
                n.indexOf(m) > -1
                  ? (w.config[m] = c(f[m]).map(E).concat(w.config[m]))
                  : void 0 === i[m] && (w.config[m] = f[m]);
            }
            i.altInputClass ||
              (w.config.altInputClass =
                re().className + " " + w.config.altInputClass);
            pe("onParseConfig");
          })(),
          le(),
          (function () {
            if (((w.input = re()), !w.input))
              return void w.config.errorHandler(
                new Error("Invalid input element specified")
              );
            (w.input._type = w.input.type),
              (w.input.type = "text"),
              w.input.classList.add("flatpickr-input"),
              (w._input = w.input),
              w.config.altInput &&
                ((w.altInput = s(w.input.nodeName, w.config.altInputClass)),
                (w._input = w.altInput),
                (w.altInput.placeholder = w.input.placeholder),
                (w.altInput.disabled = w.input.disabled),
                (w.altInput.required = w.input.required),
                (w.altInput.tabIndex = w.input.tabIndex),
                (w.altInput.type = "text"),
                w.input.setAttribute("type", "hidden"),
                !w.config.static &&
                  w.input.parentNode &&
                  w.input.parentNode.insertBefore(
                    w.altInput,
                    w.input.nextSibling
                  ));
            w.config.allowInput ||
              w._input.setAttribute("readonly", "readonly");
            w._positionElement = w.config.positionElement || w._input;
          })(),
          (function () {
            (w.selectedDates = []),
              (w.now = w.parseDate(w.config.now) || new Date());
            var e =
              w.config.defaultDate ||
              (("INPUT" !== w.input.nodeName &&
                "TEXTAREA" !== w.input.nodeName) ||
              !w.input.placeholder ||
              w.input.value !== w.input.placeholder
                ? w.input.value
                : null);
            e && me(e, w.config.dateFormat);
            (w._initialDate =
              w.selectedDates.length > 0
                ? w.selectedDates[0]
                : w.config.minDate &&
                  w.config.minDate.getTime() > w.now.getTime()
                ? w.config.minDate
                : w.config.maxDate &&
                  w.config.maxDate.getTime() < w.now.getTime()
                ? w.config.maxDate
                : w.now),
              (w.currentYear = w._initialDate.getFullYear()),
              (w.currentMonth = w._initialDate.getMonth()),
              w.selectedDates.length > 0 &&
                (w.latestSelectedDateObj = w.selectedDates[0]);
            void 0 !== w.config.minTime &&
              (w.config.minTime = w.parseDate(w.config.minTime, "H:i"));
            void 0 !== w.config.maxTime &&
              (w.config.maxTime = w.parseDate(w.config.maxTime, "H:i"));
            (w.minDateHasTime =
              !!w.config.minDate &&
              (w.config.minDate.getHours() > 0 ||
                w.config.minDate.getMinutes() > 0 ||
                w.config.minDate.getSeconds() > 0)),
              (w.maxDateHasTime =
                !!w.config.maxDate &&
                (w.config.maxDate.getHours() > 0 ||
                  w.config.maxDate.getMinutes() > 0 ||
                  w.config.maxDate.getSeconds() > 0));
          })(),
          (w.utils = {
            getDaysInMonth: function (e, t) {
              return (
                void 0 === e && (e = w.currentMonth),
                void 0 === t && (t = w.currentYear),
                1 === e && ((t % 4 == 0 && t % 100 != 0) || t % 400 == 0)
                  ? 29
                  : w.l10n.daysInMonth[e]
              );
            },
          }),
          w.isMobile ||
            (function () {
              var e = window.document.createDocumentFragment();
              if (
                ((w.calendarContainer = s("div", "flatpickr-calendar")),
                (w.calendarContainer.tabIndex = -1),
                !w.config.noCalendar)
              ) {
                if (
                  (e.appendChild(
                    ((w.monthNav = s("div", "flatpickr-months")),
                    (w.yearElements = []),
                    (w.monthElements = []),
                    (w.prevMonthNav = s("span", "flatpickr-prev-month")),
                    (w.prevMonthNav.innerHTML = w.config.prevArrow),
                    (w.nextMonthNav = s("span", "flatpickr-next-month")),
                    (w.nextMonthNav.innerHTML = w.config.nextArrow),
                    q(),
                    Object.defineProperty(w, "_hidePrevMonthArrow", {
                      get: function () {
                        return w.__hidePrevMonthArrow;
                      },
                      set: function (e) {
                        w.__hidePrevMonthArrow !== e &&
                          (d(w.prevMonthNav, "flatpickr-disabled", e),
                          (w.__hidePrevMonthArrow = e));
                      },
                    }),
                    Object.defineProperty(w, "_hideNextMonthArrow", {
                      get: function () {
                        return w.__hideNextMonthArrow;
                      },
                      set: function (e) {
                        w.__hideNextMonthArrow !== e &&
                          (d(w.nextMonthNav, "flatpickr-disabled", e),
                          (w.__hideNextMonthArrow = e));
                      },
                    }),
                    (w.currentYearElement = w.yearElements[0]),
                    De(),
                    w.monthNav)
                  ),
                  (w.innerContainer = s("div", "flatpickr-innerContainer")),
                  w.config.weekNumbers)
                ) {
                  var t = (function () {
                      w.calendarContainer.classList.add("hasWeeks");
                      var e = s("div", "flatpickr-weekwrapper");
                      e.appendChild(
                        s("span", "flatpickr-weekday", w.l10n.weekAbbreviation)
                      );
                      var t = s("div", "flatpickr-weeks");
                      return (
                        e.appendChild(t), { weekWrapper: e, weekNumbers: t }
                      );
                    })(),
                    n = t.weekWrapper,
                    a = t.weekNumbers;
                  w.innerContainer.appendChild(n),
                    (w.weekNumbers = a),
                    (w.weekWrapper = n);
                }
                (w.rContainer = s("div", "flatpickr-rContainer")),
                  w.rContainer.appendChild($()),
                  w.daysContainer ||
                    ((w.daysContainer = s("div", "flatpickr-days")),
                    (w.daysContainer.tabIndex = -1)),
                  J(),
                  w.rContainer.appendChild(w.daysContainer),
                  w.innerContainer.appendChild(w.rContainer),
                  e.appendChild(w.innerContainer);
              }
              w.config.enableTime &&
                e.appendChild(
                  (function () {
                    w.calendarContainer.classList.add("hasTime"),
                      w.config.noCalendar &&
                        w.calendarContainer.classList.add("noCalendar");
                    var e = x(w.config);
                    (w.timeContainer = s("div", "flatpickr-time")),
                      (w.timeContainer.tabIndex = -1);
                    var t = s("span", "flatpickr-time-separator", ":"),
                      n = m("flatpickr-hour", {
                        "aria-label": w.l10n.hourAriaLabel,
                      });
                    w.hourElement = n.getElementsByTagName("input")[0];
                    var a = m("flatpickr-minute", {
                      "aria-label": w.l10n.minuteAriaLabel,
                    });
                    (w.minuteElement = a.getElementsByTagName("input")[0]),
                      (w.hourElement.tabIndex = w.minuteElement.tabIndex = -1),
                      (w.hourElement.value = o(
                        w.latestSelectedDateObj
                          ? w.latestSelectedDateObj.getHours()
                          : w.config.time_24hr
                          ? e.hours
                          : (function (e) {
                              switch (e % 24) {
                                case 0:
                                case 12:
                                  return 12;
                                default:
                                  return e % 12;
                              }
                            })(e.hours)
                      )),
                      (w.minuteElement.value = o(
                        w.latestSelectedDateObj
                          ? w.latestSelectedDateObj.getMinutes()
                          : e.minutes
                      )),
                      w.hourElement.setAttribute(
                        "step",
                        w.config.hourIncrement.toString()
                      ),
                      w.minuteElement.setAttribute(
                        "step",
                        w.config.minuteIncrement.toString()
                      ),
                      w.hourElement.setAttribute(
                        "min",
                        w.config.time_24hr ? "0" : "1"
                      ),
                      w.hourElement.setAttribute(
                        "max",
                        w.config.time_24hr ? "23" : "12"
                      ),
                      w.hourElement.setAttribute("maxlength", "2"),
                      w.minuteElement.setAttribute("min", "0"),
                      w.minuteElement.setAttribute("max", "59"),
                      w.minuteElement.setAttribute("maxlength", "2"),
                      w.timeContainer.appendChild(n),
                      w.timeContainer.appendChild(t),
                      w.timeContainer.appendChild(a),
                      w.config.time_24hr &&
                        w.timeContainer.classList.add("time24hr");
                    if (w.config.enableSeconds) {
                      w.timeContainer.classList.add("hasSeconds");
                      var i = m("flatpickr-second");
                      (w.secondElement = i.getElementsByTagName("input")[0]),
                        (w.secondElement.value = o(
                          w.latestSelectedDateObj
                            ? w.latestSelectedDateObj.getSeconds()
                            : e.seconds
                        )),
                        w.secondElement.setAttribute(
                          "step",
                          w.minuteElement.getAttribute("step")
                        ),
                        w.secondElement.setAttribute("min", "0"),
                        w.secondElement.setAttribute("max", "59"),
                        w.secondElement.setAttribute("maxlength", "2"),
                        w.timeContainer.appendChild(
                          s("span", "flatpickr-time-separator", ":")
                        ),
                        w.timeContainer.appendChild(i);
                    }
                    w.config.time_24hr ||
                      ((w.amPM = s(
                        "span",
                        "flatpickr-am-pm",
                        w.l10n.amPM[
                          r(
                            (w.latestSelectedDateObj
                              ? w.hourElement.value
                              : w.config.defaultHour) > 11
                          )
                        ]
                      )),
                      (w.amPM.title = w.l10n.toggleTitle),
                      (w.amPM.tabIndex = -1),
                      w.timeContainer.appendChild(w.amPM));
                    return w.timeContainer;
                  })()
                );
              d(w.calendarContainer, "rangeMode", "range" === w.config.mode),
                d(w.calendarContainer, "animate", !0 === w.config.animate),
                d(w.calendarContainer, "multiMonth", w.config.showMonths > 1),
                w.calendarContainer.appendChild(e);
              var i =
                void 0 !== w.config.appendTo &&
                void 0 !== w.config.appendTo.nodeType;
              if (
                (w.config.inline || w.config.static) &&
                (w.calendarContainer.classList.add(
                  w.config.inline ? "inline" : "static"
                ),
                w.config.inline &&
                  (!i && w.element.parentNode
                    ? w.element.parentNode.insertBefore(
                        w.calendarContainer,
                        w._input.nextSibling
                      )
                    : void 0 !== w.config.appendTo &&
                      w.config.appendTo.appendChild(w.calendarContainer)),
                w.config.static)
              ) {
                var l = s("div", "flatpickr-wrapper");
                w.element.parentNode &&
                  w.element.parentNode.insertBefore(l, w.element),
                  l.appendChild(w.element),
                  w.altInput && l.appendChild(w.altInput),
                  l.appendChild(w.calendarContainer);
              }
              w.config.static ||
                w.config.inline ||
                (void 0 !== w.config.appendTo
                  ? w.config.appendTo
                  : window.document.body
                ).appendChild(w.calendarContainer);
            })(),
          (function () {
            w.config.wrap &&
              ["open", "close", "toggle", "clear"].forEach(function (e) {
                Array.prototype.forEach.call(
                  w.element.querySelectorAll("[data-" + e + "]"),
                  function (t) {
                    return A(t, "click", w[e]);
                  }
                );
              });
            if (w.isMobile)
              return void (function () {
                var e = w.config.enableTime
                  ? w.config.noCalendar
                    ? "time"
                    : "datetime-local"
                  : "date";
                (w.mobileInput = s(
                  "input",
                  w.input.className + " flatpickr-mobile"
                )),
                  (w.mobileInput.tabIndex = 1),
                  (w.mobileInput.type = e),
                  (w.mobileInput.disabled = w.input.disabled),
                  (w.mobileInput.required = w.input.required),
                  (w.mobileInput.placeholder = w.input.placeholder),
                  (w.mobileFormatStr =
                    "datetime-local" === e
                      ? "Y-m-d\\TH:i:S"
                      : "date" === e
                      ? "Y-m-d"
                      : "H:i:S"),
                  w.selectedDates.length > 0 &&
                    (w.mobileInput.defaultValue = w.mobileInput.value =
                      w.formatDate(w.selectedDates[0], w.mobileFormatStr));
                w.config.minDate &&
                  (w.mobileInput.min = w.formatDate(w.config.minDate, "Y-m-d"));
                w.config.maxDate &&
                  (w.mobileInput.max = w.formatDate(w.config.maxDate, "Y-m-d"));
                w.input.getAttribute("step") &&
                  (w.mobileInput.step = String(w.input.getAttribute("step")));
                (w.input.type = "hidden"),
                  void 0 !== w.altInput && (w.altInput.type = "hidden");
                try {
                  w.input.parentNode &&
                    w.input.parentNode.insertBefore(
                      w.mobileInput,
                      w.input.nextSibling
                    );
                } catch (e) {}
                A(w.mobileInput, "change", function (e) {
                  w.setDate(g(e).value, !1, w.mobileFormatStr),
                    pe("onChange"),
                    pe("onClose");
                });
              })();
            var e = l(ie, 50);
            (w._debouncedChange = l(N, 300)),
              w.daysContainer &&
                !/iPhone|iPad|iPod/i.test(navigator.userAgent) &&
                A(w.daysContainer, "mouseover", function (e) {
                  "range" === w.config.mode && ae(g(e));
                });
            A(window.document.body, "keydown", ne),
              w.config.inline || w.config.static || A(window, "resize", e);
            void 0 !== window.ontouchstart
              ? A(window.document, "touchstart", Z)
              : A(window.document, "mousedown", Z);
            A(window.document, "focus", Z, { capture: !0 }),
              !0 === w.config.clickOpens &&
                (A(w._input, "focus", w.open), A(w._input, "click", w.open));
            void 0 !== w.daysContainer &&
              (A(w.monthNav, "click", Ce),
              A(w.monthNav, ["keyup", "increment"], F),
              A(w.daysContainer, "click", ue));
            if (
              void 0 !== w.timeContainer &&
              void 0 !== w.minuteElement &&
              void 0 !== w.hourElement
            ) {
              var t = function (e) {
                return g(e).select();
              };
              A(w.timeContainer, ["increment"], I),
                A(w.timeContainer, "blur", I, { capture: !0 }),
                A(w.timeContainer, "click", Y),
                A([w.hourElement, w.minuteElement], ["focus", "click"], t),
                void 0 !== w.secondElement &&
                  A(w.secondElement, "focus", function () {
                    return w.secondElement && w.secondElement.select();
                  }),
                void 0 !== w.amPM &&
                  A(w.amPM, "click", function (e) {
                    I(e), N();
                  });
            }
            w.config.allowInput && A(w._input, "blur", te);
          })(),
          (w.selectedDates.length || w.config.noCalendar) &&
            (w.config.enableTime &&
              _(w.config.noCalendar ? w.latestSelectedDateObj : void 0),
            be(!1)),
          k();
        var t = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
        !w.isMobile && t && ce(), pe("onReady");
      })(),
      w
    );
  }
  function k(e, t) {
    for (
      var n = Array.prototype.slice.call(e).filter(function (e) {
          return e instanceof HTMLElement;
        }),
        a = [],
        i = 0;
      i < n.length;
      i++
    ) {
      var o = n[i];
      try {
        if (null !== o.getAttribute("data-fp-omit")) continue;
        void 0 !== o._flatpickr &&
          (o._flatpickr.destroy(), (o._flatpickr = void 0)),
          (o._flatpickr = E(o, t || {})),
          a.push(o._flatpickr);
      } catch (e) {
        console.error(e);
      }
    }
    return 1 === a.length ? a[0] : a;
  }
  "undefined" != typeof HTMLElement &&
    "undefined" != typeof HTMLCollection &&
    "undefined" != typeof NodeList &&
    ((HTMLCollection.prototype.flatpickr = NodeList.prototype.flatpickr =
      function (e) {
        return k(this, e);
      }),
    (HTMLElement.prototype.flatpickr = function (e) {
      return k([this], e);
    }));
  var T = function (e, t) {
    return "string" == typeof e
      ? k(window.document.querySelectorAll(e), t)
      : e instanceof Node
      ? k([e], t)
      : k(e, t);
  };
  return (
    (T.defaultConfig = {}),
    (T.l10ns = { en: e({}, i), default: e({}, i) }),
    (T.localize = function (t) {
      T.l10ns.default = e(e({}, T.l10ns.default), t);
    }),
    (T.setDefaults = function (t) {
      T.defaultConfig = e(e({}, T.defaultConfig), t);
    }),
    (T.parseDate = C({})),
    (T.formatDate = b({})),
    (T.compareDates = M),
    "undefined" != typeof jQuery &&
      void 0 !== jQuery.fn &&
      (jQuery.fn.flatpickr = function (e) {
        return k(this, e);
      }),
    (Date.prototype.fp_incr = function (e) {
      return new Date(
        this.getFullYear(),
        this.getMonth(),
        this.getDate() + ("string" == typeof e ? parseInt(e, 10) : e)
      );
    }),
    "undefined" != typeof window && (window.flatpickr = T),
    T
  );
});

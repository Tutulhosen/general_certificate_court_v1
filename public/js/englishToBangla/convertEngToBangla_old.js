! function(t) {
    function r(e) { if (n[e]) return n[e].exports; var o = n[e] = { i: e, l: !1, exports: {} }; return t[e].call(o.exports, o, o.exports, r), o.l = !0, o.exports }
    var n = {};
    r.m = t, r.c = n, r.d = function(t, n, e) { r.o(t, n) || Object.defineProperty(t, n, { configurable: !1, enumerable: !0, get: e }) }, r.n = function(t) { var n = t && t.__esModule ? function() { return t.default } : function() { return t }; return r.d(n, "a", n), n }, r.o = function(t, r) { return Object.prototype.hasOwnProperty.call(t, r) }, r.p = "", r(r.s = 211)
}({
    211: function(t, r, n) { t.exports = n(212) },
    212: function(t, r) {
        languageSelector = t.exports = {
            toBangla: function(t) {
                isNaN(t) || (t = String(t));
                try {
                    var r = ["০", "১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯"],
                        n = t.split(""),
                        e = "";
                    for (i = 0; i < n.length; i++) isNaN(n[i]) ? e += n[i] : e += r[n[i]];
                    return e
                } catch (r) { return t }
                return t
            },
            toEnglish: function(t) { for (var r = "", n = 0; n < t.length; n++) "০" != t[n] && "0" != t[n] || (r += "0"), "১" != t[n] && "1" != t[n] || (r += "1"), "২" != t[n] && "2" != t[n] || (r += "2"), "৩" != t[n] && "3" != t[n] || (r += "3"), "৪" != t[n] && "4" != t[n] || (r += "4"), "৫" != t[n] && "5" != t[n] || (r += "5"), "৬" != t[n] && "6" != t[n] || (r += "6"), "৭" != t[n] && "7" != t[n] || (r += "7"), "৮" != t[n] && "8" != t[n] || (r += "8"), "৯" != t[n] && "9" != t[n] || (r += "9"), "." != t[n] && "." != t[n] || (r += "."), "-" != t[n] && "-" != t[n] || (r += "-"); return r }
        }
    }
});

! function() {
    for (var e = document.querySelectorAll(".wprankology-wrap-faq-question"), t = 0; t < e.length; t++) e[t].addEventListener("click", (function(e) {
        var t = this.nextElementSibling,
            r = this.querySelector(".wprankology-accordion-button");
        t.classList.toggle("wprankology-hide"), "true" === r.getAttribute("aria-expanded") ? r.setAttribute("aria-expanded", "false") : r.setAttribute("aria-expanded", "true")
    }))
}();
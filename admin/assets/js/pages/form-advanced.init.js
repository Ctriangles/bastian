! function(n) {
    "use strict";

    function e() {}
    e.prototype.init = function() {
        n(".select2").select2(), n(".select2-limiting").select2({
            maximumSelectionLength: 2
        }), n(".select2-search-disable").select2({
            minimumResultsForSearch: 1 / 0
        });
        var c = {};
    }, n.AdvancedForm = new e, n.AdvancedForm.Constructor = e
}(window.jQuery),
function() {
    "use strict";
    window.jQuery.AdvancedForm.init()
}(), $(function() {
    "use strict";
    var i = $(".docs-date"),
        s = $(".docs-datepicker-container"),
        l = $(".docs-datepicker-trigger"),
        r = {
            show: function(e) {
                console.log(e.type, e.namespace)
            },
            hide: function(e) {
                console.log(e.type, e.namespace)
            },
            pick: function(e) {
                console.log(e.type, e.namespace, e.view)
            }
        };
    i.on({
        "show.datepicker": function(e) {
            console.log(e.type, e.namespace)
        },
        "hide.datepicker": function(e) {
            console.log(e.type, e.namespace)
        },
        "pick.datepicker": function(e) {
            console.log(e.type, e.namespace, e.view)
        }
    }),$(".docs-actions").on("click", "button", function(e) {
        var a, t = $(this).data(),
            c = t.arguments || [];
        e.stopPropagation(), t.method && (t.source ? i.datepicker(t.method, $(t.source).val()) : (a = i.datepicker(t.method, c[0], c[1], c[2])) && t.target && $(t.target).val(a))
    })
});
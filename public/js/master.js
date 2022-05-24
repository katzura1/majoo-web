(function ($) {
    "use strict";
       
    $(document).ready(function() {
        function set_menu(url= '', url_1 = '', url_2 = '', url_3 = '') {
            if (url_1 != '') {
                url += '/' + url_1;
            }
            if (url_2 != '') {
                url += '/' + url_2;
            }
            if (url_3 != '') {
                url += '/' + url_3;
            }
            // for sidebar menu entirely but not cover treeview
            $("ul.nav-sidebar a")
                .filter(function() {
                    return this.href == url;
                })
                .addClass("active");

            // for treeview
            $("ul.nav-treeview a")
                .filter(function() {
                    return this.href == url;
                })
                .parentsUntil(".nav-sidebar > .nav-treeview")
                .addClass("menu-open")
                .prev("a")
                .addClass("active");
        }

        set_menu(url,url_segment1,url_segment2,url_segment3);

        $('.select').select2();
    })
})(jQuery); 
(function ($) {
    "use strict";

    var RIT_Admin = {
        init: function() {
            this.metabox.tab();
        },
        megamenu: {
            select_image: function() {

            }
        },
        metabox: {
            element: '#postbox-container-2 #normal-sortables',
            tab: function() {
                /*
                var tab = '<ul id="rit-admin-tab-metabox">';
                $(this.element + ' > .postbox').each(function() {
                    tab +=  '<li><a href="#'+$(this).attr('id')+'">'+$(this).find('h3.ui-sortable-handle span').text()+'</a></li>';
                });
                tab += '</ul>';
                $(this.element).prepend(tab);
                $(this.element).tabs();
                */
            }
        }



    };

    $(document).ready(function() {
        RIT_Admin.init();
    });
})(jQuery);
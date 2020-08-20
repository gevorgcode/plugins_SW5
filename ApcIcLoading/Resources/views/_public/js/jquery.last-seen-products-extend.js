;(function($) {
    'use strict';

    /**
     * Adds ic effect to last seen products
     */
    $.subscribe('plugin/swLastSeenProducts/onCreateProductImage', function (event, plugin, element, data) {
        var $img = element.find('img');

        $img.attr({
            'class': 'ic',
            'src': 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==',
            'data-srcset': $img.attr('srcset')
        });
        $img.removeAttr('srcset');

        $.publish('plugin/apcIcLoading/onCreateProductImage', [event, plugin, element, data, $img]);
    });
})(jQuery);

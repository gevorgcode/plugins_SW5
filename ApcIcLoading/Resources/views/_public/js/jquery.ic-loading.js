;(function($, window) {
    'use strict';

    window.icSizesConfig = window.icSizesConfig || {};

    // custom ic loading config
    window.icSizesConfig.init = window.apcIcLoadingInstantLoad;
    window.icSizesConfig.expand = 50;
    window.icSizesConfig.loadMode = 1;
    window.icSizesConfig.icClass = 'ic';
    window.icSizesConfig.preloadAfterLoad = window.apcIcLoadingPreloadAfterLoad;

    /**
     * If plugin starts the download
     */
    document.addEventListener('icbeforeunveil', function (e) {
        var $element = $(e.target);

        $.publish('plugin/apcIcLoading/onIcBeforeLoad', [ $element, e ]);
    });

    /**
     * If image could not be loaded
     */
    document.addEventListener('error', function(e) {
        var $element = $(e.target);

        $.publish('plugin/apcIcLoading/onIcError', [ $element ]);
    }, true);

    /**
     * If image was successfully loaded
     */
    document.addEventListener('icloaded', function (e) {
        var $element = $(e.target),
            effect = window.apcIcLoadingEffect || 'show',
            effectTime = window.apcIcLoadingEffectTime || 0;

        $.publish('plugin/apcIcLoading/onIcAfterLoad', [ $element ]);

        if (effect !== 'fadeIn') {
            effectTime = 0;
        }

        $element.css('opacity', 0).animate({
            'opacity': 1
        }, effectTime);
    });

    $(function() {
        if (window.apcIcLoadingInstantLoad === false) {
            window.icSizes.init();
        }
    });
})(jQuery, window);

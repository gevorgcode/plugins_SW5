;(function($, window, document) {

    var bannerRemoveEvent = {

       removeButton: ".black--week21-close",
       contentForRemove: ".black--week21-banner",
       menuSelector: ".sidebar-main.off-canvas.is--active .navigation--smartphone",
       accountSelector: ".account--dropdown-navigation.off-canvas.is--active .navigation--smartphone",

        init: function(){
            var me = this;
            me.bannerRemove();            
        },

        bannerRemove: function(){
            var me = this;
            $(me.removeButton).click(function(){
               $(me.contentForRemove).remove();
               me.removeMargin();
            });
        },

        removeMargin: function(){            
            var me = this;
            $(me.menuSelector).css('margin-top',0);           
            $(me.accountSelector).css('margin-top',0);           
        },
    };

    $(document).ready(function() {
        bannerRemoveEvent.init();
    });

})(jQuery, window, document);

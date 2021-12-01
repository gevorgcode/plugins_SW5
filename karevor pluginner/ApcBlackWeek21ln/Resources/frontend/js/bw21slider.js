;(function($, window, document) {

    var bw21SliderBackground = {

       backgroundSelector: ".lic--indextop-banner",
       backgroundSelectorAdditionalClass: "lic--indextop-banner-bw21",
       bw21DotSelector: ".lic--indextop-banner .image-slider--dots .dot--link:nth-child(1)",


        init: function(){
            var me = this;
            me.addSliderClass();  
            me.registerEvents();  
        },

        addSliderClass: function(){
            var me = this;
            $(me.backgroundSelector).addClass(me.backgroundSelectorAdditionalClass);
        },   

        removeSliderClass: function(){
            var me = this;
            $(me.backgroundSelector).removeClass(me.backgroundSelectorAdditionalClass);
        },   
        
        registerEvents: function(){
            var me = this;
            $.subscribe('plugin/swImageSlider/onSlide', function() {
                if ($(me.bw21DotSelector).hasClass('is--active')){
                    if (!$(me.backgroundSelector).hasClass(me.backgroundSelectorAdditionalClass)){
                        me.addSliderClass();
                    }
                }else{
                    me.removeSliderClass();
                }
            });
        },
    };

    $(document).ready(function() {
        if (StateManager.isCurrentState(['l', 'xl']) && $.now() < 1638313199000){
            bw21SliderBackground.init();
        }        
    });

})(jQuery, window, document);
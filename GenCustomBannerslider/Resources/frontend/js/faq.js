;(function($, window, document) {

    var homepageTextCollapse= {

        collapseTitel: ".emotion--text-collapse-titel",
        collapseContent: ".emotion--text-collapse-content",

        init: function(){
            var me = this;
            me.homepageTextTriger();
            me.emotionHomepageTextTrigerStart();
        },

        homepageTextTriger: function(){
            var me = this;
            $(me.collapseTitel).click(function(){
                if($(this).parent().hasClass("is---active")){
                    return;
                }else{
                    $(me.collapseContent).fadeOut(500);
                    $(this).siblings(me.collapseContent).fadeIn(500);
                    $(me.collapseTitel).parent().removeClass("is---active");
                    $(this).parent().addClass("is---active");                    
                }
                
            });
            
        },
        emotionHomepageTextTrigerStart: function(){
            var me = this;
            $.subscribe('plugin/swEmotionLoader/onLoadEmotionFinished',function(e,plugin){
                me.homepageTextTriger();
            });
        },
    };
    $(document).ready(function() {
        homepageTextCollapse.init();
    });

})(jQuery, window, document);
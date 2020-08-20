;(function ($,window,document) {

    var listingLayoutChange = {

        listStyle: '.apc-produc-listing-list',
        listing: '.listing',
        containerSelector: '.apc-panel-viewmode',

        init: function() {
            var me = this;
            
            me.subscribeEvents();
            me.registerEvents();        
        },

        registerEvents: function() {
            var me  = this;
            
            $(me.listStyle).click(function(e) {
                e.preventDefault();

                if($(this).hasClass('is--active')){
                    return;
                }
                
                $(me.listStyle).removeClass('is--active');
                $(this).addClass('is--active');
                
                var style = $(this).data('type'),
                    url = $(this).data('ctrl-path'),
                    callback = 'listingCallback';
                
                var data = {
                    sPage: 1,
                    style: style
                }
                
                if(!$('body').hasClass('is--ctl-search')) {                   
                    data.sCategory = $(me.listing).data('categoryid');
                }
                
                $.loadingIndicator.open();
                
                window.currentListingStyle = style;
                
                me.sendAjax(url,data,callback);
                
                
            });
            
        },
        
        subscribeEvents: function() {
            var me = this;
            
            $.subscribe('plugin/swInfiniteScrolling/onBeforeFetchNewPage', function(e,plugin){
                if(window.currentListingStyle) {
                    plugin.params.productBoxLayout = window.currentListingStyle;
                }
            });
        },
        
        listingCallback: function(response) {
            var me = this;
            $(me.listing).html(response.listing);
            $.loadingIndicator.close();
            $('*[data-infinite-scrolling="true"]').data('plugin_swInfiniteScrolling').init();
        },
        
        sendAjax: function(url,data,callback){
            var me = this;
            
            $.ajax({
                type: 'POST',
                data: data,
                url: url,
                success: function(response) {
                    me[callback](response);
                }
           });
       },

    };

    $(document).ready(function(){
        if(!$(listingLayoutChange.containerSelector).length) {
            return;
        }
        
        listingLayoutChange.init();
    });

})($,window,document);
